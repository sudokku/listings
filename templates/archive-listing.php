<?php
/**
 * The template for displaying listing archives
 */

get_header();

// Get current page number
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

// Setup the query
$args = array(
    'post_type' => 'listing',
    'posts_per_page' => 9, // Number of listings per page
    'paged' => $paged,
    'orderby' => 'date',
    'order' => 'DESC'
);

// Add taxonomy filters if they exist
if (is_tax('property_type')) {
    $args['tax_query'] = array(
        array(
            'taxonomy' => 'property_type',
            'field' => 'slug',
            'terms' => get_queried_object()->slug
        )
    );
}

if (is_tax('listing_type')) {
    $args['tax_query'] = array(
        array(
            'taxonomy' => 'listing_type',
            'field' => 'slug',
            'terms' => get_queried_object()->slug
        )
    );
}

$listings_query = new WP_Query($args);
?>

<div class="listings-archive">
    <div class="listings-archive__header">
        <div class="container">
            <?php
            // Display breadcrumbs
            echo Listings_Helpers::get_breadcrumbs();
            ?>

            <h1 class="listings-archive__title">
                <?php
                if (is_tax()) {
                    single_term_title();
                } else {
                    echo __('All Listings', 'listings');
                }
                ?>
            </h1>
        </div>
    </div>

    <div class="listings-archive__content">
        <div class="container">
            <?php if ($listings_query->have_posts()): ?>
                <div class="listings-grid">
                    <?php
                    while ($listings_query->have_posts()):
                        $listings_query->the_post();
                        $args = array('show_excerpt' => false);
                        Listings_Template_Loader::get_template('partials/listing-card.php', $args);
                    endwhile;
                    ?>
                </div>

                <?php
                // Pagination
                $big = 999999999;
                echo '<div class="listings-pagination">';
                echo paginate_links(array(
                    'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                    'format' => '?paged=%#%',
                    'current' => max(1, $paged),
                    'total' => $listings_query->max_num_pages,
                    'prev_text' => '&laquo; ' . __('Previous', 'listings'),
                    'next_text' => __('Next', 'listings') . ' &raquo;'
                ));
                echo '</div>';
                ?>

            <?php else: ?>
                <p><?php _e('No listings found.', 'listings'); ?></p>
            <?php endif; ?>

            <?php wp_reset_postdata(); ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>
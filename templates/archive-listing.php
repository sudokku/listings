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
                    <?php while ($listings_query->have_posts()):
                        $listings_query->the_post(); ?>
                        <article id="listing-<?php the_ID(); ?>" <?php post_class('listing-card'); ?>>
                            <?php if (has_post_thumbnail()): ?>
                                <div class="listing-card__image">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('medium'); ?>
                                    </a>
                                </div>
                            <?php endif; ?>

                            <div class="listing-card__content">
                                <h2 class="listing-card__title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h2>

                                <?php
                                // Get listing meta
                                $price = get_post_meta(get_the_ID(), '_listing_price', true);
                                $area = get_post_meta(get_the_ID(), '_listing_area', true);
                                $area_unit = get_post_meta(get_the_ID(), '_listing_area_unit', true) ?: 'sqft';
                                $bedrooms = get_post_meta(get_the_ID(), '_listing_bedrooms', true);
                                $bathrooms = get_post_meta(get_the_ID(), '_listing_bathrooms', true);
                                ?>

                                <?php if ($price): ?>
                                    <div class="listing-card__price">
                                        <?php echo esc_html($price); ?>
                                    </div>
                                <?php endif; ?>

                                <div class="listing-card__details">
                                    <?php if ($area): ?>
                                        <span class="listing-card__area">
                                            <i class="fas fa-ruler-combined"></i>
                                            <?php echo esc_html($area . ' ' . $area_unit); ?>
                                        </span>
                                    <?php endif; ?>

                                    <?php if ($bedrooms): ?>
                                        <span class="listing-card__bedrooms">
                                            <i class="fas fa-bed"></i>
                                            <?php echo esc_html($bedrooms); ?>
                                        </span>
                                    <?php endif; ?>

                                    <?php if ($bathrooms): ?>
                                        <span class="listing-card__bathrooms">
                                            <i class="fas fa-bath"></i>
                                            <?php echo esc_html($bathrooms); ?>
                                        </span>
                                    <?php endif; ?>
                                </div>

                                <div class="listing-card__excerpt">
                                    <?php the_excerpt(); ?>
                                </div>

                                <a href="<?php the_permalink(); ?>" class="listing-card__link">
                                    <?php _e('View Details', 'listings'); ?>
                                </a>
                            </div>
                        </article>
                    <?php endwhile; ?>
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
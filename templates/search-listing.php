<?php
/**
 * The template for displaying search results for listings
 *
 * @package Listings
 */

get_header();
?>

<div class="listings-search-results">
    <div class="container">
        <?php
        // Breadcrumbs
        echo Listings_Helpers::get_breadcrumbs();
        ?>

        <div class="search-results-header">
            <h1 class="search-results-title">
                <?php
                if (have_posts()) {
                    printf(
                        esc_html(_n(
                            '%d listing found for "%s"',
                            '%d listings found for "%s"',
                            $wp_query->found_posts,
                            'listings'
                        )),
                        $wp_query->found_posts,
                        '<span class="search-query">' . get_search_query() . '</span>'
                    );
                } else {
                    printf(
                        esc_html__('No listings found for "%s"', 'listings'),
                        '<span class="search-query">' . get_search_query() . '</span>'
                    );
                }
                ?>
            </h1>

            <?php
            // Include search form
            get_template_part('templates/partials/search-form');
            ?>
        </div>

        <?php if (have_posts()): ?>
            <div class="search-results-content">
                <div class="listings-grid">
                    <?php
                    while (have_posts()):
                        the_post();
                        get_template_part('templates/partials/listing-card');
                    endwhile;
                    ?>
                </div>

                <?php
                // Pagination
                the_posts_pagination(array(
                    'mid_size' => 2,
                    'prev_text' => __('Previous', 'listings'),
                    'next_text' => __('Next', 'listings'),
                ));
                ?>
            </div>
        <?php else: ?>
            <div class="no-results">
                <div class="no-results-content">
                    <h2><?php esc_html_e('No listings found', 'listings'); ?></h2>
                    <p><?php esc_html_e('Try adjusting your search criteria or browse all listings.', 'listings'); ?></p>
                    <a href="<?php echo esc_url(get_post_type_archive_link('listing')); ?>" class="button">
                        <?php esc_html_e('Browse All Listings', 'listings'); ?>
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
get_footer();
?>
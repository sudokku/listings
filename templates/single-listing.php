<?php
/**
 * The template for displaying a single listing
 */

get_header();

if (have_posts()):
    while (have_posts()):
        the_post();
        ?>
        <div class="single-listing">
            <div class="container">
                <?php
                // Breadcrumbs
                echo Listings_Helpers::get_breadcrumbs();
                ?>

                <div class="single-listing__main">
                    <?php
                    // Listing card (full details)
                    $args = array(
                        'show_excerpt' => true,
                        'show_location' => true,
                        'show_meta' => true,
                    );
                    Listings_Template_Loader::get_template('partials/listing-card.php', $args);
                    ?>
                </div>

                <div class="single-listing__content">
                    <?php
                    // Main content (description, etc.)
                    the_content();
                    ?>
                </div>

                <div class="single-listing__meta">
                    <?php
                    // Example: Show additional meta fields or features here
                    // You can expand this section as needed
                    ?>
                </div>
            </div>
        </div>
        <?php
    endwhile;
endif;

get_footer();
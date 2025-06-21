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

                <div class="single-listing__head">
                    <div class="single-listing__head-row">
                        <div class="single-listing__head-col single-listing__head-col--left">
                            <?php
                            // Listing Type (taxonomy)
                            $listing_types = get_the_terms(get_the_ID(), 'listing_type');
                            $address = get_post_meta(get_the_ID(), '_listing_address', true);
                            $city = get_post_meta(get_the_ID(), '_listing_city', true);
                            $state = get_post_meta(get_the_ID(), '_listing_state', true);
                            $country = get_post_meta(get_the_ID(), '_listing_country', true);

                            $location = '';
                            $parts = array();

                            if (!empty($address)) {
                                $parts[] = esc_html($address);
                            }
                            if (!empty($city)) {
                                $parts[] = esc_html($city);
                            }
                            if (!empty($state)) {
                                $parts[] = esc_html($state);
                            }

                            if (!empty($parts)) {
                                $location = implode(', ', $parts);
                            }

                            if (!empty($country)) {
                                if (!empty($location)) {
                                    $location .= ' | ';
                                }
                                $location .= esc_html($country);
                            }
                            ?>
                            <?php if ($listing_types && !is_wp_error($listing_types)): ?>
                                <div class="single-listing__type">
                                    <?php foreach ($listing_types as $type): ?>
                                        <span class="listing-type"><?php echo esc_html($type->name); ?></span>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>

                            <h1 class="single-listing__title"><?php the_title(); ?></h1>

                            <?php if (!empty($location)): ?>
                                <div class="single-listing__location"><?php echo esc_html($location); ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="single-listing__head-col single-listing__head-col--right">
                            <?php
                            $price = get_post_meta(get_the_ID(), '_listing_price', true);
                            $sale_price = get_post_meta(get_the_ID(), '_listing_sale_price', true);
                            ?>
                            <?php if (!empty($sale_price) && $sale_price !== $price): ?>
                                <div class="single-listing__price">
                                    <span
                                        class="listing-price listing-price--old"><?php echo esc_html(wp_strip_all_tags($price)); ?></span>
                                    <span
                                        class="listing-price listing-price--sale"><?php echo esc_html(wp_strip_all_tags($sale_price)); ?></span>
                                </div>
                            <?php elseif (!empty($price)): ?>
                                <div class="single-listing__price">
                                    <span class="listing-price"><?php echo esc_html(wp_strip_all_tags($price)); ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="single-listing__head-row">
                        Future Gallery block here
                    </div>
                    <div class="single-listing__head-row">
                        <?php
                        $listing_info_block = '<!-- wp:listings/listing-info {"listingId":"' . get_the_ID() . '", "showRooms": true, "showBedrooms": true, "showBathrooms": true, "showGarageCapacity": true, "showArea": true, "showYearBuilt": true} /-->';
                        $parsed_blocks = parse_blocks($listing_info_block);
                        if ($parsed_blocks) {
                            foreach ($parsed_blocks as $block) {
                                echo render_block($block);
                            }
                        }
                        ?>
                    </div>
                </div>

                <div class="single-listing__body">
                    <div class="single-listing__content">
                        <?php
                        // Main content (description, etc.)
                        the_content();
                        ?>
                    </div>
                    <div class="single-listing__sidebar">

                    </div>
                </div>


                <div class="single-listing__meta">
                    <?php
                    // Example: Show additional meta fields or features here
                    // You can expand this section as needed
                    ?>
                </div>

                <div class="single-listing__comments">
                    <?php
                    // Display comments if open or there are comments
                    if (comments_open() || get_comments_number()):
                        comments_template();
                    endif;
                    ?>
                </div>
            </div>
        </div>
        <?php
    endwhile;
endif;

get_footer();
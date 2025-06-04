(function ($) {
    'use strict';

    $(document).ready(function () {
        // Admin JavaScript functionality will go here
        console.log('Listings admin script loaded');

        // Handle garage capacity field visibility
        $('#listing_has_garage').on('change', function () {
            $('.garage-capacity').toggle(this.checked);
        });

        // Handle features list
        $('.add-feature').on('click', function () {
            var featureHtml = '<p class="feature-item">' +
                '<input type="text" name="listing_features[]" value="" class="widefat">' +
                '<button type="button" class="button remove-feature">' + listings_admin.remove_text + '</button>' +
                '</p>';
            $('#listing-features-container').append(featureHtml);
        });

        // Remove feature
        $(document).on('click', '.remove-feature', function () {
            $(this).parent().remove();
        });
    });

})(jQuery); 
import { registerBlockType } from '@wordpress/blocks';
import { useSelect } from '@wordpress/data';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { __ } from '@wordpress/i18n';
import { Spinner, PanelBody, SelectControl, ToggleControl } from '@wordpress/components';
import metadata from './block.json';

registerBlockType(metadata.name, {
    edit: function Edit({ attributes, setAttributes }) {
        const blockProps = useBlockProps();
        const { listingId, showTitle, showPrice, showImage, showExcerpt, showRooms, showArea } = attributes;

        // Fetch all listings for the dropdown
        const listings = useSelect((select) => {
            return select('core').getEntityRecords('postType', 'listing', {
                per_page: -1,
                _embed: true
            });
        }, []);

        // Fetch selected listing with meta fields
        const listing = useSelect((select) => {
            if (!listingId) return null;
            return select('core').getEntityRecord('postType', 'listing', listingId, {
                _embed: true,
                _fields: [
                    'id',
                    'title',
                    'excerpt',
                    'meta',
                    '_embedded'
                ]
            });
        }, [listingId]);

        if (!listingId) {
            return (
                <div {...blockProps}>
                    <div className="components-placeholder">
                        <div className="components-placeholder__label">
                            {__('Listing Info', 'listings')}
                        </div>
                        <div className="components-placeholder__instructions">
                            {__('Please select a listing to display its information.', 'listings')}
                        </div>
                        <SelectControl
                            label={__('Select a listing', 'listings')}
                            value={listingId}
                            options={[
                                { label: __('Select a listing', 'listings'), value: 0 },
                                ...(listings || []).map(listing => ({
                                    label: listing.title.rendered,
                                    value: listing.id
                                }))
                            ]}
                            onChange={(value) => setAttributes({ listingId: parseInt(value) })}
                        />
                    </div>
                </div>
            );
        }

        if (!listing) {
            return (
                <div {...blockProps}>
                    <Spinner />
                </div>
            );
        }

        // Safely access meta fields with fallbacks
        console.log(listing);
        const meta = listing.meta || {};
        const {
            _listing_price = '',
            _listing_sale_price = '',
            _listing_rooms = '',
            _listing_area = ''
        } = meta;

        return (
            <>
                <InspectorControls>
                    <PanelBody title={__('Listing Settings', 'listings')}>
                        <SelectControl
                            label={__('Select a listing', 'listings')}
                            value={listingId}
                            options={[
                                { label: __('Select a listing', 'listings'), value: 0 },
                                ...(listings || []).map(listing => ({
                                    label: listing.title.rendered,
                                    value: listing.id
                                }))
                            ]}
                            onChange={(value) => setAttributes({ listingId: parseInt(value) })}
                        />
                        <ToggleControl
                            label={__('Show Title', 'listings')}
                            checked={showTitle}
                            onChange={() => setAttributes({ showTitle: !showTitle })}
                        />
                        <ToggleControl
                            label={__('Show Price', 'listings')}
                            checked={showPrice}
                            onChange={() => setAttributes({ showPrice: !showPrice })}
                        />
                        <ToggleControl
                            label={__('Show Image', 'listings')}
                            checked={showImage}
                            onChange={() => setAttributes({ showImage: !showImage })}
                        />
                        <ToggleControl
                            label={__('Show Excerpt', 'listings')}
                            checked={showExcerpt}
                            onChange={() => setAttributes({ showExcerpt: !showExcerpt })}
                        />
                        <ToggleControl
                            label={__('Show Rooms', 'listings')}
                            checked={showRooms}
                            onChange={() => setAttributes({ showRooms: !showRooms })}
                        />
                        <ToggleControl
                            label={__('Show Area', 'listings')}
                            checked={showArea}
                            onChange={() => setAttributes({ showArea: !showArea })}
                        />
                    </PanelBody>
                </InspectorControls>

                <div {...blockProps}>
                    <div className="listing-info-block">
                        {showImage && listing._embedded?.['wp:featuredmedia']?.[0] && (
                            <div className="listing-image">
                                <img
                                    src={listing._embedded['wp:featuredmedia'][0].source_url}
                                    alt={listing.title.rendered}
                                />
                            </div>
                        )}

                        {showTitle && (
                            <h2 className="listing-title">{listing.title.rendered}</h2>
                        )}

                        {showPrice && (
                            <div className="listing-price">
                                {_listing_sale_price ? (
                                    <>
                                        <span className="sale-price">
                                            {__('Sale Price:', 'listings')} ${_listing_sale_price}
                                        </span>
                                        <span className="original-price">
                                            {__('Original Price:', 'listings')} ${_listing_price}
                                        </span>
                                    </>
                                ) : (
                                    <span className="regular-price">
                                        {__('Price:', 'listings')} ${_listing_price}
                                    </span>
                                )}
                            </div>
                        )}

                        {showExcerpt && (
                            <div className="listing-excerpt">
                                {listing.excerpt.rendered}
                            </div>
                        )}

                        <div className="listing-details">
                            {showRooms && _listing_rooms && (
                                <div className="listing-rooms">
                                    <strong>{__('Rooms:', 'listings')}</strong>
                                    {_listing_rooms}
                                </div>
                            )}
                            {showArea && _listing_area && (
                                <div className="listing-area">
                                    <strong>{__('Area:', 'listings')}</strong>
                                    {_listing_area} m²
                                </div>
                            )}
                        </div>
                    </div>
                </div>
            </>
        );
    },

    save: function Save() {
        return null; // Dynamic block, render handled by PHP
    }
}); 
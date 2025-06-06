import { registerBlockType } from '@wordpress/blocks';
import { useSelect } from '@wordpress/data';
import { useBlockProps } from '@wordpress/block-editor';
import { __ } from '@wordpress/i18n';
import { Spinner } from '@wordpress/components';
import metadata from './block.json';

registerBlockType(metadata.name, {
    edit: function Edit({ attributes, setAttributes }) {
        const blockProps = useBlockProps();
        const { listingId } = attributes;

        const listing = useSelect((select) => {
            if (!listingId) return null;
            return select('core').getEntityRecord('postType', 'listing', listingId);
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

        const {
            title,
            meta: {
                _listing_price,
                _listing_sale_price,
                _listing_rooms,
                _listing_area
            }
        } = listing;

        return (
            <div {...blockProps}>
                <div className="listing-info-block">
                    <h2 className="listing-title">{title.rendered}</h2>

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

                    <div className="listing-details">
                        <div className="listing-rooms">
                            <strong>{__('Rooms:', 'listings')}</strong>
                            {_listing_rooms}
                        </div>
                        <div className="listing-area">
                            <strong>{__('Area:', 'listings')}</strong>
                            {_listing_area} m²
                        </div>
                    </div>
                </div>
            </div>
        );
    },

    save: function Save() {
        return null; // Dynamic block, render handled by PHP
    }
}); 
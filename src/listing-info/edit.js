/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, SelectControl, ToggleControl } from '@wordpress/components';
import { useSelect } from '@wordpress/data';
import { store as coreStore } from '@wordpress/core-data';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @param {Object} props               Block props.
 * @param {Object} props.attributes    Block attributes.
 * @param {Function} props.setAttributes Function to set block attributes.
 * @return {Element} Element to render.
 */
export default function Edit({ attributes, setAttributes }) {
	const {
		listingId,
		showRooms,
		showBedrooms,
		showBathrooms,
		showGarageCapacity,
		showArea,
		showYearBuilt
	} = attributes;

	// Fetch listings for the dropdown
	const listings = useSelect((select) => {
		return select(coreStore).getEntityRecords('postType', 'listing', {
			per_page: -1,
			_fields: ['id', 'title']
		});
	}, []);

	// Get the selected listing data
	const selectedListing = useSelect((select) => {
		if (!listingId) return null;
		return select(coreStore).getEntityRecord('postType', 'listing', listingId);
	}, [listingId]);

	return (
		<>
			<InspectorControls>
				<PanelBody title={__('Listing Settings', 'listing-info')}>
					<SelectControl
						label={__('Select Listing', 'listing-info')}
						value={listingId}
						options={[
							{ label: __('Select a listing...', 'listing-info'), value: '' },
							...(listings?.map(listing => ({
								label: listing.title.rendered,
								value: listing.id.toString()
							})) || [])
						]}
						onChange={(value) => setAttributes({ listingId: value })}
					/>

					<ToggleControl
						label={__('Show Rooms', 'listing-info')}
						checked={showRooms}
						onChange={(value) => setAttributes({ showRooms: value })}
					/>

					{showRooms && (
						<>
							<ToggleControl
								label={__('Show Bedrooms', 'listing-info')}
								checked={showBedrooms}
								onChange={(value) => setAttributes({ showBedrooms: value })}
							/>

							<ToggleControl
								label={__('Show Bathrooms', 'listing-info')}
								checked={showBathrooms}
								onChange={(value) => setAttributes({ showBathrooms: value })}
							/>
						</>
					)}

					<ToggleControl
						label={__('Show Garage Capacity', 'listing-info')}
						checked={showGarageCapacity}
						onChange={(value) => setAttributes({ showGarageCapacity: value })}
					/>

					<ToggleControl
						label={__('Show Area', 'listing-info')}
						checked={showArea}
						onChange={(value) => setAttributes({ showArea: value })}
					/>

					<ToggleControl
						label={__('Show Year Built', 'listing-info')}
						checked={showYearBuilt}
						onChange={(value) => setAttributes({ showYearBuilt: value })}
					/>
				</PanelBody>
			</InspectorControls>

			<div {...useBlockProps()}>
				{!listingId ? (
					<p>{__('Please select a listing from the block settings.', 'listing-info')}</p>
				) : !selectedListing ? (
					<p>{__('Loading listing data...', 'listing-info')}</p>
				) : (
					<div className="listing-info-preview">
						<h3>{selectedListing.title.rendered}</h3>
						<div className="listing-info-fields">
							{showRooms && (
								<p>{__('Total Rooms:', 'listing-info')} {selectedListing.meta?._listing_rooms || '-'}</p>
							)}
							{showRooms && showBedrooms && (
								<p>{__('Bedrooms:', 'listing-info')} {selectedListing.meta?._listing_bedrooms || '-'}</p>
							)}
							{showRooms && showBathrooms && (
								<p>{__('Bathrooms:', 'listing-info')} {selectedListing.meta?._listing_bathrooms || '-'}</p>
							)}
							{showGarageCapacity && selectedListing.meta?._listing_has_garage === '1' && (
								<p>{__('Garage Capacity:', 'listing-info')} {selectedListing.meta?._listing_garage_capacity || '-'}</p>
							)}
							{showArea && (
								<p>{__('Area:', 'listing-info')} {selectedListing.meta?._listing_area || '-'} {selectedListing.meta?._listing_area_unit || 'sqft'}</p>
							)}
							{showYearBuilt && (
								<p>{__('Year Built:', 'listing-info')} {selectedListing.meta?._listing_year_built || '-'}</p>
							)}
						</div>
					</div>
				)}
			</div>
		</>
	);
}

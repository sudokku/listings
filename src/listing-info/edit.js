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

			<div {...useBlockProps({ className: 'listing-info-grid' })}>
				{!listingId ? (
					<p>{__('Please select a listing from the block settings.', 'listing-info')}</p>
				) : !selectedListing ? (
					<p>{__('Loading listing data...', 'listing-info')}</p>
				) : (
					<>
						{showRooms && (
							<div className="listing-info-column">
								<div className="listing-info-icon">
									<i className="fas fa-building"></i>
								</div>
								<div className="listing-info-content">
									<h4>{selectedListing.meta?._listing_rooms || '-'}</h4>
									<p>{__('Total Rooms', 'listing-info')}</p>
								</div>
							</div>
						)}

						{showRooms && showBedrooms && (
							<div className="listing-info-column">
								<div className="listing-info-icon">
									<i className="fas fa-bed"></i>
								</div>
								<div className="listing-info-content">
									<h4>{selectedListing.meta?._listing_bedrooms || '-'}</h4>
									<p>{__('Bedrooms', 'listing-info')}</p>
								</div>
							</div>
						)}

						{showRooms && showBathrooms && (
							<div className="listing-info-column">
								<div className="listing-info-icon">
									<i className="fas fa-bath"></i>
								</div>
								<div className="listing-info-content">
									<h4>{selectedListing.meta?._listing_bathrooms || '-'}</h4>
									<p>{__('Bathrooms', 'listing-info')}</p>
								</div>
							</div>
						)}

						{showGarageCapacity && selectedListing.meta?._listing_has_garage === '1' && (
							<div className="listing-info-column">
								<div className="listing-info-icon">
									<i className="fas fa-car"></i>
								</div>
								<div className="listing-info-content">
									<h4>{`${selectedListing.meta?._listing_garage_capacity || '-'} ${__('cars', 'listing-info')}`}</h4>
									<p>{__('Garage', 'listing-info')}</p>
								</div>
							</div>
						)}

						{showArea && (
							<div className="listing-info-column">
								<div className="listing-info-icon">
									<i className="fas fa-ruler-combined"></i>
								</div>
								<div className="listing-info-content">
									<h4>{`${selectedListing.meta?._listing_area || '-'} ${selectedListing.meta?._listing_area_unit || 'sqft'}`}</h4>
									<p>{__('Area', 'listing-info')}</p>
								</div>
							</div>
						)}

						{showYearBuilt && (
							<div className="listing-info-column">
								<div className="listing-info-icon">
									<i className="fas fa-calendar-alt"></i>
								</div>
								<div className="listing-info-content">
									<h4>{selectedListing.meta?._listing_year_built || '-'}</h4>
									<p>{__('Year Built', 'listing-info')}</p>
								</div>
							</div>
						)}
					</>
				)}
			</div>
		</>
	);
}

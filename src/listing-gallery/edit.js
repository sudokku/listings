/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, SelectControl, Placeholder } from '@wordpress/components';
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
	const { listingId } = attributes;

	// Get all listings for the dropdown
	const listings = useSelect((select) => {
		const posts = select('core').getEntityRecords('postType', 'listing', {
			per_page: -1,
			status: 'publish'
		});

		if (!posts) return [];

		return posts.map(post => ({
			value: post.id,
			label: post.title.rendered
		}));
	}, []);

	// Get the selected listing's gallery images
	const listingImages = useSelect((select) => {
		if (!listingId) return [];

		const listing = select('core').getEntityRecord('postType', 'listing', listingId);
		if (!listing) return [];

		const galleryImagesRaw = listing.meta?._listing_gallery_images;
		let galleryImageIds = [];

		if (galleryImagesRaw) {
			if (Array.isArray(galleryImagesRaw)) {
				// Handle old array format
				galleryImageIds = galleryImagesRaw;
			} else {
				// Handle new string format
				galleryImageIds = galleryImagesRaw.split(',').filter(id => id.trim());
			}
		}

		if (galleryImageIds.length === 0) return [];

		return galleryImageIds.map(id => {
			const attachment = select('core').getMedia(parseInt(id.trim()));
			return attachment ? {
				id: attachment.id,
				url: attachment.source_url,
				alt: attachment.alt_text,
				caption: attachment.caption?.raw || '',
				thumbnail: attachment.media_details?.sizes?.thumbnail?.source_url || attachment.source_url,
				medium: attachment.media_details?.sizes?.medium?.source_url || attachment.source_url
			} : null;
		}).filter(Boolean);
	}, [listingId]);

	const onListingChange = (newListingId) => {
		setAttributes({ listingId: parseInt(newListingId) || 0 });
	};

	return (
		<>
			<InspectorControls>
				<PanelBody title={__('Gallery Settings', 'listings')}>
					<SelectControl
						label={__('Select Listing', 'listings')}
						value={listingId || ''}
						options={[
							{ value: '', label: __('Select a listing...', 'listings') },
							...listings
						]}
						onChange={onListingChange}
					/>
				</PanelBody>
			</InspectorControls>

			<div {...useBlockProps()}>
				{!listingId ? (
					<Placeholder
						icon="gallery"
						label={__('Listing Gallery', 'listings')}
						instructions={__('Select a listing to display its gallery images.', 'listings')}
					>
						<SelectControl
							value={listingId || ''}
							options={[
								{ value: '', label: __('Select a listing...', 'listings') },
								...listings
							]}
							onChange={onListingChange}
						/>
					</Placeholder>
				) : listingImages.length === 0 ? (
					<Placeholder
						icon="gallery"
						label={__('No Images Found', 'listings')}
						instructions={__('The selected listing has no gallery images. Add images to the listing in the admin panel.', 'listings')}
					/>
				) : (
					<div className="listing-gallery-grid-style">
						{listingImages.slice(0, 5).map((image, idx) => (
							<div
								key={image.id}
								className={
									'gallery-item' + (idx === 0 ? ' gallery-item--hero' : '')
								}
							>
								<img
									src={image.url}
									alt={image.alt}
									className="gallery-item__img"
								/>
							</div>
						))}
					</div>
				)}
			</div>
		</>
	);
}

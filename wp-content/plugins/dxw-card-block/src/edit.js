/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { useBlockProps, InspectorControls, InnerBlocks } from '@wordpress/block-editor';
import { PanelBody, SelectControl, SearchControl, ToggleControl } from '@wordpress/components';
import { store as dataStore, useEntityRecords } from '@wordpress/core-data';
import { useSelect, subscribe } from '@wordpress/data';
import { decodeEntities } from '@wordpress/html-entities';
import { useState } from 'react';
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
 * @return {Element} Element to render.
 */
export default function Edit({attributes, setAttributes}) {
	
	const {selectedPost, cardTypePost, acceptedPostTypes, headingLevel} = attributes;
	const [searchTerm, setSearchTerm] = useState('');
	const [updatedPostType, setUpdatedPostType] = useState(acceptedPostTypes)
	
	console.log(selectedPost)
	let posts = []
	let data = []

	useSelect(select => {
		if (typeof updatedPostType === 'string') {
		posts = []
		data = select(dataStore).getEntityRecords('postType', updatedPostType, {search: searchTerm})
		if (data) posts.push(data)
		} else {
			acceptedPostTypes.forEach(type => {
				data = select(dataStore).getEntityRecords('postType', type, {search: searchTerm})
				
				if(data) posts.push(data)
			})
		}
		},
		[searchTerm, updatedPostType, selectedPost]
	);

	const postTypeOptions = () => {
		let options = []
		acceptedPostTypes.map((type, index) => {
			const option = {
				label: type.charAt(0).toUpperCase() + type.slice(1),
				value: type,
				key: index
			}
			options.push(option)
		})
		return options.flat();
	}
	
	const selectOptions = () => {
		let options = [];
		posts?.map(postData => {
			const option = postData?.map((post, index) => (
			{
				label: `${decodeEntities( post.title.rendered )} [${post.type}]`,
				value: [post.id, post.type],
				key: post.id,
				type: acceptedPostTypes[index]
			})
			)
			options.push(option)
		})
		return options.flat();
	}

	let selectedPostImage = false;
	let selectedPostObject = {}
	
		if (selectedPost) {
			const selectedPostType = String(selectedPost).split(',')[1];
			const selectedPostId = String(selectedPost).split(',')[0];
			

			useSelect(
				(select) => {
					selectedPostObject = select(dataStore).getEntityRecord('postType', selectedPostType, parseInt(selectedPostId))
					console.log(selectedPostObject)
				}
			)
			// selectedPostObject = wp.data.select('core').getEntityRecord('postType', selectedPostType, parseInt(selectedPostId))

			const selectedPostImageID = selectedPostObject ? selectedPostObject.featured_media : '';
			// selectedPostImage = useSelect(
			// 	select => 
			// 		select(dataStore).getEntityRecord('postType', 'attachment', parseInt(selectedPostImageID), [selectedPostImageID]), []
			// )
			selectedPostImage = wp.data.select('core').getEntityRecord('postType', 'attachment', parseInt(selectedPostImageID))
		} 

	const FeaturedImage = ({image}) => {
		
		if (!image) return <div>No image to display</div>

		return (
			<img src={image.media_details.sizes.medium.source_url} alt={image.alt_text} />
		)
	}

	const HeaderMarkup = headingLevel || 'h2';

	const DynamicCardBlock = ({title, excerpt}) => {
		if (!title) return <div>No post to display</div>
		const trimmedExcerptContent = decodeEntities(excerpt.rendered.replace(/<[^>]*>?/gm, ''))
		return (
			<div>
				<HeaderMarkup>{title.rendered}</HeaderMarkup>
				<FeaturedImage image={selectedPostImage} />
				<p>{trimmedExcerptContent}</p>
			</div>
			
		)
	}

	const STATIC_CARD_TEMPLATE = [
		['core/heading', {}],
		['core/image'],
		['core/paragraph', {}]
	]

	return (
		<>
			<InspectorControls>
				<PanelBody>
					<ToggleControl
						label="Select a card type"
						help={
							cardTypePost
							? 'Post card'
							: 'Custom card'
						}
						checked={ cardTypePost }
						onChange={ newValue => setAttributes({ cardTypePost: newValue })}
					/>
					{
						cardTypePost === true 
						? <>
							<SearchControl
								label="Search for an article"
								placeholder="Search for an article"
								onChange = {setSearchTerm}
								value = {searchTerm}
							/>
							<SelectControl
								label="Filter by post type"
								value={updatedPostType}
								options={postTypeOptions()}
								onChange={selection => setUpdatedPostType(selection)}
							/>
							<SelectControl
								label="Select a post to feature in the card"
								value={selectedPost}
								options={selectOptions()}
								onChange={selection => setAttributes({ selectedPost: selection })}
							/>
							<SelectControl
								label="Heading level"
								value={headingLevel}
								options={[
									{ label: '1', value: 'h1' },
									{ label: '2', value: 'h2' },
									{ label: '3', value: 'h3' },
									{ label: '4', value: 'h4' }
								]}
								onChange={selection => setAttributes({ headingLevel: selection })}
							/>
						</>
						: ''
					}
					
				</PanelBody>
			</InspectorControls>
			<div { ...useBlockProps() }>
				{ 
					cardTypePost === true && selectedPostObject
					? <DynamicCardBlock {...selectedPostObject} />
					: <InnerBlocks
					template={STATIC_CARD_TEMPLATE}
					orientation="vertical"
					/>
				}
				
			</div>
		</>
	);
}

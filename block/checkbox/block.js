import { registerBlockType } from '@wordpress/blocks';
import { Fragment } from '@wordpress/element';
import { TextControl, ToggleControl } from '@wordpress/components';
import ServerSideRender from '@wordpress/server-side-render';
import { __ } from '@wordpress/i18n';

registerBlockType( 'snow-monkey-forms/checkbox', {
	title: __( 'Checkbox', 'snow-monkey-forms' ),
	icon: 'editor-ol',
	category: 'snow-monkey-forms',
	supports: {
		customClassName: false,
	},

	edit( { attributes, setAttributes, isSelected } ) {
		const { name, label, value, checked } = attributes;

		return !! isSelected ? (
			<Fragment>
				<TextControl
					label={ __( 'Label', 'snow-monkey-forms' ) }
					value={ label }
					onChange={ ( attribute ) =>
						setAttributes( { label: attribute } )
					}
				/>
				<TextControl
					label={ __( 'name', 'snow-monkey-forms' ) }
					value={ name }
					onChange={ ( attribute ) =>
						setAttributes( { name: attribute } )
					}
				/>
				<TextControl
					label={ __( 'value', 'snow-monkey-forms' ) }
					value={ value }
					onChange={ ( attribute ) =>
						setAttributes( { value: attribute } )
					}
				/>
				<ToggleControl
					label={ __( 'checked', 'snow-monkey-forms' ) }
					checked={ checked }
					onChange={ ( attribute ) =>
						setAttributes( { checked: attribute } )
					}
				/>
			</Fragment>
		) : (
			<ServerSideRender
				block="snow-monkey-forms/checkbox"
				attributes={ attributes }
			/>
		);
	},

	save() {
		return null;
	},
} );

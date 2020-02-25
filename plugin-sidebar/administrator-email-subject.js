import { TextControl } from '@wordpress/components';
import { useSelect, useDispatch } from '@wordpress/data';
import { __ } from '@wordpress/i18n';

export default function() {
	const meta = useSelect( ( select ) => {
		const { getEditedPostAttribute } = select( 'core/editor' );
		return getEditedPostAttribute( 'meta' ).administrator_email_subject;
	}, [] );

	const { editPost } = useDispatch( 'core/editor' );

	const currentPost = useSelect( ( select ) => {
		return select( 'core/editor' ).getCurrentPost();
	}, [] );

	return (
		<TextControl
			label={ __( 'Subject', 'snow-monkey-forms' ) }
			value={
				! currentPost.title && ! meta
					? __( 'Admin notification', 'snow-monkey-forms' )
					: meta
			}
			onChange={ ( value ) =>
				editPost( {
					meta: { administrator_email_subject: value },
				} )
			}
		/>
	);
}
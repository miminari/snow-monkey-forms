<?php
/**
 * @package snow-monkey-forms
 * @author inc2734
 * @license GPL-2.0+
 */

use Snow_Monkey\Plugin\Forms\App\Helper;

add_action(
	'init',
	function() {
		$attributes = include( __DIR__ . '/attributes.php' );

		register_block_type(
			'snow-monkey-forms/control-multi-checkbox',
			[
				'attributes'      => $attributes,
				'render_callback' => function( $attributes, $content ) {
					if ( ! isset( $attributes['name'] ) ) {
						return;
					}

					$properties = Helper::coordinate( 'multi-checkbox', $attributes );

					ob_start();
					include( __DIR__ . '/view.php' );
					return ob_get_clean();
				},
			]
		);
	}
);
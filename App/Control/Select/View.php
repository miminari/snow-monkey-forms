<?php
/**
 * @package snow-monkey-forms
 * @author inc2734
 * @license GPL-2.0+
 */

namespace Snow_Monkey\Plugin\Forms\App\Control\Select;

use Snow_Monkey\Plugin\Forms\App\Contract;
use Snow_Monkey\Plugin\Forms\App\Helper;

class View extends Contract\View {

	/**
	 * @var array
	 *   @var string name
	 *   @var boolean disabled
	 *   @var boolean data-invalid
	 */
	protected $attributes = [];

	/**
	 * @var string
	 */
	protected $description = '';

	/**
	 * @var array
	 */
	protected $validations = [];

	/**
	 * @var string
	 */
	public $value = '';

	/**
	 * @var array
	 */
	protected $options = [];

	public function input() {
		$description = $this->get( 'description' );
		if ( $description ) {
			$description = sprintf(
				'<div class="smf-control-description">%1$s</div>',
				wp_kses_post( $description )
			);
		}

		$options = [];
		foreach ( $this->options as $value => $label ) {
			$options[] = sprintf(
				'<option value="%1$s" %3$s>%2$s</option>',
				esc_attr( $value ),
				esc_html( $label ),
				selected( $value, $this->get( 'value' ), false )
			);
		}

		return sprintf(
			'<div class="smf-select-control">
				<select class="smf-select-control__control" %1$s>%2$s</select>
				<span class="smf-select-control__toggle"></span>
			</div>
			%3$s',
			$this->generate_attributes( $this->attributes ),
			implode( '', $options ),
			$description
		);
	}

	public function confirm() {
		$value = $this->get( 'value' );
		if ( ! $value ) {
			return;
		}

		return sprintf(
			'%1$s%2$s',
			esc_html( $this->options[ $value ] ),
			Helper::control(
				'hidden',
				[
					'attributes' => [
						'name'  => $this->get( 'name' ),
						'value' => $this->get( 'value' ),
					],
				]
			)->input()
		);
	}

	public function error( $error_message = '' ) {
		$this->set( 'data-invalid', true );

		return sprintf(
			'%1$s
			<div class="smf-error-messages">
				%2$s
			</div>',
			$this->input(),
			$error_message
		);
	}

	public function get( $attribute ) {
		if ( 'value' === $attribute ) {
			return $this->value;
		}

		return parent::get( $attribute );
	}

	public function set( $attribute, $value ) {
		if ( 'value' === $attribute ) {
			$this->value = $value;
			return true;
		}

		return parent::set( $attribute, $value );
	}
}
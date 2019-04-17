<?php
/**
 * @package snow-monkey-forms
 * @author inc2734
 * @license GPL-2.0+
 */

namespace Snow_Monkey\Plugin\Forms\App\Model;

use Snow_Monkey\Plugin\Forms\App\Helper;

class Csrf {

	const KEY = '_snow-monkey-forms-token';

	private static $token;

	public static function validate() {
		$cookie_token = static::saved_token();
		$posted_token = filter_input( INPUT_POST, static::KEY );
		return ! is_null( $cookie_token ) && ! is_null( $posted_token ) && hash_equals( $cookie_token, $posted_token );
	}

	public static function save_token() {
		static::$token = ! static::saved_token() ? static::generate_token() : static::saved_token();
		if ( ! static::saved_token() ) {
			setcookie( static::KEY, static::token(), 0, '/' );
		}
	}

	public static function token_control() {
		return Helper::control( 'hidden', [ 'name' => static::KEY, 'value' => static::token() ] )->input();
	}

	public static function token() {
		return static::$token;
	}

	public static function saved_token() {
		return filter_input( INPUT_COOKIE, static::KEY );
	}

	public static function generate_token() {
		if ( function_exists( 'random_bytes' ) ) {
			return bin2hex( random_bytes( 32 ) );
		}

		if ( function_exists( 'openssl_random_pseudo_bytes' ) ) {
			return bin2hex( openssl_random_pseudo_bytes( 32 ) );
		}

		return uniqid( mt_rand(), true );
	}
}

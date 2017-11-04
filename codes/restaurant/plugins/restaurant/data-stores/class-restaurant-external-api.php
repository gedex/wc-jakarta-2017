<?php
namespace Gedex\WCJKT\Restaurant\Data_Stores;

use Gedex\WCJKT\Restaurant\Data_Objects\Restaurant;

class Restaurant_External_API extends \WC_Data_Store_WP implements Restaurant_Interface {
	const POST_URL = 'https://requestb.in/ybsb75yb';
	const GET_URL = 'https://next.json-generator.com/4yFnTM8Rm';

	public function create( Restaurant &$restaurant ) {
		wp_remote_post( self::POST_URL, [
			'body' => json_encode( [
				'action'        => 'create',
				'name'          => $restaurant->get_name(),
				'address'       => $restaurant->get_address(),
				'cuisine'       => $restaurant->get_cuisine(),
				'opening_hours' => $restaurant->get_opening_hours(),
			] ),
		] );
	}

	public function read( Restaurant &$restaurant ) {
		$resp = wp_remote_get( self::GET_URL );
		if ( is_wp_error( $resp ) ) {
			throw new Exception( $resp->get_error_message() );
		}
		$resp = wp_remote_retrieve_body( $resp );
		$resp = json_decode( $resp );
		$restaurant->set_id( $resp['id'] );
		unset( $resp['id'] );

		$restaurant->set_props( $resp );
		$restaurant->set_object_read( true );
	}

	public function update( Restaurant &$restaurant ) {
	}

	public function delete( Restaurant &$restaurant ) {
	}
}

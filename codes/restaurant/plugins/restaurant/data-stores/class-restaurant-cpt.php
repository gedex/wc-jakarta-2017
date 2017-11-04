<?php
namespace Gedex\WCJKT\Restaurant\Data_Stores;

use Gedex\WCJKT\Restaurant\Data_Objects\Restaurant;

class Restaurant_CPT extends \WC_Data_Store_WP implements Restaurant_Interface {
	public function create( Restaurant &$restaurant ) {
		$id = wp_insert_post( [
			'post_type'   => 'restaurant',
			'post_status' => 'publish',
			'post_title'  => $restaurant->get_name(),
		] );

		if ( $id && ! is_wp_error( $id ) ) {
			$restaurant->set_id( $id );
			$this->update_post_meta( $restaurant );
		}
	}

	public function read( Restaurant &$restaurant ) {
		$restaurant->set_defaults();

		$post_object = $restaurant->get_id() ? get_post( $restaurant->get_id() ) : false;
		if ( ! $post_object || 'restaurant' !== $post_object->post_type ) {
			throw new \Exception( 'Invalid restaurant.' );
		}

		$props = [
			'name'          => $post_object->post_title,
			'address'       => $post_object->address,
			'cuisine'       => $post_object->cuisine,
			'opening_hours' => $post_object->opening_hours,
		];

		$restaurant->set_props( $props );
		$restaurant->set_object_read( true );
	}

	public function update( Restaurant &$restaurant ) {
		wp_update_post( [
			'ID'         => $restaurant->get_id(),
			'post_title' => $restaurant->get_name(),
		] );

		$this->update_post_meta( $restaurant );
	}

	public function delete( Restaurant &$restaurant ) {
		wp_delete_post( $restaurant->get_id() );
	}

	protected function update_post_meta( Restaurant &$restaurant ) {
		foreach ( [ 'address', 'cuisine', 'opening_hours' ] as $meta ) {
			update_post_meta( $restaurant->get_id(), '_' . $meta, $restaurant->{ "get_$meta" }( 'edit' ) );
		}
	}
}

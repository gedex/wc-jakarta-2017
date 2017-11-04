<?php
namespace Gedex\WCJKT\Restaurant\Data_Objects;

class Restaurant extends \WC_Data {
	protected $data = [
		'name'          => '',
		'address'       => '',
		'cuisine'       => '',
		'opening_hours' => '9am - 10pm',
	];

	public function __construct( $restaurant = 0 ) {
		parent::__construct( $restaurant );

		if ( is_numeric( $restaurant ) && $restaurant > 0 ) {
			$this->set_id( $restaurant );
		} elseif ( $restaurant instanceof self ) {
			$this->set_id( $restaurant->get_id() );
		} elseif ( $restaurant instanceof \WP_Post ) {
			$this->set_id( $restaurant->ID );
		} else {
			$this->set_object_read( true );
		}

		$this->data_store = \WC_Data_Store::load( 'restaurant' );

		if ( $this->get_id() > 0 ) {
			$this->data_store->read( $this );
		}
	}

	public function get_name( $context = 'view' ) {
		return $this->get_prop( 'name', $context );
	}

	public function set_name( $name ) {
		$this->set_prop( 'name', $name );
	}

	public function get_address( $context = 'view' ) {
		return $this->get_prop( 'address', $context );
	}

	public function set_address( $address ) {
		$this->set_prop( 'address', $address );
	}

	public function get_cuisine( $context = 'view' ) {
		return $this->get_prop( 'cuisine', $context );
	}

	public function set_cuisine( $cuisine ) {
		$this->set_prop( 'cuisine', $cuisine );
	}

	public function get_opening_hours( $context = 'view' ) {
		return $this->get_prop( 'opening_hours', $context );
	}

	public function set_opening_hours( $opening_hours ) {
		$this->set_prop( 'opening_hours', $opening_hours );
	}
}

<?php
/**
 * Plugin Name: Restaurant
 * Version: 1.0.0
 * Description: Restaurant demo for WC Data CRUD and Data Store.
 * Author: Akeda Bagus <akeda.bagus@automattic.com>
 */

namespace Gedex\WCJKT\Restaurant;

class Main {
	protected static $started;

	public static function start() {
		if ( self::$started ) {
			return;
		}

		self::includes();
		self::hooks();
		self::$started = true;
	}

	public static function get_path() {
		return untrailingslashit( plugin_dir_path( __FILE__ ) );
	}

	protected static function hooks() {
		add_action( 'init', [ __CLASS__, 'init_post_types' ] );
		add_filter( 'woocommerce_data_stores', [ __CLASS__, 'register_data_stores' ] );
	}

	/**
	 * Using this for the sake of demo so I could switch Data Store easily.
	 */
	protected static function get_active_data_store() {
		$active = get_option( 'restaurant_data_store', 'cpt' );
		switch ( $active ) {
			case 'external_api':
				$data_store = 'Gedex\\WCJKT\\Restaurant\\Data_Stores\\Restaurant_External_API';
				break;
			case 'custom_table':
				$data_store = 'Gedex\\WCJKT\\Restaurant\\Data_Stores\\Restaurant_Custom_Table';
				break;
			case 'cpt':
			default:
				$data_store = 'Gedex\\WCJKT\\Restaurant\\Data_Stores\\Restaurant_CPT';
		}
		return $data_store;
	}

	protected static function includes() {
		require_once( self::get_path() . '/data-stores/restaurant-interface.php' );
		require_once( self::get_path() . '/data-stores/class-restaurant-cpt.php' );
		require_once( self::get_path() . '/data-stores/class-restaurant-custom-table.php' );
		require_once( self::get_path() . '/data-stores/class-restaurant-external-api.php' );
		require_once( self::get_path() . '/data-objects/class-restaurant.php' );
	}

	public static function init_post_types() {
		register_post_type(
			'restaurant',
			[
				'label'   => __( 'Restaurant', 'restaurant' ),
				'public'  => true,
				'show_ui' => true,
			]
		);
	}

	public static function register_data_stores( array $data_stores = [] ) {
		$data_stores['restaurant'] = self::get_active_data_store();
		return $data_stores;
	}
}

add_action( 'plugins_loaded', function() {
	Main::start();
} );

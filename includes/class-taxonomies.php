<?php
/**
 * Registers taxonomies for beer check-ins.
 *
 * @package JardinBeer
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class JB_Taxonomies
 */
class JB_Taxonomies {

	public const STYLE = 'beer_style';
	public const BREWERY = 'brewery';
	public const VENUE  = 'venue';

	/**
	 * Register hooks.
	 *
	 * @return void
	 */
	public function register() {
		add_action( 'init', array( $this, 'register_taxonomies' ) );
	}

	/**
	 * Register all taxonomies.
	 *
	 * @return void
	 */
	public function register_taxonomies() {
		$this->register_beer_style();
		$this->register_brewery();
		$this->register_venue();
	}

	/**
	 * Beer style (hierarchical).
	 *
	 * @return void
	 */
	private function register_beer_style() {
		$labels = array(
			'name'          => __( 'Beer styles', 'jardin-beer' ),
			'singular_name' => __( 'Beer style', 'jardin-beer' ),
			'search_items'  => __( 'Search styles', 'jardin-beer' ),
			'all_items'     => __( 'All styles', 'jardin-beer' ),
			'edit_item'     => __( 'Edit style', 'jardin-beer' ),
			'update_item'   => __( 'Update style', 'jardin-beer' ),
			'add_new_item'  => __( 'Add new style', 'jardin-beer' ),
			'new_item_name' => __( 'New style name', 'jardin-beer' ),
			'menu_name'     => __( 'Styles', 'jardin-beer' ),
		);

		register_taxonomy(
			self::STYLE,
			JB_Post_Type::POST_TYPE,
			array(
				'labels'            => $labels,
				'hierarchical'      => true,
				'public'            => true,
				'show_ui'           => true,
				'show_in_menu'      => JB_Post_Type::ADMIN_MENU_SLUG,
				'show_admin_column' => true,
				'show_in_nav_menus' => true,
				'show_in_rest'      => true,
				'rewrite'           => array( 'slug' => 'beer-style' ),
			)
		);
	}

	/**
	 * Brewery (non-hierarchical).
	 *
	 * @return void
	 */
	private function register_brewery() {
		$labels = array(
			'name'          => __( 'Breweries', 'jardin-beer' ),
			'singular_name' => __( 'Brewery', 'jardin-beer' ),
			'search_items'  => __( 'Search breweries', 'jardin-beer' ),
			'all_items'     => __( 'All breweries', 'jardin-beer' ),
			'edit_item'     => __( 'Edit brewery', 'jardin-beer' ),
			'update_item'   => __( 'Update brewery', 'jardin-beer' ),
			'add_new_item'  => __( 'Add new brewery', 'jardin-beer' ),
			'new_item_name' => __( 'New brewery name', 'jardin-beer' ),
			'menu_name'     => __( 'Breweries', 'jardin-beer' ),
		);

		register_taxonomy(
			self::BREWERY,
			JB_Post_Type::POST_TYPE,
			array(
				'labels'            => $labels,
				'hierarchical'      => false,
				'public'            => true,
				'show_ui'           => true,
				'show_in_menu'      => JB_Post_Type::ADMIN_MENU_SLUG,
				'show_admin_column' => true,
				'show_in_nav_menus' => true,
				'show_in_rest'      => true,
				'rewrite'           => array( 'slug' => 'brewery' ),
			)
		);
	}

	/**
	 * Venue (non-hierarchical).
	 *
	 * @return void
	 */
	private function register_venue() {
		$labels = array(
			'name'          => __( 'Venues', 'jardin-beer' ),
			'singular_name' => __( 'Venue', 'jardin-beer' ),
			'search_items'  => __( 'Search venues', 'jardin-beer' ),
			'all_items'     => __( 'All venues', 'jardin-beer' ),
			'edit_item'     => __( 'Edit venue', 'jardin-beer' ),
			'update_item'   => __( 'Update venue', 'jardin-beer' ),
			'add_new_item'  => __( 'Add new venue', 'jardin-beer' ),
			'new_item_name' => __( 'New venue name', 'jardin-beer' ),
			'menu_name'     => __( 'Venues', 'jardin-beer' ),
		);

		register_taxonomy(
			self::VENUE,
			JB_Post_Type::POST_TYPE,
			array(
				'labels'            => $labels,
				'hierarchical'      => false,
				'public'            => true,
				'show_ui'           => true,
				'show_in_menu'      => JB_Post_Type::ADMIN_MENU_SLUG,
				'show_admin_column' => true,
				'show_in_nav_menus' => true,
				'show_in_rest'      => true,
				'rewrite'           => array( 'slug' => 'venue' ),
			)
		);
	}
}

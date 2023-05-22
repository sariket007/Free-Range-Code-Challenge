<?php
/**
 * Book Post Type.
 *
 * @package book-showcase-block.
 */

namespace SS\BOOKSHOWCASE;

use WP_Customize_Manager;

/**
 * Management of the Podcast  Post Type.
 */
class Book_Store_Post_Type {

	const STYLE_NAME            = 'ss-book-style';
	const POST_TYPE_SCRIPT_NAME = 'ss-book-script';
	const POST_TYPE_STYLE_NAME  = 'ss-book-post-type';
	const SCRIPT_NAME           = 'ss-book-admin-js';
	const POST_TYPE_SLUG        = 'books';
	
	const SUPPORTS              = [
		'title',
		'thumbnail',
		'editor',
		'custom-fields',
		'author',
	];
	/**
	 * Add actions.
	 */
	public function __construct() {
		add_action( 'init', [ $this, 'init' ] );
	}

    /**
	 * Initalize function.
	 *
	 * @return void
	 */
	public function init() : void {
		$this->register_book_post_type();
        $this->register_book_category_taxonomy();
	}

	/**
	 * Register the book episode post type.
	 *
	 * @return void
	 */
	private function register_book_post_type() : void {
		register_post_type(
			self::POST_TYPE_SLUG,
			[
				'labels'             => [
					'name'          => 'books',
					'singular_name' => 'book',
					'all_items'     => 'All books',
				],
				'public'             => true,
				'has_archive'        => false,
				'menu_icon'          => 'dashicons-book-alt',
				'supports'           => self::SUPPORTS,
		
				'show_in_rest'       => true,
				'publicly_queryable' => true,
				'rewrite'            => [
					'slug'       => 'book',
					'with_front' => false,
				],
				'template'           => []
			]
		);
	}

	/**
	 * Add `book_cat` taxonomy.
	 *
	 * @return void
	 */
	private function register_book_category_taxonomy(): void {
		if ( function_exists( 'create_custom_taxonomy_labels' ) ) {
			$args = [
				'labels'            => create_custom_taxonomy_labels( 'Book Categories', 'Book Category' ),
				'hierarchical'      => false,
				'public'            => true,
				'show_ui'           => true,
				'show_admin_column' => true,
				'show_in_nav_menus' => true,
				'show_tagcloud'     => false,
				'show_in_rest'      => true
			];

			register_taxonomy( 'book_cat', [ self::POST_TYPE_SLUG ], $args );
		}
	}
}
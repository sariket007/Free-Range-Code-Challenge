<?php
/**
 * Book Showcase Block helper functions.
 *
 * @package book-showcase-block.
 */

 if ( ! function_exists( 'create_custom_taxonomy_labels' ) ) {
	/**
	 * Generate custom taxonomy labels.
	 *
	 * @param string $plural plural text.
	 * @param string $singular singular text.
	 * @return array
	 */
	function create_custom_taxonomy_labels( $plural, $singular ) : array {
		return [
			// translators: Taxonomy `name`.
			'name'                       => sprintf( \__( '%s', 'book-showcase-block' ), $plural ), // phpcs:ignore WordPress.WP.I18n.NoEmptyStrings
			// translators: Taxonomy `singular_name`.
			'singular_name'              => sprintf( \__( '%s', 'book-showcase-block' ), $singular ), // phpcs:ignore WordPress.WP.I18n.NoEmptyStrings
			// translators: Taxonomy `menu_name`.
			'menu_name'                  => sprintf( \__( '%s', 'book-showcase-block' ), $plural ), // phpcs:ignore WordPress.WP.I18n.NoEmptyStrings
			// translators: Taxonomy `name_admin_bar`.
			'name_admin_bar'             => sprintf( \__( '%s', 'book-showcase-block' ), $singular ), // phpcs:ignore WordPress.WP.I18n.NoEmptyStrings
			// translators: Taxonomy `archives`.
			'archives'                   => sprintf( \__( 'All %s', 'book-showcase-block' ), $plural ),
			// translators: Taxonomy `all_items`.
			'all_items'                  => sprintf( \__( 'All %s', 'book-showcase-block' ), $plural ),
			// translators: Taxonomy `edit_item`.
			'edit_item'                  => sprintf( \__( 'Edit %s', 'book-showcase-block' ), $singular ),
			// translators: Taxonomy `view_item`.
			'view_item'                  => sprintf( \__( 'View %s', 'book-showcase-block' ), $singular ),
			// translators: Taxonomy `update_item`.
			'update_item'                => sprintf( \__( 'Update %s', 'book-showcase-block' ), $singular ),
			// translators: Taxonomy `add_new_item`.
			'add_new_item'               => sprintf( \__( 'Add New %s', 'book-showcase-block' ), $singular ),
			// translators: Taxonomy `new_item_name`.
			'new_item_name'              => sprintf( \__( 'New %s Name', 'book-showcase-block' ), $singular ),
			// translators: Taxonomy `parent_item`.
			'parent_item'                => sprintf( \__( 'Parent %s', 'book-showcase-block' ), $singular ),
			// translators: Taxonomy `parent_item_colon`.
			'parent_item_colon'          => sprintf( \__( 'Parent %s:', 'book-showcase-block' ), $singular ),
			// translators: Taxonomy `search_items`.
			'search_items'               => sprintf( \__( 'Search %s', 'book-showcase-block' ), $plural ),
			// translators: Taxonomy `separate_items_with_commas`.
			'separate_items_with_commas' => sprintf( \__( 'Separate %s with commas', 'book-showcase-block' ), $plural ),
			// translators: Taxonomy `add_or_remove_items`.
			'add_or_remove_items'        => sprintf( \__( 'Add or Remove %s', 'book-showcase-block' ), $plural ),
			// translators: Taxonomy `choose_from_most_used`.
			'choose_from_most_used'      => sprintf( \__( 'Choose from most used %s', 'book-showcase-block' ), $plural ),
			// translators: Taxonomy `not_found`.
			'not_found'                  => sprintf( \__( 'No %s Found', 'book-showcase-block' ), $plural ),
			// translators: Taxonomy `no_terms`.
			'no_terms'                   => sprintf( \__( 'No %s', 'book-showcase-block' ), $plural ),
			// translators: Taxonomy `items_list_navigation`.
			'items_list_navigation'      => sprintf( \__( '%s list navigation', 'book-showcase-block' ), $plural ),
			// translators: Taxonomy `items_list`.
			'items_list'                 => sprintf( \__( '%s list', 'book-showcase-block' ), $plural ),
			// translators: Taxonomy `most_used`.
			'most_used'                  => sprintf( \__( 'Most used $s', 'book-showcase-block' ), $plural ),
			// translators: Taxonomy `back_to_items`.
			'back_to_items'              => sprintf( \__( '&larr; Back to %s', 'book-showcase-block' ), $plural ),
		];
	}
}

add_filter('block_categories_all', 'add_book_block_category', 20, 3);
if(!function_exists('add_book_block_category')){
	/**
	 * Adding a new (custom) block category and show that category at the top.
	 *
	 * @param array $categories block category array.
	 * @param object|null $post WP_Post object/Null.
	 * @return mixed
	 */
	function add_book_block_category($categories, $post) {
		return array_merge(
			$categories,
			[
				[
					'slug'  => 'book-showcase',
					'title' => 'Book Showcase',
					'icon'  => 'book',
				]
			]
		);
	}
}



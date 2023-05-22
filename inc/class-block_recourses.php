<?php
/**
 * Book Showcase Block Resourses initialization.
 *
 * @package book-showcase-block.
 */

namespace SS\BOOKSHOWCASE;

class Block_Resources{
    const BLOCK_STYLE   = 'ss-block-admin-style';
    const BLOCK_SCRIPT  = 'ss-block-admin-script';
    const STYLE_FILE    = 'block-style.css';
    const SCRIPT_FILE   = 'block-script.js';
    const TARGET_POST_TYPE = 'books';
    
    public function __construct(){
        add_action( 'acf/init', [ $this, 'register_acffields_init' ] );
        add_action( 'enqueue_block_editor_assets', [ $this, 'block_enqueue_assets' ] );
    }

    public function register_acffields_init(){
        $this->register_acffields_cpt();
        $this->register_acffields_block();
        $this->acf_book_showcase_item_block();
    }

	/**
	 * Register Advance custom field for custom post type(books).
	 *
	*/
    public function register_acffields_cpt(){
        $cpt_args = [
			'key' => 'group_booksdtails_book_cpt',
			'title' => 'Books: Details',
			'fields' =>[
					[
						'key' 	=> 'book_details_description',
						'label' => 'Book Description',
						'name' 	=> 'book_description',
						'type' 	=> 'textarea',
					],
					[
						'key' 	=> 'book_details_author',
						'label' => 'Author',
						'name' 	=> 'book_author',
						'type' 	=> 'text',
					]
				],
			'location' =>[
				[
					[
						'param' 	=> 'post_type',
						'operator' 	=> '==',
						'value' 	=> self::TARGET_POST_TYPE,
					],
				],
			],
		];
		if( function_exists('acf_add_local_field_group') ):
			acf_add_local_field_group($cpt_args);
		endif;
    }

	/**
	 * Register Advance custom field for book showcase block.
	 *
	*/
    public function register_acffields_block(){
        $block_args = [
			'key' => 'group_book_block_attribute',
			'title' => 'Block: Books',
			'fields' =>[
					[
						'key' 	=> 'book_block_title',
						'label' => 'Bock Title',
						'name' 	=> 'block_title',
						'type' 	=> 'text',
					],
					[
						'key' 	=> 'book_block_description',
						'label' => 'Description',
						'name' 	=> 'book_description',
						'type' 	=> 'textarea',
					],
					[
						'key' => 'book_block_category',
						'label' => 'Book category',
						'name' => 'book_category',
						'type' => 'taxonomy',
						'instructions' => 'Select book category for specific category books',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => [
							'width' => '',
							'class' => '',
							'id' => '',
						],
						'taxonomy' => 'book_cat',
						'add_term' => 1,
						'save_terms' => 1,
						'load_terms' => 0,
						'return_format' => 'id',
						'field_type' => 'select',
						'allow_null' => 1,
						'multiple' => 0,
					],
					[
						'key' => 'book_block_show_filter',
						'label' => 'Show Filter For Page',
						'name' => 'show_filter_for_page',
						'aria-label' => '',
						'type' => 'select',
						'instructions' => '',
						'required' => 1,
						'conditional_logic' => 0,
						'choices' => array(
							1 => 'Yes',
							0 => 'No',
						),
						'default_value' => 'Yes',
						'return_format' => 'value',
						'multiple' => 0,
						'allow_null' => 0,
						'ui' => 0,
						'ajax' => 0,
						'placeholder' => '',
					],
				],
			'location' =>[
				[
					[
						'param' 	=> 'block',
						'operator' 	=> '==',
						'value' 	=> 'acf/book-item',
					],
				],
			],
		];
		if( function_exists('acf_add_local_field_group') ):
			acf_add_local_field_group($block_args);
		endif;
    }

	/**
	 * Register the book showcase block.
	 *
	*/
    public function acf_book_showcase_item_block() {
        if( function_exists('acf_register_block') ) {
            // register a book item block
            acf_register_block(
                [
                    'name'				=> 'book-item',
                    'title'				=> __('Book Showcase'),
                    'description'		=> __('A custom block for Book showcase.'),
                    'render_template'	=> SS_BOOK_SHOWCASE_DIR .'/blocks/books/book-items-render.php',
                    'category'			=> 'book-showcase',
                    'icon'				=> 'book-alt',
                    'keywords'			=> ['books', 'showcase' ],
                    'enqueue_assets'    => [$this, 'block_enqueue_assets'],
					'supports'          => ['multiple' => false],
                ]
            );
        }
    }

	/**
	 * Function to enqueue resources like style/scripts as well as localization.
	 *
	*/
    public function block_enqueue_assets(){
		if(is_admin()){
			$screen = get_current_screen();
			if('post'===$screen->base && self::TARGET_POST_TYPE === $screen->post_type){
				return;
			}
		}
		
        wp_enqueue_style(
			self::BLOCK_STYLE,
            plugins_url(basename(SS_BOOK_SHOWCASE_DIR) .'/src/styles/'.self::STYLE_FILE),
			[],
            time(),
			'all'
		);
        wp_enqueue_script(
			self::BLOCK_SCRIPT,
            plugins_url(basename(SS_BOOK_SHOWCASE_DIR) .'/src/scripts/'.self::SCRIPT_FILE),
			[],
            time(),
			true
		);

		wp_localize_script(
            self::BLOCK_SCRIPT,
            'localized_filter_book_form',
            [
                'admin_ajax_url' => admin_url( 'admin-ajax.php' ),
                'nonce'          => wp_create_nonce( '_ajaxnonce' ),
            ]
        );
    }

}
<?php

// custom post type related data and filters functionalities.

use SS\BOOKSHOWCASE\Book_Store_Post_Type as store;

if( !function_exists('show_books') ){
    /**
	 * Function to initial load table data.
	 * 
	 * @param int termId the pass taxonomy id from block settings.
	 * @return mixed
	 */
    function show_books($termId){
        $args  = pepare_payload($termId);
        $books = new Wp_Query($args);
        $tables_data='';
        if($books->have_posts()){
            while($books->have_posts()):
                $books->the_post();
                $book_thumb = wp_get_attachment_image_src( get_post_thumbnail_id($books->post->ID),'book-image-small' );
                $bookImage = (!$book_thumb) ? plugins_url(basename(SS_BOOK_SHOWCASE_DIR).'/src/assets/images/sample-book.jpg') : $book_thumb[0]; 
                $tables_data .='<tr>  
                                    <td class="bookImg"><img src='.$bookImage.'></td>  
                                    <td>'.$books->post->post_title.'</td>  
                                    <td>'.get_field('book_author', $books->post->ID).'</td>
                                    <td>'.get_field('book_description', $books->post->ID).'</td>
                                </tr>';
            endwhile;
                wp_reset_postdata();
        }else{
            $tables_data .='<tr> No Books Found </tr>';
        }
        return $tables_data;
    }
}

add_image_size( 'book-image-small', 50, 50, true );

if( !function_exists('pepare_payload') ){
    /**
	 * Function to load default payload array for query.
	 * 
	 * @param int termId the pass taxonomy id from block settings.
	 * @return array
	 */
    function pepare_payload($termId){
        $bookstore = new store();
        $args = [
            'post_type'       	=> $bookstore::POST_TYPE_SLUG ,
            'post_status'     	=> 'publish',
            'posts_per_page'  	=> -1,
            'orderby' 			=> 'date',
   			'order' 			=> 'DESC'
        ];
		if($termId !== -1):
            $args['tax_query'] = [
				'relation'	=> 'OR',
                [
                    'taxonomy' => 'book_cat',
                    'field' => 'id',
                    'terms' => [$termId],
                ]
            ];
        endif;
        return $args;
    }
}

if(!function_exists('list_books_categories')){
    /**
	 * Function to return books categories.
     * 
	 * @param int termId the pass taxonomy id from block settings.
     * @return mixed
	 */
	function list_books_categories($termId){
		$tax_output='';
        $taxonomies = get_terms( 
            [
            'taxonomy' => 'book_cat',
            'hide_empty' => false
            ]
        );
        foreach($taxonomies as $each){
			$selected = (-1 !== $termId && (int)$each->term_id === $termId) ? 'selected' : '';
			$tax_output .= '<option '.$selected.' value="'. esc_attr( $each->term_id ) .'">
					'. esc_html( $each->name ) .'</option>';
		}
        return $tax_output;
    }
}

add_action( 'wp_ajax_nopriv_filter_book_result', 'filter_book_result' );
add_action( 'wp_ajax_filter_book_result', 'filter_book_result' );

if(! function_exists( 'filter_book_result' )){
	/**
	 * Function to process ajax request to filter data from front-end.
	 */
	function filter_book_result(){
		global $wpdb;
		if ( ! isset( $_POST['_ajaxnonce'] ) && ! wp_verify_nonce( sanitize_key( $_POST['_ajaxnonce'] ) ) ) {
			return false;
		}
		$searchKey    = sanitize_text_field( filter_input( INPUT_POST, 'searchText', FILTER_UNSAFE_RAW ) );
		$bookcategory = sanitize_text_field( filter_input( INPUT_POST, 'bookCategory', FILTER_SANITIZE_NUMBER_INT ) );

		$args = [
			'post_type'       	=> 'books',
			'post_status'     	=> 'publish',
			'posts_per_page'  	=> -1,
			'order'				=> 'DESC',
			'search_title'		=> $searchKey,
        ];

		if(!empty($searchKey)):
			add_filter( 'posts_where', 'book_title_filter', 20, 2 );
		endif;
        if($bookcategory !== '-1'):
            $args['tax_query'] = [
                [
                    'taxonomy' => 'book_cat',
                    'field' => 'id',
                    'terms' => [$bookcategory],
                    'operator' => 'IN'
                ]
            ];
        endif;
		$query = new WP_Query( $args );
		remove_filter( 'posts_where', 'book_title_filter', 20, 2 );

		if($wpdb->last_error){
			$reponse_code = '500';
			$res_data = 'Something Wrong';
		}else{
			if($query->post_count > 0){
				$reponse_code = '200';
				$res_data = process_filter_data($query->posts);
			}else{
				$reponse_code = '200';
				$res_data = 'none';
			}
		}
		$result = [
			'status' => $reponse_code,
			'tableData'	 => $res_data
		];
		wp_send_json_success($result);
	}
}

if(! function_exists( 'book_title_filter' )){
	/**
	 * Post where filter to get filter data .
	 *
	 * @param string $where filter with where data.
	 * @param object|array $wp_query query object.
	 * @return mixed
	*/
	function book_title_filter( $where, &$wp_query ){
		global $wpdb;
		if ( $title = $wp_query->get( 'search_title' ) ) {
			$where .= " AND " . $wpdb->posts . ".post_title LIKE '%" . esc_sql( $wpdb->esc_like( $title ) ) . "%'" ;
		}
		return $where;
	}
}


if(! function_exists( 'process_filter_data' )){
	/**
	 * Process book data asper search filter.
	 *
	 * @param object|array $post_arrs fetched data upon search.
	 * 
	 * @return mixed
	*/
	function process_filter_data($post_arrs){
		$filter_output = [];
		foreach($post_arrs as $each_post){
            $book_thumb = wp_get_attachment_image_src( get_post_thumbnail_id($each_post->ID),'book-image-small' );
			$bookImage = (!$book_thumb) ? plugins_url(basename(SS_BOOK_SHOWCASE_DIR).'/src/assets/images/sample-book.jpg') : $book_thumb[0];
			$filter_output[]= [
                'thumbnail'     => $bookImage,
				'title'	  	    => $each_post->post_title,
				'author'	    => get_field('book_author', $each_post->ID),
				'description'	=> get_field('book_description', $each_post->ID),
			];
		}
		return $filter_output;
	}
}
<?php
/**
 * Book Showcase Block main Setup file called with plugin_loaded hook.
 *
 * @package book-showcase-block.
 */

namespace SS\BOOKSHOWCASE;

use SS\BOOKSHOWCASE\Book_Showcase;
use SS\BOOKSHOWCASE\Book_Store_Post_Type;
use SS\BOOKSHOWCASE\Block_Resources;

/**
 * Plugin loader.
 *
 * @return void
 */
function setup() {
    new Book_Store_Post_Type();
    new Block_Resources();
}
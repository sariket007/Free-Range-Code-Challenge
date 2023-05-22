<?php
// book block render template.

$blockId = $block['id'];
$blockTitle = (!empty(get_field('block_title'))) ? get_field('block_title') : 'Enter Suitable Block Title' ;
$blockDeascription = (!empty(get_field('book_description'))) ? get_field('book_description') : 'Enter Suitable Block Description';
$book_term = get_field('book_category');
$termId = ($book_term)? (int) $book_term : -1;
$filter_show = get_field('show_filter_for_page');
?>
<div id="showcaseBox<?php echo esc_attr($blockId);?>" class="bookRender">
    <div class="topDetails">
        <div class="titleBox">
            <h2 class="blockTitle"><?php echo esc_html__($blockTitle);?></h2>
            <p class="blockDes"><?php echo esc_html__($blockDeascription); ?></p>
        </div>
    </div>
    <div class="bookResultants" id="resultBox" style="overflow-x:auto;">
        <?php if(!is_admin() && '1' === $filter_show):?>
            <div class="resultantFilter">
                <div class="formTxtField field">
                    <input type="text" name="bookTitle" id="filterText" placeholder="Type book Name here">
                </div>
                <div class="formSelectField">
                    <div class="selectdiv">
                        <select name="bookCat" id="filterOption">
                            <option value="-1">Categorise : ALL</option>
                            <?php echo list_books_categories($termId); ?>
                        </select>
                    </div>
                </div>
            </div>
        <?php endif;?>
        <div class="table-wrapper">
            <table class="cptData" id="bookDetails">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Author</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    <?php echo show_books($termId); ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Author</th>
                        <th>Description</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <?php if(!is_admin()):?>
            <div id="filteredResult"  class=" table-wrapper hidden">
            </div>
        <?php endif;?>
    </div>
</div>
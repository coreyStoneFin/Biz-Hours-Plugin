<?php
/***********
 * SECTION
 * ACTIONFILTERS*
 */
//Display Fields
add_action('woocommerce_product_after_variable_attributes', 'eatfit_variable_fields', 10, 3);
//JS to add fields for new variations
add_action('woocommerce_product_after_variable_attributes_js', 'eatfit_variable_fields_js');
//Save variation fields
//add_action('woocommerce_process_product_meta_variable', 'eatfit_save_variable_fields', 10, 1);
add_action('woocommerce_save_product_variation', 'eatfit_save_variable_fields', 10 , 2);
//categories in the shop page.
//commented out because it isn't registered yet so we can't remove it.
// remove_action( 'woocommerce_before_subcategory_title', 'etheme_woocommerce_subcategory_thumbnail', 10 );
// add_action( 'woocommerce_before_subcategory_title', 'eatfit_woocommerce_subcategory_thumbnail', 5 );
add_action('eatfit_category_productlist', 'eatfit_woocommerce_subcategory_productlist', 10);


//make the store only show variable products with valid calories!
add_filter('woocommerce_product_query', 'eatfit_woocommerce_product_query');


//add the mini-cart widget contents to the ajax add to cart response.
add_filter('add_to_cart_fragments', 'eatfit_woocommerce_header_add_to_cart_fragment');

add_filter('woocommerce_placeholder_img_src', 'eatfit_woocommerce_placeholder_img_src');

//todo make this customizable.
function eatfit_woocommerce_placeholder_img_src($src)
{
    $upload_dir = wp_upload_dir();
    $uploads = untrailingslashit($upload_dir['baseurl']);
    $src = $uploads . '/2014/11/pic-coming-soon.png';
    return $src;
}

function eatfit_woocommerce_header_add_to_cart_fragment($fragments)
{
    global $woocommerce;
    ob_start();
    if (class_exists('Woocommerce') && !etheme_get_option('just_catalog') && etheme_get_option('cart_widget')) { ?>
        <div id="top-cart" class="shopping-cart-wrapper widget_shopping_cart">
            <?php $cart_widget = new Etheme_WooCommerce_Widget_Cart();
            $cart_widget->widget(); ?>
        </div>
        <?php
        $fragments['#top-cart'] = ob_get_clean();
    }
    return $fragments;
}


function eatfit_woocommerce_subcategory_productlist($category)
{
//  logDie($category);
    // The Featured Posts query.
    $catProductArgs = eatfit_getPostQueryMods();
    $catProductArgs['posts_per_page'] = -1;
    $catProductArgs['post_type'] = 'product';
    $catProductArgs['tax_query'] = array(
        'relation' => 'AND',
        array(
            'taxonomy' => 'product_cat',
            'field' => 'slug',
            // 'terms' => 'white-wines'
            'terms' => $category->slug
        )
    );
    //eatfit_modifyQueryArgs($catProductArgs);
    //logDie($catProductArgs);
    //logDie($category);
    etheme_create_slider($catProductArgs, $category->name);
}

function eatfit_woocommerce_subcategory_thumbnail($category)
{
    //commented
    // global $woocommerce;
    //
    // $small_thumbnail_size  	= array(300,300);
    // $dimensions    			= $woocommerce->get_image_size( $small_thumbnail_size );
    // $thumbnail_id  			= get_woocommerce_term_meta( $category->term_id, 'thumbnail_id', true  );
    //
    // if ( $thumbnail_id ) {
    // 	$image = wp_get_attachment_image_src( $thumbnail_id, $small_thumbnail_size  );
    // 	$image = $image[0];
    // } else {
    // 	$image = woocommerce_placeholder_img_src();
    // }
    //
    // if ( $image )
    // 	echo '<img src="' . $image . '" alt="' . $category->name . '"/>';
    // echo "Asdf";
}


function eatfit_getPostQueryMods()
{
    return array(
        'meta_query' => array(
            'key' => '_eatfit_calories',
            'value' => 0,
            'compare' => '>',
            'type' => 'numeric'
        ),
        'tax_query' => array(
            'taxonomy' => 'product_type',
            'field' => 'slug',
            'terms' => array('variable')
        ));
}

//fun fact, php is copy on write, so the array AND the value have to be references.
function eatfit_modifyQueryArgs(&$args)
{
    foreach (eatfit_getPostQueryMods() as $key => $val) {

        $value = &$args[$key];
        if (!isset($value)) {
            $value = array();
            $args[$key] = $value;
        }
        $value[] = $val;
    }
}

function eatfit_modifyQuery($query)
{
    foreach (eatfit_getPostQueryMods() as $key => $val) {
        $value = $query->get($key);
        if (!isset($value)) {
            $value = array();
            $query->set($key, $value);
        }
        $value[] = $val;
    }
}

function eatfit_woocommerce_product_query($query)
{
    eatfit_modifyQuery($query);
    $query->set('posts_per_page', 500);
    //logDie($query);
}


// simple product extra fields
function eatfit_woocommerce_getname($id)
{
    return '_eatfit_' . $id;
}

function eatfit_woocommerce_getid($id, $loop)
{
    return eatfit_woocommerce_getname($id) . (isset($loop) ? '[' . $loop . ']' : '[ + loop + ]');
}

function eatfit_woocommerce_wp_num($IDPrefix, $loop, $variation_data,
                                   $label, $desc, $customAttributes, $variation)
{
    $custAttr = isset($customAttributes) ? $customAttributes : array(
        'step' => 'any',
        'min' => '0'
    );
//    return array(
//        'id' => eatfit_woocommerce_getid($IDPrefix, $loop),
//        'label' => __($label, 'woocommerce'),
//        'desc_tip' => 'true',
//        'description' => __($desc, 'woocommerce'),
//        'value' => $variation_data[eatfit_woocommerce_getname($IDPrefix)][0],
//        'custom_attributes' => $custAttr
//    );
    return array(
        'id' => eatfit_woocommerce_getid($IDPrefix, $loop),
        'label' => __($label, 'woocommerce'),
        'desc_tip' => 'true',
        'description' => __($desc, 'woocommerce'),
        'value' => get_post_meta($variation->ID, eatfit_woocommerce_getname($IDPrefix), true),
        'custom_attributes' => $custAttr
    );
}

function eatfit_woocommerce_createrow($args)
{
    ?>

    <tr>
        <?php
        eatfit_woocommerce_createcell($args);
        ?>
    </tr>
    <?php
}

function eatfit_woocommerce_createcell($args)
{
    ?>
    <td>
        <?php
        woocommerce_wp_text_input($args);
        ?>
    </td>
    <?php
}

function eatfit_sourcefields()
{
    return Array(
        Array('key' => 'calories', 'descr' => 'Calories'),
        Array('key' => 'protein', 'descr' => 'Protein (g)'),
        Array('key' => 'carbs', 'descr' => 'Carbs (g)'),
        Array('key' => 'fat', 'descr' => 'Fat (g)'),
        Array('key' => 'satfat', 'descr' => 'Sat Fat (g)'),
        Array('key' => 'fiber', 'descr' => 'Fiber (g)'),
        Array('key' => 'sodium', 'descr' => 'Sodium (mg)'),
        Array('key' => 'sugar', 'descr' => 'Sugar (g)'),
        Array('key' => 'cholesterol', 'descr' => 'Cholesterol (mg)'),
    );
}

;
function _logDie($arg)
{
    ob_end_clean();
    echo var_export($arg, true);
    die();
}

function logDie($arg)
{
    _logDie($arg);
}

/**
 * Create new fields for variations
 *
 */
function eatfit_variable_fields($loop, $variation_data, $variation)
{
    //create the fields, then output
    $fitFields = array();
    foreach (eatfit_sourcefields() as $sourceField) {
        $fitFields[] = eatfit_woocommerce_wp_num($sourceField['key'], $loop, $variation_data,
            $sourceField['descr'], "", null, $variation);
        $yoga='cats';
    }
    foreach ($fitFields as $fldOption) {
        eatfit_woocommerce_createrow($fldOption);
    }
}

/**
 * Create new fields for new variations
 *
 */
function eatfit_variable_fields_js()
{
    $fitFields = array();
    foreach (eatfit_sourcefields() as $sourceField) {
        //$variation_data shouldn't exist according to example, so leaving the weird reference.
        //it might be smart to replace it with a null, like the loop, but the calling code has a dependency on
        //variation data, so who knows.
        $fitFields[] = eatfit_woocommerce_wp_num($sourceField['key'], null, $variation_data,
            $sourceField['descr'], "", null);

    }
    ?>
    <tr>
        <td>
            <fieldset>
                <legend>NUTRITION</legend>
                <table>
                    <?php
                    $cellCount = 0;

                    foreach ($fitFields as $fldOption) {
                        if ($cellCount % 2 == 0) {

                        }
                        eatfit_woocommerce_createcell($fldOption);
                        $cellCount++;
                    }
                    ?>
                </table>
        </td>
    </tr>
    <?php
}

/**
 * Save new fields for variations
 *
 */
function eatfit_save_variable_fields($post_id, $loop)
{
    if (isset($_POST['variable_sku'])) {
        $variable_sku = $_POST['variable_sku'];
        $variable_post_id = $_POST['variable_post_id'];

        foreach (eatfit_sourcefields() as $sourceField) {
            $fldName = eatfit_woocommerce_getname($sourceField['key']);
            $_number_field = $_POST[$fldName];
            for ($i = 0; $i < sizeof($variable_sku); $i++) {
                $variation_id = (int)$variable_post_id[$i];
                if (isset($_number_field)) {
                    update_post_meta($variation_id, $fldName, stripslashes($_number_field[$i]));

                }
            };
        }
    }
}

?>

<?php

/*
* add custom fields checkout page
*/
add_filter('woocommerce_billing_fields', 'custom_woocommerce_billing_fields');

function custom_woocommerce_billing_fields($fields)
{

    $fields['custom_checkbox'] = array(
        'label' => __('Fill Street address.', 'woocommerce'), // Add custom field label
        //'placeholder' => _x('Your NIF here....', 'placeholder', 'woocommerce'), // Add custom field placeholder
        'required' => false, // if field is required or not
        'clear' => false, // add clear or not
        'type' => 'checkbox', // add field type
        'priority' => 51,
        'class' => array('my-css')    // add class name
    );

    return $fields;
}


function filter_woocommerce_shipping_fields( $fields ) { 
     $fields['custom_checkbox_shipping'] = array(
        'label' => __('Fill Street address 2.', 'woocommerce'), // Add custom field label
        //'placeholder' => _x('Your NIF here....', 'placeholder', 'woocommerce'), // Add custom field placeholder
        'required' => false, // if field is required or not
        'clear' => false, // add clear or not
        'type' => 'checkbox', // add field type
        'priority' => 51,
        'class' => array('my-css')    // add class name
    );

    return $fields;
}; 
         
// add the filter 
add_filter( 'woocommerce_shipping_fields', 'filter_woocommerce_shipping_fields', 10, 2 ); 
/*
* add custom fields checkout page
*/




/*
* changed woocommerce order status
*/ 
add_action('woocommerce_order_status_changed','status_changed_processsing');
   function status_changed_processsing( $order_id, $checkout = null ) {
       global $woocommerce;
        $order = new WC_Order($order_id);
        
        if (!empty($order)) {
         $order->update_status( 'processing' );
        }
}
/*
* changed woocommerce order status
*/ 


/*
* Show woocommerce empty category
*/
//font
add_filter( 'woocommerce_product_subcategories_hide_empty', array( $this,'hide_empty_categories'), 10, 1 );
function hide_empty_categories ( $hide_empty ) {
        $hide_empty  =  FALSE;
        return $hide_empty;
    }

//back
add_filter( 'get_terms_args', array( $this,'wpd_show_empty_terms_in_quick_search'), 10, 2 );

function wpd_show_empty_terms_in_quick_search( $args, $taxonomies ){
        $args['hide_empty'] = false;
        return $args;
    }   
/*
* Show woocommerce empty category
*/



/*
* get woocommerce variable product price
*/
$varproduct  = wc_get_product( $woorel_item_id );

$var_price_first = $varproduct->get_price(); 

$available_variations = $varproduct->get_children();

$available_variations = end($available_variations);

$productnnn = new WC_Product_Variation($available_variations);

$var_price_last = $productnnn->get_price();

$var_septare_price = $currency_symbol.$var_price_first.' - '.$currency_symbol.$var_price_last;
/*
* get woocommerce variable product price
*/



/*
* woocommerce_before_calculate_totals
*/
add_action( 'woocommerce_before_calculate_totals', 'adding_custom_price', 10, 1);
function adding_custom_price( $cart_obj ) {

    if ( is_admin() && ! defined( 'DOING_AJAX' ) )
        return;

    // Set below your targeted individual products IDs or arrays of product IDs
    $target_product_id = 8;
    //$target_product_ids_arr = array(22, 56, 81);

    foreach ( $cart_obj->get_cart() as  $cart_item ) {
        // The corresponding product ID
        $product_id = $cart_item['product_id'];

        // For a single product ID
        if($product_id == $target_product_id){
            // Custom calculation
            $price = $cart_item['data']->get_price() + 50;
            $cart_item['data']->set_price( floatval($price) );

            echo "-a";
        } 

        // For an array of product IDs 
        elseif( in_array( $product_id, $target_product_ids_arr ) ){
            // Custom calculation
            $price = $cart_item['data']->get_price() + 30;
            $cart_item['data']->set_price( floatval($price) );
        }
    }
}
/*
* woocommerce_before_calculate_totals
*/


/*
* add to cart programatically woocommerce
*/

$product_id   = $_POST['product_id'];
  $quantity     = $_POST['quantity'];
  $variation_id = $_POST['variation_id'];
  $variation    = array(
    'Color' => 'Blue',
    'Size'  => 'Small',
  );

WC()->cart->add_to_cart( $product_id, $quantity);
/*
* add to cart programatically woocommerce
*/


/*
* unset woocomerce country
*/
function woo_remove_specific_country( $country ) {

   unset($country["IN"]);
   unset($country["BY"]);
   unset($country["BI"]);
   unset($country["CF"]);
   unset($country["CG"]);
   unset($country["CD"]);
   unset($country["CU"]);
   unset($country["IR"]);
   unset($country["IQ"]);
   unset($country["LB"]);
   unset($country["KP"]);
   unset($country["SO"]);
   unset($country["SD"]);
   unset($country["SS"]);
   unset($country["SY"]);
   unset($country["UA"]);
   unset($country["VE"]);
   unset($country["YE"]);
   unset($country["ZW"]);
   return $country; 
}
add_filter( 'woocommerce_countries', 'woo_remove_specific_country', 10, 1 );
/*
* unset woocomerce country
*/

/*
* get id by sku woocomerce
*/
echo wc_get_product_id_by_sku( $sku );
/*
* get id by sku woocomerce
*/

/*
* woocomerce page url
*/
echo get_permalink( wc_get_page_id( 'myaccount' ) );
echo get_permalink( wc_get_page_id( 'shop' ) );
echo get_permalink( wc_get_page_id( 'cart' ) );
echo get_permalink( wc_get_page_id( 'checkout' ) );
    global $wp;
    $get_current_page_url = home_url( $wp->request ).'/'; 
    $get_cart_page_url = get_permalink( wc_get_page_id( 'cart' ) );
    if($get_current_page_url === $get_cart_page_url){
        $footer = 'footer-1';
    }
/*
* woocomerce page url
*/




/*
*  Remove the product description Title
*/
// Remove the product description Title
add_filter( 'woocommerce_product_description_heading', 'remove_product_description_heading' );
function remove_product_description_heading() {
 return '';
}

// Change the product description title
add_filter('woocommerce_product_description_heading', 'change_product_description_heading');
function change_product_description_heading() {
 return __('description', 'woocommerce');
}
/*
*  Remove the product description Title
*/


/*
* @modify price html
*/
add_filter( 'woocommerce_get_price_html', 'wpa83367_price_html', 100, 2 );
function wpa83367_price_html( $price, $product ){
    
    $product_id = $product->get_id();
    
    if($product_id == 6385){
         $custom_html = '<ins><span style="margin-right: 7px;" class="woocommerce-Price-amount amount">From</span></ins>'.$price;
    }
    else{
        $custom_html = $price;
    }
    return $custom_html;
}
/*
* @modify price html
*/
?>
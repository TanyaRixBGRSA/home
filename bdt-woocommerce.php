
<?php

add_action('woocommerce_single_product_summary', 'customizing_single_product_summary_hooks', 2  );
function customizing_single_product_summary_hooks(){
    remove_action('woocommerce_single_product_summary','woocommerce_template_single_title', 10 );
    remove_action('woocommerce_single_product_summary','woocommerce_template_single_rating', 10 );
    remove_action('woocommerce_single_product_summary','woocommerce_template_single_price',10  );
    remove_action('woocommerce_single_product_summary','woocommerce_template_single_excerpt',20  );
    remove_action('woocommerce_single_product_summary','woocommerce_template_single_add_to_cart',30 );
    remove_action('woocommerce_single_product_summary','woocommerce_template_single_meta',40 );
    remove_action('woocommerce_single_product_summary','woocommerce_template_single_sharing' ,50);
	
	
    add_action('woocommerce_single_product_summary','woocommerce_template_single_price', 10 ); 
	add_action('woocommerce_single_product_summary','woocommerce_template_single_excerpt', 20 );
	add_action('woocommerce_single_product_summary','woocommerce_template_single_add_to_cart', 30 );
	
}

//add_filter( 'woocommerce_product_description_heading', '__return_null' );
add_action( 'woocommerce_before_shop_loop_item', 'bdt_custom_action', 15 );

 
function bdt_custom_action() {
echo '<span class="bdt-image">';
}

add_action( 'woocommerce_before_shop_loop_item_title', 'bbloomer_custom_action', 15 );
 
function bbloomer_custom_action() {
echo '</span>';
}

remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 20 );


function bdt_single_class(){
	echo '<div class="bdt-single-product">';
}
add_action('woocommerce_before_single_product', 'bdt_single_class', 10 , 1);

function bdt_single_class_end(){
	echo '</div>';
}
add_action('woocommerce_after_single_product_summary', 'bdt_single_class_end', 10 , 1);


//Showroom
function bdt_wishlist_support(){
	echo '<div class="action bdt_wishlist">' . do_shortcode('[yith_wcwl_add_to_wishlist]') . '</div>';
}
add_action('woocommerce_after_shop_loop_item', 'bdt_wishlist_support');

function isa_woo_cart_attributes($cart_item, $cart_item_key) {
    global $product; 
    if(is_checkout() && is_wc_endpoint_url( 'selection-confirmation')){
    $item_data = $cart_item_key['data']; 
    $post = get_post($item_data->id); 
    $thumb = get_the_post_thumbnail($item_data->id, array( 32, 50)); 
    echo '<div id="checkout_thumbnail" style="float: left; padding-right: 8px">' . $thumb . '</div> '; }
} 
//add_filter('woocommerce_cart_item_name', 'isa_woo_cart_attributes', 10, 2);

?>
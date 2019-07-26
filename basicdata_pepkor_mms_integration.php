<?php
/*
Plugin Name:  BasicData Pepkor MMS Integration
Plugin URI:  
Description:  Adds custom product fields required by MMS. Add MMS integration.
Version:      1.2
Author:       BasicData
Author URI:   https://basicdata.io/
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  basicdata_pepkor_mms_integration
Domain Path:  
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
	
	
register_activation_hook( __FILE__, 'bmc_multi_currency_activate' );


register_deactivation_hook( __FILE__, 'bmc_multi_currency_deactivation' );

add_action('init','baa_init_hook');
add_action('admin_enqueue_scripts','baa_enqueue_scripts');

function baa_init_hook(){
	include 'includes/baa_settings_page.php';
	include 'includes/baa_custom_fields.php';
}

function baa_enqueue_scripts(){
	//wp_enqueue_script('baa_add_data', plugin_dir_url(__FILE__).'assets/js/add_data.js');
	wp_enqueue_script('baa_add_data', plugin_dir_url(__FILE__).'assets/js/baa_wp_admin.js');
	wp_enqueue_style('baa_add_data', plugin_dir_url(__FILE__).'assets/css/baa_admin_style.css');
	
	wp_register_style('basicdata_dashicons', plugin_dir_url(__FILE__). 'includes/glyphter-font/css/BasicData.css');
		wp_enqueue_style('basicdata_dashicons' );
}
//Retrieving the Fields and Displaying on Product Summary
function pp_admin_footer(){

	global $current_screen;
	if ($current_screen->id == 'product') :
	//

	echo'<script type="text/javascript">


					function AttributesGets(){


					var ShippingPort = document.querySelector(".pa_shipping-port .attribute_values option:checked").innerHTML;
					var Containerload = document.querySelector(".pa_teu-load-quantity .attribute_values option:checked");
					var ProductVolume = document.querySelector(".pa_product-volume-cbm .attribute_values option:checked");
					var CartonQty = document.querySelector(".pa_carton-quantity .attribute_values option:checked");
					var PackSize = document.querySelector(".pa_pack-size .attribute_values option:checked");
					var ImageUrl =  document.querySelector("#set-post-thumbnail img").src;


					var ProductCatarray = document.querySelectorAll("#product_catchecklist li input:checked");
					var ProductCat = "";

					var i;
					for( i = 0; i < ProductCatarray.length; i++){
					  ProductCat += ProductCatarray[i].nextSibling.nodeValue + "; ";
					}


					var GenderArray = document.querySelectorAll(".pa_gender .attribute_values option:checked");
					var gendervalue = "";

					var i;
					for( i = 0; i < GenderArray.length; i++){
						  gendervalue += GenderArray[i].innerHTML + "; ";
					 }


					if( Containerload === null){
						var Containerload = " ";
					}else{
						var Containerload = document.querySelector(".pa_teu-load-quantity .attribute_values option:checked").innerHTML;

					}


					if( ProductVolume === null){
						var ProductVolume = " ";
					}else{
						var ProductVolume = ProductVolume.innerHTML;

					}

					if( PackSize === null){
						var PackSize = " ";
					}else{
						var PackSize = PackSize.innerHTML;

					}

					if( CartonQty === null){
						var CartonQty = " ";
					}else{
						var CartonQty = CartonQty.innerHTML;

					}


					document.getElementById("product_category").value = ProductCat;
					document.getElementById("shipping_port").value = ShippingPort;	
					document.getElementById("teu-load-quantity").value= Containerload;
					document.getElementById("product_volume").value = ProductVolume;
					document.getElementById("pack_size").value = PackSize;
					document.getElementById("carton_qty").value = CartonQty;
					document.getElementById("gender").value = gendervalue;
					document.getElementById("feature_image_url").value = ImageUrl;

					}

					document.getElementById("publish").addEventListener("click", AttributesGets)



				</script>' ;

	endif;

}
add_action('admin_footer', 'pp_admin_footer');



function debug_to_console( $data, $context = 'Debug in Console' ) {

    // Buffering to solve problems frameworks, like header() in this and not a solid return.
    ob_start();

    $output .= 'console.log(' . json_encode( $data ) . ');';
    $output  = sprintf( '<script>%s</script>', $output );

    echo $output;
}

add_action( 'woocommerce_thankyou', 'post_to_wso2',1,1);
function post_to_wso2($order_id){
	try {
		$wso2 = new wso2_wrapper(
			get_option('api_url_baa'),
			get_option('Consumer_Key_option'),
			get_option('Consumer_Secret_option'),
			get_option('username_option'),
			get_option('password_option'),
			'default'
		);
		//Get the order via the id available in action 
		$order = wc_get_order( $order_id );
		//Get the order details via the id
		$order_data = $order->get_data();
		$order_items = $order->get_items();
		$my_items = [];
		foreach ( $order_items as $item ) {
			if ( is_a( $item, 'WC_Order_Item_Product' ) ) {
				$item_data = $item->get_data();
				$item_data['taxes'] = [];
				$product_id = $item_data["product_id"];
				$_product = wc_get_product( $product_id );
				$price = $_product->get_price();
				$item_data['price'] = $price;
				array_push($my_items,$item_data);
			}
		}
		
		//Get the date created object
		$date_created = $order->get_date_created();
		//Get the date modified object
		$date_modified = $order->get_date_modified();
		debug_to_console($date_created);
		debug_to_console($date_modified);
// 		debug_to_console($date_created->date);
// 		debug_to_console($date_modified->date);
		//Set the date in the data object
		$order_data['date_created'] = date("c", strtotime($date_created->date));
		$order_data['date_modified'] = date("c", strtotime($date_modified->date));
		$order_data['line_items'] = $my_items;

		$response = $wso2->getInfo($order_data);
		
	} catch (Throwable $exception) {
		print 'Something bad happened: ' . $exception->getMessage();
	}
}



//   Lourens Edit Insert
class wso2_wrapper
{
    /**
     * @var string
     */
    protected $hostname;
    /**
     * @var string
     */
    protected $username;
    /**
     * @var string
     */
    protected $password;
    /**
     * @var string
     */
    protected $scope;

    /**
     * @var string
     */
    protected $key;
    /**
     * @var string
     */
    protected $secret;

    /**
     * wso2_wrapper constructor.
     *
     * @param string $hostname
     * @param string $key
     * @param string $secret
     * @param string $username
     * @param string $password
     * @param string $scope
     */
    public function __construct(
        $hostname,
        $key,
        $secret,
        $username,
        $password,
        $scope = 'default'
    ) {
        $this->hostname = $hostname;
        $this->key = $key;
        $this->secret = $secret;
        $this->username = $username;
        $this->password = $password;
        $this->scope = $scope;
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getToken()
    {
        return $this->doCall( '/token', $data);
    }

    /**
     * @param integer $url
     * @param array   $data
     *
     * @return array
     * @throws Exception
     */
    protected function doCall($url, $data)
    {
        if ($url === '/token') {
			$args = array(
				  'headers' => array(
					'Authorization' => 'Basic ' . base64_encode($this->key . ':' . $this->secret),
					'Content-Type: ' . 'application/x-www-form-urlencoded'
				  ),
					'body' => array(
						'grant_type' => 'password',
						'username'   => $this->username,
						'password'   => $this->password,
						'scope'      => $this->scope
					)
				);
        } else {
            $tokenInfo = $this->getToken();
			$tokenInfo = json_decode($tokenInfo['body']);		
			$args = array(
				  'headers' => array(
					'Authorization' => 'Bearer ' . $tokenInfo->access_token,
					'Content-Type' => 'application/json'
				  ),
				'body' => json_encode($data)
				);
        }
		@ini_set( 'post_max_size', '64M');
        $result = wp_remote_post($this->hostname . $url, $args);
		
		//print_r($result);
		//print_r($args);
		
		if ( is_wp_error( $result ) ) {
			$error_message = $result->get_error_message();
			echo 'Error while posting to wso2: <pre style="color:red">';
			print_r( "Something went wrong: $error_message");
			echo '</pre>';
		}

        return $result;
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getInfo($order)
    {
		return $this->doCall('/PepMMSInboundSupplierShowroom/1.0.0/buyerbasket',$order);
    }
}

add_filter('http_request_args', 'fix_wp_curl_timeout', 100, 1);
function fix_wp_curl_timeout( $time )
{
$time['timeout'] = 10000;
return $time;
}


function bpim_head_script(){
	echo'
	<style>
		.bdt_mini_cart .variation{display: none;}
	</style>';
}

add_action('wp_head','bpim_head_script');

require 'plugin-update/plugin-update-checker.php';
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'http://clientzone.basicdata.io/pepkorit/plugins/basicdata_pepkor_mms_integration/plugin.json',
	__FILE__, //Full path to the main plugin file or functions.php.
	'basicdata_pepkor_mms_integration'
);
?>
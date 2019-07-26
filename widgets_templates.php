<?php 
class BDFooterWidget extends WP_Widget {

	function __construct() {
		// Instantiate the parent object
		$widget_options = array( 
      	'classname' => 'bd_myaccount',
      	'description' => 'Woocommerce My Account',
    	);
		parent::__construct( 'bd_myaccount', 'BasicData My Account', $widget_options );
	}
	
	public function widget( $args, $instance ) {
		// Widget output
		
		  $title = apply_filters( 'bd_myaccount', $instance[ 'title' ] );
		  /*$$blog_title = get_bloginfo( 'name' );
		  $tagline = get_bloginfo( 'description' );
		  echo $args['before_widget'] . $args['before_title'] . $title . $args['after_title']; */
		?>

		<ul class="nav navbar-dark navbar-inverse d-inline-flex"> 
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle"  href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				 <?php 
					echo $title;
					
					if( empty($instance[ 'title' ])){
						echo 'My Account';
					}
					?>
				</a>
				<div class="dropdown-menu" aria-labelledby="navbarDropdown">
				  <a class="dropdown-item" href="/wishlist/">WISHLIST</a>
				  <a class="dropdown-item" href="/compare/">COMPARE</a>
				  <div class="dropdown-divider"></div>
				  <a class="dropdown-item" href="<?php echo wp_logout_url(); ?>">LOGOUT</a>
				</div>
			</li>
		</ul>
		  <?php /*echo $args['after_widget'];*/
		
	}

	function update( $new_instance, $old_instance ) {
		// Save widget options
		 $instance = $old_instance;
		 $instance[ 'title' ] = strip_tags( $new_instance[ 'title' ] );
		 return $instance;
	}

	function form( $instance ) {
		// Output admin widget options form
		
	  $title = ! empty( $instance['title'] ) ? $instance['title'] : ''; ?>
	  <p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
		<input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $title ); ?>" />
	  </p><?php
	}
}



class BD_mini_cart_Widget extends WP_Widget {

	function __construct() {
		// Instantiate the parent object
		$widget_options = array( 
      	'classname' => 'bd_mini_cart',
      	'description' => 'Woocommerce Mini Cart',
    	);
		parent::__construct( 'bd_mini_cart', 'BasicData Mini Cart', $widget_options );
	}
	
	public function widget( $args, $instance ) {
		// Widget output
		
		  $title = apply_filters( 'bd_myaccount', $instance[ 'title' ] );
		  /*$$blog_title = get_bloginfo( 'name' );
		  $tagline = get_bloginfo( 'description' );
		  echo $args['before_widget'] . $args['before_title'] . $title . $args['after_title']; */
		
		?>
		<ul class="nav navbar-dark navbar-inverse d-inline-flex mini-cart bdt_mini_cart"> 
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle"  href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				 	<?php 
						echo $title;

						if( empty($instance[ 'title' ])){
								global $woocommerce;
								$cart_count = count(WC()->cart->get_cart());
							 
							 if( $cart_count === 0){
								 echo "NO ITEMS";
							 }elseif($cart_count === 1){
								 echo $cart_count . " ITEM";
							 }else{
								 echo $cart_count . " ITEMS";
							 }
						
						}
					?>
				</a>
				<div class="dropdown-menu" aria-labelledby="navbarDropdown">
				  <span class="dropdown-item" href="#"><?php woocommerce_mini_cart(); ?></span>
				</div>
			</li>
		</ul>
		<?php
	}

	function update( $new_instance, $old_instance ) {
		// Save widget options
		 $instance = $old_instance;
		 $instance[ 'title' ] = strip_tags( $new_instance[ 'title' ] );
		 return $instance;
	}

	function form( $instance ) {
		// Output admin widget options form
		
	  $title = ! empty( $instance['title'] ) ? $instance['title'] : ''; ?>
	  <p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
		<input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $title ); ?>" />
	  </p><?php
	}
}

function myplugin_register_widgets() {
	register_widget( 'BDFooterWidget' );
	register_widget( 'BD_mini_cart_Widget' );
}

add_action( 'widgets_init', 'myplugin_register_widgets' );


function arphabet_widgets_init() {
	$num = 1;
	
	register_sidebar( array(
		'name'          => 'Top Bar Right',
		'id'            => 'topbarright',
		'before_widget' => '<span>',
		'after_widget'  => '</span>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4>',
	) );
	
	register_sidebar( array(
		'name'          => 'Top Bar Left',
		'id'            => 'topbarleft',
		'before_widget' => '<span>',
		'after_widget'  => '</span>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4>',
	) );
	
	register_sidebar( array(
		'name'          => 'Mini Top',
		'id'            => 'minitop',
		'before_widget' => '<div class="">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4>',
	) );
	
		
	
	register_sidebar( array(
		'name'          => 'Footer',
		'id'            => 'footer',
		'before_widget' => '<div>',
		'after_widget'  => '</div>',
		'before_title'  => '<h5>',
		'after_title'   => '</h5>',
	) );
	
	register_sidebar( array(
		'name'          => 'Copyright',
		'id'            => 'copyright',
		'before_widget' => '<div class="d-flex">',
		'after_widget'  => '</div>',
		'before_title'  => '<h7>',
		'after_title'   => '</h7>&nbsp ',
	) );
	
	
	register_sidebar( array(
		'name'          => 'Shop Sidebar',
		'id'            => 'shop-sidebar',
		'description'   => __( 'Add widgets here to appear in your sidebar on blog posts and archive pages.', 'twentyseventeen' ),
		'before_widget' => '<section id="%1$s" class="bdt-shop-siderbar widget %2$s yith-woo-ajax-navigation">',
		'after_widget'  => '</section>',
		'before_title'  => '<h5 class="widget-title">',
		'after_title'   => '</h5>',
	) );
	
	register_sidebar( array(
		'name'          => 'Home Page Banner',
		'id'            => 'home-page-banner',
		'before_widget' => '<span class="col-6 align-self-center mx-auto">',
		'after_widget'  => '</span>',
		'before_title'  => '<h3>',
		'after_title'   => '</h3>&nbsp',
	) );
	
	

	

}
add_action( 'widgets_init', 'arphabet_widgets_init' ); 


?>

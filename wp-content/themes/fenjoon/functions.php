<?php
//******************************************
// Basic Setup
//******************************************
define( "THEME_DIR", get_template_directory() );
define( "THEME_URI", get_template_directory_uri() );
load_theme_textdomain( 'fenjoon', THEME_DIR .'/lang');
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'feed_links', 2 );
add_filter('show_admin_bar', '__return_false');
add_theme_support( 'post-thumbnails' );
add_theme_support( 'menus' );
add_theme_support( 'html5', array( 'search-form' ) );
//******************************************
// disable emoji
//******************************************
function fjn_disable_emojicons_tinymce( $plugins ) {
  if ( is_array( $plugins ) ) {
    return array_diff( $plugins, array( 'wpemoji' ) );
  } else {
    return array();
  }
}
function fjn_disable_wp_emojicons() {
  remove_action( 'admin_print_styles', 'print_emoji_styles' );
  remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
  remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
  remove_action( 'wp_print_styles', 'print_emoji_styles' );
  remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
  remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
  remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
  add_filter( 'tiny_mce_plugins', 'fjn_disable_emojicons_tinymce' );
}
add_action( 'init', 'fjn_disable_wp_emojicons' );
//******************************************
// Add Custom JS & CSS
//******************************************
function add_fenjoon_admin_js() {
	wp_enqueue_script( 'fenjoon_admin_js', admin_url() . 'js/fenjoon_admin.js', array(), '1.0', true );
}
add_filter('admin_head', 'add_fenjoon_admin_js');
function add_fenjoon_admin_css() {
	wp_register_style( 'fenjoon_admin_css', admin_url() . 'css/fenjoon_admin.css', false, '1.0' );
	wp_enqueue_style( 'fenjoon_admin_css' );
}
add_action( 'admin_enqueue_scripts', 'add_fenjoon_admin_css' );
function add_fenjoon_js() {
	if( is_page_template( 'single-orders.php' ) || is_singular( 'orders' ) ){
		wp_enqueue_script( 'order', THEME_URI . '/js/order.min.js', array(), '1.0', true );
	}
	if( is_page_template( 'single-projects.php' ) || is_singular( 'projects' ) ){
		wp_enqueue_script( 'gauge', THEME_URI . '/js/gauge.min.js', array(), '1.0', true );
	}
	wp_enqueue_script( 'fenjoon', THEME_URI . '/js/fenjoon.min.js', array(), '1.0', true );
}
add_action( 'wp_enqueue_scripts', 'add_fenjoon_js' );
//******************************************
// add image sizes
//******************************************
function fjn_thumb_sizes() {
  add_image_size( 'portfolio', 282, 282, true );
}
add_action( 'after_setup_theme', 'fjn_thumb_sizes' );
//******************************************
// full tiny mce editor
//******************************************
function fjn_enable_more_buttons( $buttons ){
	$buttons[] = 'fontselect';
	$buttons[] = 'fontsizeselect';
	$buttons[] = 'styleselect';
	$buttons[] = 'backcolor';
	$buttons[] = 'newdocument';
	$buttons[] = 'cut';
	$buttons[] = 'copy';
	$buttons[] = 'charmap';
	$buttons[] = 'hr';
	$buttons[] = 'visualaid';
	return $buttons;
}
add_filter( 'mce_buttons_3', 'fjn_enable_more_buttons' );
function fjn_formatTinyMCE( $in ){
	$in['wordpress_adv_hidden'] = FALSE;
	return $in;
}
add_filter( 'tiny_mce_before_init', 'fjn_formatTinyMCE' );
//******************************************
// register menu
//******************************************
function fjn_register_menu() {
  register_nav_menu(	'top', __( 'Top Menu', 'fenjoon' ) );
}
add_action( 'init', 'fjn_register_menu' );

function fjn_wp_nav_menu( $loc ){
	$menu = ( is_user_logged_in() ? 'top_member' : 'top' );
	$args = array(
		'theme_location'  => $loc,
		'menu'            => $menu,
		'container'       => 'nav',
		'container_class' => $loc . ' mhidden',
		'container_id'    => $loc . '_menu',
		'menu_class'      => 'menu',
		'menu_id'         => '',
		'echo'            => true,
		'fallback_cb'     => 'wp_page_menu',
		'before'          => '',
		'after'           => '',
		'link_before'     => '',
		'link_after'      => '',
		'items_wrap'      => '<ul class="%2$s">%3$s</ul>',
		'depth'           => 0,
		'walker'          => ''
	);
	wp_nav_menu( $args );
}

function fjn_alter_classes_on_li( $classes, $item, $args ){
  $classes = array_diff( $classes, array( 'menu-item-type-custom', 'menu-item-object-custom', 'menu-item', 'menu-item-type-post_type', 'menu-item-object-page', 'page_item', 'current_page_item' ) );
	//$classes[] = 'icon';
	global $post;
	if( in_array( $post->post_type, $classes ) ) $classes[] = 'current-menu-item';
	return $classes;
}
add_filter( 'nav_menu_css_class', 'fjn_alter_classes_on_li', 1, 3 );
//******************************************
// Custom classes for menu items
//******************************************
function fjn_filter_menu_class( $objects, $args ){
	$ids        = array();
	$parent_ids = array();
	$top_ids    = array();
	foreach ( $objects as $i => $object ){
			if ( 0 == $object->menu_item_parent ){
				$top_ids[$i] = $object;
				continue;
			}
			if ( ! in_array( $object->menu_item_parent, $ids ) ){
				$objects[$i]->classes[] = 'first-menu-item';
				$ids[]          = $object->menu_item_parent;
			} 
			if ( in_array( 'first-menu-item', $object->classes ) )
				continue;
			$parent_ids[$i] = $object->menu_item_parent;
	}
	$sanitized_parent_ids = array_unique( array_reverse( $parent_ids, true ) );
	foreach ( $sanitized_parent_ids as $i => $id )
		$objects[$i]->classes[] = 'last-menu-item';
	return $objects; 
}
add_filter( 'wp_nav_menu_objects', 'fjn_filter_menu_class', 10, 2 );
//******************************************
// Template functions
//******************************************
function fjn_template_query( $params ){
	$args = array(
		'posts_per_page'	=> -1,
		'post_status'			=> 'publish',
		'orderby'					=> 'title',
		'order'						=> 'ASC'
	);
	if( array_key_exists( 'post_type', $params ) ){
		$cpt = $params[ 'post_type' ];
		$args[ 'post_type' ] = $cpt;
		if( 'orders' == $cpt ){
			$args[ 'post_status' ]	= array( 'publish', 'pending' );
			$args[ 'orderby']				= 'date';
			$args[ 'order' ]				= 'DESC';
		}elseif( 'general' == $cpt ){
			$args[ 'tax_query' ]	= array(
				'relation'			=> 'OR',
				array(
					'taxonomy'		=> 'field',
					'field'				=> 'slug',
					'terms'				=> array( 'about', 'difference', 'offered-services', 'unoffered-services', 'responsibility' )
				)
			);
		}
	}
	if( array_key_exists( 'posts_per_page', $params ) ) $args[ 'posts_per_page' ] = $params[ 'posts_per_page' ];
	if( array_key_exists( 'orderby', $params ) ) $args[ 'orderby' ] = $params[ 'orderby' ];
	if( array_key_exists( 'order', $params ) ) $args[ 'order' ] = $params[ 'order' ];
	if( array_key_exists( 'author', $params ) ) $args[ 'author' ] = $params[ 'author' ];
	if( array_key_exists( 'tag', $params ) ) $args[ 'tag' ] = $params[ 'tag' ];
	$the_query = new WP_Query( $args );
	return $the_query;
}

function fjn_messages(){
	$msg[1] = __( 'Order submitted successfully', 'fenjoon' );
	$msg[2] = __( 'Order updated successfully', 'fenjoon' );
	$msg[3] = __( 'Payment item submitted successfully', 'fenjoon' );
	$msg[4] = __( 'Payment item submitted successfully', 'fenjoon' );
	$msg[5] = __( 'Your login was successful', 'fenjoon' );
	$msg[6] = __( 'Your logout was successful', 'fenjoon' );
	$msg[7] = __( 'Your registration was successful', 'fenjoon' );
	return $msg;
}

function fjn_errors(){
	$err[1] = __( 'Title and Content incorrect', 'fenjoon' );
	$err[2] = __( 'Access denied. this operation is not permitted', 'fenjoon' );
	$err[3] = __( 'Order did not submit and error occurred', 'fenjoon' );
	$err[4] = __( 'Unknown error', 'fenjoon' );
	$err[5] = __( 'Item in progress and cant be removed from order any more', 'fenjoon' );
	$err[6] = __( 'Order did not update and error occurred', 'fenjoon' );
	$err[7] = __( 'Date fields are not filled correctly', 'fenjoon' );
	$err[8] = __( 'Pursuit field should be filled correctly', 'fenjoon' );
	$err[9] = __( 'Payment field should be filled correctly', 'fenjoon' );
	$err[10] = __( 'Payment item did not submit and error occurred', 'fenjoon' );
	$err[11] = __( 'Access is restricted to members. Please register or login first', 'fenjoon' );
	$err[12] = __( 'Your login was not successful', 'fenjoon' );
	$err[13] = __( 'You must fill the form completely', 'fenjoon' );
	$err[14] = __( 'Username already exists. Please choose another', 'fenjoon' );
	$err[15] = __( 'Email address already exists. Please choose another', 'fenjoon' );
	return $err;
}

function fjn_msg_reporting( $msg, $err ){
	$output = '<div id="alerts">';
	$content = '';
	$e = $_GET['err'];
	if( !empty( $e ) ){
		$e = explode( '-', $e );
		$e = array_unique( $e );
		foreach( $e as $item ){
			$content .= '<div class="alert tile red p1 size2 mb1">'. $err[$item] .'</div>';
		}
	}
	$m = $_GET['msg'];
	if( !empty( $m ) ){
		$m = explode( '-', $m );
		$m = array_unique( $m );
		foreach( $m as $item ){
			$content .= '<div class="alert tile green p1 size2 mb1">'. $msg[$item] .'</div>';
		}
	}
	$output .= $content . '</div>';
	if( '' != $content ) echo $output;
}
//******************************************
// CPT - General + field taxonomy
//******************************************
function cpt_general(){
	$labels = array(
		'name'                => __( 'General', 'fenjoon' ),
		'singular_name'       => __( 'General', 'fenjoon' ),
		'menu_name'           => __( 'General', 'fenjoon' ),
		'parent_item_colon'   => __( 'Parent General', 'fenjoon' ),
		'all_items'           => __( 'All General', 'fenjoon' ),
		'view_item'           => __( 'View General', 'fenjoon' ),
		'add_new_item'        => __( 'Add New General', 'fenjoon' ),
		'add_new'             => __( 'Add New', 'fenjoon' ),
		'edit_item'           => __( 'Edit General', 'fenjoon' ),
		'update_item'         => __( 'Update General', 'fenjoon' ),
		'search_items'        => __( 'Search General', 'fenjoon' ),
		'not_found'           => __( 'Not found', 'fenjoon' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'fenjoon' ),
	);
	$args = array(
		'label'               => __( 'General', 'fenjoon' ),
		'description'         => __( 'General information for the site', 'fenjoon' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'thumbnail' ),
		'taxonomies'          => array( 'post_tag' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'menu_icon'						=> 'dashicons-admin-home',
		'can_export'          => true,
		'has_archive'         => false,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'post',
	);
	register_post_type( 'general', $args );
}
add_action( 'init', 'cpt_general', 0 );

function fjn_general_field_taxonomy(){
	register_taxonomy(
		'field',
		'general',
		array(
			'labels' => array(
			'name' => __( 'General Field', 'fenjoon' ),
			'add_new_item' => __( 'Add New Field', 'fenjoon' ),
			'new_item_name' => __( 'New Field', 'fenjoon' )
			),
			'show_ui' => true,
			'show_tagcloud' => false,
			'hierarchical' => true
		)
	);
}
add_action( 'init', 'fjn_general_field_taxonomy', 0 );
//******************************************
// custom field column for general cpt
//******************************************
function fjn_set_general_field_columns( $columns ){
    $columns['field'] = __( 'Field', 'fenjoon' );
    return $columns;
}
add_filter( 'manage_edit-general_columns', 'fjn_set_general_field_columns' );
function fjn_general_field_custom_columns( $column, $post_id ){
	switch ( $column ){
	case 'field' :
		$terms = get_the_term_list( $post_id , 'field' , '' , ',' , '' );
		if ( is_string( $terms ) )
			echo $terms;
		else
		    _e( 'Field not set!', 'fenjoon' );
		break;
	}
}
add_action( 'manage_general_posts_custom_column' , 'fjn_general_field_custom_columns', 10, 2 );
//******************************************
// CPT - Portfolio + cat taxonomy
//******************************************
function cpt_portfolio(){
	$labels = array(
		'name'                => __( 'Portfolio', 'fenjoon' ),
		'singular_name'       => __( 'Portfolio', 'fenjoon' ),
		'menu_name'           => __( 'Portfolio', 'fenjoon' ),
		'parent_item_colon'   => __( 'Parent Portfolio', 'fenjoon' ),
		'all_items'           => __( 'All Portfolio', 'fenjoon' ),
		'view_item'           => __( 'View Portfolio', 'fenjoon' ),
		'add_new_item'        => __( 'Add New Portfolio', 'fenjoon' ),
		'add_new'             => __( 'Add New', 'fenjoon' ),
		'edit_item'           => __( 'Edit Portfolio', 'fenjoon' ),
		'update_item'         => __( 'Update Portfolio', 'fenjoon' ),
		'search_items'        => __( 'Search Portfolio', 'fenjoon' ),
		'not_found'           => __( 'Not found', 'fenjoon' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'fenjoon' ),
	);
	$args = array(
		'label'               => __( 'Portfolio', 'fenjoon' ),
		'description'         => __( 'Portfolio items', 'fenjoon' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'thumbnail' ),
		'taxonomies'          => array(),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'menu_icon'						=> 'dashicons-admin-appearance',
		'can_export'          => true,
		'has_archive'         => false,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'post',
	);
	register_post_type( 'portfolio', $args );
}
add_action( 'init', 'cpt_portfolio', 0 );

function fjn_portfolio_cat_taxonomy(){
	register_taxonomy(
		'cat',
		'portfolio',
		array(
			'labels' => array(
			'name' => __( 'Portfolio Cat', 'fenjoon' ),
			'add_new_item' => __( 'Add New Cat', 'fenjoon' ),
			'new_item_name' => __( 'New Cat', 'fenjoon' )
			),
			'show_ui' => true,
			'show_tagcloud' => true,
			'hierarchical' => true
		)
	);
}
add_action( 'init', 'fjn_portfolio_cat_taxonomy', 0 );
//******************************************
// Add Porftfolio metaboxes
//******************************************
function fjn_portfolio_metaboxes( $postType ) {
	$types = array( 'portfolio' );
	if( in_array( $postType, $types ) ){
		add_meta_box(
			'portfolio_metadata',
			__( 'Portfolio Metadata', 'fenjoon' ),
			'create_portfolio_metadata',
			$postType,
			'normal'
		);
	}
}

function create_portfolio_metadata(){
	global $post;
	wp_nonce_field( basename( __FILE__ ), 'portfolio_metadata' );
	$metadata = get_post_meta( $post->ID );
	?>
	<table>
		<tr>
			<td>
				<label for="technology">
					<?php _e( 'technology', 'fenjoon' );?>
				</label>
			</td>
			<td>
				<input type="text" id="technology" name="technology" value="<?php echo $metadata['technology'][0];?>" />
			</td>
		</tr>
		<tr>
			<td>
				<label for="start">
					<?php _e( 'start', 'fenjoon' );?>
				</label>
			</td>
			<td>
				<input type="text" id="start" name="start" value="<?php echo $metadata['start'][0];?>" />
			</td>
		</tr>
		<tr>
			<td>
				<label for="finish">
					<?php _e( 'finish', 'fenjoon' );?>
				</label>
			</td>
			<td>
				<input type="text" id="finish" name="finish" value="<?php echo $metadata['finish'][0];?>" />
			</td>
		</tr>
		<tr>
			<td>
				<label for="workforce">
					<?php _e( 'workforce', 'fenjoon' );?>
				</label>
			</td>
			<td>
				<input type="text" id="workforce" name="workforce" value="<?php echo $metadata['workforce'][0];?>" />
			</td>
		</tr>
		<tr>
			<td>
				<label for="security">
					<?php _e( 'security', 'fenjoon' );?>
				</label>
			</td>
			<td>
				<input type="text" id="security" name="security" value="<?php echo $metadata['security'][0];?>" />
			</td>
		</tr>
	</table><?php
}
add_action( 'add_meta_boxes', 'fjn_portfolio_metaboxes', 10, 1 );

function save_portfolio_metadata(){
	if( empty( $_POST['portfolio_metadata'] ) || !wp_verify_nonce( $_POST['portfolio_metadata'], basename( __FILE__ ) ) ) return;
	global $post;
	$post_id = $post->ID;
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	if ( !current_user_can( 'edit_post', $post_id ) ) return;
	$metadata_arr = array( 'technology', 'start', 'finish', 'workforce', 'security' );
	foreach( $metadata_arr as $metadata ){
		$$metadata = $_POST[ $metadata ];
		if( $$metadata ) {
			update_post_meta( $post_id, $metadata, $$metadata );
		}
	}
}
add_action( 'save_post', 'save_portfolio_metadata' );
//******************************************
// Loginout link to navigation
//******************************************
function fjn_loginout_menu_link( $menu ) {
	if( is_user_logged_in() ){
		$loginout = '<li class="left"><a title="' . __( 'Logout', 'fenjoon' ) . '" href="' . wp_logout_url( site_url( 'login' ) ) . '">' . __( 'Logout', 'fenjoon' ) . '</a></li>';
	}else{
		$loginout = '<li class="left"><a title="' . __( 'Login', 'fenjoon' ) . '" href="' . site_url( 'login' ) . '">' . __( 'Login', 'fenjoon' ) . '</a></li>';
	}
	$menu .= $loginout;
	return $menu;
}
add_filter( 'wp_nav_menu_top_member_items', 'fjn_loginout_menu_link', 10, 2 );
add_filter( 'wp_nav_menu_top_items', 'fjn_loginout_menu_link', 10, 2 );
//******************************************
// Front-end login
//******************************************
function fjn_frontend_login(){
	if( !empty( $_POST ) && !is_admin() ){
		if( empty( $_POST['email'] ) && !empty( $_POST['fjn_nonce'] ) && !empty( $_POST['action'] ) && in_array( $_POST['action'], array( 'login', 'register' ) ) ){
			if( is_user_logged_in() ){
				wp_redirect( site_url( 'orderlist' ) );
				exit;
			}elseif( !empty( $_POST['username'] ) || !empty( $_POST['password'] ) ){
				if( 'login' == $_POST['action'] && wp_verify_nonce( $_POST['fjn_nonce'], 'fjn_submit-login' ) ){
					$user = wp_signon( array( 'user_login' => $_POST['username'], 'user_password' => $_POST['password'], 'remember' => true ), true );
					if( $user && $user->ID ){
						wp_redirect( site_url( 'orderlist' . '?msg=5' ) );   
						exit;
					}else{
						wp_redirect( site_url( 'login' . '?err=12' ) );   
						exit;
					}
				}elseif( 'register' == $_POST['action'] && wp_verify_nonce( $_POST['fjn_nonce'], 'fjn_submit-register' ) ){
					$user_id = username_exists( $_POST['username'] );
					if( !$user_id && false == email_exists( $_POST['useremail'] ) ){
						$user_id = wp_create_user( $_POST['username'], $_POST['password'], $_POST['useremail'] );
						if( $user_id ){
							wp_signon( array( 'user_login' => $_POST['username'], 'user_password' => $_POST['password'], 'remember' => true ), true );
							wp_redirect( site_url( 'orderlist' . '?msg=7' ) );
							exit;
						}else{
							wp_redirect( site_url( 'register' . '?err=4' ) );
							exit;
						}
					}elseif( $user_id ){
						wp_redirect( site_url( 'register' . '?err=14' ) );
						exit;					
					}elseif( false != email_exists( $_POST['useremail'] ) ){
						wp_redirect( site_url( 'register' . '?err=15' ) );
						exit;
					}
				}
			}else{
				wp_redirect( site_url( 'login' . '?err=13' ) );   
				exit;
			}
		}
	}
}
add_action( 'after_setup_theme', 'fjn_frontend_login' );

function fjn_redirect_login_page(){
	$page_viewed = basename($_SERVER['REQUEST_URI']);
	if( strpos( $page_viewed , 'wp-login' ) !== false && strpos( $page_viewed , 'action=logout' ) === false ){
		wp_redirect( site_url( '?err=2' ) );
		exit;  
	}
}
//add_action( 'init', 'fjn_redirect_login_page' );

function fjn_checkRole(){
	if ( !current_user_can( 'manage_options' ) ){
		wp_redirect( site_url( '?err=2' ) );
		exit;
	}
}
add_action( 'admin_init', 'fjn_checkRole' );

function fjn_redirect_user(){
	if( !is_user_logged_in() && is_page_template( 'orderlist.php' ) ){
		wp_redirect( site_url( 'login' ) . '?err=11' );
		exit ();
	}elseif( !is_user_logged_in() && is_page_template( 'single-orders.php' ) ){
		wp_redirect( site_url( 'login' ) . '?err=11' );
		exit ();
	}elseif( is_user_logged_in() && is_page_template( 'page-login.php' ) ){
		wp_redirect( site_url( 'orderlist' ) );
		exit ();
	}
}
add_action( 'template_redirect', 'fjn_redirect_user' ); 

function fjn_logout_page() {
	wp_redirect( site_url( 'login' . '?msg=6' ) );  
	exit;  
}  
add_action( 'wp_logout', 'fjn_logout_page' );
?>
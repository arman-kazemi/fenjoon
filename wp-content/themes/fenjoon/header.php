<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="author" content="fenjoon.net">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
	<meta name="format-detection" content="telephone=no">
	<title><?php bloginfo('name'); ?></title>
	<link rel="shortcut icon" href="<?php echo THEME_URI; ?>/favicon.ico" />
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">
	<?php wp_head(); ?>
</head>
<body>
<header><?php
	global $msg, $err;
	$msg = fjn_messages();
	$err = fjn_errors();
	global $current_user;?>
	<div class="full backblue">
		<div class="wrapper">
			<div class="cols mb0">
				<div class="col col11 mb0">
					<div id="menu_box" class="icon menu ib pl1 vam size30 dhidden"></div><p class="ib ptb1"><?php 
					if( is_user_logged_in() ){
						printf( __( 'Welcome %s.', 'fenjoon' ), $current_user->display_name );
					}else{
						_e( 'Welcome guest', 'fenjoon' );						
					}?></p>
				</div>
			</div>
		</div>
	</div>
	<div class="navigation" role="navigation">
		<div class="wrapper">
			<?php fjn_wp_nav_menu( 'top' );?>
		</div>
	</div>
</header>
<div class="full backblue mhidden">
	<div class="wrapper">
		<div class="cols">
			<div class="col col11">
				<h1 class="ptb4"><?php _e( 'Fenjoon Group Website', 'fenjoon' );?></h1>
			</div>
		</div>
	</div>
</div>
<div class="wrapper"><?php
	fjn_msg_reporting( $msg, $err );?>
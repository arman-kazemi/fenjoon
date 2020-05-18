<?php
/*
Plugin Name: fenjoon
Plugin URI: http://fenjoon.net
Description: Fenjoon Web Design Team
Version: 1.0.0
Author: Fenjoon
Author URI: http://fenjoon.net
Text Domain: fenjoon
Domain Path: /lang
*/
defined('FENJOON_DIR') or define('FENJOON_DIR',  dirname(__FILE__).DIRECTORY_SEPARATOR);
/* =================================================================== */

require_once( FENJOON_DIR . 'functions.php' );
require_once( FENJOON_DIR . 'inc/class-fjn-list-table.php' );
require_once( FENJOON_DIR . 'inc/fjn-task-list.php' );
//******************************************
// Initialize
//******************************************
load_plugin_textdomain( 'fenjoon', false, basename(dirname(__FILE__)).'/lang');
//******************************************
// Add tasks table to database
//******************************************
function fjn_add_tasks_table_to_db(){
	global $wpdb;
	$tasks_table = $wpdb->prefix. 'tasks';
	if( $wpdb->get_var( "SHOW TABLES LIKE '{$tasks_table}'" ) != $tasks_table ){
		$query =
			"CREATE TABLE {$tasks_table} (
			task_id BIGINT(20) UNSIGNED ZEROFILL AUTO_INCREMENT PRIMARY KEY, 
			activity_id SMALLINT(6),
			project_id BIGINT(20),
			editor_id TINYINT(4) ,
			assign_date DATETIME,
			seen_date DATETIME,
			start_date DATETIME,
			done_date DATETIME,
			active BOOLEAN DEFAULT TRUE
			);";
		require_once( ABSPATH. 'wp-admin/includes/upgrade.php' );
		dbDelta( $query );
	}
}
register_activation_hook(__FILE__, 'fjn_add_tasks_table_to_db');
//******************************************
// Add instalments table to database
//******************************************
function fjn_add_instalments_table_to_db(){
	global $wpdb;
	$instalments_table = $wpdb->prefix. 'instalments';
	if( $wpdb->get_var( "SHOW TABLES LIKE '{$instalments_table}'" ) != $instalments_table ){
		$query =
			"CREATE TABLE {$instalments_table} (
			id BIGINT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			project_id BIGINT(20),
			concern TINYINT(4),
			amount DECIMAL(9,0),
			due DATE,
			passed BOOLEAN DEFAULT 0
		);";
		require_once( ABSPATH. 'wp-admin/includes/upgrade.php' );
		dbDelta( $query );
	}
}
register_activation_hook(__FILE__, 'fjn_add_instalments_table_to_db');
//******************************************
// Add payments table to database
//******************************************
function fjn_add_payments_table_to_db(){
	global $wpdb;
	$payments_table = $wpdb->prefix. 'payments';
	if( $wpdb->get_var( "SHOW TABLES LIKE '{$payments_table}'" ) != $payments_table ){
		$query =
			"CREATE TABLE {$payments_table} (
			id BIGINT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			project_id BIGINT(20),
			pay DECIMAL(9,0),
			date DATE,
			pursuit DECIMAL(10,0),
			approved BOOLEAN DEFAULT 0,
			note VARCHAR(50)
			);";
		require_once( ABSPATH. 'wp-admin/includes/upgrade.php' );
		dbDelta( $query );
	}
}
register_activation_hook(__FILE__, 'fjn_add_payments_table_to_db');
?>
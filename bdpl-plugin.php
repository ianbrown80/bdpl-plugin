<?php
/*
Plugin Name: BDPL
Plugin URI: http://bdpl.co.uk
Description: Plugin for managing the fixtures, results, knockouts and league tables for Birstal and Distric Pool League
Version: 1.0
Author: Ian Brown
Author URI: http://www.browniandev.co.uk
Text Domain: bdpl-plugin
License: GPLv2
*/
include_once( plugin_dir_path( __FILE__ ) . "includes" . DIRECTORY_SEPARATOR . "layouts.php" );
include_once( plugin_dir_path( __FILE__ ) . "includes" . DIRECTORY_SEPARATOR . "functions.php" );

global $bdlp_ammendments_db_version;
global $bdlp_fixtures_db_version;
global $bdlp_teams_db_version;

$bdlp_ammendments_db_version = '1.0';
$bdlp_fixtures_db_version = '1.0';
$bdlp_teams_db_version = '1.0';

add_action( 'init', 'bdpl_register_custom_post_types', 0 );
add_action( 'init', 'bdpl_remove_fields', 0 );
add_action( 'load-post.php', 'bdpl_meta_boxes_setup' );
add_action( 'load-post-new.php', 'bdpl_meta_boxes_setup' );
add_action( 'admin_menu', 'bdpl_create_menu' );

register_activation_hook( __FILE__, 'bdpl_install' );


<?php

function bdpl_install() {

  global $wpdb;
  global $bdpl_ammendments_db_version;
  global $bdpl_fixtures_db_version;
	global $bdpl_teams_db_version;

	$ammendments_table = $wpdb->prefix . 'ammendments';
  $fixtures_table = $wpdb->prefix . 'fixtures';
  $teams_table = $wpdb->prefix . 'teams';
	$charset_collate = $wpdb->get_charset_collate();

	$ammendments_sql = "CREATE TABLE $ammendments_table (
		    ammendment_id TINYINT(3) NOT NULL AUTO_INCREMENT,
        team TINYINT(3) NOT NULL,
        points TINYINT(3) NOT NULL,
        add_delete BOOLEAN NOT NULL,
        PRIMARY KEY (ammendment_id)
	      ) $charset_collate;";

    $fixtures_sql = "CREATE TABLE $fixtures_table (
		    fixture_id TINYINT(3) NOT NULL AUTO_INCREMENT,
        date DATE NOT NULL,
		    home_team TINYINT(3) NOT NULL,
		    away_team TINYINT(3) NOT NULL,
		    home_score TINYINT(3) NOT NULL,
		    away_score TINYINT(3) NOT NULL,
        PRIMARY KEY (fixture_id)
	      ) $charset_collate;";

    $teams_sql = "CREATE TABLE $teams_table (
		    team_id TINYINT(3) NOT NULL AUTO_INCREMENT,
        fixture_ref TINYINT(3) NOT NULL,
		    team_name tinytext NOT NULL,
		    played TINYINT(3) DEFAULT 0 NOT NULL,
		    won TINYINT(3) DEFAULT 0 NOT NULL,
		    deducted TINYINT(3) DEFAULT 0 NOT NULL,
		    lost TINYINT(3) DEFAULT 0 NOT NULL,
        points_for TINYINT(3) DEFAULT 0 NOT NULL,
        points_against TINYINT(3) DEFAULT 0 NOT NULL,
        b TINYINT(3) DEFAULT 0 NOT NULL,
        points TINYINT(3) DEFAULT 0 NOT NULL,
        division TINYINT(3) DEFAULT 0 NOT NULL,
        position TINYINT(3) DEFAULT 0 NOT NULL,
		    average float DEFAULT 0 NOT NULL,
        pub_id TINYINT(3) NOT NULL,
        PRIMARY KEY (team_id)
	      ) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

	dbDelta( $ammendments_sql );
  dbDelta( $fixtures_sql );
  dbDelta( $teams_sql );

	add_option( 'bdpl_ammendments_db_version', $bdpl_ammendments_db_version );
  add_option( 'bdpl_fixtures_db_version', $bdpl_fixtures_db_version );
  add_option( 'bdpl_teams_db_version', $bdpl_teams_db_version );

  file_put_contents( __DIR__ . '/my_log.txt', ob_get_contents() );

}

/**
 * Custom Post Type Registration 
 */   

function bdpl_register_custom_post_types() {

  register_post_type( 'contacts', 
    array(
      'labels' => array( 
        'name' => 'Contacts',
        'singular_name' => 'Contact',
        'add_new_item' => 'Add new contact',
        'edit_item' => 'Edit contact',
        'new_item' => 'New contact',
        'view_item' => 'View contact',
        'all_items' => 'All contacts',
      ),
      'public' => true,
    )
  );

  register_post_type( 'teams', 
    array(
      'labels' => array( 
        'name' => 'Teams',
        'singular_name' => 'Team',
        'add_new_item' => 'Add new team',
        'edit_item' => 'Edit team',
        'new_item' => 'New team',
        'view_item' => 'View team',
        'all_items' => 'All team',
      ),
      'public' => true,
    )
  );

}


/**
 * Remove uneeded post fields
 */

function bdpl_remove_fields() {

  remove_post_type_support( 'contacts', 'title' );
  remove_post_type_support( 'contacts', 'editor' );
  remove_post_type_support( 'contacts', 'author' );
  remove_post_type_support( 'contacts', 'excerpt' );
  remove_post_type_support( 'contacts', 'comments' );
  remove_post_type_support( 'contacts', 'trackbacks' );
  remove_post_type_support( 'contacts', 'revisions' );
  remove_post_type_support( 'contacts', 'page-attributes' );
  remove_post_type_support( 'contacts', 'post-formats' );

  remove_post_type_support( 'teams', 'editor' );
  remove_post_type_support( 'teams', 'author' );
  remove_post_type_support( 'teams', 'excerpt' );
  remove_post_type_support( 'teams', 'comments' );
  remove_post_type_support( 'teams', 'trackbacks' );
  remove_post_type_support( 'teams', 'revisions' );
  remove_post_type_support( 'teams', 'page-attributes' );
  remove_post_type_support( 'teams', 'post-formats' );

}

/**
 * Set up Meta Boxes for the Custom Posts
 */


function bdpl_meta_boxes_setup() {

  add_action( 'add_meta_boxes', 'bdpl_add_meta_boxes' );
  add_action( 'save_post', 'bdpl_save_meta', 10, 2 );

}

function bdpl_add_meta_boxes() {

  add_meta_box(
    'contact-name',      
    'Contact Name',  
    'bdpl_contact_name_meta_box',  
    'contacts',         
    'normal',        
    'default'        
  );

  add_meta_box(
    'contact-number',      
    'Contact Number',  
    'bdpl_contact_number_meta_box',  
    'contacts',         
    'normal',        
    'default'        
  );

  add_meta_box(
    'contact-role',      
    'Contact Role',  
    'bdpl_contact_role_meta_box',  
    'contacts',         
    'normal',        
    'default'        
  );

  add_meta_box(
    'team-image',      
    'Picture',  
    'bdpl_team_image_meta_box',  
    'teams',         
    'normal',        
    'default'        
  );

  add_meta_box(
    'team-address-firstline',      
    'Address Line 1' ,  
    'bdpl_team_address_firstline_meta_box',  
    'teams',         
    'normal',        
    'default'        
  );

  add_meta_box(
    'team-address-secondline',      
    'Address Line 2' ,  
    'bdpl_team_address_secondline_meta_box',  
    'teams',         
    'normal',        
    'default'        
  );

  add_meta_box(
    'team-town',      
    'Town',  
    'bdpl_team_town_meta_box',  
    'teams',         
    'normal',        
    'default'        
  );

  add_meta_box(
    'team-postcode',      
    'Post Code',  
    'bdpl_team_postcode_meta_box',  
    'teams',         
    'normal',        
    'default'        
  );

  add_meta_box(
    'team-number',      
    'Telephone',  
    'bdpl_team_telephone_meta_box',  
    'teams',         
    'normal',        
    'default'        
  );

  add_meta_box(
    'team-website',      
    'Website',  
    'bdpl_team_website_meta_box',  
    'teams',         
    'normal',        
    'default'        
  );

  add_meta_box(
    'team-email',      
    'Email',  
    'bdpl_team_email_meta_box',  
    'teams',         
    'normal',        
    'default'        
  );

  add_meta_box(
    'team-landlord',      
    'Landlord',  
    'bdpl_team_landlord_meta_box',  
    'teams',         
    'normal',        
    'default'        
  );

  add_meta_box(
    'team-captain-a',      
    'A Team Captain',  
    'bdpl_team_captain_a_meta_box',  
    'teams',         
    'normal',        
    'default'        
  );

  add_meta_box(
    'team-captain-b',      
    'B Team Captain',  
    'bdpl_team_captain_b_meta_box',  
    'teams',         
    'normal',        
    'default'        
  );

}


function bdpl_save_meta( $post_id, $post ) {

  if ( !isset( $_POST['contact_nonce'] ) || !wp_verify_nonce( $_POST['contact_nonce'], basename( __FILE__ ) ) )
    if (!isset( $_POST['team_nonce'] ) || !wp_verify_nonce( $_POST['team_nonce'], basename( __FILE__ ) ) )
      return $post_id;

  $post_type = get_post_type_object( $post->post_type );

  if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
    return $post_id;

  $new_contact_name_value = ( isset( $_POST['contact-name'] ) ? sanitize_text_field( $_POST['contact-name'] ) : '' );
  $new_contact_number_value = ( isset( $_POST['contact-number'] ) ? sanitize_text_field( $_POST['contact-number'] ) : '' );
  $new_contact_role_value = ( isset( $_POST['contact-role'] ) ? sanitize_text_field( $_POST['contact-role'] ) : '' );
  $new_team_image_value = ( isset( $_POST['team-image'] ) ? sanitize_text_field( $_POST['team-image'] ) : '' );
  $new_team_address_firstline_value = ( isset( $_POST['team-address-firstline'] ) ? sanitize_text_field( $_POST['team-address-firstline'] ) : '' );
  $new_team_address_secondline_value = ( isset( $_POST['team-address-secondline'] ) ? sanitize_text_field( $_POST['team-address-secondline'] ) : '' );
  $new_team_town_value = ( isset( $_POST['team-town'] ) ? sanitize_text_field( $_POST['team-town'] ) : '' );
  $new_team_postcode_value = ( isset( $_POST['team-postcode'] ) ? sanitize_text_field( $_POST['team-postcode'] ) : '' );
  $new_team_telephone_value = ( isset( $_POST['team-telephone'] ) ? sanitize_text_field( $_POST['team-telephone'] ) : '' );
  $new_team_website_value = ( isset( $_POST['team-website'] ) ? sanitize_text_field( $_POST['team-website'] ) : '' );
  $new_team_email_value = ( isset( $_POST['team-email'] ) ? sanitize_text_field( $_POST['team-email'] ) : '' );
  $new_team_landlord_value = ( isset( $_POST['team-landlord'] ) ? sanitize_text_field( $_POST['team-landlord'] ) : '' );
  $new_team_captain_a_value = ( isset( $_POST['team-captain-a'] ) ? sanitize_text_field( $_POST['team-captain-a'] ) : '' );
  $new_team_captain_b_value = ( isset( $_POST['team-captain-b'] ) ? sanitize_text_field( $_POST['team-captain-b'] ) : '' );
  
  $meta_contact_name_key = 'contact-name';
  $meta_contact_number_key = 'contact-number';
  $meta_contact_role_key = 'contact-role';
  $meta_team_image_key = 'team-image';
  $meta_team_address_firstline_key = 'team-address-firstline';
  $meta_team_address_secondline_key = 'team-address-secondline';
  $meta_team_town_key = 'team-town';
  $meta_team_postcode_key = 'team-postcode';
  $meta_team_telephone_key = 'team-telephone';
  $meta_team_website_key = 'team-website';
  $meta_team_email_key = 'team-email';
  $meta_team_landlord_key = 'team-landlord';
  $meta_team_captain_a_key = 'team-captain-a';
  $meta_team_captain_b_key = 'team-captain-b';

  $meta_contact_name_value = get_post_meta( $post_id, $meta_contact_name_key, true );
  $meta_contact_number_value = get_post_meta( $post_id, $meta_contact_number_key, true );
  $meta_contact_role_value = get_post_meta( $post_id, $meta_contact_role_key, true );
  $meta_team_image_value = get_post_meta( $post_id, $meta_team_image_key, true );
  $meta_team_address_firstline_value = get_post_meta( $post_id, $meta_team_address_firstline_key, true );
  $meta_team_address_secondline_value = get_post_meta( $post_id, $meta_team_address_secondline_key, true );
  $meta_team_town_value = get_post_meta( $post_id, $meta_team_town_key, true );
  $meta_team_postcode_value = get_post_meta( $post_id, $meta_team_postcode_key, true );
  $meta_team_telephone_value = get_post_meta( $post_id, $meta_team_telephone_key, true );
  $meta_team_website_value = get_post_meta( $post_id, $meta_team_website_key, true );
  $meta_team_email_value = get_post_meta( $post_id, $meta_team_email_key, true );
  $meta_team_landlord_value = get_post_meta( $post_id, $meta_team_landlord_key, true );
  $meta_team_captain_a_value = get_post_meta( $post_id, $meta_team_captain_a_key, true );
  $meta_team_captain_b_value = get_post_meta( $post_id, $meta_team_captain_b_key, true );

  if ( $new_contact_name_value && '' == $meta_contact_name_value )
    add_post_meta( $post_id, $meta_contact_name_key, $new_contact_name_value, true );
  elseif ( $new_contact_name_value && $new_contact_name_value != $meta_contact_name_value )
    update_post_meta( $post_id, $meta_contact_name_key, $new_contact_name_value );
  elseif ( '' == $new_contact_name_value && $meta_contact_name_value )
    delete_post_meta( $post_id, $meta_contact_name_key, $meta_contact_name_value );

  if ( $new_contact_number_value && '' == $meta_contact_number_value )
    add_post_meta( $post_id, $meta_contact_number_key, $new_contact_number_value, true );
  elseif ( $new_contact_number_value && $new_contact_number_value != $meta_contact_number_value )
    update_post_meta( $post_id, $meta_contact_number_key, $new_contact_number_value );
  elseif ( '' == $new_contact_number_value && $meta_contact_number_value )
    delete_post_meta( $post_id, $meta_contact_number_key, $meta_contact_number_value );

  if ( $new_contact_role_value && '' == $meta_contact_role_value )
    add_post_meta( $post_id, $meta_contact_role_key, $new_contact_role_value, true );
  elseif ( $new_contact_role_value && $new_contact_role_value != $meta_contact_role_value )
    update_post_meta( $post_id, $meta_contact_role_key, $new_contact_role_value );
  elseif ( '' == $new_contact_role_value && $meta_contact_role_value )
    delete_post_meta( $post_id, $meta_contact_role_key, $meta_contact_role_value );

  if ( $new_team_image_value && '' == $meta_team_image_value )
    add_post_meta( $post_id, $meta_team_image_key, $new_team_image_value, true );
  elseif ( $new_team_image_value && $new_team_image_value != $meta_team_image_value )
    update_post_meta( $post_id, $meta_team_image_key, $new_team_image_value );
  elseif ( '' == $new_team_image_value && $meta_team_image_value )
    delete_post_meta( $post_id, $meta_team_image_key, $meta_team_image_value );

  if ( $new_team_address_firstline_value && '' == $meta_team_address_firstline_value )
    add_post_meta( $post_id, $meta_team_address_firstline_key, $new_team_address_firstline_value, true );
  elseif ( $new_team_address_firstline_value && $new_team_address_firstline_value != $meta_team_address_firstline_value )
    update_post_meta( $post_id, $meta_team_address_firstline_key, $new_team_address_firstline_value );
  elseif ( '' == $new_team_address_firstline_value && $meta_team_address_firstline_value )
    delete_post_meta( $post_id, $meta_team_address_firstline_key, $meta_team_address_firstline_value );

  if ( $new_team_address_secondline_value && '' == $meta_team_address_secondline_value )
    add_post_meta( $post_id, $meta_team_address_secondline_key, $new_team_address_secondline_value, true );
  elseif ( $new_team_address_secondline_value && $new_team_address_secondline_value != $meta_team_address_secondline_value )
    update_post_meta( $post_id, $meta_team_address_secondline_key, $new_team_address_secondline_value );
  elseif ( '' == $new_team_address_secondline_value && $meta_team_address_secondline_value )
    delete_post_meta( $post_id, $meta_team_address_secondline_key, $meta_team_address_secondline_value );

  if ( $new_team_town_value && '' == $meta_team_town_value )
    add_post_meta( $post_id, $meta_team_town_key, $new_team_town_value, true );
  elseif ( $new_team_town_value && $new_team_town_value != $meta_team_town_value )
    update_post_meta( $post_id, $meta_team_town_key, $new_team_town_value );
  elseif ( '' == $new_team_town_value && $meta_team_town_value )
    delete_post_meta( $post_id, $meta_team_town_key, $meta_team_town_value );

  if ( $new_team_postcode_value && '' == $meta_team_postcode_value )
    add_post_meta( $post_id, $meta_team_postcode_key, $new_team_postcode_value, true );
  elseif ( $new_team_postcode_value && $new_team_postcode_value != $meta_team_postcode_value )
    update_post_meta( $post_id, $meta_team_postcode_key, $new_team_postcode_value );
  elseif ( '' == $new_team_postcode_value && $meta_team_postcode_value )
    delete_post_meta( $post_id, $meta_team_postcode_key, $meta_team_postcode_value );

  if ( $new_team_telephone_value && '' == $meta_team_telephone_value )
    add_post_meta( $post_id, $meta_team_telephone_key, $new_team_telephone_value, true );
  elseif ( $new_team_telephone_value && $new_team_telephone_value != $meta_team_telephone_value )
    update_post_meta( $post_id, $meta_team_telephone_key, $new_team_telephone_value );
  elseif ( '' == $new_team_telephone_value && $meta_team_telephone_value )
    delete_post_meta( $post_id, $meta_team_telephone_key, $meta_team_telephone_value );

  if ( $new_team_website_value && '' == $meta_team_website_value )
    add_post_meta( $post_id, $meta_team_website_key, $new_team_website_value, true );
  elseif ( $new_team_website_value && $new_team_website_value != $meta_team_website_value )
    update_post_meta( $post_id, $meta_team_website_key, $new_team_website_value );
  elseif ( '' == $new_team_website_value && $meta_team_website_value )
    delete_post_meta( $post_id, $meta_team_website_key, $meta_team_website_value );

  if ( $new_team_email_value && '' == $meta_team_email_value )
    add_post_meta( $post_id, $meta_team_email_key, $new_team_email_value, true );
  elseif ( $new_team_email_value && $new_team_email_value != $meta_team_email_value )
    update_post_meta( $post_id, $meta_team_email_key, $new_team_email_value );
  elseif ( '' == $new_team_email_value && $meta_team_email_value )
    delete_post_meta( $post_id, $meta_team_email_key, $meta_team_email_value );

  if ( $new_team_landlord_value && '' == $meta_team_landlord_value )
    add_post_meta( $post_id, $meta_team_landlord_key, $new_team_landlord_value, true );
  elseif ( $new_team_landlord_value && $new_team_landlord_value != $meta_team_landlord_value )
    update_post_meta( $post_id, $meta_team_landlord_key, $new_team_landlord_value );
  elseif ( '' == $new_team_landlord_value && $meta_team_landlord_value )
    delete_post_meta( $post_id, $meta_team_landlord_key, $meta_team_landlord_value );

  if ( $new_team_captain_a_value && '' == $meta_team_captain_a_value )
    add_post_meta( $post_id, $meta_team_captain_a_key, $new_team_captain_a_value, true );
  elseif ( $new_team_captain_a_value && $new_team_captain_a_value != $meta_team_captain_a_value )
    update_post_meta( $post_id, $meta_team_captain_a_key, $new_team_captain_a_value );
  elseif ( '' == $new_team_captain_a_value && $meta_team_captain_a_value )
    delete_post_meta( $post_id, $meta_team_captain_a_key, $meta_team_captain_a_value );

  if ( $new_team_captain_b_value && '' == $meta_team_captain_b_value )
    add_post_meta( $post_id, $meta_team_captain_b_key, $new_team_captain_b_value, true );
  elseif ( $new_team_captain_b_value && $new_team_captain_b_value != $meta_team_captain_b_value )
    update_post_meta( $post_id, $meta_team_captain_b_key, $new_team_captain_b_value );
  elseif ( '' == $new_team_captain_b_value && $meta_team_captain_b_value )
    delete_post_meta( $post_id, $meta_team_captain_b_key, $meta_team_captain_b_value );

}

function bdpl_create_menu() {

  add_menu_page( 'Birstall & District Pool League', 'BDPL', 
    'manage_options', 'bdpl_menu', 'bdpl_main_plugin_page', 
    plugins_url( '/images/wordpress.png', __FILE__ ), 1 );

  add_submenu_page( 'bdpl_menu', 'Team Managment', 'Teams', 
    'manage_options',  'bdpl_team_management', 'bdpl_team_management' );

  add_submenu_page( 'bdpl_menu', 'Fixtures', 'Fixtures', 
    'manage_options',  'bdpl_fixtures', 'bdpl_fixtures' );

  add_submenu_page( 'bdpl_menu', 'Ammendments', 'Ammendments', 
    'manage_options',  'bdpl_ammendments', 'bdpl_ammendments' );

}

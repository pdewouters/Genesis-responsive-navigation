<?php
/*
Plugin Name: Genesis Responsive menu
Plugin URI: http://wpconsult.net/genesis-responsive-menu
Description: Responsive Multilevel navigation menu because dropdowns suck.
Version: 1.0
Author: Paul de Wouters
Author URI: http://wpconsult.net
License: GPLv2
*/

/*  Copyright 2011  Paul de Wouters - WpConsult

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/* setup function on plugins_loaded hook */
add_action( 'plugins_loaded','gsrm_responsive_menu_setup' );

function gsrm_responsive_menu_setup(){
    /* Set constant path to the plugin directory. */
    define( 'GSRM_DIR', plugin_dir_path( __FILE__ ) );

    /* Set constant path to the plugin URL. */
    define( 'GSRM_URL', plugin_dir_url( __FILE__ ) ); 
    
    if ( is_admin() ) {

        /* Load translations. */
        load_plugin_textdomain( 'gsrm', false, 'genesis-responsive-menu/languages' );

        /* Load the plugin's admin file. */
        //require_once( GSRM_DIR . 'admin.php' );
    }

    else {
        add_action( 'genesis_theme_settings_metaboxes', 'gsrm_remove_metaboxes' );        
        add_action('wp_enqueue_scripts', 'gsrm_load_scripts_styles');
        require_once 'menu.php';
    }    
}


/* Check WordPress version compatibility */

register_activation_hook( __FILE__,'gsrm_install' );

function gsrm_install(){
    if( version_compare( get_bloginfo( 'version' ),'3.0.0','<' ) ){
        deactivate_plugins( basename( __FILE__ ) );
    }
}

register_activation_hook( __FILE__, 'gsrm_genesis_layout_extras_activation_check' );
/**
 * Checks for activated Genesis Framework and its minimum version before allowing plugin to activate
 *
 * @author Nathan Rice
 * @uses ddw_genesis_layout_extras_truncate()
 * @since 0.1
 * @version 1.1
 */
function gsrm_genesis_layout_extras_activation_check() {

    $latest = '1.8';

    $theme_info = get_theme_data( get_template_directory() . '/style.css' );

    if ( basename( get_template_directory() ) != 'genesis' ) {
            deactivate_plugins( plugin_basename( __FILE__ ) );  // Deactivate ourself
            wp_die( sprintf( __( 'Sorry, you can&rsquo;t activate unless you have installed the %1$sGenesis Framework%2$s', 'wprm' ), '<a href="http://wpconsult.net/genesis-framework/" target="_new">', '</a>' ) );
    }

    $version = gsrm_truncate( $theme_info['Version'], 3 );

    if ( version_compare( $version, $latest, '<' ) ) {
            deactivate_plugins( plugin_basename( __FILE__ ) );  // Deactivate ourself
            wp_die( sprintf( __( 'Sorry, you can&rsquo;t activate without %1$sGenesis Framework %2$s%3$s or greater', 'wprm' ), '<a href="http://wpconsult.net/genesis-framework/" target="_new">', $latest, '</a>' ) );
    }
}




/* For functions that need WordPress to be completely ready, init hook */
add_action( 'init', 'gsrm_modify_genesis_settings' );

/**
 * Short description
 *
 * Longer more detailed description
 *
 * @param type $varname1 Description
 * @param type $varname2 Description
 * @return type Description
*/
function gsrm_modify_genesis_settings() {
    // remove Genesis metaboxes
    add_action( 'genesis_theme_settings_metaboxes', 'gsrm_remove_metaboxes' );
         // disable primary and subnav
        remove_action( 'genesis_after_header', 'genesis_do_nav' );
        remove_action( 'genesis_after_header', 'genesis_do_subnav' );   
}    

function gsrm_remove_metaboxes( $_genesis_theme_settings_pagehook ) {
    //Remove navigation metaboxes
    remove_meta_box( 'genesis-theme-settings-nav', $_genesis_theme_settings_pagehook, 'main' );
    
}

function gsrm_load_scripts_styles(){
    
    //CSS
    wp_enqueue_style('gsrm-css',  GSRM_URL . '/menu.css');
    
    //JS
    //wp_enqueue_script('breakpoints', GSRM_URL . '/breakpoints.js',array('jquery'), false,true);
    wp_enqueue_script('gsrm-js', GSRM_URL . '/gsrm.js',array('jquery'), false,true);
}

/**
 * Used to cutoff a string to a set length if it exceeds the specified length
 *
 * @author Nick Croft
 * @link http://designsbynickthegeek.com/
 *
 * @since 0.1
 * @version 0.2
 * @param string $str Any string that might need to be shortened
 * @param string $length Any whole integer
 * @return string
 */
function gsrm_truncate( $str, $length=10 ) {

	if ( strlen( $str ) > $length ) {
		return substr( $str, 0, $length );

	} else {
		$res = $str;
	}

	return $res;
}
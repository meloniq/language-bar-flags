<?php
/*
Plugin Name: Language Bar Flags
Plugin URI: https://blog.meloniq.net/2011/11/28/language-bar-flags/
Description: Replace or disable standard WordPress bar in the top of website and display similar bar but with configurable language flags to other language versions of Your website.

Version: 1.2.0

Author: MELONIQ.NET
Author URI: https://blog.meloniq.net
Text Domain: language-bar-flags
Domain Path: /languages
*/


/**
 * Avoid calling file directly.
 */
if ( ! function_exists( 'add_action' ) ) {
	die( 'Whoops! You shouldn\'t be doing that.' );
}


/**
 * Plugin version and textdomain constants.
 */
define( 'LANGBF_VERSION', '1.2.0' );
define( 'LANGBF_TD', 'language-bar-flags' );


/**
 * Process actions on plugin activation.
 */
register_activation_hook( plugin_basename( __FILE__ ), 'langbf_activate' );


/**
 * Load Text-Domain.
 */
load_plugin_textdomain( LANGBF_TD, false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );


/**
 * Load Countries arrays.
 */
include_once( dirname( __FILE__ ) . '/includes/countries.php' );


/**
 * Initialize admin page.
 */
require_once( dirname( __FILE__ ) . '/includes/settings.php' );
new LANGBF_Settings();


/**
 * Initialize frontend renderer.
 */
require_once( dirname( __FILE__ ) . '/includes/frontend.php' );
new LANGBF_Frontend();


/**
 * Action on plugin activate.
 *
 * @return void
 */
function langbf_activate() {
	// install default options
	langbf_install_options();
}


/**
 * Install default options.
 *
 * @return void
 */
function langbf_install_options() {

	$previous_version = get_option( 'langbf_db_version' );

	// fresh install
	if ( ! $previous_version ) {
		$domain = str_replace( 'http://www.', '', home_url( '/' ) );
		$domain = str_replace( 'https://www.', '', $domain );
		$domain = str_replace( 'http://', '', $domain );
		$domain = str_replace( 'https://', '', $domain );

		$url_prefix = 'http://www.';

		$active_langs = array();
		$active_langs['pl']['url'] = $url_prefix . 'pl.' . $domain;
		$active_langs['pl']['active'] = 'yes';
		$active_langs['uk']['url'] = $url_prefix . 'uk.' . $domain;
		$active_langs['uk']['active'] = 'yes';
		$active_langs['ie']['url'] = $url_prefix . 'ie.' . $domain;
		$active_langs['ie']['active'] = 'yes';

		update_option( 'langbf_active', 'yes' );
		update_option( 'langbf_langs', $active_langs );

		update_option( 'langbf_disable_wpbar', 'yes' );
		update_option( 'langbf_new_window', 'no' );
		update_option( 'langbf_position', 'top' );
		update_option( 'langbf_side', 'left' );
	}

	// Update DB version
	update_option( 'langbf_db_version', LANGBF_VERSION );
	delete_option( 'langbf_announcement' );
}


/**
 * Load WP-CLI command.
 *
 * @return void
 */
function langbf_load_wp_cli() {
	if ( ! defined( 'WP_CLI' ) || ! WP_CLI ) {
		return;
	}

	require_once( dirname( __FILE__ ) . '/wp-cli.php' );
	\WP_CLI::add_command( 'langbf', 'LangBF_WP_CLI_Command' );
}
add_action( 'init', 'langbf_load_wp_cli' );


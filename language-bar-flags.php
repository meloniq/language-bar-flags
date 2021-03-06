<?php
/*
Plugin Name: Language Bar Flags
Plugin URI: https://blog.meloniq.net/2011/11/28/language-bar-flags/
Description: Replace or disable standard WordPress bar in the top of website and display similar bar but with configurable language flags to other language versions of Your website.

Version: 1.1.1

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
define( 'LANGBF_VERSION', '1.1.1' );
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
include_once( dirname( __FILE__ ) . '/countries.php' );


/**
 * Initialize admin menu.
 */
if ( is_admin() ) {
	add_action( 'admin_menu', 'langbf_add_menu_links' );
}


/**
 * Load front-end scripts.
 *
 * @return void
 */
function langbf_load_scripts() {
	wp_enqueue_script( 'langbf_bootstrap-js-bundle', plugins_url( '/js/bootstrap.bundle.min.js', __FILE__ ), array( 'jquery' ), '5.0.1' );
}
add_action( 'wp_enqueue_scripts', 'langbf_load_scripts' );


/**
 * Load back-end scripts.
 *
 * @return void
 */
function langbf_load_admin_scripts() {
	wp_enqueue_script( 'jquery-ui-tabs' );
}
add_action( 'admin_enqueue_scripts', 'langbf_load_admin_scripts' );


/**
 * Load front-end styles.
 *
 * @return void
 */
function langbf_load_styles() {
	wp_enqueue_style( 'langbf_bootstrap-css', plugins_url( '/css/bootstrap.min.css', __FILE__ ), array(), '5.0.1' );

	wp_register_style( 'langbf_style', plugins_url( 'style.css', __FILE__ ), array(), LANGBF_VERSION );
	wp_enqueue_style( 'langbf_style' );
}
add_action( 'wp_enqueue_scripts', 'langbf_load_styles' );


/**
 * Load back-end styles.
 *
 * @return void
 */
function langbf_load_admin_styles() {
	wp_register_style( 'langbf_admin_style', plugins_url( 'admin-style.css', __FILE__ ), array(), LANGBF_VERSION );
	wp_enqueue_style( 'langbf_admin_style' );
}
add_action( 'admin_enqueue_scripts', 'langbf_load_admin_styles' );


/**
 * Print code in footer.
 *
 * @return void
 */
function langbf_load_html() {

	if ( get_option( 'langbf_active' ) != 'yes' ) {
		return;
	}

	$side_class = ( get_option( 'langbf_side' ) == 'left' ) ? 'langbf_left' : 'langbf_right';
	$target     = ( get_option( 'langbf_new_window' ) == 'yes' ) ? 'target="_blank"' : '';
	$placement  = ( get_option( 'langbf_position' ) == 'top' ) ? 'bottom' : 'top';
	$bar_title  = get_option( 'langbf_title' );

	$langs = get_option( 'langbf_langs' );
	$native_names = langbf_get_countries( 'all', 'native' );
	$output = '';
	foreach ( $native_names as $code => $country ) {
		if ( isset( $langs[ $code ]['active'] ) && $langs[ $code ]['active'] == 'yes' ) {
			if ( ! empty( $langs[ $code ]['country'] ) ) {
				$country = $langs[ $code ]['country'];
			}
			$output .= '<li><a href="' . esc_attr( $langs[ $code ]['url'] ) . '" ' . $target . ' data-bs-toggle="tooltip" data-bs-placement="' . esc_attr( $placement ) . '" data-bs-title="' . esc_attr( $country ) . '" class="langbf_' . $code . '">' . esc_html( $country ) . '</a></li>';
		}
	}
?>
	<div id="langbf_bar">
		<div class="langbf_links">
			<div class="<?php echo $side_class; ?>">
				<?php if ( ! empty( $bar_title ) ) { echo '<span class="langbf_title">' . esc_html( $bar_title ) . '</span>'; } ?>
				<ul>
					<?php echo $output; ?>
				</ul>
			</div>
		</div>
	</div><!-- #langbf_bar -->
<?php
}
add_action( 'wp_footer', 'langbf_load_html' );


/**
 * Print css in footer.
 *
 * @return void
 */
function langbf_load_css() {
	if ( get_option( 'langbf_active' ) != 'yes' ) {
		return;
	}

	if ( get_option( 'langbf_position' ) == 'top' ) {

		if ( is_admin_bar_showing() ) {
?>
			<style type="text/css">
			html {
				margin-top: 52px !important;
			}
			* html body { 
				margin-top: 52px !important;
			}
			#langbf_bar {
				top: 32px !important;
			}
			@media screen and ( max-width: 782px ) {
				html {
					margin-top: 72px !important;
				}
				* html body { 
					margin-top: 72px !important;
				}
				#langbf_bar {
					top: 46px !important;
					z-index: 500 !important;
				}
			}
			</style>
<?php
		} else {
?>
			<style type="text/css">
			html {
				margin-top: 26px !important;
			}
			* html body { 
				margin-top: 26px !important;
			}
			#langbf_bar {
				top: 0px !important;
			}
			</style>
<?php
		}
?>
<?php
	} else {
?>
		<style type="text/css">
		html {
			padding-bottom: 26px !important;
		}
		#langbf_bar {
			top: auto !important;
			bottom: 0px !important;
		}
		</style>
<?php
	}
}
add_action( 'wp_footer', 'langbf_load_css' );


/**
 * Print css in footer.
 *
 * @return void
 */
function langbf_load_js() {
	if ( get_option( 'langbf_active' ) != 'yes' ) {
		return;
	}

?>
	<script type="text/javascript">
	// <![CDATA[
	jQuery(document).ready( function(){
		if ( jQuery.isFunction( bootstrap.Tooltip ) ) {
			var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
			var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
				return new bootstrap.Tooltip(tooltipTriggerEl)
			});
		}
	} );
	// ]]>
	</script>
<?php
}
add_action( 'wp_footer', 'langbf_load_js' );


/**
 * Populate administration menu of the plugin.
 *
 * @return void
 */
function langbf_add_menu_links() {

	add_options_page( __( 'Language Bar Flags', LANGBF_TD ), __( 'Language Bar Flags', LANGBF_TD ), 'administrator', 'langbf', 'langbf_menu_settings' );
}


/**
 * Create settings page in admin.
 *
 * @return void
 */
function langbf_menu_settings() {

	include_once( dirname( __FILE__ ) . '/admin_settings.php' );
}


/**
 * Disable WP admin bar.
 *
 * @return void
 */
function langbf_disable_admin_bar() {

	if ( get_option( 'langbf_active' ) != 'yes' ) {
		return;
	}

	if ( get_option( 'langbf_disable_wpbar' ) == 'yes' ) {
		add_filter( 'show_admin_bar', '__return_false' );
		remove_action( 'personal_options', '_admin_bar_preferences' );
	}
}
add_action( 'init', 'langbf_disable_admin_bar' );


/**
 * Create announcement on langbf setting page.
 *
 * @return void
 */
function langbf_announcement() {

	echo '<div class="notice notice-info is-dismissible"><p>';
	_e( 'Check out what you are missing.', LANGBF_TD );
	printf( __( ' <a target="_blank" href="%s">Show me recommended themes!</a>', LANGBF_TD ), 'https://blog.meloniq.net/premium-themes' );
	echo '</p></div>';
}


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
	}

	if ( version_compare( $previous_version, '1.0.4', '<' ) ) {
		update_option( 'langbf_disable_wpbar', 'yes' );
		update_option( 'langbf_new_window', 'no' );
	}

	if ( version_compare( $previous_version, '1.0.5', '<' ) ) {
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


<?php
/*
Plugin Name: Language Bar Flags
Plugin URI: http://blog.meloniq.net/2011/11/28/language-bar-flags/
Description: Replace or disable standard WordPress bar in the top of website and display similar bar but with configurable language flags to other language versions of Your website.

Version: 1.0.8

Author: MELONIQ.NET
Author URI: http://blog.meloniq.net
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
define( 'LANGBF_VERSION', '1.0.8' );
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
	if ( ! wp_is_mobile() ) {
		wp_register_script( 'langbf_tooltip', plugins_url( '/js/tooltip.slide.js', __FILE__ ), array( 'jquery' ) );
		wp_enqueue_script( 'langbf_tooltip' );
	}
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
	wp_register_style( 'langbf_style', plugins_url( 'style.css', __FILE__ ) );
	wp_enqueue_style( 'langbf_style' );
}
add_action( 'wp_enqueue_scripts', 'langbf_load_styles' );


/**
 * Load back-end styles.
 *
 * @return void
 */
function langbf_load_admin_styles() {
	wp_register_style( 'langbf_admin_style', plugins_url( 'admin-style.css', __FILE__ ) );
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
	$target = ( get_option( 'langbf_new_window' ) == 'yes' ) ? 'target="_blank"' : '';
	$bar_title = get_option( 'langbf_title' );

	$langs = get_option( 'langbf_langs' );
	$native_names = langbf_get_countries( 'all', 'native' );
	$output = '';
	foreach ( $native_names as $code => $country ) {
		if ( isset( $langs[ $code ]['active'] ) && $langs[ $code ]['active'] == 'yes' ) {
			if ( ! empty( $langs[ $code ]['country'] ) ) {
				$country = $langs[ $code ]['country'];
			}
			$output .= '<li><a href="' . $langs[ $code ]['url'] . '" ' . $target . ' title="' . $country . '" class="langbf_' . $code . '">' . $country . '</a></li>';
		}
	}
?>
	<div id="langbf_bar">
		<div class="langbf_links">
			<div class="<?php echo $side_class; ?>">
				<?php if ( ! empty( $bar_title ) ) { echo '<span class="langbf_title">' . $bar_title . '</span>'; } ?>
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

	if ( get_option( 'langbf_position' ) == 'top' ) {
		$tooltip = array(
			'offset' => '10, 0',
			'position' => 'bottom center',
			'effect' => 'slide',
			'class' => 'langbf_tooltip_top',
		);
	} else {
		$tooltip = array(
			'offset' => '10, 0',
			'position' => 'top center',
			'effect' => 'slide',
			'class' => 'langbf_tooltip_bottom',
		);
	}
	$tooltip = apply_filters( 'langbf_tooltip', $tooltip, get_option( 'langbf_position' ) );
?>
	<script type="text/javascript">
	// <![CDATA[
	jQuery(document).ready( function(){
		if ( jQuery.isFunction( jQuery.fn.tooltip ) ) {
			jQuery("#langbf_bar a[title]").tooltip( {
				offset: [<?php echo esc_js( $tooltip['offset'] ); ?>],
				position: '<?php echo esc_js( $tooltip['position'] ); ?>',
				effect: '<?php echo esc_js( $tooltip['effect'] ); ?>',
				tipClass: '<?php echo esc_js( $tooltip['class'] ); ?>'
			} );
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

	if ( get_option( 'langbf_announcement' ) ) {
		return;
	}

	$enabled = array( true, false );
	shuffle( $enabled );

	if ( ! langbf_is_theme_provider( 'appthemes' ) && $enabled[0] ) {
		echo '<div class="update-nag">';
		_e( 'You are not using any of AppThemes Premium Themes, check what You are missing.', LANGBF_TD );
		printf( __( ' <a target="_blank" href="%s">Show me themes!</a>', LANGBF_TD ), 'http://bit.ly/s23oNj' );
		echo '</div>';
		return;
	}

	if ( ! langbf_is_theme_provider( 'elegantthemes' ) && $enabled[1] ) {
		echo '<div class="update-nag">';
		_e( 'You are not using any of Elegant Premium Themes, check what You are missing.', LANGBF_TD );
		printf( __( ' <a target="_blank" href="%s">Show me themes!</a>', LANGBF_TD ), 'http://bit.ly/11A8EmR' );
		echo '</div>';
		return;
	}

}


/**
 * Check theme provider, used for announcement.
 *
 * @param string $provider
 *
 * @return bool
 */
function langbf_is_theme_provider( $provider ) {

	if ( $provider == 'appthemes' ) {
		return ( function_exists( 'appthemes_init' ) );
	}

	if ( $provider == 'elegantthemes' ) {
		return ( function_exists( 'et_setup_theme' ) );
	}

	return false;
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


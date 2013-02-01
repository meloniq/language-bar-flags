<?php
/*
	Plugin Name: Language Bar Flags
	Plugin URI: http://blog.meloniq.net/2011/11/28/language-bar-flags/
	Description: Replace or disable standard WordPress bar in the top of website and display similar bar but with configurable language flags to other language versions of Your website.
	Author: MELONIQ.NET
	Version: 1.0.4
	Author URI: http://blog.meloniq.net
*/


/**
 * Avoid calling file directly
 */
if ( ! function_exists( 'add_action' ) )
	die( 'Whoops! You shouldn\'t be doing that.' );


global $langbf_dbversion;
$langbf_version = '1.0.4';
define('LANGBF_VERSION', '1.0.4');
$langbf_dbversion = '104';


/**
 * Process actions on plugin activation
 */
register_activation_hook( plugin_basename( __FILE__ ), 'langbf_activate' );


/**
 * Load Text-Domain
 */
load_plugin_textdomain( 'mnet-langbf', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );


/**
 * Load Countries arrays
 */
include_once( dirname( __FILE__ ) . '/countries.php' );


/**
 * Initialize admin menu
 */
if ( is_admin() ) {
	add_action( 'admin_menu', 'langbf_add_menu_links' );
}


/**
 * Load front-end scripts
 */
function langbf_load_scripts() {
	wp_register_script( 'langbf_tooltip', plugins_url( '/js/tooltip.slide.js', __FILE__ ), array( 'jquery' ) );
	wp_enqueue_script( 'langbf_tooltip' );
}
add_action( 'wp_print_scripts', 'langbf_load_scripts' );


/**
 * Load back-end scripts
 */
function langbf_load_admin_scripts() {
  wp_enqueue_script( 'jquery-ui-tabs' );
}
add_action( 'admin_enqueue_scripts', 'langbf_load_admin_scripts' );


/**
 * Load front-end styles
 */
function langbf_load_styles() {
	wp_register_style( 'langbf_style', plugins_url( 'style.css', __FILE__ ) );
	wp_enqueue_style( 'langbf_style' );
}
add_action( 'wp_print_styles', 'langbf_load_styles' );


/**
 * Load back-end styles
 */
function langbf_load_admin_styles() {
	wp_register_style( 'langbf_admin_style', plugins_url( 'admin-style.css', __FILE__ ) );
	wp_enqueue_style( 'langbf_admin_style' );
}
add_action( 'admin_enqueue_scripts', 'langbf_load_admin_styles' );


/**
 * Print code in footer
 */
function langbf_load_html() {
	global $europe_native, $america_native, $asia_native, $africa_native;

  if(get_option('langbf_active') == 'yes') {

		if(get_option('langbf_disable_wpbar') == 'yes') {
			add_filter( 'show_admin_bar', '__return_false' );
			remove_action( 'personal_options', '_admin_bar_preferences' );
		}
		
		if(get_option('langbf_new_window') == 'yes') $target = 'target="_blank"'; else $target = '';

    $langs = get_option('langbf_langs');
    $native_names = array_merge((array)$europe_native, (array)$america_native, (array)$asia_native, (array)$africa_native);
    $output = '';
    foreach($native_names as $code => $country){
      if(isset($langs[$code]['active']) && $langs[$code]['active'] == 'yes'){
        $output .= '<li><a href="' . $langs[$code]['url'] . '" ' . $target . ' title="' . $country . '" class="langbf_' . $code . '">' . $country . '</a></li>';
      }
    }
?>
    <div id="langbf_bar">
      <div class="langbf_links">
        <?php if(get_option('langbf_title') != ''){ echo '<span class="langbf_title">' . get_option('langbf_title') . '</span>'; } ?>
        <ul>
          <?php echo $output; ?>
        </ul>
      </div>
    </div><!-- #langbf_bar -->
<?php
  }
}
add_action( 'wp_footer', 'langbf_load_html' );


/**
 * Print css in footer
 */
function langbf_load_css() {
  if(get_option('langbf_active') == 'yes') {
		if( is_admin_bar_showing() ) {
			$margin_top = 52;
			$top = 26;
		} else {
			$margin_top = 26;
			$top = 0;
		}
?>
<style type="text/css">
html {
	margin-top: <?php echo $margin_top ?>px !important;
}
* html body { 
	margin-top: <?php echo $margin_top ?>px !important;
}
#langbf_bar {
	top: <?php echo $top ?>px !important;
}
</style>
<?php
	}
}
add_action( 'wp_footer', 'langbf_load_css' );


/**
 * Print css in footer
 */
function langbf_load_js() {
  if(get_option('langbf_active') == 'yes') {
?>
<script type="text/javascript">
// <![CDATA[
  jQuery(document).ready(function() {
    jQuery("#langbf_bar a[title]").tooltip({
      offset: [10, 0],
      position: 'bottom center',
      effect: 'slide'
});
  });
// ]]>
</script>
<?php
	}
}
add_action( 'wp_footer', 'langbf_load_js' );


/**
 * Populate administration menu of the plugin
 */
function langbf_add_menu_links() {
	if (function_exists('add_options_page')) {
		add_options_page(__('Language Bar Flags','mnet-langbf'), __('Language Bar Flags','mnet-langbf'), 'administrator', 'langbf', 'langbf_menu_settings' );
	}
}


/**
 * Create settings page in admin
 */
function langbf_menu_settings() {
	global $europe_english, $europe_native, $america_english, $america_native, $asia_english, $asia_native, $africa_english, $africa_native;
	include_once( dirname( __FILE__ ) . '/admin_settings.php' );
}


/**
 * Create announcement on langbf setting page
 */
function langbf_announcement() {
	global $app_theme;
	if(get_option('langbf_announcement') == false && !isset($app_theme)) {
		echo '<div class="update-nag">';
		_e('You are not using any of AppThemes Premium Themes, check what You are missing.', 'mnet-langbf');
		printf(__(' <a target="_blank" href="%s">Show me themes!</a>', 'mnet-langbf'), 'http://bit.ly/s23oNj');
		echo '</div>';
	}
}


/**
 * Action on plugin activate
 */
function langbf_activate() {
	global $wpdb, $langbf_dbversion;
	langbf_install_options($langbf_dbversion);
}

/**
 * Install default options
 */
function langbf_install_options($langbf_dbversion) {
	global $wpdb;
	
	$langbf_saved_dbversion = get_option('langbf_db_version');
	
  //If fresh installation, save defaults
	if(!$langbf_saved_dbversion){

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

  	update_option('langbf_db_version', $langbf_dbversion);
  	update_option('langbf_active', 'yes');
  	update_option('langbf_langs', $active_langs);
  	update_option('langbf_disable_wpbar', 'yes');
  	update_option('langbf_new_window', 'no');

	} else if($langbf_saved_dbversion < 104) {

  	update_option('langbf_disable_wpbar', 'yes');
  	update_option('langbf_new_window', 'no');

	}

  //Update DB version
  update_option('langbf_db_version', $langbf_dbversion);
  delete_option('langbf_announcement');
}		
?>
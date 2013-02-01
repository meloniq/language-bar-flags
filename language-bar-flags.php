<?php
/*
	Plugin Name: Language Bar Flags
	Plugin URI: http://blog.meloniq.net/2011/11/28/language-bar-flags/
	Description: Replace or disable standard WordPress bar in the top of website and display similar bar but with configurable language flags to other language versions of Your website.
	Author: MELONIQ.NET
	Version: 1.0.4
	Author URI: http://blog.meloniq.net
*/

// Avoid calling page directly
if (eregi(basename(__FILE__),$_SERVER['PHP_SELF'])) {
	echo "Whoops! You shouldn't be doing that.";
	exit;
}

global $langbf_dbversion;
$langbf_version = '1.0.4';
define('LANGBF_VERSION', '1.0.4');
$langbf_dbversion = '104';
// Init options & tables during activation & deregister init option
register_activation_hook( plugin_basename(__FILE__), 'langbf_activate' );

/* PLUGIN and WP-CONTENT directory constants if not already defined */
if ( ! defined( 'WP_PLUGIN_URL' ) )
	define( 'WP_PLUGIN_URL', WP_CONTENT_URL. '/plugins' );
if ( ! defined( 'WP_PLUGIN_DIR' ) )
	define( 'WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins' );
if ( ! defined( 'WP_CONTENT_URL' ) )
	define( 'WP_CONTENT_URL', get_option( 'siteurl' ) . '/wp-content' );
if ( ! defined( 'WP_CONTENT_DIR' ) )
	define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' );

if ( ! defined( 'LANGBF_PLUGIN_BASENAME' ) )
	define( 'LANGBF_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
if ( ! defined( 'LANGBF_PLUGIN_NAME' ) )
	define( 'LANGBF_PLUGIN_NAME', trim( dirname( LANGBF_PLUGIN_BASENAME ), '/' ) );
if ( ! defined( 'LANGBF_PLUGIN_DIR' ) )
	define( 'LANGBF_PLUGIN_DIR', WP_PLUGIN_DIR . '/' . LANGBF_PLUGIN_NAME );
if ( ! defined( 'LANGBF_PLUGIN_URL' ) )
	define( 'LANGBF_PLUGIN_URL', WP_PLUGIN_URL . '/' . LANGBF_PLUGIN_NAME );
	
	
/**
 * Load Text-Domain
 */
load_plugin_textdomain( 'mnet-langbf', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

/**
 * Load Countries arrays
 */
include_once (dirname (__FILE__) . '/countries.php');

/**
 * Initialize admin menu
 */
if ( is_admin() ) {	
	add_action('admin_menu', 'langbf_add_menu_links');
} else {
	// Add a author to the header
	//add_action('wp_head', create_function('', 'echo "\n<meta name=\'Language Bar\' content=\'http://www.meloniq.net\' />\n";') );
}

/**
 * Load scripts
 */
function langbf_load_scripts() {
  wp_enqueue_script('jquery');
	wp_register_script('langbf_tooltip', plugins_url(LANGBF_PLUGIN_NAME.'/js/tooltip.slide.js'), array('jquery'));
	wp_enqueue_script('langbf_tooltip');	
	//wp_print_scripts('langbf_tooltip');
}		
add_action('wp_print_scripts', 'langbf_load_scripts');

function langbf_load_admin_scripts() {
  wp_enqueue_script('jquery-ui-tabs'); 
}
add_action('admin_enqueue_scripts', 'langbf_load_admin_scripts');			

/**
 * Load styles
 */
function langbf_load_styles() {
	wp_register_style('langbf_style', plugins_url(LANGBF_PLUGIN_NAME.'/style.css'));
	wp_enqueue_style('langbf_style');	
}		
add_action('wp_print_styles', 'langbf_load_styles');

function langbf_load_admin_styles() {
	wp_register_style('langbf_admin_style', plugins_url(LANGBF_PLUGIN_NAME.'/admin-style.css'));
	wp_enqueue_style('langbf_admin_style');	
}
add_action('admin_enqueue_scripts', 'langbf_load_admin_styles');			

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
add_action('wp_footer', 'langbf_load_html');			

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
add_action('wp_footer', 'langbf_load_css');			

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
add_action('wp_footer', 'langbf_load_js');			

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
	include_once (dirname (__FILE__) . '/admin_settings.php');
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

  	$domain = str_replace('http://www.', '', get_option('siteurl'));
  	$domain = str_replace('https://www.', '', $domain);
  	$domain = str_replace('http://', '', $domain);
  	$domain = str_replace('https://', '', $domain);

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
<?php
/*
	Plugin Name: Language Bar
	Plugin URI: http://blog.meloniq.net/downloads/language-bar/
	Description: Replace or disable standard WordPress bar in the top of website and display similar bar but with configurable language flags to other language versions of Your website. Developed by <a href="http://www.meloniq.net">MELONIQ.NET</a>.
	Author: MELONIQ.NET
	Version: 1.0.0
	Author URI: http://blog.meloniq.net
*/

// Avoid calling page directly
if (eregi(basename(__FILE__),$_SERVER['PHP_SELF'])) {
	echo "Whoops! You shouldn't be doing that.";
	exit;
}

global $langbf_dbversion;
$langbf_version = '1.0.0';
define('LANGBF_VERSION', '1.0.0');
$langbf_dbversion = '100';
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
	global $europe_native;
  if(get_option('langbf_active') == 'yes'){
    add_filter( 'show_admin_bar', '__return_false' );
    remove_action( 'personal_options', '_admin_bar_preferences' ); 

    $langs = get_option('langbf_langs');
    $output = '';
    foreach($europe_native as $code => $country){
      if($langs[$code]['active'] == 'yes'){
        $output .= '<li><a href="' . $langs[$code]['url'] . '" title="' . $country . '" class="langbf_' . $code . '">' . $country . '</a></li>';
      }
    }
?>
    <div id="langbf_bar">
      <div class="langbf_links">
        <ul>
          <?php echo $output; ?>
        </ul>
      </div>
    </div><!-- #langbf_bar -->
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
<style type="text/css">
html {
  margin-top: 26px !important;
}
* html body { 
  margin-top: 26px !important; 
}
</style>
<?php
  }
}
add_action('wp_footer', 'langbf_load_html');			

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
	global $europe_english, $europe_native;
	include_once (dirname (__FILE__) . '/admin_settings.php');
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
	
	update_option('langbf_active', 'yes');
	update_option('langbf_langs', $active_langs);
	
}		
?>
<?php
/**
 * Handles frontend part.
 */
class LANGBF_Frontend {

	/**
	 * Class Constructor
	 *
	 * @return void
	 */
	public function __construct() {

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'init', array( $this, 'disable_admin_bar' ) );

		add_action( 'wp_footer', array( $this, 'load_html' ) );
		add_action( 'wp_footer', array( $this, 'load_css' ) );
		add_action( 'wp_footer', array( $this, 'load_js' ) );
	}


	/**
	 * Enqueue scripts and styles.
	 *
	 * @return void
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( 'langbf_bootstrap-js-bundle', plugins_url( '/js/bootstrap.bundle.min.js', dirname( __FILE__ ) ), array( 'jquery' ), '5.0.1' );

		wp_enqueue_style( 'langbf_bootstrap-css', plugins_url( '/css/bootstrap.min.css', dirname( __FILE__ ) ), array(), '5.0.1' );

		wp_register_style( 'langbf_style', plugins_url( '/css/style.css', dirname( __FILE__ ) ), array(), LANGBF_VERSION );
		wp_enqueue_style( 'langbf_style' );
	}


	/**
	 * Disable WP admin bar.
	 *
	 * @return void
	 */
	public function disable_admin_bar() {
		if ( get_option( 'langbf_active' ) != 'yes' ) {
			return;
		}

		if ( get_option( 'langbf_disable_wpbar' ) == 'yes' ) {
			add_filter( 'show_admin_bar', '__return_false' );
			remove_action( 'personal_options', '_admin_bar_preferences' );
		}
	}


	/**
	 * Output HTML.
	 *
	 * @return void
	 */
	public function load_html() {
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


	/**
	 * Output CSS.
	 *
	 * @return void
	 */
	public function load_css() {
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


	/**
	 * Output JS.
	 *
	 * @return void
	 */
	public function load_js() {
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


}

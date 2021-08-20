<?php
/**
 * Handles settings page.
 */
class LANGBF_Settings {

	/**
	 * Class Constructor
	 *
	 * @return void
	 */
	public function __construct() {

		add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
	}


	/**
	 * Populate administration menu of the plugin.
	 *
	 * @return void
	 */
	public function add_admin_menu() {
		add_options_page( __( 'Language Bar Flags', LANGBF_TD ), __( 'Language Bar Flags', LANGBF_TD ), 'administrator', 'langbf', array( $this, 'display_page' ) );
	}


	/**
	 * Create settings page in admin.
	 *
	 * @return void
	 */
	public function display_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( __( 'You do not have sufficient permissions to access this page.', LANGBF_TD ) );
		}
	
		// update options
		if ( isset( $_POST['options_update'] ) ) {
			$this->_save();
			echo '<div class="updated"><p><strong>' . __( 'Settings saved', LANGBF_TD ) . '</strong></p></div>';
		}

		// show announcement
		$this->announcement();
		?>
		<script type="text/javascript">
		// <![CDATA[
			jQuery(document).ready(function(){
				jQuery("#tabs-wrap").tabs( {
					fx: {
						opacity: 'toggle',
						duration: 200
					}
				} );
			} );
		// ]]>
		</script>
		<div class="wrap">
			<div class="icon32" id="icon-options-general"><br /></div>
			<h2><?php _e( 'General Settings', LANGBF_TD ); ?></h2>
			<form name="mainform" method="post" action="">
				<input type="hidden" value="1" name="options_update">
	
				<div id="tabs-wrap" class="">
					<ul class="tabs">
						<li class=""><a href="#tab1"><?php _e( 'General', LANGBF_TD ); ?></a></li>
						<li class=""><a href="#tab2"><?php _e( 'Europe', LANGBF_TD ); ?></a></li>
						<li class=""><a href="#tab3"><?php _e( 'America', LANGBF_TD ); ?></a></li>
						<li class=""><a href="#tab4"><?php _e( 'Asia + Oceania', LANGBF_TD ); ?></a></li>
						<li class=""><a href="#tab5"><?php _e( 'Africa', LANGBF_TD ); ?></a></li>
					</ul>
					<?php
						// General
						$this->display_general_tab();
						// Europe
						$this->display_countries_tab( 'tab2', 'europe' );
						// Americas
						$this->display_countries_tab( 'tab3', 'america' );
						// Asia + Oceania
						$this->display_countries_tab( 'tab4', 'asia' );
						// Africa
						$this->display_countries_tab( 'tab5', 'africa' );
					?>
					<p class="submit">
						<input type="submit" name="Submit" class="button-primary" value="<?php _e( 'Save Changes', LANGBF_TD ); ?>" />
					</p>
				</div>
			</form>
		</div>
		<div class="clear"></div>
		<?php
	}


	/**
	 * Save settings.
	 *
	 * @return void
	 */
	protected function _save() {
		if ( isset( $_POST['langbf_active'] ) && in_array( $_POST['langbf_active'], array( 'yes', 'no' ) ) ) {
			update_option( 'langbf_active', wp_kses_data( $_POST['langbf_active'] ) );
		}

		if ( isset( $_POST['langbf_title'] ) ) {
			update_option( 'langbf_title', wp_kses_data( $_POST['langbf_title'] ) );
		}

		if ( isset( $_POST['langbf_disable_wpbar'] ) && in_array( $_POST['langbf_disable_wpbar'], array( 'yes', 'no' ) ) ) {
			update_option( 'langbf_disable_wpbar', wp_kses_data( $_POST['langbf_disable_wpbar'] ) );
		}

		if ( isset( $_POST['langbf_new_window'] ) && in_array( $_POST['langbf_new_window'], array( 'yes', 'no' ) ) ) {
			update_option( 'langbf_new_window', wp_kses_data( $_POST['langbf_new_window'] ) );
		}

		if ( isset( $_POST['langbf_position'] ) && in_array( $_POST['langbf_position'], array( 'top', 'bottom' ) ) ) {
			update_option( 'langbf_position', wp_kses_data( $_POST['langbf_position'] ) );
		}

		if ( isset( $_POST['langbf_side'] ) && in_array( $_POST['langbf_side'], array( 'left', 'right' ) ) ) {
			update_option( 'langbf_side', wp_kses_data( $_POST['langbf_side'] ) );
		}

		$langs_array   = array();
		$english_names = langbf_get_countries( 'all', 'english' );

		foreach ( $english_names as $code => $country ) {
			if ( isset( $_POST[ $code ]['active'] ) && $_POST[ $code ]['active'] == 'yes' ) {
				$langs_array[ $code ]['active'] = 'yes';
			} else {
				$langs_array[ $code ]['active'] = 'no';
			}
			$langs_array[ $code ]['url']     = esc_url_raw( trim( stripslashes( $_POST[ $code ]['url'] ) ) );
			$langs_array[ $code ]['country'] = wp_kses_data( trim( stripslashes( $_POST[ $code ]['country'] ) ) );
		}

		update_option( 'langbf_langs', $langs_array );
	}


	/**
	 * Enqueue scripts.
	 *
	 * @return void
	 */
	public function admin_enqueue_scripts() {
		wp_enqueue_script( 'jquery-ui-tabs' );

		wp_register_style( 'langbf_admin_style', plugins_url( '/css/admin-style.css', dirname( __FILE__ ) ), array(), LANGBF_VERSION );
		wp_enqueue_style( 'langbf_admin_style' );
	}


	/**
	 * Display General Settings.
	 *
	 * @return void
	 */
	protected function display_general_tab() {
	?>
		<div id="tab1" class="">
			<table class="widefat fixed" style="width:850px; margin-bottom:20px;">
				<thead>
					<tr>
						<th width="200px" scope="col"><?php _e( 'General', LANGBF_TD ); ?></th>
						<th scope="col">&nbsp;</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><?php _e( 'Activate bar?', LANGBF_TD ); ?></td>
						<td>
							<select name="langbf_active">
								<option value="no" <?php selected( get_option( 'langbf_active' ), 'no' ); ?> ><?php _e( 'No', LANGBF_TD ); ?></option>
								<option value="yes" <?php selected( get_option( 'langbf_active' ), 'yes' ); ?> ><?php _e( 'Yes', LANGBF_TD ); ?></option>
							</select>
							<br /><small><?php _e( 'If "YES" is selected, then plugin will add a bar with language flags.', LANGBF_TD ); ?></small>
						</td>
					</tr>
					<tr>
						<td><?php _e( 'Title of bar', LANGBF_TD ); ?></td>
						<td>
							<input type="text" value="<?php echo esc_attr( get_option( 'langbf_title' ) ); ?>" style="min-width:500px;" id="langbf_title" name="langbf_title" /><br />
							<small><?php _e( 'Title will be displayed on a bar, right before flags.', LANGBF_TD ); ?></small>
						</td>
					</tr>
					<tr>
						<td><?php _e( 'Position of bar', LANGBF_TD ); ?></td>
						<td>
							<select name="langbf_position">
								<option value="top" <?php selected( get_option( 'langbf_position' ), 'top' ); ?> ><?php _e( 'Top', LANGBF_TD ); ?></option>
								<option value="bottom" <?php selected( get_option( 'langbf_position' ), 'bottom' ); ?> ><?php _e( 'Bottom', LANGBF_TD ); ?></option>
							</select>
							<br /><small><?php _e( 'Choose position where the bar should appear. The top of page or on the bottom.', LANGBF_TD ); ?></small>
						</td>
					</tr>
					<tr>
						<td><?php _e( 'Side of flags', LANGBF_TD ); ?></td>
						<td>
							<select name="langbf_side">
								<option value="left" <?php selected( get_option( 'langbf_side' ), 'left' ); ?> ><?php _e( 'Left', LANGBF_TD ); ?></option>
								<option value="right" <?php selected( get_option( 'langbf_side' ), 'right' ); ?> ><?php _e( 'Right', LANGBF_TD ); ?></option>
							</select>
							<br /><small><?php _e( 'Choose side of the bar where flags should appear. Left or right side of bar.', LANGBF_TD ); ?></small>
						</td>
					</tr>
					<tr>
						<td><?php _e( 'Disable WP bar?', LANGBF_TD ); ?></td>
						<td>
							<select name="langbf_disable_wpbar">
								<option value="no" <?php selected( get_option( 'langbf_disable_wpbar' ), 'no' ); ?> ><?php _e( 'No', LANGBF_TD ); ?></option>
								<option value="yes" <?php selected( get_option( 'langbf_disable_wpbar' ), 'yes' ); ?> ><?php _e( 'Yes', LANGBF_TD ); ?></option>
							</select>
							<br /><small><?php _e( 'If "YES" is selected, then plugin will disable WordPress Admin bar.', LANGBF_TD ); ?></small>
						</td>
					</tr>
					<tr>
						<td><?php _e( 'Open links in new window?', LANGBF_TD ); ?></td>
						<td>
							<select name="langbf_new_window">
								<option value="no" <?php selected( get_option( 'langbf_new_window' ), 'no' ); ?> ><?php _e( 'No', LANGBF_TD ); ?></option>
								<option value="yes" <?php selected( get_option( 'langbf_new_window' ), 'yes' ); ?> ><?php _e( 'Yes', LANGBF_TD ); ?></option>
							</select>
							<br /><small><?php _e( 'If "YES" is selected, then links on site will be open in new window.', LANGBF_TD ); ?></small>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	<?php
	}


	/**
	 * Display Countries Settings.
	 *
	 * @return void
	 */
	protected function display_countries_tab( $tab_id = 'tab2', $group_key = 'europe' ) {
		// load saved data
		$langs = get_option( 'langbf_langs' );

		// load countries data
		$countries_native  = langbf_get_countries( $group_key, 'native' );
		$countries_english = langbf_get_countries( $group_key, 'english' );
	?>
		<div id="<?php echo esc_attr( $tab_id ); ?>" class="">
			<table class="widefat fixed" style="margin-bottom:20px;">
				<thead>
					<tr>
						<th width="150px" scope="col"><?php _e( 'Country', LANGBF_TD ); ?></th>
						<th width="100px" scope="col"><?php _e( 'Active', LANGBF_TD ); ?></th>
						<th width="300px" scope="col"><?php _e( 'Alternative Name', LANGBF_TD ); ?></th>
						<th scope="col"><?php _e( 'URL', LANGBF_TD ); ?></th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ( $countries_english as $code => $country ) { ?>
					<tr>
						<td class=""><div class="langbf_img <?php echo 'langbf_' . $code; ?>"></div> <?php echo esc_html( $country ); ?></td>
						<td class="">
							<input type="checkbox" value="yes" id="<?php echo $group_key . '_' . $code . '_active'; ?>" name="<?php echo $code . '[active]'; ?>" <?php checked( isset( $langs[ $code ]['active'] ) && $langs[ $code ]['active'] == 'yes' ); ?> /><br />
						</td>
						<td class="">
							<input type="text" value="<?php if ( isset( $langs[ $code ]['country'] ) ) echo esc_attr( $langs[ $code ]['country'] ); ?>" style="min-width:230px;" id="<?php echo esc_attr( $group_key . '_' . $code . '_country' ); ?>" name="<?php echo esc_attr( $code . '[country]' ); ?>" /><br />
							<small><?php _e( 'Alternative country name. Default is: ', LANGBF_TD ); ?><i><?php echo esc_html( $countries_native[ $code ] ); ?></i></small>
						</td>
						<td class="">
							<input type="text" value="<?php if ( isset( $langs[ $code ]['url'] ) ) echo esc_attr( $langs[ $code ]['url'] ); ?>" style="min-width:400px;" id="<?php echo esc_attr( $group_key . '_' . $code . '_url' ); ?>" name="<?php echo esc_attr( $code . '[url]' ); ?>" /><br />
							<small><?php _e( 'URL address where link should point to.', LANGBF_TD ); ?></small>
						</td>
					</tr>
				<?php } ?>
				</tbody>
			</table>
		</div>
	<?php
	}


	/**
	 * Create announcement on setting page.
	 *
	 * @return void
	 */
	protected function announcement() {

		echo '<div class="notice notice-info is-dismissible"><p>';
		_e( 'Check out what you are missing.', LANGBF_TD );
		printf( __( ' <a target="_blank" href="%s">Show me recommended themes!</a>', LANGBF_TD ), 'https://blog.meloniq.net/premium-themes' );
		echo '</p></div>';
	}


}

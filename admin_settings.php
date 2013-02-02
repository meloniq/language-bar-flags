<?php

	if ( ! current_user_can( 'manage_options' ) )
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );


	// update options
	if ( isset( $_POST['options_update'] ) ) {
		update_option( 'langbf_active', stripslashes( $_POST['langbf_active'] ) );
		update_option( 'langbf_title', stripslashes( $_POST['langbf_title'] ) );
		update_option( 'langbf_disable_wpbar', stripslashes( $_POST['langbf_disable_wpbar'] ) );
		update_option( 'langbf_new_window', stripslashes( $_POST['langbf_new_window'] ) );
		update_option( 'langbf_position', stripslashes( $_POST['langbf_position'] ) );
		update_option( 'langbf_side', stripslashes( $_POST['langbf_side'] ) );

		$langs_array = array();
		$english_names = langbf_get_countries( 'all', 'english' );

		foreach ( $english_names as $code => $country ) {
			if ( isset( $_POST[ $code ]['active'] ) && $_POST[ $code ]['active'] == 'yes' ) {
				$langs_array[ $code ]['active'] = 'yes';
			} else {
				$langs_array[ $code ]['active'] = 'no';
			}
			$langs_array[ $code ]['url'] = trim( stripslashes( $_POST[ $code ]['url'] ) );
		}

		update_option( 'langbf_langs', $langs_array );

		echo '<div class="updated"><p><strong>' . __( 'Settings saved', LANGBF_TD ) . '</strong></p></div>';
	}


	// load saved data
	$langs = get_option('langbf_langs');

	// load countries data
	$europe_native = langbf_get_countries( 'europe', 'native' );
	$europe_english = langbf_get_countries( 'europe', 'english' );
	$america_native = langbf_get_countries( 'america', 'native' );
	$america_english = langbf_get_countries( 'america', 'english' );
	$asia_native = langbf_get_countries( 'asia', 'native' );
	$asia_english = langbf_get_countries( 'asia', 'english' );
	$africa_native = langbf_get_countries( 'africa', 'native' );
	$africa_english = langbf_get_countries( 'africa', 'english' );

	// show announcement
	langbf_announcement();
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

				<!-- General -->
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
										<option value="no" <?php selected( get_option('langbf_active'), 'no' ); ?> ><?php _e( 'No', LANGBF_TD ); ?></option>
										<option value="yes" <?php selected( get_option('langbf_active'), 'yes' ); ?> ><?php _e( 'Yes', LANGBF_TD ); ?></option>
									</select>
									<br /><small><?php _e( 'If "YES" is selected, then plugin will add a bar with language flags.', LANGBF_TD ); ?></small>
								</td>
							</tr>
							<tr>
								<td><?php _e( 'Title of bar', LANGBF_TD ); ?></td>
								<td>
									<input type="text" value="<?php echo esc_attr( get_option('langbf_title') ); ?>" style="min-width:500px;" id="langbf_title" name="langbf_title" /><br />
									<small><?php _e( 'Title will be displayed on a bar, right before flags.', LANGBF_TD ); ?></small>
								</td>
							</tr>
							<tr>
								<td><?php _e( 'Position of bar', LANGBF_TD ); ?></td>
								<td>
									<select name="langbf_position">
										<option value="top" <?php selected( get_option('langbf_position'), 'top' ); ?> ><?php _e( 'Top', LANGBF_TD ); ?></option>
										<option value="bottom" <?php selected( get_option('langbf_position'), 'bottom' ); ?> ><?php _e( 'Bottom', LANGBF_TD ); ?></option>
									</select>
									<br /><small><?php _e( 'Choose position where the bar should appear. The top of page or on the bottom.', LANGBF_TD ); ?></small>
								</td>
							</tr>
							<tr>
								<td><?php _e( 'Side of flags', LANGBF_TD ); ?></td>
								<td>
									<select name="langbf_side">
										<option value="left" <?php selected( get_option('langbf_side'), 'left' ); ?> ><?php _e( 'Left', LANGBF_TD ); ?></option>
										<option value="right" <?php selected( get_option('langbf_side'), 'right' ); ?> ><?php _e( 'Right', LANGBF_TD ); ?></option>
									</select>
									<br /><small><?php _e( 'Choose side of the bar where flags should appear. Left or right side of bar.', LANGBF_TD ); ?></small>
								</td>
							</tr>
							<tr>
								<td><?php _e( 'Disable WP bar?', LANGBF_TD ); ?></td>
								<td>
									<select name="langbf_disable_wpbar">
										<option value="no" <?php selected( get_option('langbf_disable_wpbar'), 'no' ); ?> ><?php _e( 'No', LANGBF_TD ); ?></option>
										<option value="yes" <?php selected( get_option('langbf_disable_wpbar'), 'yes' ); ?> ><?php _e( 'Yes', LANGBF_TD ); ?></option>
									</select>
									<br /><small><?php _e( 'If "YES" is selected, then plugin will disable WordPress Admin bar.', LANGBF_TD ); ?></small>
								</td>
							</tr>
							<tr>
								<td><?php _e( 'Open links in new window?', LANGBF_TD ); ?></td>
								<td>
									<select name="langbf_new_window">
										<option value="no" <?php selected( get_option('langbf_new_window'), 'no' ); ?> ><?php _e( 'No', LANGBF_TD ); ?></option>
										<option value="yes" <?php selected( get_option('langbf_new_window'), 'yes' ); ?> ><?php _e( 'Yes', LANGBF_TD ); ?></option>
									</select>
									<br /><small><?php _e( 'If "YES" is selected, then links on site will be open in new window.', LANGBF_TD ); ?></small>
								</td>
							</tr>
						</tbody>
					</table>
				</div>

				<!-- Europe -->
				<div id="tab2" class="">
					<table class="widefat fixed" style="width:850px; margin-bottom:20px;">
						<thead>
							<tr>
								<th width="150px" scope="col"><?php _e( 'Country', LANGBF_TD ); ?></th>
								<th width="100px" scope="col"><?php _e( 'Active', LANGBF_TD ); ?></th>
								<th scope="col"><?php _e( 'URL', LANGBF_TD ); ?></th>
							</tr>
						</thead>
						<tbody>
						<?php foreach ( $europe_english as $code => $country ) { ?>
							<tr>
								<td class=""><div class="langbf_img"><img src="<?php echo plugins_url( '/images/flag_' . $code . '.png', __FILE__ ); ?>" width="24" /></div> <?php echo esc_html( $country ); ?></td>
								<td class="">
									<input type="checkbox" value="yes" id="<?php echo 'europe_' . $code . '_active'; ?>" name="<?php echo $code . '[active]'; ?>" <?php checked( isset( $langs[ $code ]['active'] ) && $langs[ $code ]['active'] == 'yes' ); ?> /><br />
								</td>
								<td class="">
									<input type="text" value="<?php if ( isset( $langs[ $code ]['url'] ) ) echo esc_attr( $langs[ $code ]['url'] ); ?>" style="min-width:500px;" id="<?php echo 'europe_' . $code . '_url'; ?>" name="<?php echo $code . '[url]'; ?>" /><br />
									<small><?php _e( 'Country name will be dispayed as: ', LANGBF_TD ); ?><i><?php echo esc_html( $europe_native[ $code ] ); ?></i></small>
								</td>
							</tr>
						<?php } ?>
						</tbody>
					</table>
				</div>

				<!-- Americas -->
				<div id="tab3" class="">
					<table class="widefat fixed" style="width:850px; margin-bottom:20px;">
						<thead>
							<tr>
								<th width="150px" scope="col"><?php _e( 'Country', LANGBF_TD ); ?></th>
								<th width="100px" scope="col"><?php _e( 'Active', LANGBF_TD ); ?></th>
								<th scope="col"><?php _e( 'URL', LANGBF_TD ); ?></th>
							</tr>
						</thead>
						<tbody>
						<?php foreach ( $america_english as $code => $country ) { ?>
							<tr>
								<td class=""><div class="langbf_img"><img src="<?php echo plugins_url( '/images/flag_' . $code . '.png', __FILE__ ); ?>" width="24" /></div> <?php echo esc_html( $country ); ?></td>
								<td class="">
									<input type="checkbox" value="yes" id="<?php echo 'america_' . $code . '_active'; ?>" name="<?php echo $code . '[active]'; ?>" <?php checked( isset( $langs[ $code ]['active'] ) && $langs[ $code ]['active'] == 'yes' ); ?> /><br />
								</td>
								<td class="">
									<input type="text" value="<?php if ( isset( $langs[ $code ]['url'] ) ) echo esc_attr( $langs[ $code ]['url'] ); ?>" style="min-width:500px;" id="<?php echo 'america_' . $code . '_url'; ?>" name="<?php echo $code . '[url]'; ?>" /><br />
									<small><?php _e( 'Country name will be dispayed as: ', LANGBF_TD ); ?><i><?php echo esc_html( $america_native[ $code ] ); ?></i></small>
								</td>
							</tr>
						<?php } ?>
						</tbody>
					</table>
				</div>

				<!-- Asia + Oceania -->
				<div id="tab4" class="">
					<table class="widefat fixed" style="width:850px; margin-bottom:20px;">
						<thead>
							<tr>
								<th width="150px" scope="col"><?php _e( 'Country', LANGBF_TD ); ?></th>
								<th width="100px" scope="col"><?php _e( 'Active', LANGBF_TD ); ?></th>
								<th scope="col"><?php _e( 'URL', LANGBF_TD ); ?></th>
							</tr>
						</thead>
						<tbody>
						<?php foreach ( $asia_english as $code => $country ) { ?>
							<tr>
								<td class=""><div class="langbf_img"><img src="<?php echo plugins_url( '/images/flag_' . $code . '.png', __FILE__ ); ?>" width="24" /></div> <?php echo esc_html( $country ); ?></td>
								<td class="">
									<input type="checkbox" value="yes" id="<?php echo 'asia_' . $code . '_active'; ?>" name="<?php echo $code . '[active]'; ?>" <?php checked( isset( $langs[ $code ]['active'] ) && $langs[ $code ]['active'] == 'yes' ); ?> /><br />
								</td>
								<td class="">
									<input type="text" value="<?php if ( isset( $langs[ $code ]['url'] ) ) echo esc_attr( $langs[ $code ]['url'] ); ?>" style="min-width:500px;" id="<?php echo 'asia_' . $code . '_url'; ?>" name="<?php echo $code . '[url]'; ?>" /><br />
									<small><?php _e( 'Country name will be dispayed as: ', LANGBF_TD ); ?><i><?php echo esc_html( $asia_native[ $code ] ); ?></i></small>
								</td>
							</tr>
						<?php } ?>
						</tbody>
					</table>
				</div>

				<!-- Africa -->
				<div id="tab5" class="">
					<table class="widefat fixed" style="width:850px; margin-bottom:20px;">
						<thead>
							<tr>
								<th width="150px" scope="col"><?php _e( 'Country', LANGBF_TD ); ?></th>
								<th width="100px" scope="col"><?php _e( 'Active', LANGBF_TD ); ?></th>
								<th scope="col"><?php _e( 'URL', LANGBF_TD ); ?></th>
							</tr>
						</thead>
						<tbody>
						<?php foreach ( $africa_english as $code => $country ) { ?>
							<tr>
								<td class=""><div class="langbf_img"><img src="<?php echo plugins_url( '/images/flag_' . $code . '.png', __FILE__ ); ?>" width="24" /></div> <?php echo esc_html( $country ); ?></td>
								<td class="">
									<input type="checkbox" value="yes" id="<?php echo 'africa_' . $code . '_active'; ?>" name="<?php echo $code . '[active]'; ?>" <?php checked( isset( $langs[ $code ]['active'] ) && $langs[ $code ]['active'] == 'yes' ); ?> /><br />
								</td>
								<td class="">
									<input type="text" value="<?php if ( isset( $langs[ $code ]['url'] ) ) echo esc_attr( $langs[ $code ]['url'] ); ?>" style="min-width:500px;" id="<?php echo 'africa_' . $code . '_url'; ?>" name="<?php echo $code . '[url]'; ?>" /><br />
									<small><?php _e( 'Country name will be dispayed as: ', LANGBF_TD ); ?><i><?php echo esc_html( $africa_native[ $code ] ); ?></i></small>
								</td>
							</tr>
						<?php } ?>
						</tbody>
					</table>
				</div>

				<p class="submit">
					<input type="submit" name="Submit" class="button-primary" value="<?php _e( 'Save Changes', LANGBF_TD ); ?>" />
				</p>

			</div>
		</form>
	</div>
	<div class="clear"></div>

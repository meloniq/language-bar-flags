<?php
  if (!current_user_can('manage_options')) {
    wp_die( __('You do not have sufficient permissions to access this page.') );
  }

  //Update options
  if( isset( $_POST['options_update']) ) {
    update_option('langbf_active', $_POST['langbf_active']);
    update_option('langbf_title', $_POST['langbf_title']);
    update_option('langbf_disable_wpbar', $_POST['langbf_disable_wpbar']);
    update_option('langbf_new_window', $_POST['langbf_new_window']);

    $langs_array = array();
    $english_names = array_merge((array)$europe_english, (array)$america_english, (array)$asia_english, (array)$africa_english);

    foreach($english_names as $code => $country) {
      if (isset($_POST[$code]['active']) && $_POST[$code]['active'] == 'yes'){
        $langs_array[$code]['active'] = 'yes';
      }else{
        $langs_array[$code]['active'] = 'no';
      }
      $langs_array[$code]['url'] = trim($_POST[$code]['url']);
    }

    update_option('langbf_langs', $langs_array);
    
    echo '<div class="updated"><p><strong>' . __('Settings saved', 'mnet-langbf') . '</strong></p></div>';
  }

  //load saved data
  $langs = get_option('langbf_langs');
	langbf_announcement();
	?>	
<script type="text/javascript">
// <![CDATA[
  jQuery(document).ready(function() {
    jQuery("#tabs-wrap").tabs({fx: {opacity: 'toggle', duration: 200}});
  });
// ]]>
</script>
<div class="wrap">
  <div class="icon32" id="icon-options-general"><br /></div>
  <h2><?php _e('General Settings', 'mnet-langbf'); ?></h2>
  <form name="mainform" method="post" action="">
    <input type="hidden" value="1" name="options_update">

    <div id="tabs-wrap" class="">
      <ul class="tabs">
        <li class=""><a href="#tab1"><?php _e('General', 'mnet-langbf'); ?></a></li>
        <li class=""><a href="#tab2"><?php _e('Europe', 'mnet-langbf'); ?></a></li>
        <li class=""><a href="#tab3"><?php _e('America', 'mnet-langbf'); ?></a></li>
        <li class=""><a href="#tab4"><?php _e('Asia + Oceania', 'mnet-langbf'); ?></a></li>
        <li class=""><a href="#tab5"><?php _e('Africa', 'mnet-langbf'); ?></a></li>
      </ul>
      
      <div id="tab1" class="">
        <table class="widefat fixed" style="width:850px; margin-bottom:20px;">
          <thead>
            <tr>
              <th width="200px" scope="col"><?php _e('General', 'mnet-langbf'); ?></th>
              <th scope="col">&nbsp;</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><?php _e('Activate bar?', 'mnet-langbf'); ?></td>
              <td>
                <select name="langbf_active">
                  <option value="no" <?php if(get_option('langbf_active') == 'no'){ echo 'selected="selected"'; } ?> ><?php _e('No', 'mnet-langbf'); ?></option>
                  <option value="yes" <?php if(get_option('langbf_active') == 'yes'){ echo 'selected="selected"'; } ?> ><?php _e('Yes', 'mnet-langbf'); ?></option>
                </select>
                <br /><small><?php _e('If "YES" is selected, then plugin will add a bar with language flags.', 'mnet-langbf'); ?></small>
              </td>
            </tr>
            <tr>
              <td><?php _e('Title of bar', 'mnet-langbf'); ?></td>
              <td>
                <input type="text" value="<?php echo get_option('langbf_title'); ?>" style="min-width:500px;" id="langbf_title" name="langbf_title" /><br />
                <small><?php _e('Title will be displayed on a bar, right before flags.', 'mnet-langbf'); ?></small>
              </td>
            </tr>
            <tr>
              <td><?php _e('Disable WP bar?', 'mnet-langbf'); ?></td>
              <td>
                <select name="langbf_disable_wpbar">
                  <option value="no" <?php if(get_option('langbf_disable_wpbar') == 'no'){ echo 'selected="selected"'; } ?> ><?php _e('No', 'mnet-langbf'); ?></option>
                  <option value="yes" <?php if(get_option('langbf_disable_wpbar') == 'yes'){ echo 'selected="selected"'; } ?> ><?php _e('Yes', 'mnet-langbf'); ?></option>
                </select>
                <br /><small><?php _e('If "YES" is selected, then plugin will disable WordPress Admin bar.', 'mnet-langbf'); ?></small>
              </td>
            </tr>
            <tr>
              <td><?php _e('Open links in new window?', 'mnet-langbf'); ?></td>
              <td>
                <select name="langbf_new_window">
                  <option value="no" <?php if(get_option('langbf_new_window') == 'no'){ echo 'selected="selected"'; } ?> ><?php _e('No', 'mnet-langbf'); ?></option>
                  <option value="yes" <?php if(get_option('langbf_new_window') == 'yes'){ echo 'selected="selected"'; } ?> ><?php _e('Yes', 'mnet-langbf'); ?></option>
                </select>
                <br /><small><?php _e('If "YES" is selected, then links on site will be open in new window.', 'mnet-langbf'); ?></small>
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
              <th width="150px" scope="col"><?php _e('Country', 'mnet-langbf'); ?></th>
              <th width="100px" scope="col"><?php _e('Active', 'mnet-langbf'); ?></th>
              <th scope="col"><?php _e('URL', 'mnet-langbf'); ?></th>
            </tr>
          </thead>
          <tbody>
          <?php foreach($europe_english as $code => $country): ?>
            <tr>
              <td class=""><div class="langbf_img"><img src="<?php echo plugins_url( '/images/flag_' . $code . '.png', __FILE__ ); ?>" width="24" /></div> <?php echo $country; ?></td>
              <td class="">
                <input type="checkbox" value="yes" id="europe_<?php echo $code; ?>_active" name="<?php echo $code; ?>[active]" <?php if(isset($langs[$code]['active']) && $langs[$code]['active'] == 'yes'){ echo 'checked="checked"'; }; ?> /><br />
              </td>
              <td class="">
                <input type="text" value="<?php if(isset($langs[$code]['url'])) echo $langs[$code]['url']; ?>" style="min-width:500px;" id="europe_<?php echo $code; ?>_url" name="<?php echo $code; ?>[url]" /><br />
                <small><?php _e('Country name will be dispayed as: ', 'mnet-langbf'); ?><i><?php echo $europe_native[$code]; ?></i></small>
              </td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <!-- Americas -->
      <div id="tab3" class="">
        <table class="widefat fixed" style="width:850px; margin-bottom:20px;">
          <thead>
            <tr>
              <th width="150px" scope="col"><?php _e('Country', 'mnet-langbf'); ?></th>
              <th width="100px" scope="col"><?php _e('Active', 'mnet-langbf'); ?></th>
              <th scope="col"><?php _e('URL', 'mnet-langbf'); ?></th>
            </tr>
          </thead>
          <tbody>
          <?php foreach($america_english as $code => $country): ?>
            <tr>
              <td class=""><div class="langbf_img"><img src="<?php echo plugins_url( '/images/flag_' . $code . '.png', __FILE__ ); ?>" width="24" /></div> <?php echo $country; ?></td>
              <td class="">
                <input type="checkbox" value="yes" id="america_<?php echo $code; ?>_active" name="<?php echo $code; ?>[active]" <?php if(isset($langs[$code]['active']) && $langs[$code]['active'] == 'yes'){ echo 'checked="checked"'; }; ?> /><br />
              </td>
              <td class="">
                <input type="text" value="<?php if(isset($langs[$code]['url'])) echo $langs[$code]['url']; ?>" style="min-width:500px;" id="america_<?php echo $code; ?>_url" name="<?php echo $code; ?>[url]" /><br />
                <small><?php _e('Country name will be dispayed as: ', 'mnet-langbf'); ?><i><?php echo $america_native[$code]; ?></i></small>
              </td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <!-- Asia + Oceania -->
      <div id="tab4" class="">
        <table class="widefat fixed" style="width:850px; margin-bottom:20px;">
          <thead>
            <tr>
              <th width="150px" scope="col"><?php _e('Country', 'mnet-langbf'); ?></th>
              <th width="100px" scope="col"><?php _e('Active', 'mnet-langbf'); ?></th>
              <th scope="col"><?php _e('URL', 'mnet-langbf'); ?></th>
            </tr>
          </thead>
          <tbody>
          <?php foreach($asia_english as $code => $country): ?>
            <tr>
              <td class=""><div class="langbf_img"><img src="<?php echo plugins_url( '/images/flag_' . $code . '.png', __FILE__ ); ?>" width="24" /></div> <?php echo $country; ?></td>
              <td class="">
                <input type="checkbox" value="yes" id="asia_<?php echo $code; ?>_active" name="<?php echo $code; ?>[active]" <?php if(isset($langs[$code]['active']) && $langs[$code]['active'] == 'yes'){ echo 'checked="checked"'; }; ?> /><br />
              </td>
              <td class="">
                <input type="text" value="<?php if(isset($langs[$code]['url'])) echo $langs[$code]['url']; ?>" style="min-width:500px;" id="asia_<?php echo $code; ?>_url" name="<?php echo $code; ?>[url]" /><br />
                <small><?php _e('Country name will be dispayed as: ', 'mnet-langbf'); ?><i><?php echo $asia_native[$code]; ?></i></small>
              </td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <!-- Africa -->
      <div id="tab5" class="">
        <table class="widefat fixed" style="width:850px; margin-bottom:20px;">
          <thead>
            <tr>
              <th width="150px" scope="col"><?php _e('Country', 'mnet-langbf'); ?></th>
              <th width="100px" scope="col"><?php _e('Active', 'mnet-langbf'); ?></th>
              <th scope="col"><?php _e('URL', 'mnet-langbf'); ?></th>
            </tr>
          </thead>
          <tbody>
          <?php foreach($africa_english as $code => $country): ?>
            <tr>
              <td class=""><div class="langbf_img"><img src="<?php echo plugins_url( '/images/flag_' . $code . '.png', __FILE__ ); ?>" width="24" /></div> <?php echo $country; ?></td>
              <td class="">
                <input type="checkbox" value="yes" id="africa_<?php echo $code; ?>_active" name="<?php echo $code; ?>[active]" <?php if(isset($langs[$code]['active']) && $langs[$code]['active'] == 'yes'){ echo 'checked="checked"'; }; ?> /><br />
              </td>
              <td class="">
                <input type="text" value="<?php if(isset($langs[$code]['url'])) echo $langs[$code]['url']; ?>" style="min-width:500px;" id="africa_<?php echo $code; ?>_url" name="<?php echo $code; ?>[url]" /><br />
                <small><?php _e('Country name will be dispayed as: ', 'mnet-langbf'); ?><i><?php echo $africa_native[$code]; ?></i></small>
              </td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      </div>

    <p class="submit">
      <input type="submit" name="Submit" class="button-primary" value="<?php _e('Save Changes', 'mnet-langbf'); ?>" />
    </p>

  </form>
</div>    
<div class="clear"></div>
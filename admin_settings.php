<?php
  if (!current_user_can('manage_options')) {
    wp_die( __('You do not have sufficient permissions to access this page.') );
  }

  //Update options
  if( isset( $_POST['options_update']) ) {
    update_option('langbf_active', $_POST['langbf_active']);
    $langs_array = array();
    // Europe part
    foreach($europe_english as $code => $country) {
      if ($_POST['europe'][$code]['active'] == 'yes'){
        $langs_array[$code]['active'] = 'yes';
      }else{
        $langs_array[$code]['active'] = 'no';
      }
      $langs_array[$code]['url'] = trim($_POST['europe'][$code]['url']);
    }
    // America part
    /*
    foreach($america_english as $code => $country) {
      if ($_POST['america'][$code]['active'] == 'yes'){
        $langs_array[$code]['active'] = 'yes';
      }else{
        $langs_array[$code]['active'] = 'no';
      }
      $langs_array[$code]['url'] = trim($_POST['america'][$code]['url']);
    }
    */
    update_option('langbf_langs', $langs_array);
    
    echo '<div class="updated"><p><strong>' . __('Settings saved', 'mnet-langbf') . '</strong></p></div>';
  }

  //load saved data
  $langs = get_option('langbf_langs');
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
        <li class=""><a href="#tab4"><?php _e('Asia + Australia', 'mnet-langbf'); ?></a></li>
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
                  <option value="no" selected="selected"><?php _e('No', 'mnet-langbf'); ?></option>
                  <option value="yes" selected="selected"><?php _e('Yes', 'mnet-langbf'); ?></option>
                </select>
                <br /><span class="description"><?php _e('If "YES" is selected, then plugin will add a bar with language flags.', 'mnet-langbf'); ?></span>
              </td>
            </tr>
          </tbody>
        </table>

      </div>

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
              <td class=""><div class="langbf_img"><img src="<?php echo LANGBF_PLUGIN_URL . '/images/flag_' . $code . '.png'; ?>" width="24" /></div> <?php echo $country; ?></td>
              <td class="">
                <input type="checkbox" value="yes" id="europe_<?php echo $code; ?>_active" name="europe[<?php echo $code; ?>][active]" <?php if($langs[$code]['active'] == 'yes'){ echo 'checked="checked"'; }; ?> /><br />
              </td>
              <td class="">
                <input type="text" value="<?php echo $langs[$code]['url']; ?>" style="min-width:500px;" id="europe_<?php echo $code; ?>_url" name="europe[<?php echo $code; ?>][url]" /><br />
                <small><?php _e('Country name will be dispayed as: ', 'mnet-langbf'); ?><i><?php echo $europe_native[$code]; ?></i></small>
              </td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      </div>

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
            <tr>
              <td colspan="3" class="">
                <p><?php _e('Don\'t need it right now... but if users will need it, will create it later...', 'mnet-langbf'); ?></p>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

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
            <tr>
              <td colspan="3" class="">
                <p><?php _e('Don\'t need it right now... but if users will need it, will create it later...', 'mnet-langbf'); ?></p>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

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
            <tr>
              <td colspan="3" class="">
                <p><?php _e('Don\'t need it right now... but if users will need it, will create it later...', 'mnet-langbf'); ?></p>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

    <p class="submit">
      <input type="submit" name="Submit" class="button-primary" value="<?php _e('Save Changes', 'mnet-langbf'); ?>" />
    </p>

  </form>
</div>    
<div class="clear"></div>
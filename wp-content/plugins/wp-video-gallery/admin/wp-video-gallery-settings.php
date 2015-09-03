<?php

add_action( 'admin_init', 'wpvg_my_gallery_settings' );
/**
 * Init plugin options to white list our options
 */
function wpvg_my_gallery_settings(){
	register_setting( 'my_gallery_options', 'my_gallery_video_options', 'wpvg_my_gallery_options_validate' );
}
/**
 * Create the options page
 */
 
$select_options = array(
	'0' => array(
		'value' =>	'pp_default',
		'label' => __( 'Default', 'my_videogallery' )
	),
	'1' => array(
		'value' =>	'dark_rounded',
		'label' => __( 'Dark rounded', 'my_videogallery' )
	),
	'2' => array(
		'value' =>	'light_square',
		'label' => __( 'Light Square', 'my_videogallery' )
	),
	'3' => array(
		'value' =>	'dark_square',
		'label' => __( 'Dark Square', 'my_videogallery' )
	),
	'4' => array(
		'value' =>	'facebook',
		'label' => __( 'Faceook Style', 'my_videogallery' )
	),
);

$pb_style = array(
	'0' => array(
		'value' =>	'default',
		'label' => __( 'Default', 'my_videogallery' )
	),
	'1' => array(
		'value' =>	'big_play',
		'label' => __( 'Big Button', 'my_videogallery' )
	),
	'2' => array(
		'value' =>	'standard',
		'label' => __( 'Standard Button', 'my_videogallery' )
	)
);

function wpvg_my_gallery_do_page() {
	global $select_options, $radio_options, $pb_style;

	if ( ! isset( $_REQUEST['settings-updated'] ) )
		$_REQUEST['settings-updated'] = false;

	?>

<div class="wrap wpvg_settings">
  <div id="leftsec-gallery">
    <div id="InputsWrapper">
      <div class="dashicons dashicons-admin-settings"></div>
      <?php echo "<h2>" . __( ' WP Video Gallery Settings', 'my_videogallery' ) . "</h2>"; ?>
      <?php if ( false !== $_REQUEST['settings-updated'] ) : ?>
      <div class="updated fade">
        <p><strong>
          <?php _e( 'Settings saved', 'my_videogallery' ); ?>
          </strong></p>
      </div>
      <?php endif; ?>
      <div id="section-next">
        <div id="poststuff">
        <div class="postbox " id="videogallery-slider-topd">
      <div title="Click to toggle" class="handlediv"><br>
      </div>
      <h3 class="hndle"><span> <div class="dashicons dashicons-admin-users"></div> Top Donations</span></h3>
      <div class="inside">
      <p>Thanks for donate for WP Video Gallery</p>
        <div class="videogallery-field">
          <ul id="donations_list">
          <li>Fawad Khan <span class="country">Pakistan</span> <span class="ammount">$25</span></li>
          <li>ASTUS S.R.L <span class="country">Italy</span> <span class="ammount">$5</span></li>
          </ul>
        </div>
      </div>
    </div>
          <div class="postbox " id="videogallery-slider-support">
            <div title="Click to toggle" class="handlediv"><br>
            </div>
            <h3 class="hndle"><span>
              <div class="dashicons dashicons-heart"></div>
              Support WP Video Gallery</span></h3>
            <div class="inside">
              <div id="credits">
                <p>Development: <a href="https://plus.google.com/106669313030431497344">Gulzar Ahmed</a><br>
                  Additional UI: <a href="http://pluginsforwp.net/plugins/wp-video-gallery">WP Video Gallery</a></p>
              </div>
              <div id="contrib-note">
                <center>
                  <p>If you find this plugin useful, or are using it commercially, please consider</p>
                  <form style="text-align: center;" action="https://www.paypal.com/cgi-bin/webscr" method="post">
                    <input type="hidden" name="cmd" value="_s-xclick" />
                    <input type="hidden" name="hosted_button_id" value="XUNV7HH2STFQS" />
                    <input type="image" name="submit" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" alt="PayPal - The safer, easier way to pay online!" />
                    <img src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" alt="" width="1" height="1" border="0" />
                  </form>
                  <p>Donate <strong>$1</strong> or <strong>$5</strong> Thanks!</p>
                </center>
              </div>
              <div id="copyright">
                <p>&copy; 2011-<?php echo date('Y')?> Plugins for WP. Proud to be <a href="https://www.gnu.org/licenses/gpl-2.0.html">GPLv2 (or later) licensed</a>.</p>
                <p id="vpm-credit">Built by <a href="http://pluginsforwp.net/">Plugins For Wp</a></p>
              </div>
            </div>
          </div>
          <div class="postbox " id="videogallery-slider-extend">
        <div title="Click to toggle" class="handlediv"><br>
        </div>
        <h3 class="hndle"><span>Extend Power - WP Video Gallery</span></h3>
        <div class="inside">
          <div class="videogallery-field">
            <p><a href="mailto:webmaster.gulzarahmed@gmail.com?subject=Feedback - WP Video Gallery">Submit Your Feedback</a></p>
            <p><a href="mailto:webmaster.gulzarahmed@gmail.com?subject=Customize Request - WP Video Gallery">Customize WP Video Gallery</a></p>
            <p><a href="mailto:webmaster.gulzarahmed@gmail.com?subject=Report a Bug - WP Video Gallery">Report a Bug</a></p>
            <p><a href="mailto:webmaster.gulzarahmed@gmail.com?subject=Hire Us - WP Video Gallery">Hire Us</a></p>            
          </div>
        </div>
      </div>
          <div class="postbox " id="videogallery-slider-codes">
            <div title="Click to toggle" class="handlediv"><br>
            </div>
            <h3 class="hndle"><span>News from PluginsForWP.net</span></h3>
            <div class="inside">
              <div class="videogallery-field">
                <?php wpvg_rss_news(); ?>
              </div>
            </div>
          </div>
          <div class="postbox " id="videogallery-slider-codes">
            <div title="Click to toggle" class="handlediv"><br>
            </div>
            <h3 class="hndle"><span>Offers</span></h3>
            <div class="inside">
              <div class="videogallery-field">
                <iframe src="http://pluginsforwp.net/offers.html" width="260" height="250" frameborder="0" scrolling="no"></iframe>
              </div>
            </div>
          </div>
          <div class="postbox " id="videogallery-slider-codes">
            <div title="Click to toggle" class="handlediv"><br>
            </div>
            <h3 class="hndle"><span>Find us on Facebook</span></h3>
            <div class="inside">
              <div class="videogallery-field">
                <iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Fiwebsolutions&amp;width=260&amp;height=258&amp;colorscheme=light&amp;show_faces=true&amp;header=false&amp;stream=false&amp;show_border=true&amp;appId=280237358777181" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:260px; height:258px;" allowTransparency="true"></iframe>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="setupload" style="margin:20px 0;">
        <form id="setting_page" method="post" action="options.php">
          <?php settings_fields( 'my_gallery_options' ); ?>
          <?php $options = get_option( 'my_gallery_video_options' ); ?>
          <h3 class="title-settings"><?php echo __( 'Settings', 'my_videogallery' ); ?></h3>
          <table class="form-table">
            <tr valign="top">
              <th scope="row"><?php _e( 'Touch (Mobile)', 'my_videogallery' ); ?></th>
              <td><input id="my_gallery_video_options[touch]" name="my_gallery_video_options[touch]" type="checkbox" value="1" <?php checked( '1', $options['touch'] ); ?> />
                <label class="description" for="my_gallery_video_options[touch]">
                  <?php _e( 'Enable', 'my_videogallery' ); ?>
                </label></td>
            </tr>
            <tr valign="top">
              <th scope="row"><?php _e( 'Social Share', 'my_videogallery' ); ?></th>
              <td><input id="my_gallery_video_options[sshare]" name="my_gallery_video_options[sshare]" type="checkbox" value="1" <?php checked( '1', $options['sshare'] ); ?> />
                <label class="description" for="my_gallery_video_options[sshare]">
                  <?php _e( 'Enable', 'my_videogallery' ); ?>
                </label></td>
            </tr>
            <tr valign="top">
              <th scope="row"><?php _e( 'Slide Width', 'my_videogallery' ); ?></th>
              <td><input id="my_gallery_video_options[slidewidth]" class="regular-text" type="text" name="my_gallery_video_options[slidewidth]" value="<?php esc_attr_e( $options['slidewidth'] ); ?>" style="width:60px"/>
                <label class="description" for="my_gallery_video_options[slidewidth]">
                  <?php _e( 'px', 'my_videogallery' ); ?>
                </label></td>
            </tr>
            <tr valign="top">
              <th scope="row"><?php _e( 'Slide Margin', 'my_videogallery' ); ?></th>
              <td><input id="my_gallery_video_options[slidemargin]" class="regular-text" type="text" name="my_gallery_video_options[slidemargin]" value="<?php esc_attr_e( $options['slidemargin'] ); ?>" style="width:60px"/>
                <label class="description" for="my_gallery_video_options[slidemargin]">
                  <?php _e( 'px', 'my_videogallery' ); ?>
                </label></td>
            </tr>
            <tr valign="top">
              <th scope="row"><?php _e( 'Move Slide', 'my_videogallery' ); ?></th>
              <td><input id="my_gallery_video_options[moveslide]" class="regular-text" type="number" name="my_gallery_video_options[moveslide]" value="<?php esc_attr_e( $options['moveslide'] ); ?>" style="width:60px"/>
                <label class="description" for="my_gallery_video_options[moveslide]">
                  <?php _e( 'Slide', 'my_videogallery' ); ?>
                </label></td>
            </tr>
            <tr valign="top">
              <th scope="row"><?php _e( 'Min Slide', 'my_videogallery' ); ?></th>
              <td><input id="my_gallery_video_options[minslide]" class="regular-text" type="number" name="my_gallery_video_options[minslide]" value="<?php esc_attr_e( $options['minslide'] ); ?>" style="width:60px"/>
                <label class="description" for="my_gallery_video_options[minslide]">
                  <?php _e( 'Slide', 'my_videogallery' ); ?>
                </label></td>
            </tr>
            <tr valign="top">
              <th scope="row"><?php _e( 'Max Slide', 'my_videogallery' ); ?></th>
              <td><input id="my_gallery_video_options[maxslide]" class="regular-text" type="number" name="my_gallery_video_options[maxslide]" value="<?php esc_attr_e( $options['maxslide'] ); ?>" style="width:60px"/>
                <label class="description" for="my_gallery_video_options[maxslide]">
                  <?php _e( 'Slide', 'my_videogallery' ); ?>
                </label></td>
            </tr>
            <tr valign="top">
              <th scope="row"><?php _e( 'Responsive Slide', 'my_videogallery' ); ?></th>
              <td><input id="my_gallery_video_options[responsive]" name="my_gallery_video_options[responsive]" type="checkbox" value="1" <?php checked( '1', $options['responsive'] ); ?> />
                <label class="description" for="my_gallery_video_options[responsive]">
                  <?php _e( 'Enable', 'my_videogallery' ); ?>
                </label></td>
            </tr>
            <tr valign="top">
              <th scope="row"><?php _e( 'Play Button', 'my_videogallery' ); ?></th>
              <td><input id="my_gallery_video_options[playbutton]" name="my_gallery_video_options[playbutton]" type="checkbox" value="1" <?php checked( '1', $options['playbutton'] ); ?> />
                <label class="description" for="my_gallery_video_options[playbutton]">
                  <?php _e( 'Enable', 'my_videogallery' ); ?>
                </label></td>
            </tr>
            <tr valign="top">
        <th scope="row"><?php _e( 'Light Box Style', 'my_videogallery' ); ?></th>
        <td><select name="my_gallery_video_options[vgstyle]">
            <?php
								$selected = $options['vgstyle'];
								$p = '';
								$r = '';

								foreach ( $select_options as $option ) {
									$label = $option['label'];
									if ( $selected == $option['value'] ) // Make default first in list
										$p = "\n\t<option style=\"padding-right: 10px;\" selected='selected' value='" . esc_attr( $option['value'] ) . "'>$label</option>";
									else
										$r .= "\n\t<option style=\"padding-right: 10px;\" value='" . esc_attr( $option['value'] ) . "'>$label</option>";
								}
								echo $p . $r;
							?>
          </select>
          <label class="description" for="my_gallery_video_options[vgstyle]">
            <?php _e( 'Select', 'my_videogallery' ); ?>
          </label></td>
      </tr>
     		 <tr valign="top">
      <th scope="row"><?php _e( 'Play Button Style', 'my_videogallery' ); ?></th>
        <td><select name="my_gallery_video_options[pbstyle]">

            <?php

								$selected = $options['pbstyle'];

								$p = '';

								$r = '';



								foreach ( $pb_style as $option ) {

									$label = $option['label'];

									if ( $selected == $option['value'] ) // Make default first in list

										$p = "\n\t<option style=\"padding-right: 10px;\" selected='selected' value='" . esc_attr( $option['value'] ) . "'>$label</option>";

									else

										$r .= "\n\t<option style=\"padding-right: 10px;\" value='" . esc_attr( $option['value'] ) . "'>$label</option>";

								}

								echo $p . $r;

							?>

          </select>

          <label class="description" for="my_gallery_video_options[pbstyle]">

            <?php _e( 'Select', 'my_videogallery' ); ?>

          </label></td>
       </table>
       </tr>
          </table>
          <p class="submit">
            <input type="submit" class="button-primary" value="<?php _e( 'Save Settings', 'my_videogallery' ); ?>" />
          </p>
        </form>
      </div>
      
    </div>
  </div>
</div>
<?php
}


function wpvg_my_gallery_options_validate( $input ) {
	return $input;
}



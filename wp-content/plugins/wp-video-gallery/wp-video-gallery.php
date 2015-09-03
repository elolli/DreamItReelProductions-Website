<?php
/**
 * Plugin Name: WP Video Gallery
 * Plugin URI: http://www.wordpresspluginshop.com
 * Description: A Beautiful Video and Image Gallery for WordPress
 * Version: 0.6.5
 * Author: Gulzar Ahmed
 * Author URI: http://theiwebsolutions.com/
 * License: GPL2
 */

// Plugin URL 
define('wp_vgurl', plugins_url('',__FILE__));
define('video_gallery_directory',plugin_dir_path( __FILE__ ));

// Gallery Functions
require_once(video_gallery_directory."wp-video-gallery-functions.php");

add_action( 'admin_init', 'wpvg_gallery_options_init' );
add_action( 'admin_menu', 'wpvg_gallery_options_add_page' );

require_once(video_gallery_directory."admin/wp-video-gallery-settings.php");

function wpvg_default_settings() {
  
  // Get the Settings
  $options = get_option( 'my_gallery_video_options' );
  
  if(!isset($options['touch'])) $options['touch'] = "1";
  if(!isset($options['slidewidth'])) $options['slidewidth'] = "226";
  if(!isset($options['slidemargin'])) $options['slidemargin'] = "10";
  if(!isset($options['moveslide'])) $options['moveslide'] = "1";
  if(!isset($options['minslide'])) $options['minslide'] = "1";
  if(!isset($options['maxslide'])) $options['maxslide'] = "4";
  if(!isset($options['responsive'])) $options['responsive'] = true;
  if(!isset($options['playbutton'])) $options['playbutton'] = "1";
  if(!isset($options['vgstyle'])) $options['vgstyle'] = "pp_default";
  if(!isset($options['pbstyle'])) $options['pbstyle'] = "default";
  if(!isset($options['sshare'])) $options['sshare'] = "1";
  
	  update_option('my_gallery_video_options',$options);
  
}
register_activation_hook( __FILE__, 'wpvg_default_settings' );


// Message
$message_log = NULL;

function wpvg_rss_news(){
// Get RSS Feed(s)
include_once( ABSPATH . WPINC . '/feed.php' );

// Get a SimplePie feed object from the specified feed source.
$rss = fetch_feed( 'http://pluginsforwp.net/feed/' );

if ( ! is_wp_error( $rss ) ) : // Checks that the object is created correctly

    // Figure out how many total items there are, but limit it to 5. 
    $maxitems = $rss->get_item_quantity( 5 ); 

    // Build an array of all the items, starting with element 0 (first element).
    $rss_items = $rss->get_items( 0, $maxitems );

endif;
?>

<ul>
  <?php if ( $maxitems == 0 ) : ?>
  <li>
    <?php _e( 'No items', 'my-text-domain' ); ?>
  </li>
  <?php else : ?>
  <?php // Loop through each feed item and display each item as a hyperlink. ?>
  <?php foreach ( $rss_items as $item ) : ?>
  <li> <a href="<?php echo esc_url( $item->get_permalink() ); ?>"
                    title="<?php printf( __( 'Posted %s', 'my-text-domain' ), $item->get_date('j F Y | g:i a') ); ?>"> <?php echo esc_html( $item->get_title() ); ?> </a><div id="desc"><?php echo wp_trim_words($item->get_description(),20); ?></div></li>
  <?php endforeach; ?>
  <?php endif; ?>
</ul>
<?php }

/**
 * Init plugin options to white list our options
 */
function wpvg_gallery_options_init(){
	global $message_log;
	
	// My settings to Save
	if(isset($_GET['gallery_id']) and is_numeric($_GET['gallery_id']) and !empty($_POST)){
		
		// Verify the Category is Exist
		$get_category_data = get_option('vcategory_id_'.$_GET['gallery_id']);
		
			if($get_category_data !== FALSE){

			  $gallery_id = $_GET['gallery_id'];	
			  $gallery_data  = $_POST;
			  
			  $option_name = 'video_gallery_'.$gallery_id ;
			  $new_value = $gallery_data;
		  
			  if ( get_option( $option_name ) !== false ) {
				  
				  $message_log = "Gallery has been Saved!";
				  
				  // if this fails, check_admin_referer() will automatically print a "failed" page and die.
				if ( ! empty( $_POST ) && check_admin_referer( 'wpvg_gallery_update', 'wpvg_gallery_nonce' ) ) {
					
					$gallery_id = $_GET['gallery_id'];
					$update_gname  = wp_strip_all_tags($_POST['gallery_name']);
					$update_gname_option = "vcategory_id_".$gallery_id;
					
					// Update Gallery Name
					update_option( $update_gname_option, $update_gname );
					
					// Clean New Value Before it Save on Options
					unset($new_value['wpvg_gallery_nonce']);
					unset($new_value['_wp_http_referer']);
					unset($new_value['gallery_name']);
					
									
				  // The option already exists, so we just update it.
				  update_option( $option_name, $new_value );
				  
				}
		  
			  } else {
				  // The option hasn't been added yet. We'll add it with $autoload set to 'no'.
				  $deprecated = NULL;
				  $autoload = 'no';
				  
				  $message_log = "Gallery has been Saved!";
				  
				 // if this fails, check_admin_referer() will automatically print a "failed" page and die.
				if ( ! empty( $_POST ) && check_admin_referer( 'wpvg_gallery_update', 'wpvg_gallery_nonce' ) ) {
					
					$gallery_id = $_GET['gallery_id'];
					$update_gname  = wp_strip_all_tags($_POST['gallery_name']);
					$update_gname_option = "vcategory_id_".$gallery_id;
					
					// Update Gallery Name
					update_option( $update_gname_option, $update_gname );
	 
 					// Clean New Value Before it Save on Options
					unset($new_value['wpvg_gallery_nonce']);
					unset($new_value['_wp_http_referer']);
					unset($new_value['gallery_name']);
					
				  add_option( $option_name, $new_value, $deprecated, $autoload );
				  
				}
			  }
		
			}
	}else{
		
		
		if(isset($_GET['cat_delete']) and is_numeric($_GET['cat_delete'])){
			$delete_id = $_GET['cat_delete'];
			
			if($get_value = get_option("vcategory_id_".$delete_id)){
			
				// DELETED
				$deleted_cat = delete_option("vcategory_id_".$delete_id);
				$deleted_gallery = delete_option("video_gallery_".$delete_id);
				
				$message_log = "Category has been Deleted!";
			
			}
			
		}
		
		
		
		if(!empty($_POST['vcategory_name'])){			
			// Save the Category
			$vcategory_data  = wp_strip_all_tags($_POST['vcategory_name']);
			$vcategory_id = $_POST['cat_id'];
			$vcategory_option = "vcategory_id_".$vcategory_id;
			$vcat_counter = "vcat_counter";
		
			if ( get_option( $vcategory_option ) !== false ) {	
			
			} else {
			$deprecated = NULL;
			$autoload = 'no';
			
			
			$message_log = "Category has been Created!";
			
			   // if this fails, check_admin_referer() will automatically print a "failed" page and die.
			  if ( ! empty( $_POST ) && check_admin_referer( 'wpvg_gallery_update', 'wpvg_gallery_nonce' ) ) {
				  add_option( $vcategory_option, $vcategory_data, $deprecated, $autoload );
			  }
				
			}
			
			if ( get_option( $vcat_counter ) !== false ) {
				update_option( $vcat_counter, $vcategory_id );
			} else {
				$deprecated = NULL;
				$autoload = 'no';
				$cat_counter = 1;
				add_option( $vcat_counter, $cat_counter, $deprecated, $autoload );
			
			}
		}
	}
	
	wp_register_script('my_jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js', false, '1.7.2');
	wp_register_script('wpvg_gallery_ready', wp_vgurl.'/includes/gallery-ready.js', false);

}



/**
 * Load up the menu page
 */
function wpvg_gallery_options_add_page() {
	$page_hook_suffix = add_menu_page( __( 'WP Video Gallery', 'vgallery' ), __( 'WP Video Gallery', 'vgallery' ), 'manage_options', 'gallery_options', 'wpvg_gallery_options_do_page', 'dashicons-format-video');
	
	$page_sub_hook = add_submenu_page( 'gallery_options', 'Video Gallery Settings', 'Settings', 'manage_options', 'new_gallery_options', 'wpvg_my_gallery_do_page' ); 
	
	add_action('admin_print_scripts-' . $page_hook_suffix, 'wpvg_my_gallery_scripts');
	add_action( 'admin_enqueue_scripts', 'wpvg_my_enqueue' );
	
}
// Admin Page Styles
function wpvg_my_enqueue($hook) {
	if( 'toplevel_page_gallery_options' == $hook or 'wp-video-gallery_page_new_gallery_options' == $hook ){
	     wp_register_style( 'gallery_style', wp_vgurl.'/includes/gallery-style.css' );
    	 wp_enqueue_style( 'gallery_style' );
	}
	return;
	

}
// Admin Page Scripts
function wpvg_my_gallery_scripts() {

          wp_enqueue_script('my_jquery');
		  wp_enqueue_media();
		  wp_enqueue_script('form_validate');
		  
          // WordPress jQuery UI
		  wp_enqueue_script('jquery-ui-core');
		  wp_enqueue_script('jquery-ui-widget');
		  wp_enqueue_script('jquery-ui-sortable');
		  wp_enqueue_script('jquery-ui-accordion');
		  wp_enqueue_script('wpvg_gallery_ready');		  
		  //wp_enqueue_script('media-upload');
}

/**
 * Create the options page
 */
function wpvg_gallery_options_do_page() {
	global $select_options, $radio_options, $message_log;

	if ( ! isset( $_REQUEST['settings-updated'] ) )
		$_REQUEST['settings-updated'] = false;

	?>
<div class="wrap">
  <?php if(isset($_GET['gallery_id']) and is_numeric($_GET['gallery_id'])){ ?>
  <?php // Verify the Category is Exist
		$get_category_data = get_option('vcategory_id_'.$_GET['gallery_id']);
		
			if($get_category_data !== FALSE){
				
				// GET OPTION DATA 
					$option_name = 'video_gallery_'.$_GET['gallery_id'];
					$gallery_option_data = get_option($option_name);
	
					
					$input_count = 0;
					$video_count = 0;
					
					
				if(!empty($gallery_option_data)){
				
					foreach($gallery_option_data as $position_video){
						// Count the Inputs	
						$input_count ++;
					}
					
					if($input_count >= 3){
						$input_decount =  $input_count/3;
					}else{
						$input_decount = 0;
					}
					
				}else{
					$input_decount = 1;	
				}
					
					?>
 <script>
 // ADD IMAGE
	jQuery(document).ready(function($){
		var _custom_media = true,
			_orig_send_attachment = wp.media.editor.send.attachment;
	  
		$('#InputsWrapper .button').click(function(e) {
		  var send_attachment_bkp = wp.media.editor.send.attachment;
		  var button = $(this);
		  var id = button.attr('id').replace('_button', '');
		  _custom_media = true;
		  wp.media.editor.send.attachment = function(props, attachment){
			if ( _custom_media ) {
			  $("#"+id).val(attachment.url);
			} else {
			  return _orig_send_attachment.apply( this, [props, attachment] );
			};
		  }
	  
		  wp.media.editor.open(button);
		  return false;
		});
	  
		$('.add_media').on('click', function(){
		  _custom_media = false;
		});
	  });
			  
// VALIDATE FIELDS			
			jQuery(document).ready(function($){
			$( "#gallery-form" ).submit(function( event ) {
   				var empty = $('.setupload').parent().parent().find("input").filter(function() {
     			   return this.value === "";
			    });
			$('input[type="text"]').css({"border-color": "#DDDDDD", 
					             "border-width":"1px", 
					             "border-style":"solid"});

			    if(empty.length) {
        			//At least one input is empty
					alert("There were errors on the form, please make sure all fields are fill out correctly.");
					empty.focus();
					empty.css({"border-color": "#FF8888", 
					             "border-width":"1px", 
					             "border-style":"solid"});

					return false;
			    }
				//event.preventDefault();
			});			
			});

// ADD NEW SLIDE
			jQuery(document).ready(function($){
				
				var MaxInputs       = 1000; //maximum input boxes allowed
				var InputsWrapper   = $("#InputsWrapper #gallery-list"); //Input boxes wrapper ID
				var AddButton       = $("#AddMoreFileBox"); //Add button ID
				
				var x = <?php echo $input_decount; ?>; //initlal text box count
				var FieldCount=<?php echo $input_decount; ?>; //to keep track of text box added
	
				$(AddButton).click(function (e)  //on add input button click
				{
					
						if(x <= MaxInputs) //max input box allowed
						{
							FieldCount++; //text box added increment
							//add input box
							$(InputsWrapper).append('<div style="margin:20px 0;" class="setupload"><div class="setup-wrapper"><h3>Slide: </h3><div><p><label>Video Title<input id="video_title_'+ FieldCount +'" name="video_title_'+ FieldCount +'" class="sname" type="text" value="" /><small>This is used for display the video titles in the Video Gallery. <strong>Example: My First Video</strong></small></label></p><p><label>Video URL or Media<input id="video_url_'+ FieldCount +'" name="video_url_'+ FieldCount +'" type="text" value="" /><small>This is the URL of the video to play or Media. <strong>Example: http://vimeo.com/59362697 or http://instagr.am/p/IejkuUGxQn </strong></small></label></p><p><label>Thumbnail URL <input id="vthumbnail_url_'+ FieldCount +'" name="vthumbnail_url_'+ FieldCount +'" type="text" value="" /><small>This is used for display the Video Thumbnail. <strong>Example: http://www.yoursite.com/thumbnail.png </strong></small></label><input class="button" id="vthumbnail_url_'+ FieldCount +'_button" value="Add Image" /></p><a href="#" class="removeclass">REMOVE</a></div></div></div>');
							
							/*<div><input type="text" name="mytext[]" id="field_'+ FieldCount +'" value="Text '+ FieldCount +'"/></div> */
							x++; //text box increment
						}
				return false;
				});
				
				$("body").on("click",".removeclass", function(e){ //user click on remove text
						if( x > 1 ) {
								$(this).parent('div').parent('div').remove(); //remove text box
								x--; //decrement textbox
						}
				return false;
				}) 			
			});
			</script>
  
  <div id="leftsec-gallery">
  <div id="InputsWrapper">
  
  
  
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
  <h3 class="hndle"><span><div class="dashicons dashicons-heart"></div> Support WP Video Gallery</span></h3>
  <div class="inside">
  <div id="credits">
    <p>Development: <a href="http://pluginsforwp.net/">Gulzar Ahmed</a><br>
		Additional UI: <a href="http://pluginsforwp.net/plugins/wp-video-gallery">WP Video Gallery</a></p>
  </div>
  <div id="contrib-note">
  <center>
  <p>If you find this plugin useful, or are using it commercially, please consider</p>
  <form style="text-align: center;" action="https://www.paypal.com/cgi-bin/webscr" method="post">
    <input type="hidden" name="cmd" value="_s-xclick" />
    <input type="hidden" name="hosted_button_id" value="XUNV7HH2STFQS" />
    <input type="image" name="submit" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" alt="PayPal - The safer, easier way to pay online!" value="1"/>
    <img src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" alt="" width="1" height="1" border="0" />
  </form>
  <p>Donate <strong>$1</strong> or <strong>$5</strong> Thanks!</p>
  </center>
</div>
<div id="copyright">
  <p>&copy; 2011-<?php echo date('Y')?> Plugins for WP. Proud to be <a href="https://www.gnu.org/licenses/gpl-2.0.html">GPLv2 (or later) licensed</a>.</p>
  <p id="vpm-credit">Built by <a href="https://plus.google.com/106669313030431497344">Plugins For Wp</a></p>
</div>
</div>
</div>
    <div class="postbox " id="videogallery-slider-codes">
      <div title="Click to toggle" class="handlediv"><br>
      </div>
      <h3 class="hndle"><span>Get Slider Codes</span></h3>
      <div class="inside">
        <div class="videogallery-field">
          <label for="videogallery_get_shortcode">Your Shortcode: </label>
          <input type="text" value="[gallery_videos id=&quot;<?php echo $_GET['gallery_id']; ?>&quot;]"  class="widefat" id="videogallery_get_shortcode" readonly>
          <span class="note">Copy and paste this shortcode into your Post, Page or Custom Post editor.</span>
          <div class="clear"></div>
        </div>
        <div class="videogallery-field last">
          <label for="videogallery_get_code">Your PHP Code: </label>
          <input type="text" value="&lt;?php if( function_exists('wpvg_get_category_videos') ) wpvg_get_category_videos('<?php echo $_GET['gallery_id']; ?>'); ?&gt;" class="widefat" id="videogallery_get_code" readonly>
          <span class="note">Copy and paste this code when you need to display the slider in template files (header.php, front-page.php, etc.).</span>
          <div class="clear"></div>
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
    <div class="postbox " id="videogallery-slider-news">
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
    <form id="gallery-form" method="post" action="">
    <div class="dashicons dashicons-images-alt2"></div><h2 class="g_headline">
    <input id="gallery_name" name="gallery_name" type="text" placeholder="Enter the Gallery Name" value="<?php if($category_title = get_option('vcategory_id_'.$_GET['gallery_id'])){ echo $category_title;	} ?>" />
    <a href="#" id="AddMoreFileBox" class="btn btn-info newstyle">Add New Slide</a></h2>
    <?php if(!empty($message_log)){ ?>
  <div class="updated below-h2" id="message">
    <p><?php echo $message_log; ?></p>
  </div>
  <?php } ?>
  <p class="back-cat"><a href="?page=gallery_options">&#8592; Back to Video Categories</a></p>
  <div id="gallery-list">
<?php
			if(!empty($gallery_option_data)){
			
			
			foreach($gallery_option_data as $position_video => $single_video){
					if($video_count == 0){

					echo '<div style="margin:20px 0;" class="setupload"><div class="setup-wrapper"><h3>Slide:</h3><div>'; } ?>
<p>
  <label>
    <?php if($video_count == 0){
						echo "Video Title ";
					}elseif($video_count == 1){
						echo "Video URL or Media";
					}elseif($video_count == 2){
						echo 'Thumbnail URL';
					} ?>
    <input id="<?php echo $position_video; ?>" name="<?php echo $position_video; ?>" <?php if($video_count == 0){ echo 'class="sname"'; } ?> type="text" value="<?php echo stripslashes($single_video); ?>" />
    <?php if($video_count == 0){
						echo '<small>This is used for display the video titles in the Video Gallery. <strong>Example: My First Video</strong></small>';
					}elseif($video_count == 1){
						echo '<small>This is the URL of the video to play or Media. <strong>Example: http://vimeo.com/59362697 or http://instagr.am/p/IejkuUGxQn </strong><</small>';
					}elseif($video_count == 2){
						echo '<small>This is used for display the Video Thumbnail. <strong>Example: http://www.yoursite.com/thumbnail.png </strong></small>';
					} ?>
  </label>
  <?php 	// Video Count
					$video_count++;
			
					if($video_count == 3){
						echo '<input class="button" id="'.$position_video.'_button" value="Add Image" />';
					} ?>
</p>
<?php	
					if($video_count == 3){ $video_count = 0; echo '<a href="#" class="removeclass">REMOVE</a></div></div></div>'; }
				}
				
			}else{ ?>
<div style="margin:20px 0;" class="setupload">
  <div class="setup-wrapper">
    <h3>Slide:</h3><div>
    <p>
      <label>Video Title
        <input name="video_title_1" class="sname" type="text" value="" />
        <small>This is used for display the video titles in the Video Gallery. <strong>Example: My First Video</strong></small> </label>
    </p>
    <p>
      <label>Video URL or Media
        <input name="video_url_1" type="text" value="" />
        <small>This is the URL of the video to play or Media. <strong>Example: http://vimeo.com/59362697 or http://instagr.am/p/IejkuUGxQn</strong></small> </label>
    </p>
    <p>
      <label>Thumbnail URL
        <input id="vthumbnail_url_1"  name="vthumbnail_url_1" type="text" value="" />
        <small>This is used for display the Video Thumbnail. <strong>Example: http://www.yoursite.com/thumbnail.png </strong></small> </label>
      <input class="button" id="vthumbnail_url_1_button" value="Add Image" />
    </p>
  </div>
</div>
</div>
<?php } ?>
</div>
<script>
// Get the Slide Name
$(".setupload").each(function(index, value) { 
		// Apply Values
		var slidename = $(this).find(".sname").val();
		$(this).find("h3").append( "<span>"+slidename+"</span>" );
});		
</script>
</div>
</div>
<div id="rightsec-gallery"> </div>
<?php wp_nonce_field('wpvg_gallery_update','wpvg_gallery_nonce'); ?>
<p class="submit">
  <input type="submit" class="button-primary submit_vgallery" value="<?php _e( 'Save Gallery', 'vgallery' ); ?>" />
</p>
</form>
<script>
            
			jQuery(document).ready(function($){
				
				var AddButton       = $("#AddMoreFileBox"); //Add button ID
				$(AddButton).click(function (e)  //on add input button click
				{
					var _custom_media = true,
					_orig_send_attachment = wp.media.editor.send.attachment;
			  
				$('#InputsWrapper .button').click(function(e) {
				  var send_attachment_bkp = wp.media.editor.send.attachment;
				  var button = $(this);
				  var id = button.attr('id').replace('_button', '');
				  _custom_media = true;
				  wp.media.editor.send.attachment = function(props, attachment){
					if ( _custom_media ) {
					  $("#"+id).val(attachment.url);
					} else {
					  return _orig_send_attachment.apply( this, [props, attachment] );
					};
				  }
			  
				  wp.media.editor.open(button);
				  return false;
				});
			  
				$('.add_media').on('click', function(){
				  _custom_media = false;
				});
					
				});
			});

            </script>
<?php
			
			
			}else{
				
				echo "<p>The gallery does not Exist";
				
			}
		
		 }else{ ?>
<div class="dashicons dashicons-format-video"></div>
<h2>
  <?php _e( 'Video Categories', 'vgallery' ); ?>
</h2>
<!-- pre<?php print_r(get_option('video_category')); ?>-->

<div id="left-section" class="category_set">
  <?php if(!empty($message_log)){ ?>
  <div class="updated below-h2" id="message">
    <p><?php echo $message_log; ?></p>
  </div>
  <?php } ?>
  <div id="section-next" class="category_list">
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
  <h3 class="hndle"><span><div class="dashicons dashicons-heart"></div> Support WP Video Gallery</span></h3>
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
    <input type="image" value="1" name="submit" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" alt="PayPal - The safer, easier way to pay online!" />
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
      <div class="postbox " id="videogallery-slider-codes">
        <div title="Click to toggle" class="handlediv"><br>
        </div>
        <h3 class="hndle"><span>Get All Categories Codes</span></h3>
        <div class="inside">
          <div class="videogallery-field">
            <label for="videogallery_get_shortcode">Your Shortcode: </label>
            <input type="text" value="[video_categories]"  class="widefat" id="videogallery_get_shortcode" readonly>
            <span class="note">Copy and paste this shortcode into your Post, Page or Custom Post editor.</span>
            <div class="clear"></div>
          </div>
          <div class="videogallery-field last">
            <label for="videogallery_get_code">Your PHP Code: </label>
            <input type="text" value="&lt;?php if( function_exists('wpvg_get_all_categories') ) wpvg_get_all_categories(); ?&gt;" class="widefat" id="videogallery_get_code" readonly>
            <span class="note">Copy and paste this code when you need to display the slider in template files (header.php, front-page.php, etc.).</span>
            <div class="clear"></div>
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
      <div class="postbox " id="videogallery-slider-news">
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
  <form method="post" name="add_category" action="admin.php?page=gallery_options">
    <?php $counter_id = get_option('vcat_counter'); ?>
    <div id="category_add">
      <div id="cat_add_wrapper">
        <h3>Add New Category</h3>
        <input name="vcategory_name" type="text" value="" />
        <input name="cat_id" type="hidden" value="<?php echo $counter_id+1; ?>" />
        <input type="submit" class="button-primary addstyle" onClick="return wpvg_valid_category();" value="<?php _e( 'Add Category', 'vgallery' ); ?>" />
        <small>Enter the name of the Category</small> </div>
    </div>
    <div id="category-list">
      <div id="titles-cat"><span class="title_id"><strong>ID</strong></span><span class="slide_name"><strong>Title</strong></span><span class="slide_code"><strong>Shortcode</strong></span></div>
      <ul>
        <?php 	$category_exist = NULL;
		$i = 1;
			while($i<=$counter_id){
				if(get_option('vcategory_id_'.$i) !== FALSE){
					echo "<li><span class='title_id_list'>$i</span>
					<span class='title_list'><a href='?page=gallery_options&gallery_id=".$i."'>".get_option('vcategory_id_'.$i)." </span></a>
					<span class='action_edit'><a href='?page=gallery_options&gallery_id=".$i."'>Edit</a></span>
					<span class='action_delete'><a href='?page=gallery_options&cat_delete=".$i."'>Delete</a></span>
					<span class='short_code'>[gallery_videos id=&quot;".$i."&quot;]</span></li>";
					$category_exist = true;
				}
				$i++;
		}
		
		if($category_exist == NULL){
		 echo "<p class='notexist'> Category does not Exist. Please Add New Category </p>";
		}
		?>
      </ul>
      <div id="titles-cat"><span class="title_id"><strong>ID</strong></span><span class="slide-name"><strong>Title</strong></span></div>
    </div>
    <?php wp_nonce_field('wpvg_gallery_update','wpvg_gallery_nonce'); ?>
  </form>
</div>
<div id="right-section"> </div>
<script>
function wpvg_valid_category()
{
var x=document.forms["add_category"]["vcategory_name"].value;
if (x==null || x=="")
  {
  alert("Please enter the Category Name");
  return false;
  }
}
</script>
<?php } ?>
</div>
<?php
}



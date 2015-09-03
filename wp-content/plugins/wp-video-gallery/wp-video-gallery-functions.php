<?php /* 
====================================
===== Video Gallery Functions ======
=====   Author: Gulzar Ahmed   =====
====================================
*/

// Register the Scripts
function wpvg_video_gallery_scripts() {
		wp_register_script('video_slides', wp_vgurl."/includes/jquery.bxslider.js", array('jquery'),'1.1', true);
		wp_enqueue_script('video_slides');	
		wp_register_script('pretty_gallery_box', wp_vgurl."/includes/jquery.prettyPhoto.js", array('jquery'),'1.1', true);
		wp_enqueue_script('pretty_gallery_box');		
		wp_register_style('video_styles', wp_vgurl."/includes/wpvg-sliders-style.css");
		wp_enqueue_style('video_styles');
}
add_action( 'wp_enqueue_scripts', 'wpvg_video_gallery_scripts' ); 

// Call the JS Functions
function wpvg_video_gallery_ready(){ 
	// Get Settings
	$options = get_option( 'my_gallery_video_options' );
?>
	<script>
    jQuery(document).ready(function($){
	
      $('.slider4').bxSlider({
        slideWidth: <?php if(empty($options['slidewidth'])){ echo "226"; }else{ echo $options['slidewidth']; } ?>,
        minSlides: <?php if(empty($options['minslide'])){ echo "1"; }else{ echo $options['minslide']; } ?>,
        maxSlides: <?php if(empty($options['maxslide'])){ echo "4"; }else{ echo $options['maxslide']; } ?>,
        moveSlides: <?php if(empty($options['moveslide'])){ echo "1"; }else{ echo $options['moveslide']; } ?>,
        slideMargin: <?php if(empty($options['slidemargin'])){ echo "10"; }else{ echo $options['slidemargin']; } ?>,
		touchEnabled: <?php if($options['touch'] == 1){ echo "true"; }else{ echo "false"; } ?>,
		preloadImages: "all",
		responsive: <?php if(empty($options['responsive'])){ echo "true"; }else{ echo "false"; } ?>
      });
	  <?php // PrettyPhoto is totally free to use, it is released the GPLv2 (http://www.gnu.org/licenses/gpl-2.0.html) ?>
	  $(".slider4 a.vgimage").prettyPhoto({
		  default_width: 800,
		  default_height: 600,
		  theme: ' <?php if(empty($options['vgstyle']) or !isset($options['vgstyle'])){ echo "pp_default"; }else{ echo $options['vgstyle']; } ?>',
		  <?php if($options['sshare'] == 1){ /* Default */ }else{ echo "social_tools: false";  } ?>
	  });
	
    });
    </script>
<?php 
}
add_action('wp_footer','wpvg_video_gallery_ready');

// Play Button
function wpvg_play_button(){
	$options = get_option( 'my_gallery_video_options' );
	if(!isset($options['playbutton'])){
		return NULL;
	}else{
		return $options['playbutton'];
	}
}

// Play Button Image

function wpvg_play_button_image(){
	$options = get_option( 'my_gallery_video_options' );
	
	// Double Check Option is Saved
	if(isset($options['pbstyle'])){	
		  // BIG Play Button
		  if($options['pbstyle'] == "big_play"){	
			  $bg_image = "background-image:url('".wp_vgurl."/includes/images/big-play.png');";
			  $bg_position = "background-position:center;";
		  }elseif($options['pbstyle'] == "standard"){	
			  $bg_image = "background-image:url('".wp_vgurl."/includes/images/standard-play.png');";
			  $bg_position = "background-position:center;";
		  }else{
			  $bg_image = "background-image:url('".wp_vgurl."/includes/images/play_small_button.png');";
			  $bg_position = "background-position:4px 4px;";
		  }
	}else{
		$bg_image = "background-image:url('".wp_vgurl."/includes/images/play_small_button.png');";
		$bg_position = "background-position:4px 4px;";
	}
	
	$style = 'style="'.$bg_image.$bg_position.'"';
	return $style;
		
}

// Video Player Render
function wpvg_videos_render($videos_data, $play_button){
	
	$video_count = 0;
	$list_of_videos = array();
	$final_video = array();
	
	// Get Playbutton Settings
	if(!isset($play_button) or empty($play_button)) $play_button = wpvg_play_button();
	
	foreach($videos_data as $position_video => $single_video){

		if($video_count == 0){
			$list_of_videos['video_title'] = $single_video;
		}elseif($video_count == 1){
			$list_of_videos['video_link'] = $single_video;
		}
		
		$video_count++;
		// RESERT COUNT
		if($video_count == 3){
			$list_of_videos['video_thumbnail'] = $single_video;
			$final_video[] = $list_of_videos;
			$video_count = 0;
		}
		
	} ?>

<?php
	
	if($play_button == true){
		$play_area = '<small class="play_area" '.wpvg_play_button_image().'></small>';
	}else{
		$play_area = '';	
	}
	
	foreach($final_video as $one_video){ ?>
		
        <div class="slide"><a class="vgimage" href="<?php echo wp_strip_all_tags($one_video['video_link']); ?>" title="<?php echo wp_strip_all_tags(stripslashes($one_video['video_title'])); ?>"><img src="<?php echo wp_strip_all_tags($one_video['video_thumbnail']); ?>" /><?php echo $play_area; ?></a>
        <h4><?php echo wp_strip_all_tags(stripslashes($one_video['video_title'])); ?></h4>
        </div>
        
	<?php }
	
	
}

// Get All the by Gallery ID
function wpvg_get_category_videos($category_id = 1, $play_button = true){

if(get_option('video_gallery_'.$category_id) !== FALSE){
	  if($get_videos_data = get_option('video_gallery_'.$category_id)){
		  
		  if(!empty($get_videos_data)){
					
					$input_count = 0;
					
					foreach($get_videos_data as $position_video){
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
			if(get_option('vcategory_id_'.$category_id) !== FALSE){
				if($category_name = get_option('vcategory_id_'.$category_id)){
					$cat_name = $category_name;
				}	
			}else{
				$cat_name = "Not Specified";	
			}
			
			
			// Get the Category Name
				echo "<div id='category_name'><div id='category_wrapper'><h2>".$cat_name."</h2></div><div class='slider4'>"; 			
				wpvg_videos_render($get_videos_data,$play_button);
				echo "</div></div>";
	  }
  }else{
	  // Category not Found
	  echo "Category is not Exist.";  
	}
}


// Get All Categories
function wpvg_get_all_categories($play_button = true){
	
	if(get_option('vcat_counter') !== FALSE ){
		
		// Get the Data
		$counter_id = get_option('vcat_counter');
		
		if(!empty($counter_id)){

			$id = 1; // Default_id
			
			while($id<=$counter_id){
				if(get_option('vcategory_id_'.$id) !== FALSE){
					
					wpvg_get_category_videos($id,$play_button);
				}
				$id++;
			} 
				
		}
	}else{
		// if counter is False
		echo "You have not any category to show.";
			
	}
}

// Get the All Category Video  Shortcode
function wpvg_get_all_categories_shortcode( $atts ) {
      $atts = shortcode_atts( array(
 	      'play_button' => true
      ), $atts );
	  
	  ob_start(); ?>      
<?php wpvg_get_all_categories($atts['play_button']); ?>
<?php return ob_get_clean();
}
add_shortcode( 'video_categories', 'wpvg_get_all_categories_shortcode' );

// Get the Category Videos By ID
function wpvg_get_category_videos_shortcode( $atts ) {
      $atts = shortcode_atts( array(
  		'id' => NULL,
        'play_button' => ""
      ), $atts );
	  
	  ob_start(); ?>      
<?php wpvg_get_category_videos($atts['id'],$atts['play_button']); ?>
<?php return ob_get_clean();
}
add_shortcode( 'gallery_videos', 'wpvg_get_category_videos_shortcode' );
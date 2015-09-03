<?php
/*Plugin Name: Create Wedding Post
Description: This plugin registers the "wedding" post type.
Version: 1.0
*/


function create_wedding_type() {
// set up labels
	$labels = array(
 		'name' => 'Weddings',
    	'singular_name' => 'Wedding',
    	'add_new' => 'Add New Wedding',
    	'add_new_item' => 'Add New Wedding',
    	'edit_item' => 'Edit Wedding',
    	'new_item' => 'New Wedding',
    	'all_items' => 'All Weddings',
    	'view_item' => 'View Wedding',
    	'search_items' => 'Search Weddings',
    	'not_found' =>  'No Weddings Found',
    	'not_found_in_trash' => 'No Weddings found in Trash', 
    	'parent_item_colon' => '',
    	'menu_name' => 'Weddings',
    );
    //register post type
	register_post_type( 'wedding', array(
		'labels' => $labels,
		'has_archive' => true,
 		'public' => true,
		'supports' => array( 'title', 'editor', 'excerpt', 'custom-fields', 'thumbnail','page-attributes' ),
		'taxonomies' => array( 'post_tag', 'category' ),	
		'exclude_from_search' => false,
		'capability_type' => 'post',
		'rewrite' => array( 'slug' => 'weddings' ),
		)
	);

}
add_action( 'init', 'create_wedding_type' );


add_action( 'add_meta_boxes', 'wedding_date_box' );
function wedding_date_box() {
    add_meta_box( 
        'wedding_date_box',
        __( 'Wedding Date', 'myplugin_textdomain' ),
        'wedding_date_box_content',
        'wedding',
        'side',
        'high'
    );
}

function wedding_date_box_content( $post ) {
  wp_nonce_field( plugin_basename( __FILE__ ), 'wedding_date_box_content_nonce' );
  echo '<label for="wedding_date"></label>';
  echo '<input type="date" id="wedding_date" name="wedding_date" placeholder="enter a date" />';
}

add_action( 'save_post', 'wedding_date_box_save' );
function wedding_date_box_save( $post_id ) {

  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
  return;

  if ( !wp_verify_nonce( $_POST['wedding_date_box_content_nonce'], plugin_basename( __FILE__ ) ) )
  return;

  if ( 'page' == $_POST['post_type'] ) {
    if ( !current_user_can( 'edit_page', $post_id ) )
    return;
  } else {
    if ( !current_user_can( 'edit_post', $post_id ) )
    return;
  }
  $wedding_date = $_POST['wedding_date'];
  update_post_meta( $post_id, 'wedding_date', $wedding_date );
}

?>
<?php
add_action( 'wp_enqueue_scripts', 'enqueue_parent_theme_style' );
function enqueue_parent_theme_style() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
    wp_enqueue_style( 'parent-style', get_template_directory_uri().'/css/bootstrap.css' );
    wp_enqueue_style( 'parent-style', get_template_directory_uri().'/css/bootstrap.min.css' );
    wp_enqueue_style( 'parent-style', get_template_directory_uri().'/css/font-awesome.css' );
    wp_enqueue_style( 'parent-style', get_template_directory_uri().'/css/font-awesome.min.css' );
    wp_enqueue_style( 'parent-style', get_template_directory_uri().'/css/navmenu.css' );
}

/*
function my_custom_post_wedding() {
  $labels = array(
    'name'               => _x( 'Weddings', 'post type general name' ),
    'singular_name'      => _x( 'Wedding', 'post type singular name' ),
    'add_new'            => _x( 'Add New', 'wedding' ),
    'add_new_item'       => __( 'Add New Wedding' ),
    'edit_item'          => __( 'Edit Wedding' ),
    'new_item'           => __( 'New Wedding' ),
    'all_items'          => __( 'All Weddings' ),
    'view_item'          => __( 'View Wedding' ),
    'search_items'       => __( 'Search Weddings' ),
    'not_found'          => __( 'No weddings found' ),
    'not_found_in_trash' => __( 'No weddings found in the Trash' ), 
    'parent_item_colon'  => '',
    'menu_name'          => 'Weddings'
  );
  $args = array(
    'labels'        => $labels,
    'description'   => 'Holds our information for wedding subsites',
    'public'        => true,
    'menu_position' => 5,
    'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments' ),
    'has_archive'   => true,
  );
    register_post_type( 'wedding', $args ); 
}
add_action( 'init', 'my_custom_post_wedding' );

function my_updated_messages( $messages ) {
  global $post, $post_ID;
  $messages['wedding'] = array(
    0 => '', 
    1 => sprintf( __('Wedding updated. <a href="%s">View wedding</a>'), esc_url( get_permalink($post_ID) ) ),
    2 => __('Custom field updated.'),
    3 => __('Custom field deleted.'),
    4 => __('Wedding updated.'),
    5 => isset($_GET['revision']) ? sprintf( __('Wedding restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => sprintf( __('Wedding published. <a href="%s">View wedding</a>'), esc_url( get_permalink($post_ID) ) ),
    7 => __('Wedding saved.'),
    8 => sprintf( __('Wedding submitted. <a target="_blank" href="%s">Preview wedding</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    9 => sprintf( __('Wedding scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview product</a>'), date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
    10 => sprintf( __('Wedding draft updated. <a target="_blank" href="%s">Preview wedding</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );
  return $messages;
}
add_filter( 'post_updated_messages', 'my_updated_messages' );

add_action( 'add_meta_boxes', 'wedding_date' );
function wedding_date() {
    add_meta_box( 
        'wedding_date',
        __( 'Wedding Date', 'myplugin_textdomain' ),
        'wedding_date_content',
        'wedding',
        'side',
        'high'
    );
}

function wedding_date_content( $post ) {
  wp_nonce_field( plugin_basename( __FILE__ ), 'wedding_date_content_nonce' );
  echo '<label for="wedding_date"></label>';
  echo '<input type="text" id="wedding_date" name="wedding_date" placeholder="enter a wedding date" />';
}

add_action( 'save_post', 'wedding_date_save' );
function wedding_date_save( $post_id ) {

  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
  return;

  if ( !wp_verify_nonce( $_POST['product_price_box_content_nonce'], plugin_basename( __FILE__ ) ) )
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

add_action( 'add_meta_boxes', 'shareable_link' );
function shareable_link() {
    add_meta_box( 
        'shareable_link',
        __( 'Shareable Link', 'myplugin_textdomain' ),
        'shareable_link_content',
        'wedding',
        'side',
        'high'
    );
}

function shareable_link_content( $pos ) {
  wp_nonce_field( plugin_basename( __FILE__ ), 'wedding_date_content_nonce' );
  echo '<label for="shareable_link"></label>';
  echo '<input type="text" id="shareable_link" name="shareable_link" placeholder="shareable link" />';
}

add_action( 'save_post', 'shareable_link_save' );
function shareable_link_save( $post_id ) {

  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
  return;

  if ( !wp_verify_nonce( $_POST['shareable_link_content'], plugin_basename( __FILE__ ) ) )
  return;

  if ( 'page' == $_POST['post_type'] ) {
    if ( !current_user_can( 'edit_page', $post_id ) )
    return;
  } else {
    if ( !current_user_can( 'edit_post', $post_id ) )
    return;
  }
  $shareable_link = $_POST['shareable_link'];
  update_post_meta( $post_id, 'shareable_link', $shareable_link );
}

*/








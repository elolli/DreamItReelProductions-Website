<?php
/*
Plugin Name: Save the Date
Plugin URI: http://wp.tutsplus.com/
Description: Declares a plugin that will create a custom post type displaying save the dates.
Version: 1.0
Author: Elise Lawley
Author URI: http://wp.tutsplus.com/
License: GPLv2
*/


add_action( 'init', 'create_save_the_date' );

function create_save_the_date() {
    register_post_type('save_the_date',
        array(
            'labels' => array(
                'name' => 'Save the Dates',
                'singular_name' => 'Save the Date',
                'add_new' => 'Add New',
                'add_new_item' => 'Add New Save the Date',
                'edit' => 'Edit',
                'edit_item' => 'Edit Save the Date',
                'new_item' => 'New Save the Date',
                'view' => 'View',
                'view_item' => 'View Save the Date',
                'search_items' => 'Search Save the Dates',
                'not_found' => 'No Save the Dates found',
                'not_found_in_trash' => 'No Save the Dates found in Trash',
                'parent' => 'Parent Save the Date'
            ),
 
            'public' => true,
            'menu_position' => 15,
            'supports' => array( 'title', 'editor', 'comments', 'thumbnail'),
            'taxonomies' => array( '' ),
            'menu_icon' => plugins_url( 'images/icon.png', __FILE__ ),
            'has_archive' => true
        )
    );
}


add_action( 'admin_init', 'my_admin' );
function my_admin() {
    add_meta_box( 'save_the_date_meta_box',
        'Save the Date Details',
        'display_save_the_date_meta_box',
        'save_the_date', 'normal', 'high'
    );
}

function display_save_the_date_meta_box( $save_the_date ) {
    // Retrieve current name of the Director and Movie Rating based on review ID
    $wedding_bride = esc_html( get_post_meta( $save_the_date->ID, 'wedding_bride', true ) );
    $wedding_groom = esc_html( get_post_meta( $save_the_date->ID, 'wedding_groom', true ) );
    $wedding_date = esc_html( get_post_meta( $save_the_date->ID, 'wedding_date', true ) );
    $wedding_color01 = esc_html(get_post_meta( $save_the_date->ID, 'wedding_color01', true ) );
    $wedding_color02 = esc_html(get_post_meta( $save_the_date->ID, 'wedding_color02', true ) );
    $wedding_color03 = esc_html( get_post_meta( $save_the_date->ID, 'wedding_color03', true ) );
    $wedding_location = esc_html( get_post_meta( $save_the_date->ID, 'wedding_location', true ) );
    $wedding_hashtag = esc_html( get_post_meta( $save_the_date->ID, 'wedding_hashtag', true ) );
    $wedding_form_shortcode = esc_html( get_post_meta( $save_the_date->ID, 'wedding_form_shortcode', true ) );
    ?>
    <table>
    <tr>
          <td style="width: 100%">Bride</td>
            <td><input type="text" size="50" name="save_the_date_bride" value="<?php echo $wedding_bride; ?>" /></td>  
        </tr>
        <tr>
          <td style="width: 100%">Groom</td>
            <td><input type="text" size="50" name="save_the_date_groom" value="<?php echo $wedding_groom; ?>" /></td>  
        </tr>
        <tr>
            <td style="width: 100%">Wedding Date</td>
            <td><input type="date" size="50" name="save_the_date_wedding_date" value="<?php echo $wedding_date; ?>" /></td>
        </tr>
        <tr>
            <td style="width: 100%">Wedding Color</td>
            <td>
            <input class = "ir" name="save_the_date_wedding_color01" value="<?php echo $wedding_color01; ?>" />
            <input class = "ir" name="save_the_date_wedding_color02" value="<?php echo $wedding_color02; ?>" />
            <input class = "ir" name="save_the_date_wedding_color03" value="<?php echo $wedding_color03; ?>" />
            </td>
        </tr>
        <tr>
            <td style="width: 100%">Location</td>
            <td><input type="text" size="50" name="save_the_date_location" value="<?php echo $wedding_location; ?>" /></td>
        </tr>
        <tr>
            <td style="width: 100%">Hashtag</td>
            <td><input type="text" size="50" name="save_the_date_wedding_hashtag" value="<?php echo $wedding_hashtag; ?>" /></td>
        </tr>
        <tr>
            <td style="width: 100%">DropBox Form Shortcode</td>
            <td><input type="text" size="50" name="save_the_date_form_shortcode" value="<?php echo $wedding_form_shortcode; ?>" /></td>
        </tr>
    </table>
    <?php
}

add_action( 'save_post', 'add_save_the_date_fields',10, 9);
function add_save_the_date_fields( $save_the_date_id, $save_the_date) {
    // Check post type for save the dates
    if ( $save_the_date->post_type == 'save_the_date' ) {
            // Store data in post meta table if present in post data
            if ( isset( $_POST['save_the_date_bride'] ) && $_POST['save_the_date_bride'] != '' ) {
                update_post_meta( $save_the_date_id, 'wedding_bride', $_POST['save_the_date_bride'] );
            }
            if ( isset( $_POST['save_the_date_groom'] ) && $_POST['save_the_date_groom'] != '' ) {
                update_post_meta( $save_the_date_id, 'wedding_groom', $_POST['save_the_date_groom'] );
            }
            if ( isset( $_POST['save_the_date_wedding_date'] ) && $_POST['save_the_date_wedding_date'] != '' ) {
                update_post_meta( $save_the_date_id, 'wedding_date', $_POST['save_the_date_wedding_date'] );
            }
            if ( isset( $_POST['save_the_date_wedding_color01'] ) && $_POST['save_the_date_wedding_color01'] != '' ) {
                update_post_meta( $save_the_date_id, 'wedding_color01', $_POST['save_the_date_wedding_color01'] );
            }
            if ( isset( $_POST['save_the_date_wedding_color02'] ) && $_POST['save_the_date_wedding_color02'] != '' ) {
                update_post_meta( $save_the_date_id, 'wedding_color02', $_POST['save_the_date_wedding_color02'] );
            }
            if ( isset( $_POST['save_the_date_wedding_color03'] ) && $_POST['save_the_date_wedding_color03'] != '' ) {
                update_post_meta( $save_the_date_id, 'wedding_color03', $_POST['save_the_date_wedding_color03'] );
            }
            if ( isset( $_POST['save_the_date_location'] ) && $_POST['save_the_date_location'] != '' ) {
                update_post_meta( $save_the_date_id, 'wedding_location', $_POST['save_the_date_location'] );
            }
            if ( isset( $_POST['save_the_date_wedding_hashtag'] ) && $_POST['save_the_date_wedding_hashtag'] != '' ) {
                update_post_meta( $save_the_date_id, 'wedding_hashtag', $_POST['save_the_date_wedding_hashtag'] );
            }
            if ( isset( $_POST['save_the_date_form_shortcode'] ) && $_POST['save_the_date_form_shortcode'] != '' ) {
                update_post_meta( $save_the_date_id, 'wedding_form_shortcode', $_POST['save_the_date_form_shortcode'] );
            }
     }
}


add_filter( 'template_include', 'include_template_function', 1 );
function include_template_function( $template_path ) {
    if ( get_post_type() == 'save_the_date' ) {
        if ( is_single() ) {
            // checks if the file exists in the theme first,
            // otherwise serve the file from the plugin
            if ( $theme_file = locate_template( array ( 'single-save_the_date.php' ) ) ) {
                $template_path = $theme_file;
            } else {
                $template_path = plugin_dir_path( __FILE__ ) . '/single-save_the_date.php';
            }
        }
    }
    return $template_path;
}


add_action( 'admin_enqueue_scripts', 'wp_enqueue_color_picker' );
function wp_enqueue_color_picker( $hook_suffix ) {
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'wp-color-picker');
    wp_enqueue_script( 'wp-color-picker-script-handle', plugins_url('wp-color-picker-script.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
}



?>

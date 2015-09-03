
<?php
    
    add_action( 'wp_enqueue_scripts', 'safely_add_stylesheet' );

    /**
     * Add stylesheet to the page
     */
    function safely_add_stylesheet() {
        wp_enqueue_style( 'prefix-style', plugins_url('style.css', __FILE__) );
    }

    function load_fonts() {
            wp_register_style('et-googleFonts', 'http://fonts.googleapis.com/css?family=Great+Vibes');
            wp_enqueue_style( 'et-googleFonts');
        }
    add_action('wp_print_styles', 'load_fonts');

get_header(); 
?>

<div id="primary">
    <div id="content" role="main">
    <!--Search query for post-->
    <?php $mypost = array( 'post_type' => 'save_the_dates', );
    $loop = new WP_Query( $mypost );?>
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?> >
    <div id = "wedding-background">


    <header id = "Wedding-header"> 
        
        <div id="Wedding-cover-image">
        <?php if (has_post_thumbnail( $post->ID ) ): ?>
  <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' ); ?>
  <div id="custom-bg" style="width: 100%; height: 500px; background-position: center center;
  background-repeat: no-repeat; background-image: url('<?php echo $image[0]; ?>')">
  </div>
<?php endif; ?>
        </div>

        <div id="title-container">
 <h2 id = "wedding-date-location">
     <span id = "wedding-date" ><?php echo esc_html( get_post_meta( get_the_ID(), 'wedding_date', true ) ); ?></span> </h2>
        <h1 id = "wedding-title"><?php echo esc_html( get_post_meta( get_the_ID(), 'wedding_bride', true ) ); ?> and <?php echo esc_html( get_post_meta( get_the_ID(), 'wedding_groom', true ) ); ?></h1>
        <h2 id = "wedding-location"> are getting married in <?php echo esc_html( get_post_meta( get_the_ID(), 'wedding_location', true ) ); ?> </span>
            </h2>
                            <p id = "wedding-form_label">Upload all your photos and videos from the wedding here!</p>

                    <h1 id = "wedding-hashtag"><?php echo esc_html( get_post_meta( get_the_ID(), 'wedding_hashtag', true ) ); ?></h1>

        <div>
            <!-- Display Cover Photo -->   
            <?php $shortcode = esc_html( get_post_meta( get_the_ID(), 'wedding_form_shortcode', true ) );
            echo do_shortcode($shortcode); ?>
        </div>
        </div>
        </header>
    </div>

             <body id = "wedding-body">

<!--Styling for poloroid-->
        
            </body>

         </article>
 
    </div>
</div>

<?php wp_register_style('myStyleSheet', 'style.php');
wp_enqueue_style( 'myStyleSheet'); ?>

<?php get_footer(); ?>
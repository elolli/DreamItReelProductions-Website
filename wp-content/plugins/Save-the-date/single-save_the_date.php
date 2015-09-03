
<?php
    
    add_action( 'wp_enqueue_scripts', 'safely_add_stylesheet' );

    /**
     * Add stylesheet to the page
     */
    function safely_add_stylesheet() {
        wp_enqueue_style( 'prefix-style', plugins_url('style.css', __FILE__) );
    }

add_action( 'wp_enqueue_scripts', 'load_fonts' );
    function load_fonts() {
            wp_register_style('first-googleFonts', 'http://fonts.googleapis.com/css?family=Great+Vibes');
              wp_enqueue_style( 'first-googleFonts');
            wp_register_style('et-googleFonts', 'https://fonts.googleapis.com/css?family=Raleway:400,200,300');
            wp_enqueue_style( 'et-googleFonts');

        }
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
     <div id = "writing">
     <span id = "wedding-date spacer" ><?php 
     $weddingdate_toprint = esc_html( get_post_meta( get_the_ID(), 'wedding_date', true ) ); 
echo '<p><span>'.$weddingdate_toprint.'</span></p>';
     ?></span> 
        <h1 id = "wedding-title"><?php echo esc_html( get_post_meta( get_the_ID(), 'wedding_bride', true ) ); ?> & <?php echo esc_html( get_post_meta( get_the_ID(), 'wedding_groom', true ) ); ?></h1>
        <p><span> are getting married in <?php echo esc_html( get_post_meta( get_the_ID(), 'wedding_location', true ) ); ?> </span>
            </p></div>
  </div>
<?php endif; ?>
        </div>
         </header>
 <body id = "wedding-body">
        <div id="title-container">
 
                            <p id = "wedding-form_label">Upload all your photos and videos from the wedding here!</p>

                    <h1 id = "wedding-hashtag"><?php echo esc_html( get_post_meta( get_the_ID(), 'wedding_hashtag', true ) ); ?></h1>

        <div>
            <?php $shortcode = esc_html( get_post_meta( get_the_ID(), 'wedding_form_shortcode', true ) );
            echo do_shortcode($shortcode); ?>
        </div>
        </div>
       
    </div>

            
<!--Styling for poloroid-->
        
            </body>

         </article>
 
    </div>
</div>

<?php wp_register_style('myStyleSheet', 'style.php');
wp_enqueue_style( 'myStyleSheet'); ?>

<?php get_footer(); ?>
<?php
 /*Template Name: New Template
 */
 
get_header(); 
?>
<div id="primary">
    <div id="content" role="main">
    <?php
    $mypost = array( 'post_type' => 'save_the_dates', );
    $loop = new WP_Query( $mypost );
    ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>
         <header class="entry-header">
            
            <!-- Display Cover Photo -->
             <div id = "cover-image" style = "position: relative; border: 15px solid white; padding-bottom: 10%; background-color: white; overflow: hidden; text-align: center !important;">
                <?php the_post_thumbnail( array( 300, 300 ) ); ?>
             </div>

             <div id = "title-container" style = "position: relative;
    padding: 5px 10px 20px 0;
    text-align: center;
    background-color: white;">
             <h1 id = "wedding-title" style = "font-family: "Roboto Condensed";
    font-size: 50px;
    font-style: normal;
    font-weight: 300;
    color: #000;
    text-transform: uppercase;margin: 6px 0 8px 0;
    line-height: 1;"><?php echo esc_html( get_post_meta( get_the_ID(), 'wedding_bride', true ) ); ?> and <?php echo esc_html( get_post_meta( get_the_ID(), 'wedding_groom', true ) ); ?></h1>
             
             <h2 id = "wedding-date-location" style = "font-family: 'Times New Roman';
    font-size: 16px;
    font-style: normal;
    font-weight: normal;
    color: #000;
    letter-spacing: 0.4px;"><?php echo esc_html( get_post_meta( get_the_ID(), 'wedding_location', true ) ); ?> </h2>
             <h2 id = "wedding-countdown"><?php echo esc_html( get_post_meta( get_the_ID(), 'wedding_date', true ) ); ?>
             </h2>
             </div>


             </header>


             
             <body>

 
            </body>
 
            <!-- Display movie review contents -->
            <div class="entry-content"><?php the_content(); ?></div>
        </article>
 
    </div>
</div>
<?php wp_reset_query(); ?>
<?php get_footer(); ?>
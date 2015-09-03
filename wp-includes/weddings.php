<?php
    $args = array(
      'post_type' => 'wedding',
      'tax_query' => array(
      )
    );
    $weddings = new WP_Query( $args );
    if( $weddings->have_posts() ) {
      while( $weddings->have_posts() ) {
        $weddings->the_post();
        ?>
          <h1><?php the_title() ?></h1>
          <div class='content'>
            <?php the_content() ?>
          </div>
        <?php
      }
    }
    else {
      echo 'Oh ohm no weddings!';
    }
  ?>
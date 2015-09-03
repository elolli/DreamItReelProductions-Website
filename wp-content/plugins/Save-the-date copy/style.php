<?php
// We'll be outputting CSS
header('Content-type: text/css');

include('single-save_the_date.php');    
?>

.polaroid {
  background-color: black;
  font-size: <?php echo $image; ?>;
}


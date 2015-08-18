<div class="post_preview">
  <div>
  <a class="" href="<?php echo get_permalink($post->ID); ?>">
<?php 
    if(has_post_thumbnail( $post->ID ) ){
      $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'thumbnail' ); 
      $imgurl=$image[0];
?>
      <img src="<?php echo $imgurl; ?>" style="width:160px; height:auto; margin:.5em;"/>
<?php 
  }
?>
      <h4 class="name"><?php echo display_name_format(get_the_title()); ?></h4>

    </a>
    <p class="post_excerpt"><?php echo get_the_excerpt(); ?></p>
  </div>
    <?php
    $terms = wp_get_post_terms( $post->ID, 'topics', array("fields" => "all") );
    if(!empty($terms)){
      echo '<ul class="topics">';
      $even_or_odd="odd";
      foreach( $terms as $term ){
        echo '<li class="topic '.$even_or_odd.'">';
        echo '<a href="'. home_url('/erg-search/?search_for='.$term->name ) .'" alt="Search the ERG website for this term">'. $term->name .'</a>';
        // echo ($term->count > 1) ? ('<a href="'. get_term_link($term) .'">'. $term->name .'</a>') : $term->name;
        echo '</li>';
        $even_or_odd=($even_or_odd=="odd" ? "even" : "odd");
      }
      echo '</ul>';
    }
    ?>
    <!-- <button type="button" class="btn btn-link btn-block btn-xs"><a class="post_preview_link" href="<?php echo get_permalink($post->ID); ?>">Go to <?php echo display_name_format(get_the_title()); ?>&apos;s Page <span class="glyphicon glyphicon-arrow-right"></span></a></button> -->
</div>

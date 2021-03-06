<?php
/**
 *
 * @package 	WordPress
 * @subpackage 	Starkers
 * @since 		Starkers 4.0
 */
?>
<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
<?php $person_type="Student"; ?>

<div class="container">
<div class="row">
      <?php Starkers_Utilities::get_template_parts( array( 'parts/shared/page-menu' ) ); ?>
      <div class="col-md-10 content">
        <div class="row">
          <h2 class="section_heading">ERG <?php the_title(); ?></h2>
          <?php
            the_content();
          ?>
          <?php
          $query = new WP_Query( array( 'post_type' => 'people', 'position'=>'student', 'posts_per_page' => '1', 'order' => 'ASC', 'orderby' => 'modified', 'tag__in'=>array(80)));
          // tag id 80 is "spotlight"
          if ( $query->have_posts() ) {
          	while ( $query->have_posts() ) {
          		$query->the_post();
              Starkers_Utilities::get_template_parts( array( 'parts/shared/people-spotlight' ) ); 
          	}
          } 
          wp_reset_postdata();
        ?>    
      </div>
        <?php
          $query = new WP_Query( array( 'post_type' => 'people', 'position'=>'student', 'posts_per_page' => '-1', 'offset' => '0', 'order' => 'ASC', 'orderby' => 'title' ));
          if ( $query->have_posts() ) {
            $number_of_columns=4;
            $posts_per_column=ceil(($query->post_count)/$number_of_columns);
            $current_post=0;
            $current_column=0;
            $current_post_in_current_column=0;
            // echo '<div class="row">'; // wraps the whole people grid
          	while ( $query->have_posts() ) {
              if(($current_column==0 || $current_column==2) && $current_post_in_current_column==0){
                echo '<div class="col-sm-6 column_level_1"><div class="row">'; // this is a 1st level column containing two more columns
                echo '<div class="alpha_index hidden-md hidden-lg" data-range-start="'. substr(get_the_title($post->ID),0,1) .'" data-range-end=""><a name="'. substr(get_the_title($post->ID),0,1) .'"></a><span>– '.substr(get_the_title($post->ID),0,1).' –</span></div>';
              }
          		$query->the_post();
              if($current_post_in_current_column==0){
                echo '<div class="col-sm-12 col-md-6 column_level_2 even_height_column">';
                echo '<div class="alpha_index hidden-xs hidden-sm" data-range-start="'. substr(get_the_title($post->ID),0,1) .'" data-range-end=""><a name="'. substr(get_the_title($post->ID),0,1) .'"></a><span>– '.substr(get_the_title($post->ID),0,1).' –</span></div>';
                echo '<div class="people_container">';
              }
        		  Starkers_Utilities::get_template_parts( array( 'parts/shared/people-preview-rows' ) ); 
              $current_post++;
              $current_post_in_current_column++;
              if(($current_column<$number_of_columns-1 && $current_post_in_current_column>=$posts_per_column) || $current_post>=$query->post_count){
                echo '</div><!-- .people_container --></div><!-- .column_level_2 '. $current_post.','.$current_post_in_current_column.','.$current_column.' -->';
                $current_post_in_current_column=0;
                if($current_column==1 || $current_column==3) {
                  echo '</div></div><!-- .column_level_1 '. $current_post.','.$current_post_in_current_column.','.$current_column.' -->';
                }
                $current_column++;
                if($current_column<$number_of_columns) $posts_per_column=ceil(($query->post_count-$current_post)/($number_of_columns-$current_column));
              }
          	}
          } else { ?>
          	<div class="alert alert-danger">Content not found.</div>
          <?php }
          wp_reset_postdata();
        ?>
      </div>
    </div>
</div>

<?php endwhile; ?>

<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>
<script>
$(document).ready(function(){
  do_even_columns();
  set_alpha_indexes();
})
</script>
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

<div class="container">
  <div class="row">
      <?php Starkers_Utilities::get_template_parts( array( 'parts/shared/page-menu' ) ); ?>
      <div class="col-md-10 content">
          <h2 class="section_heading">ERG <?php the_title(); ?></h2>
          <?php
            the_content();
          ?>
          <?php
          $query = new WP_Query( array( 'post_type' => 'people', 'position'=>'faculty', 'posts_per_page' => '-1', 'order' => 'ASC', 'orderby' => 'title', 'tag__in'=>array(80)));
          // tag id 80 is "spotlight"
          if ( $query->have_posts() ) {
            $person_type="Faculty";
          	while ( $query->have_posts() ) {
          		$query->the_post();
          		$columns_per_preview=6;
        		  Starkers_Utilities::get_template_parts( array( 'parts/shared/people-spotlight' ) ); 
          	}
          } 
          wp_reset_postdata();
        ?>    
        <?php
          // tag__not_in removes 'in memorium' and 'emeritus' faculty from faculty list
          // $query = new WP_Query( array( 'post_type' => 'people', 'tag__not_in'=>array(63,61,80), 'position'=>'faculty', 'posts_per_page' => '-1', 'offset' => '0', 'order' => 'ASC', 'orderby' => 'title' ));
          $query = new WP_Query( array( 'post_type' => 'people', 'position'=>'faculty', 'posts_per_page' => '-1', 'offset' => '0', 'order' => 'ASC', 'orderby' => 'title' ));
          if ( $query->have_posts() ) {
            $person_type="Faculty";
            $number_of_columns=3; // 3 cols breaks down to 1 in xs
            $posts_per_column=ceil(($query->post_count)/$number_of_columns);
            $current_post=0;
            $current_column=0;
            $current_post_in_current_column=0;
            echo '<div class="row">'; // wraps the whole people grid
          	while ( $query->have_posts() ) {
              if($current_post_in_current_column==0){
                echo '<div class="col-sm-4 column_level_2 even_height_column">';
                echo '<div class="people_container">';
              }
          		$query->the_post();
        		  Starkers_Utilities::get_template_parts( array( 'parts/shared/people-preview-rows' ) ); 
              $current_post++;
              $current_post_in_current_column++;
              if(($current_column<$number_of_columns-1 && $current_post_in_current_column>=$posts_per_column) || $current_post>=$query->post_count){
                echo '</div></div><!-- .column_level_2 '. $current_post.','.$current_post_in_current_column.','.$current_column.' -->';
                $current_post_in_current_column=0;
                $current_column++;
                if($current_column<$number_of_columns) $posts_per_column=ceil(($query->post_count-$current_post)/($number_of_columns-$current_column));
              }
          	}
          	echo '</div>';
          } else { ?>
          	<div class="alert alert-danger">Content not found.</div>
          <?php }
          wp_reset_postdata();
        ?>
        <div class="section_divider">
          <h3 class="section_heading">Faculty Emeritus</h3>
        </div>
        <?php
          $query = new WP_Query( array( 'post_type' => 'people', 'position'=>'professor-emeritus', 'posts_per_page' => '-1', 'order' => 'ASC', 'orderby' => 'title') );
          // $query = new WP_Query( array( 'tag__in'=>array('emeritus') ));
          if ( $query->have_posts() ) {
            $person_type="Faculty Emeritus";
            $number_of_columns=3; // 3 cols breaks down to 1 in xs
            $posts_per_column=ceil(($query->post_count)/$number_of_columns);
            $current_post=0;
            $current_column=0;
            $current_post_in_current_column=0;
            echo '<div class="row">'; // wraps the whole people grid
          	while ( $query->have_posts() ) {
              if($current_post_in_current_column==0){
                echo '<div class="col-sm-4 column_level_2">';
              }
          		$query->the_post();
        		  Starkers_Utilities::get_template_parts( array( 'parts/shared/people-preview-rows' ) ); 
              $current_post++;
              $current_post_in_current_column++;
              if(($current_column<$number_of_columns-1 && $current_post_in_current_column>=$posts_per_column) || $current_post>=$query->post_count){
                echo '</div><!-- .column_level_2 '. $current_post.','.$current_post_in_current_column.','.$current_column.' -->';
                $current_post_in_current_column=0;
                $current_column++;
                if($current_column<$number_of_columns) $posts_per_column=ceil(($query->post_count-$current_post)/($number_of_columns-$current_column));
              }
          	}
          	echo '</div>';
          } else { ?>
          	<div class="alert alert-danger">Content not found.</div>
          <?php }
          wp_reset_postdata();
        ?>
        <div class="section_divider">
          <h3 class="section_heading">In Memoriam</h3>
        </div>
        <?php
          $query = new WP_Query( array( 'post_type' => 'people', 'position'=>'in-memoriam-2', 'posts_per_page' => '-1', 'order' => 'ASC', 'orderby' => 'title' ));
          if ( $query->have_posts() ) {
            $person_type="Faculty In Memorium";
            $number_of_columns=3; // 3 cols breaks down to 1 in xs
            $posts_per_column=ceil(($query->post_count)/$number_of_columns);
            $current_post=0;
            $current_column=0;
            $current_post_in_current_column=0;
            echo '<div class="row">'; // wraps the whole people grid
          	while ( $query->have_posts() ) {
              if($current_post_in_current_column==0){
                echo '<div class="col-sm-4 column_level_2">';
              }
          		$query->the_post();
        		  Starkers_Utilities::get_template_parts( array( 'parts/shared/people-preview-rows' ) ); 
              $current_post++;
              $current_post_in_current_column++;
              if(($current_column<$number_of_columns-1 && $current_post_in_current_column>=$posts_per_column) || $current_post>=$query->post_count){
                echo '</div><!-- .column_level_2 '. $current_post.','.$current_post_in_current_column.','.$current_column.' -->';
                $current_post_in_current_column=0;
                $current_column++;
                if($current_column<$number_of_columns) $posts_per_column=ceil(($query->post_count-$current_post)/($number_of_columns-$current_column));
              }
          	}
          	echo '</div>';
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
})
</script>
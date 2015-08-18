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

<?php $person_type="Visiting Scholar"; ?>

<div class="container">
  <div class="row">
      <?php Starkers_Utilities::get_template_parts( array( 'parts/shared/page-menu' ) ); ?>
      <div class="col-md-10 content">
          <h2 class="section_heading">ERG <?php the_title(); ?></h2>
          <?php
            the_content();
          ?>
        <?php
        $query = new WP_Query( array( 'post_type' => 'people', 'position'=>'researcher', 'posts_per_page' => '-1', 'order' => 'ASC', 'orderby' => 'title') );

          if ( $query->have_posts() ) {
            $number_of_columns=3; // 3 cols breaks down to 1 in xs
            $posts_per_column=ceil(($query->post_count)/$number_of_columns);
            $current_post=0;
            $current_column=0;
            $current_post_in_current_column=0;
            echo '<div class="row even_height_container">'; // wraps the whole people grid
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
          	<div class="alert">No visiting scholars, researchers or post docs found.</div>
          <?php }
          wp_reset_postdata();
        ?>
        <div class="section_divider">
          <h3 class="section_heading">Past Visiting Scholars, Researchers &amp; Post Docs</h3>
        </div>
        <?php
          $query = new WP_Query( array( 'post_type' => 'people', 'position'=>'past-researcher', 'posts_per_page' => '-1', 'order' => 'ASC', 'orderby' => 'title') );
          if ( $query->have_posts() ) {
            $number_of_columns=3; // 3 cols breaks down to 1 in xs
            $posts_per_column=ceil(($query->post_count)/$number_of_columns);
            $current_post=0;
            $current_column=0;
            $current_post_in_current_column=0;
            echo '<div class="row even_height_container">'; // wraps the whole people grid
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
          } else { 
          ?>
          	<div class="alert ">No past visiting scholars, researchers or post docs found.</div>
          <?php 
            } wp_reset_postdata();
          ?>
      </div>
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
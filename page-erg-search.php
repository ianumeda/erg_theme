<?php
/**
 * Search results page
 * 
 * Please see /external/starkers-utilities.php for info on Starkers_Utilities::get_template_parts()
 *
 * @package 	WordPress
 * @subpackage 	Starkers
 * @since 		Starkers 4.0
 */
?>
<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>
<?php $search_query=htmlspecialchars($_GET["search_for"]); ?>
<div class="container">
  <div class="page row">
    <div class="col-lg-10 col-lg-offset-1 ">
      <div class="row">
        <div class="col-xs-12">
          <?php Starkers_Utilities::get_template_parts( array( 'parts/shared/searchform' ) ); ?>
        </div>
      </div>
      <?php if ( have_posts() ): ?>
      <h2 class="section_heading">Search Results for '<strong><?php echo $search_query; ?></strong>'</h2>	
      <div class="row">
        <div class="col-md-8 col-md-push-2 col-sm-10 col-sm-push-1">
      <?php while ( have_posts() ) : the_post(); ?>
      <?php endwhile; ?>
        </div>
      <?php else: ?>
      <h2 class="section_heading">No results found for '<?php echo get_search_query(); ?>'</h2>
      <?php endif; ?>
      </div>
      <div class="row">

<?php
if(!$search_query){
  echo '<div class="alert alert-warning">Put your search terms in the search field above</div>';
} else {
  // show search results in 'people' (separated into position), 'news', 'events'
  
  $args=array( 'post_type' => 'page', 'posts_per_page' => '-1', 'order' => 'ASC', 'orderby' => 'title', 's'=>$search_query );
  $page_query = new WP_Query( $args );
  $args=array( 'post_type' => 'people', 'position'=>'faculty', 'posts_per_page' => '-1', 'order' => 'ASC', 'orderby' => 'title', 's'=>$search_query );
  $faculty_query = new WP_Query( $args );
  $args=array( 'post_type' => 'people', 'position'=>'student', 'posts_per_page' => '-1', 'order' => 'ASC', 'orderby' => 'title', 's'=>$search_query );
  $student_query = new WP_Query( $args );
  $args=array( 'post_type' => 'people', 'position'=>'alumni', 'posts_per_page' => '-1', 'order' => 'ASC', 'orderby' => 'title', 's'=>$search_query );
  $alumni_query = new WP_Query( $args );
  $args=array( 'post_type' => 'people', 'position'=>'researcher', 'posts_per_page' => '-1', 'order' => 'ASC', 'orderby' => 'title', 's'=>$search_query );
  $researcher_query = new WP_Query( $args );
  $args=array( 'post_type' => 'post', 'category_name'=>'news', 'posts_per_page' => '-1', 'order' => 'DESC', 'orderby' => 'date', 's'=>$search_query );
  $news_query = new WP_Query( $args );
  $args = array( 'post_status'=>'publish', 'post_type'=>array(TribeEvents::POSTTYPE), 'posts_per_page'=>10,
    //order by startdate from newest to oldest
    'meta_key'=>'_EventStartDate',
    'orderby'=>'_EventStartDate',
    'order'=>'DESC',
    //required in 3.x
    'eventDisplay'=>'custom',
    //query events by category
    's'=>$search_query
    );
  $event_query = new WP_Query( $args );
  $args = array(
  	'post_type' => array('post', 'people'),
  	'tax_query' => array(
  		array(
  			'taxonomy' => 'topics',
  			'field'    => 'slug',
  			'terms'    => $search_query,
  		),
  	),
  );
  $topic_query=new WP_Query( $args );

  
  echo '<div class="col-sm-12" style="text-align:center;">';
  echo '<ul class="nav nav-pills">';
  echo '<li><a href="#pages">ERG Site ('.$page_query->post_count.')</a></li>';
  echo '<li><a href="#faculty">Faculty ('.$faculty_query->post_count.')</a></li>';
  echo '<li><a href="#students">Students ('.$student_query->post_count.')</a></li>';
  echo '<li><a href="#alumni">Alumni ('.$alumni_query->post_count.')</a></li>';
  echo '<li><a href="#researchers">Post Docs & Researchers ('.$researcher_query->post_count.')</a></li>';
  echo '<li><a href="#news">News ('.$news_query->post_count.')</a></li>';
  echo '<li><a href="#events">Events ('.$event_query->post_count.')</a></li>';
  echo '<li><a href="#topics">Topic Links ('.$topic_query->post_count.')</a></li>';
  echo '</ul>';
  echo '</div>';
  if ( $page_query->have_posts() ) {
    echo '<div class="row">';
    echo '<a class="anchor" id="pages"></a>';
    echo '<div class="section_divider"> <h3 class="section_heading">ERG Site</h3> </div>';
    echo '<div class="col-sm-6 col-sm-push-3 col-xs-8 col-xs-push-2">';
  	while ( $page_query->have_posts() ) {
  		$page_query->the_post();
		  Starkers_Utilities::get_template_parts( array( 'parts/shared/post-preview' ) ); 
    }
    echo '</div>';
    echo '</div>';
  }
  if ( $faculty_query->have_posts() ) {
    echo '<div class="row">';
    echo '<a class="anchor" id="faculty"></a>';
    echo '<div class="section_divider"> <h3 class="section_heading">Faculty</h3> </div>';
    echo '<div class="col-sm-6 col-sm-push-3 col-xs-8 col-xs-push-2">';
  	while ( $faculty_query->have_posts() ) {
  		$faculty_query->the_post();
		  Starkers_Utilities::get_template_parts( array( 'parts/shared/people-preview-rows' ) ); 
    }
    echo '</div>';
    echo '</div>';
  }
  if ( $student_query->have_posts() ) {
    echo '<div class="row">';
    echo '<a class="anchor" id="students"></a>';
    echo '<div class="section_divider"> <h3 class="section_heading">Students</h3> </div>';
    echo '<div class="col-sm-6 col-sm-push-3 col-xs-8 col-xs-push-2">';
  	while ( $student_query->have_posts() ) {
  		$student_query->the_post();
		  Starkers_Utilities::get_template_parts( array( 'parts/shared/people-preview-rows' ) ); 
    }
    echo '</div>';
    echo '</div>';
  }
  if ( $alumni_query->have_posts() ) {
    echo '<div class="row">';
    echo '<a class="anchor" id="alumni"></a>';
    echo '<div class="section_divider"> <h3 class="section_heading">Alumni</h3> </div>';
    echo '<div class="col-sm-6 col-sm-push-3 col-xs-8 col-xs-push-2">';
  	while ( $alumni_query->have_posts() ) {
  		$alumni_query->the_post();
		  Starkers_Utilities::get_template_parts( array( 'parts/shared/people-preview-rows' ) ); 
    }
    echo '</div>';
    echo '</div>';
  }
  if ( $researcher_query->have_posts() ) {
    echo '<div class="row">';
    echo '<a class="anchor" id="researchers"></a>';
    echo '<div class="section_divider"> <h3 class="section_heading">Post Docs & Researchers</h3> </div>';
    echo '<div class="col-sm-6 col-sm-push-3 col-xs-8 col-xs-push-2">';
  	while ( $researcher_query->have_posts() ) {
  		$researcher_query->the_post();
		  Starkers_Utilities::get_template_parts( array( 'parts/shared/people-preview-rows' ) ); 
    }
    echo '</div>';
    echo '</div>';
  }
  if ( $news_query->have_posts() ) {
    echo '<div class="row">';
    echo '<a class="anchor" id="news"></a>';
    echo '<div class="section_divider"> <h3 class="section_heading">News</h3> </div>';
    echo '<div class="col-sm-6 col-sm-push-3 col-xs-8 col-xs-push-2">';
  	while ( $news_query->have_posts() ) {
  		$news_query->the_post();
		  Starkers_Utilities::get_template_parts( array( 'parts/shared/post-preview' ) ); 
    }
    echo '</div>';
    echo '</div>';
  }
  if ( $event_query->have_posts() ) {
    echo '<div class="row">';
    echo '<a class="anchor" id="events"></a>';
    echo '<div class="section_divider"> <h3 class="section_heading">Events</h3> </div>';
    echo '<div class="col-sm-6 col-sm-push-3 col-xs-8 col-xs-push-2">';
  	while ( $event_query->have_posts() ) {
  		$event_query->the_post();
		  Starkers_Utilities::get_template_parts( array( 'parts/shared/event-preview' ) ); 
    }
    echo '</div>';
    echo '</div>';
  }
  if ( $topic_query->have_posts() ) {
    echo '<div class="row">';
    echo '<a class="anchor" id="topics"></a>';
    echo '<div class="section_divider"> <h3 class="section_heading">Topic Links</h3> </div>';
    echo '<div class="col-sm-6 col-sm-push-3 col-xs-8 col-xs-push-2">';
  	while ( $topic_query->have_posts() ) {
  		$topic_query->the_post();
		  Starkers_Utilities::get_template_parts( array( 'parts/shared/post-preview' ) ); 
    }
    echo '</div>';
    echo '</div>';
  }
}
?>
        </div>
      </div>
    </div>
  </div>
</div><!-- .page -->
</div>
<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>
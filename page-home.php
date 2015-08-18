<?php
/**
 * @package 	WordPress
 * @subpackage 	Starkers
 * @since 		Starkers 4.0
 */
?>
<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>

<?php
$query = new WP_Query( array( 'post_type' => 'page', 'post_parent' => '348', 'post', 'posts_per_page' => '4','order' =>'ASC' ) ); 
if ( $query->have_posts() ) {
  $i=0;
  $feature_buttons='<div id="feature_buttons" class="row hidden-xs hidden-sm">';
?>
<div id="feature_box" class="container-fluid">
  <div id="feature_carousel" class="carousel carousel slide" data-interval="10000">
    <!-- Indicators -->
    <ol class="carousel-indicators hidden-md hidden-lg">
      <li data-target="#feature_carousel" data-slide-to="0" class="carousel-indicator active"></li>
      <li data-target="#feature_carousel" data-slide-to="1" class="carousel-indicator"></li>
      <li data-target="#feature_carousel" data-slide-to="2" class="carousel-indicator"></li>
      <li data-target="#feature_carousel" data-slide-to="3" class="carousel-indicator"></li>
    </ol>
    <!-- Wrapper for slides -->
    <div class="carousel-inner">

<?php	
while ( $query->have_posts() ) { 
  $query->the_post(); 
	if (has_post_thumbnail( $post->ID ) ){
  $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' ); 
  $imgurl=$image[0];
  } else $imgurl="";

?>      

      <div class="item background-carousel<?php if($i==0) echo " active"; ?>" style="background-image:url(<?php echo $imgurl; ?>);">
        <!-- <img src="http://erg.berkeley.edu/wp2013/wp-content/uploads/2013/08/DSC1211-2048.jpg" alt="1"> -->
        <div class="carousel-caption ">
          <div class="carousel-item-title visible-xs"><a href="<?php echo get_permalink($post->ID); ?>"><?php echo get_the_title($post->ID); ?> </a></div>
          <div class="hidden-xs"><a href="<?php echo get_permalink($post->ID); ?>"><?php echo get_the_content($post->ID); ?></a></div>
          <a class="coverall_link" href="<?php echo get_permalink($post->ID); ?>"><span class="fa fa-angle-right"></span></a>
        </div>
        <div class="carousel_bottom">&nbsp;</div>
      </div>

<?php 
  $feature_buttons.='<div id="feature'.$i.'" class="col-sm-3 feature_button';
  if($i==0) $feature_buttons.=' active';
  $feature_buttons.=' data-target="#feature_carousel" data-slide-to="'.$i.'"><a href="'. get_permalink($post->ID) .'"><div class="feature_button_content">';
  if($thumbnail=get_post_meta($post->ID,'thumbnail',true)) $feature_buttons.='<div class="thumbnail" style="background-image:url('.$thumbnail.');"></div>';
  $feature_buttons.='<span class="title">'. get_the_title($post->ID) .'</span><span class="blurb">'. get_the_excerpt() .'</span>';
  $feature_buttons.='</a></div></div>';
  $i++;
}
$feature_buttons.='</div>'; 
?>

    </div>

    <!-- Controls -->
    <a class="left carousel-control" href="#feature_carousel" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left"></span>
    </a>
    <a class="right carousel-control" href="#feature_carousel" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right"></span>
    </a>
  </div>
<?php echo $feature_buttons; ?>
</div>
<?php } else { ?>
	<div class="alert alert-danger">Content not found.</div>
<?php } wp_reset_postdata(); ?>
<div id="thefold" class="">&nbsp;</div>
<div class="container">
<div id="belowthefold" class="row">
      <?php
        $query = new WP_Query( array( 'post_type' => 'page', 'post_parent' => $post->ID, 'posts_per_page' => '-1', 'offset' => '0', 'order' => 'ASC', 'orderby' => 'menu_order' ));
        if ( $query->have_posts() ) {
          $i=1;
        	while ( $query->have_posts() ) {
        		$query->the_post();
            if($i==1) {
              ?>
              <div id="welcome" class="col-sm-5 col-md-5 col-lg-5">
                <div >
                  <div class="section content">
            		    <h2 class="section_heading"><?php echo get_the_title($post->ID); ?></h2>
                    <?php 
                    the_content();
                    if(get_field('links_to_content', $post->ID) != null) { 
                      $links_to=get_field('links_to_content',$post->ID);
                      echo '<a class="btn btn-link btn-block" href="'.get_permalink($links_to->ID).'">Go to '.get_the_title($links_to->ID).' <span class="fa fa-angle-right"></span></a>';
                    } 
                    ?>
              	  </div>
                <?php 
              } elseif($i==$query->found_posts && $query->found_posts>2){
                  $the_last_bit_of_content_on_the_home_page='<div id="last_section" class="row"><div class="section content">
            		  <h2 class="section_heading">'. get_the_title($post->ID) .'</h2><p>'. get_the_content($post->ID) .'</p>';
                  if(get_field('links_to_content', $post->ID) != null) {
                    $the_linked_post=get_field('links_to_content', $post->ID);
                    $the_last_bit_of_content_on_the_home_page.='<a class="btn btn-block btn-link" href="'.get_permalink($the_linked_post->ID).'">'.get_the_title($the_linked_post->ID).'</a>'; 
                  } 
                  $the_last_bit_of_content_on_the_home_page.='</div></div>';
                } else {
                ?>
                <div class="section content">
            		  <h2 class="section_heading"><?php echo get_the_title($post->ID); ?></h2>
                    <?php 
                    the_content(); 
                    if(get_field('links_to_content', $post->ID) != null) { 
                      $links_to=get_field('links_to_content',$post->ID);
                      echo '<a class="btn btn-link btn-block" href="'.get_permalink($links_to->ID).'">Go to '.get_the_title($links_to->ID).' <span class="fa fa-angle-right"></span></a>';
                    } 
                    ?>
                </div>
              <?php 
            }
          	$i++;
        	}
          ?>
            </div>
            <div class="spacer hidden-xs"></div>
          </div>
          <?php 
            } else { 
          ?>
        	<div class="alert alert-danger">Content not found.</div>
        <?php }
        wp_reset_postdata();
      ?>

    <?php
    global $post;
    $all_events = tribe_get_events(array( 'eventDisplay'=>'upcoming', 'posts_per_page'=>10 ));
    ?>
    
    <?php
    // if we have more than 5 events the system tries to divide the news_and_events column into two columns which require more space so we take one column from the spotlight column
    if(count($all_events)>=5){
      $spotlight_cols=3;
      $news_events_cols=4;
    } else {
      $spotlight_cols=4;
      $news_events_cols=3;
    }
    ?>   
    <div id="spotlight" class="col-sm-<?php echo $spotlight_cols; ?> col-md-<?php echo $spotlight_cols; ?> col-lg-<?php echo $spotlight_cols; ?>">
      <div>
      <h3 class="section_heading">ERG Media</h3>
      <?php
        $query = new WP_Query( array( 'category_name' => 'media', 'posts_per_page' => '5' ));
        if ( $query->have_posts() ) {
        	while ( $query->have_posts() ) {
        		$query->the_post();
        		echo '<div class=" spotlight_item post_preview">';
        		echo '<div class="post_title"><a href=' . get_permalink($post->ID) . '>' . get_the_title() . '</a></div>';
        		echo get_preview_image();
      ?>
            <p>
          		<?php echo get_the_excerpt(); ?>
          		<a class="post_preview_link" href="<?php echo get_permalink($post->ID); ?>">Read more <span class="glyphicon glyphicon-arrow-right"></span></a>
            </p>
      <?php
        		echo '</div>';
        	}
          echo '<div class="spacer hidden-xs"></div>';
        } else { ?>
        	<div class="alert alert-danger">Content not found.</div>
        <?php }
        wp_reset_postdata();
      ?>
      <div class="">
        <button type="button" class="btn btn-link btn-block btn-xs"><a class="" href="<?php echo get_category_link( get_cat_ID( 'media' ) ); ?>">Media Archive <span class="glyphicon glyphicon-chevron-right"></span></a></button>
      </div>
    </div>
  </div>
    
    <div id="news_and_events_col" class="col-sm-<?php echo $news_events_cols; ?> col-md-<?php echo $news_events_cols; ?> col-lg-<?php echo $news_events_cols; ?>"><div class="row">
      <?php 
      global $post;
      $all_events = tribe_get_events(array( 'eventDisplay'=>'upcoming', 'posts_per_page'=>10 ));
      if(count($all_events)>0){ 
        if(count($all_events)>=5){
          $news_events_column_arrangement="col-md-12 col-lg-6";
        } else {
          $news_events_column_arrangement="col-md-12 col-lg-12";
        }
          // if sufficient upcoming events make a separate column for events, otherwise stack events on top of news ?>
        <div id="events_col" class="<?php echo $news_events_column_arrangement; ?>">
          <div>
        <h3 class="section_heading">Events</h3>
        <?php 
        foreach($all_events as $post)
        {
          setup_postdata($post);
          $eventstatus="";
          if(tribe_event_in_category('canceled')){ $eventstatus="canceled"; }
					elseif( tribe_get_start_date($post->ID, true, 'U')-strtotime('now') < 86400) {
						if( tribe_get_end_date($post->ID, true, 'U') < strtotime('now') ) $eventstatus="passed"; // event is over
						elseif( tribe_get_start_date($post->ID, true, 'U') < strtotime('now')) $eventstatus="now"; // event is happening now
						else /*if( tribe_get_start_date($post->ID, true, 'Ymdhi') <= date('Ymdhi', time('now')) )*/ $eventstatus="soon"; // event is upcoming within the next 24 hours
					}
					else $eventstatus="future";
          ?>
        
          <div class="event_item event_<?php echo $eventstatus; ?> post_preview">
            <div class="post_title event_title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
            <?php echo get_preview_image($post->ID); ?>
            <div class="event_status <?php echo $eventstatus; ?>"><?php echo $eventstatus; ?></div>
            <div class="event_date">
              <span class="fa fa-calendar-o"></span>
              <?php echo tribe_events_event_schedule_details(); ?>
              <?php //echo '<span class="event_status">'. ($eventstatus=="future" ? '' : $eventstatus ) .'</span>'; ?>
            </div>
            <?php // the_excerpt(); ?>
      		<button type="button" class="btn btn-link btn-block btn-xs"><a class="post_preview_link" href="<?php the_permalink(); ?>">Read more <span class="glyphicon glyphicon-arrow-right"></span></a></button>
          </div>
        <?php 
        }
        wp_reset_postdata();
        ?>      
      </div>
      <div class="spacer hidden-xs"></div>
        
        <div class="">
          <button type="button" class="btn btn-link btn-block btn-xs">
            <a href="./events/">Events Calendar <span class="glyphicon glyphicon-chevron-right"></span></a>
          </button>
        </div>
      </div>
        <?php
        }
        ?>
          
        <div id="news_col" class="<?php echo $news_events_column_arrangement; ?>">        
        <div class="">
          <h3 class="section_heading">News</h3>
            <?php
              $query = new WP_Query( array( 'category_name' => 'news', 'posts_per_page' => '10' ));
              if ( $query->have_posts() ) {
              	while ( $query->have_posts() ) {
              		$query->the_post(); 
            ?>
              		<div <?php post_class("post_preview news_item"); ?>>
                    <?php echo get_preview_image($post->ID); ?>
                    <h5 class="post_title"><a href="<?php the_permalink(); ?>"> <?php echo get_the_title(); ?></a></h5>
                    <p>
                  		<?php //echo get_the_excerpt(); ?>
                  		<a class="post_preview_link" href="<?php echo get_permalink($post->ID); ?>">Read more <span class="glyphicon glyphicon-arrow-right"></span></a>
                    </p>                  
              		</div>
            <?php }
              } else { ?>
              	<div class="alert alert-danger">Content not found.</div>
              <?php }
              wp_reset_postdata();
            ?>
      </div>
      <div class="spacer hidden-xs"></div>
      <div class="">
        <button type="button" class="btn btn-link btn-block btn-xs">
          <a href="./news-events/">News &amp; Events <span class="glyphicon glyphicon-chevron-right"></span></a>
        </button>
      </div>
    </div>
  </div>
  <div class="spacer hidden-xs"></div>
</div>    
  </div><!-- #belowthefold -->
    <?php echo $the_last_bit_of_content_on_the_home_page; ?>

</div>
<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>

<script>
function check_for_active_slide(){
  var which_slide_is_active = $('.carousel-indicator.active').attr('data-slide-to');
  if(which_slide_is_active!=null){
    // alert(which_slide_is_active);
    $('.feature_button').removeClass('active');
    $('#feature'+which_slide_is_active).addClass('active');
  }
  else {
    setTimeout(check_for_active_slide, 100); // check again in .1 seconds
  }
}

$('#feature_carousel').on('slid.bs.carousel', function(){ check_for_active_slide(); window.coverall_links(); });
$("#feature0").hover(function(){
  $('.carousel').carousel(0);
}).click(function(){
  window.location = $(this).children('a').attr('href');
});
$("#feature1").hover(function(){
  $('.carousel').carousel(1);
}).click(function(){
  window.location = $(this).children('a').attr('href');
});
$("#feature2").hover(function(){
  $('.carousel').carousel(2);
}).click(function(){
  window.location = $(this).children('a').attr('href');
});
$("#feature3").hover(function(){
  $('.carousel').carousel(3);
}).click(function(){
  window.location = $(this).children('a').attr('href');
});
$(document).ready(function(){
  // the following removes news items from the news column until the height of the news column matches the layout
  home_page_layout();
});
$( window ).resize(function() {
  home_page_layout();
}); 
</script>
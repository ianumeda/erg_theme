<?php
$eventstatus="";
if(tribe_event_in_category('canceled')){ $eventstatus="canceled"; }
elseif( tribe_get_start_date($post->ID, true, 'U')-strtotime('now') < 86400) {
	if( tribe_get_end_date($post->ID, true, 'U') < strtotime('now') ) $eventstatus="passed"; // event is over
	elseif( tribe_get_start_date($post->ID, true, 'U') < strtotime('now')) $eventstatus="now"; // event is happening now
	else /*if( tribe_get_start_date($post->ID, true, 'Ymdhi') <= date('Ymdhi', time('now')) )*/ $eventstatus="soon"; // event is upcoming within the next 24 hours
}
else $eventstatus="future";
?>
<div class="event_item event_<?php echo $eventstatus; ?> event_preview">
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

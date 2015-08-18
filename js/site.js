function home_page_layout(){
  set_carousel_height();
  height_to_match=$("#welcome").height();
  // height_to_match=($("#events_col").height() > $("#welcome").height() ? $("#events_col").height() : $("#welcome").height() );
  // first the news column
  $('.post_preview').show();
  $('.spacer').height(0);
  var number_of_upcoming_events=$('#events_col .post_preview').length;
  if(number_of_upcoming_events<5 || $(window).width()<992){  
    // events stacked on top of news so don't need to adjust events
    var first_news_item=$('#news_col .post_preview').first();
    var last_news_item=$('#news_col .post_preview').last();
    while(last_news_item.index('.post_preview')!=first_news_item.index('.post_preview') && $('#news_col').height()>height_to_match- $("#events_col").height()){
      last_news_item.hide();
      last_news_item=last_news_item.prev(".post_preview");
    }
  } else {
    // otherwise adjust both news and events
    var first_news_item=$('#news_col .post_preview').first();
    var last_news_item=$('#news_col .post_preview').last();
    while(last_news_item.index('.post_preview')!=first_news_item.index('.post_preview') && $('#news_col').height()>height_to_match){
      last_news_item.hide();
      last_news_item=last_news_item.prev(".post_preview");
    }
    var first_events_item=$('#events_col .post_preview').first();
    var last_events_item=$('#events_col .post_preview').last();
    while(last_events_item.index('.post_preview')!=first_events_item.index('.post_preview') && $('#events_col').height()>height_to_match){
      last_events_item.hide();
      last_events_item=last_events_item.prev(".post_preview");
    }
  }
  var first_spotlight_item=$('#spotlight .post_preview').first();
  var last_spotlight_item=$('#spotlight .post_preview').last();
  while(last_spotlight_item.index('.post_preview')!=first_spotlight_item.index('.post_preview') && $('#spotlight').height()>height_to_match){
    last_spotlight_item.hide();
    last_spotlight_item=last_spotlight_item.prev(".post_preview");
  }
  // now increase spacer divs so all columns match
  // if($(window).width() < 992 || number_of_upcoming_events < 5){
  //   // 992px is the breakpoint for col-md which is when the news and events stack
  //   // $('#welcome .spacer').height($('#news_col').height()-$('#welcome').height()-$('#welcome .spacer').height());
  //   $('#events_col .spacer').height($('#welcome').height()-$('#events_col').height()-$('#events_col .spacer').height());
  //   $('#news_col .spacer').height($('#welcome').height()-$('#news_col').height()-$('#news_col .spacer').height());
  // } else {
  //   $('#welcome .spacer').height($('#events_col').height()+$('#news_col').height()-$('#welcome').height()-$('#welcome .spacer').height());
  //   $('#news_col .spacer').height(0);
  //   $('#events_col .spacer').height(0);
  //   $('#news_and_events_col .spacer').height($('#welcome').height()-$('#news_and_events_col').height());
  // }
}
function set_footer_position(){
  var page_position=$('#page').position();
  var page_bottom=page_position.top+$('#page').outerHeight(true);
  // alert(page_position.top+" + "+$('#page').outerHeight(true));
  if( $(window).height() > page_bottom + $('#footer').outerHeight(true) ){
    $('#footer').css({'position':'fixed', 'bottom':'0px'});
  } else {
    $('#footer').css({'position':'relative'});
  }
  $('#footer').css({'visibility':"visible"});
} 
function makesquares(){
  $('.headshot.square').each(function(){
      var $img = $(this),
          imgWidth = $img.width();

      $(this).css({"height":imgWidth});
      $('.person_page .headshot .glyphicon-user').css({"font-size":imgWidth});
  });
  
}

var throttle_id=null;
function throttle_on_resize(thedelayamount){
  // this function sets a timer function that calls on_resize after thedelayamount. when called during that delay a new delay is set. 
  if(thedelayamount==null) thedelayamount=1000;
  if(throttle_id!=null){
    // kill current throttle 
    clearTimeout(throttle_id);
  }
  // start a new one...
  throttle_id=setTimeout(function() { on_resize(true); },thedelayamount); 
}

function on_resize(go_immediately) {
  if(!go_immediately) throttle_on_resize();
  else {
    throttle_id=null;
    set_carousel_height();
    set_footer_position();
    makesquares();
    window.coverall_links();
  }
};


function set_carousel_height(){
  var ideal_h_ratio=.666;
  var min_h=300;
  var max_h=640;
  var viewport_w=$(window).width();
  var viewport_h=$(window).height();
  var ideal_h=viewport_h*ideal_h_ratio;
  if(ideal_h>max_h) { var set_height=max_h; } 
  else if(ideal_h<min_h) { var set_height=min_h; }
  else { var set_height=ideal_h; }
  $(".carousel_bottom").css({"margin-top":set_height+"px"});
}
function set_alpha_indexes(){
  $('[data-range-end]').each(function(){
    var first_item_in_range=$(this).siblings().find('[data-last-initial]').first();
    var last_item_in_range=$(this).siblings().find('[data-last-initial]').last();
    $(this).attr('data-range-start', first_item_in_range.attr('data-last-initial'));
    $(this).attr('data-range-end', last_item_in_range.attr('data-last-initial'));
  })
  $('.alpha_index').each(function(){
    $(this).html( "<a id="+$(this).attr('data-range-start')+"></a>"+$(this).attr('data-range-start') +" – "+ $(this).attr('data-range-end') );
    // if($('.name_nav').find('[href="#'+$(this).attr('data-range-start')+'"]').length<=0){
    //   $('.name_nav').append('<a href="#'+$(this).attr('data-range-start')+'">'+$(this).attr('data-range-start')+'</a>');
    // }
  })
}
function do_even_columns(){
  //first get average height of all columns
  var col_heights=[];
  var total_height=0;
  if($('.even_height_container').length){
    // if there are more than one section of columns that need tidying then they should be wrapped in .even_height_container class
    $('.even_height_container').each(function(){
      $(this).find('.even_height_column').each(function(){
        col_heights.push($(this).height());
        total_height+=$(this).height();
      });
      var avg_column_height=total_height/col_heights.length;
      // $(".people_container").append('<div class="h_guide" style="position:absolute; width:100%; border-top:1px dotted red; top:'+avg_column_height+'px; left:0;"></div>');
      // now add or subtract elements from columns to match average and add them to 
      for(i=0; i<col_heights.length; i++){
        make_col_close_to_average($(this), i, avg_column_height);
      }
    });
  } else {
    $('.even_height_column').each(function(){
      col_heights.push($(this).height());
      total_height+=$(this).height();
    });
    var avg_column_height=total_height/col_heights.length;
    // $(".people_container").append('<div class="h_guide" style="position:absolute; width:100%; border-top:1px dotted red; top:'+avg_column_height+'px; left:0;"></div>');
    // now add or subtract elements from columns to match average and add them to 
    for(i=0; i<col_heights.length; i++){
      make_col_close_to_average($('body'), i, avg_column_height); // send 'body' as container
    }
  }
}
function make_col_close_to_average(container, this_col_number, average_height){
  this_col=container.find('.even_height_column:eq('+this_col_number+')');
  if(this_col.find('.person_item').length>1){
    if(this_col_number<container.find('.even_height_column').length-1) next_col=container.find('.even_height_column:eq('+(this_col_number+1)+')');
    else next_col=undefined;
    if(this_col_number>0) prev_col=container.find('.even_height_column:eq('+(this_col_number-1)+')');
    else prev_col=undefined;
    diff_from_average_old=this_col.height()-average_height;
    diff_from_average_new=diff_from_average_old;
    // console.log(this_col_number, next_col, prev_col);
    if(diff_from_average_old>0){
      //too tall, give elements away
      if(next_col!=undefined){
        // if this isn't the last column so subtract from the end
        while(Math.abs(diff_from_average_old) - Math.abs(diff_from_average_new) >= 0){
          give_a_person_to_the_next_column(this_col,next_col);
          diff_from_average_old=diff_from_average_new;
          diff_from_average_new=this_col.height()-average_height;
          // console.log(Math.abs(diff_from_average_old), Math.abs(diff_from_average_new))
        }
        take_a_person_from_the_next_column(this_col,next_col);
      } else {
        // or it is the last column so subtract from the start
        while(Math.abs(diff_from_average_old) - Math.abs(diff_from_average_new) >= 0){
          give_a_person_to_the_previous_column(this_col,prev_col);
          diff_from_average_old=diff_from_average_new;
          diff_from_average_new=this_col.height()-average_height;
          // console.log(Math.abs(diff_from_average_old), Math.abs(diff_from_average_new))
        }
        take_a_person_from_the_previous_column(this_col,prev_col);
      }
    } else {
      //too short take elements from neighbors
      if(next_col!=undefined){
        while(Math.abs(diff_from_average_old) - Math.abs(diff_from_average_new) >= 0){
          take_a_person_from_the_next_column(this_col,next_col);
          diff_from_average_old=diff_from_average_new;
          diff_from_average_new=this_col.height()-average_height;
          // console.log(Math.abs(diff_from_average_old), Math.abs(diff_from_average_new))
        }
        give_a_person_to_the_next_column(this_col,next_col);
      } else {
        while(Math.abs(diff_from_average_old) - Math.abs(diff_from_average_new) >= 0){
          take_a_person_from_the_previous_column(this_col,prev_col);
          diff_from_average_old=diff_from_average_new;
          diff_from_average_new=this_col.height()-average_height;
          // console.log(Math.abs(diff_from_average_old), Math.abs(diff_from_average_new))
        }
        give_a_person_to_the_previous_column(this_col,prev_col);
      }
    }
  }
}
function give_a_person_to_the_next_column(col,next_col){
  col.find('.person_item').last().detach().prependTo(next_col.find('.people_container'));
}
function take_a_person_from_the_next_column(col,next_col){
  next_col.find('.person_item').first().detach().appendTo(col.find('.people_container'));
}
function give_a_person_to_the_previous_column(col,previous_col){
  col.find('.person_item').first().detach().appendTo(previous_col.find('.people_container'));
}
function take_a_person_from_the_previous_column(col,previous_col){
  previous_col.find('.person_item').last().detach().prependTo(col.find('.people_container'));
}
jQuery(document).ready(function($) {
  window.coverall_links=function(){
    $(".coverall_link").each(function(){
      var my_height=$(this).height();
      $(this).css({"line-height":my_height+"px"});
    });
  }

	new UISearch( document.getElementById( 'sb-search-top' ) );
	new UISearch( document.getElementById( 'sb-search-bottom' ) );

  $( window ).resize(function() {
    on_resize(false);
  }); 
  $(window).load(function(e){ 
    on_resize(false);
  });    
  on_resize(true);
});


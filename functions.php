<?php
	/**
	 * Starkers functions and definitions
	 *
	 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
	 *
 	 * @package 	WordPress
 	 * @subpackage 	Starkers
 	 * @since 		Starkers 4.0
	 */

	/* ========================================================================================================================
	
	Required external files
	
	======================================================================================================================== */

	require_once( 'external/starkers-utilities.php' );
	require_once( 'wp_bootstrap_navwalker.php' );

	/* ========================================================================================================================
	
	Theme specific settings

	Uncomment register_nav_menus to enable a single menu with the title of "Primary Navigation" in your theme
	
	======================================================================================================================== */

	add_theme_support('post-thumbnails');
	
	// register_nav_menus(array('primary' => 'Primary Navigation'));

	/* ========================================================================================================================
	
	Actions and Filters
	
	======================================================================================================================== */

	add_action( 'wp_enqueue_scripts', 'starkers_script_enqueuer' );

	add_filter( 'body_class', array( 'Starkers_Utilities', 'add_slug_to_body_class' ) );

	/* ========================================================================================================================
	
	Custom Post Types - include custom post types and taxonimies here e.g.

	e.g. require_once( 'custom-post-types/your-custom-post-type.php' );
	
	======================================================================================================================== */



	/* ========================================================================================================================
	
	Scripts
	
	======================================================================================================================== */

	/**
	 * Add scripts via wp_head()
	 *
	 * @return void
	 * @author Keir Whitaker
	 */

	function starkers_script_enqueuer() {
		wp_register_script( 'site', get_template_directory_uri().'/js/site.js', array( 'jquery' ) );
		wp_enqueue_script( 'site' );

		wp_register_style( 'screen', get_stylesheet_directory_uri().'/style.css', '', '', 'screen' );
        wp_enqueue_style( 'screen' );
	}	

	/* ========================================================================================================================
	
	Comments
	
	======================================================================================================================== */

	/**
	 * Custom callback for outputting comments 
	 *
	 * @return void
	 * @author Keir Whitaker
	 */
	function starkers_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment; 
		?>
		<?php if ( $comment->comment_approved == '1' ): ?>	
		<li>
			<article id="comment-<?php comment_ID() ?>">
				<?php echo get_avatar( $comment ); ?>
				<h4><?php comment_author_link() ?></h4>
				<time><a href="#comment-<?php comment_ID() ?>" pubdate><?php comment_date() ?> at <?php comment_time() ?></a></time>
				<?php comment_text() ?>
			</article>
		<?php endif;
	}
	
	function your_function_name() {
  add_theme_support( 'menus' );
  }

  add_action( 'after_setup_theme', 'your_function_name' );
  

add_theme_support('html5');
$header_defaults = array(
	'default-image'          => '',
	'random-default'         => false,
	'width'                  => 1200,
	'height'                 => 180,
	'flex-height'            => false,
	'flex-width'             => true,
	'default-text-color'     => '',
	'header-text'            => true,
	'uploads'                => true,
	'wp-head-callback'       => '',
	'admin-head-callback'    => '',
	'admin-preview-callback' => '',
);
add_theme_support( 'custom-header', $header_defaults );
add_post_type_support('page', 'excerpt');

function get_preview_image ($postID=null){
  if(!is_int($postID)) { global $post; $postID=$post->ID; }
  if(function_exists('get_field')){
    $preview_image=get_field('preview_image_or_video');
  }
  if(empty($preview_image)){
    $preview_image=get_post_meta($postID,'preview-image', true);    
  }
  if(!empty($preview_image)){
    if(preg_match('#^http:\/\/(.*)\.(gif|png|jpg)$#i', $preview_image)) return '<img class="post_preview_image" src="'.$preview_image.'"/>';
    else {
      $filtered=apply_filters('the_content', $preview_image);
      if($filtered !== '<p>'.$preview_image.'</p>') return '<div class="post_preview_image">'.$filtered.'</div>';
    }
  } else {
    // last resort is to use the posts featured image
    if(has_post_thumbnail( $postID ) ){
      $image = wp_get_attachment_image_src( get_post_thumbnail_id( $postID ), 'thumbnail' ); 
      $imgurl=$image[0];
      return '<img class="post_preview_image" src="'. $imgurl .'"/>';
    }
  }
  return null;
}
function get_page_menu($id){
  // (1) returns 'menu' custom field value if found
  if($menu=get_post_meta($id, 'menu', true)) return $menu;
  // (2) returns custom menu name of the same name as page slug if menu exists
  $menus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );    
  foreach($menus as $menu){
    // echo '<!--'.strtolower($menu->name).'=='.strtolower(get_the_title($id)).'-->';
    if( ($menu->name == get_the_slug($id)) || strtolower($menu->name)==strtolower(get_the_slug($id)) ) return $menu->name;
  }
  // (3) recurses through parent pages for the above
  $parents = get_post_ancestors( $id );
  foreach($parents as $parent){
    if($menu=get_page_menu($parent)) return $menu; 
  }
} 
function get_the_slug($id,$echo=false){
  $slug = basename(get_permalink($id));
  do_action('before_slug', $slug);
  $slug = apply_filters('slug_filter', $slug);
  do_action('after_slug', $slug);
  return $slug;
}
function display_name_format($name){
  // the current name format as placed in the "title" field is "lastname, firstname"
  // if there is no comma then the name is returned as-is
  if(strstr($name,',')) {
    $aName=explode(',',$name);
    return trim($aName[1])." ".trim($aName[0]);
  } else return $name;
}

function get_adjacent_person($direction="prev", $current_personID=null){
  if(!is_numeric($current_personID)) $current_personID=get_the_ID();
 // this function gets the next person in the same "role" taxonomy  
 //1. get the person's position 
 $positions=wp_get_post_terms($current_personID, 'position', array("fields" => "slugs")); 
 $position=$positions[0];
 $all_people_with_same_position=get_posts( array('post_type'=>'people', 'posts_per_page'=>-1, 'position' => $position, 'orderby'=>'title', 'order'=>'asc') );
 $people=array();
 foreach($all_people_with_same_position as $person){
   array_push($people, $person->ID);
 } 
 $current = array_search($current_personID, $people);
 if($direction=="prev" && $current>0) {
   return get_post($people[$current-1]);
 } elseif($direction=='next' && $current<count($people)-1){
   return get_post($people[$current+1]);
 } else return null; 
}

// hook into the init action and call create_book_taxonomies when it fires
add_action( 'init', 'create_people_taxonomies', 0 );

// create two taxonomies, genres and writers for the post type "book"
function create_people_taxonomies() {
	// Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name'              => _x( 'Position', 'taxonomy general name' ),
		'singular_name'     => _x( 'Position', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Positions' ),
		'all_items'         => __( 'All Positions' ),
		'edit_item'         => __( 'Edit Position' ),
		'update_item'       => __( 'Update Position' ),
		'add_new_item'      => __( 'Add New Position' ),
		'new_item_name'     => __( 'New Position Name' ),
		'menu_name'         => __( 'Position' ),
	);

	$args = array(
		'hierarchical'      => false,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => false,
	);

  register_taxonomy( 'position', array( 'people' ), $args );

	// Add new 'titles'  taxonomy, NOT hierarchical (like tags)
	$labels = array(
		'name'                       => _x( 'Titles', 'taxonomy general name' ),
		'singular_name'              => _x( 'Title', 'taxonomy singular name' ),
		'search_items'               => __( 'Search Title' ),
		'all_items'                  => __( 'All Titles' ),
		'parent_item'                => null,
		'parent_item_colon'          => null,
		'edit_item'                  => __( 'Edit Title' ),
		'update_item'                => __( 'Update Title' ),
		'add_new_item'               => __( 'Add New Title' ),
		'new_item_name'              => __( 'New Title Name' ),
		'separate_items_with_commas' => __( 'Separate titles with commas' ),
		'add_or_remove_items'        => __( 'Add or remove titles' ),
		'choose_from_most_used'      => __( 'Choose from the most used titles' ),
		'not_found'                  => __( 'No titles found.' ),
		'menu_name'                  => __( 'Titles' ),
	);

	$args = array(
		'hierarchical'          => false,
		'labels'                => $labels,
		'show_ui'               => true,
		'show_admin_column'     => true,
		'query_var'             => true,
		'rewrite'               => false,
	);

  register_taxonomy( 'titles', 'people', $args );
  
	$labels = array(
		'name'              => _x( 'Topics', 'taxonomy general name' ),
		'singular_name'     => _x( 'Topic', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Topics' ),
		'all_items'         => __( 'All Topics' ),
		'edit_item'         => __( 'Edit Topic' ),
		'update_item'       => __( 'Update Topic' ),
		'add_new_item'      => __( 'Add New Topic' ),
		'new_item_name'     => __( 'New Topic Name' ),
		'menu_name'         => __( 'Topic' ),
	);

	$args = array(
		'hierarchical'      => false,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => false,
	);

  register_taxonomy( 'topics', array( 'people' ), $args );
}
?>
<?php
namespace BookShop\Includes;

class PostTypes{


    // This method will be responsible registering the posttypes 
	public static function add($singular,$plural) {
       
        $type     = $plural;
        $singular = ucfirst($singular);
        $plural   = ucfirst($plural);
        
		add_action('init', function() use ($singular,$plural,$type){

			// Set UI labels for Custom Post Type
		    $labels = array(
		        'name'                => _x($plural, 'Post Type General Name', 'book-shop' ),
		        'singular_name'       => _x($singular, 'Post Type Singular Name', 'book-shop' ),
		        'menu_name'           => __($plural, 'book-shop' ),
		        'parent_item_colon'   => __('Parent '.$singular, 'book-shop' ),
		        'all_items'           => __('All '.$plural, 'book-shop' ),
		        'view_item'           => __('View '.$singular, 'book-shop' ),
		        'add_new_item'        => __('Add New '.$singular, 'book-shop' ),
		        'add_new'             => __('Add New', 'book-shop' ),
		        'edit_item'           => __('Edit '.$singular, 'book-shop' ),
		        'update_item'         => __('Update '.$singular, 'book-shop' ),
		        'search_items'        => __('Search '.$singular, 'book-shop' ),
		        'not_found'           => __('Not Found', 'book-shop' ),
		        'not_found_in_trash'  => __('Not found in Trash', 'book-shop' ),
		    );
		    
		    // Set other options for Custom Post Type  
		    $args = array(
		        'label'               => __($plural, 'book-shop' ),
		        'description'         => __($singular.' details', 'book-shop'),
		        'labels'              => $labels,
		        'supports'            => array('title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ), 
		        'taxonomies'          => array('genres' ),
		        'hierarchical'        => false,
		        'public'              => true,
		        'show_ui'             => true,
		        'show_in_menu'        => true,
		        'show_in_nav_menus'   => true,
		        'show_in_admin_bar'   => true,
		        'menu_position'       => 5,
		        'can_export'          => true,
		        'has_archive'         => true,
		        'exclude_from_search' => false,
		        'publicly_queryable'  => true,
		        'capability_type'     => 'post',
		        'show_in_rest'        => true,
		    );
      
		    // Registering your Custom Post Type
		    register_post_type($type,$args);
		});	  
    }
}
<?php
namespace BookShop\Includes;

class Taxonomies{
 
    // This method will be responsible for registering taxonomies to our plugin
	public static function add($singular,$plural,$post) {
    
        $type     = $plural;
        $singular = ucfirst($singular);
        $plural   = ucfirst($plural);

		add_action('init', function() use ($singular,$plural,$type,$post){

			// Set UI labels for Custom Post Type
		    $labels = array(
			    'name'              => _x($plural, 'taxonomy general name' ,'book-shop'),
			    'singular_name'     => _x($singular, 'taxonomy singular name' ,'book-shop'),
			    'search_items'      =>  __( 'Search '.$plural ,'book-shop'	),
			    'all_items'         => __( 'All '.$plural ,'book-shop'),
			    'parent_item'       => __( 'Parent '.$singular ,'book-shop'),
			    'parent_item_colon' => __( 'Parent '.$singular.':' ,'book-shop'),
			    'edit_item'         => __( 'Edit '.$singular ,'book-shop'), 
			    'update_item'       => __( 'Update '.$singular ,'book-shop'),
			    'add_new_item'      => __( 'Add New '.$singular ,'book-shop'),
			    'new_item_name'     => __('New '.$singular.' Name' ,'book-shop'),
			    'menu_name'         => __($plural,'book-shop'),
			);   

			$args = array(
			    'hierarchical'      => true,
			    'labels'            => $labels,
			    'show_ui'           => true,
			    'show_in_rest'      => true,
			    'show_admin_column' => true,
			    'query_var'         => true,
			    'rewrite'           => array('slug' => $type),
			); 
 
			// Now register the taxonomy
			register_taxonomy( $type , array($post) , $args);
		});	  
    }
}
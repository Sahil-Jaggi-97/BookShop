<?php
namespace BookShop\Includes;

use BookShop\Includes\Assets;
use BookShop\Includes\PostTypes;
use BookShop\Includes\Taxonomies;
use BookShop\Includes\MetaBoxes;
use BookShop\Includes\Ajaxify;
use BookShop\Includes\SinglePost;

class Init {

	public function __construct($file) {
        
        // Register plugin css and js files 
		Assets::register($file);

        // Register Shortcodes for plugin   
		ShortCodes::add();

		// Trigger our function that registers the custom post type.
	    PostTypes::add('book','books');

	    // Trigger our function that registers the custom taxonomy to post type.
	    Taxonomies::add('author','authors','books');
	    Taxonomies::add('publisher','publishers','books');
        
        // Trigger our function that registers the meta box to post type.
        MetaBoxes::add('Price' ,'text' ,'books');
        MetaBoxes::add('Rating','numeric','books');

        // Save MetaData for post type.
        add_action('save_post',['BookShop\Includes\MetaBoxes','save']); 

        // Initialize plugin ajax instance
        new Ajaxify();

        // Initialize plugin singlepost instance
        new SinglePost(); 
	}
}

?>
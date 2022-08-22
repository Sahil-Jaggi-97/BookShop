<?php
namespace BookShop\Includes;

use BookShop\Includes\Assets;

class ShortCodes{
 
    // This will register our shortcode and load the neccessary assets
	public static function add(){

		add_shortcode('Allbooks', function($atts){

			Assets::load();

			$data = require_once __DIR__ ."/../templates/bookshop.php";
			return $data;
		});
	}
}
<?php
namespace BookShop\Includes;

use BookShop\Includes\Assets;

class SinglePost {

	public function __construct() {
        
        // Add the book details on the detail page of book 
		add_filter( 'the_content', array($this,'singleBookContent') , 99);
	}

	public function singleBookContent($content){

		if( 'books' == get_post_type() &&  is_singular() && in_the_loop() && is_main_query()){

            global $post;

            Assets::load();

            $id         = $post->ID;
            $price      = get_post_meta($id,'bookshop_price',true);
            $rating     = get_post_meta($id,'bookshop_rating',true);
            $authors    = wp_get_post_terms($id,'authors');
            $publishers = wp_get_post_terms($id,'publishers'); 

            foreach($authors as $author){
            	$id           = $author->term_id;
            	$link         = get_term_link($id);
            	$name         = $author->name;
            	$newauthors[] = ['name' => "<a target='_blank' href='".$link."'>".$name."</a>"];
            }

            foreach($publishers as $publisher){
            	$id              = $publisher->term_id;
            	$link            = get_term_link($id);
            	$name            = $publisher->name;
            	$newpublishers[] = ['name' => "<a target='_blank' href='".$link."'>".$name."</a>"];
            }

            $authors    = implode(",", array_column($newauthors, 'name'));
            $publishers = implode(",",array_column($newpublishers, 'name'));

            $rating     = ($rating) ? ((int)$rating/ 5) * 100 : 0;
       
			$html      = "<div class='bookshop-bookdetails'>
			                   <div class='book-author'>
			                     <label>Author :</label>
			                     <span>{$authors}</span>
			                   </div>
			                   <div class='book-publisher'>
			                     <label>Publisher :</label>
			                     <span>{$publishers}</span>
			                   </div>
			                   <div class='book-rating'>
			                     <label>Rating :</label>
			                     <span>
			                        <div class='ratings'>
				                        <div class='empty-stars'></div>
				                        <div class='full-stars' style='width:{$rating}%'></div>
				                    </div>
				                 </span>
			                   </div>
			                   <div class='book-price'>
			                     <label>Price :</label>
			                     <span>{$price}</span>
			                   </div>  
			              </div>";

	        $content = $content.$html;
		}	
	    return $content;
	}
}

?>
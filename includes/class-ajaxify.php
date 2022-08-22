<?php
namespace BookShop\Includes;

class Ajaxify{
 
    public function __construct(){

        // Get all,searched and paginated books 
        add_action("wp_ajax_getAllBooks", array($this , 'getAllBooks'));
        add_action("wp_ajax_nopriv_getAllBooks", array($this , 'getAllBooks'));

        // Get all the authors for search filter dropdown 
        add_action("wp_ajax_getAllAuthors", array($this , 'getAllAuthors'));
        add_action("wp_ajax_nopriv_getAllAuthors", array($this , 'getAllAuthors'));
       
        // Get all the publishers for search filter dropdown
        add_action("wp_ajax_getAllPublishers", array($this , 'getAllPublishers'));
        add_action("wp_ajax_nopriv_getAllPublishers", array($this , 'getAllPublishers'));
    }

    public function getAllAuthors(){

        $response = ["status" => false , "message" => "Something Went Wrong"];   

        if ( !wp_verify_nonce( $_GET['nonce'], "bookshopobject")) {
            $response["message"] = "You are not authorised";
        }
        else{

            $terms = get_terms(array(
                'taxonomy'   => 'authors',
                'hide_empty' => false,
            ));

            if (!empty($terms)){

                foreach($terms as $category){ 
                    $data[] = ['id' => $category->term_id , 'name' => $category->name];
                }

                $response["message"] = "Author Found";
                $response["output"]  = $data;
                $response["status"]  = true;
            }
            else{
                $response["message"] = "No Author Found";
            }

            wp_send_json($response);
        }
    }

    public function getAllPublishers(){

        $response = ["status" => false , "message" => "Something Went Wrong"];   

        if ( !wp_verify_nonce( $_GET['nonce'], "bookshopobject")) {
            $response["message"] = "You are not authorised";
        }
        else{

            $terms = get_terms(array(
                'taxonomy'   => 'publishers',
                'hide_empty' => false,
            ));

            if (!empty($terms)){

                foreach($terms as $category){ 
                    $data[] = ['id' => $category->term_id , 'name' => $category->name];
                }

                $response["message"] = "Publisher Found";
                $response["output"]  = $data;
                $response["status"]  = true;
            }
            else{
                $response["message"] = "No Publisher Found";
            }

            wp_send_json($response);
        }
    }

	public function getAllBooks(){ 
         
        $response = ["status" => false , "message" => "Something Went Wrong"];   

        if ( !wp_verify_nonce( $_GET['nonce'], "bookshopobject")) {
            $response["message"] = "You are not authorised";
        }
        else{

            $args      = array('post_type'      => 'books',
                               'post_status'    => 'publish',
                               'posts_per_page' => 10,
                               'paged'          => 1,
                               'orderby'        => 'ID',
                               'order'          => 'ASC',
                               'meta_query'     => [],
                               'tax_query'      => [],
            );

            if( isset($_GET['paged']) && !empty($_GET['paged'])){
                $args['paged'] = $_GET['paged'];
            }

            if( isset($_GET['bookname']) && !empty($_GET['bookname'])){
                $args['title'] = $_GET['bookname'];
            }

            if( isset($_GET['rating']) && !empty($_GET['rating'])){
                
                $query = ['key'   => 'bookshop_rating',
                         'value'  => $_GET['rating']
                ];
                array_push($args['meta_query'],$query);
            }

            if( isset($_GET['price']) && !empty($_GET['price'])){

                $query = ['key'     => 'bookshop_price',
                          'value'   =>  $_GET['price'],
                          'compare' => '<=',
                          'type'    => 'numeric'
                ];

                array_push($args['meta_query'],$query);
            }   

            if( isset($_GET['publisher']) && !empty($_GET['publisher'])){

                $query = ['taxonomy'   => 'publishers',
                          'terms'      => $_GET['publisher']
                ];

                array_push($args['tax_query'],$query);

            }

            if( isset($_GET['author']) && !empty($_GET['author'])){

                $query = ['taxonomy'   => 'authors',
                          'terms'      => $_GET['author']
                ];

                array_push($args['tax_query'],$query);
            }

            $the_query = new \WP_Query($args);

            $response["total"]  = $the_query->found_posts;
            $response["paged"]  = $args['paged'];
                 
            if ($the_query->have_posts()){
                
                while ($the_query->have_posts()) {
                    $the_query->the_post();

                    $data[] = ['id'        => get_the_ID(),
                               'name'      => get_the_title(),
                               'booklink'  => get_the_permalink(),
                               'price'     => get_post_meta(get_the_ID(),'bookshop_price',true),
                               'rating'    => get_post_meta(get_the_ID(),'bookshop_rating',true),
                               'author'    => wp_get_post_terms(get_the_ID(),'authors',['fields' => 'names']),
                               'publisher' => wp_get_post_terms(get_the_ID(),'publishers',['fields' => 'names']) 
                    ];
                }

                $response["status"]  = true;
                $response["message"] = "Book Found";
                $response["output"]  = $data;
            }
            else{
                $response["message"] = "No Book Found";
            }

            wp_reset_postdata();
        }

        wp_send_json($response);
    }
}
<?php
namespace BookShop\Includes;

class MetaBoxes{

	public static $metakey = "bookshop";

    // This will add metafields to specified post type
	public static function add($title,$input,$postype){
    
		add_action('add_meta_boxes', function() use ($title,$input,$postype){
			$id   = "key".time().$title;
			add_meta_box($id,$title,function($post) use ($title,$input){
				self::renderHtml($post,$title,$input);
			},$postype);
		});	  
    }

    
    // This will check the plugin metafields start with plugin key then save those fields
    public static function save($post_id) {
        
    	$bookshop = array_filter(array_keys($_POST),function($val){
    		if(strpos($val, self::$metakey) !== false){
    			return $val;
    		}
    	});

    	
        if ($bookshop){
        	foreach($bookshop as $value){
        		update_post_meta($post_id,$value,$_POST[$value]);
        	}
        }
    }
    
    // This will be responsible for rendering the html for specific metafields
    public static function renderHtml($post,$title,$html){

        $field = strtolower($title); 
        $name  = self::$metakey."_".$field;
        $value = get_post_meta($post->ID,$name,true);

    	if($html == "text"){
    		self::textField($name,$value);
    	}
    	elseif($html == "numeric"){
    		self::numericField($name,$value);
    	} 
    }

    public static function textField($name ,$value) {
        ?>
         <input type="text" required name="<?php echo $name; ?>" value="<?php echo $value; ?>">  
        <?php
    }

    public static function numericField($name,$value) {
        ?>
        <input type="number" required min="1" max="5" name="<?php echo $name; ?>" value="<?php echo $value; ?>">  
        <?php
    }
}
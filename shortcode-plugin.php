<?php
/**
 * Plugin Name: ShortCode Plugin
 * Description:  This is the seccond plugin of this course which gives idea about shortcode basics and how it workds
 * Version: 1.0
 * Author: Praveen Suthar
 * Plugin URI: https://gbas.in/
 * Author URI: https://gbas.in/
 */


//  Basic Shortcode 
add_shortcode('message', 'sp_show_static_message') ;

function sp_show_static_message(){

    return 'Hello I am a simple shortcode message.' ;
}

add_shortcode('student', 'sc_show_student_data') ; 

// parameterized shortcode

function  sc_show_student_data($attributes){

 $attributes =    shortcode_atts(array(
        'name' => 'Default Name',
        'email' => 'Default Email',
    ), $attributes, 'student');

    return "<h3>The Name - {$attributes['name']} ,  The email is- {$attributes['email']} </h3>";
}

// Shotcode with Db Operations


add_shortcode('post-lists', 'sp_handle_post_lists') ; 

function  sp_handle_post_lists(){
    global $wpdb ;

    $table_prefix = $wpdb->prefix ;
    $table_name = $table_prefix."posts" ; 

    // Get posts whose 	post_status  is publish and post_type is post

     $posts = $wpdb->get_results(
        "SELECT post_title FROM {$table_name} WHERE post_status = 'publish' AND  post_type = 'post' "

    );

   if(count($posts) > 0){
        
        $outputHTML = "<ul>" ; 

        foreach($posts as $post){

            $outputHTML .= "<li>".  $post->post_title ."</li>" ;


        }

        $outputHTML .= "</ul>" ; 

        return $outputHTML ; 
   }

   return  "No posts found" ;

}

// shortcode with db operations using post query class

add_shortcode('post-list', 'sp_handle_post_using_wp_query_class') ;

function sp_handle_post_using_wp_query_class($attributes){

    $attributes = shortcode_atts(array(
        "number" => 5
    ), $attributes, "post-list") ; 

    $query = new WP_query(array( 
        "posts_per_page" => $attributes["number"], 
        "post_status" => "publish"

    )); 

    if($query->have_posts()){

        $outputHTML = "<ul>" ; 

        while($query->have_posts()){
            $query ->the_post();
            $outputHTML .= "<li>".get_the_title()." ". get_the_date() ."</li>" ; 
        }

        $outputHTML .= "</ul>" ; 

        return $outputHTML ; 
    }

    return "No posts found" ; 
}

?> 
<?php
/**
 * Plugin Name: Idea Pro Example Plugin
 * Description: This is just an example Plugin      
 */

 function example_function(){

    $information = 'This is a very basic plugin';
    $information .= '<div>This is a div </div>'; 
    $information .= '<p>This is a block of paragraph text</p>';    
    return $information;
 }
 add_shortcode('example','example_function');

 function ideapro_admin_menu_option(){

    add_menu_page('Header & Footer Scripts','Site Scripts','manage_options','ideapro-admin-menu','ideapro_script_page','dashicons-admin-home',200);            ;
 }

add_action('admin_menu','ideapro_admin_menu_option');

function ideapro_script_page(){

    if(array_key_exists('submit_scripts_update',$_POST)){
        update_option('ideapro_header_scripts',$_POST['header_scripts']);
        update_option('ideapro_footer_scripts',$_POST['footer_scripts']);


    }
    $header_scripts = get_option('ideapro_header_scripts','none');
    $footer_scripts = get_option('ideapro_footer_scripts','none');
    ?>
        <div id="setting-error-settings-updated" class="updated settings-error notice is-dismissible"><strong>Settings have been saved</strong></div>
    <?php

    ?>
    <div class='wrap'>
        <h2>Update scripts.</h2>
        <form action="" method="post">  
        <label for="header_scripts">Header Scripts</label>
        <textarea class='large-text' name="header_scripts"><?php print $header_scripts; ?></textarea>
        <label for="footer_scripts">Footer Scripts</label>
        <textarea class='large-text' name="footer_scripts"><?php print $footer_scripts; ?></textarea>
        <input type="submit" name="submit_scripts_update" value="UPDATE SCRIPTS" class="button button-primary   ">
        </form>
    </div>
    <?php
}

function ideapro_display_header_scripts(){

    $header_scripts = get_option('ideapro_header_scripts','none');
    print $header_scripts;

}
add_action('wp_head','ideapro_display_header_scripts');

function ideapro_display_footer_scripts(){

    $footer_scripts = get_option('ideapro_footer_scripts','none');
    print $footer_scripts;
}
add_action('wp_footer','ideapro_display_footer_scripts');   


function ideapro_form(){

$information = '';
$information .= '<form method="post" action="http://wordpress.test/thank-you/">';
    $information .='<input type="text" name="full_name" placeholder="Your Full Name" />';
    $information .='<br/>';
    $information .='<input type="text" name="email_address" placeholder="Email Address" />';
    $information .='<br/>';
    $information .='<input type="text" name="phone_number" placeholder="Phone Number" />';
    $information .='<br/>';
    $information .='<textarea name="comments" placeholder="Give us your comments"></textarea>';
    $information .='<br/>';
    $information .='<input type="submit" name="ideapro_submit_form" value="SUBMIT YOUR INFORMATION">';
$information .= '</form>';
return $information;    

}

add_shortcode('ideapro_contact_form','ideapro_form');

function set_html_content_type(){
    return 'text/html'; 
}

function ideapro_form_capture(){

    global $post;

if(array_key_exists('ideapro_submit_form',$_POST)){
    $to = "jithingeorge165@gmail.com";
    $subject = "Idea Pro Example Site Form Submission";
    $body="";

    $body .= 'Name: '.$_POST['full_name']. "<br/>";
    $body .= 'Email: '.$_POST['email_address']. "<br/>";
    $body .= 'Phone Number: '.$_POST['phone_number']. "<br/>";
    $body .= 'Comments: '.$_POST['comments']. "<br/>";

    add_filter("wp_mail_content_type",'set_html_content_type');

    wp_mail($to,$subject,$body); 

    remove_filter('wp_mail_content_type','set_html_content_type'); 

    $time = current_time('mysql'); 

    $data = [
        'comment_post_ID'      => $post -> ID,
        'comment_content'      => $body,
        'comment_author_IP'    => $_SERVER['REMOTE_ADDR'],
        'comment_date'         => $time,    
        'comment_approved'     => 1,
    ];
    
    wp_insert_comment($data);
}
}

add_action("wp_head","ideapro_form_capture");    
<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
global $wpdb;

$sql = "DROP TABLE IF EXISTS `" . $wpdb->prefix . "zgallery_settings`";
$wpdb->query($sql);

$sql1 = "CREATE TABLE " . $wpdb->prefix . "zgallery (
	`gallery_id` int(11) NOT NULL auto_increment,          
   `gallery_name` varchar(255) default NULL,              
   `gallery_description` text,                            
   `creation_date` date default NULL,                     
   PRIMARY KEY  (`gallery_id`) 
	) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE utf8_general_ci";
$wpdb->query($sql1);

$sql = "DROP TABLE IF EXISTS `" . $wpdb->prefix . "zgallery_images`";
$wpdb->query($sql);

$sql2 = "CREATE TABLE " . $wpdb->prefix . "zgallery_images (
	`image_id` int(11) NOT NULL auto_increment,             
	  `gallery_id` int(11) NOT NULL,                          
	  `image_name` varchar(255) default NULL,                 
	  `image_path` varchar(255) default NULL,                 
	  `image_tags` text,                                      
	  `image_alt` varchar(255) default NULL,                  
	  `image_description` text,                               
	  `exclude` tinyint(1) default NULL,                      
	  `sort_order` bigint(20) default NULL,                   
	  `creation_date` date default NULL,                      
	  PRIMARY KEY  (`image_id`)
	) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE utf8_general_ci";
$wpdb->query($sql2);

$sql = "DROP TABLE IF EXISTS `" . $wpdb->prefix . "zgallery_settings`";
$wpdb->query($sql);

$sql3 = "CREATE TABLE " . $wpdb->prefix . "zgallery_settings (
	`setting_id` int(10) unsigned NOT NULL auto_increment,  
	`setting_key` varchar(100) NOT NULL,                    
	`setting_value` text NOT NULL,                          
	PRIMARY KEY  (`setting_id`)
	) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE utf8_general_ci";
$wpdb->query($sql3);


$settings = array();

$settings["delete_images"] = "0";
$settings["sort_order"] = "0";
$settings["sort_direction"] = "0";
$settings["custom_css"] = "0";
$settings["custom_css_content"] = "";

$settings["thumbnail_custom_enable"] = "1";
$settings["thumbnail_width"] = "160";
$settings["thumbnail_height"] = "120";
$settings["thumbnail_opacity"] = "1";
$settings["thumbnail_border_size"] = "2";
$settings["thumbnail_border_radius"] = "2";
$settings["thumbnail_border_color"] = "#000000";
$settings["margin_btw_thumbnails"] = "5";
$settings["thumbnail_text_color"] = "#ffffff";
$settings["thumbnail_text_align"] = "center";
$settings["thumbnail_font_family"] = "Verdana";
$settings["heading_font_size"] = "16";
$settings["text_font_size"] = "12";
$settings["thumbnail_desc_length"] = "60";

$settings["cover_custom_enable"] = "1";
$settings["cover_thumbnail_width"] = "160";
$settings["cover_thumbnail_height"] = "120";
$settings["cover_thumbnail_opacity"] = "1";
$settings["cover_thumbnail_border_size"] = "2";
$settings["cover_thumbnail_border_radius"] = "2";
$settings["cover_thumbnail_border_color"] = "#000000";
$settings["margin_btw_cover_thumbnails"] = "5";
$settings["album_text_align"] = "left";
$settings["album_font_family"] = "Verdana";
$settings["album_heading_font_size"] = "16";
$settings["album_text_font_size"] = "12";
$settings["album_desc_length"] = "400";

$settings["lightbox_type"] = "pretty_photo";
$settings["lightbox_overlay_opacity"] = "0.6";
$settings["lightbox_overlay_border_size"] = "5";
$settings["lightbox_overlay_border_radius"] = "5";
$settings["lightbox_text_color"] = "#ffffff";
$settings["lightbox_overlay_border_color"] = "#ffffff";
$settings["lightbox_inline_bg_color"] = "#ffffff";
$settings["lightbox_overlay_bg_color"] = "#000000";
$settings["lightbox_fade_in_time"] = "500";
$settings["lightbox_fade_out_time"] = "500";
$settings["lightbox_text_align"] = "left";
$settings["lightbox_font_family"] = "Verdana";
$settings["lightbox_heading_font_size"] = "16";
$settings["lightbox_text_font_size"] = "12";
$settings["facebook_comments"] = "0";
$settings["social_sharing"] = "0";
$settings["image_title_setting"] = "1";
$settings["image_desc_setting"] = "1";

$settings["autoplay_setting"] = "0";
$settings["slide_interval"] = "5";

$settings["pagination_setting"] = "0";
$settings["images_per_page"] = "10";

$settings["filters_setting"] = "0";
$settings["filter_font_family"] = "Verdana";
$settings["filter_font_size"] = "12";
$settings["back_button_text"] = "Back to Albums";
$settings["album_click_text"] = "Click to View Album";
$settings["album_text_color"] = "#C0C0C0";
$settings["button_color"] = "#000000";
$settings["button_text_color"] = "#CCCCCC";
$settings["filters_color"] = "#2a83ed";
$settings["filters_text_color"] = "#ffffff";
$settings["album_seperator"] = "1";
$settings["back_button_font_family"] = "Verdana";
$settings["back_button_font_size"] = "12";

$settings["admin_full_control"] = "1";
$settings["admin_read_control"] = "1";
$settings["admin_write_control"] = "1";
$settings["editor_full_control"] = "0";
$settings["editor_read_control"] = "1";
$settings["editor_write_control"] = "0";
$settings["author_full_control"] = "0";
$settings["author_read_control"] = "1";
$settings["author_write_control"] = "0";
$settings["contributor_full_control"] = "0";
$settings["contributor_read_control"] = "1";
$settings["contributor_write_control"] = "0";
$settings["subscriber_full_control"] = "0";
$settings["subscriber_read_control"] = "1";
$settings["subscriber_write_control"] = "0";

$settings["language_direction"] = "inherit";
foreach ($settings as $val => $innerKey)
{
    $wpdb->query
    (
        $wpdb->prepare
        (
            "INSERT INTO " . $wpdb->prefix . "zgallery_settings (setting_key, setting_value) VALUES(%s, %s)",
            $val,
            $innerKey
        )
    );
}

?>
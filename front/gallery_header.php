<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
global $wpdb;
$unique_id = rand(100, 10000);
$effect = explode("-", $special_effect);

$image_sort_order = $wpdb->get_row( "SELECT * FROM ".$wpdb->prefix."zgallery_settings WHERE setting_key='sort_order'", ARRAY_A );
$image_sort_direction = $wpdb->get_row( "SELECT * FROM ".$wpdb->prefix."zgallery_settings WHERE setting_key='sort_direction'", ARRAY_A );

$zgallery_settings = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix. "zgallery_settings");
$zsettings = array();
foreach($zgallery_settings as $zgallery_setting){
	$zsettings[$zgallery_setting->setting_key] = $zgallery_setting->setting_value;
}

$album = $wpdb->get_results
	(
		$wpdb->prepare
			(
				"SELECT * FROM " . $wpdb->prefix. "zgallery where gallery_id = %d",
				$album_id
			),ARRAY_A
	);

if($image_sort_order['setting_value'] == 'image_id') {

	$pics = $wpdb->get_results
	(
		$wpdb->prepare
			(
				"SELECT * FROM " . $wpdb->prefix. "zgallery_images WHERE gallery_id = %d order by image_id ".$image_sort_direction['setting_value'],
				$album_id
			)
	);

} else {

	$pics = $wpdb->get_results
	(
		$wpdb->prepare
			(
				"SELECT * FROM " . $wpdb->prefix. "zgallery_images WHERE gallery_id = %d order by sort_order ".$image_sort_direction['setting_value'],
				$album_id
			)
	);
}
?>
<style>
.overlay_text h5 {
margin-top:10px !important;
padding: 0 10px 0 10px !important;
line-height: 1.5em !important;
text-align: center !important;
color: #cfcfcf !important;
font-size: 20px !important;
}

.overlay_text > p {
padding: 10px 10px 0 10px !important;
line-height: 1.5em !important;
<?php /*direction: <?php echo $lang_dir_setting; ?> !important;
text-align: <?php echo $thumbnail_text_align;?> !important;
font-family: <?php echo $thumbnail_font_family;?> !important;
color: <?php echo $thumbnail_text_color?> !important;
font-size: <?php echo $text_font_size?>px !important; */?>
}
</style>
            <h3><?php echo $album[0]['gallery_name']; ?></h3>
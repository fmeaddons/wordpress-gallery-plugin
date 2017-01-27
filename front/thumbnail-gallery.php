<?php 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
$image_width = $wpdb->get_row( "SELECT * FROM ".$wpdb->prefix."zgallery_settings WHERE setting_key='thumbnail_width'", ARRAY_A );
$image_height = $wpdb->get_row( "SELECT * FROM ".$wpdb->prefix."zgallery_settings WHERE setting_key='thumbnail_height'", ARRAY_A );

$border_size = $wpdb->get_row( "SELECT * FROM ".$wpdb->prefix."zgallery_settings WHERE setting_key='thumbnail_border_size'", ARRAY_A );
$border_color = $wpdb->get_row( "SELECT * FROM ".$wpdb->prefix."zgallery_settings WHERE setting_key='thumbnail_border_color'", ARRAY_A );
$border_radius = $wpdb->get_row( "SELECT * FROM ".$wpdb->prefix."zgallery_settings WHERE setting_key='thumbnail_border_radius'", ARRAY_A );

$thumbnail_text_color = $wpdb->get_row( "SELECT * FROM ".$wpdb->prefix."zgallery_settings WHERE setting_key='thumbnail_text_color'", ARRAY_A );
$thumbnail_text_align = $wpdb->get_row( "SELECT * FROM ".$wpdb->prefix."zgallery_settings WHERE setting_key='thumbnail_text_align'", ARRAY_A );

$custom_css = $wpdb->get_row( "SELECT * FROM ".$wpdb->prefix."zgallery_settings WHERE setting_key='custom_css'", ARRAY_A );
$custom_css_content = $wpdb->get_row( "SELECT * FROM ".$wpdb->prefix."zgallery_settings WHERE setting_key='custom_css_content'", ARRAY_A );
$zgallery_images = $wpdb->prefix . "zgallery_images";
$pics = $wpdb->get_results
			(
					"SELECT * FROM " . $zgallery_images . " WHERE gallery_id = ". $album_id ." order by image_id desc "
			);
?>

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=64021732675&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<style type="text/css">
.boxSep{
	background-color:#f7f7f7;
	border: 1px solid #ddd;
	margin:10px;
	float:left;
	margin-right:30px;
}
.zgal_thumb {
	width: <?php echo $image_width['setting_value'] ?>px; 
	height: <?php echo $image_height['setting_value'] ?>px;
	border: solid <?php echo $border_size['setting_value'] ?>px <?php echo $border_color['setting_value']; ?>;
	border-radius: <?php echo $border_radius['setting_value'] ?>px;
}

 div.ppt {
	
	color: <?php echo $thumbnail_text_color['setting_value'] ?>;
	text-align: <?php echo $thumbnail_text_align['setting_value']  ?>;
}
</style>
<?php if($custom_css['setting_value'] == 1) { ?>

<style type="text/css">
	<?php echo $custom_css_content['setting_value']; ?>
</style>

<?php } ?>
<?php

	for($flag = 0; $flag< count($pics); $flag++) 
	{
		$image_title = $pics[$flag]->image_alt;
		$image_description = $pics[$flag]->image_description;
		$exclude = $pics[$flag]->exclude;
		if($exclude == 0) {
?>
<div class="boxSep" >
		<div class="imgLiquidFill imgLiquid zgal_thumb" data-imgLiquid-fill="false" data-imgLiquid-verticalAlign="50%">
				<a rel="prettyPhoto[gallery]"  href="<?php echo stripcslashes($pics[$flag]->image_path); ?>" title="<?php echo $image_description;?>" id="ux_img_div_<?php echo $unique_id;?>">
				<img imageid="<?php echo $pics[$flag]->image_id;?>" id="ux_gb_img_<?php echo $unique_id;?>"
                                 type="image" src="<?php echo stripcslashes($pics[$flag]->image_path);?>" alt="<?php echo $image_title;?>"/>
				
				</a>
		</div>
	</div>
<?php
} }
?>
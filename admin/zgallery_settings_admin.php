<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
global $wpdb;
$zgallery_settings = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix. "zgallery_settings");
$zsettings = array();
foreach($zgallery_settings as $zgallery_setting){
	$zsettings[$zgallery_setting->setting_key] = $zgallery_setting->setting_value;
}

if(isset($_POST['reset'])) {

	$settings = array();

$settings["delete_images"] = "0";
$settings["sort_order"] = "0";
$settings["sort_direction"] = "0";
$settings["custom_css"] = "0";
$settings["custom_css_content"] = " ";

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

}

if(isset($_POST['submit'])) {
	
	foreach($_POST as $key=>$value){
		
		$wpdb->query("Update " . $wpdb->prefix . "zgallery_settings set setting_value='".sanitize_text_field($value)."' where setting_key='".sanitize_text_field($key)."'");
	}
	
}


?>
<div class="wrap">
	<form action="" method="post">
	<div id="tabs">
		<ul>
			<li><a href="#tabs-1">Image Options</a></li>
			<li><a href="#tabs-2">Thumbnail Options</a></li>
			<li style="display:none;"><a href="#tabs-3">Lightbox Effect</a></li>
			<li><a href="#tabs-4">Custom CSS</a></li>
			<li><a href="#tabs-5">Reset Options</a></li>
		</ul>
		<div id="tabs-1">
			<table class="settings-table">
				<tr style="display:none;">
					<td class="column1">Gallery Path</th>
					<td><input type="text" name="gallery_path" id="gallery_path" value="<?php echo $zsettings['gallery_path']; ?>" /></td>
				</tr>
				<tr>
					<td class="column1">Delete Images ?</th>
					<td><input type="radio" name="delete_images" id="delete_images" value="1" <?php echo ($zsettings['delete_images']==1) ? 'checked="checked"' : ''; ?> /> Yes <input type="radio" name="delete_images" id="delete_images" value="0" <?php echo ($zsettings['delete_images']==0) ? 'checked="checked"' : ''; ?> /> No (If enabled image files will be removed after a Gallery deleted )</td>
				</tr>
				<tr>
					<td class="column1">Sort Order</th>
					<td><select id="sort_order" name="sort_order">
							<option value="custom" <?php echo ($zsettings['sort_order']=='custom') ? 'selected="selected"' : ''; ?>>Custom</option>
							<option value="image_id" <?php echo ($zsettings['sort_order']=='image_id') ? 'selected="selected"' : ''; ?>>Image ID</option>
							
						</select>
					</td>
				</tr>
				<tr>
					<td class="column1">Sort Direction</th>
					<td>
						<select id="sort_direction" name="sort_direction">
							<option value="asc" <?php echo ($zsettings['sort_direction']=='asc') ? 'selected="selected"' : ''; ?>>Ascending</option>
							<option value="desc" <?php echo ($zsettings['sort_direction']=='desc') ? 'selected="selected"' : ''; ?>>Descending</option>
						</select>
					</td>
				</tr>
<tr>
					<td class="column1">Text Color</th>
					<td><input type="text" name="thumbnail_text_color" id="text_color" class="thumboptions" value="<?php echo $zsettings['thumbnail_text_color']; ?>" /></td>
</tr>
<tr>
					<td class="column1">Text Align</th>
					<td>
						<select id="text_align" name="thumbnail_text_align">
							<option value="left" <?php echo ($zsettings['thumbnail_text_align']=='left') ? 'selected="selected"' : ''; ?>>Left</option>
							<option value="center" <?php echo ($zsettings['thumbnail_text_align']=='center') ? 'selected="selected"' : ''; ?>>Center</option>
							<option value="right" <?php echo ($zsettings['thumbnail_text_align']=='right') ? 'selected="selected"' : ''; ?>>Right</option>
						</select>
					</td>
				</tr>
			</table>
		</div>
		<div id="tabs-2">
			<table class="settings-table">
				<tr>
					<td class="column1">Thumbnail Dimentions</th>
					<td colspan="3"><input type="text" name="thumbnail_width" id="thumbnail_width" maxlength="4" class="dimentions" value="<?php echo $zsettings['thumbnail_width']; ?>" /> X <input type="text" name="thumbnail_height" id="thumbnail_height" maxlength="4" class="dimentions" value="<?php echo $zsettings['thumbnail_height']; ?>" /> px</td>
				</tr>
				<tr>
					<td class="column1">Border Size</th>
					<td><input type="text" name="thumbnail_border_size" id="border_size" maxlength="4" class="thumboptions" value="<?php echo $zsettings['thumbnail_border_size']; ?>" /> px</td>
					<td class="column1">Border Radius</th>
					<td><input type="text" name="thumbnail_border_radius" id="border_radius" maxlength="4" class="thumboptions" value="<?php echo $zsettings['thumbnail_border_radius']; ?>" /> px</td>
				</tr>
				<tr>
					<td class="column1">Margin Between Images</th>
					<td><input type="text" name="margin_btw_thumbnails" id="margin_images" class="thumboptions" value="<?php echo $zsettings['margin_btw_thumbnails']; ?>" /> px</td>
					<td class="column1">Border Color</th>
					<td><input type="text" name="thumbnail_border_color" id="border_color" class="thumboptions" value="<?php echo $zsettings['thumbnail_border_color']; ?>" />
					<p>i.e. #cfcfcf</p>
					</td>
				</tr>
				
			</table>
		</div>
		<div id="tabs-3" style="display:none;">
			<table class="settings-table">
				<tr>
					<td class="column1">Lightbox Effect</th>
					<td>
						<select id="lightbox_effect" name="lightbox_effect">
							<option value="lightbox" <?php echo ($zsettings['lightbox_effect']=='lightbox') ? 'selected="selected"' : ''; ?>>Lightbox</option>
							<option value="fancybox" <?php echo ($zsettings['lightbox_effect']=='fancybox') ? 'selected="selected"' : ''; ?>>Fancybox</option>
							<option value="thickbox" <?php echo ($zsettings['lightbox_effect']=='thickbox') ? 'selected="selected"' : ''; ?>>Thickbox</option>
							<option value="highslide" <?php echo ($zsettings['lightbox_effect']=='highslide') ? 'selected="selected"' : ''; ?>>Highslide</option>
							<option value="shutter" <?php echo ($zsettings['lightbox_effect']=='shutter') ? 'selected="selected"' : ''; ?>>Shutter</option>
							<option value="prettyphoto" <?php echo ($zsettings['lightbox_effect']=='prettyphoto') ? 'selected="selected"' : ''; ?>>Pretty Photo</option>
						</select>
					</td>
				</tr>
				<tr>
					<td class="column1">Image Title</th>
					<td><input type="radio" name="image_title" id="image_title" value="1" <?php echo ($zsettings['image_title']==1) ? 'checked="checked"' : ''; ?> />Enable <input type="radio" name="image_title" id="image_title" value="0" <?php echo ($zsettings['image_title']==0) ? 'checked="checked"' : ''; ?> />Disable</td>
				</tr>
				<tr>
					<td class="column1">Image Description</th>
					<td><input type="radio" name="image_desc" id="image_desc" value="1" <?php echo ($zsettings['image_desc']==1) ? 'checked="checked"' : ''; ?> />Enable <input type="radio" name="image_desc" id="image_desc" value="0" <?php echo ($zsettings['image_desc']==0) ? 'checked="checked"' : ''; ?> />Disable</td>
				</tr>
				<tr>
					<td class="column1">Facebook Comments</th>
					<td><input type="radio" name="fb_comments" id="fb_comments" value="1" <?php echo ($zsettings['fb_comments']==1) ? 'checked="checked"' : ''; ?> />Enable <input type="radio" name="fb_comments" id="fb_comments" value="0" <?php echo ($zsettings['fb_comments']==0) ? 'checked="checked"' : ''; ?> />Disable</td>
				</tr>
				<tr>
					<td class="column1">Social Sharing</th>
					<td><input type="radio" name="social_sharing" id="social_sharing" value="1" <?php echo ($zsettings['social_sharing']==1) ? 'checked="checked"' : ''; ?> />Enable <input type="radio" name="social_sharing" id="social_sharing" value="0" <?php echo ($zsettings['social_sharing']==0) ? 'checked="checked"' : ''; ?> />Disable</td>
				</tr>
			</table>
		</div>
		<div id="tabs-4">
			<table class="settings-table">
				<tr>
					<td class="column1">Custom CSS</th>
					<td><input type="radio" name="custom_css" id="custom_css" value="1" <?php echo ($zsettings['custom_css']==1) ? 'checked="checked"' : ''; ?> />Enable <input type="radio" name="custom_css" id="custom_css" value="0" <?php echo ($zsettings['custom_css']==0) ? 'checked="checked"' : ''; ?> />Disable</td>
				</tr>
				<tr>
					<td class="column1">CSS Content</th>
					<td>
						<textarea name="custom_css_content" id="custom_css_content" style="width:100%; height:100px;"><?php echo $zsettings['custom_css_content']; ?></textarea>
						<p>Place all your custom css content in this box i.e. .test{width:100%;}</p>
					</td>
				</tr>
			</table>
		</div>
		<div id="tabs-5">
			<table class="settings-table">
				<tr>
					<td class="column1"></th>
					<td><input type="submit" value="Reset to default settings" name="reset" id="reset" /></td>
				</tr>
			</table>
		</div>
	</div>
		<br />
		<input type="submit" name="submit" id="search-submit" class="button button-primary button-large" value="Save">
	</form> 
</div>
<script language="javascript">
jQuery(document).ready(function($) {
$('#tabs').tabs();

//hover states on the static widgets
$('#dialog_link, ul#icons li').hover(
function() { $(this).addClass('ui-state-hover'); },
function() { $(this).removeClass('ui-state-hover'); }
);
});
</script>

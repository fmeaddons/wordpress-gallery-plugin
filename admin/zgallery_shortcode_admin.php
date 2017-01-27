<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<div id="my-gallery-content-id" style="display:none;">
	<div class="fluid-layout responsive">
		<div style="padding:0 15px;">
			<h3 class="gallery-shortcode-label"><?php _e("Insert Gallery Shortcode", fma-gallery-z); ?></h3>
		</div>
		<div class="layout-span12" style="padding:15px 15px 0 0;">
			<table border="0" width="100%">
				<tr>
					<td><?php _e("Select Gallery", fma-gallery-z); ?> : </td>
					<td>
					<select id="add_album_id" class="layout-span9">
						<option value=""> <?php _e("Select Gallery", fma-gallery-z); ?>  </option>
						<?php
					   global $wpdb,$current_user;
						$albums = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."zgallery order by gallery_id desc");
						for ($flag = 0; $flag < count($albums); $flag++) {
							?>
							<option value="<?php echo intval($albums[$flag]->gallery_id); ?>"><?php echo esc_html($albums[$flag]->gallery_name) ?></option>
						<?php
						}
						?>
					</select>
					</td>
				</tr>
				<tr>
					<td><?php _e("Gallery Format", fma-gallery-z); ?> : </td>
					<td>
						<select id="ux_gallery_format" class="layout-span9">
							<option value=""> <?php _e("Select Gallery Format ", fma-gallery-z); ?>  </option>
							<option value="masonry">Masonry Style Gallery</option>
							<option value="thumbnail">Thumbnail Style Gallery</option>
						</select>
					</td>
				</tr>
				<tr>
					<td><?php _e("Text Format", fma-gallery-z); ?> : </td>
					<td>
						<select id="ux_text_format" class="layout-span9">
							<option value=""><?php _e("Select Format ", fma-gallery-z); ?></option>
							<option value="title_only">With Title only</option>
							<option value="title_desc">With Title and Description</option>
							<option value="no_text">Without Title and Description</option>
						</select>
					</td>
				</tr>
				<tr>
					<td><?php _e("Show Gallery Title", fma-gallery-z); ?> : </td>
					<td><input type="checkbox" checked="checked" name="ux_album_title" id="ux_album_title"/></td>
				</tr>
				<tr>
					<td><input type="button" class="button-primary" value="<?php _e("Insert Code", fma-gallery-z); ?>"
			           onclick="InsertGallery();"/>
					</td>
					<td><a class="button" style="color:#bbb;" href="#"
			       onclick="tb_remove(); return false;"><?php _e("Cancel", fma-gallery-z); ?></a></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
				</tr>
			</table>			
		</div>
	</div>
</div>
<script type="text/javascript">
jQuery(document).ready(function () {
    check_gallery_type();
    select_images_in_row();
    effects_settings();
    show_special_effect();
    show_images_in_row();
});
function show_images_in_row()
{
	var responsive = jQuery("#ux_responsive_gallery").prop("checked");
	var gallery_format = jQuery("#ux_gallery_format").val();
	if(responsive == true && (gallery_format == "thumbnail" || gallery_format == "masonry" || gallery_format == "slideshow" ))
	{
		jQuery("#div_img_in_row").css("display","none");
	}
	else if(gallery_format != "blog" && gallery_format != "slideshow")
	{
		jQuery("#div_img_in_row").css("display","block");
	}
}
function select_images_in_row() {
    var gallery_format = jQuery("#ux_gallery_format").val();
    switch(gallery_format)
    {
    	case "thumbnail":
	    	jQuery("#div_img_in_row").css("display", "block");
	        jQuery("#gb_gallery_format").css("display", "block");
	        jQuery("#div_img_width").css("display", "none");
	        jQuery("#div_special_effects").css("display", "block");
	        jQuery("#div_animation_effects").css("display", "block");
	        jQuery("#option_cornor_ribbons").css("display", "block");
	        jQuery("#option_hover_rotation").css("display", "block");
	        jQuery("#option_levitation_shadow").css("display", "block");
	        jQuery("#option_lomo_effect").css("display", "block");
	        jQuery("#option_overlay_fade").css("display", "block");
	        jQuery("#option_overlay_join").css("display", "block");
	        jQuery("#option_overlay_slide").css("display", "block");
	        jQuery("#option_overlay_split").css("display", "block");
	        jQuery("#option_perspective_images").css("display", "block");
	        jQuery("#option_rounded_images").css("display", "block");
	        jQuery("#option_pulse").css("display", "block");
	    break;
	    case "filmstrip":
	    	jQuery("#div_img_in_row").css("display", "block");
	        jQuery("#gb_gallery_format").css("display", "block");
	        jQuery("#div_img_width").css("display", "block");
	        jQuery("#div_special_effects").css("display", "none");
	        jQuery("#div_animation_effects").css("display", "block");
	    break;
	    case "masonry":
	    	jQuery("#div_img_in_row").css("display", "block");
	        jQuery("#gb_gallery_format").css("display", "block");
	        jQuery("#div_img_width").css("display", "none");
	        jQuery("#div_special_effects").css("display", "block");
	        jQuery("#div_animation_effects").css("display", "block");
	        jQuery("#ux_special_effects").val("grayscale");
	        jQuery("#option_cornor_ribbons").css("display", "none");
	        jQuery("#option_hover_rotation").css("display", "none");
	        jQuery("#option_levitation_shadow").css("display", "none");
	        jQuery("#option_lomo_effect").css("display", "none");
	        jQuery("#option_overlay_fade").css("display", "none");
	        jQuery("#option_overlay_join").css("display", "none");
	        jQuery("#option_overlay_slide").css("display", "none");
	        jQuery("#option_overlay_split").css("display", "none");
	        jQuery("#option_perspective_images").css("display", "none");
	        jQuery("#option_rounded_images").css("display", "none");
	        jQuery("#option_pulse").css("display", "none");
	    break;
	    case "slideshow":
	    	jQuery("#gb_gallery_format").css("display", "block");
	        jQuery("#div_img_in_row").css("display", "none");
	        jQuery("#div_img_width").css("display", "none");
	        jQuery("#div_special_effects").css("display", "none");
	        jQuery("#div_animation_effects").css("display", "none");
	    break;
	    case "blog":
	    	jQuery("#gb_gallery_format").css("display", "block");
	        jQuery("#div_img_in_row").css("display", "none");
	        jQuery("#div_img_width").css("display", "none");
	        jQuery("#div_special_effects").css("display", "block");
	        jQuery("#div_animation_effects").css("display", "block");
	        jQuery("#ux_special_effects").val("grayscale");
	        jQuery("#option_cornor_ribbons").css("display", "none");
	        jQuery("#option_hover_rotation").css("display", "none");
	        jQuery("#option_levitation_shadow").css("display", "none");
	        jQuery("#option_lomo_effect").css("display", "none");
	        jQuery("#option_overlay_fade").css("display", "none");
	        jQuery("#option_overlay_join").css("display", "none");
	        jQuery("#option_overlay_slide").css("display", "none");
	        jQuery("#option_overlay_split").css("display", "none");
	        jQuery("#option_perspective_images").css("display", "none");
	        jQuery("#option_rounded_images").css("display", "none");
	        jQuery("#option_pulse").css("display", "none");
	    break;
	    default:
	    	jQuery("#gb_gallery_format").css("display", "block");
	        jQuery("#div_img_in_row").css("display", "none");
	        jQuery("#div_img_width").css("display", "none");
	        jQuery("#div_special_effects").css("display", "block");
	        jQuery("#div_animation_effects").css("display", "block");
	        jQuery("#option_cornor_ribbons").css("display", "block");
	        jQuery("#option_hover_rotation").css("display", "block");
	        jQuery("#option_levitation_shadow").css("display", "block");
	        jQuery("#option_lomo_effect").css("display", "block");
	        jQuery("#option_overlay_fade").css("display", "block");
	        jQuery("#option_overlay_join").css("display", "block");
	        jQuery("#option_overlay_slide").css("display", "block");
	        jQuery("#option_overlay_split").css("display", "block");
	        jQuery("#option_perspective_images").css("display", "block");
	        jQuery("#option_rounded_images").css("display", "block");
	        jQuery("#option_pulse").css("display", "block");
	    break;
    }
    show_images_in_row();
}
function effects_settings() {
    var special_effects = jQuery("#ux_special_effects").val();
    switch (special_effects) {
        case "hover_rotation":
            jQuery("#rotation_setting").css("display", "block");
            jQuery("#overlay_color").css("display", "none");
            jQuery("#overlay_color_with_direction").css("display", "none");
            jQuery("#ribbon_color_with_direction").css("display", "none");
            jQuery("#levitation_shadow_div").css("display", "none");
            jQuery("#lomo_effect_div").css("display", "none");
            jQuery("#rounded_images_div").css("display", "none");
            break;
        case "overlay_fade":
            jQuery("#rotation_setting").css("display", "none");
            jQuery("#overlay_color").css("display", "block");
            jQuery("#overlay_color_with_direction").css("display", "none");
            jQuery("#ribbon_color_with_direction").css("display", "none");
            jQuery("#levitation_shadow_div").css("display", "none");
            jQuery("#lomo_effect_div").css("display", "none");
            jQuery("#rounded_images_div").css("display", "none");
            break;
        case "overlay_slide":
            jQuery("#rotation_setting").css("display", "none");
            jQuery("#overlay_color").css("display", "block");
            jQuery("#overlay_color_with_direction").css("display", "none");
            jQuery("#ribbon_color_with_direction").css("display", "none");
            jQuery("#levitation_shadow_div").css("display", "none");
            jQuery("#lomo_effect_div").css("display", "none");
            jQuery("#rounded_images_div").css("display", "none");
            break;
        case "overlay_split":
            jQuery("#rotation_setting").css("display", "none");
            jQuery("#overlay_color").css("display", "none");
            jQuery("#overlay_color_with_direction").css("display", "block");
            jQuery("#ribbon_color_with_direction").css("display", "none");
            jQuery("#levitation_shadow_div").css("display", "none");
            jQuery("#lomo_effect_div").css("display", "none");
            jQuery("#rounded_images_div").css("display", "none");
            break;
        case "overlay_join":
            jQuery("#rotation_setting").css("display", "none");
            jQuery("#overlay_color").css("display", "none");
            jQuery("#overlay_color_with_direction").css("display", "block");
            jQuery("#ribbon_color_with_direction").css("display", "none");
            jQuery("#levitation_shadow_div").css("display", "none");
            jQuery("#lomo_effect_div").css("display", "none");
            jQuery("#rounded_images_div").css("display", "none");
            break;
        case "corner_ribbons":
            jQuery("#rotation_setting").css("display", "none");
            jQuery("#overlay_color").css("display", "none");
            jQuery("#overlay_color_with_direction").css("display", "none");
            jQuery("#ribbon_color_with_direction").css("display", "block");
            jQuery("#levitation_shadow_div").css("display", "none");
            jQuery("#lomo_effect_div").css("display", "none");
            jQuery("#rounded_images_div").css("display", "none");
            break;
        case "levitation_shadow":
            jQuery("#rotation_setting").css("display", "none");
            jQuery("#overlay_color").css("display", "none");
            jQuery("#overlay_color_with_direction").css("display", "none");
            jQuery("#ribbon_color_with_direction").css("display", "none");
            jQuery("#levitation_shadow_div").css("display", "block");
            jQuery("#lomo_effect_div").css("display", "none");
            jQuery("#rounded_images_div").css("display", "none");
            break;
        case "lomo_effect":
            jQuery("#rotation_setting").css("display", "none");
            jQuery("#overlay_color").css("display", "none");
            jQuery("#overlay_color_with_direction").css("display", "none");
            jQuery("#ribbon_color_with_direction").css("display", "none");
            jQuery("#levitation_shadow_div").css("display", "none");
            jQuery("#lomo_effect_div").css("display", "block");
            jQuery("#rounded_images_div").css("display", "none");
            break;
        case "rounded_images":
            jQuery("#rotation_setting").css("display", "none");
            jQuery("#overlay_color").css("display", "none");
            jQuery("#overlay_color_with_direction").css("display", "none");
            jQuery("#ribbon_color_with_direction").css("display", "none");
            jQuery("#levitation_shadow_div").css("display", "none");
            jQuery("#lomo_effect_div").css("display", "none");
            jQuery("#rounded_images_div").css("display", "block");
            break;
        case "perspective_images":
            jQuery("#rotation_setting").css("display", "block");
            jQuery("#overlay_color").css("display", "none");
            jQuery("#overlay_color_with_direction").css("display", "none");
            jQuery("#ribbon_color_with_direction").css("display", "none");
            jQuery("#levitation_shadow_div").css("display", "none");
            jQuery("#lomo_effect_div").css("display", "none");
            jQuery("#rounded_images_div").css("display", "none");
            break;
        default:
            jQuery("#rotation_setting").css("display", "none");
            jQuery("#overlay_color").css("display", "none");
            jQuery("#overlay_color_with_direction").css("display", "none");
            jQuery("#ribbon_color_with_direction").css("display", "none");
            jQuery("#levitation_shadow_div").css("display", "none");
            jQuery("#lomo_effect_div").css("display", "none");
            jQuery("#rounded_images_div").css("display", "none");
            break;
    }
}
function show_special_effect() {
    var text_format = jQuery("#ux_text_format").val();
    var gallery_format = jQuery("#ux_gallery_format").val();
    if (text_format == "no_text" && (gallery_format != "slideshow" && gallery_format != "filmstrip" )) {
        jQuery("#div_special_effects").css("display", "block");
        effects_settings();
    }
    else if(gallery_format == "blog")
    {
    	jQuery("#div_special_effects").css("display", "block");
    }
    else {
        jQuery("#div_special_effects").css("display", "none");
        jQuery("#rotation_setting").css("display", "none");
        jQuery("#overlay_color").css("display", "none");
        jQuery("#overlay_color_with_direction").css("display", "none");
        jQuery("#ribbon_color_with_direction").css("display", "none");
        jQuery("#levitation_shadow_div").css("display", "none");
        jQuery("#lomo_effect_div").css("display", "none");
        jQuery("#rounded_images_div").css("display", "none");
    }
}
function check_gallery_type() {
    var gallery_type = jQuery("input:radio[name=ux_gallery]:checked").val();
    var album_format = jQuery("#ux_album_format").val();
    if (gallery_type == 0) {
        jQuery("#album_format").css("display", "none");
        jQuery("#div_albums_in_row").css("display", "none");
        jQuery("#ux_select_album").css("display", "block");
        jQuery("#slide_show").css("display", "none");
    }
    else {
        jQuery("#album_format").css("display", "block");
        if (album_format != "individual") {
            jQuery("#ux_select_album").css("display", "block");
            if (album_format == "grid") {
                jQuery("#div_albums_in_row").css("display", "block");
                jQuery("#slide_show").css("display", "block");
            }
            else {
                jQuery("#div_albums_in_row").css("display", "none");
                jQuery("#slide_show").css("display", "block");
            }
        }
        else {
            jQuery("#div_albums_in_row").css("display", "none");
            jQuery("#slide_show").css("display", "block");
        }
    }
}
function select_album() {
    var album_format = jQuery("#ux_album_format").val();
    if (album_format == "individual") {
        jQuery("#ux_select_album").css("display", "block");
    }
    else {
        jQuery("#ux_select_album").css("display", "block");
    }
}
function InsertGallery() {
    var gallery_effect;
    var album_id = jQuery("#add_album_id").val();
    var album_format = jQuery("#ux_album_format").val();
    var gallery_format = jQuery("#ux_gallery_format").val();
    var text_format = jQuery("#ux_text_format").val();
    var images_in_row = jQuery("#ux_img_in_row").val();
    var album_in_row = jQuery("#ux_album_in_row").val();
    var filmstrip_width = jQuery("#ux_img_width").val();
    var gallery_type = jQuery("input:radio[name=ux_gallery]:checked").val();

    var special_effect = jQuery("#ux_special_effects").val();
    var rotation = jQuery("#ux_rotation").val();
    var overlay_color = jQuery("#ux_overlay_color").val();
    var overlay_color_with_dir = jQuery("#ux_overlay_color_with_dir").val();
    var overlay_dir = jQuery("#ux_overlay_dir").val();
    var ribbon_color = jQuery("#ux_ribbon_color").val();
    var ribbon_dir = jQuery("#ux_ribbon_dir").val();
    var shadow = jQuery("#ux_shadow").val();
    var lomo_color = jQuery("#ux_lomo_color").val();
    var lomo_dir = jQuery("#ux_lomo_dir").val();
    var rounded_images = jQuery("#ux_rounded_images").val();
    var animation_effects = jQuery("#ux_animation_effects").val();
    var displayAlbumTitle = jQuery("#ux_album_title").prop("checked");
    var responsiveGallery = jQuery("#ux_responsive_gallery").prop("checked");
    var responsive;

    if (album_id == "" && (album_format == "individual" || gallery_type == 0)) {
        alert("<?php _e("Please select an Album", gallery_zplus) ?>");
        return;
    }
    else if (gallery_type == 1 && album_format == "") {
        alert("<?php _e("Please select an Album Format", gallery_zplus) ?>");
        return;
    }
    else if (gallery_format == "") {
        alert("<?php _e("Please select a Gallery Images Format", gallery_zplus) ?>");
        return;
    }
    else if (text_format == "" && gallery_format != "slideshow") {
        alert("<?php _e("Please select a Text Format for the Gallery", gallery_zplus) ?>");
        return;
    }
    else if (gallery_format == "slideshow" || gallery_format == "filmstrip" || gallery_format == "blog") {
        alert("This Feature is only available in Paid Premium Version!");
        return;
    }
	
	if(responsiveGallery == true)
	{
		responsive = "responsive=\""+ responsiveGallery+"\"";
	}
	else
	{
		responsive = "img_in_row=\""+ images_in_row+"\"";
	}
	
    if (gallery_type == 1) {
        if (album_format == "individual") {
            if (gallery_format == "thumbnail" || gallery_format == "masonry") {
                if (text_format == "title_only") {
                    window.send_to_editor("[gallery_zplus format=\"" + gallery_format + "\" title=\"true\" desc=\"false\" "+responsive+" animation_effect=\"\" gallery_title=\"" + displayAlbumTitle + "\" album_id=\"" + album_id + "\"]");
                }
                else if (text_format == "title_desc") {
                    window.send_to_editor("[gallery_zplus format=\"" + gallery_format + "\" title=\"true\" desc=\"true\" "+responsive+" animation_effect=\"\" gallery_title=\"" + displayAlbumTitle + "\" album_id=\"" + album_id + "\"]");
                }
                else if (text_format == "no_text") {
                    window.send_to_editor("[gallery_zplus format=\"" + gallery_format + "\" title=\"false\" desc=\"false\" "+responsive+" special_effect=\"\" animation_effect=\"\" gallery_title=\"" + displayAlbumTitle + "\" album_id=\"" + album_id + "\"]");
                }
            }
        }
        else if (album_format == "grid") {
            if (gallery_format == "thumbnail" || gallery_format == "masonry") {
                if (text_format == "title_only") {
                    window.send_to_editor("[gallery_zplus format=\"" + gallery_format + "\" title=\"true\" desc=\"false\" "+responsive+" albums_in_row=\"" + album_in_row + "\" animation_effect=\"\" gallery_title=\"" + displayAlbumTitle + "\"]");
                }
                else if (text_format == "title_desc") {
                    window.send_to_editor("[gallery_zplus format=\"" + gallery_format + "\" title=\"true\" desc=\"true\" "+responsive+" albums_in_row=\"" + album_in_row + "\" animation_effect=\"\" gallery_title=\"" + displayAlbumTitle + "\"]");
                }
                else if (text_format == "no_text") {
                    window.send_to_editor("[gallery_zplus format=\"" + gallery_format + "\" title=\"false\" desc=\"false\" "+responsive+" albums_in_row=\"" + album_in_row + "\" special_effect=\"\" animation_effect=\"\" gallery_title=\"" + displayAlbumTitle + "\"]");
                }
            }
        }
        else {
            if (gallery_format == "thumbnail" || gallery_format == "masonry") {
                if (text_format == "title_only") {
                    window.send_to_editor("[gallery_zplus format=\"" + gallery_format + "\" title=\"true\" desc=\"false\" gallery_title=\"" + displayAlbumTitle + "\"]");
                }
                else if (text_format == "title_desc") {
                    window.send_to_editor("[gallery_zplus format=\"" + gallery_format + "\" title=\"true\" desc=\"true\" gallery_title=\"" + displayAlbumTitle + "\"]");
                }
                else if (text_format == "no_text") {
                    window.send_to_editor("[gallery_zplus format=\"" + gallery_format + "\" title=\"false\" desc=\"false\" gallery_title=\"" + displayAlbumTitle + "\"]");
                }
            }
        }
    }
    else {
        if (gallery_format == "thumbnail" || gallery_format == "masonry") {
            if (text_format == "title_only") {
                window.send_to_editor("[gallery_zplus format=\"" + gallery_format + "\" title=\"true\" desc=\"false\" gallery_title=\"" + displayAlbumTitle + "\" album_id=\"" + album_id + "\"]");
            }
            else if (text_format == "title_desc") {
                window.send_to_editor("[gallery_zplus format=\"" + gallery_format + "\" title=\"true\" desc=\"true\" gallery_title=\"" + displayAlbumTitle + "\" album_id=\"" + album_id + "\"]");
            }
            else if (text_format == "no_text") {
                window.send_to_editor("[gallery_zplus format=\"" + gallery_format + "\" title=\"false\" desc=\"false\" gallery_title=\"" + displayAlbumTitle + "\" album_id=\"" + album_id + "\"]");
            }
        }
    }
}
/**
 * @return {boolean}
 */
function OnlyNumbers(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode;
    return (charCode > 47 && charCode < 58) || charCode == 127 || charCode == 8;
}
function set_text_value(text_type) {
    var val = "";
    switch (text_type) {
        case "img_in_row":
            val = jQuery("#ux_img_in_row").val();
            if (val < 1)
                jQuery("#ux_img_in_row").val(1);


            break;
        case  "album_in_row":
            val = jQuery("#ux_album_in_row").val();
            if (val < 1)
                jQuery("#ux_album_in_row").val(1);
            break;
    }
}
</script>
<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 
$zgallery_images = $wpdb->prefix . "zgallery_images";
$pics = $wpdb->get_results
			(
					"SELECT * FROM " . $zgallery_images . " WHERE gallery_id = ". $album_id ." order by image_id desc "
			);

?>
<style type="text/css">
		.width_thumb
		{
			width:<?php echo $zsettings['thumbnail_width']+1;?>px !important;
			border-radius:0px !important;
	        display: block !important;
	        box-sizing: border-box !important;
            max-width: 100% !important;
		}
	.gallery-sizer { width:<?php echo $zsettings['thumbnail_width'] + 10;?>px !important; }

	@media screen and (min-width: 720px) {
		.gallery-sizer { width:<?php echo $zsettings['thumbnail_width'] + 10;?>px !important; } 
	}
</style>
<div  class="<?php echo $class_images_in_row;?>" id="masonry-gallery-thumbnails_<?php echo $unique_id;?>" >
<?php
	$css_class = "width_thumb";
	for($flag = 0; $flag< count($pics); $flag++) 
	{
        $image_title = $image_title_setting == 1 && $pics[$flag]->image_alt != "" ? "<h5>" . esc_attr(html_entity_decode(stripcslashes(htmlspecialchars($pics[$flag]->image_alt)))). "</h5>" : "";
        $image_description = $image_desc_setting == 1 && $pics[$flag]->image_description != ""  ? "<p>" . esc_attr(html_entity_decode(stripcslashes(htmlspecialchars($pics[$flag]->image_description)))) ."</p>" : "";
				?>
				<a rel="prettyPhoto[gallery]" class="element gallery-sizer" href="<?php echo stripcslashes($pics[$flag]->image_path); ?>" data-title="<?php echo $image_title.$image_description;?>" id="ux_img_div_<?php echo $unique_id;?>">
				<?php
		if($img_title == "true" || $img_desc == "true")
		{
			?>
			<div class="widget_margin_thumbs<?php echo $unique_id;?> opactiy_thumbs margin_thumbs dynamic_css gb_overlay">
				<div class= "overlay_text">
					<h5><?php echo stripcslashes(htmlspecialchars_decode($pics[$flag]->title));?></h5>
					<?php
					if($img_desc == "true")
					{
						?>
						<p>
							<?php
							$string = stripcslashes(htmlspecialchars_decode($pics[$flag]->description));
							$description = (strlen($string) > $thumbnail_desc_length) ? substr($string,0,$thumbnail_desc_length)."..." : $string;
							echo $description;
							?>
						</p>
						<?php
					}
					?>
				</div>
						<img class="<?php echo $css_class;?>" id="ux_gb_img_<?php echo $unique_id;?>"
						imageid="<?php echo $pics[$flag]->pic_id;?>"
                           type="image" src="<?php echo stripcslashes($pics[$flag]->image_path);?>"/>
			</div>
		<?php
		}
		else
		{
			?>
			<div class="margin_thumbs dynamic_css opactiy_thumbs widget_margin_thumbs<?php echo $unique_id;?>" >
					<img class="<?php echo $css_class;?>" id="ux_gb_img_<?php echo $unique_id;?>"
					imageid="<?php echo $pics[$flag]->image_id;?>"
                      type="image" src="<?php echo stripcslashes($pics[$flag]->image_path);?>"/>
			</div>
			<?php
		}
		?>
		</a>
	<?php	
	}
?>
</div>
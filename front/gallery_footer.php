        <?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
        <div class="separator-doubled"></div>
		<script type="text/javascript">

	        <?php
	        switch($gallery_type)
	        {
	            case "masonry":
					?>
					var $container1_<?php echo $unique_id;?> = jQuery("#masonry-gallery-thumbnails_<?php echo $unique_id;?>");
			        $container1_<?php echo $unique_id;?>.imagesLoaded( function() {
			            $container1_<?php echo $unique_id;?>.isotope({
			                itemSelector: ".element",
			                layoutMode : "masonry",
			                itemPositionDataEnabled: true,
			                resizable: false,
			                resizesContainer: true,
			                isAnimated: true,
			                animationOptions: {
			                    duration: 750,
			                    easing: "linear",
			                    queue: false
			                },
			                masonry : {
			                	columnWidth: ".gallery-sizer"
			                }
			            });
			        });
			        jQuery(window).smartresize(function(){
					  $container1_<?php echo $unique_id;?>.isotope({
					    // update columnWidth to a percentage of container width
					    masonry: { columnWidth: ".gallery-sizer" }
					  });
					});
					<?php
				break;
				case "thumbnail":
				    ?>
				        jQuery(function () {
				            jQuery(".imgLiquidFill").imgLiquid({fill: true});
				        });
				        <?php
				break;
			}
			?>
		</script>
		<script type="text/javascript">
			jQuery(document).ready(function () {
				jQuery("a[rel^=\"prettyPhoto\"]").prettyPhoto
				({
					animation_speed: 'normal', 
					slideshow: 5000,
					autoplay_slideshow: false,
					opacity: 0.80,
					show_title: true,
					allow_resize: true
				});
			});
		</script>
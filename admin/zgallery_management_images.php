<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
   		global $wpdb;
   		$query = "SELECT * FROM ".$wpdb->prefix."zgallery order by gallery_name asc";
		$galleries_list = $wpdb->get_results( $query, ARRAY_A );
   		$table_name = $wpdb->prefix . "zgallery_images";

   		if(isset($_POST['submit']) && $_POST['submit']!= '') {

	   		if ( !current_user_can( apply_filters( 'fma_gallery_z_capability', 'manage_options' ) ) )
	            die( '-1' );
	    
	        check_admin_referer( 'fma_gallery_z_nonce_action', 'fma_gallery_z_nonce_field' );

	        $gallery_id = intval($_POST['gallery_id']);
	        
	        foreach($_POST['imagefile'] as $key => $value) {

	        	$res2 = $wpdb->query("INSERT INTO ".$table_name." set image_path = '".sanitize_text_field($value)."', gallery_id = '".$gallery_id."'");
	        } ?>
	        <div class="updated below-h2" id="update_album_success_message" style="display:block;"><p>Pictures Uploaded.</p></div>
    	<?php }
		
		
?>

<div class="wrap">
	<form action="" id="edit_album" method="post" class="layout-form">
	<?php wp_nonce_field('fma_gallery_z_nonce_action','fma_gallery_z_nonce_field'); ?>
	<h2>Add Gallery Images</h2>
	
	
	
	<div class="gallery_images">
		<div class="gallery_images_text"><b>Select Gallery:</b></div>
		<div class="gallery_images_text2">
			<select name="gallery_id" id="gallery_id">
				<option value="">Select Gallery</option>
				<?php foreach($galleries_list as $_galleries_list){ ?>
				<option value="<?php echo $_galleries_list['gallery_id']?>"><?php echo $_galleries_list['gallery_name']?></option>
				<?php } ?>
			</select>
		</div>
	</div>

	<div class="gallery_images">
		<div class="gallery_images_text"><b>Gallery Image:</b></div>
		<div class="gallery_images_text2">
			<div class="gallery_images_text3">
				<input type="text" style="width:65.5%" name="imagefile[]" id="new_image" value="">
        		<a class="button" onclick="upload_image('new_image');">Choose Image</a>
        		<input type="button" class="btt2 button button-primary button-large" value="+ Add More Images" onClick="addImage();">
			</div>
			<div class="topfilters" id="beforetf"></div>
		</div>
	</div>

	<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary button-large" value="Submit"></p>	

	
	</form>
</div>

<script type="text/javascript">

	var filter_row_rule = 1;

	function addImage() {

		html = '';
		html += '<div class="gallery_images_text3" id="filter-row-rule' + filter_row_rule + '">';
			html += '<input type="text" style="width:65.5%" name="imagefile[]" id="'+ filter_row_rule +'" value="">';
			html += '<a class="button" onclick="upload_image('+filter_row_rule+');">Choose Image</a>';
			html += '<input style="margin-left:5px;" type="button" class="btt2 button button-primary button-large" value="+ Add More Images" onClick="addImage();">';
			html += '<a onclick="jQuery(\'#filter-row-rule' + filter_row_rule + '\').remove();" class="button button-danger button-large"><?php _e("Remove Image","gallery-zplus"); ?></a>'
		html += '</div>';

		jQuery('#beforetf').before(html);
	
		filter_row_rule++;

	}




	var uploader;
	function upload_image(id) {

	  //Extend the wp.media object
	  uploader = wp.media.frames.file_frame = wp.media({
	    title: 'Choose Image',
	    button: {
	      text: 'Choose Image'
	    },
	    multiple: false
	  });

	  //When a file is selected, grab the URL and set it as the text field's value
	  uploader.on('select', function() {
	    attachment = uploader.state().get('selection').first().toJSON();
	    var url = attachment['url'];
	    jQuery('#'+id).val(url);
	  });

	  //Open the uploader dialog
	  uploader.open();
	}
</script>
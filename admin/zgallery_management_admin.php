<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<script type="text/javascript">
    function conf(str) {
       if(confirm("Are you sure you want delete") == true){ location.replace(str);}
    }
	function deleteImage(control) {
		var r = confirm("<?php _e("Are you sure you want to delete this Image?", fma-gallery-z)?>");
		if (r == true) {
			location.replace(control);
		}
	}
</script>
<div class="wrap">
<?php if(!isset($_GET['add']) && $_GET['add']!= 1){ ?>
	<h2>Manage Galleries <a href="admin.php?page=zgallery_manage_galleries&add=1" class="add-new-h2">Add New</a></h2>
	<form action="" method="post">
	<p class="search-box">
		<label class="screen-reader-text" for="user-search-input">Search:</label>
		<input type="search" id="user-search-input" name="s" value="">
		<input type="submit" name="" id="search-submit" class="button button-primary button-large" value="Search"></p>
	</form> 
<?php }else{ 
		if(isset($_GET['gallery_id']) && $_GET['gallery_id']!= ''){?>	
		<h2>Edit Galley</h2>
		<?php }else{ ?>
		<h2>Add Galley</h2>
		<?php } ?>
<?php } ?>

<?php 
	
	

	global $wpdb;
	$title = 'Gallery';
	$action = "admin.php?page=zgallery_manage_galleries";
	
	$table_name = $wpdb->prefix . "zgallery";
	$table_name_images = $wpdb->prefix . "zgallery_images";
	$field_name = 'gallery_name';
	
	if(isset($_POST['check_sub']) && $_POST['check_sub'] == 1){
		$name = sanitize_text_field($_POST['name']);
		if(trim($name) == ''){
			echo '<div class="error below-h2"><p>Please enter gallery name</p></div>';	
		}else{
			global $wpdb;
			$update_gallery_id = '';
			if($_POST['gallery_id'] != '')
				$update_gallery_id = ' and gallery_id != '.intval($_POST['gallery_id']);
			
			$query_gallery = "SELECT * FROM ".$table_name." where ".$field_name." = '".$name."'".$update_gallery_id;
			$galleries_list = $wpdb->get_results( $query_gallery, ARRAY_A );
			
			if($galleries_list[0]['gallery_id'] != ''){
				echo '<div class="error below-h2"><p>Gallery name already exists</p></div>';
			}else{
				 if($_POST['gallery_id'] != ''){
				 	if ( !current_user_can( apply_filters( 'fmagalleryz_capability', 'manage_options' ) ) )
					die( '-1' );
			
				check_admin_referer( 'fmagalleryz_nonce_action', 'fmagalleryz_nonce_field' );
					 $res = $wpdb->query("update ".$table_name." set ".$field_name." = '".addslashes(strip_tags($name))."' where gallery_id = '".intval($_POST['gallery_id'])."'");
					 $pre = ' updated';
					 /*Images Update*/
						if(isset($_POST['image_id']) && !empty($_POST['image_id'])){
							$image_counts = count(intval($_POST['image_id']));
							
							$image_id = intval($_POST['image_id']);
							$image_alt = sanitize_text_field($_POST['image_alt']);
							$image_description = sanitize_text_field($_POST['image_description']);
							$exclude = sanitize_text_field($_POST['exclude']);
							if(isset($_POST['sort_order']) && $_POST['sort_order']!='') {
								$sort_order = intval($_POST['sort_order']);
							} else {
								$sort_order = 0;
							}
							$image_tags = sanitize_text_field($_POST['image_tags']);
							
							for($i=0;$i<$image_counts;$i++){
								$excludeVal = 0;
								if(!empty($exclude[$i]))
									$excludeVal = 1;
								
								$wpdb->query("UPDATE $table_name_images SET image_alt='$image_alt[$i]', image_description='$image_description[$i]', image_tags='$image_tags[$i]', exclude=$excludeVal, sort_order='$sort_order[$i]' WHERE image_id='$image_id[$i]'");
							}
						}
					/*Images Update*/
				 }else{
				 	if ( !current_user_can( apply_filters( 'fmagalleryz_capability', 'manage_options' ) ) )
						die( '-1' );
				
					check_admin_referer( 'fmagalleryz_nonce_action', 'fmagalleryz_nonce_field' );
				 	$res = $wpdb->query("insert into ".$table_name." set ".$field_name." = '".addslashes(strip_tags($name))."'");
					$pre = ' added';
				 }
				 echo '<div class="updated below-h2"><p>'.$title. $pre.' succesfully</p></div>';
			}
		}
	}
	
	if(isset($_GET['gallery_id']) && $_GET['gallery_id'] != ''){
		global $wpdb;
		$query_chk = "SELECT * FROM ".$table_name." where gallery_id = '".intval($_GET['gallery_id'])."'";
		$query_chk_list = $wpdb->get_results( $query_chk, ARRAY_A );
		$name = $query_chk_list[0][$field_name];
		
		$editaction = '&gallery_id='.intval($_GET['gallery_id']);	
		$btn = 'Update';
		$action = "admin.php?page=zgallery_manage_galleries&add=1".$editaction;
	}
	
	if($_GET['del_id'] != ''){
		global $wpdb;
		$res = $wpdb->query("delete from ".$table_name."  where gallery_id = '".intval($_GET['del_id'])."'");
		echo '<p style="color:green">Deleted Successfully</p>';
	}
	
	if(isset($_GET['del_img_id']) &&  $_GET['del_img_id']!= ''){
		global $wpdb;
		$res = $wpdb->query("delete from ".$table_name_images."  where image_id = '".intval($_GET['del_img_id'])."'");
		echo '<p style="color:green">Image deleted successfully</p>';
	}
		if($_GET['add'] == 1){
	?>
    <form action="<?php echo $action;?>" method="post">
    <?php wp_nonce_field('fmagalleryz_nonce_action','fmagalleryz_nonce_field'); ?>
    <table class="form-table">
<tbody><tr valign="top">
<th scope="row"><label for="mailserver_url"><?php echo $title?$title:''?> Name</label></th>
<td><input name="name" type="text" id="name" value="<?php echo $name?$name:''?>" class="regular-text code">
<input name="gallery_id" type="hidden" id="gallery_id" value="<?php echo $_GET['gallery_id']?>" class="regular-text code">
<input name="check_sub" type="hidden" id="check_sub" value="1" class="regular-text code">
</td>
</tr>
</tbody></table>

<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary button-large" value="<?php echo $btn?$btn:'Add'; ?> <?php echo $title?>"></p>

<?php 
/*BOF Loading Gallery Images*/
if(isset($_GET['gallery_id']) && $_GET['gallery_id'] != ''){
	$zgallery_images = $wpdb->prefix . "zgallery_images";
	$gallery_id = intval($_GET['gallery_id']);
	$pics = $wpdb->get_results
			(
					"SELECT * FROM " . $zgallery_images . " WHERE gallery_id = ". $gallery_id ." order by image_id desc "
			);
	if(!empty($pics)) {
?>

<table class="wp-list-table widefat fixed users" cellspacing="0">
	<thead>
		<tr>
			<th style="display:none;"></th>
			<th style="width:5%">ID</th>
			<th style="width:25%">Thumbnail</th>
			<th style="width:30%">Alt/Title & Description</th>
			<th style="width:20%">Tags</th>
			<th style="width:20%">Actions</th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<th style="display:none;"></th>
			<th style="width:5%">ID</th>
			<th style="width:25%">Thumbnail</th>
			<th style="width:30%">Alt/Title & Description</th>
			<th style="width:20%">Tags</th>
			<th style="width:20%">Actions</th>
		</tr>
	</tfoot>
	<tbody>
		<?php
		$f = 1;
		for ($flag = 0; $flag < count($pics); $flag++) {
			$class = 'alternate';
			if($f%2)
				$class='';
			?>
			<tr class="<?php echo $class; ?>">
					<td style="display:none;"><input type="text" value="<?php echo $pics[$flag]->image_id; ?>" name="image_id[]" /></td>
					<td><?php echo $flag+1; ?></td>
					<td>
						<img type="image" imgpath="<?php echo $pics[$flag]->image_path; ?>"
								src="<?php echo $pics[$flag]->image_path; ?>"
								id="ux_gb_img" imageid="<?php echo $pics[$flag]->image_id; ?>"
								name="ux_gb_img" class=" dynamic_css"
								width="150"/>
						<br/>
						<?php $dateFormat = date("F j, Y", strtotime($pics[$flag]->creation_date)); ?>
						<label><strong><?php echo $pics[$flag]->image_name; ?></strong></label><br/><label><?php echo $dateFormat; ?></label><br/>
					</td>
					<td>
						<input placeholder="<?php _e("Title", gallery_zplus) ?>" type="text" name="image_alt[]" value="<?php echo html_entity_decode(stripcslashes(htmlspecialchars($pics[$flag]->image_alt))); ?>"/>
						<textarea placeholder="<?php _e("Description ", gallery_zplus) ?>" style="margin-top:20px" rows="5" name="image_description[]"><?php echo html_entity_decode(stripcslashes(htmlspecialchars($pics[$flag]->image_description))); ?></textarea>
					</td>
					<td>
						<input placeholder="<?php _e("Comma seperated tags", gallery_zplus) ?>" type="text" name="image_tags[]" value="<?php echo $pics[$flag]->image_tags; ?>"/>
					</td>
					<td>
						<a class="btn hovertip" id="ux_btn_delete" style="cursor: pointer;" data-original-title="<?php _e("Delete Image", gallery_zplus) ?>" onclick="deleteImage('admin.php?page=zgallery_manage_galleries&add=1&gallery_id=<?php echo $pics[$flag]->gallery_id; ?>&del_img_id=<?php echo $pics[$flag]->image_id; ?>');">Delete</a><br /><br />
						<input type="checkbox" name="exclude[]" value="1" <?php if($pics[$flag]->exclude==1){ ?>checked="checked"<?php } ?> /> Exclude ? <br /><br />
						Sort Order&nbsp;&nbsp;<input size="6" type="text" name="sort_order[]" value="<?php echo $pics[$flag]->sort_order; ?>" placeholder="Sort Order" />
					</td>
			</tr>
		<?php
		$f++;
		}
	 ?>
	</tbody>
</table>
<?php				
	}
}
/*EOF Loading Gallery Images*/
?>	
</form>
<?php				
		}
	?>

<?php if(!isset($_GET['add']) && $_GET['add']!= 1){ ?>
   
   <?php
   		global $wpdb;
		$pagenum = isset( $_GET['paged'] ) ? absint( $_GET['paged'] ) : 0;
		if ( empty( $pagenum ) )
			$pagenum = 1;
	
		$per_page = (int) get_user_option( 'ms_users_per_page' );
		if ( empty( $per_page ) || $per_page < 1 )
			$per_page = 15;
	
		$per_page = apply_filters( 'ms_users_per_page', $per_page );

		if($_GET['orderby'] != '' && $_GET['order'] != ''){
			$orderby = 'order by '.$_GET['orderby'].' '.$_GET['order'];	
			if($_GET['order'] == 'asc'){
				$actionOrder = 'admin.php?page=zgallery_manage_galleries&orderby=gallery_name&amp;order=desc';
			}
			if($_GET['order'] == 'desc'){
				$actionOrder = 'admin.php?page=zgallery_manage_galleries&orderby=gallery_name&amp;order=asc';
			}
		}else{
			$orderby = 'order by gallery_id desc';	
			$actionOrder = 'admin.php?page=zgallery_manage_galleries&orderby=gallery_name&amp;order=asc';	
		}
		
		$where = '';
		if(trim($_POST['s']) != ''){
			$where = "where ".$field_name." like '%".$_POST['s']."%' ";
		}
		
		$query = "SELECT * FROM ".$wpdb->prefix."zgallery ".$where.$orderby;
		
		$total = $wpdb->get_var( str_replace( 'SELECT *', 'SELECT COUNT(gallery_id)', $query ) );

		$query .= " LIMIT " . intval( ( $pagenum - 1 ) * $per_page) . ", " . intval( $per_page );
	
		$galleries_list = $wpdb->get_results( $query, ARRAY_A );
		
		$num_pages = ceil( $total / $per_page );
		$page_links = paginate_links( array(
			'base' => add_query_arg( 'paged', '%#%' ),
			'format' => '',
			'end_size'     => 1,
			'mid_size'     => 9,
			'prev_text' => __( '&laquo;' ),
			'next_text' => __( '&raquo;' ),
			'total' => $num_pages,
			'current' => $pagenum
		));
   ?> 
   <?php if ( $page_links ) { ?>
      <div class="tablenav-pages">
        <?php $page_links_text = sprintf( '<span class="displaying-num">' . __( 'Displaying %s&#8211;%s of %s' ) . '</span>%s',
			number_format_i18n( ( $pagenum - 1 ) * $per_page + 1 ),
			number_format_i18n( min( $pagenum * $per_page, $total ) ),
			number_format_i18n( $total ),
			$page_links
			); echo $page_links_text; ?>
      </div>
      <?php } ?>
<table class="wp-list-table widefat fixed users" cellspacing="0">
	<thead>
	<tr>
        <th scope="col" id="galleryid" class="manage-column column-galleryid sortable desc" style="">
        <span style="padding: 10px;">ID</span>
        </th>
        <th scope="col" id="galleryname" class="manage-column column-galleryname sortable desc" style="">
        <a href="<?php echo $actionOrder?>"><span>Gallery Name</span><span class="sorting-indicator"></span></a>
        </th>
       <th scope="col" id="counter" class="manage-column column-counter sortable desc" style="">
        <span>Image Count</span>
        </th>
		<th scope="col" id="actions" class="manage-column column-counter" style="">
        <span>Actions</span>
        </th>
	</thead>

	<tfoot>
	<tr>
		<th scope="col" class="manage-column column-username sortable desc" style="">
        <span style="padding: 10px;">ID</span>
        </th>
        
        <th scope="col" class="manage-column column-name sortable desc" style="">
        <a href="<?php echo $actionOrder?>"><span>Gallery Name</span><span class="sorting-indicator"></span></a>
        </th>
         <th scope="col" id="name" class="manage-column column-name sortable desc" style="">
        <span>Image Count</span>
        </th>
        <th scope="col" id="actions" class="manage-column column-counter" style="">
        <span>Actions</span>
        </th>
        	</tr>
	</tfoot>

	<tbody id="the-list" data-wp-lists="list:user">
	<?php 
	if(!empty($galleries_list)){
		 $i= 1;
		foreach($galleries_list as $_galleries_list){
			
			wp_reset_query();
			$query_fruit = "SELECT count(*) as imgCnt FROM ".$wpdb->prefix . "zgallery_images where gallery_id = '".$_galleries_list['gallery_id']."'";
			$fruit_list = $wpdb->get_results( $query_fruit, ARRAY_A );
			$class = 'alternate';
			if($i%2)
				$class='';
	?>
	<tr id="user-<?php echo $_galleries_list['gallery_id']?>" class="<?php echo $class; ?>">
     <td class="username column-username">
   <strong><?php echo $_galleries_list['gallery_id']?></strong></td>
    <td class="username column-username">
   <strong><?php echo esc_attr($_galleries_list['gallery_name']); ?></strong></td>
     <td class="username column-username">
     <strong><?php echo $fruit_list[0]['imgCnt']?></strong>
     </td>
	<td class="username column-username">
 	<strong> <a href="admin.php?page=zgallery_manage_galleries&add=1&gallery_id=<?php echo $_galleries_list['gallery_id']?>">Edit</a></strong> | <strong><a href="#" onclick="conf('admin.php?page=zgallery_manage_galleries&del_id=<?php echo $_galleries_list['gallery_id']?>')" >
        Delete
    </a></strong>
	</td>
    </tr>	
    <?php $i++;}}else{ ?>
   <tr id="user-1" class="alternate"><td> No record found</td></tr>
    <?php }?>
    </tbody>
</table>

<?php } ?>
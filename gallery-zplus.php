<?php
/**
 * Plugin Name:       FMA Gallery Z
 * Plugin URI:        http://fmeaddons.com/
 * Description:       Download Wordpress Gallery Plugin for free, create video galleries and insert them into WordPress posts to improve engagement and revenue.
 * Version:           1.0.0
 * Author:            FME Addons
 * Developed By:      Hanan Ali, Raja Usman Mehmood
 * Author URI:        http://fmeaddons.com/
 * Support:           http://support.fmeaddons.com/
 * Text Domain:       fma-gallery-z
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if (!defined("FMA_GALLERY_FILE")) define("FMA_GALLERY_FILE",plugin_basename(__FILE__));
if (!defined("FMA_GALLERY_MAIN_PLUGIN_DIRNAME")) define("FMA_GALLERY_MAIN_PLUGIN_DIRNAME", plugin_basename(dirname(__FILE__)));
if (!defined("FMA_GALLERY_ZPLUS_PLUGIN_DIR")) define("FMA_GALLERY_ZPLUS_PLUGIN_DIR",  plugin_dir_path( __FILE__ ));
if (!defined("FMA_GALLERY_ZPLUS_PLUGIN_BASENAME")) define("FMA_GALLERY_ZPLUS_PLUGIN_BASENAME", plugin_basename(__FILE__));
if (!defined("gallery-zplus")) define("gallery-zplus", "gallery-zplus");

add_action( 'admin_enqueue_scripts', 'wp_enqueue_media' );




function fma_zgallery_settings() {
	include('admin/zgallery_settings_admin.php');
}

function fma_zgallery_manage_galleries() {
	include('admin/zgallery_management_admin.php');
}

function fma_zgallery_manage_images() {
	include('admin/zgallery_management_images.php');
}

if ( is_admin() ) {

    add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'fma_zgallery_supportlink' );
    add_filter( 'admin_footer_text', 'fma_zgallery_admin_footer_text', 1 );
    add_action('wp_ajax_fme_gallery_rated', 'fma_zgallery_rated'); 
}

    function fma_zgallery_supportlink( $actions ) {
            
        $custom_actions = array();

        // support url
        $custom_actions['support'] = sprintf( '<a href="%s" target="_blank">%s</a>', 'http://support.fmeaddons.com/', __( 'Support', 'fmepiw' ) );
        
        // add the links to the front of the actions list
        return array_merge( $custom_actions, $actions );
        
    }

     function fma_zgallery_admin_footer_text( $footer_text ) { 
            

        // Check to make sure we're on a WooCommerce admin page
        if ( apply_filters( 'wp_display_admin_footer_text', $footer_text ) ) {
            // Change the footer text
            if ( ! get_option( 'fme_gallery_rated_text' ) ) {
                $footer_text = sprintf( __( 'If you like <strong>Gallery Zplus</strong> please leave us a %s&#9733;&#9733;&#9733;&#9733;&#9733;%s rating. A huge thank you from FME Addons in advance!', 'gallery-zplus' ), '<a href="https://www.fmeaddons.com" target="_blank" class="wc-rating-link" data-rated="' . esc_attr__( 'Thanks :)', 'gallery-zplus' ) . '">', '</a>' );
                wc_enqueue_js( "
                    jQuery( 'a.wc-rating-link' ).click( function() { 
                        jQuery.post( '" . WC()->ajax_url() . "', { action: 'fma_zgallery_rated' } );
                        jQuery( this ).parent().text( jQuery( this ).data( 'rated' ) );
                    });
                " );
            } else {
                $footer_text = __( 'Thank you for buying with FME Addons', 'gallery-zplus' );
            }
        }

        return $footer_text;
    }


    function fma_zgallery_rated() {

        update_option( 'fme_gallery_rated_text', 1 );
    }



function fma_zgallery_admin_menu_actions() {  	
	add_menu_page('Gallery Zplus', 'Gallery Zplus', 'read', 'zgallery_settings','', '');
	add_submenu_page( 'zgallery_settings', 'Gallery Settings', 'Gallery Settings', 'read', 'zgallery_settings','fma_zgallery_settings','');
	add_submenu_page( 'zgallery_settings', 'Manage Galleries', 'Manage Galleries', 'read', 'zgallery_manage_galleries','fma_zgallery_manage_galleries','');
	add_submenu_page( 'zgallery_settings', 'Add Images', 'Add Images', 'read', 'zgallery_manage_images','fma_zgallery_manage_images','');

}

function fma_zgallery_admin_js_loads(){
    wp_enqueue_script("jquery");
    wp_enqueue_script("jquery-ui-draggable");
    wp_enqueue_script("jquery-ui-sortable");
    wp_enqueue_script("jquery-ui-dialog");
	wp_enqueue_script('jquery-ui-tabs');
    wp_enqueue_script("farbtastic");
    wp_enqueue_script("imgLiquid.js", plugins_url("/js/imgLiquid.js",__FILE__));
    wp_enqueue_script("jquery.dataTables.min.js", plugins_url("/js/jquery.dataTables.min.js",__FILE__));
    wp_enqueue_script("jquery.validate.min.js", plugins_url("/js/jquery.validate.min.js",__FILE__));
    wp_enqueue_script("jquery.Tooltip.js", plugins_url("/js/jquery.Tooltip.js",__FILE__));
    wp_enqueue_script("bootstrap.js", plugins_url("/js/bootstrap.js",__FILE__));
	wp_enqueue_script("jquery.prettyPhoto.js", plugins_url("/js/jquery.prettyPhoto.js",__FILE__));
}

function fma_zgallery_admin_css_loads(){
    wp_enqueue_style("farbtastic");
	wp_enqueue_style("wp-jquery-ui-dialog");
    wp_enqueue_style("stylesheet.css", plugins_url("/css/stylesheet.css",__FILE__));
    wp_enqueue_style("system-message.css", plugins_url("/css/system-message.css",__FILE__));
    wp_enqueue_style("gallery-zplus.css", plugins_url("/css/gallery-zplus.css",__FILE__));
	wp_enqueue_style("prettyPhoto.css", plugins_url("/css/prettyPhoto.css",__FILE__));
	wp_enqueue_style("premium-edition.css", plugins_url("/css/premium-edition.css",__FILE__));
	wp_enqueue_style("responsive.css", plugins_url("/css/responsive.css",__FILE__));
	wp_enqueue_style("jquery-ui.css", plugins_url("/css/jquery-ui.css",__FILE__));
}

function fma_zgallery_front_js_loads()
{
    wp_enqueue_script("jquery");
    wp_enqueue_script("jquery.masonry.min.js", plugins_url("/js/jquery.masonry.min.js",__FILE__));
    wp_enqueue_script("isotope.pkgd.js", plugins_url("/js/isotope.pkgd.js",__FILE__));
    wp_enqueue_script("imgLiquid.js", plugins_url("/js/imgLiquid.js",__FILE__));
	wp_enqueue_script("jquery.prettyPhoto.js", plugins_url("/js/jquery.prettyPhoto.js",__FILE__));
}

function fma_zgallery_front_css_loads()
{
    wp_enqueue_style("gallery-zplus.css", plugins_url("/css/gallery-zplus.css",__FILE__));
	wp_enqueue_style("prettyPhoto.css", plugins_url("/css/prettyPhoto.css",__FILE__));
}

add_action("media_buttons_context", "fma_zgallery_shortcode_button");
function fma_zgallery_shortcode_button($context)
{
    $context .= "<a href='#TB_inline?width=400&inlineId=my-gallery-content-id'  class='button thickbox'
     title='" . __("Gallery ZPlus", fma-gallery-z) . "'> Gallery ZPlus</a>";
    return $context;
}

add_action("admin_footer", "fma_zgallery_shortcode_content");

function fma_zgallery_shortcode_content()
{
    require_once FMA_GALLERY_ZPLUS_PLUGIN_DIR . "/admin/zgallery_shortcode_admin.php";
}

function fma_zgallery_shortcode($atts)
{
    extract(shortcode_atts(array(
        "album_id" => "",
        "type" => "",
        "format" => "",
        "title" => "",
        "desc" => "",
        "img_in_row" => "",
        "responsive" => "",
        "albums_in_row" => "",
        "special_effect" => "",
        "animation_effect" => "",
        "image_width" => "",
        "gallery_title" => "",
        "thumb_width" => "",
        "thumb_height" => "",
        "widget" => "",
    ), $atts));
    return fma_zgallery_shortcode_execute($album_id, $type, $format, $title, $desc, $img_in_row, $responsive, $albums_in_row, $special_effect, $animation_effect, $image_width, $gallery_title, $thumb_width, $thumb_height, $widget);
}
function fma_zgallery_shortcode_execute($album_id, $album_type, $gallery_type, $img_title, $img_desc, $img_in_row, $responsive, $albums_in_row, $special_effect, $animation_effect, $image_width, $gallery_title, $thumb_width, $thumb_height, $widget)
{
    ob_start();
    global $wpdb;
    include FMA_GALLERY_ZPLUS_PLUGIN_DIR . "/front/gallery_header.php";

    switch ($gallery_type) {
		case "masonry":
			include FMA_GALLERY_ZPLUS_PLUGIN_DIR . "/front/masonry-gallery.php";
			break;
		case "thumbnail":
			include FMA_GALLERY_ZPLUS_PLUGIN_DIR . "/front/thumbnail-gallery.php";
			break;
	}
    include FMA_GALLERY_ZPLUS_PLUGIN_DIR . "/front/gallery_footer.php";
    $gallery_zplus_output_album = ob_get_clean();
    wp_reset_query();
    return $gallery_zplus_output_album;
}

function fma_zgallery_create_installation_tables()
	{
		include FMA_GALLERY_ZPLUS_PLUGIN_DIR . "/admin/create-db.php";
	}

function fma_zgallery_drop_installation_tables()
	{
		include FMA_GALLERY_ZPLUS_PLUGIN_DIR . "/admin/drop-db.php";
	}

register_activation_hook(__FILE__, "fma_zgallery_create_installation_tables");
register_uninstall_hook(__FILE__, "fma_zgallery_drop_installation_tables");

add_shortcode("gallery_zplus", "fma_zgallery_shortcode");
add_action('admin_menu', 'fma_zgallery_admin_menu_actions');
add_action("admin_init", "fma_zgallery_admin_js_loads");
add_action("admin_init", "fma_zgallery_admin_css_loads");
add_action("init", "fma_zgallery_front_js_loads");
add_action("init", "fma_zgallery_front_css_loads");
?>

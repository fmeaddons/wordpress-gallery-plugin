<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
global $wpdb;
$sql = "DROP TABLE " . $wpdb->prefix .'zgallery';
$wpdb->query($sql);

$sql = "DROP TABLE " . $wpdb->prefix .'zgallery_images';
$wpdb->query($sql);

$sql = "DROP TABLE " . $wpdb->prefix .'zgallery_settings';
$wpdb->query($sql);
?>
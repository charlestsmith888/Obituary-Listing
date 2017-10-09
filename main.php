<?php
/**
* @package w_a_p_l
* @version 1.0
*/
/*
Plugin Name: Obituary Listing
Plugin URI: #
Description: Obituary Listing
Version: 1.0
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: ul_pro
Author URI: #
*/
/*
Copyright (C) Year  Author  Email : charlestsmith888@gmail.com
Woocommerce Advanced plugin layout is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.
Woocommerce Advanced plugin layout is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with Woocommerce Advanced plugin layout; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


define('OBL_URL', dirname(__FILE__));
define('OBL_ASSESTS', plugins_url('/obituary-listing/assets/'));


// Public Code
require_once OBL_URL.'/inc/public/public.php';

// Admin Code
require_once OBL_URL.'/inc/admin/admin.php';


// get options custom
if (!function_exists('OBL_get_option')) {
	function OBL_get_option($key='') {
		if ($key == '') {
			return;
		}
		$OBL_settings = array(
			'text-count' => 75,
			'productcolm' => 'col-md-6',
			'popupbtn' => '[...]',
			'woo-popup' => 'red',
			'columncontent1' => '
					<div class="listing-single">
						<div class="thumb"><a href="{$detail-link}"><img src="{$img}" alt="" width="107" height="160"></a></div>
						<div class="content">
							<h2>{$title}</h2>
							<p class="dates">{$dates}</p>
							<p>{$content}</p>
							<div class="obit_buttons"><a href="{$detail-link}">View Details</a> | <a href="#">Send Flowers</a></div>
						</div>
					</div>
			',
			'columncontent2' => '
					<div class="col-md-6 col-sm-12">
						<div class="card-list">
					    <a href="{$detail-link}">
					        <div class="col-md-8 col-sm-12">
					            <h5>{$title}</h5>
					            <p><strong style="color: #dfcc26;">{$dates}</strong></p>
					            <p>{$content}</p>
					        </div>
					        <div class="col-md-4 col-sm-12 no-pad">
					            <img src="{$img}" class="img-full" />
					        </div>
					    </a>
					    </div>
					</div><!--left col end-->
			',
			);
		if ( get_option($key) != '' ) {
			return get_option($key);
		} else {
			return $OBL_settings[$key];
		}
	}
}





if (!function_exists('insert_attachment')) {
	function insert_attachment($file_handler, $post_id, $setthumb=false) {

		if ($_FILES[$file_handler]['error'] !== UPLOAD_ERR_OK) {
			return __return_false();
		}
		require_once(ABSPATH . "wp-admin" . '/includes/image.php');
		require_once(ABSPATH . "wp-admin" . '/includes/file.php');
		require_once(ABSPATH . "wp-admin" . '/includes/media.php');
		$attach_id = media_handle_upload( $file_handler, $post_id );
		
		

		return $attach_id;
	}
}





// Add product in cart with ajax
add_action( 'wp_ajax_photo_shared', 'OBT_myajax_submit' );
add_action( 'wp_ajax_nopriv_photo_shared', 'OBT_myajax_submit' );
function OBT_myajax_submit() {

	$id = $_POST['postid'];
	$attach_id = insert_attachment('img', $id);
	$contributionDate = array(
		'name' => $_POST['name'],
		'date' => $_POST['pdate'],
		'dsc' => $_POST['dsc'],
		'img' => $attach_id,
	);
	add_metadata('post', $id, '_contribution', $contributionDate, false);

	$response = json_encode(array( 'class' => 'alert-success', 'msg'));
	header( "Content-Type: application/json" );
	echo $response;
	exit;
}

<?php


function OBL_Obituary() {
	$labels = array(
		'name'                => __( 'Obituary Listing', 'text-domain' ),
		'singular_name'       => __( 'Obituary', 'text-domain' ),
		'add_new'             => _x( 'Add New Obituary', 'text-domain', 'text-domain' ),
		'add_new_item'        => __( 'Add New Obituary', 'text-domain' ),
		'edit_item'           => __( 'Edit Obituary', 'text-domain' ),
		'new_item'            => __( 'New Obituary', 'text-domain' ),
		'view_item'           => __( 'View Obituary', 'text-domain' ),
		'search_items'        => __( 'Search Obituary Listing', 'text-domain' ),
		'not_found'           => __( 'No Obituary Listing found', 'text-domain' ),
		'not_found_in_trash'  => __( 'No Obituary Listing found in Trash', 'text-domain' ),
		'parent_item_colon'   => __( 'Parent Obituary:', 'text-domain' ),
		'menu_name'           => __( 'Obituary Listing', 'text-domain' ),
		);
	$args = array(
		'labels'                   => $labels,
		'hierarchical'        => false,
		'description'         => 'description',
		'taxonomies'          => array(),
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => null,
		'menu_icon'           => null,
		'show_in_nav_menus'   => true,
		'publicly_queryable'  => true,
		'exclude_from_search' => false,
		'has_archive'         => true,
		'query_var'           => true,
		'can_export'          => true,
		'rewrite'             => true,
		'capability_type'     => 'post',
		'supports'            => array(
			'title', 'editor', 'thumbnail',
			'excerpt',
			)
		);
	register_post_type( 'obituary', $args );
}
add_action( 'init', 'OBL_Obituary' );

// Custom Fields of arbituary...
function OBL_get_meta_field( $value ) {
	global $post;
	$field = get_post_meta( $post->ID, $value, true );
	if ( ! empty( $field ) ) {
		return is_array( $field ) ? stripslashes_deep( $field ) : stripslashes( wp_kses_decode_entities( $field ) );
	} else {
		return false;
	}
}
function ul_pro_custom_fields_add_meta_box() {
	add_meta_box(
		'custom_fields-custom-fields',
		__( 'Custom Fields', 'custom_fields' ),
		'ul_pro_custom_fields_html',
		'obituary',
		'advanced',
		'high'
		);
	add_meta_box(
		'custom_fields-custom-fields_buttons',
		__( 'Add linked Buttons', 'custom_fields_buttons' ),
		'ul_pro_custom_buttons',
		'obituary',
		'advanced',
		'high'
		);	


}
add_action( 'add_meta_boxes', 'ul_pro_custom_fields_add_meta_box' );
function ul_pro_custom_buttons( $post) {
	wp_nonce_field( '_custom_fields_nonce', 'custom_fields_nonce' ); ?>

<div id="dynamic_form-btn">
	<div id="field_wrap-btn">
		

	




		<?php 
		$button_data = get_post_meta( $post->ID, 'button_data', true );
		if ($button_data):
		foreach ($button_data as $key22): ?>
			


		<div class="field_row full-width">
			<div class="field_left">
				<label>
					Button Text
					<input placeholder="Button Text" class="meta_image_url" value="<?php echo $key22[0]; ?>" type="text" name="OBT_btns[btn][]" />
				</label>
				<label>
					Button URL
					<input placeholder="Button URL" class="meta_image_url" value="<?php echo $key22[1]; ?>" type="text" name="OBT_btns[url][]" />
				</label>
			</div>
			<div class="field_right">
				<input class="button" type="button" value="Remove" onclick="remove_field(this)" />
			</div>
		</div>





		<?php endforeach;
		endif; ?>
		<div class="clear" /></div>
	</div>

	<div style="display:none" id="master-row-btn">
		<div class="field_row full-width">
			<div class="field_left">
				<label>
					Button Text
					<input placeholder="Button Text" class="meta_image_url" type="text" name="OBT_btns[btn][]" />
				</label>
				<label>
					Button URL
					<input placeholder="Button URL" class="meta_image_url"  type="text" name="OBT_btns[url][]" />
				</label>
			</div>
			<div class="field_right">
				<input class="button" type="button" value="Remove" onclick="remove_field(this)" />
			</div>
		</div>
	</div>

</div>
<div id="add_field_row">
	<input class="button" type="button" value="Add Button" onclick="add_field_row_btn();" />
</div>
<div class="clear" /></div>
	

	<?php
}
function ul_pro_custom_fields_html( $post) {
	wp_nonce_field( '_custom_fields_nonce', 'custom_fields_nonce' ); ?>


	<div style="width: 46%;float: left;">
		<label for="OBL_dob"><?php _e( 'Date Of Birth', 'custom_fields' ); ?></label><br>
		<input style="width: 100%;" type="date" name="OBL_dob" size="90"  id="OBL_dob" value="<?php echo OBL_get_meta_field( 'OBL_dob' ); ?>">
	</div>
	<div style="width: 46%;float: right;">
		<label for="OBL_dod"><?php _e( 'Date Of Death', 'custom_fields' ); ?></label><br>
		<input style="width: 100%;" type="date" name="OBL_dod" id="OBL_dod" value="<?php echo OBL_get_meta_field( 'OBL_dod' ); ?>">
	</div>
	<div style="clear: both;margin-top: 20px;"></div>

	<?php
}
function ul_pro_custom_fields_save( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	if ( ! isset( $_POST['custom_fields_nonce'] ) || ! wp_verify_nonce( $_POST['custom_fields_nonce'], '_custom_fields_nonce' ) ) return;
	if ( ! current_user_can( 'edit_post', $post_id ) ) return;
	if ( isset( $_POST['OBL_dob'] ) )
		update_post_meta( $post_id, 'OBL_dob', esc_attr( $_POST['OBL_dob'] ) );
	if ( isset( $_POST['OBL_dod'] ) )
		update_post_meta( $post_id, 'OBL_dod', esc_attr( $_POST['OBL_dod'] ) );
}
add_action( 'save_post', 'ul_pro_custom_fields_save' );



//***************************************************//
//*****GALLERY META BOX FOR obituary POST TYPE*******//
//***************************************************//


add_action( 'admin_init', 'OBL_post_gallery' );
add_action( 'admin_head-post.php', 'OBL_print_view' );
add_action( 'admin_head-post-new.php', 'OBL_print_view' );
add_action( 'save_post', 'OBL_gallery_update', 10, 2 );
/**
 * Add custom Meta Box to Posts post type
*/
function OBL_post_gallery()
{
	add_meta_box(
	'post_gallery',
	'Studio Image Uploader',
	'OBL_gallery_metabox',
	'obituary ',// here you can set post type name
	'normal',
	'core'
			);
}
 
/**
 * Print the Meta Box content
 */
function OBL_gallery_metabox()
{
	global $post;
	$gallery_data = get_post_meta( $post->ID, 'gallery_data', true );
 
	// Use nonce for verification
	wp_nonce_field( plugin_basename( __FILE__ ), 'noncename_so_14445904' );
	?>
 
<div id="dynamic_form">
 
    <div id="field_wrap">
    
    	<?php if (isset($gallery_data['image_url'])):
    	foreach ($gallery_data['image_url'] as $key => $value): $thummb = wp_get_attachment_image_src($value,'thumbnail', true); ?>
	    	<div class="field_row">
	    		<div class="field_left" style="display: none;">
	    			<div class="form_field">
	    				<label>Image URL</label>
	    				<input type="text"
	    				class="meta_image_url"
	    				name="gallery[image_url][]"
	    				value="<?php echo $value; ?>"
	    				/>
	    			</div>
	    		</div>
	    		<div class="field_right image_wrap">
	    			<img src="<?php echo $thummb[0]; ?>" height="48" width="48" />
	    		</div>
	    		<div class="field_right">
	    			<input type="button" class="button choosebtn" value="Choose File">
	    			<input class="button" type="button" value="Remove" onclick="remove_field(this)" />
	    		</div>
	    	</div>
    <?php endforeach;
    endif; ?>
	<div class="clear" /></div>

    </div>
 
    <div style="display:none" id="master-row">
    <div class="field_row">
        <div class="field_left" style="display: none;">
            <div class="form_field">
                <label>Image URL</label>
                <input class="meta_image_url" value="" type="text" name="gallery[image_url][]" />
            </div>
        </div>
        <div class="field_right image_wrap">
        </div> 
        <div class="field_right"> 
            <input type="button" class="button choosebtn" value="Choose File" />
            <input class="button" type="button" value="Remove" onclick="remove_field(this)" /> 
        </div>
    </div>
    </div>
 
 
 
</div>
<div id="add_field_row">
  <input class="button" type="button" value="Add Field" onclick="add_field_row();" />
</div>
<div class="clear" /></div>
 
<?php
}
 
/**
 * Print styles and scripts
 */
function OBL_print_view()
{
    // Check for correct post_type
    global $post;
    if( 'obituary' != $post->post_type )// here you can set post type name
        return;
    ?>  
    <style type="text/css">
    #add_field_row, .full-width{width: 100%;float: left;}
    .field_left { float: left; }
    .field_right { float: left; margin-left: 10px; }
    .clear { clear: both; }
    #dynamic_form { width: 100%; }
    #dynamic_form input[type=text] { width: 300px; }
    #dynamic_form .field_row { border: 1px solid #999; margin-bottom: 10px; padding: 10px;float: left;width: 25%;margin-right: 2%; }
    #dynamic_form label { padding: 0 6px; }
    </style>
 
<script type="text/javascript">
  // ADD IMAGE LINK
  jQuery(document).on('click', '.choosebtn', function( event ){
    event.preventDefault();

    var parent = jQuery(this).parent().parent('div.field_row');
    var inputField = jQuery(parent).find("input.meta_image_url");

  // Create a new media frame
  frame = wp.media({
    title: 'Select or Upload Media for Gallery',
    button: {
      text: 'Use this media'
    },
  multiple: false  // Set to true to allow multiple files to be selected
});


// When an image is selected in the media frame...
frame.on( 'select', function() {

// Get media attachment details from the frame state
var attachment = frame.state().get('selection').first().toJSON();

// attachment.id; //89
// attachment.title; //osts57yu7em91yaeazvq
// attachment.filename; //osts57yu7em91yaeazvq.jpg
// attachment.url; //http://localhost/testwp/wp-content/uploads/2017/09/osts57yu7em91yaeazvq.jpg
// attachment.link; //http://localhost/testwp/obituary/obituary-for-dorothy-ann-leslie/osts57yu7em91yaeazvq/

inputField.val(attachment.id);
jQuery(parent).find("div.image_wrap").html('<img src="'+attachment.url+'" height="48" width="48" />');
});
// Finally, open the modal on click
frame.open();
});

function remove_field(obj) {
	var parent=jQuery(obj).parent().parent();
//console.log(parent)
parent.remove();
}

function add_field_row() {
var row = jQuery('#master-row').html();
jQuery(row).appendTo('#field_wrap');
}
function add_field_row_btn() {
var row = jQuery('#master-row-btn').html();
jQuery(row).appendTo('#field_wrap-btn');
}

    </script>


<?php
}
 
/**
 * Save post action, process fields
 */
function OBL_gallery_update( $post_id, $post_object )
{
// Doing revision, exit earlier **can be removed**
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
		return;
// Doing revision, exit earlier
	if ( 'revision' == $post_object->post_type )
		return;
// Verify authenticity
	if ( !wp_verify_nonce( $_POST['noncename_so_14445904'], plugin_basename( __FILE__ ) ) )
		return;
// Correct post type
if ( 'obituary' != $_POST['post_type'] ) // here you can set post type name
return;
if ( @$_POST['gallery'] )
{
// Build array for saving post meta
	$gallery_data = array();
	for ($i = 0; $i < count( $_POST['gallery']['image_url'] ); $i++ )
	{
		if ( '' != $_POST['gallery']['image_url'][ $i ] )
		{
			$gallery_data['image_url'][]  = $_POST['gallery']['image_url'][ $i ];
		}
	}
// echo "<pre>";
	// print_r($gallery_data);
	// die();
	if ( $gallery_data ) 
		update_post_meta( $post_id, 'gallery_data', $gallery_data );
	else 
		delete_post_meta( $post_id, 'gallery_data' );
} 
// Nothing received, all fields are empty, delete option
else 
{
	delete_post_meta( $post_id, 'gallery_data' );
}

//````````````````````````` Buttons Fields
if (@$_POST['OBT_btns']){
	$button_data = array();
	$i = 0;
	foreach ($_POST['OBT_btns']['btn'] as $key => $value) {

		if ( '' != $_POST['OBT_btns']['btn'][$i] ) {
			$button_data[$i][0] = $_POST['OBT_btns']['btn'][$i];
			$button_data[$i][1] = $_POST['OBT_btns']['url'][$i];
			$i++;
		}
	}
	// echo "<pre>";
	// print_r($button_data);
	// die();
	if ( $button_data )
		update_post_meta( $post_id, 'button_data', $button_data );
	else
		delete_post_meta( $post_id, 'button_data' );
}else{
	delete_post_meta( $post_id, 'button_data' );
}





}//save post ends here


// Add Menu
function woo_add_menu_in_admin() {
	add_submenu_page(
		'edit.php?post_type=obituary',
		'Property Seting', /*page title*/
		'Settings', /*menu title*/
		'manage_options', /*roles and capabiliyt needed*/
		'OBL_setting',
		'OBL_setting' /*replace with your own function*/
	);
}
add_action('admin_menu', 'woo_add_menu_in_admin');
	//setting Page
function OBL_setting()
{
	require_once OBL_URL.'/inc/pages/settingpage.php';
}

	// Setting Fields
add_action( 'admin_init', 'OBL_register_woo_settings' );
function OBL_register_woo_settings() {
	register_setting( 'ul-pro-settings-group', 'columncontent1' );
	register_setting( 'ul-pro-settings-group', 'columncontent2' );
}


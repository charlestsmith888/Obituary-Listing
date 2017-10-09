jQuery(document).ready(function(){
	
	jQuery('ul.tabs li').click(function(){
		var tab_id = jQuery(this).attr('data-tab');

		jQuery('ul.tabs li').removeClass('current');
		jQuery('.tab-content').removeClass('current');

		jQuery(this).addClass('current');
		jQuery("#"+tab_id).addClass('current');
	})

})





jQuery(document).on('submit', '.OBT_sharedby', function(event) {
	event.preventDefault();
	var t = jQuery(this);
	var formData = new FormData(jQuery(this)[0]);
	jQuery.ajax({
		type: 'post',
		url: obt_ajaxurl.ajax_url,
		contentType: false,
		processData: false,
		data: formData,
	})
	.done(function(value) {
		t.trigger('reset');
		alert('Thankyou for sharing...');
	})
	.fail(function() {
		alert('Something Went Wrong');
	});
});









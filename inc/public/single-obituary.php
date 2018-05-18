<?php
/**
* The template for displaying all single posts
*
* @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
*
* @package WordPress
* @subpackage Twenty_Seventeen
* @since 1.0
* @version 1.0
*/
get_header(); ?>
<?php while ( have_posts() ) : the_post(); $thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(),'medium_large', true); ?>
	<div id="OBL_bootstrap" class="single-page-obl">
		<div class="clearfix"></div>
		<section class="banner">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<h2><?php the_title(); ?></h2>
						<h4>Born <?php echo OBL_get_meta_field( 'OBL_dob' ); ?> - <?php echo OBL_get_meta_field( 'OBL_dod' ); ?></h4>
					</div>
				</div>
			</div>
		</section>
		<div class="container">
			<div class="row">
				
				<div class="col-md-3 left">
					<div class="images">
						<img src="<?php echo $thumbnail[0]; ?>" alt="" class="img-responsive center-block">
					</div>
					<div class="btns">

						


						<?php $button_data = get_post_meta( get_the_ID(), 'button_data', true );
						if ($button_data):

							foreach ($button_data as $key22): ?>
							<a href="<?php echo $key22[1]; ?>" class="btn-primry"><?php echo $key22[0]; ?><i class="fa fa-chevron-right" aria-hidden="true"></i></a>
						<?php endforeach; endif; ?>


					</div>



				</div>
				<div class="col-md-9 right">
					<ul class="tabs">
						<li class="tab-link current" data-tab="tab-1">Obituary & Services</li>
						<li class="tab-link" data-tab="tab-2">Photos Gallery</li>
						<li class="tab-link" data-tab="tab-3">Condolences</li>
						<li class="tab-link" data-tab="tab-4">Send Flowers</li>
					</ul>
					<div id="tab-1" class="tab-content current">
						<h1 class="property_title"><?php the_title(); ?></h1>
						<div class="clearfix"></div>
						<?php the_content(); ?>
					</div>
					<div id="tab-2" class="tab-content">
						
						<h3>Photos:</h3>

						<div class="row">

						<?php $gallery_data = get_post_meta( get_the_ID(), 'gallery_data', true ); ?>
						<?php if (isset($gallery_data['image_url'])):
						foreach ($gallery_data['image_url'] as $key => $value): $thummb = wp_get_attachment_image_src($value,'thumbnail', true); ?>
						
								<div class="col-md-4"><img class="img-responsive" src="<?php echo $thummb[0]; ?>"></div>
							
							
					<?php endforeach;
					endif; ?>

					<div class="clearfix"></div>
					</div>


					<div class="row">
					<?php $userShared = get_post_meta( get_the_ID(), '_contribution'); ?>
					<?php if ($userShared): ?>
						<div class="col-md-12"><h3>Shared by:</h3></div>
						<?php foreach ($userShared as $Shared): $thummbb = wp_get_attachment_image_src($Shared['img'],'thumbnail', true); ?>
							
						<div class="col-md-3">
							<h5><?php echo $Shared['name']; ?></h5>
							<img src="<?php echo $thummbb[0]; ?>" alt="">
						</div>


						<?php endforeach ?>
					<?php endif ?>

						<div class="clearfix"></div>
					</div>



						
					<h3>Submit A Photo</h3>
					<div class="row">
						<div class="col-md-12">
							<form method="POST" enctype="multipart/form-data" class="OBT_sharedby">
								<input type="hidden" name="action" value="photo_shared">
								<input type="hidden" name="postid" value="<?php echo get_the_ID(); ?>">
								<input type="text" name="name" placeholder="Name">
								<input type="date" name="pdate" placeholder="Photo Date">
								<input type="text" name="dsc" placeholder="Description">
								<input type="file" name="img">
								<input type="submit" value="submit">
							</form>
						</div>
					</div>
				




					</div>
					<div id="tab-3" class="tab-content">
						Condolences
						Honor the life of Jimmie L. Thornton Sr.
						Please share a condolence, photo or memory of Jimmie . We welcome all condolences that are positive and uplifting that will help family and friends heal.
					</div>
					<div id="tab-4" class="tab-content">
						Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
					</div>
				</div>
			</div>
		</div>
	</div>
<?php endwhile; ?>
<?php get_footer(); ?>

<script>
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
</script>
<style type='text/css'>
.woo_fieldset {border: 1px solid #ebebeb;padding: 5px 20px;background: #fff;margin-bottom: 40px;-webkit-box-shadow: 4px 4px 10px 0px rgba(50, 50, 50, 0.1);-moz-box-shadow: 4px 4px 10px 0px rgba(50, 50, 50, 0.1);box-shadow: 4px 4px 10px 0px rgba(50, 50, 50, 0.1);}
.woo_fieldset .sec-title {border: 1px solid #ebebeb;background: #fff;color: #d54e21;padding: 2px 4px;}
</style>


<form method="post" action="options.php" enctype="multipart/form-data">
	<?php settings_fields( 'ul-pro-settings-group' ); ?>



	<h2>Obituary Setting</h2>
	<table class="form-table">

		
		<tr class="wrap-icon-bg-color" valign="top">
			<th scope="row">Listing Style HTML</th>
			<td>
				<textarea name="columncontent1" id="columncontent1" cols="200" rows="10">
					<?php echo esc_html(OBL_get_option('columncontent1')); ?>
				</textarea>
			</td>
		</tr>		
		<tr class="wrap-icon-bg-color" valign="top">
			<th scope="row">Cards Style HTML</th>
			<td>
				<textarea name="columncontent2" id="columncontent2" cols="200" rows="10">
					<?php echo esc_html(OBL_get_option('columncontent2')); ?>
				</textarea>
			</td>
		</tr>

	</table>
	<p class="submit" style="text-align:left"><input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" /></p>
</form>


<div class="container">
	<div class="row">
		<h2 id="shortcode">How to use</h2>
		<fieldset class="woo_fieldset">
			<legend><h4 class="sec-title">Using Shortcode</h4></legend>
			<p>You just need to put the shortcode wherever you want <code></code></p>
			<p>For Search <code></code></p>
		</fieldset>
	</div>
</div>
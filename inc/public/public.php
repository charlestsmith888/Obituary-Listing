<?php

/*
Usage
*/
// Add Shortcode
function OBL_obituary_listing( $atts ) {
// Attributes
	$atts = shortcode_atts(
		array(
			'posttype' => 'obituary',
			'postcount' => 6,
			'type' => 'list'
			),
		$atts
		);
	$q = new WP_Query(
		array('post_type' => array($atts['posttype']),
			'post_status' => array('publish'),
			'orderby' => 'date',
			'order' => 'DESC',
			'posts_per_page' => $atts['postcount'],
			)
		);


		if ($atts['type'] == 'list') {
			$inicontent = OBL_get_option('columncontent1');
			$className = "orbituary-listing";
		}
		if ($atts['type'] == 'card') {
			$inicontent = OBL_get_option('columncontent2');
			$className = "orbituary-card-listing";
		}


		$ul_prop_content = '
		<div id="OBL_bootstrap" class="'.$className.'">
			<div class="row">
			';
				while ($q->have_posts()) : $q->the_post();
				$thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(),'medium_large', true);
				$contreplace = array(
					'{$img}'  		=> $thumbnail[0],
					'{$dates}'  	=> 'Born '.OBL_get_meta_field( 'OBL_dob' ).' Passing Date '.OBL_get_meta_field( 'OBL_dod' ),
					'{$title}'  	=> get_the_title(),
					'{$content}'  	=> substr(get_the_content(), 0 , 200),
					'{$detail-link}'=> get_the_permalink(),
					);
				$ul_prop_content .=strtr($inicontent, $contreplace);
				endwhile;
				$ul_prop_content .= '
			</div>
		</div>
		';
	return $ul_prop_content;
}
add_shortcode( 'obituary-listing', 'OBL_obituary_listing' );
function OBL_func_name( $atts ) {
	$atts = shortcode_atts( array(
		'default' => 'values'
		), $atts );
	$content = '
	<div class="ul-pro-search" id="OBL_bootstrap">
		<form role="search" action="'.site_url('/').'" method="get">
			<input type="text" name="s" placeholder="Search Obituary"/>
			<input type="hidden" name="post_type" value="obituary" />
			<input type="submit" alt="Search" value="Search" />
		</form>
	</div>
	';
	return $content;
}
add_shortcode( 'ultimate-property-search','OBL_func_name' );

// Single Page Template
function OBL_single_page($template)
{
	global $post;
	if ($post->post_type == 'obituary' ) {
		$template = dirname(__FILE__) . '/single-obituary.php';
	}
	return $template;
}
add_filter('single_template', 'OBL_single_page');

// Custom search page
function OBL_template_chooser($template)
{
	global $wp_query;
	if( $wp_query->is_search == '1' && $wp_query->query['post_type'] == 'obituary')
	{
		$template = dirname(__FILE__) . '/search-archive.php';
	}
	return $template;
}
add_filter('template_include', 'OBL_template_chooser');



function OBL_pagination($pages = '', $range = 4)
{
	$showitems = ($range * 2)+1;
	global $paged;
	if(empty($paged)) $paged = 1;
	if($pages == '')
	{
		global $wp_query;
		$pages = $wp_query->max_num_pages;
		if(!$pages)
		{
			$pages = 1;
		}
	}
	if(1 != $pages)
	{
// echo "<div class=\"pagination\">
	// <span>Page ".$paged." of ".$pages."</span>";
		echo "<div class=\"pagination\">";
		previous_posts_link('Prev');
		if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo; First</a>";
		if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo; Previous</a>";
		for ($i=1; $i <= $pages; $i++)
		{
			if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
			{
				echo ($paged == $i)? "<span class=\"current\">".$i."</span>":"<a href='".get_pagenum_link($i)."' class=\"inactive\">".$i."</a>";
			}
		}
		if ($paged < $pages && $showitems < $pages) echo "<a href=\"".get_pagenum_link($paged + 1)."\">Next &rsaquo;</a>";
		if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>Last &raquo;</a>";
		next_posts_link('Next');
		echo "</div>\n";
	}
}
	/**
	* Enqueue scripts
	*
	* @param string $handle Script name
	* @param string $src Script url
	* @param array $deps (optional) Array of script names on which this script depends
	* @param string|bool $ver (optional) Script version (used for cache busting), set to null to disable
* @param bool $in_footer (optional) Whether to enqueue the script before </head> or before </body>
*/
function OBL_stylesheets_for_public()
{
	wp_enqueue_style( 'custom_bootstrap', OBL_ASSESTS.'css/ui-bootstrap.css', 100);
}
add_action( 'wp_head', 'OBL_stylesheets_for_public', 10 );


function OBL_theme_name_scripts() {
	wp_enqueue_script( 'customjs', OBL_ASSESTS.'/js/custom.js', array( 'jquery' ), '1.1', true);
	wp_localize_script('customjs', 'obt_ajaxurl', array(
		'ajax_url' => admin_url('admin-ajax.php'),
	));
}
add_action( 'wp_enqueue_scripts', 'OBL_theme_name_scripts' );


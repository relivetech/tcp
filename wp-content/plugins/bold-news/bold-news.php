<?php

/**
 * Plugin Name: Bold News Plugin
 * Description: Shortcodes and widgets by BoldThemes.
 * Version: 1.4.7
 * Author: BoldThemes
 * Author URI: http://bold-themes.com 
 */
 
require_once( 'framework_plugin/framework.php' );

function bt_load_custom_wp_admin_style() {
	wp_enqueue_style( 'bt_custom_wp_admin_css', plugin_dir_url( __FILE__ ) . 'admin-style.css' );
}
add_action( 'admin_enqueue_scripts', 'bt_load_custom_wp_admin_style' );

function bt_widgets_init() {
	register_sidebar( array (
		'name' 			=> esc_html__( 'Header Left Widgets', 'bt_plugin' ),
		'id' 			=> 'header_left_widgets',
		'before_widget' => '<div class="btTopBox %2$s">', 
		'after_widget' 	=> '</div>'
	));
	register_sidebar( array (
		'name' 			=> esc_html__( 'Header Right Widgets', 'bt_plugin' ),
		'id' 			=> 'header_right_widgets',
		'before_widget' => '<div class="btTopBox %2$s">',
		'after_widget' 	=> '</div>'
	));
	register_sidebar( array (
		'name' 			=> esc_html__( 'Header Menu Widgets', 'bt_plugin' ),
		'id' 			=> 'header_menu_widgets',
		'before_widget' => '<div class="btTopBox %2$s">', 
		'after_widget' 	=> '</div>'
	));
	register_sidebar( array (
		'name' 			=> esc_html__( 'Header Banner Widgets', 'bt_plugin' ),
		'id' 			=> 'header_banner_widgets',
		'before_widget' => '<div class="btTopBox %2$s">', 
		'after_widget' 	=> '</div>'
	));
	register_sidebar( array (
		'name' 			=> esc_html__( 'Footer Widgets', 'bt_plugin' ),
		'id' 			=> 'footer_widgets',
		'before_widget' => '<div class="btBox %2$s">',
		'after_widget' 	=> '</div>',
		'before_title' 	=> '<h4><span>',
		'after_title' 	=> '</span></h4>',
	));
	register_sidebar( array (
		'name' 			=> esc_html__( 'Post Banner', 'bt_plugin' ),
		'id' 			=> 'post_banner',
		'before_widget' => '<div class="btPostBanner %2$s">',
		'after_widget' 	=> '</div>',
		'before_title' 	=> '<h4><span>',
		'after_title' 	=> '</span></h4>',
	));
	register_sidebar( array (
		'name' 			=> esc_html__( 'Left Banners', 'bt_plugin' ),
		'id' 			=> 'left_banner',
		'before_widget' => '<div class="btBox %2$s">',
		'after_widget' 	=> '</div>',
		'before_title' 	=> '<h4><span>',
		'after_title' 	=> '</span></h4>',
	));
}
add_action( 'widgets_init', 'bt_widgets_init', 30 );

function bt_plugin_enqueue() {
	wp_enqueue_script( 'bt_plugin_enqueue', plugin_dir_url( __FILE__ ) . 'bt_elements.js', array( 'jquery' ), '', false );
}
add_action( 'wp_enqueue_scripts', 'bt_plugin_enqueue' );
 
function bt_load_plugin_textdomain() {

	$domain = 'bt_plugin';
	$locale = apply_filters( 'plugin_locale', get_locale(), $domain );

	load_plugin_textdomain( $domain, false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );

}
add_action( 'plugins_loaded', 'bt_load_plugin_textdomain' );

// Extra profile information
add_action( 'show_user_profile', 'bold_news_extra_profile_fields' );
add_action( 'edit_user_profile', 'bold_news_extra_profile_fields' );

if ( ! function_exists( 'bold_news_extra_profile_fields' ) ) {
	function bold_news_extra_profile_fields( $user ) {?>
		<h3>Extra profile information</h3>
		<table class="form-table">
			<tr>
				<th><label for="twitter">Twitter</label></th>
				<td>
					<input type="text" name="twitter" id="twitter" value="<?php echo esc_attr( get_the_author_meta( 'twitter', $user->ID ) ); ?>" class="regular-text" /><br />
					<span class="description">Enter user Twitter link.</span>
				</td>
			</tr>
			<tr>
				<th><label for="twitter">Facebook</label></th>
				<td>
					<input type="text" name="facebook" id="facebook" value="<?php echo esc_attr( get_the_author_meta( 'facebook', $user->ID ) ); ?>" class="regular-text" /><br />
					<span class="description">Enter user Facebook link.</span>
				</td>
			</tr>
			<tr>
				<th><label for="twitter">Linkedin</label></th>
				<td>
					<input type="text" name="linkedin" id="linkedin" value="<?php echo esc_attr( get_the_author_meta( 'linkedin', $user->ID ) ); ?>" class="regular-text" /><br />
					<span class="description">Enter user Linkedin link.</span>
				</td>
			</tr>
			<tr>
				<th><label for="twitter">Google+</label></th>
				<td>
					<input type="text" name="google_plus" id="google_plus" value="<?php echo esc_attr( get_the_author_meta( 'google_plus', $user->ID ) ); ?>" class="regular-text" /><br />
					<span class="description">Enter user Google+ link.</span>
				</td>
			</tr>
			<tr>
				<th><label for="twitter">Vkontakte</label></th>
				<td>
					<input type="text" name="vkontakte" id="vkontakte" value="<?php echo esc_attr( get_the_author_meta( 'vkontakte', $user->ID ) ); ?>" class="regular-text" /><br />
					<span class="description">Enter user Vkontakte link.</span>
				</td>
			</tr>

		</table>
	<?php }
}

add_action( 'personal_options_update', 'bold_news_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'bold_news_save_extra_profile_fields' );

if ( ! function_exists( 'bold_news_save_extra_profile_fields' ) ) {
	function bold_news_save_extra_profile_fields( $user_id ) {
		if ( !current_user_can( 'edit_user', $user_id ) ) return false;

		update_user_meta( $user_id, 'twitter', $_POST['twitter'] );
		update_user_meta( $user_id, 'facebook', $_POST['facebook'] );
		update_user_meta( $user_id, 'linkedin', $_POST['linkedin'] );
		update_user_meta( $user_id, 'google_plus', $_POST['google_plus'] );
		update_user_meta( $user_id, 'vkontakte', $_POST['vkontakte'] );
	}
}

// /Extra profile information

 // [bt_highlight]
function bt_highlight( $atts, $content ) {
	extract( shortcode_atts( array(
	), $atts, 'bt_highlight' ) );
	return '<span class="btHighlight">' . wptexturize( do_shortcode( $content ) ) . '</span>';
}
add_shortcode( 'bt_highlight', 'bt_highlight' );

// [bt_drop_cap type="1/2/3"]
function bt_drop_cap( $atts, $content ) {
	extract( shortcode_atts( array(
		'type' => '1'
	), $atts, 'bt_drop_cap' ) );
	
	$type = intval( $type );
	
	$class = 'enhanced';
	
	if ( $type == 2 ) {
		$class = 'enhanced circle colored';
	} else if ( $type == 3 ) {
		$class = 'enhanced ring';
	}

	return '<span class="' . $class . '">' . wptexturize( do_shortcode( $content ) ) . '</span>';
}
add_shortcode( 'bt_drop_cap', 'bt_drop_cap' );

// [bt_image]
class bt_image  {
	static function init() {
		add_shortcode( 'bt_image', array( __CLASS__, 'handle_shortcode' ) );
	}

	static function handle_shortcode( $atts, $content ) {
		extract( shortcode_atts( array(
			'image'  		=> '',
			'caption_title'	=> '',	
			'caption_text'	=> '',
			'show_titles'   => '',	
			'size'     		=> '',
			'shape'     	=> '',
			'hover_type'    => '',
			'url'      		=> '',
			'target'      	=> '',
			'el_style' 		=> '',
			'el_class' 		=> ''
		), $atts, 'bt_image' ) );
		
		$image = sanitize_text_field( $image );
		$caption_title = sanitize_text_field( $caption_title );
		$caption_text = sanitize_text_field( $caption_text );
		$show_titles = sanitize_text_field( $show_titles );
		$size = sanitize_text_field( $size );
		$shape = sanitize_text_field( $shape );
		$hover_type = sanitize_text_field( $hover_type );
		$url = sanitize_text_field( $url );
		$target = sanitize_text_field( $target );
		$el_style = sanitize_text_field( $el_style );
		// $el_class = 'btTextCenter ' . sanitize_text_field( $el_class );
		$el_class = ' ' . sanitize_text_field( $el_class );
		if( $hover_type != '') $el_class = $hover_type . ' ' . $el_class ;

		if ( strpos( $caption_text, PHP_EOL ) !== false) {
			$caption_text = '<p>' . str_replace( "\n", '</p><p>', $caption_text ) . '</p>';
		}

		if ( $image != '' ) {
			$post_image = get_post( $image );
			if ( $post_image && $caption_text == '' ) $caption_text = get_post( $image )->post_excerpt;
			$image = wp_get_attachment_image_src( $image, $size );
			$image = $image[0];
		}
		
		
 		
		return boldthemes_get_image_html(
			array(
				'image' => $image,
				'caption_title' => $caption_title,
				'caption_text' => $caption_text,
				'content' => do_shortcode( $content ),
				'size' => $size,
				'shape' => $shape,
				'url' => $url,
				'target' => $target,
				'show_titles' => $show_titles,
				'el_style' => $el_style,
				'el_class' => $el_class
			)
		);
	}
}

remove_shortcode( 'image' );

// [image]
class image {
	static function init() {
		add_shortcode( 'image', array( __CLASS__, 'handle_shortcode' ) );
	}

	static function handle_shortcode( $atts ) {
		extract( shortcode_atts( array(
				'ids'      => '',
				'orderby'  => '',
				'order'    => '',
				'size'     => '',
				'el_style' => '',
				'el_class' => ''
		), $atts, 'image' ) );

		$ids = sanitize_text_field( $ids );
		$orderby = sanitize_text_field( $orderby );
		$order = sanitize_text_field( $order );
		$el_style = sanitize_text_field( $el_style );
		$el_class = sanitize_text_field( $el_class );
		$size = sanitize_text_field( $size );

		if ( $orderby == 'post_date' ) {
			$orderby = 'date';
		}

		if ( $orderby == '' ) {
			$orderby = 'post__in';
		}

		if ( $order == '' ) {
			$order = 'ASC';
		}

		if ( $size == '' ) {
			$size = 'large';
		}

		$ids = trim( $ids );
		$ids = explode( ',', $ids );
		$the_query = new WP_Query( array ( 'post_type' => 'attachment', 'post_status' => 'any', 'orderby' => $orderby, 'order' => $order, 'post__in' => $ids, 'posts_per_page' => -1, 'nopaging' => true ) );

		$output = '';

		while ( $the_query->have_posts() ) {

			$the_query->the_post();
			$img = wp_get_attachment_image_src( $the_query->post->ID, $size );
				
			$img_full = wp_get_attachment_image_src( $the_query->post->ID, 'full' );
			$img_full = $img_full[0];

			$img = $img[0];
			$caption = $the_query->post->post_excerpt;
			$title = $the_query->post->post_title;
				
			$output = '<div class="btImage"><img src="' . esc_url( $img ) . '" alt="' . esc_attr( $title ) . '"></div>';
				
		}

		wp_reset_postdata();


		return $output;
	}
}

remove_shortcode( 'gallery' );
// [gallery]
class gallery {
	static function init() {
		add_shortcode( 'gallery', array( __CLASS__, 'handle_shortcode' ) );
	}

	static function handle_shortcode( $atts ) {
		extract( shortcode_atts( array(
			'ids'      => '',
			'orderby'  => '',
			'order'    => '',
			'size'     => '',
			'el_style' => '',
			'el_class' => ''
		), $atts, 'gallery' ) );
		
		$ids = sanitize_text_field( $ids );
		$orderby = sanitize_text_field( $orderby );
		$order = sanitize_text_field( $order );
		$el_style = sanitize_text_field( $el_style );
		$el_class = sanitize_text_field( $el_class );
		$size = sanitize_text_field( $size );
		
		if ( $orderby == 'post_date' ) {
			$orderby = 'date';
		}
		
		if ( $orderby == '' ) {
			$orderby = 'post__in';
		}
		
		if ( $order == '' ) {
			$order = 'ASC';
		}
		
		if ( $size == '' ) {
			$size = 'large';
		}
		
		$ids = trim( $ids );
		$ids = explode( ',', $ids );
		$the_query = new WP_Query( array ( 'post_type' => 'attachment', 'post_status' => 'any', 'orderby' => $orderby, 'order' => $order, 'post__in' => $ids, 'posts_per_page' => -1, 'nopaging' => true ) );
		
		$output = '';
		
		while ( $the_query->have_posts() ) {
		
			$the_query->the_post();
			$img = wp_get_attachment_image_src( $the_query->post->ID, $size );
			
			$img_full = wp_get_attachment_image_src( $the_query->post->ID, 'full' );
			$img_full = $img_full[0];			
	
			$img = $img[0];
			$caption = $the_query->post->post_excerpt;
			$title = $the_query->post->post_title;
			
			$output .= '<div class="bpbItem"><img src="' . esc_url( $img ) . '" alt="' . esc_attr( $title ) . '"></div>';
			
		}
		
		wp_reset_postdata();
		
		$class_html = '';
		if ( $el_class != '' ) {
			$class_html = ' ' . $el_class;
		}
		
		$style_html = '';
		if ( $el_style != '' ) {
			$style_html= ' ' . 'style="' . $el_style . '"';
		}		

		$output = '<div class="boldPhotoSlide ' . $class_html . '"' . $style_html . '>' . $output . '</div>';
		
		return $output;
	}
}

// [bt_grid_gallery]
class bt_grid_gallery {
	static function init() {
		add_shortcode( 'bt_grid_gallery', array( __CLASS__, 'handle_shortcode' ) );
	}

	static function handle_shortcode( $atts ) {
	
		wp_enqueue_script( 
			'boldthemes_imagesloaded',
			plugin_dir_url( __FILE__ ) . 'imagesloaded.pkgd.min.js',
			array( 'jquery' ),
			'',
			true
		);
		
		wp_enqueue_script( 
			'boldthemes_packery',
			plugin_dir_url( __FILE__ ) . 'packery.pkgd.min.js',
			array( 'jquery' ),
			'',
			true
		);	
		
		wp_enqueue_script( 
			'boldthemes_grid_tweak',
			plugin_dir_url( __FILE__ ) . 'bt_grid_tweak.js',
			array( 'jquery' ),
			'',
			true
		);
	
		wp_enqueue_script( 
			'boldthemes_grid_gallery',
			plugin_dir_url( __FILE__ ) . 'bt_grid_gallery.js',
			array( 'jquery' ),
			'',
			true
		);
	
		extract( shortcode_atts( array(
			'ids'       => '',
			'format'    => '',
			'grid_gap'  => '',
			'columns'   => '',
			'lightbox'  => '',
			'orderby'   => '',
			'order'     => '',
			'has_thumb' => '',
			'links'     => '',
			'el_style'  => '',
			'el_class'  => ''
		), $atts, 'bt_grid_gallery' ) );
		
		$ids = sanitize_text_field( $ids );
		$format = sanitize_text_field( $format );
		$grid_gap = sanitize_text_field( $grid_gap );
		$columns = sanitize_text_field( $columns );
		$lightbox = sanitize_text_field( $lightbox );
		$orderby = sanitize_text_field( $orderby );
		$order = sanitize_text_field( $order );
		$has_thumb = sanitize_text_field( $has_thumb );
		$links = sanitize_text_field( $links );
		$el_style = sanitize_text_field( $el_style );
		$el_class = sanitize_text_field( $el_class );
		
		$format_arr = explode( ',', $format );
		
		$links_arr = explode( ',', $links );
		
		if ( $orderby == 'post_date' ) {
			$orderby = 'date';
		}
		
		if ( $orderby == '' ) {
			$orderby = 'post__in';
		}
		
		if ( $order == '' ) {
			$order = 'ASC';
		}

		if ( $grid_gap != '' ) {
			$el_class .= ' btGridGap-' . $grid_gap;
		}
		
		$ids = trim( $ids );
		$ids = explode( ',', $ids );
		$the_query = new WP_Query( array ( 'post_type' => 'attachment', 'post_status' => 'any', 'orderby' => $orderby, 'order' => $order, 'post__in' => $ids, 'posts_per_page' => -1, 'nopaging' => true ) );
		
		$output = '';
		
		$n = 0;
		
		$lightbox_class = '';
		
		while ( $the_query->have_posts() ) {

			$the_query->the_post();
			
			$size = 'boldthemes_medium_square';
			$tile_format = '11';
			
			if ( isset( $format_arr[ $n ] ) ) {
				if ( $format_arr[ $n ] == '11' ) {
					$size = 'boldthemes_medium_square';
					$tile_format = '11';
				} else if ( $format_arr[ $n ] == '21' ) {
					$size = 'boldthemes_large_rectangle';
					$tile_format = '21';
				} else if ( $format_arr[ $n ] == '12' ) {
					$size = 'boldthemes_large_vertical_rectangle';
					$tile_format = '12';
				} else if ( $format_arr[ $n ] == '22' ) {
					$size = 'boldthemes_large_square';
					$tile_format = '22';
				}
			}
			
			$img = wp_get_attachment_image_src( $the_query->post->ID, $size );
			$img = $img[0];
			
			$caption = $the_query->post->post_excerpt;
			
			$data_order_num = $n;
			if ( $has_thumb == 'yes' ) {
				$data_order_num++;
			}
			
			if ( ! boldthemes_get_option( 'pf_ghost_slider' ) ) {
				$data_order_num--;
			}
			
			if ( $lightbox != 'yes' ) {
				$link = '<a href="#"></a>';
			} else {
				$lightbox_class = ' ' . 'lightbox';
				$img_full = wp_get_attachment_image_src( $the_query->post->ID, 'full' );
				$img_full = $img_full[0];
				$link = '<a href="' . esc_url( $img_full ) . '" class="lightbox" data-title="' . esc_attr( $caption ) . '"></a>';
			}
			
			if ( isset( $links_arr[ $n ] ) && $links_arr[ $n ] != '' ) {
				$lightbox_class = '';
				$link = '<a href="' . $links_arr[ $n ] . '" target="_blank"></a>';
			}

			$output .= '<div class="gridItem btGhostSliderThumb bt' . $tile_format . '" data-order-num="' . esc_attr( $data_order_num ) . '"><div class="btTileBox">' . boldthemes_get_image_html(
				array(
					'image' => $img,
					'caption_title' => $caption,
					'caption_text' => '',
					'content' => '',
					'size' => $size,
					'shape' => '',
					'url' => $link,
					'target' => '_self',
					'show_titles' => false,
					'el_style' => '',
					'el_class' => ''
				)
			) . '</div></div>';
			
			$n++;
		}
		
		wp_reset_postdata();
		
		$class_html = '';
		if ( $el_class != '' ) {
			$class_html = ' ' . $el_class;
		}
		
		$style_html = '';
		if ( $el_style != '' ) {
			$style_html= ' ' . 'style="' . $el_style . '"';
		}		

		$output = '<div class="tilesWall btGridGallery tiled' . $class_html . $lightbox_class . '"' . $style_html . ' data-col="' . $columns . '"><div class="gridSizer"></div>' . $output . '</div>';
		
		return $output;
	}
}

// [bt_section]
class bt_section {
	static function init() {
		add_shortcode( 'bt_section', array( __CLASS__, 'handle_shortcode' ) );
	}

	static function handle_shortcode( $atts, $content ) {
		
		extract( shortcode_atts( array(
			'layout'            => '', // boxed/wide
			'top_spaced'        => '', // not-spaced/semiSpaced/spaced/extraSpaced
			'bottom_spaced'     => '', // not-spaced/semiSpaced/spaced/extraSpaced
			'skin'              => '', // inherit/dark/light
			'full_screen'       => '', // no/yes
			'vertical_align'    => '', // inherit/top/middle/bottom
			'back_image'        => '',
			'back_color'        => '',
			'back_overlay'		=> '',
			'back_video'        => '',
			'video_settings'    => '',
			'back_video_mp4'    => '',
			'back_video_ogg'    => '',
			'back_video_webm'   => '',				
			'parallax'          => '',
			'parallax_offset'   => '',
			'animation'         => '',
			'animation_back'    => '',
			'animation_impress' => '',
			'posts_category'    => '',
			'posts_author'      => '',
			'show_prev'         => '',
			'show_sticky'       => '',
			'divider'           => '', // no/yes
			'el_id'             => '',
			'el_class'          => '',
			'el_style'          => ''
		), $atts, 'bt_section' ) );
		
		$class = array( 'boldSection' );

		if ( $divider != 'no' && $divider != '' ) {
			$class[] = 'btDivider';
		}

		if ( $top_spaced != 'not-spaced' && $top_spaced != '' ) {
			$class[] = $top_spaced;
		}

		if ( $bottom_spaced != 'not-spaced' && $bottom_spaced != '' ) {
			$class[] = $bottom_spaced;
		}
		
		if ( $skin == 'dark' ) {
			$class[] = 'btDarkSkin';
		} else if ( $skin == 'light' ) {
			$class[] = 'btLightSkin';
		} else if ( $skin == 'accent' ) {
			$class[] = 'btAccentColorBackground';
		} else if ( $skin == 'alternate' ) {
			$class[] = 'btAlternateColorBackground';
		} else if ( $skin == 'accent-dark' ) {
			$class[] = 'btDarkSkin btAccentColorBackground';
		} else if ( $skin == 'alternate-dark' ) {
			$class[] = 'btDarkSkin btAlternateColorBackground';
		}
		
		if ( $layout != 'wide' ) {
			$class[] = 'gutter';
			$class[] = $layout;
		}

		if ( $full_screen == 'yes' && ! BoldThemesFramework::$has_sidebar ) {
			$class[] = 'fullScreenHeight';
		}

		if ( $vertical_align != 'Inherit' && $vertical_align != '' ) {
			$class[] = $vertical_align;
		}

		$data_parallax_attr = '';
		if ( $parallax != '' && ! wp_is_mobile() ) {
		
			$data_parallax_attr = 'data-parallax="' . $parallax . '" data-parallax-offset="' . intval( $parallax_offset ) . '"';
			$class[] = 'btParallax';
		}
		
		if ( $back_image != '' ) {
			$back_image = wp_get_attachment_image_src( $back_image, 'full' );
			$back_image_url = $back_image[0];
			$back_image_style = 'background-image:url(\'' . $back_image_url . '\');';
			$el_style = $back_image_style . $el_style;	
			$class[] = 'wBackground cover';
		}

		if ( $back_color != '' ) {
			$back_color_style = 'background-color:' . $back_color . '  !important;';
			$el_style = $back_color_style . $el_style;	
		}

		if ( $back_overlay != '' ) {
			$class[] = $back_overlay;
		}
		
		$page_anim = boldthemes_rwmb_meta( BoldThemesFramework::$pfx . '_animations' );
		
		$http_user_agent = $_SERVER['HTTP_USER_AGENT'];
		$is_ie = false;
		if ( strpos( $http_user_agent, 'MSIE' ) || strpos( $http_user_agent, 'Trident/' ) || strpos( $http_user_agent, 'Edge/' ) ) {
			$is_ie = true;
		}
		
		/*if ( $is_ie && $page_anim == 'impress' && $animation_impress != '' ) {
			$page_anim = '';
			$animation = '0';
		}*/
		
		$data_anim_attr = '';
		$data_anim_back_attr = '';
		if ( $page_anim != 'impress' && $animation != '' ) {
			wp_enqueue_script( 
				'boldthemes_section_anims_js',
				plugin_dir_url( __FILE__ ) . 'pagetransitions.js',
				array( 'jquery' ),
				'',
				true
			);
			$data_anim_attr = ' ' . 'data-animation="' . $animation . '"';
			$data_anim_back_attr = ' ' . 'data-animation-back="' . $animation_back . '"';
		}
		
		$data_anim_impress_attr = '';
		if ( $page_anim == 'impress' && $animation_impress != '' ) {
			$temp_arr = explode( ';', $animation_impress );
			if ( count( $temp_arr ) == 3 ) {
				$class[] = 'step';
				wp_enqueue_script( 
					'boldthemes_impress',
					plugin_dir_url( __FILE__ ) . 'impress.js',
					array( 'jquery' ),
					'',
					true
				);
				wp_enqueue_script( 
					'boldthemes_impress_custom',
					plugin_dir_url( __FILE__ ) . 'impress_custom.js',
					array( 'jquery' ),
					'',
					true
				);
				$data_anim_impress_attr = ' ';
				for ( $i = 0; $i < 3; $i++ ) {
					$temp_arr1 = explode( ',', $temp_arr[ $i ] );
					
					if ( $i == 0 ) {
						if ( $is_ie ) {
							$temp_arr1[2] = 0;
						}
						$data_anim_impress_attr .= 'data-x="' . intval( $temp_arr1[0] ) . '" data-y="' . intval( $temp_arr1[1] ) . '" data-z="' . intval( $temp_arr1[2] ) . '"';
					} else if ( $i == 1 ) {
						if ( $is_ie ) {
							$temp_arr1[1] = 0;
							$temp_arr1[2] = 0;
						}
						$data_anim_impress_attr .= ' ' . 'data-rotate="' . intval( $temp_arr1[0] ) . '" data-rotate-x="' . intval( $temp_arr1[1] ) . '" data-rotate-y="' . intval( $temp_arr1[2] ) . '"';
					} else if ( $i == 2 ) {
						$data_anim_impress_attr .= ' ' . 'data-scale="' . floatval( $temp_arr1[0] ) . '"';
					}
				}
			}
		}
		
		$id_attr = '';
		if ( $el_id == '' ) {
			$el_id = uniqid( 'bt_section' );
		}
		$id_attr = 'id="' . $el_id . '"';
		
		$back_video_attr = '';
		
		$video_html = '';
		
		if ( $back_video != '' && ! wp_is_mobile() ) {
			wp_enqueue_style( 'boldthemes_style_yt', plugin_dir_url( __FILE__ ) . 'css/YTPlayer.css', array(), false );
			wp_enqueue_script( 
				'boldthemes_yt',
				plugin_dir_url( __FILE__ ) . 'jquery.mb.YTPlayer.min.js',
				array( 'jquery' ),
				'',
				true
			);
			
			$class[] = 'bt_yt_video';
			
			if ( $video_settings == '' ) {
				$video_settings = 'showControls:false,showYTLogo:false,mute:true,stopMovieOnBlur:false,opacity:1';
			}
			
			$back_video_attr = ' ' . 'data-property="{videoURL:\'' . $back_video . '\',containment:\'self\',' . $video_settings . '}"';
			$proxy = new YT_Video_Proxy();
			add_action( 'wp_footer', array( $proxy, 'js_init' ) );
			
		} else if ( ( $back_video_mp4 != '' || $back_video_ogg != '' || $back_video_webm != '' ) && ! wp_is_mobile() ) {
			$class[] = 'video';
			$video_html = '<video autoplay loop muted onplay="bt_video_callback( this )">';
			if ( $back_video_mp4 != '' ) {
				$video_html .= '<source src="' . $back_video_mp4 . '" type="video/mp4">';
			}
			if ( $back_video_ogg != '' ) {
				$video_html .= '<source src="' . $back_video_ogg . '" type="video/ogg">';
			}
			if ( $back_video_webm != '' ) {
				$video_html .= '<source src="' . $back_video_webm . '" type="video/webm">';
			}
			$video_html .= '</video>';
		}
		
		if ( $el_class != '' ) {
			$class[] = $el_class;
		}
		
		$style_attr = '';
		if ( $el_style != '' ) {
			$style_attr = 'style="' . $el_style . '"';
		}
		
		$content = do_shortcode( $content );
		$subposts = substr_count( $content, 'btSinglePostTemplateCount' );

		preg_match_all( '/image_size__(.*?)__/', $content, $image_size_matches );
		$image_size_matches = $image_size_matches[1];

		if ( $show_sticky == 'yes' ) {
			$show_sticky = true;
		} else {
			$show_sticky = false;
		}

		if ( $show_prev == 'yes' ) {
			$show_prev = true;
		} else {
			$show_prev = false;
		}
		
		global $bt_global_exclude_ids;

		if ( $show_prev ) {
			$bt_local_exclude_ids = array();
		} else {
			$bt_local_exclude_ids = $bt_global_exclude_ids;
		}

		if ( $subposts > 0 ) {

			$posts = boldthemes_get_template_posts_data( $subposts, 0, $posts_category, $bt_local_exclude_ids, $posts_author, $show_sticky, 'blog', $atts, 'bt_section' );

			$title_replace = array();
			$permalink_title_replace = array();
			$date_replace = array();
			$author_replace = array();
			$post_format_replace = array();
			$permalink_replace1 = array();
			$permalink_replace2 = array();
			$permalink_replace3 = array();
			$permalink_replace4 = array();
			$excerpt_replace = array();
			$categories_replace = array();
			$post_image_replace = array();
			$post_bg_image_replace = array();
			$reading_time_replace = array();
			$views_count_replace = array();
			$star_rating_replace = array();
			$comments_replace = array();
			$video_replace = array();
			$video_text_replace = array();
			
			$m = 0;
			foreach ( $posts as $item ) {
				
				if ( isset( $bt_global_exclude_ids ) && !in_array($item['ID'], $bt_global_exclude_ids)  ) { 
					$bt_global_exclude_ids[] = $item['ID']; 
				}
				$title_replace[] = $item['title'];
				$permalink_title_replace[] = $item['title'];
				$date_replace[] = $item['date'];
				$author_replace[] = boldthemes_get_post_author_id( false, $item['ID']);
				$post_format_replace[] = $item['format'];
				$excerpt_replace[] = get_the_excerpt( $item['ID'] );
				$permalink_replace1[] = $item['permalink'];
				$permalink_replace2[] = $item['permalink'];
				$permalink_replace3[] = $item['permalink'];
				$permalink_replace4[] = $item['permalink'];
				$categories_replace[] = $item['category'];
				$post_image_replace_tmp = wp_get_attachment_image_src( get_post_thumbnail_id( $item['ID'] ), $image_size_matches[ $m ] );
				$post_image_replace[] = '<img src="' . $post_image_replace_tmp[0] . '" title="' . $item['title'] . '">';
				$post_bg_image_replace[] = $post_image_replace_tmp[0];
				$views_count_replace[] = bold_news_get_view_count( $item['ID'] );
				$star_rating_replace[] = boldthemes_get_post_star_rating( $item['ID'] );
				$reading_time_replace[] = bold_news_get_reading_time( $item['ID'] );
				$comments_replace[] = "<span class='btArticleComments'>" . $item['comments'] . "</span>";
				$video_replace[] = $item['video'] != '' ? '<div class="btMediaBoxPopup"><div class="btMediaBoxPopupClose"></div>' . boldthemes_get_media_html( 'video_frame_data_src', array( $item['video'] ) ) . '</div>' : '';
				$video_text_replace[] = $item['video'] != '' ? '<span class="btVideoPopupText">' . __( 'Play video', 'bt_plugin' ) . '</span>' : '';
				
				$m++;

			}

			$content = preg_replace_callback( '/{{ video_player }}/', function() use( &$video_replace ) {
				return array_shift( $video_replace );
			}, $content );

			$content = preg_replace_callback( '/{{ video_player_text }}/', function() use( &$video_text_replace ) {
				return array_shift( $video_text_replace );
			}, $content );

			$content = preg_replace_callback( '/{{ title }}/', function() use( &$title_replace ) {
				return array_shift( $title_replace );
			}, $content );
			
			$content = preg_replace_callback( '/{{ permalink_title }}/', function() use( &$permalink_title_replace ) {
				return array_shift( $permalink_title_replace );
			}, $content );

			$content = preg_replace_callback( '/{{ date }}|{{ ! date }}/', function( $matches ) use( &$date_replace ) {
				$r = array_shift( $date_replace );
				if ( substr( $matches[0], 0, 4 ) == '{{ !' ) {
					return '';
				}
				return $r;
			}, $content );

			
			
			$content = preg_replace_callback( '/{{ author }}|{{ ! author }}/', function( $matches ) use( &$author_replace ) {
				$r = array_shift( $author_replace );
				if ( substr( $matches[0], 0, 4 ) == '{{ !' ) {
					return '';
				}
				return $r;
			}, $content );
			
			$content = preg_replace_callback( '/{{ post_format }}|{{ ! post_format }}/', function( $matches ) use( &$post_format_replace ) {
				$r = array_shift( $post_format_replace );
				if ( substr( $matches[0], 0, 4 ) == '{{ !' ) {
					return '';
				}
				return $r;
			}, $content );

			$content = preg_replace_callback( '/{{ excerpt }}|{{ ! excerpt }}/', function( $matches ) use( &$excerpt_replace ) {
				$r = array_shift( $excerpt_replace );
				if ( substr( $matches[0], 0, 4 ) == '{{ !' ) {
					return '';
				}
				return $r;
			}, $content );

			$content = preg_replace_callback( '/{{ permalink1 }}|{{ ! permalink1 }}/', function( $matches ) use( &$permalink_replace1 ) {
				$r = array_shift( $permalink_replace1 );
				if ( substr( $matches[0], 0, 4 ) == '{{ !' ) {
					return '';
				}
				return $r;
			}, $content );

			$content = preg_replace_callback( '/{{ permalink2 }}|{{ ! permalink2 }}/', function( $matches ) use( &$permalink_replace2 ) {
				$r = array_shift( $permalink_replace2 );
				if ( substr( $matches[0], 0, 4 ) == '{{ !' ) {
					return '';
				}
				return $r;
			}, $content );

			$content = preg_replace_callback( '/{{ permalink3 }}|{{ ! permalink3 }}/', function( $matches ) use( &$permalink_replace3 ) {
				$r = array_shift( $permalink_replace3 );
				if ( substr( $matches[0], 0, 4 ) == '{{ !' ) {
					return '';
				}
				return $r;
			}, $content );

			$content = preg_replace_callback( '/{{ permalink4 }}|{{ ! permalink4 }}/', function( $matches ) use( &$permalink_replace4 ) {
				$r = array_shift( $permalink_replace4 );
				if ( substr( $matches[0], 0, 4 ) == '{{ !' ) {
					return '';
				}
				return $r;
			}, $content );
			
			$content = preg_replace_callback( '/{{ categories }}|{{ ! categories }}/', function( $matches ) use( &$categories_replace ) {
				$r = array_shift( $categories_replace );
				if ( substr( $matches[0], 0, 4 ) == '{{ !' ) {
					return '';
				}
				return $r;
			}, $content );
			
			$content = preg_replace_callback( '/{{ bg_image }}|{{ ! bg_image }}/', function( $matches ) use( &$post_bg_image_replace ) {
				$r = array_shift( $post_bg_image_replace );
				if ( substr( $matches[0], 0, 4 ) == '{{ !' ) {
					return '';
				}
				return $r;
			}, $content );
			
			$content = preg_replace_callback( '/{{ image }}|{{ ! image }}/', function( $matches ) use( &$post_image_replace ) {
				$r = array_shift( $post_image_replace );
				if ( substr( $matches[0], 0, 4 ) == '{{ !' ) {
					return '';
				}
				return $r;
			}, $content );
			
			$content = preg_replace_callback( '/{{ views_count }}|{{ ! views_count }}/', function( $matches ) use( &$views_count_replace ) {
				$r = array_shift( $views_count_replace );
				if ( substr( $matches[0], 0, 4 ) == '{{ !' ) {
					return '';
				}
				return $r;
			}, $content );
			
			$content = preg_replace_callback( '/{{ star_rating }}|{{ ! star_rating }}/', function( $matches ) use( &$star_rating_replace ) {
				$r = array_shift( $star_rating_replace );
				if ( substr( $matches[0], 0, 4 ) == '{{ !' ) {
					return '';
				}
				return $r;
			}, $content );
			
			$content = preg_replace_callback( '/{{ reading_time }}|{{ ! reading_time }}/', function( $matches ) use( &$reading_time_replace ) {
				$r = array_shift( $reading_time_replace );
				if ( substr( $matches[0], 0, 4 ) == '{{ !' ) {
					return '';
				}
				return $r;
			}, $content );
			
			$content = preg_replace_callback( '/{{ comments }}|{{ ! comments }}/', function( $matches ) use( &$comments_replace ) {
				$r = array_shift( $comments_replace );
				if ( substr( $matches[0], 0, 4 ) == '{{ !' ) {
					return '';
				}
				return $r;
			}, $content );
			
			$content = str_replace( "btSinglePostTemplateCount", "", $content );

		}

		$output = '<section ' . $id_attr . ' ' . $data_parallax_attr . ' class="' . implode( ' ', $class ) . '" ' . $style_attr . $back_video_attr . $data_anim_attr . $data_anim_back_attr . $data_anim_impress_attr . '>';
		$output .= $video_html;
			$output .= '<div class="port">';
				$output .= '<div class="boldCell">';
					$output .= '<div class="boldCellInner">';
					$output .= wptexturize( do_shortcode( $content ) );
					$output .= '</div>';
				$output .= '</div>';
		$output .= '</div>';

		$output .= '</section>';
		
		return $output;
	}
}

class YT_Video_Proxy {
	function __construct() {
		
	}	

	public function js_init() { ?>
		<script>
			jQuery(function() {
				jQuery( '.bt_yt_video' ).YTPlayer();
			});
		</script>
	<?php }
}

// [bt_post_container]
class bt_post_container {
	static function init() {
		add_shortcode( 'bt_post_container', array( __CLASS__, 'handle_shortcode' ) );
	}

	static function handle_shortcode( $atts, $content ) {
		
		extract( shortcode_atts( array(
			'posts_category'    => '',
			'posts_author'      => '',
			'show_prev'         => '',
			'show_sticky'       => '',
			'el_id'             => '',
			'el_class'          => '',
			'el_style'          => ''
		), $atts, 'bt_post_container' ) );
		
		$class = array( 'btPostContainer' );

		$id_attr = '';
		if ( $el_id != '' ) {
			$id_attr = 'id="' . $el_id . '"';
		}
		
		if ( $el_class != '' ) {
			$class[] = $el_class;
		}
		
		$style_attr = '';
		if ( $el_style != '' ) {
			$style_attr = 'style="' . $el_style . '"';
		}
		
		$content = do_shortcode( $content );
		$subposts = substr_count( $content, 'btSinglePostTemplateCount' );

		preg_match_all( '/image_size__(.*?)__/', $content, $image_size_matches );
		$image_size_matches = $image_size_matches[1];

		if ( $show_sticky == 'yes' ) {
			$show_sticky = true;
		} else {
			$show_sticky = false;
		}
		
		if ( $show_prev == 'yes' ) {
			$show_prev = true;
		} else {
			$show_prev = false;
		}
		
		global $bt_global_exclude_ids;

		if ( $show_prev ) {
			$bt_local_exclude_ids = array();
		} else {
			$bt_local_exclude_ids = $bt_global_exclude_ids;
		}

		if ( $subposts > 0 ) {

			$posts = boldthemes_get_template_posts_data( $subposts, 0, $posts_category, $bt_local_exclude_ids, $posts_author, $show_sticky, 'blog', $atts, 'bt_post_container' );
			
			//var_dump( $posts );

			$title_replace = array();
			$permalink_title_replace = array();
			$date_replace = array();
			$author_replace = array();
			$post_format_replace = array();
			$permalink_replace1 = array();
			$permalink_replace2 = array();
			$permalink_replace3 = array();
			$permalink_replace4 = array();
			$excerpt_replace = array();
			$categories_replace = array();
			$post_image_replace = array();
			$post_bg_image_replace = array();
			$reading_time_replace = array();
			$views_count_replace = array();
			$star_rating_replace = array();
			$comments_replace = array();
			$video_replace = array();
			$video_text_replace = array();

			$m = 0;
			foreach ( $posts as $item ) {
				
				if ( isset( $bt_global_exclude_ids ) && !in_array($item['ID'], $bt_global_exclude_ids) ) { 
					$bt_global_exclude_ids[] = $item['ID']; 
				}
				$title_replace[] = $item['title'];
				$permalink_title_replace[] = $item['title'];
				$date_replace[] = $item['date'];
				$author_replace[] = boldthemes_get_post_author_id( false, $item['ID']);
				$post_format_replace[] = $item['format'];
				$excerpt_replace[] = get_the_excerpt( $item['ID'] ); 
				$permalink_replace1[] = $item['permalink'];
				$permalink_replace2[] = $item['permalink'];
				$permalink_replace3[] = $item['permalink'];
				$permalink_replace4[] = $item['permalink'];
				$categories_replace[] = $item['category'];
				$post_image_replace_tmp = wp_get_attachment_image_src( get_post_thumbnail_id( $item['ID'] ), $image_size_matches[ $m ] );
				$post_image_replace[] = '<img src="' . $post_image_replace_tmp[0] . '" title="' . $item['title'] . '">';
				$post_bg_image_replace[] = $post_image_replace_tmp[0];
				$views_count_replace[] = bold_news_get_view_count( $item['ID'] );
				$star_rating_replace[] = boldthemes_get_post_star_rating( $item['ID'] );
				$reading_time_replace[] = bold_news_get_reading_time( $item['ID'] );
				$comments_replace[] = "<span class='btArticleComments'>" . $item['comments'] . "</span>";
				$video_replace[] = $item['video'] != '' ? '<div class="btMediaBoxPopup"><div class="btMediaBoxPopupClose"></div>' . boldthemes_get_media_html( 'video_frame_data_src', array( $item['video'] ) ) . '</div>' : '';
				$video_text_replace[] = $item['video'] != '' ? '<span class="btVideoPopupText">' . __( 'Play video', 'bt_plugin' ) . '</span>' : '';

				$m++;
			}

			$content = preg_replace_callback( '/{{ video_player }}/', function() use( &$video_replace ) {
				return array_shift( $video_replace );
			}, $content );

			$content = preg_replace_callback( '/{{ video_player_text }}/', function() use( &$video_text_replace ) {
				return array_shift( $video_text_replace );
			}, $content );

			$content = preg_replace_callback( '/{{ title }}/', function() use( &$title_replace ) {
				return array_shift( $title_replace );
			}, $content );
			
			$content = preg_replace_callback( '/{{ permalink_title }}/', function() use( &$permalink_title_replace ) {
				return array_shift( $permalink_title_replace );
			}, $content );

			$content = preg_replace_callback( '/{{ date }}|{{ ! date }}/', function( $matches ) use( &$date_replace ) {
				$r = array_shift( $date_replace );
				if ( substr( $matches[0], 0, 4 ) == '{{ !' ) {
					return '';
				}
				return $r;
			}, $content );
			
			$content = preg_replace_callback( '/{{ author }}|{{ ! author }}/', function( $matches ) use( &$author_replace ) {
				$r = array_shift( $author_replace );
				if ( substr( $matches[0], 0, 4 ) == '{{ !' ) {
					return '';
				}
				return $r;
			}, $content );
			
			$content = preg_replace_callback( '/{{ post_format }}|{{ ! post_format }}/', function( $matches ) use( &$post_format_replace ) {
				$r = array_shift( $post_format_replace );
				if ( substr( $matches[0], 0, 4 ) == '{{ !' ) {
					return '';
				}
				return $r;
			}, $content );

			$content = preg_replace_callback( '/{{ excerpt }}|{{ ! excerpt }}/', function( $matches ) use( &$excerpt_replace ) {
				$r = array_shift( $excerpt_replace );
				if ( substr( $matches[0], 0, 4 ) == '{{ !' ) {
					return '';
				}
				return $r;
			}, $content );

			$content = preg_replace_callback( '/{{ permalink1 }}|{{ ! permalink1 }}/', function( $matches ) use( &$permalink_replace1 ) {
				$r = array_shift( $permalink_replace1 );
				if ( substr( $matches[0], 0, 4 ) == '{{ !' ) {
					return '';
				}
				return $r;
			}, $content );

			$content = preg_replace_callback( '/{{ permalink2 }}|{{ ! permalink2 }}/', function( $matches ) use( &$permalink_replace2 ) {
				$r = array_shift( $permalink_replace2 );
				if ( substr( $matches[0], 0, 4 ) == '{{ !' ) {
					return '';
				}
				return $r;
			}, $content );

			$content = preg_replace_callback( '/{{ permalink3 }}|{{ ! permalink3 }}/', function( $matches ) use( &$permalink_replace3 ) {
				$r = array_shift( $permalink_replace3 );
				if ( substr( $matches[0], 0, 4 ) == '{{ !' ) {
					return '';
				}
				return $r;
			}, $content );

			$content = preg_replace_callback( '/{{ permalink4 }}|{{ ! permalink4 }}/', function( $matches ) use( &$permalink_replace4 ) {
				$r = array_shift( $permalink_replace4 );
				if ( substr( $matches[0], 0, 4 ) == '{{ !' ) {
					return '';
				}
				return $r;
			}, $content );
			
			$content = preg_replace_callback( '/{{ categories }}|{{ ! categories }}/', function( $matches ) use( &$categories_replace ) {
				$r = array_shift( $categories_replace );
				if ( substr( $matches[0], 0, 4 ) == '{{ !' ) {
					return '';
				}
				return $r;
			}, $content );
			
			$content = preg_replace_callback( '/{{ bg_image }}|{{ ! bg_image }}/', function( $matches ) use( &$post_bg_image_replace ) {
				$r = array_shift( $post_bg_image_replace );
				if ( substr( $matches[0], 0, 4 ) == '{{ !' ) {
					return '';
				}
				return $r;
			}, $content );
			
			$content = preg_replace_callback( '/{{ image }}|{{ ! image }}/', function( $matches ) use( &$post_image_replace ) {
				$r = array_shift( $post_image_replace );
				if ( substr( $matches[0], 0, 4 ) == '{{ !' ) {
					return '';
				}
				return $r;
			}, $content );
			
			$content = preg_replace_callback( '/{{ views_count }}|{{ ! views_count }}/', function( $matches ) use( &$views_count_replace ) {
				$r = array_shift( $views_count_replace );
				if ( substr( $matches[0], 0, 4 ) == '{{ !' ) {
					return '';
				}
				return $r;
			}, $content );
			
			$content = preg_replace_callback( '/{{ star_rating }}|{{ ! star_rating }}/', function( $matches ) use( &$star_rating_replace ) {
				$r = array_shift( $star_rating_replace );
				if ( substr( $matches[0], 0, 4 ) == '{{ !' ) {
					return '';
				}
				return $r;
			}, $content );
			
			$content = preg_replace_callback( '/{{ reading_time }}|{{ ! reading_time }}/', function( $matches ) use( &$reading_time_replace ) {
				$r = array_shift( $reading_time_replace );
				if ( substr( $matches[0], 0, 4 ) == '{{ !' ) {
					return '';
				}
				return $r;
			}, $content );
			
			$content = preg_replace_callback( '/{{ comments }}|{{ ! comments }}/', function( $matches ) use( &$comments_replace ) {
				$r = array_shift( $comments_replace );
				if ( substr( $matches[0], 0, 4 ) == '{{ !' ) {
					return '';
				}
				return $r;
			}, $content );
			
			$content = str_replace( "btSinglePostTemplateCount", "", $content );

		}

		$output = '<div ' . $id_attr . ' ' . ' class="' . implode( ' ', $class ) . '" ' . $style_attr . '>';
			$output .= wptexturize( do_shortcode( $content ) );
		$output .= '</div>';
		
		return $output;
	}
}

// [bt_row]
class bt_row {
	static function init() {
		add_shortcode( 'bt_row', array( __CLASS__, 'handle_shortcode' ) );
	}

	static function handle_shortcode( $atts, $content ) {
		extract( shortcode_atts( array(
			'cell_spacing'     	=> '',
			'el_class'  	    => '',
			'el_style'  		=> ''
		), $atts, 'bt_row' ) );
		
		$cell_spacing = sanitize_text_field( $cell_spacing );
		$el_class = sanitize_text_field( $el_class );
		$el_style = sanitize_text_field( $el_style );
		
		$style_attr = '';
		if ( $el_style != '' ) {
			$style_attr = 'style="' . $el_style . '"';
		}
		if ( $cell_spacing != '' ) {
			$el_class .= ' ' . $cell_spacing;
		}
	
		$output = '<div class="boldRow ' . $el_class . '" ' . $style_attr . '>';
		$output .= '<div class="boldRowInner">';
		$output .= wptexturize( do_shortcode( $content ) );
		$output .= '</div>';
		$output .= '</div>';
		
		return $output;
	}
}

// [bt_row_inner]
class bt_row_inner {
	static function init() {
		add_shortcode( 'bt_row_inner', array( __CLASS__, 'handle_shortcode' ) );
	}

	static function handle_shortcode( $atts, $content ) {
		extract( shortcode_atts( array(
			'cell_spacing'     	=> '',
			'el_class'  	     => '',
			'el_style'  		 => ''
		), $atts, 'bt_row_inner' ) );
		
		$cell_spacing = sanitize_text_field( $cell_spacing );
		$el_class = sanitize_text_field( $el_class );
		$el_style = sanitize_text_field( $el_style );
		
		$style_attr = '';
		if ( $el_style != '' ) {
			$style_attr = 'style="' . $el_style . '"';
		}
		if ( $cell_spacing != '' ) {
			$el_class .= ' ' . $cell_spacing;
		}
	
		$output = '<div class="boldRow ' . $el_class . '" ' . $style_attr . '>';
		$output .= '<div class="boldRowInner">';
		$output .= wptexturize( do_shortcode( $content ) );
		$output .= '</div>';
		$output .= '</div>';
		
		return $output;
	}
}

// [bt_column_inner]
class bt_column_inner {
	static function init() {
		add_shortcode( 'bt_column_inner', array( __CLASS__, 'handle_shortcode' ) );
	}

	static function handle_shortcode( $atts, $content ) {
		extract( shortcode_atts( array(
			'width'    		   => '',
			'align'   		   => '',
			'vertical_align'   => '',
			'cell_padding'     => '',
			'highlight'		   => '',
			'animation'		   => '',
			'background_color' => '',
			'opacity'	       => '', 
			'el_class' 		   => '',
			'el_style'		   => ''
		), $atts, 'bt_column_inner' ) );
		
		$class = array( 'rowItem rowInnerItem' );
		
		$array = explode( '/', $width );

		if ( empty( $array ) || $array[0] == 0 || $array[1] == 0 ) {
			$width = 12;
		} else {
			$top = $array[0];
			$bottom = $array[1];
			
			$width = 12 * $top / $bottom;
			
			if ( ! is_int( $width ) || $width < 1 || $width > 12 ) {
				$width = 12;
			}
		}
		
		/*if ( $width == 2 ) {
			$class[] = 'col-md-2  col-sm-4 col-ms-12';
		} else if ( $width == 3 ) {
			$class[] = 'col-md-3 col-sm-6 col-ms-12';
		} else if ( $width == 4 ) {
			$class[] = 'col-sm-4 col-ms-12';
		} else if ( $width == 6 ) {
			$class[] = 'col-sm-6 col-ms-12';	
		} else {
			$class[] = 'col-md-' . $width . ' col-ms-12 ';
		}*/

		$class[] = 'col-sm-' . $width . ' ';
		
		if ( $align == 'left' || $align == '' || $align == 'inherit' ) {
			$class[] = 'btTextLeft';
		} else if ( $align == 'right' ) {
			$class[] = 'btTextRight';
		} else if ( $align == 'center' ) {
			$class[] = 'btTextCenter';
		}

		if ( $highlight != 'no_highlight' && $highlight != '' ) {
			$class[] = $highlight;
		}	

		if ( $vertical_align != 'Inherit' && $vertical_align != '' ) {
			$class[] = $vertical_align;
		}		

		if ( $cell_padding != 'default' && $cell_padding != '' ) {
			$class[] = $cell_padding;
		}

		if ( $animation != 'no_animation' && $animation != '' ) {
			$class[] = $animation;
		}
		
		if ( $el_class != '' ) {
			$class[] = $el_class;
		}
		
		if ( $opacity == '' ) {
			$opacity = 1;
		}		
		
		if ( $background_color != '' ) {
			$background_color = bt_column::hex2rgb( $background_color );
			if ( $opacity == '' ) $opacity = '1';
			$el_style .= 'background-color: rgba(' . $background_color[0] . ', ' . $background_color[1] . ', ' . $background_color[2] . ', ' . $opacity . ');';
		}		

		$style_attr = '';

		if ( $el_style != '' ) {
			$style_attr = 'style="' . $el_style . '"';
		}

		$output = '<div class="' . implode( ' ', $class ) . '" ' . $style_attr . ' >';  
			$output .= '<div class="rowItemContent">';
				$output .= wptexturize( do_shortcode( $content ) );
			$output .= '</div>';
		$output .= '</div>';
		
		return $output;
	}
}

// [bt_column]
class bt_column {
	static function init() {
		add_shortcode( 'bt_column', array( __CLASS__, 'handle_shortcode' ) );
	}
	
	static function hex2rgb($hex) {
		$hex = str_replace("#", "", $hex);
	
		if(strlen($hex) == 3) {
			$r = hexdec(substr($hex,0,1).substr($hex,0,1));
			$g = hexdec(substr($hex,1,1).substr($hex,1,1));
			$b = hexdec(substr($hex,2,1).substr($hex,2,1));
		} else {
			$r = hexdec(substr($hex,0,2));
			$g = hexdec(substr($hex,2,2));
			$b = hexdec(substr($hex,4,2));
		}
		$rgb = array($r, $g, $b);
		//return implode(",", $rgb); // returns the rgb values separated by commas
		return $rgb; // returns an array with the rgb values
	}

	static function handle_shortcode( $atts, $content ) {
		extract( shortcode_atts( array(
			'width'    		   => '',
			'align'   		   => '', // inherit/left/right/center
			'animation'		   => '', // no_animation/...
			'vertical_align'   => '', // inherit/top/middle/bottom
			'border'           => '',
			'cell_padding'     => '', 
			'highlight'		   => '', 
			'background_image' => '', 
			'background_color' => '', 
			'inner_background_color' => '',
			'transparent'	   => '', 
			'el_class' 		   => '',
			'el_style'		   => ''
		), $atts, 'bt_column' ) );
		
		$width = sanitize_text_field( $width );
		$align = sanitize_text_field( $align );
		$animation = sanitize_text_field( $animation );
		$vertical_align = sanitize_text_field( $vertical_align );
		$border = sanitize_text_field( $border );
		$cell_padding = sanitize_text_field( $cell_padding );
		$highlight = sanitize_text_field( $highlight );
		$background_image = sanitize_text_field( $background_image );
		$background_color = sanitize_text_field( $background_color );
		$inner_background_color = sanitize_text_field( $inner_background_color );
		$transparent = sanitize_text_field( $transparent );
		$el_class = sanitize_text_field( $el_class );
		$el_style = sanitize_text_field( $el_style );
		$inner_el_style = '';
		
		$class = array( 'rowItem' );
		
		if ( $border == 'btLeftBorder' || $border == 'btRightBorder' ) {
			$class[] = $border;
		}
		
		$array = explode( '/', $width );

		if ( empty( $array ) || $array[0] == 0 || $array[1] == 0 ) {
			$width = 12;
		} else {
			$top = $array[0];
			$bottom = $array[1];
			
			$width = 12 * $top / $bottom;
			
			if ( ! is_int( $width ) || $width < 1 || $width > 12 ) {
				$width = 12;
			}
		}
		
		if ( $width == 2 ) {
			$class[] = 'col-md-2  col-sm-4 col-ms-12';
		} else if ( $width == 3 ) {
			$class[] = 'col-md-3 col-sm-6 col-ms-12';
		} else if ( $width == 4 ) {
			$class[] = 'col-md-4 col-ms-12';
		} else if ( $width == 6 ) {
			$class[] = 'col-md-6 col-sm-12';	
		} else if ( $width == 8 ) {
			$class[] = 'col-md-8 col-ms-12';
		} else {
			$class[] = 'col-md-' . $width . ' col-ms-12 ';
		}
		
		if ( $align == 'left' || $align == '' || $align == 'inherit' ) {
			$class[] = 'btTextLeft';
		} else if ( $align == 'right' ) {
			$class[] = 'btTextRight';
		} else if ( $align == 'center' ) {
			$class[] = 'btTextCenter';
		}
		
		if ( $animation != 'no_animation' && $animation != '' ) {
			$class[] = $animation;
		}			
		
		if ( $highlight != 'no_highlight' && $highlight != '' ) {
			$class[] = $highlight;
		}	

		if ( $vertical_align != 'Inherit' && $vertical_align != '' ) {
			$class[] = $vertical_align;
		}		

		if ( $cell_padding != 'default' && $cell_padding != '' ) {
			$class[] = $cell_padding;
		}	
		
		if ( $el_class != '' ) {
			$class[] = $el_class;
		}
				
		if ( $transparent == '' ) {
			$transparent = 1;
		}

		if ( $background_image != '' ) {
			$image = wp_get_attachment_image_src( $background_image, 'full' );
			$image = $image[0];
			if ( $highlight == 'no_highlight' || $highlight == '' ) {
				$el_style .= 'background-image: url(' . $image . ');';
				$class[] = 'wBackground cover';
			} else {
				$inner_el_style .= 'background-image: url(' . $image . '); ';
			}
		}	
		
		if ( $background_color != '' ) {
			$background_color = bt_column::hex2rgb( $background_color );
			if ( $transparent == '' ) $transparent = '1';
			$el_style .= 'background-color: rgba(' . $background_color[0] . ', ' . $background_color[1] . ', ' . $background_color[2] . ', ' . $transparent . '); ';
		}

		$style_attr = '';

		if ( $el_style != '' ) {
			$style_attr = 'style="' . $el_style . '"';
		}
		
		if ( $el_style != '' ) {
			$style_attr = 'style="' . $el_style . '"';
		}

		
		if ( $inner_background_color != '' ) {
			$inner_background_color = bt_column::hex2rgb( $inner_background_color );
			if ( $transparent == '' ) $transparent = '1';
			$inner_el_style .= 'background-color: rgba(' . $inner_background_color[0] . ', ' . $inner_background_color[1] . ', ' . $inner_background_color[2] . ', ' . $transparent . '); ';
		}
		
		if ( $inner_el_style != '' ) {
			$inner_el_style = 'style = "' . $inner_el_style . '"';
		}

		$output = '<div class="' . implode( ' ', $class ) . '" ' . $style_attr . ' data-width="' . $width . '">';  
			$output .= '<div class="rowItemContent" ' . $inner_el_style . '>';
				$output .= wptexturize( do_shortcode( $content ) );
			$output .= '</div>';
		$output .= '</div>';
		
		return $output;
	}
}


// [bt_custom_menu]
class bt_custom_menu {
	static function init() {
		add_shortcode( 'bt_custom_menu', array( __CLASS__, 'handle_shortcode' ) );
	}

	static function handle_shortcode( $atts, $content ) {
		extract( shortcode_atts( array(
			'menu'  			=> '',	
			'el_class'  	     => '',
			'el_style'  		 => ''
		), $atts, 'bt_row' ) );
		
		$menu = sanitize_text_field( $menu );
		$el_class = sanitize_text_field( $el_class );
		$el_style = sanitize_text_field( $el_style );
		
		$style_attr = '';
		if ( $el_style != '' ) {
			$style_attr = 'style="' . $el_style . '"';
		}

		if ( $menu != '' ) {
			$output = '<div class="btCustomMenu ' . $el_class . '" ' . $style_attr . '>';
			// $output .= wptexturize( do_shortcode( $content ) );
			$output .= wp_nav_menu( array( 'menu' => $menu, 'echo' => false ) );
			$output .= '</div>';
		}
		
		return $output;
	}
}

// [bt_text]
class bt_text {
	static function init() {
		add_shortcode( 'bt_text', array( __CLASS__, 'handle_shortcode' ) );
	}

	static function handle_shortcode( $atts, $content ) {
		extract( shortcode_atts( array(
			'el_class' 			=> '',
			'el_style'			=> ''
		), $atts, 'bt_text' ) );
		
		$el_class = sanitize_text_field( $el_class );
		$el_style = sanitize_text_field( $el_style );

		$style_attr = '';
		if ( $el_style != '' ) {
			$style_attr = 'style="' . $el_style . '"';
		}
		
		if ( strpos( $content, '[' ) == 0 && substr( $content, -1 ) == ']' ) {
			$output = '<div class="btText" ' . $style_attr . '>' . do_shortcode( $content ) . '</div>';
		} else {
			$output = '<div class="btText" ' . $style_attr . '>' . wptexturize( wpautop ( do_shortcode( $content ) ) ) . '</div>';
		}

		return $output;
	}
}

// [bt_header]
class bt_header {
	static function init() {
		add_shortcode( 'bt_header', array( __CLASS__, 'handle_shortcode' ) );
	}

	static function handle_shortcode( $atts, $content ) {
		extract( shortcode_atts( array(
			'superheadline'		=> '',
			'headline'			=> '',
			'headline_size'		=> '', // small/medium/large/extralarge/huge
			'headline_style'	=> '', // regular/thin/bold
			'dash'				=> '', // no/top/bottom
			'subheadline'		=> '', 
			'el_class' 			=> '',
			'el_style'			=> ''
		), $atts, 'bt_header' ) );
		
		$superheadline = str_replace( "\n", '<br>', $superheadline );
		$headline = str_replace( "\n", '<br>', $headline );
		$subheadline = str_replace( "\n", '<br>', $subheadline );
		$el_class .= " " . $headline_style; 
	
		return boldthemes_get_heading_html( $superheadline, $headline, $subheadline, $headline_size, $dash, $el_class, $el_style );
	}
}

// [bt_tabs]
class bt_tabs {
	static function init() {
		add_shortcode( 'bt_tabs', array( __CLASS__, 'handle_shortcode' ) );
	}
	
	static function handle_shortcode( $atts, $content ) {
	
		$content = do_shortcode( $content );
		$content = explode( '%$%', $content );	
		
		$output = '<div class="btTabs tabsHorizontal">';
			$output .='<ul class="tabsHeader">';
				for ( $i = 0; $i < count( $content ); $i = $i + 2 ) {
					$output .= wptexturize( $content[ $i ] );
				}
			$output .='</ul>';
			$output .='<div class="tabPanes tabPanesTabs">';
				for ( $i = 1; $i < count( $content ); $i = $i + 2 ) {
					$output .= wptexturize( $content[ $i ] );
				}
			$output .='</div>';
		$output .='</div>';
			
		return $output;
	}
}
class bt_tabs_proxy {
	function __construct() {
	}	
}

// [bt_tabs_items]
class bt_tabs_items {
	static function init() {
		add_shortcode( 'bt_tabs_items', array( __CLASS__, 'handle_shortcode' ) );
	}

	static function handle_shortcode( $atts, $content ) {
		extract( shortcode_atts( array(
			'headline'	=> '',
		), $atts, 'bt_tabs_items' ) );

		$headline = sanitize_text_field( $headline );

		$output1 = '<li><span>' . $headline . '</span></li>';
		
		/*$output2 = '<div class="tabPane">
			<div class="tabAccordionContent">' . wptexturize( wpautop( $content ) ) . '</div>
		</div>';*/

		$output2 = '<div class="tabPane">
			<div class="tabAccordionContent">' . wptexturize( do_shortcode( $content ) ) . '</div>
		</div>';
		
		return $output1 . '%$%' . $output2 . '%$%';

	}
}

// [bt_accordion]
class bt_accordion {
	static function init() {
		add_shortcode( 'bt_accordion', array( __CLASS__, 'handle_shortcode' ) );
	}

	static function handle_shortcode( $atts, $content ) {
	
		$content = do_shortcode( $content );
		$content = explode( '%$%', $content );	

		$output = '<div class="btTabs tabsVertical">';
			$output .= '<ul class="tabsHeader">';
				for ( $i = 0; $i < count( $content ); $i = $i + 2 ) {
					$output .= wptexturize( $content[ $i ] );
				}
			$output .= '</ul>';
			$output .= '<div class="tabPanes accordionPanes">';
				for ( $i = 1; $i < count( $content ); $i = $i + 2 ) {
					$output .= wptexturize( $content[ $i ] );
				}
			$output .= '</div>';
		$output .= '</div>';

		$proxy = new bt_accordion_proxy();
		add_action( 'wp_footer', array( $proxy, 'js_init' ) );
		
		return $output;
	}
}
class bt_accordion_proxy {
	function __construct() {
	}	

	public function js_init() { ?>
		
	<?php }
}

// [bt_accordion_items]
class bt_accordion_items {
	static function init() {
		add_shortcode( 'bt_accordion_items', array( __CLASS__, 'handle_shortcode' ) );
	}

	static function handle_shortcode( $atts, $content ) {
		extract( shortcode_atts( array(
				'headline'	=> '',
		), $atts, 'bt_accordion_items' ) );

		$headline = sanitize_text_field( $headline );

		$output1 = '<li><span>' . $headline . '</span></li>';
		
		/* $output2 = '<div class="tabPane">
			<div class="tabAccordionTitle"><span>' . $headline . '</span></div>
			<div class="tabAccordionContent">' . wptexturize ( wpautop( $content ) ) . '</div>
		</div>';*/

		$output2 = '<div class="tabPane">
			<div class="tabAccordionTitle"><span>' . $headline . '</span></div>
			<div class="tabAccordionContent">' . wptexturize( do_shortcode( $content ) ) . '</div>
		</div>';
		
		return $output1 . '%$%' . $output2 . '%$%';

	}
}

// [bt_service]
class bt_service {
	static function init() {
		add_shortcode( 'bt_service', array( __CLASS__, 'handle_shortcode' ) );
	}

	static function handle_shortcode( $atts, $content ) {
		extract( shortcode_atts( array(
			'icon'      => '',
			'icon_type' => '',
			'icon_shape' => '',
			'icon_size' => '',
			'icon_color' => '',
			'url'       => '',
			'headline'  => '',
			'dash'		=> '',
			'text'      => '',
			'el_style'  => '',
			'el_class'  => ''
		), $atts, 'bt_service' ) );
		
		$icon = sanitize_text_field( $icon );
		$icon_type = sanitize_text_field( $icon_type );
		$icon_shape = sanitize_text_field( $icon_shape );
		$icon_size = sanitize_text_field( $icon_size );
		$icon_color = sanitize_text_field( $icon_color );
		$url = sanitize_text_field( $url );
		$headline = sanitize_text_field( $headline );
		$dash = sanitize_text_field( $dash );
		$el_style = sanitize_text_field( $el_style );
		$el_class = sanitize_text_field( $el_class );

		$style_attr = '';
		if ( $el_style != '' ) {
			$style_attr = ' style="' . $el_style . '"';
		}
		
		if (strpos($text, PHP_EOL) !== false) {
			$text = str_replace( "\n", '<br/>', $text ) ;
		}
		
		$output = '<div class="servicesItem ' . ' ' . $icon_color . 'Icon ' . $icon_size . 'Icon ' . $el_class . '"' . $style_attr . '>';
			$output .= '<div class="sIcon">';
				$output .= boldthemes_get_icon_html( $icon, $url, '', $icon_size . ' ' . $icon_type . ' ' . $icon_color . ' ' . $icon_shape );
			$output .= '</div>';
			if ( $headline != '' || $text != '') {
				$output .= '<div class="sTxt">';
					$output .= boldthemes_get_heading_html( '', $headline, $text , 'small', $dash, '', '' ) ;
				$output .= '</div>';
			}

		$output .= '</div>';
		
		return $output;
	}
}

// [bt_gmaps]
class bt_gmaps {
	static function init() {
		add_shortcode( 'bt_gmaps', array( __CLASS__, 'handle_shortcode' ) );
	}

	static function handle_shortcode( $atts, $content ) {
	
		extract( shortcode_atts( array(
			'api_key'   		=> '',
			'latitude'  		=> '',
			'longitude' 		=> '',
			'zoom'      		=> '',
			'icon'      		=> '',
			'height'    		=> '',
			'primary_color'    	=> '',
			'secondary_color'	=> '',
			'custom_style'    	=> '',
			'water_color'    	=> '',
			'el_style'  		=> '',
			'el_class'  		=> ''
		), $atts, 'bt_gmaps' ) );
		
		$latitude = sanitize_text_field( $latitude );
		$longitude = sanitize_text_field( $longitude );
		$zoom = sanitize_text_field( $zoom );
		$icon = sanitize_text_field( $icon );
		$height = sanitize_text_field( $height );
		$primary_color = sanitize_text_field( $primary_color );
		$secondary_color = sanitize_text_field( $secondary_color );
		$water_color = sanitize_text_field( $water_color );
		$el_style = sanitize_text_field( $el_style );
		$el_class = sanitize_text_field( $el_class );
		
		if ( $api_key != '' ) {
			wp_enqueue_script( 
				'gmaps_api',
				'https://maps.googleapis.com/maps/api/js?key=' . $api_key
			);
		} else {
			wp_enqueue_script( 
				'gmaps_api',
				'https://maps.googleapis.com/maps/api/js?v=&sensor=false'
			);
		}

		wp_enqueue_script( 
			'bt_gmap_init',
			plugin_dir_url( __FILE__ ) . 'bt_gmap.js',
			array( 'jquery' ),
			'',
			true
		);
		
		if ( $zoom == '' ) $zoom = 14;
		if ( $height == '' ) $height = '250px';

		$icon_img = '""';
		if ( $icon != '' ) {
			$icon_tmp = wp_get_attachment_image_src( $icon, 'small' );
			$icon_img = '"' . $icon_tmp[0] . '"';
		}
		
		if ( $el_class != '' ) {
			$el_class = ' ' . $el_class;
		}
		
		$map_id = uniqid( 'map_canvas' );
			
		if ( $content != '' ) {
			$content = '<div class="btGoogleMapsContent port"><div class="btGoogleMapsWrap">' . wptexturize( do_shortcode( $content ) ) . '</div></div>';
			$el_class = 'btGoogleMapsContainerWithContent ' . $el_class;
		}

		return '
		<div class="btGoogleMapsWrapper gutter"><div class="btGoogleMapsContainer ' . $el_class . '" id="' . $map_id . '" style="height:' . $height . ';' . $el_style . ';" ></div>' . $content . '</div>
		<script type="text/javascript">
			jQuery( document ).ready(function() {
				bt_gmap_init( ' . $map_id . ', ' . $latitude . ', ' . $longitude . ', ' . $zoom . ', ' . $icon_img . ', "' . $primary_color . '", "' . $secondary_color . '", "' . $water_color . '", "' . $custom_style . '" );
			});	
		</script>
		';
	}
}

// [bt_clients]
class bt_clients {
	static function init() {
		add_shortcode( 'bt_clients', array( __CLASS__, 'handle_shortcode' ) );
	}

	static function handle_shortcode( $atts, $content ) {
		extract( shortcode_atts( array(
			'loop_type' 			=> '',
			'slides'	   			=> '6',
			'slides_padding'		=> '',
			'arrow_position'		=> '',
			'auto_play'    			=> '',
			'el_class'            	=> '',
			'el_style'  		 	=> ''
		), $atts, 'bt_clients' ) );
		
		$slick_data = '';
		$auto_play = intval( $auto_play );
		$slick_data = ' ' . "data-slick='{\"pauseOnHover\":true,\"pauseOnDotsHover\":true";
		if ( $auto_play > 0 ) {
			$slick_data .=  ",\"autoplay\":true,\"autoplaySpeed\":" . $auto_play ;
		}
		if ( $loop_type == 'infinite' ) {
			$slick_data .=  ",\"infinite\":true" ;
		}
		if ( is_rtl() ) {
			$slick_data .=  ",\"rtl\":true" ;
		}
		$slick_data .=  "}'";
		
		$style = '';
		if ( $el_style != '' ) {
			$style = ' ' . 'style="' . $el_style . '"';
		}

		$arrow_position = ' ' . $arrow_position . 'Arrow';

		if ( is_rtl() ) {
			$is_rtl_data = ' data-rtl="yes"';
		}else{
			$is_rtl_data = ' data-rtl="no"';
		}
	
		$output = '<div class="' . $el_class . ' btCarouselSmallNav boldClientList ' . $slides_padding .  $arrow_position . '"' . $style . '>';
			$output .= '<div class="bclPort" data-slides="' . $slides . '"'. $slick_data  . $is_rtl_data . '>';
				$output .= wptexturize( do_shortcode( $content ) );
			$output .= '</div>';
		$output .= '</div>';
		
		return $output;
	}
}

// [bt_client]
class bt_client {
	static function init() {
		add_shortcode( 'bt_client', array( __CLASS__, 'handle_shortcode' ) );
	}

	static function handle_shortcode( $atts, $content ) {
		extract( shortcode_atts( array(
			'el_class'            	=> '',
			'el_style'  		 	=> ''
		), $atts, 'bt_client' ) );
		
		$style = '';
		if ( $el_style != '' ) {
			$style = ' ' . 'style="' . $el_style . '"';
		}
		
		$output = '<div class="bclItem' . ' ' . $el_class . '"' . $style . '>';
			$output .= '<div class="bclItemChild">';
				$output .= '<div class="bclItemChildContent">' . wptexturize( do_shortcode( $content ) ) . '</div>';
			$output .= '</div>';
		$output .= '</div>';
		
		return $output;
	}
}

// [bt_twitter]
class bt_twitter {
	static function init() {
		add_shortcode( 'bt_twitter', array( __CLASS__, 'handle_shortcode' ) );
	}

	static function handle_shortcode( $atts, $content ) {
		extract( shortcode_atts( array(
			'number'              => '',
			'cache'               => '',
			'cache_id'            => '',
			'username'            => '',
			'show_avatar'         => '',
			'consumer_key'        => '',
			'consumer_secret'     => '',
			'access_token'        => '',
			'access_token_secret' => '',
			'display_type'        => '',
			'el_class'            => '',
			'el_style'            => ''
		), $atts, 'bt_twitter' ) );

		if ( $display_type == 'regular' ) {
			$extra_class = 'boldClientRegularList';
			$inner_class = '';
		} else {
			$extra_class = 'boldClientList btCarouselSmallNav';
			$inner_class = 'bclPort';
		}
		
		$style = '';
		if ( $el_style != '' ) {
			$style = ' ' . 'style="' . $el_style . '"';
		}
		
		$twitter_data = bt_get_twitter_data( $number, $cache, $cache_id, $username, $consumer_key, $consumer_secret, $access_token, $access_token_secret );
		
		$output = '<div class="recentTweets ' . $extra_class . ' ' . $el_class . '"' . $style . '>';
			$output .= '<div class="' . $inner_class . '">';
				foreach ( $twitter_data as $data ) {
					$user =  $data->user->screen_name;
					$profile_link = 'https://twitter.com/' . $user ;
					$link = 'https://twitter.com/' . $user . '/status/' . $data->id_str;
					$text = mb_convert_encoding( utf8_encode( $data->text ), 'HTML-ENTITIES', 'UTF-8' );
					$time = human_time_diff( strtotime( $data->created_at ) );

					$output .= '<div class="bclItem">';
						if( $show_avatar == 'yes' ) {
							$output .= '<a href="' . esc_url( $profile_link ) . '" target="_blank"><img src="https://twitter.com/' . $user . '/profile_image?size=normal" class="btClear"/></a>';
						}
						$output .= '<small><a href="' . esc_url( $link ) . '" target="_blank">@' . $user . ' - ' . $time . '</a></small>';
						$output .= '<p>' . BT_Twitter_Widget::parse( $data->text ) . '</p>';
					$output .= '</div>';
				}
			$output .= '</div>';
		$output .= '</div>';
		
		return $output;
	}
}

// [bt_button]
class bt_button {
	static function init() {
		add_shortcode( 'bt_button', array( __CLASS__, 'handle_shortcode' ) );
	}

	static function handle_shortcode( $atts, $content ) {
		extract( shortcode_atts( array(
			'text'				=> '',
			'icon'				=> '',
			'url'				=> '',
			'target'			=> '',
			'style'				=> '',
			'icon_position'		=> '',
			'color'				=> '',
			'size'				=> '',
			'width'				=> '',
			'el_style'			=> '',
			'el_class'			=> ''			
		), $atts, 'bt_button' ) );
		
		$text = sanitize_text_field( $text );
		$icon = sanitize_text_field( $icon );
		$url = sanitize_text_field( $url );
		$target = sanitize_text_field( $target );
		$style = sanitize_text_field( $style );
		$icon_position = sanitize_text_field( $icon_position );
		$color = sanitize_text_field( $color );
		$size = sanitize_text_field( $size );
		$width = sanitize_text_field( $width );
		$el_style = sanitize_text_field( $el_style );
		$el_class = sanitize_text_field( $el_class );		
		
		$class = array( 'btBtn' );
		
		if ( $style != '' ) {
			$class[] = 'btn'.$style.'Style';
		}

		if ( $color != '' ) {
			$class[] = 'btn'.$color.'Color';
		}
		 
		if ( $size != '' ) {
			$class[] = 'btn'.$size;
		} 
		
		if ( $width != '' ) {
			$class[] = 'btn'.$width.'Width';
		}

		if ( $el_class != '' ) {
			$class[] = $el_class;
		}

		if ( $icon_position == '' ) {
			$icon_position = 'Right';
		}
		$class[] = 'btn'.$icon_position.'Position';

		if ( $icon != '' && $icon != 'no_icon' ) {
			$class[] = 'btnIco';
		}
			
		if ( $url == '' ) {
			$url = '#';
		}

		if ( $target != 'no_target' ) {
			$target = ' ' . 'target="' . $target . '"';
		} else {
			$target= '';
		}

		return boldthemes_get_button_html( $icon, $url, $text, $class, $el_style, $target );

	}
}

// [bt_counter]
class bt_counter {
	static function init() {
		add_shortcode( 'bt_counter', array( __CLASS__, 'handle_shortcode' ) );
	}
	
	static function handle_shortcode( $atts, $content ) {
		extract( shortcode_atts( array(
			'number'			=> '',
			'size'				=> '',
			'el_style'			=> '',
			'el_class'			=> ''
		), $atts, 'bt_counter' ) );

		$number = sanitize_text_field( $number );
		$size = sanitize_text_field( $size );
		$el_style = sanitize_text_field( $el_style );
		$el_class = sanitize_text_field( $el_class );

		$style_attr = '';
		if ( $el_style != '' ) {
			$style_attr = ' style="' . $el_style . '"';
		}

		$el_class .= " " . $size;

		$output = '';
		$output .= '<div class="btCounterHolder ' . $el_class . '"' . $style_attr . '>';
		$output .= '<span class="btCounter animate" data-digit-length="' . strlen( $number ) . '">';
		
		for ( $i = 0; $i < strlen( $number ); $i++ ) {
			
			$output .= '<span class="onedigit p' . ( strlen( $number ) - $i ) . ' d' . $number[ $i ] . '" data-digit="' . $number[ $i ] . '">';
			
				if ( ctype_digit( $number[ $i ] ) ) {
					for ( $j = 0; $j <= 9; $j++ ) {
						$output .= '<span class="n' . $j . '">' . $j . '</span>';
					}
					$output .= '<span class="n0">0</span>';				
				} else {
					$output .= '<span class="t">' . $number[ $i ] . '</span>';	
				}
			
			$output .= '</span>';
		}
		
		$output .= '</span>';
		$output .= '</div>';
			
		return $output;
	}
}

// [bt_countdown]
class bt_countdown {
	static function init() {
		add_shortcode( 'bt_countdown', array( __CLASS__, 'handle_shortcode' ) );
	}
	
	static function handle_shortcode( $atts, $content ) {
		extract( shortcode_atts( array(
			'datetime'			=> '',
			'size'				=> '',
			'hide_indication'   => '',
			'el_style'			=> '',
			'el_class'			=> ''
		), $atts, 'bt_countdown' ) );

		$datetime = sanitize_text_field( $datetime );
		$size = sanitize_text_field( $size );
		$hide_indication = sanitize_text_field( $hide_indication );
		$el_style = sanitize_text_field( $el_style );
		$el_class = sanitize_text_field( $el_class );

		$style_attr = '';
		if ( $el_style != '' ) {
			$style_attr = ' style="' . $el_style . '"';
		}
		
		$el_class = array();
		$el_class[] = 'btCounterHolder';
		$el_class[] = $size;

		$datetime = sanitize_text_field( $datetime );
		
		$target = strtotime( $datetime );
		$now = strtotime( 'now' );
		
		$init_seconds = $target - $now;
		if ( $init_seconds < 0 ) {
			$init_seconds = 0;
		}
		
		$d_text = __( 'dys', 'bt_plugin' );
		$h_text = __( 'hrs', 'bt_plugin' );
		$m_text = __( 'min', 'bt_plugin' );
		$s_text = __( 'sec', 'bt_plugin' );
		
		if ( $hide_indication == 'yes' ) {
			$d_text = '';
			$h_text = '';
			$m_text = '';
			$s_text = '';
		}		

		$output = '<div class="' . implode( ' ', $el_class ) . '"' . $style_attr . '>';
			$output .= '<div class="btCountdownHolder" data-init-seconds="' . $init_seconds . '">';
				$output .= '<span class="days">
					<span class="numbers">
					</span>
					<span class="days_text">
						<span>' . $d_text . '</span>
					</span>
				</span>';
				
				$output .= '<span class="separator">:</span>';
				
				$output .= '<span class="hours">
					<span class="numbers">
						<span class="n0">
							<span></span>
							<span></span>
						</span>
						<span class="n1">
							<span></span>
							<span></span>
						</span>
					</span>
					<span class="hours_text">
						<span>' . $h_text . '</span>
					</span>
				</span>';
				
				$output .= '<span class="separator">:</span>';
				
				$output .= '<span class="minutes">
					<span class="numbers">
						<span class="n0">
							<span></span>
							<span></span>
						</span>
						<span class="n1">
							<span></span>
							<span></span>
						</span>
					</span>
					<span class="minutes_text">
						<span>' . $m_text . '</span>
					</span>
				</span>';
				
				$output .= '<span class="separator">:</span>';
				
				$output .= '<span class="seconds">
					<span class="numbers">
						<span class="n0">
							<span></span>
							<span></span>
						</span>
						<span class="n1">
							<span></span>
							<span></span>
						</span>
					</span>
					<span class="seconds_text">
						<span>' . $s_text . '</span>
					</span>
				</span>';
			$output .= '</div>';
		$output .= '</div>';
			
		return $output;
	}
}

// [bt_percentage_bar]
class bt_percentage_bar {
	static function init() {
		add_shortcode( 'bt_percentage_bar', array( __CLASS__, 'handle_shortcode' ) );
	}

	static function handle_shortcode( $atts, $content ) {
		extract( shortcode_atts( array(
			'text'			=> '',
			'percentage'	=> '',
			'bar_color'		=> '',	
			'bar_style'		=> '',
			'el_style'		=> '',
			'el_class'		=> ''	
		), $atts, 'bt_percentage_bar' ) );

		$text = sanitize_text_field( $text );
		if( $text == '' ) $text = $percentage . '%';
		$percentage = sanitize_text_field( $percentage );
		$bar_color = sanitize_text_field( $bar_color );
		$bar_style = sanitize_text_field( $bar_style );
		$el_style = sanitize_text_field( $el_style );
		$el_class = sanitize_text_field( $el_class );
		
		$style_attr = '';
		if ( $el_style != '' ) {
			$style_attr = ' style="' . $el_style . '"';
		}

		$color_style_attr = '';
		if ( $bar_color != '' ) {
			if( $bar_style == 'Line' ) {
				$color_style_attr = ' style="border-color:' . $bar_color . '; color:' . $bar_color . ';"';	
			} else {
				$color_style_attr = ' style="background-color:' . $bar_color . ';"';	
			}
		}

		$class = array( 'btProgressBar', 'animate' );

		if ( $el_class != '' ) {
			$class[] = $el_class;
		}

		if ( $bar_style != '' ) {
			$class[] = 'btProgressBar' . $bar_style . 'Style';
		}

		$output = '';
		$output .= '<div class="' . implode( ' ', $class ) . '" '. $style_attr .'>';
		$output .= '<div class="btProgressContent">';
		$output .= '<div data-percentage="' . $percentage . '" class="btProgressAnim animate" ' . $color_style_attr . '><span>' . $text . '</span></div>';
		$output .= '</div>';
		$output .= '</div>';

		return $output;
	}
}

// [bt_slider]
class bt_slider {
	static function init() {
		add_shortcode( 'bt_slider', array( __CLASS__, 'handle_shortcode' ) );
	}

	static function handle_shortcode( $atts, $content ) {
		extract( shortcode_atts( array(
			'auto_play'     => '',
			'height'        => '',
			'hide_arrows'   => '',
			'hide_paging'   => '',
			'simple_arrows' => '',
			'el_style'      => '',
			'el_class'      => ''			
		), $atts, 'bt_slider' ) );
		
		$auto_play = sanitize_text_field( $auto_play );
		$height = sanitize_text_field( $height );
		$hide_arrows = sanitize_text_field( $hide_arrows );
		$hide_paging = sanitize_text_field( $hide_paging );
		$el_style = sanitize_text_field( $el_style );
		$el_class = sanitize_text_field( $el_class );		
		
		$class = array( 'slided' );
		
		$slick_data = '';
		$auto_play = intval( $auto_play );
		if ( $auto_play > 0 ) {
			if ( is_rtl() ) {
				$slick_data = ' ' . "data-slick='{\"infinite\":true,\"autoplay\":true,\"autoplaySpeed\":" . $auto_play . ",\"pauseOnHover\":false,\"pauseOnDotsHover\":true,\"rtl\":true}'";
			}else{
				$slick_data = ' ' . "data-slick='{\"infinite\":true,\"autoplay\":true,\"autoplaySpeed\":" . $auto_play . ",\"pauseOnHover\":false,\"pauseOnDotsHover\":true}'";
			}
			//$slick_data = ' ' . "data-slick='{\"infinite\":true,\"autoplay\":true,\"autoplaySpeed\":" . $auto_play . ",\"pauseOnHover\":false,\"pauseOnDotsHover\":true}'";
		}

		if ( $height == '' ) {
			$class[] = "autoSliderHeight";
		} else {
			$class[] = $height . "SliderHeight";
		}
		
		if ( $hide_arrows != '' ) {
			$class[] = $hide_arrows;
		}

		if ( $hide_paging != '' ) {
			$class[] = $hide_paging;
		}
		
		if ( $el_class != '' ) {
			$class[] = $el_class;
		}
		
		$style_attr = '';
		if ( $el_style != '' ) {
			$style_attr = 'style="' . $el_style . '"';
		}
		
		$simple_arrows_data = '';
		
		if ( $simple_arrows == 'yes' ) {
			$simple_arrows_data = ' data-simple_arrows="yes"';
			$class[] = "btSimpleArrows";
		} else {
			$simple_arrows_data = ' data-simple_arrows="no"';
		}

		if ( is_rtl() ) {
			$is_rtl_data = ' data-rtl="yes"';
		}else{
			$is_rtl_data = ' data-rtl="no"';
		}

		$output = '<div class="' . implode( ' ', $class ) . '" ' . $style_attr . $slick_data . $simple_arrows_data . $is_rtl_data . '>';
			$output .= wptexturize( do_shortcode( $content ) );
		$output .= '</div>';
		
		return $output;
	}
}

// [bt_slider_item]
class bt_slider_item {
	static function init() {
		add_shortcode( 'bt_slider_item', array( __CLASS__, 'handle_shortcode' ) );
	}

	static function handle_shortcode( $atts, $content ) {
		extract( shortcode_atts( array(
			'image'    => '',
			'el_style' => '',
			'el_class' => ''			
		), $atts, 'bt_slider_item' ) );
		
		$image = sanitize_text_field( $image );
		$el_style = sanitize_text_field( $el_style );
		$el_class = sanitize_text_field( $el_class );
		
		$img_full = '';
		$img_thumb = '';
		if ( $image != '' ) {
			$img_full = wp_get_attachment_image_src( $image, 'full' );
			$img_full = $img_full[0];
			$img_thumb = wp_get_attachment_image_src( $image, 'medium' );
			$img_thumb = $img_thumb[0];		
		}		
		
		$class = array( 'slidedItem', 'firstItem' );
		
		if ( $el_class != '' ) {
			$class[] = $el_class;
		}
		
		$style_attr = '';
		if ( $el_style != '' ) {
			$style_attr = 'style="' . $el_style . '"';
		}

		$output = '<div class="' . implode( ' ', $class ) . '" ' . $style_attr . ' data-thumb="' . $img_thumb . '">';
			$output .= '<div class="btSliderPort wBackground cover" style="background-image: url(\'' . $img_full . '\')">';
				$output .= '<div class="btSliderCell" data-slick="yes">';
					$output .= '<div class="btSlideGutter">';
						$output .= '<div class="btSlidePane">';
							$output .= wptexturize( do_shortcode( $content ) );
						$output .= '</div>';
					$output .= '</div>';
				$output .= '</div>';
			$output .= '</div>';	
		$output .= '</div>';		
		
		return $output;
	}
}

// [bt_slider_post_item]
class bt_slider_post_item {
	static function init() {
		add_shortcode( 'bt_slider_post_item', array( __CLASS__, 'handle_shortcode' ) );
	}

	static function handle_shortcode( $atts, $content ) {
		extract( shortcode_atts( array(
			'template' 				=> '',
			'h_tag' 				=> '',
			'text_position' 		=> '',
			'content_background'	=> '',
			'image_position' 		=> '',
			'image_size' 	    	=> 'medium_large',
			'show_highlight' 		=> '',
			'show_excerpt' 			=> '',
			'show_date' 			=> '',
			'show_author' 			=> '',
			'show_categories' 		=> '',
			'show_post_format' 		=> '',
			'show_comments' 		=> '',
			'show_reading_time' 	=> '',
			'show_views_count' 		=> '',
			'show_review' 			=> '',
			'el_style' 				=> '',
			'el_class' 				=> ''		
		), $atts, 'bt_slider_post_item' ) );

		/* class slider */
		$class = array( 'slidedItem', 'firstItem' );
		
		if ( $el_class != '' ) {
			$class[] = $el_class;
		}



		$class_single_post = array();
		$class_single_post[] = "single-post";
		$class_single_post[] = $content_background;
	
		$class_single_post[] = 'image_size__' . $image_size . '__';
		
		$style_attr = '';
		if ( $el_style != '' ) {
			$style_attr = ' ' . 'style="' . $el_style . '"';
		}

		$bg_style = '';
		if ( $image_position == "background" ) {
			$bg_style .= 'style="background-image:url({{ bg_image }});" ' ;	
		}

		$bg_style_side = '';
		if ( $image_position == "side" ) {
			$bg_style_side .= 'style="background-image:url({{ bg_image }});" ' ;	
		}


		/* class post template */
		$class_template = array();

		if ( $template != '' ) {
			$class_template[] = $template . "Template";
		}

		$class_template[] = "{{ post_format }}";	
		$class_template[] = $image_position . "ImagePosition";
		$class_single_post[] = $text_position;
		$class_template[] = $text_position;
		$class_template[] = $content_background;

		if ( ( ! empty( $show_highlight ) && $show_highlight == true ) ) {
			$class_template[] = "btSingleHighlight";
		}

		ob_start();
		require "templates/bt_slider_post_template.php";
		return ob_get_clean();
		
		return $output;
	}
}

// [bt_hr]
class bt_hr {
	static function init() {
		add_shortcode( 'bt_hr', array( __CLASS__, 'handle_shortcode' ) );
	}

	static function handle_shortcode( $atts, $content ) {
		extract( shortcode_atts( array(
			'top_spaced'  			 => '',
			'bottom_spaced'  		 => '',
			'transparent_border'  	 => '',
			'el_style'				 => '',
			'el_class' 				 => ''			
		), $atts, 'bt_hr' ) );
		
		$top_spaced = sanitize_text_field( $top_spaced );
		$bottom_spaced = sanitize_text_field( $bottom_spaced );
		$transparent_border = sanitize_text_field( $transparent_border );
		$el_style = sanitize_text_field( $el_style );
		$el_class = sanitize_text_field( $el_class );
		
		$class = array( "btClear btSeparator" );
		
		if ( $top_spaced != 'not-spaced' && $top_spaced != '' ) {
			$class[] = $top_spaced;
		}

		if ( $bottom_spaced != 'not-spaced' && $bottom_spaced != '' ) {
			$class[] = $bottom_spaced;
		}

		if ( $transparent_border != '') {
			$class[] = $transparent_border;
		}
		
		if ( $el_class != '') {
			$class[] = $el_class;
		}
		
		
		$style_attr = '';
		if ( $el_style != '' ) {
			$style_attr = ' ' . 'style="' . $el_style . '"';
		}
		

		$output = '<div class="' . implode( ' ', $class ) . '" '. $style_attr . '><hr></div>';
		
		return $output;
	}
}

// [bt_icon]
class bt_icon {
	static function init() {
		add_shortcode( 'bt_icon', array( __CLASS__, 'handle_shortcode' ) );
	}

	static function handle_shortcode( $atts, $content ) {
		extract( shortcode_atts( array(
			'icon'				=> '',
			'icon_type'			=> '',
			'icon_color'		=> '',
			'icon_size'			=> '',
			'icon_shape'		=> '',
			'icon_title'		=> '',
			'url'				=> '',
			'target'			=> '',
			'el_style'		    => '',
			'el_class' 		    => ''					
		), $atts, 'bt_icon' ) );
		
		if ( $el_class != '' ) {
			$el_class = ' ' . $el_class;
		}
		
		$output = boldthemes_get_icon_html( $icon, $url, $icon_title, $icon_type . ' ' . $icon_size . ' ' . $icon_color . ' ' . $icon_shape . $el_class, $target, $el_style );

		return $output;
	}
}

// [bt_icons]
class bt_icons {
	static function init() {
		add_shortcode( 'bt_icons', array( __CLASS__, 'handle_shortcode' ) );
	}

	static function handle_shortcode( $atts, $content ) {
		extract( shortcode_atts( array(
			'el_style' => '',
			'el_class' => ''
		), $atts, 'bt_icons' ) );
		
		$el_style = sanitize_text_field( $el_style );
		$el_class = sanitize_text_field( $el_class );		
		
		$class = array( 'btIconImageRow' );
		
		if ( $el_class != '' ) {
			$class[] = $el_class;
		}
		
		$style_attr = '';
		if ( $el_style != '' ) {
			$style_attr = 'style="' . $el_style . '"';
		}

		$output = '<div class="' . implode( ' ', $class ) . '" ' . $style_attr . '>';
			$output .= wptexturize( do_shortcode( $content ) );
		$output .= '</div>';
		
		return $output;
	}
}

// [bt_grid]
class bt_grid {
	static function init() {
		add_shortcode( 'bt_grid', array( __CLASS__, 'handle_shortcode' ) );
		add_action( 'wp_ajax_bt_get_grid', array( __CLASS__, 'bt_get_grid_callback' ) );
		add_action( 'wp_ajax_nopriv_bt_get_grid', array( __CLASS__, 'bt_get_grid_callback' ) );
	}
	
	static function bt_get_grid_callback() {
		$data = boldthemes_get_posts_data( intval( $_POST['number'] ), intval( $_POST['offset'] ), $_POST['cat_slug'], $_POST['post_type'] );
		bt_grid::bt_dump_grid( $data, $_POST['grid_type'], $_POST['post_type'], $_POST['format'], $_POST['tiles_title'] );
		die();
	}
	
	static function bt_dump_grid( $data, $grid_type, $post_type, $format, $tiles_title ) {
		if ( count( $data ) == 0 ) {
			echo 'no_posts';
			die();
		}

		if( $tiles_title == 'yes' || $tiles_title == "true" || $tiles_title == 1 ) {
			$tiles_title = true;
		} else {
			$tiles_title = false;
		}
		
		$new_arr = array();
		
		$format_arr = explode( ',', $format );
		
		$i = 0;
		foreach( $data as $post ) {
		
			$item = '';
			
			$img_size = 'boldthemes_medium_square';
			
			if ( isset( $format_arr[ $i ] ) ) {
				if ( $format_arr[ $i ] == '21' ) {
					$tile_format = '21';
					$img_size = 'boldthemes_large_rectangle';
				} else if (  $format_arr[ $i ] == '12' ) {
					$tile_format = '12';
					$img_size = 'boldthemes_large_vertical_rectangle';
				} else if (  $format_arr[ $i ] == '22' ) {
					$tile_format = '22';
					$img_size = 'boldthemes_large_square';
				} else {
					$tile_format = '11';
					$img_size = 'boldthemes_medium_square';
				}
			} else {
				if ( $post['tile_format'] != '' ) {
					$tile_format = $post['tile_format'];
					if ( $tile_format != '11' || $tile_format != '12' || $tile_format != '21' || $tile_format != '22' ) {
						$tile_format = '11';			
					}
				} else {
					$tile_format = '11';
				}
			}
			
			// $img_size = 'boldthemes_grid_' . $tile_format;
			
			if ( $grid_type  == 'classic' ) {
				$img_size = 'boldthemes_medium';
			}
			
			// post formats
			
			$media_html = '';
			
			$img_src = '';
			$post_thumbnail_id = get_post_thumbnail_id( $post['ID'] );
			
			$hw = '';
			
			if ( $post_thumbnail_id != '' ) {
				$img = wp_get_attachment_image_src( $post_thumbnail_id, $img_size );
				$img_src = $img[0];
				if ( $grid_type == 'classic' && $img[1] != '' ) $hw = $img[2] / $img[1];
				
			} else if ( ( $post['format'] == 'image' && count( $post['images'] ) > 0 ) || ( $post_type == 'portfolio' && count( $post['images'] ) == 1 ) ) {
				foreach ( $post['images'] as $img ) {
					$img = wp_get_attachment_image_src( $img['ID'], $img_size );
					$img_src = $img[0];
					if ( $grid_type == 'classic' && $img[1] != '' ) $hw = $img[2] / $img[1];
					break;
				}
			}
			
			if ( $grid_type == 'classic' ) {
			
				if ( $post['format'] == 'gallery' || ( $post_type == 'portfolio' && count( $post['images'] ) > 1 ) ) {
						
					if ( count( $post['images'] ) > 0 ) {
						$images_ids = array();
						foreach ( $post['images'] as $img ) {
							$images_ids[] = $img['ID'];
						}
						$img = wp_get_attachment_image_src( $images_ids[0], 'boldthemes_medium_rectangle' );
						$src = $img[0];
						if ( $img[1] == 0 || $img[1] == '' ) {
							$media_html = '';
						} else {
							$hw = $img[2] / $img[1];
							$media_html = boldthemes_get_media_html( 'gallery', array( $images_ids, $hw, 'boldthemes_medium_rectangle' ) );
						}
					}
					
				} else if ( $post['format'] == 'video' || ( $post_type == 'portfolio' && $post['video'] != '' ) ) {
					
					$media_html = boldthemes_get_media_html( 'video', array( $post['video'] ) );
					
				} else if ( $post['format'] == 'audio' || ( $post_type == 'portfolio' && $post['audio'] != '' ) ) {
					
					$media_html = boldthemes_get_media_html( 'audio', array( $post['audio'] ) );
					
				} else if ( $post['format'] == 'link' || ( $post_type == 'portfolio' && $post['link_url'] != '' ) ) {
					
					$media_html = boldthemes_get_media_html( 'link', array( $post['link_url'], $post['link_title'] ) );
					
				} else if ( $post['format'] == 'quote' || ( $post_type == 'portfolio' && $post['quote'] != '' ) ) {
					
					$media_html = boldthemes_get_media_html( 'quote', array( $post['quote'], $post['quote_author'], $post['permalink'] ) );
				}
			}
			
			if ( $media_html == '' ) {
				$extra_class = ' ' . 'noPhoto';
				if ( $img_src != '' ) {
					if ( $grid_type == 'classic' ) {
						$media_html = boldthemes_get_media_html( 'image', array( $post['permalink'], $img_src, $hw ) );
					}
					$extra_class = '';
				} else if ( $grid_type != 'classic' ) {
					$img_src = get_template_directory_uri() . '/gfx/ph_tiles.png';
				}
			}

			$comments = '';
			if ( $post['comments'] !== false ) {
				$comments = boldthemes_get_post_comments( $post['ID'] );
			}

			$use_dash = '';
			$bold_article_bottom = '';
			$bold_article_top = '';
			
			$catgs = str_replace( ', ', '', $post['category'] );
			if ( $post_type == 'portfolio' ) $catgs = $post['category'];
			
			if ( $post_type == 'portfolio' ) {
				$author = '';
				$bold_article_bottom = '';
				$use_dash = boldthemes_get_option( 'pf_use_dash' );
			} else {
				if ( boldthemes_get_option( 'blog_author' ) ) $bold_article_top .= boldthemes_get_post_author( $post['author_url'], $post['author_id'] );
				if ( boldthemes_get_option( 'blog_date' ) ) $bold_article_top .= '<span class="btArticleDate">' . $post['date'] . '</span>';
				if ( boldthemes_get_option( 'blog_views_count' ) ) $bold_article_bottom .=  bold_news_get_view_count( $post['ID'] );
				if ( boldthemes_get_option( 'blog_reading_time' ) ) $bold_article_bottom .=  bold_news_get_reading_time( $post['ID'] );
				if ( boldthemes_get_option( 'blog_comments' ) ) $bold_article_bottom .= $comments ;
				if ( boldthemes_get_option( 'blog_rating' ) ) $bold_article_bottom .=  boldthemes_get_post_star_rating( $post['ID'] );
				$use_dash = boldthemes_get_option( 'blog_use_dash' );
			}
			
			$bold_article_categories = '' . $catgs . '';

			
			if ( $grid_type == 'classic' ) {
				
				if ( $post_type == 'portfolio' ) {
					$share_html = boldthemes_get_share_html( $post['permalink'], 'pf', 'btIcoExtraSmallSize', 'btIcoDefaultColor btIcoFilledType' );
				} else {
					$share_html = boldthemes_get_share_html( $post['permalink'], 'blog', 'btIcoExtraSmallSize', 'btIcoDefaultColor btIcoFilledType' );
				}
			
				$new_arr[ $i ]['container_class'] = 'gridItem';
				$dash = $use_dash ? 'bottom' : '';
				ob_start();
				require "templates/bt_single_grid_post_template.php";
				$item .= ob_get_clean();
			} else {
				
				if ( $post_type == 'post' ) {
					$subtitle =  $bold_article_top;
				} else {
					$subtitle =  '';
				}
				
				if ( $post_type == 'post' ) $content = '' . $bold_article_categories . '';
				$content = '<div class="btTilesArticleTop">' . $bold_article_top . '</div>';
				$content .= '<h3 class="btTilesArticleTitle">' . $post['title'] . '</h3>';
				$content .= '<div class="btTilesArticleBottom">' . $bold_article_bottom . '</div>';
				
				$new_arr[ $i ]['container_class'] = 'gridItem bt' . $tile_format . $extra_class;
				$dash = $use_dash ? 'bottom' : '';
				ob_start();
				require "templates/bt_single_tiles_post_template.php";
				$item .= ob_get_clean();				
			}
			
			$new_arr[ $i ]['html'] = $item;
			$new_arr[ $i ]['hw'] = $hw;
			$i++;			
			
		}

		echo json_encode( $new_arr );
	}
	
	static function handle_shortcode( $atts, $content ) {
	
		extract( shortcode_atts( array(
			'number'          => '',
			'columns'         => '',
			'category'        => '',
			'category_filter' => '',
			'related'         => '',
			'grid_type'       => '',
			'grid_gap'        => '',
			'format'          => '',
			'tiles_title'     => '',
			'post_type'       => '',
			'scroll_loading'  => '',
			'sticky_in_grid'  => '',
			'el_class'        => '',
			'el_style'        => ''
		), $atts, 'bt_grid' ) );

		$style_attr = '';
		if ( $el_style != '' ) {
			$style_attr = 'style="' . $el_style . '"';
		}
		
		if ( $number == '' || $number <= 0 ) $number = 12;
		
		$col = 4;
		if ( $columns != '' ) $col = $columns;
		
		if ( $grid_type != 'classic' ) $grid_type = 'tiled';

		if ( $grid_gap != '' ) $el_class .= 'btGridGap-' . $grid_gap;

		$tiles_title_class = '';

		if ( $tiles_title == 'yes' ) $tiles_title_class = 'btHasTitles';
		
		if ( $post_type != 'portfolio' ) $post_type = 'post';
		
		if ( $scroll_loading != 'yes' ) {
			$scroll_loading = 'no';
		}
		
		wp_enqueue_script( 
			'boldthemes_imagesloaded',
			plugin_dir_url( __FILE__ ) . 'imagesloaded.pkgd.min.js',
			array( 'jquery' ),
			'',
			true
		);
		
		wp_enqueue_script( 
			'boldthemes_packery',
			plugin_dir_url( __FILE__ ) . 'packery.pkgd.min.js',
			array( 'jquery' ),
			'',
			true
		);
		
		wp_enqueue_script( 
			'boldthemes_grid_tweak',
			plugin_dir_url( __FILE__ ) . 'bt_grid_tweak.js',
			array( 'jquery' ),
			'',
			true
		);		
		
		wp_enqueue_script( 
			'boldthemes_grid',
			plugin_dir_url( __FILE__ ) . 'bt_grid.js',
			array( 'jquery' ),
			'',
			true
		);
		
		$output = '<div class="btGridContainer ' . $grid_type . ' ' . $el_class . ' ' . $tiles_title_class . '" ' . $style_attr . '>';
		if ( $category_filter == 'yes' ) {
			$cat_arr = explode( ',', str_replace( ' ', '', $category ) );
			if ( $post_type == 'post' ) {
				$cats = get_categories();
			} else {
				$cats = get_categories( array( 'type' => 'portfolio', 'taxonomy' => 'portfolio_category' ) );
			}
			$output .= '<div class="btCatFilter">';
			$output .= '<span class="btCatFilterTitle"><b>' . __( 'Category filter:', 'bt_plugin' ) . '</b></span>';
			$final_cat_arr = array();
			$output_filer_items = '';
			foreach ( $cats as $cat ) {
				if ( in_array( $cat->slug, $cat_arr ) || count( $cat_arr ) == 1 ) {
					$output_filer_items .= '<span class="btCatFilterItem" data-slug="' . $cat->slug . '"><b>' . $cat->name . '</b></span>';
					$final_cat_arr[] = $cat->slug;
				}
			}
			$output .= '<span class="btCatFilterItem all" data-slug="' . implode( ',', $final_cat_arr ) . '"><b>' . __( 'All', 'bt_plugin' ) . '</b></span>';
			$output .= $output_filer_items;
			$output .= '</div>';
		}
		$output .= '<div class="tilesWall btAjaxGrid ' . $grid_type . '" data-num="' . $number . '" data-tiles-title="' . $tiles_title . '" data-grid-type="' . $grid_type . '" data-post-type="' . $post_type . '" data-col="' . $col . '" data-cat-slug="' . $category . '" data-scroll-loading="' . $scroll_loading . '" data-format="' . $format . '" data-related="' . $related . '" data-sticky="' . $sticky_in_grid . '">';
		$output .= '<div class="gridSizer"></div>';
		$output .= '</div>';
		$output .= '<div class="btLoader btLoaderGrid"></div><div class="btNoMore btTextCenter topSmallSpaced bottomSmallSpaced">' . esc_html( __( 'No more posts', 'bt_plugin' ) ) . '</div>';
		$output .= '</div>';
		
		return $output;

	}
}

// [bt_latest_posts]
class bt_latest_posts {
	static function init() {
		add_shortcode( 'bt_latest_posts', array( __CLASS__, 'handle_shortcode' ) );
	}
	static function handle_shortcode( $atts, $content ) {
	
		extract( shortcode_atts( array(
			'number'          	=> '',
			'category'        	=> '',
			'format'          	=> '',
			'headline_size'     => '',
			'show_excerpt'    	=> '',
			'show_date'    	  	=> '',
			'show_categories'   => '',
			'show_author'     	=> '',
			'show_pagination'   => '',
			'post_type'       	=> '',
			'el_class'        	=> '',
			'el_style'        	=> ''
		), $atts, 'bt_latest_posts' ) );
		
		if ( $headline_size == '' ) {
			$headline_size = 'small';
		}
		
		$style_attr = '';
		if ( $el_style != '' ) {
			$style_attr = 'style="' . $el_style . '"';
		}
		
		if ( $number == '' || $number <= 0 ) $number = 3;

		$column_width = 12;

		$img_size = 'boldthemes_small_square';
		$dash = 'bottom';
		$indent_class = '';

		if ( $format == 'horizontal' ) {
			$column_width = intval( 12 / $number );
			$img_size = 'boldthemes_medium_rectangle';
			$dash = 'bottom';
		}

		$use_dash = '';
		if ( $post_type == 'portfolio' ) {
			$use_dash = boldthemes_get_option( 'pf_use_dash' );
		} else {
			$use_dash = boldthemes_get_option( 'blog_use_dash' );
		}

		$dash = $use_dash ? 'bottom' : '';
		
		if ( $post_type != 'portfolio' ) $post_type = 'post';

		$paged = ( isset( $_GET['pg'] ) ) ? sanitize_text_field( $_GET['pg'] ) : 1;
		
		$data = boldthemes_get_template_posts_data( $number, ($paged-1)*$number, $category, array(), '', false, $post_type, $atts, 'bt_latest_posts' );
		
		$output = '<div class="btLatestPostsContainer ' . $format . 'Posts ' . $el_class . '" ' . $style_attr . '>';
		
		$i = 0;
		foreach( $data as $post_item ) { 
			$i++;
			if ( $i > $number ) break;
			
			$img_src = '';
			$post_thumbnail_id = get_post_thumbnail_id( $post_item['ID'] );
			
			if ( $post_thumbnail_id != '' ) {
				$img = wp_get_attachment_image_src( $post_thumbnail_id, $img_size );
				$img_src = $img[0];			
			} else if ( ( $post_item['format'] == 'image' && count( $post_item['images'] ) > 0 ) || ( $post_type == 'portfolio' && count( $post_item['images'] ) == 1 ) ) {
				foreach ( $post_item['images'] as $img ) {
					$img = wp_get_attachment_image_src( $img['ID'], $img_size );
					$img_src = $img[0];
					break;
				}
			}
	
			$comments = '';
			
			$author = '';
			$bold_article_supertitle = '';
			
			if ( $post_type == 'portfolio' ) {
				$author = '';
				if ( $show_categories != 'no' ) {
					$bold_article_supertitle = '<span class="btArticleCategories">' . $post_item['category'] . '</span>';
				}
				$bold_article_subtitle = '';
			} else {
				if ( $show_author != 'no' ) { 
					$author = '<a href="' . $post_item['author_url'] . '" class="btArticleAuthor">' . __( 'by', 'bt_plugin' ) . ' ' . $post_item['author_name'] . '</a>';
				}
				$bold_article_subtitle = $author . $comments ;
				$bold_article_supertitle = "";
				if ( $show_date != 'no' ) $bold_article_supertitle = '<span class="btArticleDate">' . $post_item['date'] . '</span>';
				if ( $show_categories != 'no' ) $bold_article_supertitle .= '<span class="btArticleCategories">' . $post_item['category'] . '</span>';
			}
			
			if ( $bold_article_subtitle == '' ) $dash = '';

			$image_html = '';

			if ( $img_src != '' ) {
				$image_html .= '<div class="btSingleLatestPostImage btTextCenter">' . boldthemes_get_image_html(
					array(
						'image' => $img_src,
						'caption_title' => '',
						'caption_text' => '',
						'content' => '',
						'size' => '',
						'shape' => '',
						'url' => $post_item['permalink'],
						'target' => '_self',
						'show_titles' => '',
						'el_style' => $el_style,
						'el_class' => $el_class . ' btZoomInHoverType'
					)
				) . '</div>';
			}

			$output .= '
				<div class="btSingleLatestPost col-md-' . $column_width . ' col-ms-12 ' . $indent_class . ' inherit"' . $el_style . '>'
					. $image_html .
					'<div class = "btSingleLatestPostContent">
						' . boldthemes_get_heading_html( $bold_article_supertitle, '<a href="' . $post_item['permalink'] . '" target="_self">' . $post_item['title'] . '</a>', $bold_article_subtitle, $headline_size, $dash, '', '' );
			if ( $show_excerpt == 'yes' ) $output .= '
				<p class="btLatestPostContent">' . get_the_excerpt( $post_item['ID'] ) . '</p>';
			$output .= '
					</div>
				</div>';
		}

		if ( $show_pagination != 'no' ) { 
			global $wp_query;
			global $recent_posts_query_results;
			
			$tmp_query = $wp_query;
			$wp_query = null;
			$wp_query = $recent_posts_query_results;
			
			$output .= bt_latest_posts::bt_numeric_posts_nav($paged);
			
			$wp_query = null;
			$wp_query = $tmp_query;
		}

		$output .= '</div>';
		
		return $output;

	}
	
	static function bt_numeric_posts_nav($paged) {
 
		if( is_singular() )
			return;
 
		global $wp_query;
 
		/** Stop execution if there's only 1 page */
		
		if( $wp_query->max_num_pages <= 1 )
			return;
 
		//$paged = (get_query_var('page')) ? get_query_var('page') : 1;

		$max   = intval( $wp_query->max_num_pages );
 
		/** Add current page to the array */
		if ( $paged >= 1 )
			$links[] = $paged;
 
		/** Add the pages around the current page to the array */
		if ( $paged >= 3 ) {
			$links[] = $paged - 1;
			$links[] = $paged - 2;
		}
 
		if ( ( $paged + 2 ) <= $max ) {
			$links[] = $paged + 2;
			$links[] = $paged + 1;
		}
		
		$class_common = ' class="btBtn btnOutlineStyle btnAccentColor btnSmall btnNormalWidth btnRightPosition btnNoIcon"';
		$class_common_active = ' class="btBtn btnOutlineStyle btnAccentColor btnSmall btnNormalWidth btnRightPosition btnNoIcon active"';
		$output = '<div class="btLatestPostsNav"><ul>' . "\n"; 
 
		/** Link to first page, plus ellipses if necessary */
		if ( ! in_array( 1, $links ) ) {
			$class = 1 == $paged ? $class_common_active : $class_common; 
			$output .= '<li'. $class .'><a href="' . esc_url( get_permalink() . '?pg=1' ) . '">1</a></li>' . "\n";
			if ( ! in_array( 2, $links ) )
				$output .= '<li>...</li>';
		}
 
		/** Link to current page, plus 2 pages in either direction if necessary */
		sort( $links );
		foreach ( (array) $links as $link ) {
			$class = $paged == $link ? $class_common_active : $class_common;
			$output .= '<li'. $class .'><a href="' . esc_url( get_permalink() . '?pg='.$link ) . '">' . $link . '</a></li>' . "\n";
		}
 
		/** Link to last page, plus ellipses if necessary */
    	if ( ! in_array( $max, $links ) ) {
			if ( ! in_array( $max - 1, $links ) )
				$output .= '<li>...</li>' . "\n";
 
			$class = $paged == $max ? $class_common_active : $class_common;
			$output .= '<li'. $class .'><a href="' . esc_url( get_permalink() . '?pg='.$max ) . '">' . $max . '</a></li>' . "\n";
		}
 
		$output .= '</ul></div>' . "\n";
		
		return $output;
 
	}
}

// [bt_price_list]
class bt_price_list {

	static function init() {
		add_shortcode( 'bt_price_list', array( __CLASS__, 'handle_shortcode' ) );
	}

	static function handle_shortcode( $atts, $content ) {
		extract( shortcode_atts( array(
			'title'       => '',
			'subtitle'       => '',
			'sticker'     => '',
			'currency'    => '',
			'price'       => '',
			'items'       => '',
			'el_class'    => '',
			'el_style'    => ''
		), $atts, 'bt_price_list' ) );
		
		$style_attr = '';
		if ( $el_style != '' ) {
			$style_attr = 'style="' . $el_style . '"';
		}

		$output = '<div class="btPriceTable ' . $el_class . '" ' . $style_attr . '>';
		
		if ( $sticker != '' ) $sticker = '<div class="btPriceTableSticker"><div><div>' . $sticker . '</div></div></div>';

		$items_arr = preg_split( '/$\R?^/m', $items );

		$use_dash = '';
		$use_dash = boldthemes_get_option( 'sidebar_use_dash' );
		$dash = $use_dash ? "bottom" : ""; 
		
		$output .= 
			'<div class="btPriceTableHeader btDarkSkin">' . $sticker .
				boldthemes_get_heading_html( $title, '<span class="btPriceTableCurrency">' . $currency . '</span>'	. $price, $subtitle, 'large', $dash, 'bold', '' ) .
			'</div><!-- /ptHeader -->
			<ul>';
				foreach ( $items_arr as $item ) {
					$output .= '<li>' . $item . '</li>';
				}
			$output .= '</ul>
		';
		$output .= '</div>';
		
		return $output;
	}
}

/* Single post template shortcode */

// [bt_single_post_template]
class bt_single_post_template {
	static function init() {
		add_shortcode( 'bt_single_post_template', array( __CLASS__, 'handle_shortcode' ) );
	}

	static function handle_shortcode( $atts, $content ) {
		extract( shortcode_atts( array(
			'template' 				=> '',
			'h_tag' 				=> '',
			'image_position' 		=> '',
			'image_size' 	    	=> 'medium_large',
			'show_highlight' 		=> '',
			'show_excerpt' 			=> '',
			'show_date' 			=> '',
			'show_author' 			=> '',
			'show_categories' 		=> '',
			'show_post_format' 		=> '',
			'show_comments' 		=> '',
			'show_reading_time' 	=> '',
			'show_views_count' 		=> '',
			'show_review' 			=> '',
			'el_style' 				=> '',
			'el_class' 				=> ''
		), $atts, 'bt_single_post_template' ) );	
		
		$class = array();
		if ( $el_class != '' ) {
			$class[] = $el_class;
		}
		if ( $template != '' ) {
			$class[] = $template . "Template";
		}

		if ( ( ! empty( $show_highlight ) && $show_highlight == true ) ) {
			$class[] = "btSingleHighlight";
		}

		if ( ( ! empty( $show_post_format ) && $show_post_format == true ) ) {
			$class[] = "{{ post_format }}";
		}
		
		if ( ( ! empty( $show_comments ) && $show_comments == true ) || ( ! empty( $show_reading_time ) && $show_reading_time == true ) || ( ! empty( $show_views_count ) && $show_views_count == true ) || ( ! empty( $show_review  ) && $show_review == true ) ) {
			$class[] = "btHideBottomData";
		}
		
		if ( ( ! empty( $show_date ) && $show_date == true ) || ( !empty( $show_author ) && $show_author == true ) ) {
			$class[] = "btHideTopData";
		}
		
		$el_style_attr = '';
		if ( $el_style != '' ) {
			$el_style_attr = ' ' . 'style="' . $el_style . '"';
		}
		
		$class[] = $image_position . "ImagePosition";
		if ( $image_position == "background" || $image_position == "left" ) {
			$el_style = 'background-image:url({{ bg_image }}); ' ;	
		}

		$class[] = 'image_size__' . $image_size . '__';

		$style_attr = '';
		if ( $el_style != '' ) {
			$style_attr = 'style="' . $el_style . '"';
		}
	
		ob_start();
		require 'templates/bt_single_post_template.php';
		return ob_get_clean();
		
		return $output;
	}
}


// [bt_categories_widget]
class bt_categories_widget {
	static function init() {
		add_shortcode( 'bt_categories_widget', array( __CLASS__, 'handle_shortcode' ) );
	}

	static function handle_shortcode( $atts, $content ) {
		extract( shortcode_atts( array(
			'title' 					=> '',
			'category_slug' 			=> '',
			'dcw_exclude_slug' 			=> '',
			'dcw_depth' 				=> '',
			'show_title' 				=> '',
			'show_format' 				=> '',
			'showcount_value' 			=> '',
			'display_empty_categories'	=> '',
			'el_class' 					=> '',
			'el_style'					=> ''
		), $atts, 'bt_categories_widget' ) );
		
		$el_class	= sanitize_text_field( $el_class );
		$el_style	= sanitize_text_field( $el_style );

		$style_attr = '';
		if ( $el_style != '' ) {
			$style_attr = ' style="' . $el_style . '"';
		}
			
		if ( $show_title == true ) {			
			$before_title	= '<h4><span>';
			$after_title	= '</span></h4>';	
		}else{
			$atts["title"]	= ' ';
			$before_title	= '';
			$after_title	= '';	
		}

		$before_dropdown	= '';
		$after_dropdown		= '';
		if ( $show_format == true ) {
			$before_dropdown  = '<div class="fancy-select">';
			$after_dropdown	  = '</div>';
		}

		$before_widget	= '<div class="btBox shortcode_widget_categories ' . $el_class . '"' . $style_attr . '>';
		$after_widget	= '</div>';

		$args = array(
			'before_widget' => $before_widget,
			'after_widget'  => $after_dropdown . $after_widget,
			'before_title' 	=> $before_title,
			'after_title' 	=> $after_title . $before_dropdown
		);	
		
		wp_enqueue_script( 'bt_categories_widget', plugin_dir_url( __FILE__ ) . 'bt_categories_widget.js', array( 'jquery' ), '', false );
		
		ob_start();
			the_widget( 'BT_Custom_Categories_Widget', $atts, $args );
			$output = ob_get_contents();
		ob_end_clean();

		return $output;		
	}
}

// [bt_banner]
class bt_banner {
	static function init() {
		add_shortcode( 'bt_banner', array( __CLASS__, 'handle_shortcode' ) );
	}

	static function handle_shortcode( $atts, $content ) {
		extract( shortcode_atts( array(
			'code'     => '',
			'el_class' => '',
			'el_style' => '',
			'show_banner_border' => ''
		), $atts, 'bt_banner' ) );

		$class = array( 'bt_banner' );
		
		if ( $el_class != '' ) {
			$class[] = $el_class;
		}

		if ( empty( $show_banner_border) ){
			$class[] = "no-border";
		}
		
		$style_attr = '';
		if ( $el_style != '' ) {
			$style_attr = 'style="' . $el_style . '"';
		}

		$output = '<div class="' . implode( ' ', $class ) . '" ' . $style_attr . '>';
			$output .= base64_decode( $code );
		$output .= '</div>';

		return $output;
		
	}
}

// [bt_category_title]
class bt_category_title {
	static function init() {
		add_shortcode( 'bt_category_title', array( __CLASS__, 'handle_shortcode' ) );
	}

	static function handle_shortcode( $atts, $content ) {
		extract( shortcode_atts( array(
			'title' 			=> '',
			'h_tag' 			=> '',
			'category_filter'	=> '',
			'category' 			=> '',
			'icon'				=> '',
			'icon_type'			=> '',
			'icon_shape'		=> '',
			'icon_size'			=> '',	
			'el_class' 			=> '',
			'el_style'			=> ''
		), $atts, 'bt_category_title' ) );

		$style_attr = '';
		if ( $el_style != '' ) {
			$style_attr = ' style="' . $el_style . '"';
		}

		$output_filer_categories = '';

		$cat_obj = get_category_by_slug( $category );

		if ( ( $category_filter != 'no' ) ) {
			
			if ( !empty( $cat_obj ) ){
				$cats = get_categories( array('parent' => $cat_obj->term_id) );
				if ( !empty($cats) ){
					foreach ( $cats as $cat ) {
						$category_url = get_category_link( $cat->term_id );
						$output_filer_categories .= '
							<span class="btCatFilterItem" data-slug="' . $cat->slug . '"><b>
								<a href="' . esc_url_raw( $category_url ) . '">' . esc_html( $cat->name ).'</a>
							</b></span>';
					}
				}
			}
		}		

		$output = '<div class="btCategoryTitle ' . $icon_size . 'Icon ' . $el_class . '"' . $style_attr . '>';
			
			$output .= '<div class="sIcon cat-item-' . $cat_obj->term_id . ' ">';
				$output .= boldthemes_get_icon_html( $icon, '', '', $icon_size . ' ' . $icon_type . ' ' . $icon_shape );
			$output .= '</div>';
			
			if ( $title != '') {
				$output .= '<div class="btCategoryTitleTxt">';
					$output .= '<' . $h_tag . '>' . wp_kses_post( $title  ) . '</' . $h_tag . '>';
				$output .= '</div>';
			}
			
			if ( $output_filer_categories != '') {
				$output .= '<div class="btCatFilter">';
					$output .= $output_filer_categories;
				$output .= '</div>';
			}

		$output .= '</div>';
		
		return $output;		
	}
}

bt_single_post_template::init();

bt_image::init();
gallery::init();
image::init();

bt_grid_gallery::init();

bt_section::init();
bt_post_container::init();
bt_row::init();
bt_row_inner::init();
bt_custom_menu::init();
bt_column::init();
bt_column_inner::init();
bt_text::init();
bt_header::init();
bt_tabs::init();
bt_tabs_items::init();
bt_accordion::init();
bt_accordion_items::init();
bt_service::init();
bt_gmaps::init();
bt_clients::init();
bt_client::init();
bt_twitter::init();
bt_button::init();
bt_counter::init();
bt_countdown::init();
bt_percentage_bar::init();
bt_slider::init();
bt_slider_item::init();
bt_slider_post_item::init();
bt_hr::init();
bt_icon::init();
//bt_icons::init();
bt_grid::init();
bt_latest_posts::init();
bt_price_list::init();

bt_categories_widget::init();
bt_category_title::init();

bt_banner::init();

function bt_map_sc() {
	if ( function_exists( 'bt_rc_map' ) ) {
	
		if ( ! function_exists( 'bt_fa_icons' ) ) {
			require_once( 'bt_fa_icons.php' );
		}
		if ( ! function_exists( 'bt_s7_icons' ) ) {
			require_once( 'bt_s7_icons.php' );
		}
		if ( ! function_exists( 'bt_custom_icons' ) ) {
			require_once( 'bt_custom_icons.php' );
		}
		
		$icon_arr = array( 'Font Awesome' => bt_fa_icons(), 'S7' => bt_s7_icons(), 'Custom' => bt_custom_icons() );
		
		require_once( 'section_anims.php' );
		$section_anims = bt_get_section_anims();	

		bt_rc_map( 'bt_single_post_template', array( 'name' => __( 'Single Post Template', 'bt_plugin' ), 'description' => __( 'Single post is defined in parent section or container', 'bt_plugin' ), 'icon' => 'bt_bb_icon_bt_bb_icons', 'container' => 'vertical', 'accept' => array( 'bt_icon' => true, 'bt_image' => true, 'bt_service' => true ), 'toggle' => true, 'show_settings_on_create' => false,
			'params' => array( 
				array( 'param_name' => 'template', 'type' => 'dropdown', 'heading' => __( 'Template', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'Default', 'bt_plugin' ) => 'default',
						__( 'Small', 'bt_plugin' ) => 'small',
						__( 'Large', 'bt_plugin' ) => 'large'
				) ),
				array( 'param_name' => 'h_tag', 'type' => 'dropdown', 'heading' => __( 'H tag', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'H1', 'bt_plugin' ) => 'h1',
						__( 'H2', 'bt_plugin' ) => 'h2',
						__( 'H3', 'bt_plugin' ) => 'h3',
						__( 'H4', 'bt_plugin' ) => 'h4',
						__( 'H5', 'bt_plugin' ) => 'h5',
						__( 'H6', 'bt_plugin' ) => 'h6'
				) ),
				array( 'param_name' => 'image_position', 'type' => 'dropdown', 'heading' => __( 'Image position', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'Top', 'bt_plugin' ) 			=> 'top',
						__( 'Left', 'bt_plugin' ) 			=> 'left',
						__( 'Background', 'bt_plugin' ) 	=> 'background',
						__( 'No image', 'bt_plugin' ) 		=> 'no-image'
				) ),
				array( 'param_name' => 'image_size', 'type' => 'textfield', 'value' => 'medium_large', 'heading' => __( 'Image size', 'bt_plugin' ), 'preview' => true ),
				array( 'param_name' => 'show_highlight', 'type' => 'checkbox', 'value' => array( 'Yes' => 'true' ), 'heading' => __( 'Show highlight', 'bt_plugin' ), 'preview' => true ),
				array( 'param_name' => 'show_excerpt', 'type' => 'checkbox', 'value' => array( 'Yes' => 'true' ), 'heading' => __( 'Show excrept', 'bt_plugin' ), 'group' => __( 'Display', 'bold-news' ) ),
				array( 'param_name' => 'show_author', 'type' => 'checkbox', 'value' => array( 'Yes' => 'true' ), 'heading' => __( 'Show author', 'bt_plugin' ), 'group' => __( 'Display', 'bold-news' ) ),
				array( 'param_name' => 'show_date', 'type' => 'checkbox', 'value' => array( 'Yes' => 'true' ), 'heading' => __( 'Show date', 'bt_plugin' ), 'group' => __( 'Display', 'bold-news' ) ),
				array( 'param_name' => 'show_categories', 'type' => 'checkbox', 'value' => array( 'Yes' => 'true' ), 'heading' => __( 'Show categories', 'bt_plugin' ), 'group' => __( 'Display', 'bold-news' ) ),
				array( 'param_name' => 'show_post_format', 'type' => 'checkbox', 'value' => array( 'Yes' => 'true' ), 'heading' => __( 'Show post format', 'bt_plugin' ), 'group' => __( 'Display', 'bold-news' ) ),
				array( 'param_name' => 'show_comments', 'type' => 'checkbox', 'value' => array( 'Yes' => 'true' ), 'heading' => __( 'Show comments', 'bt_plugin' ), 'group' => __( 'Display', 'bold-news' ) ),
				array( 'param_name' => 'show_reading_time', 'type' => 'checkbox', 'value' => array( 'Yes' => 'true' ), 'heading' => __( 'Show reading time', 'bt_plugin' ), 'group' => __( 'Display', 'bold-news' ) ),
				array( 'param_name' => 'show_views_count', 'type' => 'checkbox', 'value' => array( 'Yes' => 'true' ), 'heading' => __( 'Show views count', 'bt_plugin' ), 'group' => __( 'Display', 'bold-news' ) ),
				array( 'param_name' => 'show_review', 'type' => 'checkbox', 'value' => array( 'Yes' => 'true' ), 'heading' => __( 'Show review', 'bt_plugin' ), 'group' => __( 'Display', 'bold-news' ) ),
				array( 'param_name' => 'el_class', 'type' => 'textfield', 'heading' => __( 'Extra Class Name(s)', 'bt_plugin' ), 'group' => __( 'Custom', 'bold-builder' ) ),
				array( 'param_name' => 'el_style', 'type' => 'textfield', 'heading' => __( 'Inline Style', 'bt_plugin' ), 'group' => __( 'Custom', 'bold-builder' ) )
			) )
		);		
	
		bt_rc_map( 'bt_image', array( 'name' => __( 'Image', 'bt_plugin' ), 'description' => __( 'Single image', 'bt_plugin' ), 'container' => 'vertical', 'accept' => array( 'bt_header' => true, 'bt_text' => true, 'bt_hr' => true, 'bt_icon' => true, 'bt_button' => true ), 'icon' => 'bt_bb_icon_bt_bb_image',
			'params' => array(
				array( 'param_name' => 'image', 'type' => 'attach_image', 'heading' => __( 'Image', 'bt_plugin' ), 'preview' => true ),
				array( 'param_name' => 'caption_text', 'type' => 'textfield', 'heading' => __( 'Caption Supetitle', 'bt_plugin' ) ),		
				array( 'param_name' => 'caption_title', 'type' => 'textfield', 'heading' => __( 'Caption', 'bt_plugin' ) ),
				array( 'param_name' => 'show_titles', 'type' => 'dropdown', 'heading' => __( 'Show Captions', 'bt_plugin' ), 
					'value' => array(
						__( 'No', 'bt_plugin' ) => 'no',
						__( 'Yes', 'bt_plugin' ) => 'yes' 
				) ),
				array( 'param_name' => 'size', 'type' => 'dropdown', 'heading' => __( 'Size', 'bt_plugin' ), 'group' => __( 'Design', 'bold-builder' ),
					'value' => array(
						__( 'Full', 'bt_plugin' ) => 'full',
						__( 'Small (320px)', 'bt_plugin' ) => 'boldthemes_small',
						__( 'Small Square (320x320px)', 'bt_plugin' ) => 'boldthemes_small_square',
						__( 'Small Rectangle (320x240px)', 'bt_plugin' ) => 'boldthemes_small_rectangle',
						__( 'Medium (640px)', 'bt_plugin' ) => 'boldthemes_medium',
						__( 'Medium Square (640x640px)', 'bt_plugin' ) => 'boldthemes_medium_square',
						__( 'Medium Rectangle (640x480px)', 'bt_plugin' ) => 'boldthemes_medium_rectangle',
						__( 'Large (1280px)', 'bt_plugin' ) => 'boldthemes_large',
						__( 'Large Square (1280x1280px)', 'bt_plugin' ) => 'boldthemes_large_square',
						__( 'Large Rectangle (1280x640px)', 'bt_plugin' ) => 'boldthemes_large_rectangle',
						__( 'Large Vertical Rectangle (640x1280px)', 'bt_plugin' ) => 'boldthemes_large_vertical_rectangle',
						__( 'Thumbnail  (160x160px)', 'bt_plugin' ) => 'thumbnail'
				) ),
				array( 'param_name' => 'shape', 'type' => 'dropdown', 'heading' => __( 'Shape', 'bt_plugin' ), 'group' => __( 'Design', 'bold-builder' ), 'preview' => true,
					'value' => array(
						__( 'Square', 'bt_plugin' ) => 'square',
						__( 'Square Outlined', 'bt_plugin' ) => 'outlined',
						__( 'Square Rounded', 'bt_plugin' ) => 'rounded',
						__( 'Circle', 'bt_plugin' ) => 'circle'
				) ),
				array( 'param_name' => 'hover_type', 'type' => 'dropdown', 'heading' => __( 'Hover Type', 'bt_plugin' ), 'group' => __( 'Design', 'bold-builder' ),
					'value' => array(
						__( 'Default (Direction based)', 'bt_plugin' ) => 'btDefaultHoverType',
						__( 'Zoom in', 'bt_plugin' ) => 'btZoomInHoverType',
						__( 'Zoom in & Twist', 'bt_plugin' ) => 'btZoomInTwistHoverType',
						__( 'To Grayscale', 'bt_plugin' ) => 'btToGrayscaleHoverType',
						__( 'Simple', 'bt_plugin' ) => 'btSimpleHoverType'
				) ),
				array( 'param_name' => 'url', 'type' => 'textfield', 'heading' => __( 'URL', 'bt_plugin' ), 'preview' => true ),
				array( 'param_name' => 'target', 'type' => 'dropdown', 'heading' => __( 'Target', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'Self', 'bt_plugin' ) => '_self',
						__( 'Blank', 'bt_plugin' ) => '_blank'
				) ),
				array( 'param_name' => 'el_class', 'type' => 'textfield', 'heading' => __( 'Extra Class Name(s)', 'bt_plugin' ), 'group' => __( 'Custom', 'bold-builder' ) ),
				array( 'param_name' => 'el_style', 'type' => 'textfield', 'heading' => __( 'Inline Style', 'bt_plugin' ), 'group' => __( 'Custom', 'bold-builder' ) )
			) )
		);

		bt_rc_map( 'bt_section', array( 'name' => __( 'Section', 'bt_plugin' ), 'description' => __( 'Basic root element', 'bt_plugin' ), 'icon' => 'bt_bb_icon_bt_bb_row_inner', 'root' => true, 'container' => 'vertical', 'accept' => array( 'bt_row' => true ), 'toggle' => true, 'show_settings_on_create' => false, 
			'params' => array( 
				array( 'param_name' => 'layout', 'type' => 'dropdown', 'heading' => __( 'Layout', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'Boxed (default 1200px)', 'bt_plugin' ) => 'boxed',
						__( 'Boxed (1100px)', 'bt_plugin' ) => 'boxed-1100',
						__( 'Boxed (1000px)', 'bt_plugin' ) => 'boxed-1000',
						__( 'Boxed (900px)', 'bt_plugin' ) => 'boxed-900',
						__( 'Boxed (800px)', 'bt_plugin' ) => 'boxed-800',
						__( 'Wide', 'bt_plugin' ) => 'wide'
				) ),		
				array( 'param_name' => 'top_spaced', 'type' => 'dropdown', 'heading' => __( 'Top spaced', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'No', 'bt_plugin' ) => 'not-spaced',
						__( 'Extra-Small-Spaced', 'bt_plugin' ) => 'topExtraSmallSpaced',
						__( 'Small-Spaced', 'bt_plugin' ) => 'topSmallSpaced',		
						__( 'Medium-Spaced', 'bt_plugin' ) => 'topMediumSpaced',
						__( 'Semi-Spaced', 'bt_plugin' ) => 'topSemiSpaced',
						__( 'Spaced', 'bt_plugin' ) => 'topSpaced',
						__( 'Large Spaced', 'bt_plugin' ) => 'topLargeSpaced',
						__( 'Extra-Large Spaced', 'bt_plugin' ) => 'topExtraSpaced'
				) ),
				array( 'param_name' => 'bottom_spaced', 'type' => 'dropdown', 'heading' => __( 'Bottom spaced', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'No', 'bt_plugin' ) => 'not-spaced',
						__( 'Extra-Small-Spaced', 'bt_plugin' ) => 'bottomExtraSmallSpaced',		
						__( 'Small-Spaced', 'bt_plugin' ) => 'bottomSmallSpaced',
						__( 'Medium-Spaced', 'bt_plugin' ) => 'bottomMediumSpaced',
						__( 'Semi-Spaced', 'bt_plugin' ) => 'bottomSemiSpaced',
						__( 'Spaced', 'bt_plugin' ) => 'bottomSpaced',
						__( 'Large Spaced', 'bt_plugin' ) => 'bottomLargeSpaced',
						__( 'Extra-Spaced', 'bt_plugin' ) => 'bottomExtraSpaced'
				) ),
				array( 'param_name' => 'skin', 'type' => 'dropdown', 'heading' => __( 'Skin', 'bt_plugin' ), 'group' => __( 'Design', 'bold-builder' ), 'preview' => true,
					'value' => array(
						__( 'Inherit', 'bt_plugin' ) => 'inherit',			
						__( 'Dark', 'bt_plugin' ) => 'dark',
						__( 'Light', 'bt_plugin' ) => 'light',
						__( 'Accent', 'bt_plugin' ) => 'accent',
						__( 'Accent + Light text', 'bt_plugin' ) => 'accent-dark',
						__( 'Alternate', 'bt_plugin' ) => 'alternate',
						__( 'Alternate + Dark text', 'bt_plugin' ) => 'alternate-dark'
						
				) ),
				array( 'param_name' => 'full_screen', 'type' => 'dropdown', 'heading' => __( 'Full Screen', 'bt_plugin' ), 
					'value' => array(
						__( 'No', 'bt_plugin' ) => 'no',
						__( 'Yes', 'bt_plugin' ) => 'yes'
				) ),
				array( 'param_name' => 'vertical_align', 'type' => 'dropdown', 'heading' => __( 'Vertical Align', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'Inherit', 'bt_plugin' ) => 'inherit',
						__( 'Top', 'bt_plugin' )     => 'btTopVertical',
						__( 'Middle', 'bt_plugin' )  => 'btMiddleVertical',
						__( 'Bottom', 'bt_plugin' )  => 'btBottomVertical'					
				) ),
				array( 'param_name' => 'divider', 'type' => 'dropdown', 'heading' => __( 'Divider', 'bt_plugin' ), 
					'value' => array(
						__( 'No', 'bt_plugin' ) => 'no',
						__( 'Yes', 'bt_plugin' ) => 'yes'
				) ),
				array( 'param_name' => 'back_image', 'type' => 'attach_image', 'heading' => __( 'Background Image', 'bt_plugin' ), 'group' => __( 'Design', 'bold-builder' ) ),
				array( 'param_name' => 'back_color', 'type' => 'colorpicker', 'heading' => __( 'Background color', 'bt_plugin' ), 'group' => __( 'Design', 'bold-builder' ) ),
				array( 'param_name' => 'back_overlay', 'type' => 'dropdown', 'heading' => __( 'Background Overlay', 'bt_plugin' ), 'group' => __( 'Design', 'bold-builder' ), 
					'value' => array(
						__( 'None', 'bt_plugin' )				=> '',
						__( 'Light Stripes', 'bt_plugin' )		=> 'btBackgroundOverlay btStripedLight',
						__( 'Dark Stripes', 'bt_plugin' )		=> 'btBackgroundOverlay btStripedDark',
						__( 'Dark Solid', 'bt_plugin' )			=> 'btBackgroundOverlay btSolidDarkBackground',
						__( 'Light Solid', 'bt_plugin' )		=> 'btBackgroundOverlay btSolidLightBackground'
				) ),
				array( 'param_name' => 'back_video', 'type' => 'textfield', 'heading' => __( 'YouTube Background Video', 'bt_plugin' ), 'group' => __( 'Video', 'bold-builder' ) ),
				array( 'param_name' => 'video_settings', 'type' => 'textfield', 'heading' => __( 'Video Settings (e.g. startAt:20, mute:true, stopMovieOnBlur:false)', 'bt_plugin' ), 'group' => __( 'Video', 'bold-builder' ) ),
				array( 'param_name' => 'back_video_mp4', 'type' => 'textfield', 'heading' => __( 'MP4 Background Video', 'bt_plugin' ), 'group' => __( 'Video', 'bold-builder' ) ),
				array( 'param_name' => 'back_video_ogg', 'type' => 'textfield', 'heading' => __( 'Ogg Background Video', 'bt_plugin' ), 'group' => __( 'Video', 'bold-builder' ) ),
				array( 'param_name' => 'back_video_webm', 'type' => 'textfield', 'heading' => __( 'WebM Background Video', 'bt_plugin' ), 'group' => __( 'Video', 'bold-builder' ) ),				
				array( 'param_name' => 'parallax', 'type' => 'textfield', 'heading' => __( 'Parallax (e.g. -.7)', 'bt_plugin' ), 'group' => __( 'Design', 'bold-builder' ) ),
				array( 'param_name' => 'parallax_offset', 'type' => 'textfield', 'heading' => __( 'Parallax Offset in px (e.g. -100)', 'bt_plugin' ), 'group' => __( 'Design', 'bold-builder' ) ),
				array( 'param_name' => 'animation', 'type' => 'dropdown', 'heading' => __( 'Animation (forward)', 'bt_plugin' ), 'group' => __( 'Animations', 'bold-builder' ), 'value' => $section_anims ),
				array( 'param_name' => 'animation_back', 'type' => 'dropdown', 'heading' => __( 'Animation (backward)', 'bt_plugin' ), 'group' => __( 'Animations', 'bold-builder' ), 'value' => $section_anims ),
				array( 'param_name' => 'animation_impress', 'type' => 'textfield', 'heading' => __( 'Impress Animation Settings', 'bt_plugin' ), 'group' => __( 'Animations', 'bold-builder' ), 'description' => 'x,y,z;rotate,rotate-x,rotate-y;scale' ),
				array( 'param_name' => 'posts_category', 'type' => 'textfield', 'heading' => __( 'Categories', 'bt_plugin' ), 'preview' => true, 'group' => __( 'Posts', 'bold-builder' ), 'description' => __( 'Category slug or comma-separated slugs or taxonomy:slug1,slug2, etc. for custom taxonomy.', 'bold-builder' ) ),
				array( 'param_name' => 'posts_author', 'type' => 'textfield', 'heading' => __( 'Author username', 'bt_plugin' ), 'preview' => true, 'group' => __( 'Posts', 'bold-builder' ) ),
				array( 'param_name' => 'show_prev', 'type' => 'checkbox', 'value' => array( 'Yes' => 'yes' ), 'heading' => __( 'Include previous posts', 'bt_plugin' ), 'preview' => true, 'group' => __( 'Posts', 'bold-news' ) ),
				array( 'param_name' => 'show_sticky', 'type' => 'checkbox', 'value' => array( 'Yes' => 'yes' ), 'heading' => __( 'Show sticky', 'bt_plugin' ), 'group' => __( 'Posts', 'bold-news' ) ),
				array( 'param_name' => 'el_id', 'type' => 'textfield', 'heading' => __( 'Custom Id Attribute', 'bt_plugin' ), 'group' => __( 'Custom', 'bold-builder' ) ),
				array( 'param_name' => 'el_class', 'type' => 'textfield', 'heading' => __( 'Extra Class Name(s)', 'bt_plugin' ), 'group' => __( 'Custom', 'bold-builder' ) ),
				array( 'param_name' => 'el_style', 'type' => 'textfield', 'heading' => __( 'Inline Style', 'bt_plugin' ), 'group' => __( 'Custom', 'bold-builder' ) )
			) )
		);

		bt_rc_map( 'bt_post_container', array( 'name' => __( 'Post Container', 'bt_plugin' ), 'description' => __( 'Container for Single Post Template', 'bt_plugin' ), 'icon' => 'bt_bb_icon_bt_post_container', 'container' => 'vertical', 'accept' => array( 'bt_single_post_template' => true, 'bt_header' => true, 'bt_hr' => true, 'bt_text' => true, 'bt_button' => true, 'bt_icon' => true, 'bt_image' => true ), 'toggle' => true, 'show_settings_on_create' => true, 
			'params' => array(
				array( 'param_name' => 'posts_category', 'type' => 'textfield', 'heading' => __( 'Categories', 'bt_plugin' ), 'preview' => true, 'group' => __( 'Posts', 'bold-builder' ), 'description' => __( 'Category slug or comma-separated slugs or taxonomy:slug1,slug2, etc. for custom taxonomy.', 'bold-builder' ) ),
				array( 'param_name' => 'posts_author', 'type' => 'textfield', 'heading' => __( 'Author username', 'bt_plugin' ), 'preview' => true, 'group' => __( 'Posts', 'bold-builder' ) ),
				array( 'param_name' => 'show_prev', 'type' => 'checkbox', 'value' => array( 'Yes' => 'yes' ), 'heading' => __( 'Include previous posts', 'bt_plugin' ), 'preview' => true, 'group' => __( 'Posts', 'bold-news' ) ),
				array( 'param_name' => 'show_sticky', 'type' => 'checkbox', 'value' => array( 'Yes' => 'yes' ), 'heading' => __( 'Show sticky', 'bt_plugin' ), 'group' => __( 'Posts', 'bold-news' ) ),
				array( 'param_name' => 'el_id', 'type' => 'textfield', 'heading' => __( 'Custom Id Attribute', 'bt_plugin' ), 'group' => __( 'Custom', 'bold-builder' ) ),
				array( 'param_name' => 'el_class', 'type' => 'textfield', 'heading' => __( 'Extra Class Name(s)', 'bt_plugin' ), 'group' => __( 'Custom', 'bold-builder' ) ),
				array( 'param_name' => 'el_style', 'type' => 'textfield', 'heading' => __( 'Inline Style', 'bt_plugin' ), 'group' => __( 'Custom', 'bold-builder' ) )
			) )
		);
		
		bt_rc_map( 'bt_row', array( 'name' => __( 'Row', 'bt_plugin' ), 'description' => __( 'Row element', 'bt_plugin' ), 'container' => 'horizontal', 'accept' => array( 'bt_column' => true ), 'toggle' => true, 'show_settings_on_create' => false,
			'params' => array(
				array( 'param_name' => 'cell_spacing', 'type' => 'dropdown', 'heading' => __( 'Cell Spacing', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'Default', 'bt_plugin' ) => '',
						__( 'No', 'bt_plugin' ) => 'btNoRowSpacing',
						__( 'Double', 'bt_plugin' ) => 'btDoubleRowSpacing',
						__( 'Triple', 'bt_plugin' ) => 'btTripleRowSpacing'						
				) ),
				array( 'param_name' => 'el_class', 'type' => 'textfield', 'heading' => __( 'Extra Class Name(s)', 'bt_plugin' ) ),
				array( 'param_name' => 'el_style', 'type' => 'textfield', 'heading' => __( 'Inline Style', 'bt_plugin' ) )
			) )
		);

		bt_rc_map( 'bt_row_inner', array( 'name' => __( 'Inner Row', 'bt_plugin' ), 'description' => __( 'Inner Row element', 'bt_plugin' ), 'icon' => 'bt_bb_icon_bt_bb_row_inner', 'container' => 'horizontal', 'accept' => array( 'bt_column_inner' => true ), 'toggle' => true, 'show_settings_on_create' => false,
			'params' => array( 
				array( 'param_name' => 'cell_spacing', 'type' => 'dropdown', 'heading' => __( 'Cell Spacing', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'Default', 'bt_plugin' ) => '',
						__( 'No', 'bt_plugin' ) => 'btNoRowSpacing',
						__( 'Double', 'bt_plugin' ) => 'btDoubleRowSpacing',
						__( 'Triple', 'bt_plugin' ) => 'btTripleRowSpacing'					
				) ),
				array( 'param_name' => 'el_class', 'type' => 'textfield', 'heading' => __( 'Extra Class Name(s)', 'bt_plugin' ), 'group' => __( 'Custom', 'bold-builder' ) ),
				array( 'param_name' => 'el_style', 'type' => 'textfield', 'heading' => __( 'Inline Style', 'bt_plugin' ), 'group' => __( 'Custom', 'bold-builder' ) )
			) )
		);

		bt_rc_map( 'bt_custom_menu', array( 'name' => __( 'Custom Menu', 'bt_plugin' ), 'description' => __( 'Custom Menu', 'bt_plugin' ), 'icon' => 'bt_bb_icon_bt_bb_custom_menu',
			'params' => array( 
				array( 'param_name' => 'menu', 'type' => 'textfield', 'heading' => __( 'Menu Name', 'bt_plugin' ) ),		
				array( 'param_name' => 'el_class', 'type' => 'textfield', 'heading' => __( 'Extra Class Name(s)', 'bt_plugin' ) ),
				array( 'param_name' => 'el_style', 'type' => 'textfield', 'heading' => __( 'Inline Style', 'bt_plugin' ) )
			) )
		);
		
		bt_rc_map( 'bt_column', array( 'name' => __( 'Column', 'bt_plugin' ), 'description' => __( 'Column element', 'bt_plugin' ), 'width_param' => 'width', 'container' => 'vertical', 'accept' => array( 'bt_section' => false, 'bt_row' => false, 'bt_column' => false, 'bt_column_inner' => false, '_content' => false, 'bt_client' => false, 'bt_tabs_items' => false, 'bt_accordion_items' => false, 'bt_slider_item' => false, 'bt_slider_post_item' => false, 'bt_cc_item' => false, 'bt_cc_multiply' => false,'bt_cc_group' => false ), 'accept_all' => true, 'toggle' => true,
			'params' => array(
				array( 'param_name' => 'align', 'type' => 'dropdown', 'heading' => __( 'Align', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'Left', 'bt_plugin' ) => 'left',
						__( 'Right', 'bt_plugin' ) => 'right',
						__( 'Center', 'bt_plugin' ) => 'center'					
				) ),
				array( 'param_name' => 'vertical_align', 'type' => 'dropdown', 'heading' => __( 'Vertical Align', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'Inherit', 'bt_plugin' ) => 'inherit',
						__( 'Top', 'bt_plugin' )     => 'btTopVertical',
						__( 'Middle', 'bt_plugin' )  => 'btMiddleVertical',
						__( 'Bottom', 'bt_plugin' )  => 'btBottomVertical'					
				) ),
				array( 'param_name' => 'border', 'type' => 'dropdown', 'heading' => __( 'Border', 'bt_plugin' ),
					'value' => array(
						__( 'No Border', 'bt_plugin' ) => 'no_border',
						__( 'Left', 'bt_plugin' )      => 'btLeftBorder',
						__( 'Right', 'bt_plugin' )     => 'btRightBorder'
				) ),				
				array( 'param_name' => 'cell_padding', 'type' => 'dropdown', 'heading' => __( 'Padding', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'Default', 'bt_plugin' ) => 'default',
						__( 'No padding', 'bt_plugin' ) => 'btNoPadding',
						__( 'Double padding', 'bt_plugin' ) => 'btDoublePadding',
						__( 'Text indent', 'bt_plugin' ) => 'btTextIndent'			
				) ),
				array( 'param_name' => 'animation', 'type' => 'dropdown', 'heading' => __( 'Animation', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'No Animation', 'bt_plugin' ) => 'no_animation',
						__( 'Fade In', 'bt_plugin' ) => 'animate animate-fadein',
						__( 'Move Up', 'bt_plugin' ) => 'animate animate-moveup',
						__( 'Move Left', 'bt_plugin' ) => 'animate animate-moveleft',
						__( 'Move Right', 'bt_plugin' ) => 'animate animate-moveright',
						__( 'Move Down', 'bt_plugin' ) => 'animate animate-movedown',
						__( 'Fade In / Move Up', 'bt_plugin' ) => 'animate animate-fadein animate-moveup',
						__( 'Fade In / Move Left', 'bt_plugin' ) => 'animate animate-fadein animate-moveleft',
						__( 'Fade In / Move Right', 'bt_plugin' ) => 'animate animate-fadein animate-moveright',
						__( 'Fade In / Move Down', 'bt_plugin' ) => 'animate animate-fadein animate-movedown'				
				) ),
				array( 'param_name' => 'highlight', 'type' => 'dropdown', 'heading' => __( 'Cell highlight', 'bt_plugin' ), 'group' => __( 'Design', 'bold-builder' ),
					'value' => array(
						__( 'No', 'bt_plugin' ) => 'no_highlight',
						__( 'Yes', 'bt_plugin' ) => 'btHighlight'
				) ),
				array( 'param_name' => 'background_color', 'type' => 'colorpicker', 'heading' => __( 'Background color', 'bt_plugin' ), 'group' => __( 'Design', 'bold-builder' ) ),
				array( 'param_name' => 'transparent', 'type' => 'textfield', 'heading' => __( 'Transparent (e.g. 0.4)', 'bt_plugin' ), 'group' => __( 'Design', 'bold-builder' ) ),
				array( 'param_name' => 'inner_background_color', 'type' => 'colorpicker', 'heading' => __( 'Inner Background color', 'bt_plugin' ), 'group' => __( 'Design', 'bold-builder' ) ),
				array( 'param_name' => 'background_image', 'type' => 'attach_image', 'heading' => __( 'Background image', 'bt_plugin' ), 'group' => __( 'Design', 'bold-builder' ) ),
				array( 'param_name' => 'el_class', 'type' => 'textfield', 'heading' => __( 'Extra Class Name(s)', 'bt_plugin' ), 'group' => __( 'Custom', 'bold-builder' ) ),
				array( 'param_name' => 'el_style', 'type' => 'textfield', 'heading' => __( 'Inline Style', 'bt_plugin' ), 'group' => __( 'Custom', 'bold-builder' ) )
			) )
		);

		bt_rc_map( 'bt_column_inner', array( 'name' => __( 'Inner Column', 'bt_plugin' ), 'description' => __( 'Inner Column element', 'bt_plugin' ), 'icon' => 'bt_bb_icon_bt_bb_row_inner', 'width_param' => 'width', 'container' => 'vertical', 'accept' => array( 'bt_section' => false, 'bt_row' => false, 'bt_column' => false, '_content' => false, 'bt_client' => false, 'bt_tabs_items' => false, 'bt_accordion_items' => false, 'bt_slider_item' => false ), 'accept_all' => true, 'toggle' => true,
			'params' => array(
				array( 'param_name' => 'align', 'type' => 'dropdown', 'heading' => __( 'Align', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'Left', 'bt_plugin' ) => 'left',
						__( 'Right', 'bt_plugin' ) => 'right',
						__( 'Center', 'bt_plugin' ) => 'center'					
				) ),
				array( 'param_name' => 'cell_padding', 'type' => 'dropdown', 'heading' => __( 'Padding', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'Default', 'bt_plugin' ) => 'default',
						__( 'No padding', 'bt_plugin' ) => 'btNoPadding',
						__( 'Double padding', 'bt_plugin' ) => 'btDoublePadding',
						__( 'Text indent', 'bt_plugin' ) => 'btTextIndent'							
				) ),				
				array( 'param_name' => 'vertical_align', 'type' => 'dropdown', 'heading' => __( 'Vertical Align', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'Inherit', 'bt_plugin' ) => 'inherit',
						__( 'Top', 'bt_plugin' )     => 'btTopVertical',
						__( 'Middle', 'bt_plugin' )  => 'btMiddleVertical',
						__( 'Bottom', 'bt_plugin' )  => 'btBottomVertical'					
				) ),
				array( 'param_name' => 'highlight', 'type' => 'dropdown', 'heading' => __( 'Highlight', 'bt_plugin' ),
					'value' => array(
						__( 'No', 'bt_plugin' ) => 'no_highlight',
						__( 'Yes', 'bt_plugin' ) => 'btHighlight'
				) ),
				array( 'param_name' => 'animation', 'type' => 'dropdown', 'heading' => __( 'Animation', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'No Animation', 'bt_plugin' ) => 'no_animation',
						__( 'Fade In', 'bt_plugin' ) => 'animate animate-fadein',
						__( 'Move Up', 'bt_plugin' ) => 'animate animate-moveup',
						__( 'Move Left', 'bt_plugin' ) => 'animate animate-moveleft',
						__( 'Move Right', 'bt_plugin' ) => 'animate animate-moveright',
						__( 'Move Down', 'bt_plugin' ) => 'animate animate-movedown',
						__( 'Fade In / Move Up', 'bt_plugin' ) => 'animate animate-fadein animate-moveup',
						__( 'Fade In / Move Left', 'bt_plugin' ) => 'animate animate-fadein animate-moveleft',
						__( 'Fade In / Move Right', 'bt_plugin' ) => 'animate animate-fadein animate-moveright',
						__( 'Fade In / Move Down', 'bt_plugin' ) => 'animate animate-fadein animate-movedown'				
				) ),
				array( 'param_name' => 'background_color', 'type' => 'colorpicker', 'heading' => __( 'Background color', 'bt_plugin' ) ),
				array( 'param_name' => 'opacity', 'type' => 'textfield', 'heading' => __( 'Opacity (0 - 1, e.g. 0.4)', 'bt_plugin' ) ),
				array( 'param_name' => 'el_class', 'type' => 'textfield', 'heading' => __( 'Extra Class Name(s)', 'bt_plugin' ), 'group' => __( 'Custom', 'bold-builder' ) ),
				array( 'param_name' => 'el_style', 'type' => 'textfield', 'heading' => __( 'Inline Style', 'bt_plugin' ), 'group' => __( 'Custom', 'bold-builder' ) )
			) )
		);
		
		bt_rc_map( 'bt_text', array( 'name' => __( 'Text', 'bt_plugin' ), 'description' => __( 'Text element', 'bt_plugin' ), 'container' => 'vertical', 'accept' => array( '_content' => true ), 'toggle' => true, 'show_settings_on_create' => false, 'icon' => 'bt_bb_icon_bt_bb_text' ) );
		
		bt_rc_map( 'bt_header', array( 'name' => __( 'Header', 'bt_plugin' ), 'description' => __( 'Header element', 'bt_plugin' ), 'icon' => 'bt_bb_icon_bt_bb_headline',
			'params' => array( 
				array( 'param_name' => 'superheadline', 'type' => 'textfield', 'heading' => __( 'Superheadline', 'bt_plugin' ) ),
				array( 'param_name' => 'headline', 'type' => 'textarea', 'heading' => __( 'Headline', 'bt_plugin' ), 'preview' => true ),
				array( 'param_name' => 'headline_size', 'type' => 'dropdown', 'heading' => __( 'Headline Size', 'bt_plugin' ), 'preview' => true, 
					'value' => array(
						__( 'Small', 'bt_plugin' ) => 'small',
						__( 'ExtraSmall', 'bt_plugin' ) => 'extrasmall',
						__( 'Medium', 'bt_plugin' ) => 'medium',
						__( 'Large', 'bt_plugin' ) => 'large',
						__( 'Extra large', 'bt_plugin' ) => 'extralarge',
						__( 'Huge', 'bt_plugin' ) => 'huge'
				) ),		
				array( 'param_name' => 'headline_style', 'type' => 'dropdown', 'heading' => __( 'Headline Style', 'bt_plugin' ), 'preview' => true, 
					'value' => array(
						__( 'Regular', 'bt_plugin' ) => 'regular',
						__( 'Thin', 'bt_plugin' ) => 'thin',
						__( 'Bold', 'bt_plugin' ) => 'bold'
		 		) ),
				array( 'param_name' => 'dash', 'type' => 'dropdown', 'heading' => __( 'Dash', 'bt_plugin' ), 'preview' => true, 
					'value' => array(
						__( 'No', 'bt_plugin' ) => 'no',
						__( 'Top', 'bt_plugin' ) => 'top',
						__( 'Bottom', 'bt_plugin' ) => 'bottom',
						__( 'Top and Bottom', 'bt_plugin' ) => 'top bottom'
		 		) ),
				array( 'param_name' => 'subheadline', 'type' => 'textarea', 'heading' => __( 'Subheadline', 'bt_plugin' ) ),
				array( 'param_name' => 'el_class', 'type' => 'textfield', 'heading' => __( 'Extra Class Name(s)', 'bt_plugin' ), 'group' => __( 'Custom', 'bold-builder' ) ),
				array( 'param_name' => 'el_style', 'type' => 'textfield', 'heading' => __( 'Inline Style', 'bt_plugin' ), 'group' => __( 'Custom', 'bold-builder' ) )
			) )
		);
		
		bt_rc_map( 'bt_tabs', array( 'name' => __( 'Tabs', 'bt_plugin' ), 'description' => __( 'Tabs container', 'bt_plugin' ), 'container' => 'vertical', 'icon' => 'bt_bb_icon_bt_bb_tabs', 'accept' => array( 'bt_tabs_items' => true ), 'show_settings_on_create' => false ));
		
		bt_rc_map( 'bt_tabs_items', array( 'name' => __( 'Tab Item', 'bt_plugin' ), 'description' => __( 'Tabs items', 'bt_plugin' ), 'container' => 'vertical', 'icon' => 'bt_bb_icon_bt_bb_tabs', 'accept' => array( 'content' => true, 'bt_row_inner' => true, 'bt_header' => true, 'bt_text' => true, 'bt_hr' => true, 'bt_image' => true, 'bt_icon' => true, 'bt_button' => true ), 'params' => array(
				array( 'param_name' => 'headline', 'type' => 'textfield', 'heading' => __( 'Headline', 'bt_plugin' ), 'preview' => true )
			) )
		);
		
		bt_rc_map( 'bt_accordion', array( 'name' => __( 'Accordion', 'bt_plugin' ), 'description' => __( 'Accordion container', 'bt_plugin' ), 'container' => 'vertical', 'icon' => 'bt_bb_icon_bt_bb_accordion', 'accept' => array( 'bt_accordion_items' => true ), 'show_settings_on_create' => false ));
		
		bt_rc_map( 'bt_accordion_items', array( 'name' => __( 'Accordion Item', 'bt_plugin' ), 'description' => __( 'Single accordion element', 'bt_plugin' ), 'icon' => 'bt_bb_icon_bt_bb_accordion', 'container' => 'vertical', 'accept' => array( 'content' => true, 'bt_row_inner' => true, 'bt_text' => true, 'bt_hr' => true, 'bt_header' => true, 'bt_image' => true, 'bt_icon' => true, 'bt_button' => true ), 
			'params' => array(
				array( 'param_name' => 'headline', 'type' => 'textfield', 'heading' => __( 'Headline', 'bt_plugin' ), 'preview' => true )
			) )
		);
		
		bt_rc_map( 'bt_service', array( 'name' => __( 'Service', 'bt_plugin' ), 'description' => __( 'Service element', 'bt_plugin' ), 'icon' => 'bt_bb_icon_bt_bb_service',
			'params' => array(
				array( 'param_name' => 'icon', 'type' => 'iconpicker', 'preview' => true, 'heading' => __( 'Icon', 'bt_plugin' ), 'value' => $icon_arr ),	
				array( 'param_name' => 'icon_type', 'type' => 'dropdown', 'heading' => __( 'Icon Type', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'Default', 'bt_plugin' ) 	=> 'btIcoDefaultType',
						__( 'Filled', 'bt_plugin' )	 	=> 'btIcoFilledType',
						__( 'Outline', 'bt_plugin' )	=> 'btIcoOutlineType'
					) ),
				array( 'param_name' => 'icon_shape', 'type' => 'dropdown', 'heading' => __( 'Icon Shape', 'bt_plugin' ), 'preview' => true,
				'value' => array(
					__( 'Circle', 'bt_plugin' ) 	=> 'btIconCircleShape',
					__( 'Square', 'bt_plugin' )	 	=> 'btIconSquareShape',
					__( 'Hexagon', 'bt_plugin' )	=> 'btIconHexagonShape'
				) ),
				array( 'param_name' => 'icon_color', 'type' => 'dropdown', 'heading' => __( 'Icon Color', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'Default', 'bt_plugin' ) 	=> 'btIcoDefaultColor',
						__( 'Accent', 'bt_plugin' )	 	=> 'btIcoAccentColor',
						__( 'Alternate', 'bt_plugin' )	 	=> 'btIcoAlternateColor'
					) ),
				array( 'param_name' => 'icon_size', 'type' => 'dropdown', 'heading' => __( 'Icon Size', 'bt_plugin' ), 'preview' => true,
					'value' => array(
							__( 'Small', 'bt_plugin' ) 			=> 'btIcoSmallSize',		
							__( 'Extra Small', 'bt_plugin' )	=> 'btIcoExtraSmallSize',
							__( 'Medium', 'bt_plugin' )	 		=> 'btIcoMediumSize',
							__( 'Big', 'bt_plugin' )	 		=> 'btIcoBigSize',
							__( 'Large', 'bt_plugin' )			=> 'btIcoLargeSize'
					) ),
				array( 'param_name' => 'url', 'type' => 'textfield', 'heading' => __( 'URL', 'bt_plugin' ) ),
				array( 'param_name' => 'headline', 'type' => 'textfield', 'heading' => __( 'Headline', 'bt_plugin' ), 'preview' => true ),
				array( 'param_name' => 'dash', 'type' => 'dropdown', 'heading' => __( 'Dash', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'No', 'bt_plugin' ) 	=> '',
						__( 'Bottom', 'bt_plugin' )	 	=> 'bottom',
					) ),
				array( 'param_name' => 'text', 'type' => 'textarea', 'heading' => __( 'Text', 'bt_plugin' ) ),
				array( 'param_name' => 'el_class', 'type' => 'textfield', 'heading' => __( 'Extra Class Name(s)', 'bt_plugin' ), 'group' => __( 'Custom', 'bold-builder' ) ),
				array( 'param_name' => 'el_style', 'type' => 'textfield', 'heading' => __( 'Inline Style', 'bt_plugin' ), 'group' => __( 'Custom', 'bold-builder' ) )
			) )
		);
		
		bt_rc_map( 'bt_gmaps', array( 'name' => __( 'Google Maps', 'bt_plugin' ), 'description' => __( 'Google Maps with marker on specified coordinates', 'bt_plugin' ), 'container' => 'vertical', 'icon' => 'bt_bb_icon_bt_bb_google_maps_location', 'accept' => array( 'bt_header' => true, 'bt_button' => true, 'bt_counter' => true, 'bt_icon' => true, 'bt_image' => true, 'bt_text' => true, 'bt_hr' => true, 'bt_dropdown' => true, 'bt_service' => true ),
			'params' => array(
				array( 'param_name' => 'api_key', 'type' => 'textfield', 'heading' => __( 'API key', 'bt_plugin' ) ),
				array( 'param_name' => 'latitude', 'type' => 'textfield', 'heading' => __( 'Latitude', 'bt_plugin' ) ),
				array( 'param_name' => 'longitude', 'type' => 'textfield', 'heading' => __( 'Longitude', 'bt_plugin' ) ),
				array( 'param_name' => 'zoom', 'type' => 'textfield', 'heading' => __( 'Zoom (e.g. 14)', 'bt_plugin' ) ),
				array( 'param_name' => 'icon', 'type' => 'attach_image', 'heading' => __( 'Icon', 'bt_plugin' ) ),
				array( 'param_name' => 'height', 'type' => 'textfield', 'heading' => __( 'Height (e.g. 250px)', 'bt_plugin' ) ),
				array( 'param_name' => 'primary_color', 'type' => 'colorpicker', 'heading' => __( 'Map primary color', 'bt_plugin' ) ),
				array( 'param_name' => 'secondary_color', 'type' => 'colorpicker', 'heading' => __( 'Map secondary color', 'bt_plugin' ) ),
				array( 'param_name' => 'water_color', 'type' => 'colorpicker', 'heading' => __( 'Map water color', 'bt_plugin' ) ),
				array( 'param_name' => 'custom_style', 'type' => 'textarea_object', 'heading' => __( 'Custom map style array', 'bt_plugin' ), 'description' => 'Find more custom styles at https://snazzymaps.com/' ),
				array( 'param_name' => 'el_class', 'type' => 'textfield', 'heading' => __( 'Extra Class Name(s)', 'bt_plugin' ), 'group' => __( 'Custom', 'bold-builder' ) ),
				array( 'param_name' => 'el_style', 'type' => 'textfield', 'heading' => __( 'Inline Style', 'bt_plugin' ), 'group' => __( 'Custom', 'bold-builder' ) )
			) )
		);
		
		bt_rc_map( 'bt_clients', array( 'name' => __( 'Simple slider', 'bt_plugin' ), 'container' => 'vertical', 'icon' => 'bt_bb_icon_bt_bb_clients', 'description' => __( 'Simple slider', 'bt_plugin' ), 'accept' => array( 'bt_client' => true ), 'toggle' => true, 'show_settings_on_create' => false,
			'params' => array(
				array( 'param_name' => 'loop_type', 'type' => 'dropdown', 'heading' => __( 'Type', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'Finite', 'bt_plugin' ) => 'slider',
						__( 'Infinite', 'bt_plugin' ) => 'regular'
					)
				),
				array( 'param_name' => 'slides', 'type' => 'dropdown', 'heading' => __( 'Slides to Show', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( '3', 'bt_plugin' ) => '3',
						__( '4', 'bt_plugin' ) => '4',
						__( '5', 'bt_plugin' ) => '5',
						__( '6', 'bt_plugin' ) => '6'
					)
				),
				array( 'param_name' => 'slides_padding', 'type' => 'dropdown', 'heading' => __( 'Slides Padding', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'No padding', 'bt_plugin' ) => 'btNoPadding',
						__( 'Default padding', 'bt_plugin' ) => 'btDefaultPadding',
						__( 'Double padding', 'bt_plugin' ) => 'btDoublePadding'
					)
				),
				array( 'param_name' => 'arrow_position', 'type' => 'dropdown', 'heading' => __( 'Arrow position', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'On top', 'bt_plugin' ) => 'btOnTop',
						__( 'Next to slides', 'bt_plugin' ) => 'btNextToSlides'
					)
				),
				array( 'param_name' => 'auto_play', 'type' => 'textfield', 'heading' => __( 'Auto Play Speed (e.g. 3000)', 'bt_plugin' ) )
			) )
		);
		
		bt_rc_map( 'bt_client', array( 'name' => __( 'Simple slider item', 'bt_plugin' ), 'description' => __( 'Simple slider item', 'bt_plugin' ), 'container' => 'vertical', 'icon' => 'bt_bb_icon_bt_bb_clients', 'accept' => array( 'bt_header' => true, 'bt_text' => true, 'bt_service' => true, 'bt_image' => true, 'bt_hr' => true, 'bt_icon' => true, 'bt_button' => true, 'bt_single_post_template' => true ),
			'params' => array(	
				array( 'param_name' => 'el_class', 'type' => 'textfield', 'heading' => __( 'Extra Class Name(s)', 'bt_plugin' ), 'group' => __( 'Custom', 'bold-builder' ) ),
				array( 'param_name' => 'el_style', 'type' => 'textfield', 'heading' => __( 'Inline Style', 'bt_plugin' ), 'group' => __( 'Custom', 'bold-builder' ) )
			) )
		);
		
		bt_rc_map( 'bt_twitter', array( 'name' => __( 'Twitter', 'bt_plugin' ), 'description' => __( 'Twitter posts', 'bt_plugin' ), 'icon' => 'bt_bb_icon_bt_bb_twitter',
			'params' => array(
				array( 'param_name' => 'number', 'type' => 'textfield', 'heading' => __( 'Number of Tweets', 'bt_plugin' ) ),
				array( 'param_name' => 'username', 'type' => 'textfield', 'heading' => __( 'Username (or #hashtag)', 'bt_plugin' ) ),
				array( 'param_name' => 'cache', 'type' => 'textfield', 'heading' => __( 'Cache (minutes)', 'bt_plugin' ) ),
				array( 'param_name' => 'cache_id', 'type' => 'textfield', 'heading' => __( 'Cache ID', 'bt_plugin' ) ),
				array( 'param_name' => 'consumer_key', 'type' => 'textfield', 'heading' => __( 'Consumer Key', 'bt_plugin' ) ),
				array( 'param_name' => 'consumer_secret', 'type' => 'textfield', 'heading' => __( 'Consumer Secret', 'bt_plugin' ) ),
				array( 'param_name' => 'access_token', 'type' => 'textfield', 'heading' => __( 'Access Token', 'bt_plugin' ) ),
				array( 'param_name' => 'access_token_secret', 'type' => 'textfield', 'heading' => __( 'Access Token Secret', 'bt_plugin' ) ),
				array( 'param_name' => 'display_type', 'type' => 'dropdown', 'heading' => __( 'Type', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'Slider', 'bt_plugin' ) => 'slider',
						__( 'Regular', 'bt_plugin' ) => 'regular'
					) ),
				array( 'param_name' => 'show_avatar', 'type' => 'dropdown', 'heading' => __( 'Show avatar', 'bt_plugin' ), 'preview' => true,
				'value' => array(
					__( 'No', 'bt_plugin' ) 		=> 'no',
					__( 'Yes', 'bt_plugin' )	 	=> 'yes'
				) ),
				array( 'param_name' => 'el_class', 'type' => 'textfield', 'heading' => __( 'Extra Class Name(s)', 'bt_plugin' ), 'group' => __( 'Custom', 'bold-builder' ) ),
				array( 'param_name' => 'el_style', 'type' => 'textfield', 'heading' => __( 'Inline Style', 'bt_plugin' ), 'group' => __( 'Custom', 'bold-builder' ) )					
			) )
		);		
		
		bt_rc_map( 'bt_button', array( 'name' => __( 'Button', 'bt_plugin' ), 'description' => __( 'Button with custom link', 'bt_plugin' ), 'icon' => 'bt_bb_icon_bt_bb_button',
			'params' => array(
				array( 'param_name' => 'text', 'type' => 'textfield', 'heading' => __( 'Text', 'bt_plugin' ), 'preview' => true ),
				array( 'param_name' => 'icon', 'type' => 'iconpicker', 'heading' => __( 'Icon', 'bt_plugin' ), 'value' => $icon_arr, 'preview' => true ),
				array( 'param_name' => 'url', 'type' => 'textfield', 'heading' => __( 'URL', 'bt_plugin' ) ),
				array( 'param_name' => 'target', 'type' => 'dropdown', 'heading' => __( 'Target window', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'No', 'bt_plugin' ) => 'no_target',
						__( 'Self', 'bt_plugin' ) => '_self',
						__( 'Blank', 'bt_plugin' ) => '_blank',
						__( 'Parent', 'bt_plugin' ) => '_parent',
						__( 'Top', 'bt_plugin' ) => '_top'
				) ),
				array( 'param_name' => 'style', 'type' => 'dropdown', 'heading' => __( 'Style', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'Outline', 'bt_plugin' ) => 'Outline',
						__( 'Filled', 'bt_plugin' ) => 'Filled',
						__( 'Borderless', 'bt_plugin' ) => 'Borderless'
				) ),
				array( 'param_name' => 'icon_position', 'type' => 'dropdown', 'heading' => __( 'Icon Position', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'Right', 'bt_plugin' ) => 'Right',
						__( 'Inline', 'bt_plugin' ) => 'Inline',
						__( 'Left', 'bt_plugin' ) => 'Left'
				) ),
				array( 'param_name' => 'color', 'type' => 'dropdown', 'heading' => __( 'Color', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'Normal', 'bt_plugin' ) => 'Normal',
						__( 'Accent', 'bt_plugin' ) => 'Accent',
						__( 'Alternate', 'bt_plugin' ) => 'Alternate'
				) ),
				array( 'param_name' => 'size', 'type' => 'dropdown', 'heading' => __( 'Size', 'bt_plugin' ), 'preview' => true,
					'value' => array(
					__( 'Small', 'bt_plugin' ) => 'Small',
					__( 'Extra Small', 'bt_plugin' ) => 'ExtraSmall',
					__( 'Medium', 'bt_plugin' ) => 'Medium',
					__( 'Big', 'bt_plugin' ) => 'Big'
										
				) ),
				array( 'param_name' => 'width', 'type' => 'dropdown', 'heading' => __( 'Width', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'Normal', 'bt_plugin' ) => 'Normal',
						__( 'Full', 'bt_plugin' ) => 'Full'				
				) ),
				array( 'param_name' => 'el_class', 'type' => 'textfield', 'heading' => __( 'Extra Class Name(s)', 'bt_plugin' ), 'group' => __( 'Custom', 'bold-builder' ) ),
				array( 'param_name' => 'el_style', 'type' => 'textfield', 'heading' => __( 'Inline Style', 'bt_plugin' ), 'group' => __( 'Custom', 'bold-builder' ) )			
			) )
		);
		
		bt_rc_map( 'bt_counter', array( 'name' => __( 'Counter', 'bt_plugin' ), 'description' => __( 'Animated counter', 'bt_plugin' ), 'icon' => 'bt_bb_icon_bt_bb_counter',
			'params' => array(
				array( 'param_name' => 'number', 'type' => 'textfield', 'heading' => __( 'Number', 'bt_plugin' ), 'preview' => true ),
				array( 'param_name' => 'size', 'type' => 'dropdown', 'heading' => __( 'Size', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'Normal', 'bt_plugin' ) => 'btCounterNormalSize',
						__( 'Large', 'bt_plugin' ) => 'btCounterLargeSize'				
				) ),
				array( 'param_name' => 'el_class', 'type' => 'textfield', 'heading' => __( 'Extra Class Name(s)', 'bt_plugin' ), 'group' => __( 'Custom', 'bold-builder' ) ),
				array( 'param_name' => 'el_style', 'type' => 'textfield', 'heading' => __( 'Inline Style', 'bt_plugin' ), 'group' => __( 'Custom', 'bold-builder' ) )	
			) )
		);

		bt_rc_map( 'bt_countdown', array( 'name' => __( 'Countdown', 'bt_plugin' ), 'description' => __( 'Animated countdown', 'bt_plugin' ), 'icon' => 'bt_bb_icon_bt_bb_countdown',
			'params' => array(
				array( 'param_name' => 'datetime', 'type' => 'textfield', 'heading' => __( 'Target Date and Time', 'bt_plugin' ), 'description' => __( 'YY-mm-dd HH:mm:ss, e.g. 2015-02-22 22:45:00' ), 'preview' => true ),
				array( 'param_name' => 'size', 'type' => 'dropdown', 'heading' => __( 'Size', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'Normal', 'bt_plugin' ) => 'btCounterNormalSize',
						__( 'Large', 'bt_plugin' ) => 'btCounterLargeSize'				
				) ),
				array( 'param_name' => 'hide_indication', 'type' => 'dropdown', 'heading' => __( 'Hide Indication', 'bt_plugin' ), 'description' => __( 'Hide indication of days, hours, minutes and seconds', 'bt_plugin' ),
					'value' => array(
						__( 'No', 'bt_plugin' ) => 'no',
						__( 'Yes', 'bt_plugin' ) => 'yes'				
				) ),					
				array( 'param_name' => 'el_class', 'type' => 'textfield', 'heading' => __( 'Extra Class Name(s)', 'bt_plugin' ) ),
				array( 'param_name' => 'el_style', 'type' => 'textfield', 'heading' => __( 'Inline Style', 'bt_plugin' ) )
			) )
		);	

		bt_rc_map( 'bt_percentage_bar', array( 'name' => __( 'Percentage Bar', 'bt_plugin' ), 'description' => __( 'Animated percentage bar', 'bt_plugin' ), 'icon' => 'bt_bb_icon_bt_bb_percentage_bar',
			'params' => array(
				array( 'param_name' => 'text', 'type' => 'textfield', 'heading' => __( 'Text', 'bt_plugin' ), 'preview' => true ),
				array( 'param_name' => 'percentage', 'type' => 'textfield', 'heading' => __( 'Percentage', 'bt_plugin' ), 'preview' => true ),
				array( 'param_name' => 'bar_color', 'type' => 'colorpicker', 'heading' => __( 'Color', 'bt_plugin' ) ),		
				array( 'param_name' => 'bar_style', 'type' => 'dropdown', 'heading' => __( 'Style', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'Filled', 'bt_plugin' ) => 'Filled',
						__( 'Line', 'bt_plugin' ) => 'Line'
				) ),
				array( 'param_name' => 'el_class', 'type' => 'textfield', 'heading' => __( 'Extra Class Name(s)', 'bt_plugin' ), 'group' => __( 'Custom', 'bold-builder' ) ),
				array( 'param_name' => 'el_style', 'type' => 'textfield', 'heading' => __( 'Inline Style', 'bt_plugin' ), 'group' => __( 'Custom', 'bold-builder' ) )
			) )
		);
		
		bt_rc_map( 'bt_slider', array( 'name' => __( 'Slider', 'bt_plugin' ), 'description' => __( 'Slider container', 'bt_plugin' ), 'container' => 'vertical', 'icon' => 'bt_bb_icon_bt_bb_slider', 'accept' => array( 'bt_slider_item' => true, 'bt_slider_post_item' => true ), 'toggle' => true, 'show_settings_on_create' => false,
			'params' => array(
				array( 'param_name' => 'height', 'type' => 'dropdown', 'heading' => __( 'Slider height', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'Auto/Adaptive', 'bt_plugin' ) => 'auto',
						__( 'Fixed/Keep Height', 'bt_plugin' ) => 'fixed',
						__( 'Full Screen', 'bt_plugin' ) => 'large'
				) ),
				array( 'param_name' => 'auto_play', 'type' => 'textfield', 'heading' => __( 'Auto Play Speed (e.g. 3000)', 'bt_plugin' ) ),
				array( 'param_name' => 'hide_arrows', 'type' => 'dropdown', 'heading' => __( 'Hide Arrows', 'bt_plugin' ),
					'value' => array(
						__( 'No', 'bt_plugin' ) => '',
						__( 'Yes', 'bt_plugin' ) => 'btSliderHideArrows'
				) ),				
				array( 'param_name' => 'hide_paging', 'type' => 'dropdown', 'heading' => __( 'Hide Paging', 'bt_plugin' ),
					'value' => array(
						__( 'No', 'bt_plugin' ) => '',
						__( 'Yes', 'bt_plugin' ) => 'btSliderHidePaging'
				) ),
				array( 'param_name' => 'simple_arrows', 'type' => 'dropdown', 'heading' => __( 'Simple Arrows', 'bt_plugin' ),
					'value' => array(
						__( 'No', 'bt_plugin' ) => 'no',
						__( 'Yes', 'bt_plugin' ) => 'yes'
				) ),				
				array( 'param_name' => 'el_class', 'type' => 'textfield', 'heading' => __( 'Extra Class Name(s)', 'bt_plugin' ), 'group' => __( 'Custom', 'bold-builder' ) ),
				array( 'param_name' => 'el_style', 'type' => 'textfield', 'heading' => __( 'Inline Style', 'bt_plugin' ), 'group' => __( 'Custom', 'bold-builder' ) )
			) )
		);
		
		bt_rc_map( 'bt_slider_item', array( 'name' => __( 'Slider Item', 'bt_plugin' ), 'description' => __( 'Individual slide element', 'bt_plugin' ), 'container' => 'vertical', 'icon' => 'bt_bb_icon_bt_bb_slider', 'accept' => array( 'bt_header' => true, 'bt_button' => true, 'bt_counter' => true, 'bt_icon' => true, 'bt_image' => true, 'bt_text' => true, 'bt_hr' => true, 'bt_row_inner' => true ),
			'params' => array( 
				array( 'param_name' => 'image', 'type' => 'attach_image', 'heading' => __( 'Image', 'bt_plugin' ), 'preview' => true ),
				array( 'param_name' => 'el_class', 'type' => 'textfield', 'heading' => __( 'Extra Class Name(s)', 'bt_plugin' ), 'group' => __( 'Custom', 'bold-builder' ) ),
				array( 'param_name' => 'el_style', 'type' => 'textfield', 'heading' => __( 'Inline Style', 'bt_plugin' ), 'group' => __( 'Custom', 'bold-builder' ) )
			) )
		);

		bt_rc_map( 'bt_slider_post_item', array( 'name' => __( 'Slider Single Post Template', 'bt_plugin' ), 'description' => __( 'Individual post slide element', 'bt_plugin' ), 'container' => 'vertical', 'icon' => 'bt_bb_icon_bt_bb_slider',
			'params' => array( 
				array( 'param_name' => 'template', 'type' => 'dropdown', 'heading' => __( 'Template', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'Default', 'bt_plugin' ) => 'default',
						__( 'Small', 'bt_plugin' ) => 'small',
						__( 'Large', 'bt_plugin' ) => 'large'
				) ),
				array( 'param_name' => 'h_tag', 'type' => 'dropdown', 'heading' => __( 'H tag', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'H1', 'bt_plugin' ) => 'h1',
						__( 'H2', 'bt_plugin' ) => 'h2',
						__( 'H3', 'bt_plugin' ) => 'h3',
						__( 'H4', 'bt_plugin' ) => 'h4',
						__( 'H5', 'bt_plugin' ) => 'h5',
						__( 'H6', 'bt_plugin' ) => 'h6'
				) ),
				array( 'param_name' => 'text_position', 'type' => 'dropdown', 'heading' => __( 'Content position', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'Left', 'bt_plugin' ) 	=> 'text-left',
						__( 'Right', 'bt_plugin' ) 	=> 'text-right'
				) ),
				array( 'param_name' => 'content_background', 'type' => 'dropdown', 'heading' => __( 'Content background', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'Solid', 'bt_plugin' ) 				=> 'content-background-solid',
						__( 'Semi Transparent', 'bt_plugin' ) 	=> 'content-background-semi-transparent',
						__( 'Transparent', 'bt_plugin' ) 		=> 'content-background-transparent'
				) ),
				array( 'param_name' => 'image_position', 'type' => 'dropdown', 'heading' => __( 'Image position', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'Side', 'bt_plugin' ) 		=> 'side',
						__( 'Background', 'bt_plugin' ) => 'background',
						__( 'No image', 'bt_plugin' ) 	=> 'no-image'
				) ),
				array( 'param_name' => 'image_size', 'type' => 'textfield', 'value' => 'medium_large', 'heading' => __( 'Image size', 'bt_plugin' ), 'preview' => true ),
				array( 'param_name' => 'show_highlight', 'type' => 'checkbox', 'value' => array( 'Yes' => 'true' ), 'heading' => __( 'Show highlight', 'bt_plugin' ), 'preview' => true ),
				array( 'param_name' => 'show_excerpt', 'type' => 'checkbox', 'value' => array( 'Yes' => 'true' ), 'heading' => __( 'Show excrept', 'bt_plugin' ), 'group' => __( 'Display', 'bold-news' ) ),
				array( 'param_name' => 'show_author', 'type' => 'checkbox', 'value' => array( 'Yes' => 'true' ), 'heading' => __( 'Show author', 'bt_plugin' ), 'group' => __( 'Display', 'bold-news' ) ),
				array( 'param_name' => 'show_date', 'type' => 'checkbox', 'value' => array( 'Yes' => 'true' ), 'heading' => __( 'Show date', 'bt_plugin' ), 'group' => __( 'Display', 'bold-news' ) ),
				array( 'param_name' => 'show_categories', 'type' => 'checkbox', 'value' => array( 'Yes' => 'true' ), 'heading' => __( 'Show categories', 'bt_plugin' ), 'group' => __( 'Display', 'bold-news' ) ),
				array( 'param_name' => 'show_post_format', 'type' => 'checkbox', 'value' => array( 'Yes' => 'true' ), 'heading' => __( 'Show post format', 'bt_plugin' ), 'group' => __( 'Display', 'bold-news' ) ),
				array( 'param_name' => 'show_comments', 'type' => 'checkbox', 'value' => array( 'Yes' => 'true' ), 'heading' => __( 'Show comments', 'bt_plugin' ), 'group' => __( 'Display', 'bold-news' ) ),
				array( 'param_name' => 'show_reading_time', 'type' => 'checkbox', 'value' => array( 'Yes' => 'true' ), 'heading' => __( 'Show reading time', 'bt_plugin' ), 'group' => __( 'Display', 'bold-news' ) ),
				array( 'param_name' => 'show_views_count', 'type' => 'checkbox', 'value' => array( 'Yes' => 'true' ), 'heading' => __( 'Show views count', 'bt_plugin' ), 'group' => __( 'Display', 'bold-news' ) ),
				array( 'param_name' => 'show_review', 'type' => 'checkbox', 'value' => array( 'Yes' => 'true' ), 'heading' => __( 'Show review', 'bt_plugin' ), 'group' => __( 'Display', 'bold-news' ) ),
				array( 'param_name' => 'el_class', 'type' => 'textfield', 'heading' => __( 'Extra Class Name(s)', 'bt_plugin' ), 'group' => __( 'Custom', 'bold-builder' ) ),
				array( 'param_name' => 'el_style', 'type' => 'textfield', 'heading' => __( 'Inline Style', 'bt_plugin' ), 'group' => __( 'Custom', 'bold-builder' ) )			
			) )
		);
		
		bt_rc_map( 'bt_hr', array( 'name' => __( 'Separator', 'bt_plugin' ), 'description' => __( 'Horizontal separator', 'bt_plugin' ), 'icon' => 'bt_bb_icon_bt_bb_hr',
			'params' => array( 
				array( 'param_name' => 'top_spaced', 'type' => 'dropdown', 'heading' => __( 'Top spaced', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'No', 'bt_plugin' ) => 'not-spaced',
						__( 'Extra-Small-Spaced', 'bt_plugin' ) => 'topExtraSmallSpaced',
						__( 'Small-Spaced', 'bt_plugin' ) => 'topSmallSpaced',		
						__( 'Medium-Spaced', 'bt_plugin' ) => 'topMediumSpaced',
						__( 'Semi-Spaced', 'bt_plugin' ) => 'topSemiSpaced',
						__( 'Spaced', 'bt_plugin' ) => 'topSpaced',
						__( 'Large Spaced', 'bt_plugin' ) => 'topLargeSpaced',
						__( 'Extra-Spaced', 'bt_plugin' ) => 'topExtraSpaced'
				) ),
				array( 'param_name' => 'bottom_spaced', 'type' => 'dropdown', 'heading' => __( 'Bottom spaced', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'No', 'bt_plugin' ) => 'not-spaced',
						__( 'Extra-Small-Spaced', 'bt_plugin' ) => 'bottomExtraSmallSpaced',
						__( 'Small-Spaced', 'bt_plugin' ) => 'bottomSmallSpaced',
						__( 'Medium-Spaced', 'bt_plugin' ) => 'bottomMediumSpaced',
						__( 'Semi-Spaced', 'bt_plugin' ) => 'bottomSemiSpaced',
						__( 'Spaced', 'bt_plugin' ) => 'bottomSpaced',
						__( 'Large Spaced', 'bt_plugin' ) => 'bottomLargeSpaced',
						__( 'Extra-Spaced', 'bt_plugin' ) => 'bottomExtraSpaced'
				) ),				
				array( 'param_name' => 'transparent_border', 'type' => 'dropdown', 'heading' => __( 'Border', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'No', 'bt_plugin' ) => 'noBorder',
						__( 'Yes', 'bt_plugin' ) => 'border'
				) ),				
				array( 'param_name' => 'el_class', 'type' => 'textfield', 'heading' => __( 'Extra Class Name(s)', 'bt_plugin' ), 'group' => __( 'Custom', 'bold-builder' ) ),
				array( 'param_name' => 'el_style', 'type' => 'textfield', 'heading' => __( 'Inline Style', 'bt_plugin' ), 'group' => __( 'Custom', 'bold-builder' ) )
			) )
		);

		bt_rc_map( 'bt_icon', array( 'name' => __( 'Icon', 'bt_plugin' ), 'description' => __( 'Single icon with link', 'bt_plugin' ), 'icon' => 'bt_bb_icon_bt_bb_icon',
			'params' => array(
				array( 'param_name' => 'icon', 'type' => 'iconpicker', 'heading' => __( 'Icon', 'bt_plugin' ), 'value' => $icon_arr, 'preview' => true ),			
				array( 'param_name' => 'icon_title', 'type' => 'textfield', 'heading' => __( 'Title', 'bt_plugin' ) ),
				array( 'param_name' => 'icon_type', 'type' => 'dropdown', 'heading' => __( 'Icon Type', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'Default', 'bt_plugin' ) 	=> 'btIcoDefaultType',
						__( 'Filled', 'bt_plugin' )	 	=> 'btIcoFilledType',
						__( 'Outline', 'bt_plugin' )	=> 'btIcoOutlineType'
					) ),
				array( 'param_name' => 'icon_shape', 'type' => 'dropdown', 'heading' => __( 'Icon Shape', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'Cirle', 'bt_plugin' ) 	=> 'btIconCircleShape',
						__( 'Square', 'bt_plugin' )	 	=> 'btIconSquareShape',
						__( 'Hexagon', 'bt_plugin' )	=> 'btIconHexagonShape'
					) ),
				array( 'param_name' => 'icon_color', 'type' => 'dropdown', 'heading' => __( 'Icon Color', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'Default', 'bt_plugin' ) 	=> 'btIcoDefaultColor',
						__( 'Accent', 'bt_plugin' )	 	=> 'btIcoAccentColor',
						__( 'Alternate', 'bt_plugin' ) => 'btIcoAlternateColor'
					) ),
				array( 'param_name' => 'icon_size', 'type' => 'dropdown', 'heading' => __( 'Icon Size', 'bt_plugin' ), 'preview' => true,
					'value' => array(
							__( 'Small', 'bt_plugin' ) 			=> 'btIcoSmallSize',		
							__( 'Extra Small', 'bt_plugin' )	=> 'btIcoExtraSmallSize',
							__( 'Medium', 'bt_plugin' )	 		=> 'btIcoMediumSize',
							__( 'Big', 'bt_plugin' )	 		=> 'btIcoBigSize',
							__( 'Large', 'bt_plugin' )			=> 'btIcoLargeSize'
					) ),
				array( 'param_name' => 'url', 'type' => 'textfield', 'heading' => __( 'URL', 'bt_plugin' ) ),
				array( 'param_name' => 'target', 'type' => 'dropdown', 'heading' => __( 'Target window', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'No', 'bt_plugin' ) => 'no_target',
						__( 'Self', 'bt_plugin' ) => '_self',
						__( 'Blank', 'bt_plugin' ) => '_blank',
						__( 'Parent', 'bt_plugin' ) => '_parent',
						__( 'Top', 'bt_plugin' ) => '_top'
				) ),
				array( 'param_name' => 'el_class', 'type' => 'textfield', 'heading' => __( 'Extra Class Name(s)', 'bt_plugin' ), 'group' => __( 'Custom', 'bold-builder' ) ),
				array( 'param_name' => 'el_style', 'type' => 'textfield', 'heading' => __( 'Inline Style', 'bt_plugin' ), 'group' => __( 'Custom', 'bold-builder' ) )				
			) )
		);
		
		bt_rc_map( 'bt_latest_posts', array( 'name' => __( 'Latest Posts', 'bt_plugin' ), 'description' => __( 'Recent posts', 'bt_plugin' ), 'icon' => 'bt_bb_icon_bt_bb_latest_posts',
			'params' => array(
				array( 'param_name' => 'number', 'type' => 'textfield', 'heading' => __( 'Number of Items', 'bt_plugin' ), 'preview' => true ),
				array( 'param_name' => 'category', 'type' => 'textfield', 'heading' => __( 'Category Slug', 'bt_plugin' ), 'preview' => true ),
				array( 'param_name' => 'format', 'type' => 'dropdown', 'heading' => __( 'Format', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'Horizontal', 'bt_plugin' ) => 'horizontal',
						__( 'Vertical', 'bt_plugin' ) => 'vertical'
				) ),
				array( 'param_name' => 'post_type', 'type' => 'dropdown', 'heading' => __( 'Post Type', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'Blog', 'bt_plugin' ) => 'blog',
						__( 'Portfolio', 'bt_plugin' ) => 'portfolio'
				) ),
				array( 'param_name' => 'headline_size', 'type' => 'dropdown', 'heading' => __( 'Headline Size', 'bt_plugin' ), 'preview' => true, 
					'value' => array(
						__( 'Small', 'bt_plugin' ) => 'small',
						__( 'ExtraSmall', 'bt_plugin' ) => 'extrasmall',
						__( 'Medium', 'bt_plugin' ) => 'medium',
						__( 'Large', 'bt_plugin' ) => 'large',
						__( 'Extra large', 'bt_plugin' ) => 'extralarge',
						__( 'Huge', 'bt_plugin' ) => 'huge'
				) ),
				array( 'param_name' => 'show_excerpt', 'type' => 'dropdown', 'heading' => __( 'Show Excerpt', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'Yes', 'bt_plugin' ) => 'yes',
						__( 'No', 'bt_plugin' ) => 'no'
				) ),
				array( 'param_name' => 'show_date', 'type' => 'dropdown', 'heading' => __( 'Show Date', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'Yes', 'bt_plugin' ) => 'yes',
						__( 'No', 'bt_plugin' ) => 'no'
				) ),
				array( 'param_name' => 'show_categories', 'type' => 'dropdown', 'heading' => __( 'Show Categories', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'Yes', 'bt_plugin' ) => 'yes',
						__( 'No', 'bt_plugin' ) => 'no'
				) ),
				array( 'param_name' => 'show_author', 'type' => 'dropdown', 'heading' => __( 'Show Author', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'Yes', 'bt_plugin' ) => 'yes',
						__( 'No', 'bt_plugin' ) => 'no'
				) ),
				array( 'param_name' => 'show_pagination', 'type' => 'dropdown', 'heading' => __( 'Show Pagination', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'Yes', 'bt_plugin' ) => 'yes',
						__( 'No', 'bt_plugin' ) => 'no'
				) ),
				array( 'param_name' => 'el_class', 'type' => 'textfield', 'heading' => __( 'Extra Class Name(s)', 'bt_plugin' ), 'group' => __( 'Custom', 'bold-builder' ) ),
				array( 'param_name' => 'el_style', 'type' => 'textfield', 'heading' => __( 'Inline Style', 'bt_plugin' ), 'group' => __( 'Custom', 'bold-builder' ) )
			) )
		);	

		bt_rc_map( 'bt_grid', array( 'name' => __( 'Grid', 'bt_plugin' ), 'description' => __( 'Grid with recent posts', 'bt_plugin' ), 'icon' => 'bt_bb_icon_bt_bb_masonry_post_grid',
			'params' => array(
				array( 'param_name' => 'number', 'type' => 'textfield', 'heading' => __( 'Number of items', 'bt_plugin' ), 'preview' => true ),
				array( 'param_name' => 'columns', 'type' => 'dropdown', 'heading' => __( 'Columns', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( '3', 'bt_plugin' ) => '3',
						__( '4', 'bt_plugin' ) => '4',
						__( '5', 'bt_plugin' ) => '5',
						__( '6', 'bt_plugin' ) => '6'
				) ),
				array( 'param_name' => 'category', 'type' => 'textfield', 'heading' => __( 'Category Slug', 'bt_plugin' ), 'preview' => true ),
				array( 'param_name' => 'category_filter', 'type' => 'dropdown', 'heading' => __( 'Category Filter', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'No', 'bt_plugin' ) => 'no',
						__( 'Yes', 'bt_plugin' ) => 'yes'
				) ),
				array( 'param_name' => 'grid_type', 'type' => 'dropdown', 'heading' => __( 'Grid Type', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'Classic', 'bt_plugin' ) => 'classic',
						__( 'Tiled', 'bt_plugin' ) => 'tiled'
				) ),
				array( 'param_name' => 'grid_gap', 'type' => 'dropdown', 'heading' => __( 'Grid Gap', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( '0', 'bt_plugin' ) => '0',
						__( '1', 'bt_plugin' ) => '1',
						__( '2', 'bt_plugin' ) => '2',
						__( '3', 'bt_plugin' ) => '3',
						__( '4', 'bt_plugin' ) => '4',
						__( '5', 'bt_plugin' ) => '5',
						__( '6', 'bt_plugin' ) => '6',
						__( '7', 'bt_plugin' ) => '7',
						__( '8', 'bt_plugin' ) => '8',
						__( '9', 'bt_plugin' ) => '9',
						__( '10', 'bt_plugin' ) => '10',
						__( '15', 'bt_plugin' ) => '15',
						__( '20', 'bt_plugin' ) => '20',
						__( '30', 'bt_plugin' ) => '30',
						__( '40', 'bt_plugin' ) => '40',
						__( '50', 'bt_plugin' ) => '50'
				) ),
				array( 'param_name' => 'format', 'type' => 'textfield', 'heading' => __( 'Tiled Format', 'bt_plugin' ) ),				
				array( 'param_name' => 'tiles_title', 'type' => 'dropdown', 'heading' => __( 'Show Title in Tiles', 'bt_plugin' ),
					'value' => array(
						__( 'No', 'bt_plugin' ) => 'no',
						__( 'Yes', 'bt_plugin' ) => 'yes'
				) ),				
				array( 'param_name' => 'post_type', 'type' => 'dropdown', 'heading' => __( 'Post Type', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'Blog', 'bt_plugin' ) => 'blog',
						__( 'Portfolio', 'bt_plugin' ) => 'portfolio'
				) ),
				array( 'param_name' => 'scroll_loading', 'type' => 'dropdown', 'heading' => __( 'Scroll Loading', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'No', 'bt_plugin' ) => 'no',
						__( 'Yes', 'bt_plugin' ) => 'yes'
				) ),
				array( 'param_name' => 'sticky_in_grid', 'type' => 'dropdown', 'heading' => __( 'Show Sticky Posts', 'bt_plugin' ),
					'value' => array(
						__( 'No', 'bt_plugin' ) => 'no',
						__( 'Yes', 'bt_plugin' ) => 'yes'
				) ),				
				array( 'param_name' => 'el_class', 'type' => 'textfield', 'heading' => __( 'Extra Class Name(s)', 'bt_plugin' ), 'group' => __( 'Custom', 'bold-builder' ) ),
				array( 'param_name' => 'el_style', 'type' => 'textfield', 'heading' => __( 'Inline Style', 'bt_plugin' ), 'group' => __( 'Custom', 'bold-builder' ) )
			) )
		);
		
		bt_rc_map( 'bt_grid_gallery', array( 'name' => __( 'Grid Gallery', 'bt_plugin' ), 'description' => __( 'Responsive grid gallery with lightbox.', 'bt_plugin' ), 'icon' => 'bt_bb_icon_bt_bb_grid_gallery',
			'params' => array(
				array( 'param_name' => 'ids', 'type' => 'attach_images', 'heading' => __( 'Images', 'bt_plugin' ) ),
				array( 'param_name' => 'format', 'type' => 'textfield', 'heading' => __( 'Format (e.g. 21,11,12)', 'bt_plugin' ) ),
				array( 'param_name' => 'lightbox', 'type' => 'hidden', 'value' => 'yes' ),
				array( 'param_name' => 'grid_gap', 'type' => 'dropdown', 'heading' => __( 'Grid Gap', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( '0', 'bt_plugin' ) => '0',
						__( '1', 'bt_plugin' ) => '1',
						__( '2', 'bt_plugin' ) => '2',
						__( '3', 'bt_plugin' ) => '3',
						__( '4', 'bt_plugin' ) => '4',
						__( '5', 'bt_plugin' ) => '5',
						__( '6', 'bt_plugin' ) => '6',
						__( '7', 'bt_plugin' ) => '7',
						__( '8', 'bt_plugin' ) => '8',
						__( '9', 'bt_plugin' ) => '9',
						__( '10', 'bt_plugin' ) => '10',
						__( '15', 'bt_plugin' ) => '15',
						__( '20', 'bt_plugin' ) => '20',
						__( '30', 'bt_plugin' ) => '30',
						__( '40', 'bt_plugin' ) => '40',
						__( '50', 'bt_plugin' ) => '50'
				) ),
				array( 'param_name' => 'columns', 'type' => 'dropdown', 'heading' => __( 'Columns', 'bt_plugin' ),
					'value' => array(
						__( '3', 'bt_plugin' ) => '3',
						__( '4', 'bt_plugin' ) => '4',
						__( '5', 'bt_plugin' ) => '5',
						__( '6', 'bt_plugin' ) => '6'
				) ),
				array( 'param_name' => 'links', 'type' => 'textarea', 'heading' => __( 'Links (in one line, separated by commas)', 'bt_plugin' ) ),
				array( 'param_name' => 'el_class', 'type' => 'textfield', 'heading' => __( 'Extra Class Name(s)', 'bt_plugin' ), 'group' => __( 'Custom', 'bold-builder' ) ),
				array( 'param_name' => 'el_style', 'type' => 'textfield', 'heading' => __( 'Inline Style', 'bt_plugin' ), 'group' => __( 'Custom', 'bold-builder' ) )
			) )
		);		
		
		bt_rc_map( 'bt_price_list', array( 'name' => __( 'Price List', 'bt_plugin' ), 'description' => __( 'Price List element', 'bt_plugin' ), 'icon' => 'bt_bb_icon_bt_bb_price_list',
			'params' => array( 
				array( 'param_name' => 'title', 'type' => 'textfield', 'heading' => __( 'Title', 'bt_plugin' ), 'preview' => true ),
				array( 'param_name' => 'subtitle', 'type' => 'textfield', 'heading' => __( 'Subtitle', 'bt_plugin' ), 'preview' => true ),
				array( 'param_name' => 'sticker', 'type' => 'textfield', 'heading' => __( 'Sticker Text', 'bt_plugin' ) ),
				array( 'param_name' => 'currency', 'type' => 'textfield', 'heading' => __( 'Currency', 'bt_plugin' ) ),
				array( 'param_name' => 'price', 'type' => 'textfield', 'heading' => __( 'Price', 'bt_plugin' ), 'preview' => true ),
				array( 'param_name' => 'items', 'type' => 'textarea', 'heading' => __( 'Items', 'bt_plugin' ) ),
				array( 'param_name' => 'el_class', 'type' => 'textfield', 'heading' => __( 'Extra Class Name(s)', 'bt_plugin' ), 'group' => __( 'Custom', 'bold-builder' ) ),
				array( 'param_name' => 'el_style', 'type' => 'textfield', 'heading' => __( 'Inline Style', 'bt_plugin' ), 'group' => __( 'Custom', 'bold-builder' ) )
			) )
		);
		
		bt_rc_map( 'bt_categories_widget', array( 'name' => __( 'Custom Categories Widget', 'bt_plugin' ), 'description' => __( 'Custom categories widget element', 'bt_plugin' ),'icon' => 'bt_bb_icon_bt_bb_categories_widget',
			 'params' => array( 
				array( 'param_name' => 'title', 'type' => 'textfield', 'heading' => __( 'Title', 'bt_plugin' ), 'preview' => true ),
				array( 'param_name' => 'show_title', 'type' => 'checkbox', 'value' => array( 'Yes' => 'true' ), 'heading' => __( 'Show title', 'bt_plugin' ), 'preview' => true ),
				array( 'param_name' => 'category_slug', 'type' => 'textfield', 'heading' => __( 'Category slug  (optional)', 'bt_plugin' ), 'preview' => true ),
				array( 'param_name' => 'dcw_exclude_slug', 'type' => 'textfield', 'heading' => __( 'Category slugs to exclude (optional). Ex: slug1,slug2,slug3', 'bt_plugin' ), 'preview' => true ),
				array( 'param_name' => 'dcw_depth', 'type' => 'dropdown', 'heading' => __( 'Levels in the hierarchy to show (optional)', 'bt_plugin' ), 
					'value' => array(
						__( 'All Categories and child Categories', 'bt_plugin' ) => '0',
						__( 'Show only top level Categories', 'bt_plugin' ) => '1',
						__( 'All Categories displayed in flat (no indent) form (overrides hierarchical)', 'bt_plugin' ) => '-1'
				) ),				
				array( 'param_name' => 'show_format', 'type' => 'dropdown', 'heading' => __( 'Display as ...', 'bt_plugin' ), 
				'value' => array(
					__( 'List', 'bt_plugin' )		=> '0',
					__( 'Drop Down', 'bt_plugin' )	=> '2'
				) ),
				array( 'param_name' => 'showcount_value', 'type' => 'dropdown', 'heading' => __( 'Show post counts', 'bt_plugin' ), 
				'value' => array(
					__( 'Yes', 'bt_plugin' )	=> '1',
					__( 'No', 'bt_plugin' )		=> '0'
				) ),
				array( 'param_name' => 'display_empty_categories', 'type' => 'dropdown', 'heading' => __( 'Display Empty categories', 'bt_plugin' ), 
				'value' => array(
					__( 'Yes', 'bt_plugin' )	=> '0',
					__( 'No', 'bt_plugin' )		=> '1'
				) ),
				array( 'param_name' => 'el_class', 'type' => 'textfield', 'heading' => __( 'Extra Class Name(s)', 'bt_plugin' ), 'group' => __( 'Custom', 'bold-builder' ) ),
				array( 'param_name' => 'el_style', 'type' => 'textfield', 'heading' => __( 'Inline Style', 'bt_plugin' ), 'group' => __( 'Custom', 'bold-builder' ) )
			 ) )
		);

		bt_rc_map( 'bt_banner', array( 'name' => __( 'Banner', 'bt_plugin' ), 'description' => __( 'Banner with custom code', 'bt_plugin' ), 'icon' => 'bt_bb_icon_bt_bb_banner',
			'params' => array( 
				array( 'param_name' => 'code', 'type' => 'textarea_object', 'heading' => __( 'Banner code', 'bt_plugin' ) ),
				array( 'param_name' => 'el_class', 'type' => 'textfield', 'heading' => __( 'Extra Class Name(s)', 'bt_plugin' ), 'group' => __( 'Custom', 'bold-builder' ) ),
				array( 'param_name' => 'el_style', 'type' => 'textfield', 'heading' => __( 'Inline Style', 'bt_plugin' ), 'group' => __( 'Custom', 'bold-builder' ) ),
				array( 'param_name' => 'show_banner_border', 'type' => 'dropdown', 'heading' => __( 'Show border', 'bt_plugin' ), 
				'value' => array(
					__( 'Yes', 'bt_plugin' )	=> 'on',
					__( 'No', 'bt_plugin' )		=> ''
				) ),
			) )
		);

		bt_rc_map( 'bt_category_title', array( 'name' => __( 'Category Title', 'bt_plugin' ), 'description' => __( 'Category title with subcategories', 'bt_plugin' ), 'icon' => 'bt_bb_icon_bt_bb_category_title',
			'params' => array(
				array( 'param_name' => 'title', 'type' => 'textfield', 'heading' => __( 'Title', 'bt_plugin' ), 'preview' => true ),
				array( 'param_name' => 'h_tag', 'type' => 'dropdown', 'heading' => __( 'H tag', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'H1', 'bt_plugin' ) => 'h1',
						__( 'H2', 'bt_plugin' ) => 'h2',
						__( 'H3', 'bt_plugin' ) => 'h3',
						__( 'H4', 'bt_plugin' ) => 'h4',
						__( 'H5', 'bt_plugin' ) => 'h5',
						__( 'H6', 'bt_plugin' ) => 'h6'
				) ),
				array( 'param_name' => 'category_filter', 'type' => 'dropdown', 'heading' => __( 'Show Categories', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'No', 'bt_plugin' ) => 'no',
						__( 'Yes', 'bt_plugin' ) => 'yes'
				) ),
				array( 'param_name' => 'category', 'type' => 'textfield', 'heading' => __( 'Post Category Slug', 'bt_plugin' ), 'preview' => true ),
				array( 'param_name' => 'icon', 'type' => 'iconpicker', 'heading' => __( 'Icon', 'bt_plugin' ), 'value' => $icon_arr, 'preview' => true ),	
				array( 'param_name' => 'icon_type', 'type' => 'dropdown', 'heading' => __( 'Icon Type', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'Default', 'bt_plugin' ) 	=> 'btIcoDefaultType',
						__( 'Filled', 'bt_plugin' )	 	=> 'btIcoFilledType',
						__( 'Outline', 'bt_plugin' )	=> 'btIcoOutlineType'
					) ),
				array( 'param_name' => 'icon_shape', 'type' => 'dropdown', 'heading' => __( 'Icon Shape', 'bt_plugin' ), 'preview' => true,
					'value' => array(
						__( 'Cirle', 'bt_plugin' ) 		=> 'btIconCircleShape',
						__( 'Square', 'bt_plugin' )	 	=> 'btIconSquareShape',
						__( 'Hexagon', 'bt_plugin' )	=> 'btIconHexagonShape'
					) ),
				array( 'param_name' => 'icon_size', 'type' => 'dropdown', 'heading' => __( 'Icon Size', 'bt_plugin' ), 'preview' => true,
					'value' => array(
							__( 'Small', 'bt_plugin' ) 			=> 'btIcoSmallSize',		
							__( 'Extra Small', 'bt_plugin' )	=> 'btIcoExtraSmallSize',
							__( 'Medium', 'bt_plugin' )	 		=> 'btIcoMediumSize',
							__( 'Big', 'bt_plugin' )	 		=> 'btIcoBigSize',
							__( 'Large', 'bt_plugin' )			=> 'btIcoLargeSize'
					) ),
				array( 'param_name' => 'el_class', 'type' => 'textfield', 'heading' => __( 'Extra Class Name(s)', 'bt_plugin' ), 'group' => __( 'Custom', 'bold-builder' ) ),
				array( 'param_name' => 'el_style', 'type' => 'textfield', 'heading' => __( 'Inline Style', 'bt_plugin' ), 'group' => __( 'Custom', 'bold-builder' ) )				
			) )
		);

	}
}
add_action( 'plugins_loaded', 'bt_map_sc' );


// WIDGETS

if ( ! class_exists( 'BT_Gallery' ) ) {

	// GALLERY

	class BT_Gallery extends WP_Widget {
	
		function __construct() {
			parent::__construct(
				'bt_gallery', // Base ID
				__( 'BT Gallery', 'bt_plugin' ), // Name
				array( 'description' => __( 'Gallery widget.', 'bt_plugin' ) ) // Args
			);
		}

		public function widget( $args, $instance ) {
		
			echo $args['before_widget'];
			if ( ! empty( $instance['title'] ) ) {
				echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
			}
			
			if ( $instance['ids'] != '' ) {
				echo do_shortcode( '[gallery ids="' . $instance['ids'] . '"]' );
			}
			
			echo $args['after_widget'];
		}
		
		public function form( $instance ) {
			$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Gallery', 'bt_plugin' );
			$ids = ! empty( $instance['ids'] ) ? $instance['ids'] : '';
			?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'bt_plugin' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'ids' ) ); ?>"><?php _e( 'List of image IDs (comma-separated):', 'bt_plugin' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'ids' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'ids' ) ); ?>" type="text" value="<?php echo esc_attr( $ids ); ?>">
			</p>			
			<?php 
		}

		public function update( $new_instance, $old_instance ) {
			$instance = array();
			$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
			$instance['ids'] = ( ! empty( $new_instance['ids'] ) ) ? strip_tags( $new_instance['ids'] ) : '';

			return $instance;
		}
	}	
}

if ( ! class_exists( 'BT_Text_Image' ) ) {

	// TEXT IMAGE

	class BT_Text_Image extends WP_Widget {

		function __construct() {
			parent::__construct(
				'bt_text_image', // Base ID
				__( 'BT Text Image', 'bt_plugin' ), // Name
				array( 'description' => __( 'Text with image.', 'bt_plugin' ) ) // Args
			);
		}

		public function widget( $args, $instance ) {

			echo $args['before_widget'];
			if ( ! empty( $instance['title'] ) ) {
				echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
			}
				
			if ( $instance['ids'] != '' ) {
				echo do_shortcode( '[image ids="' . $instance['ids'] . '"]' );
			}
			echo '<div class="widget_sp_image-description">' . wpautop( $instance['text'] ) . '</div>';
			
			echo $args['after_widget'];
		}

		public function form( $instance ) {
			$title = ! empty( $instance['title'] ) ? $instance['title'] : '';
			$ids = ! empty( $instance['ids'] ) ? $instance['ids'] : '';
			$text = ! empty( $instance['text'] ) ? $instance['text'] : '';
			?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'bt_plugin' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'ids' ) ); ?>"><?php _e( 'Image IDs:', 'bt_plugin' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'ids' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'ids' ) ); ?>" type="text" value="<?php echo esc_attr( $ids ); ?>">
			</p>			
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>"><?php _e( 'Text:', 'bt_plugin' ); ?></label> 
				<textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'text' ) ); ?>" > <?php echo esc_attr( $text ); ?></textarea>
			</p>			
			<?php 
		}

		public function update( $new_instance, $old_instance ) {
			$instance = array();
			$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
			$instance['ids'] = ( ! empty( $new_instance['ids'] ) ) ? strip_tags( $new_instance['ids'] ) : '';
			$instance['text'] = ( ! empty( $new_instance['text'] ) ) ? strip_tags( $new_instance['text'] ) : '';

			return $instance;
		}
	}	
}

if ( ! class_exists( 'BT_Banner_Widget' ) ) {

	// BANNER

	class BT_Banner_Widget extends WP_Widget {

		function __construct() {
			parent::__construct(
				'bt_banner_widget', // Base ID
				__( 'BT Banner', 'bt_plugin' ), // Name
				array( 
					'description' => __( 'Banner with custom class.', 'bt_plugin' ), 
					'classname' => 'widget_bt_banner_widget __brdr__' 
				) 
			);
		}

		public function widget( $args, $instance ) {
			$show_banner_border = '';
			if ( isset( $instance['show_banner_border']) ){
				$show_banner_border = $instance['show_banner_border'];
				$args['before_widget'] = str_replace( '__brdr__', '', $args['before_widget'] );				
			}else{				
				$args['before_widget'] = str_replace( '__brdr__', 'no-border', $args['before_widget'] );
			}
			echo $args['before_widget'];

			if ( ! empty( $instance['title'] ) ) {
				echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
			}
			
			echo do_shortcode( '[bt_banner code="' . base64_encode( $instance['code'] ) . '" el_class="' . $instance['el_class'] . ' show_banner_border="' . $show_banner_border . '"]' );
			
			echo $args['after_widget'];
		}

		public function form( $instance ) {
			$title = ! empty( $instance['title'] ) ? $instance['title'] : '';
			$el_class = ! empty( $instance['el_class'] ) ? $instance['el_class'] : '';
			$code = ! empty( $instance['code'] ) ? $instance['code'] : '';
			$show_banner_border = ! empty( $instance['show_banner_border'] ) ? $instance['show_banner_border'] : '';
			?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'bt_plugin' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'el_class' ) ); ?>"><?php _e( 'Custom class:', 'bt_plugin' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'el_class' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'el_class' ) ); ?>" type="text" value="<?php echo esc_attr( $el_class ); ?>">
			</p>			
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'code' ) ); ?>"><?php _e( 'Banner code:', 'bt_plugin' ); ?></label> 
				<textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'code' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'code' ) ); ?>" ><?php echo $code; ?></textarea>
			</p>
			<p>
				<input class="checkbox" type="checkbox" <?php checked( $instance['show_banner_border'], 'on' ); ?> id="<?php echo $this->get_field_id('show_banner_border'); ?>" name="<?php echo $this->get_field_name('show_banner_border'); ?>" /> 
				<label for="<?php echo $this->get_field_id('show_banner_border'); ?>"><?php _e( 'Show border', 'bt_plugin' ); ?></label>
			</p>
			<?php 
		}

		public function update( $new_instance, $old_instance ) {
			$instance = array();
			$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
			$instance['el_class'] = ( ! empty( $new_instance['el_class'] ) ) ? strip_tags( $new_instance['el_class'] ) : '';
			$instance['code'] = ( ! empty( $new_instance['code'] ) ) ? $new_instance['code'] : '';
			$instance['show_banner_border'] = $new_instance['show_banner_border'];

			return $instance;
		}
	}	
}

if ( ! class_exists( 'BT_Icon_Widget' ) ) {

	// ICON

	class BT_Icon_Widget extends WP_Widget {

		function __construct() {
			parent::__construct(
				'bt_icon_widget', // Base ID
				__( 'BT Icon', 'bt_plugin' ), // Name
				array( 'description' => __( 'Icon with text and link.', 'bt_plugin' ) ) // Args
			);
		}

		public function widget( $args, $instance ) {
		
			$icon = ! empty( $instance['icon'] ) ? $instance['icon'] : '';
			$title = ! empty( $instance['title'] ) ? $instance['title'] : '';
			$text = ! empty( $instance['text'] ) ? $instance['text'] : '';
			$url = ! empty( $instance['url'] ) ? $instance['url'] : '';
			$show_button = ! empty( $instance['show_button'] ) ? $instance['show_button'] : '';
			$target = ! empty( $instance['target'] ) ? $instance['target'] : '_self';

			$icon_class = 'btIcoDefaultColor';
			$extra_class = '';
			
			if ( $show_button != '' ) {
				// $icon_class = 'btIcoAccentColor';
				$extra_class .= 'btAccentIconWidget';
			}
			
			if ( $text != '' || $title != '' ) {
				$extra_class .= ' btWidgetWithText';
			}

			$wrap_start_tag = '<span class="btIconWidget ' . $extra_class . '">';
			$wrap_end_tag = '</span>';

			if ( $url != '' ) {
				if ( $url != '' && $url != '#' && substr( $url, 0, 4 ) != 'http' && substr( $url, 0, 5 ) != 'https'  && substr( $url, 0, 6 ) != 'mailto' ) {
					$link = boldthemes_get_permalink_by_slug( $url );
				} else {
					$link = $url;
				}
				$wrap_start_tag = '<a href="' . $link . '" target="' . $target . '" class="btIconWidget ' . $extra_class . '">';
				$wrap_end_tag = '</a>';
			}

			// echo boldthemes_get_icon_html( $icon, $url, $text, 'btIcoExtraSmallSize btIcoDefaultType btIcoDefaultColor', $target );

			echo $wrap_start_tag;
				if ( $icon != '' && $icon != 'no_icon' ) {
					echo '<span class="btIconWidgetIcon">';
						echo boldthemes_get_icon_html( $icon, '', '', 'btIcoDefaultType ' . $icon_class . '', $target );
					echo '</span>';
				}
				if ( $title != '' || $text != '' ) {
					echo '<span class="btIconWidgetContent">';
						if ( $title != '' ) echo '<span class="btIconWidgetTitle">' . $title . '</span>';
						if ( $text != '' ) echo '<span class="btIconWidgetText">' . $text . '</span>';
					echo '</span>';
				}
			echo $wrap_end_tag;
		}

		public function form( $instance ) {
			$icon = ! empty( $instance['icon'] ) ? $instance['icon'] : '';
			$title = ! empty( $instance['title'] ) ? $instance['title'] : '';
			$text = ! empty( $instance['text'] ) ? $instance['text'] : '';
			$url = ! empty( $instance['url'] ) ? $instance['url'] : '';
			$show_button = ! empty( $instance['show_button'] ) ? $instance['show_button'] : '';
			$target = ! empty( $instance['target'] ) ? $instance['target'] : '';
			
			if ( ! function_exists( 'bt_fa_icons' ) ) {
				require_once( 'bt_fa_icons.php' );
			}
			if ( ! function_exists( 'bt_s7_icons' ) ) {
				require_once( 'bt_s7_icons.php' );
			}		
			if ( ! function_exists( 'bt_custom_icons' ) ) {
				require_once( 'bt_custom_icons.php' );
			}
			$icon_arr = array_merge( array( ' ' => 'no_icon' ), bt_fa_icons(), bt_s7_icons(), bt_custom_icons() );
			ksort( $icon_arr );
			?>		
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'icon' ) ); ?>"><?php _e( 'Icon:', 'bt_plugin' ); ?></label> 
				<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'icon' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'icon' ) ); ?>">
					<option value=""></option>;
					<?php
					foreach( $icon_arr as $key => $value ) {
						if ( $value == $icon ) {
							echo '<option value="' . $value . '" selected>' . $key . '</option>';
						} else {
							echo '<option value="' . $value . '">' . $key . '</option>';
						}
					}
					?>
				</select>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'bt_plugin' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>"><?php _e( 'Text:', 'bt_plugin' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'text' ) ); ?>" type="text" value="<?php echo esc_attr( $text ); ?>">
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'url' ) ); ?>"><?php _e( 'URL or slug:', 'bt_plugin' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'url' ) ); ?>" type="text" value="<?php echo esc_attr( $url ); ?>">
			</p>
			<p>
				<input class="checkbox" type="checkbox" <?php checked( $instance['show_button'], 'on' ); ?> id="<?php echo $this->get_field_id('show_button'); ?>" name="<?php echo $this->get_field_name('show_button'); ?>" /> 
				<label for="<?php echo $this->get_field_id('show_button'); ?>"><?php _e( 'Show in accent color', 'bt_plugin' ); ?></label>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'target' ) ); ?>"><?php _e( 'Target:', 'bt_plugin' ); ?></label> 
				<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'target' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'target' ) ); ?>">
					<option value=""></option>;
					<?php
					$target_arr = array("Self" => "_self", "Blank" => "_blank", "Parent" => "_parent", "Top" => "_top");
					foreach( $target_arr as $key => $value ) {
						if ( $value == $target ) {
							echo '<option value="' . $value . '" selected>' . $key . '</option>';
						} else {
							echo '<option value="' . $value . '">' . $key . '</option>';
						}
					}
					?>
				</select>
			</p>
			<?php 
		}

		public function update( $new_instance, $old_instance ) {
			$instance = array();
			$instance['icon'] = ( ! empty( $new_instance['icon'] ) ) ? strip_tags( $new_instance['icon'] ) : '';
			$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
			$instance['text'] = ( ! empty( $new_instance['text'] ) ) ? strip_tags( $new_instance['text'] ) : '';
			$instance['url'] = ( ! empty( $new_instance['url'] ) ) ? strip_tags( $new_instance['url'] ) : '';
			$instance['show_button'] = $new_instance['show_button'];
			$instance['target'] = ( ! empty( $new_instance['target'] ) ) ? strip_tags( $new_instance['target'] ) : '';

			return $instance;
		}
	}	
}

if ( ! class_exists( 'BT_Weather_Widget' ) ) {

	// ICON

	class BT_Weather_Widget extends WP_Widget {

		function __construct() {
			parent::__construct(
				'bt_weather_widget', // Base ID
				__( 'BT Weather', 'bt_plugin' ), // Name
				array( 'description' => __( 'Weather widget.', 'bt_plugin' ) ) // Args
			);
		}

		public function widget( $args, $instance ) {
			
			$this->latitude = ! empty( $instance['latitude'] ) ? $instance['latitude'] : '';
			$this->longitude = ! empty( $instance['longitude'] ) ? $instance['longitude'] : '';
			$this->temp_unit = ! empty( $instance['temp_unit'] ) ? $instance['temp_unit'] : '';
			$this->type = ! empty( $instance['type'] ) ? $instance['type'] : '';
			$this->cache = ! empty( $instance['cache'] ) ? $instance['cache'] : '';
			
			$this->cache = intval( $this->cache );

			if ( $this->cache < 0 ) {
				$this->cache = 0;
			} else if ( $this->cache > 60 * 12 ) {
				$this->cache = 60 * 12;
			}
			
			$this->api_key = ! empty( $instance['api_key'] ) ? $instance['api_key'] : '';

			$trans_name = 'bt_bb_weather_data_' . md5( $this->latitude . $this->longitude . $this->temp_unit . $this->type . $this->cache );

			$weather_data = get_transient( $trans_name );

			if ( $weather_data === false ) {
				
				$session = false;

				if ( $this->type == 'now' ) {
					$session = curl_init( 'https://api.openweathermap.org/data/2.5/weather?lat=' . $this->latitude . '&lon=' . $this->longitude . '&units=' . $this->temp_unit . '&appid=' . $this->api_key );
				} else if ( $this->type == 'forecast12' || $this->type == 'forecast24' ) {
					$session = curl_init( 'https://api.openweathermap.org/data/2.5/forecast?lat=' . $this->latitude . '&lon=' . $this->longitude . '&units=' . $this->temp_unit . '&appid=' . $this->api_key );
				}
				
				if ( ! $session ) {
					return;
				}
				
				curl_setopt( $session, CURLOPT_RETURNTRANSFER, true );
				
				$json = curl_exec( $session );
				
				$result = json_decode( $json, true );

				if ( is_array( $result ) && ( isset( $result['weather'] ) || isset( $result['list'] ) ) ) {

					if ( $this->type == 'now' ) {

						$weather_data = array(
							'icon' => $result['weather'][0]['icon'],
							'temp' => round( $result['main']['temp'] ),
						);
						
						if ( $weather_data['temp'] == 0 ) { // -0 fix
							$weather_data['temp'] = 0;
						}
						
					} else if ( $this->type == 'forecast12' || $this->type == 'forecast24' ) {
						
						if ( $this->type == 'forecast12' ) {
							$n = 4;
						} else if ( $this->type == 'forecast24' ) {
							$n = 8;
						}

						$min_temp = 1000;
						$max_temp = -1000;
						
						$icons = array();
						$icons_int = array();
						$d_icons = 0;
						$n_icons = 0;

						$weather_data = array();
						
						for ( $i = 0; $i < $n; $i++ ) {
							
							$t = $result['list'][ $i ]['main']['temp'];
							
							if ( $t > $max_temp ) {
								$max_temp = $t;
							} else if ( $t < $min_temp ) {
								$min_temp = $t;
							}
							
							$icon = $result['list'][ $i ]['weather'][0]['icon'];
							
							$icons[] = $icon;
							$icons_int[] = intval( $icon );
							
							if ( strpos( $icon, 'd' ) ) {
								$d_icons++;
							} else if ( strpos( $icon, 'n' ) ) {
								$n_icons++;
							}
							
						}
						
						// temp
						
						$weather_data['temp_low'] = round( $min_temp );
						$weather_data['temp_high'] = round( $max_temp );
						
						if ( $weather_data['temp_low'] == 0 ) { // -0 fix
							$weather_data['temp_low'] = 0;
						}
						
						if ( $weather_data['temp_high'] == 0 ) { // -0 fix
							$weather_data['temp_high'] = 0;
						}
						
						// icon
						
						if ( in_array( '11', $icons_int ) ) {
							$weather_data['icon'] = '11d';
						} else if ( in_array( '13', $icons_int ) ) {
							$weather_data['icon'] = '13d';
						} else if ( in_array( '10', $icons_int ) ) {
							$weather_data['icon'] = '10d';
						} else if ( in_array( '9', $icons_int ) ) {
							$weather_data['icon'] = '09d';
						} else if ( in_array( '50', $icons_int ) ) {
							$weather_data['icon'] = '50d';
						} else if ( in_array( '4', $icons_int ) ) {
							$weather_data['icon'] = '04d';
						} else if ( in_array( '3', $icons_int ) ) {
							$weather_data['icon'] = '03d';
						} else {
							if ( $d_icons >= $n_icons ) {
								if ( in_array( '2', $icons_int ) ) {
									$weather_data['icon'] = '02d';
								} else if ( in_array( '1', $icons_int ) ) {
									$weather_data['icon'] = '01d';
								}
							} else {
								if ( in_array( '2', $icons_int ) ) {
									$weather_data['icon'] = '02n';
								} else if ( in_array( '1', $icons_int ) ) {
									$weather_data['icon'] = '01n';
								}
							}
						}
						
					}
					
					set_transient( $trans_name, $weather_data, $this->cache );
				
				}

			}

			if ( $weather_data !== false ) {
				if ( $this->type == 'now' ) {
					echo '<span class="btIconWidget btWidgetWithText">';
						echo '<span class="btIconWidgetIcon">';
							echo boldthemes_get_icon_html( 'wi_' . $this->get_icon_code( $weather_data['icon'] ), '', '', 'btIcoDefaultType btIcoDefaultColor', '' );
						echo '</span>';
						echo '<span class="btIconWidgetContent">';
							echo '<span class="btIconWidgetTitle">' . __( 'Now', 'bt_plugin' ) . '</span>';
							echo '<span class="btIconWidgetText">' . $weather_data['temp'] . '&deg;' . ( $this->temp_unit == 'imperial' ? 'F' : 'C' ) . '</span>';
						echo '</span>';
					echo '</span>';
				} else if ( $this->type == 'forecast12' || $this->type == 'forecast24' ) {
					echo '<span class="btIconWidget">';
						echo '<span class="btIconWidgetIcon">';
							echo boldthemes_get_icon_html( 'wi_' . $this->get_icon_code( $weather_data['icon'] ), '', '', 'btIcoDefaultType btIcoDefaultColor', '' );
						echo '</span>';
						echo '<span class="btIconWidgetContent">';
							if ( $this->type == 'forecast12' ) {
								echo '<span class="btIconWidgetTitle">' . __( '12 h', 'bt_plugin' ) . '</span>';
							} else if ( $this->type == 'forecast24' ) {
								echo '<span class="btIconWidgetTitle">' . __( '24 h', 'bt_plugin' ) . '</span>';
							}
							echo '<span class="btIconWidgetText">' . $weather_data['temp_low'] . '/' . $weather_data['temp_high'] . '&deg;' . ( $this->temp_unit == 'imperial' ? 'F' : 'C' ) . '</span>';
						echo '</span>';
					echo '</span>';
				}
			}
		}
		
		public function get_icon_code( $code ) {
			$map = array(
				'01d' => 'f00d',
				'02d' => 'f002',
				'03d' => 'f041',
				'04d' => 'f013',
				'09d' => 'f01a',
				'10d' => 'f019',
				'11d' => 'f01e',
				'13d' => 'f01b',
				'50d' => 'f014',
				
				'01n' => 'f02e',
				'02n' => 'f086',
				'03n' => 'f041',
				'04n' => 'f013',
				'09n' => 'f01a',
				'10n' => 'f019',
				'11n' => 'f01e',
				'13n' => 'f01b',
				'50n' => 'f014',				
			);

			return $map[ $code ];
		}	

		public function form( $instance ) {
			$latitude = ! empty( $instance['latitude'] ) ? $instance['latitude'] : '';
			$longitude = ! empty( $instance['longitude'] ) ? $instance['longitude'] : '';
			$temp_unit = ! empty( $instance['temp_unit'] ) ? $instance['temp_unit'] : '';
			$type = ! empty( $instance['type'] ) ? $instance['type'] : '';
			$cache = ! empty( $instance['cache'] ) ? $instance['cache'] : '30';
			$api_key = ! empty( $instance['api_key'] ) ? $instance['api_key'] : '';
			
			?>
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'latitude' ) ); ?>"><?php _e( 'Latitude:', 'bt_plugin' ); ?></label> 
					<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'latitude' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'latitude' ) ); ?>" type="text" value="<?php echo esc_attr( $latitude ); ?>">
				</p>
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'longitude' ) ); ?>"><?php _e( 'Longitude:', 'bt_plugin' ); ?></label> 
					<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'longitude' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'longitude' ) ); ?>" type="text" value="<?php echo esc_attr( $longitude ); ?>">
				</p>
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'temp_unit' ) ); ?>"><?php _e( 'Temperature unit:', 'bt_plugin' ); ?></label> 
					<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'temp_unit' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'temp_unit' ) ); ?>">
						<?php
						$target_arr = array( __( 'Celsius', 'bt_plugin' ) => 'metric', __( 'Fahrenheit', 'bt_plugin' ) => 'imperial' );
						foreach( $target_arr as $key => $value ) {
							if ( $value == $temp_unit ) {
								echo '<option value="' . esc_attr( $value ) . '" selected>' . $key . '</option>';
							} else {
								echo '<option value="' . esc_attr( $value ) . '">' . $key . '</option>';
							}
						}
						?>
					</select>
				</p>				
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'type' ) ); ?>"><?php _e( 'Type:', 'bt_plugin' ); ?></label> 
					<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'type' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'type' ) ); ?>">
						<?php
						$target_arr = array( __( 'Now', 'bt_plugin' ) => 'now', __( 'Next 12 hours', 'bt_plugin' ) => 'forecast12', __( 'Next 24 hours', 'bt_plugin' ) => 'forecast24' );
						foreach( $target_arr as $key => $value ) {
							if ( $value == $type ) {
								echo '<option value="' . esc_attr( $value ) . '" selected>' . $key . '</option>';
							} else {
								echo '<option value="' . esc_attr( $value ) . '">' . $key . '</option>';
							}
						}
						?>
					</select>
				</p>
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'cache' ) ); ?>"><?php _e( 'Cache (minutes):', 'bt_plugin' ); ?></label> 
					<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'cache' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'cache' ) ); ?>" type="text" value="<?php echo esc_attr( $cache ); ?>">			
				</p>
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'api_key' ) ); ?>"><?php _e( 'API key:', 'bt_plugin' ); ?></label> 
					<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'api_key' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'api_key' ) ); ?>" type="text" value="<?php echo esc_attr( $api_key ); ?>">
					<br>
					<i><?php _e( 'Get Openweather API key here: ', 'bt_plugin' ); ?></i><a href="https://openweathermap.org/appid" target="_blank">https://openweathermap.org/appid</a>
				</p>		
				
			<?php 
		}

		public function update( $new_instance, $old_instance ) {
			$instance = array();
			$instance['latitude'] = ( ! empty( $new_instance['latitude'] ) ) ? strip_tags( $new_instance['latitude'] ) : '';
			$instance['longitude'] = ( ! empty( $new_instance['longitude'] ) ) ? strip_tags( $new_instance['longitude'] ) : '';
			$instance['temp_unit'] = ( ! empty( $new_instance['temp_unit'] ) ) ? strip_tags( $new_instance['temp_unit'] ) : '';
			$instance['type'] = ( ! empty( $new_instance['type'] ) ) ? strip_tags( $new_instance['type'] ) : '';
			$instance['cache'] = ( ! empty( $new_instance['cache'] ) ) ? strip_tags( $new_instance['cache'] ) : '';
			$instance['api_key'] = ( ! empty( $new_instance['api_key'] ) ) ? strip_tags( $new_instance['api_key'] ) : '';
			
			return $instance;
		}
	}
}

if ( ! class_exists( 'BT_Time_Widget' ) ) {

	// TIME

	class BT_Time_Widget extends WP_Widget {

		function __construct() {
			parent::__construct(
				'bt_time_widget', // Base ID
				__( 'BT Time', 'bt_plugin' ), // Name
				array( 'description' => __( 'Time widget.', 'bt_plugin' ) ) // Args
			);
		}

		public function widget( $args, $instance ) {
			
			wp_enqueue_script( 'bt_moment', plugin_dir_url( __FILE__ ) . 'moment.js', array(), '', true );
			wp_enqueue_script( 'bt_moment_timezone', plugin_dir_url( __FILE__ ) . 'moment-timezone-with-data.js', array(), '', true );
			
			$this->container_id = uniqid( 'time' );
			
			$this->time_zone = ! empty( $instance['time_zone'] ) ? $instance['time_zone'] : '';
			$this->place_name = ! empty( $instance['place_name'] ) ? $instance['place_name'] : '';
			$this->time_notation = ! empty( $instance['time_notation'] ) ? $instance['time_notation'] : '';
			
			$proxy = new BT_Time_Widget_Proxy( $this->time_zone, $this->place_name, $this->time_notation, $this->container_id );
			add_action( 'wp_footer', array( $proxy, 'js' ) );
			
			echo '<span id="' . $this->container_id . '" class="btIconWidget btTimeWidget"><span class="btIconWidgetIcon">' . boldthemes_get_icon_html( 'fa_f017', '', '', 'btIcoDefaultType btIcoAccentColor', '' ) . '</span><span class="btIconWidgetContent"><span class="btIconWidgetTitle">' . $this->place_name . '</span><span class="btIconWidgetText"></span></span></span>';
		}

		public function form( $instance ) {
			$time_zone = ! empty( $instance['time_zone'] ) ? $instance['time_zone'] : '';
			$place_name = ! empty( $instance['place_name'] ) ? $instance['place_name'] : '';
			$time_notation = ! empty( $instance['time_notation'] ) ? $instance['time_notation'] : '';
			
			?>
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'time_zone' ) ); ?>"><?php _e( 'Time zone:', 'bt_plugin' ); ?></label> 
					<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'time_zone' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'time_zone' ) ); ?>">
						<?php
						
						require_once( 'time.php' );
						
						$tz = bt_time_zone();

						foreach ( $tz as $item ) {
							if ( $item == $time_zone ) {
								echo '<option value="' . $item . '" selected>' . $item . '</option>';
							} else {
								echo '<option value="' . $item . '">' . $item . '</option>';
							}
						}
						?>
					</select>
				</p>
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'place_name' ) ); ?>"><?php _e( 'Place name:', 'bt_plugin' ); ?></label> 
					<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'place_name' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'place_name' ) ); ?>" type="text" value="<?php echo esc_attr( $place_name ); ?>">
				</p>
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'time_notation' ) ); ?>"><?php _e( 'Time notation:', 'bt_plugin' ); ?></label> 
					<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'time_notation' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'time_notation' ) ); ?>">
						<?php
						
						require_once( 'time.php' );
						
						$tn = array( __( '24 hours', 'bt_plugin' ) => '24', __( '12 hours', 'bt_plugin' ) => '12' );

						foreach ( $tn as $k => $v ) {
							if ( $v == $time_notation ) {
								echo '<option value="' . $v . '" selected>' . $k . '</option>';
							} else {
								echo '<option value="' . $v . '">' . $k . '</option>';
							}
						}
						?>
					</select>
				</p>
			<?php 
		}

		public function update( $new_instance, $old_instance ) {
			$instance = array();
			$instance['time_zone'] = ( ! empty( $new_instance['time_zone'] ) ) ? strip_tags( $new_instance['time_zone'] ) : '';
			$instance['place_name'] = ( ! empty( $new_instance['place_name'] ) ) ? strip_tags( $new_instance['place_name'] ) : '';
			$instance['time_notation'] = ( ! empty( $new_instance['time_notation'] ) ) ? strip_tags( $new_instance['time_notation'] ) : '';

			return $instance;
		}
	}
	
	class BT_Time_Widget_Proxy {
		function __construct( $time_zone, $place_name, $time_notation, $container_id ) {
			$this->time_zone = $time_zone;
			$this->place_name = $place_name;
			$this->time_notation = $time_notation;
			$this->container_id = $container_id;
		}
		public function js() { ?>
			<script>
				(function( $ ) {
					$( document ).ready(function() {
						
						var time_notation = '<?php echo $this->time_notation; ?>';
						
						var time = function() {
							
							if ( time_notation == '12' ) {
								var time = moment().tz( '<?php echo $this->time_zone; ?>' ).format( 'h:mm A' );
							} else {
								var time = moment().tz( '<?php echo $this->time_zone; ?>' ).format( 'H:mm' );
							}

							$( '#<?php echo $this->container_id; ?> .btIconWidgetText' ).html( time );
						}
						setInterval( function() {
							time();
						}, 1000 );
						time();
					});
				})( jQuery );
			</script>
		<?php }		
	}
}

if ( ! class_exists( 'BT_Recent_Posts' ) ) {
	
	// RECENT POSTS	
	
	class BT_Recent_Posts extends WP_Widget {
	
		function __construct() {
			parent::__construct(
				'bt_recent_posts', // Base ID
				__( 'BT Recent Posts', 'bt_plugin' ), // Name
				array( 'description' => __( 'Recent posts with thumbnails.', 'bt_plugin' ) ) // Args
			);
		}

		public function widget( $args, $instance ) {
		
			echo $args['before_widget'];
			if ( ! empty( $instance['title'] ) ) {
				echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
			}

			$number = intval( trim( $instance['number'] ) );
			if ( $number < 1 ) {
				$number = 5;
			} else if ( $number > 30 ) {
				$number = 30;
			}
			
			echo '<div class="popularPosts"><ul>';
			
			$recent_posts = wp_get_recent_posts( array( 'numberposts' => $number, 'post_status' => 'publish' ) );
			foreach ( $recent_posts as $recent ) {
				$link = get_permalink( $recent['ID'] );
				$user_data = get_userdata( $recent['post_author'] );
				$user_url = $user_data->data->user_url;
				
				$post_format = get_post_format( $recent['ID'] );
				$images = boldthemes_rwmb_meta( BoldThemesFramework::$pfx . '_images', 'type=image', $recent['ID'] );
				if ( $images == null ) $images = array();
				
				$img = get_the_post_thumbnail( $recent['ID'], 'thumbnail' );
				
				if ( $post_format == 'image' && $img == '' ) {
					foreach ( $images as $img ) {
						$src = $img['full_url'];
						$img = '<img src="' . esc_url( $src ) . '" alt="' . esc_attr( basename( $src ) ) . '">';
						break;
					}
				}					

				echo '<li>';
				if ( $img != '' ) echo '<div class="ppImage"><a href="' . esc_url( $link ) . '">' . $img . '</a></div>';

				$supertitle = '';
				$title = '';
				$subtitle = '';
				if ( boldthemes_get_option( 'blog_date' ) ) {
					$supertitle = date_i18n( BoldThemesFramework::$date_format, strtotime( get_the_time( 'Y-m-d', $recent['ID'] ) ) );
				}
				$title = '<a href="' . esc_url( $link ) . '">' . esc_html( $recent['post_title'] ) . '</a>';
				echo '<div class="ppTxt">' . boldthemes_get_heading_html( $supertitle, $title, $subtitle, 'small', '', '', '' ) . '</div>';
			}
			
			echo '</ul></div>';
				
			echo $args['after_widget'];
		}
		
		public function form( $instance ) {
			$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Recent Posts', 'bt_plugin' );
			$number = ! empty( $instance['number'] ) ? $instance['number'] : '5';
			?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'bt_plugin' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php _e( 'Number of posts:', 'bt_plugin' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="text" value="<?php echo esc_attr( $number ); ?>">			
			</p>
			<?php 
		}

		public function update( $new_instance, $old_instance ) {
			$instance = array();
			$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
			$instance['number'] = ( ! empty( $new_instance['number'] ) ) ? strip_tags( $new_instance['number'] ) : '';

			return $instance;
		}
	}
}


if ( ! class_exists( 'BT_Recent_Comments' ) ) {
	
	// RECENT COMMENTS	
	
	class BT_Recent_Comments extends WP_Widget {
	
		function __construct() {
			parent::__construct(
				'bt_recent_comments', // Base ID
				__( 'BT Recent Comments', 'bt_plugin' ), // Name
				array( 'description' => __( 'Recent comments with avatars.', 'bt_plugin' ) ) // Args
			);
		}

		public function widget( $args, $instance ) {
		
			echo $args['before_widget'];
			if ( ! empty( $instance['title'] ) ) {
				echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
			}			

			$number = intval( trim( $instance['number'] ) );
			if ( $number < 1 ) {
				$number = 5;
			} else if ( $number > 30 ) {
				$number = 30;
			}
			
			echo '<div class="latestComments"><ul>';
			
			$comments_query = new WP_Comment_Query;
			$recent_comments = $comments_query->query( array( 'number' => $number, 'status' => 'approve' ) );
			if ( $recent_comments ) {
				foreach ( $recent_comments as $recent ) {
					echo '<li><h5><a href="' . esc_url( get_permalink( $recent->comment_post_ID ) ) . '">' . esc_html( get_the_title( $recent->comment_post_ID ) ) . '</a></h5><p class="posted">' . date_i18n( BoldThemesFramework::$date_format, strtotime( get_the_time( 'Y-m-d', $recent->comment_date ) ) ) . ' &mdash; ' . __( 'by', 'bt_plugin' ) . ' <a href="' . esc_url( $recent->comment_author_url ) . '">' . $recent->comment_author . '</a></p></li>';
				}
			}

			echo '</div></ul>';
				
			echo $args['after_widget'];
		}
		
		public function form( $instance ) {
			$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Recent Comments', 'bt_plugin' );
			$number = ! empty( $instance['number'] ) ? $instance['number'] : '5';
			?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'bt_plugin' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php _e( 'Number of comments:', 'bt_plugin' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="text" value="<?php echo esc_attr( $number ); ?>">			
			</p>
			<?php 
		}

		public function update( $new_instance, $old_instance ) {
			$instance = array();
			$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
			$instance['number'] = ( ! empty( $new_instance['number'] ) ) ? strip_tags( $new_instance['number'] ) : '';

			return $instance;
		}
	}
}

if ( ! class_exists( 'BT_Instagram' ) ) {
	
	// INSTAGRAM	
	
	class BT_Instagram extends WP_Widget {
		
		private $feed_id;
	
		function __construct() {
			parent::__construct(
				'bt_instagram', // Base ID
				__( 'BT Instagram', 'bt_plugin' ), // Name
				array( 'description' => __( 'Instagram photos.', 'bt_plugin' ) ) // Args
			);
		}

		public function widget( $args, $instance ) {

			wp_enqueue_script( 'bt_instagram', plugin_dir_url( __FILE__ ) . 'instafeed.min.js', array(), '', true );

			$number = intval( trim( $instance['number'] ) );
			if ( $number < 1 ) {
				$number = 4;
			} else if ( $number > 30 ) {
				$number = 30;
			}
			
			$instance['tag'] = isset( $instance['tag'] ) ? $instance['tag'] : '';
			$instance['access_token'] = isset( $instance['access_token'] ) ? $instance['access_token'] : '';
			
			$this->feed_id = uniqid( 'instafeed' );
			
			$this->number = $number;
			$this->user_id = trim( $instance['user_id'] );
			$this->tag = trim( $instance['tag'] );
			$this->client_id = trim( $instance['client_id'] );
			$this->access_token = trim( $instance['access_token'] );
			
			// if ( $this->number == '' || $this->user_id == '' || $this->client_id == '' ) {
			if ( $this->access_token == '' || $this->client_id == '' || $this->tag == '' ) {
				return;
			}

			echo $args['before_widget'];
			if ( ! empty( $instance['title'] ) ) {
				echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
			}
			
			echo '<div class="btInstaWrap">';
			echo '<div id="' . $this->feed_id . '" class="btInstaGrid"></div>';
			echo '</div>';				
			echo $args['after_widget'];
			
			$proxy = new BT_Instagram_Proxy( $this->feed_id, $this->number, $this->user_id, $this->tag, $this->client_id, $this->access_token );
			add_action( 'wp_footer', array( $proxy, 'js' ) );
		}
	
		
		public function form( $instance ) {
			$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Instagram', 'bt_plugin' );
			$number = ! empty( $instance['number'] ) ? $instance['number'] : '4';
			$user_id = ! empty( $instance['user_id'] ) ? $instance['user_id'] : '';
			$tag = ! empty( $instance['tag'] ) ? $instance['tag'] : '';
			$client_id = ! empty( $instance['client_id'] ) ? $instance['client_id'] : '';
			$access_token = ! empty( $instance['access_token'] ) ? $instance['access_token'] : '';
			?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'bt_plugin' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php _e( 'Number of photos:', 'bt_plugin' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="text" value="<?php echo esc_attr( $number ); ?>">			
			</p>
			<!--p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'user_id' ) ); ?>"><?php _e( 'User ID:', 'bt_plugin' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'user_id' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'user_id' ) ); ?>" type="text" value="<?php echo esc_attr( $user_id ); ?>">			
			</p-->
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'tag' ) ); ?>"><?php _e( 'Hashtag:', 'bt_plugin' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'tag' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'tag' ) ); ?>" type="text" value="<?php echo esc_attr( $tag ); ?>">			
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'client_id' ) ); ?>"><?php _e( 'Client ID:', 'bt_plugin' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'client_id' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'client_id' ) ); ?>" type="text" value="<?php echo esc_attr( $client_id ); ?>">			
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'access_token' ) ); ?>"><?php _e( 'Access token:', 'bt_plugin' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'access_token' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'access_token' ) ); ?>" type="text" value="<?php echo esc_attr( $access_token ); ?>">			
			</p>
			<?php 
		}

		public function update( $new_instance, $old_instance ) {
			$instance = array();
			$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
			$instance['number'] = ( ! empty( $new_instance['number'] ) ) ? strip_tags( $new_instance['number'] ) : '';
			$instance['user_id'] = ( ! empty( $new_instance['user_id'] ) ) ? strip_tags( $new_instance['user_id'] ) : '';
			$instance['tag'] = ( ! empty( $new_instance['tag'] ) ) ? strip_tags( $new_instance['tag'] ) : '';
			$instance['client_id'] = ( ! empty( $new_instance['client_id'] ) ) ? strip_tags( $new_instance['client_id'] ) : '';
			$instance['access_token'] = ( ! empty( $new_instance['access_token'] ) ) ? strip_tags( $new_instance['access_token'] ) : '';
			
			return $instance;
		}
	}
	
	class BT_Instagram_Proxy {
		function __construct( $feed_id, $number, $user_id, $tag, $client_id, $access_token ) {
			$this->feed_id = $feed_id;
			$this->number = $number;
			$this->user_id = $user_id;
			$this->tag = $tag;
			$this->client_id = $client_id;
			$this->access_token = $access_token;
		}
		public function js() { ?>
			<script>
				jQuery( document ).ready(function() {
					var feed = new Instafeed({
						get: 'tagged',
						tagName: '<?php echo $this->tag; ?>',
						target: '<?php echo $this->feed_id; ?>', 
						limit: '<?php echo $this->number; ?>',
						template: '<span><a href="{{link}}"><img src="{{image}}" /></a></span>',
						clientId: '<?php echo $this->client_id; ?>',
						accessToken: '<?php echo $this->access_token; ?>'
					});
					feed.run();
				});
			</script>
		<?php }
	}	
	
}

if ( ! function_exists( 'bt_get_twitter_data' ) ) {
	
	function bt_get_twitter_data( $number, $cache, $cache_id, $username, $consumer_key, $consumer_secret, $access_token, $access_token_secret ) {
		
		if ( $number < 1 ) {
			$number = 5;
		} else if ( $number > 30 ) {
			$number = 30;
		}

		if ( $cache == 0 || $cache < 0 ) {
			$cache = 0;
		} else if ( $cache > 720 ) {
			$cache = 720;
		}
		
		$trans_name = 'bt_tweets_' . $cache_id;
		
		if ( $cache == 0 ) {
			delete_transient( $trans_name );
		}

		if ( false == ( $twitter_data = unserialize( base64_decode( get_transient( $trans_name ) ) ) ) ) {
			require_once( 'twitteroauth.php' );
			$twitter_connection = new TwitterOAuth( $consumer_key, $consumer_secret, $access_token, $access_token_secret );
			if ( !preg_match( '/#/', $username ) ) {
				$twitter_data = $twitter_connection->get(
					'statuses/user_timeline',
					array(
						'screen_name'		=> $username,
						'count'				=> $number,
						'exclude_replies'	=> false
					)
				);
			} else {
				$twitter_data = $twitter_connection->get(
					'search/tweets',
					array(
						'q'					=> $username,
						'count'				=> $number,
						'exclude_replies'	=> false
					)
				);
				$twitter_data = $twitter_data -> statuses;
			}

			if ( $twitter_connection->http_code != 200 ) {
				$twitter_data = unserialize( base64_decode( get_transient( $trans_name ) ) );
			}

			if ( $cache > 0 ) {
				set_transient( $trans_name, base64_encode( serialize( $twitter_data ) ), 60 * $cache );
			}
			
		}
		
		return $twitter_data;
	}
}

if ( ! class_exists( 'BT_Twitter_Widget' ) ) {
	
	// TWITTER	
	
	class BT_Twitter_Widget extends WP_Widget {
	
		function __construct() {
			parent::__construct(
				'bt_twitter_widget', // Base ID
				__( 'BT Twitter', 'bt_plugin' ), // Name
				array( 'description' => __( 'Twitter feed.', 'bt_plugin' ) ) // Args
			);
		}

		public function widget( $args, $instance ) {
			
			$number = intval( trim( $instance['number'] ) );
			$cache = intval( trim( $instance['cache'] ) );	

			$this->number = $number;
			$this->cache = $cache;
			$this->cache_id = $instance['cache_id'];
			$this->username = trim( $instance['username'] );
			$this->consumer_key = trim( $instance['consumer_key'] );
			$this->consumer_secret = trim( $instance['consumer_secret'] );
			$this->access_token = trim( $instance['access_token'] );
			$this->access_token_secret = trim( $instance['access_token_secret'] );
			
			if ( $this->number == '' || $this->username == '' || $this->consumer_key == '' || $this->consumer_secret == '' || $this->access_token == '' || $this->access_token_secret == '' ) {
				return;
			}			
		
			echo $args['before_widget'];
			if ( ! empty( $instance['title'] ) ) {
				echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
			}

			$twitter_data = bt_get_twitter_data( $this->number, $this->cache, $this->cache_id, $this->username, $this->consumer_key, $this->consumer_secret, $this->access_token, $this->access_token_secret );
			
			echo '<div class="recentTweets">';

			foreach ( $twitter_data as $data ) {
				$user =  $data->user->screen_name;
				$profile_link = 'https://twitter.com/' . $user ;
				$link = 'https://twitter.com/' . $user . '/status/' . $data->id_str;
				
				$text = mb_convert_encoding( utf8_encode( $data->text ), 'HTML-ENTITIES', 'UTF-8' );

				$time = human_time_diff( strtotime( $data->created_at ) );

				echo '<small><a href="' . esc_url( $link ) . '">@' . $user . ' - ' . $time . '</a></small>';
				echo '<p>' . BT_Twitter_Widget::parse( $data->text ) . '</p>';
			}
			
			echo '</div>';
				
			echo $args['after_widget'];
		}
		
		public function form( $instance ) {
			$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Twitter', 'bt_plugin' );
			$number = ! empty( $instance['number'] ) ? $instance['number'] : '5';
			$cache = ! empty( $instance['cache'] ) ? $instance['cache'] : '0';
			$username = ! empty( $instance['username'] ) ? $instance['username'] : '';
			$consumer_key = ! empty( $instance['consumer_key'] ) ? $instance['consumer_key'] : '';
			$consumer_secret = ! empty( $instance['consumer_secret'] ) ? $instance['consumer_secret'] : '';
			$access_token = ! empty( $instance['access_token'] ) ? $instance['access_token'] : '';
			$access_token_secret = ! empty( $instance['access_token_secret'] ) ? $instance['access_token_secret'] : '';
			?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'bt_plugin' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php _e( 'Number of tweets:', 'bt_plugin' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="text" value="<?php echo esc_attr( $number ); ?>">			
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'username' ) ); ?>"><?php _e( 'Username  (or #hashtag):', 'bt_plugin' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'username' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'username' ) ); ?>" type="text" value="<?php echo esc_attr( $username ); ?>">			
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'cache' ) ); ?>"><?php _e( 'Cache (minutes):', 'bt_plugin' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'cache' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'cache' ) ); ?>" type="text" value="<?php echo esc_attr( $cache ); ?>">			
			</p>		
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'consumer_key' ) ); ?>"><?php _e( 'Consumer key:', 'bt_plugin' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'consumer_key' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'consumer_key' ) ); ?>" type="text" value="<?php echo esc_attr( $consumer_key ); ?>">			
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'consumer_secret' ) ); ?>"><?php _e( 'Consumer secret:', 'bt_plugin' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'consumer_secret' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'consumer_secret' ) ); ?>" type="text" value="<?php echo esc_attr( $consumer_secret ); ?>">			
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'access_token' ) ); ?>"><?php _e( 'Access token:', 'bt_plugin' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'access_token' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'access_token' ) ); ?>" type="text" value="<?php echo esc_attr( $access_token ); ?>">			
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'access_token_secret' ) ); ?>"><?php _e( 'Access token secret:', 'bt_plugin' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'access_token_secret' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'access_token_secret' ) ); ?>" type="text" value="<?php echo esc_attr( $access_token_secret ); ?>">			
			</p>			
			<?php 
		}

		public function update( $new_instance, $old_instance ) {
			$instance = array();
			$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
			$instance['number'] = ( ! empty( $new_instance['number'] ) ) ? strip_tags( $new_instance['number'] ) : '';
			$instance['username'] = ( ! empty( $new_instance['username'] ) ) ? strip_tags( $new_instance['username'] ) : '';
			$instance['cache'] = ( ! empty( $new_instance['cache'] ) ) ? strip_tags( $new_instance['cache'] ) : '';
			$instance['cache_id'] = ( ! empty( $new_instance['cache_id'] ) ) ? strip_tags( $new_instance['cache_id'] ) : uniqid();
			$instance['consumer_key'] = ( ! empty( $new_instance['consumer_key'] ) ) ? strip_tags( $new_instance['consumer_key'] ) : '';
			$instance['consumer_secret'] = ( ! empty( $new_instance['consumer_secret'] ) ) ? strip_tags( $new_instance['consumer_secret'] ) : '';
			$instance['access_token'] = ( ! empty( $new_instance['access_token'] ) ) ? strip_tags( $new_instance['access_token'] ) : '';
			$instance['access_token_secret'] = ( ! empty( $new_instance['access_token_secret'] ) ) ? strip_tags( $new_instance['access_token_secret'] ) : '';

			return $instance;
		}
		
		static function parse( $text ) {
			$text = preg_replace( '/\b([a-zA-Z]+:\/\/[\w_.\-]+\.[a-zA-Z]{2,6}[\/\w\-~.?=&%#+$*!]*)\b/i', '<a href="$1" class="twitter-link">$1</a>', $text );
			$text = preg_replace( '/\b(?<!:\/\/)(www\.[\w_.\-]+\.[a-zA-Z]{2,6}[\/\w\-~.?=&%#+$*!]*)\b/i', '<a href="http://$1" class="twitter-link">$1</a>', $text );

			$text = preg_replace( '/\b([a-zA-Z][a-zA-Z0-9\_\.\-]*[a-zA-Z]*\@[a-zA-Z][a-zA-Z0-9\_\.\-]*[a-zA-Z]{2,6})\b/i', '<a href="mailto://$1" class="twitter-link">$1</a>', $text );

			$text = preg_replace( '/([\.|\,|\:|\|\|\>|\{|\(]?)#{1}(\w*)([\.|\,|\:|\!|\?|\>|\}|\)]?)\s/i', '$1<a href="https://twitter.com/hashtag/$2" class="twitter-link">#$2</a>$3 ', $text );
			
			$text = preg_replace( '/([\.|\,|\:|\|\|\>|\{|\(]?)@{1}(\w*)([\.|\,|\:|\!|\?|\>|\}|\)]?)\s/i', '$1<a href="https://twitter.com/$2" class="twitter-user">@$2</a>$3 ', $text );			
			
			return $text;
		}
	}
}

if ( ! class_exists( 'BT_Date_Widget' ) ) {

	// DATE
	class BT_Date_Widget extends WP_Widget {

		function __construct() {
			parent::__construct(
				'bt_date_widget', 
				__( 'BT Date', 'bt_plugin' ), 
				array( 'description' => __( 'Date widget.', 'bt_plugin' ) ) 
			);
		}

		public function widget( $args, $instance ) {
			$icon				= ! empty( $instance['icon'] ) ? $instance['icon'] : '';
			$date_format		= ! empty( $instance['date_format'] ) ? $instance['date_format'] : 'd.F Y';
			$custom_date_format = ! empty( $instance['custom_date_format'] ) ? $instance['custom_date_format'] : '';

			define( 'MY_TIMEZONE',  date_default_timezone_get() );
			date_default_timezone_set( MY_TIMEZONE );

			if ( !empty($custom_date_format) ){
				$date_format = $custom_date_format;
			}

			$icon_html = '';
			if ( $icon != '' && $icon != 'no_icon' ) {
				$icon_html = '<span class="btIconWidgetIcon">' . boldthemes_get_icon_html( $icon, '', '', 'btIcoDefaultType btIcoAccentColor', '' ) . '</span>';
			}

			echo '<span id="' . uniqid( 'time' ) . '" class="btIconWidget btDateWidget">'. $icon_html .
					'<span class="btIconWidgetContent">
						<span class="btIconWidgetTitle">' . esc_html( date_i18n($date_format) ) . '</span>
					</span>
				</span>';
		
		}

		public function form( $instance ) {
			$icon				= ! empty( $instance['icon'] )				? $instance['icon'] : '';
			$date_format		= ! empty( $instance['date_format'] )		? $instance['date_format'] : '';
			$custom_date_format = ! empty( $instance['custom_date_format'] )? $instance['custom_date_format'] : '';

			if ( ! function_exists( 'bt_fa_icons' ) ) {
				require_once( 'bt_fa_icons.php' );
			}
			if ( ! function_exists( 'bt_s7_icons' ) ) {
				require_once( 'bt_s7_icons.php' );
			}		
			if ( ! function_exists( 'bt_custom_icons' ) ) {
				require_once( 'bt_custom_icons.php' );
			}
			$icon_arr = array_merge( array( ' ' => 'no_icon' ), bt_fa_icons(), bt_s7_icons(), bt_custom_icons() );
			ksort( $icon_arr );

			$date_format_arr = array( 
				'd.F Y   ( ' . date_i18n('d.F Y') . ' )'	=> 'd.F Y', 
				'F j, Y  ( ' . date_i18n('F j, Y') . ' )'	=> 'F j, Y',
				'Y-m-d   ( ' . date_i18n('Y-m-d') . ' )'	=> 'Y-m-d',
				'm/d/Y   ( ' . date_i18n('m/d/Y') . ' )'	=> 'm/d/Y',
				'd/m/Y   ( ' . date_i18n('d/m/Y') . ' )'	=> 'd/m/Y',
				'Y/m/d   ( ' . date_i18n('Y/m/d') . ' )'	=> 'Y/m/d',
				'F jS, Y ( ' . date_i18n('F jS, Y') . ' )'	=> 'F jS, Y',				
				'M d, Y  ( ' . date_i18n('M d, Y') . ' )'	=> 'M d, Y',
				'd M, Y  ( ' . date_i18n('d M, Y') . ' )'	=> 'd M, Y'
			);
			?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'icon' ) ); ?>"><?php _e( 'Icon:', 'bt_plugin' ); ?></label> 
				<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'icon' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'icon' ) ); ?>">
					<option value=""></option>;
					<?php
					foreach( $icon_arr as $key => $value ) {
						if ( $value == $icon ) {
							echo '<option value="' . $value . '" selected>' . $key . '</option>';
						} else {
							echo '<option value="' . $value . '">' . $key . '</option>';
						}
					}
					?>
				</select>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'date_format' ) ); ?>"><?php _e( 'Date format:', 'bt_plugin' ); ?></label> 
				<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'date_format' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'date_format' ) ); ?>">
					<option value=""></option>;
					<?php
					foreach( $date_format_arr as $key => $value ) {
						if ( $value == $date_format ) {
							echo '<option value="' . $value . '" selected>' . $key . '</option>';
						} else {
							echo '<option value="' . $value . '">' . $key . '</option>';
						}
					}
					?>
				</select>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'custom_date_format' ) ); ?>"><?php _e( 'Custom date format:', 'bt_plugin' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'custom_date_format' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'custom_date_format' ) ); ?>" type="text" value="<?php echo esc_attr( $custom_date_format ); ?>">
			</p>
			<?php 
		}

		public function update( $new_instance, $old_instance ) {
			$instance = array();
			$instance['icon']				= ( ! empty( $new_instance['icon'] ) ) ? strip_tags( $new_instance['icon'] ) : '';
			$instance['date_format']		= ( ! empty( $new_instance['date_format']) ) ?  $new_instance['date_format'] : '';
			$instance['custom_date_format'] = ( ! empty( $new_instance['custom_date_format']) ) ?  $new_instance['custom_date_format'] : '';

			return $instance;

		}
	}
}

if ( ! class_exists( 'BT_Custom_Categories_Widget' ) ) {
	
	// BT Custom Categories Widget
	
	class BT_Custom_Categories_Widget extends WP_Widget {
	
		function __construct() {
			parent::__construct(
				'bt_custom_categories_widget', // Base ID
				__( 'BT Categories Widget', 'bt_plugin' ), // Name
				array( 'classname' => 'widget_categories', 'description' => __( 'Custom Categories Widget.', 'bt_plugin' ) ) // Args
			);
		}

		public function widget( $args, $instance ) {
				extract($args, EXTR_SKIP);
			 
				echo $before_widget;
				$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
				$show_title = isset($instance['show_title']) ?  $instance['show_title'] : '';
				$category_slug = isset($instance['category_slug']) ?  $instance['category_slug'] : '';	
				$cat_id = isset($instance['category']) ?  $instance['category'] : '';
				$dcw_limit = '';
				$dcw_option_name =  __( 'Select A Category', 'bt_plugin' );    
				$dcw_exclude = '';
				$dcw_depth = $instance['dcw_depth'];
				$display_empty_categories = $instance['display_empty_categories'];
				$showcount_value = $instance['showcount_value'];
				$show_format = $instance['show_format'];
				$dcw_exclude_slug = $instance['dcw_exclude_slug'];
				
				if ( !empty($category_slug) ){
					$cat = get_category_by_slug($category_slug); 				
					$cat_id = $cat->term_id;	
				}
				
				if ( !empty($dcw_exclude_slug) ){
					$dcw_exclude_slugs = trim( $dcw_exclude_slug );
					$dcw_exclude_slugs = explode(',', $dcw_exclude_slugs);
					if ( count($dcw_exclude_slugs) ) {
						$dcw_exclude_arr = array();
						foreach ( $dcw_exclude_slugs as $slug ){
							$cat = get_category_by_slug($slug); 				
							$dcw_exclude_arr[] = $cat->term_id;	
						}						
						$dcw_exclude = implode("," , $dcw_exclude_arr);
					}
				}

				if ( !empty($title) && $show_title == true )
				  echo $before_title . $title . $after_title;;
				  
				 if($cat_id=="BLANK") $cat_id="0";
				 if($dcw_depth=="BLANK") $dcw_depth="0";
				 
				if($instance['show_format']==0) //list
				{
				  echo "<ul>"; 
					wp_list_categories('orderby=name&show_count='.$showcount_value.'&child_of='.$cat_id.'&hide_empty='.$display_empty_categories.'&title_li=&number='.$dcw_limit.'&exclude='.$dcw_exclude.'&depth='.$dcw_depth);
				  echo "</ul>";
				}

				if($instance['show_format']==2) //drop down
				{
				?>
				  <form action="<?php bloginfo('url'); ?>" method="get">
				  <div>
					  <?php wp_dropdown_categories('show_option_none='.$dcw_option_name.'&orderby=name&hierarchical=1&show_count='.$showcount_value.'&child_of='.$cat_id.'&hide_empty='.$display_empty_categories.'&title_li=&number='.$dcw_limit.'&exclude='.$dcw_exclude.'&depth='.$dcw_depth); 
					  ?>
					  <script type="text/javascript">
						<!--
						var dropdown = document.getElementById("cat");
						function onCatChange() {
						  if ( dropdown.options[dropdown.selectedIndex].value > 0 ) {
							location.href = "<?php echo esc_url( home_url( '/' ) ); ?>?cat="+dropdown.options[dropdown.selectedIndex].value;
						  }
						}
						dropdown.onchange = onCatChange;
						-->
					  </script>
				  </div>
				  </form>
				  
				<?php
				}
				echo $after_widget;
		}

		public function form( $instance ) {
			    $instance = wp_parse_args( (array) $instance, array( 'title' => '','cat_id' => '' ) );
				$title = ! empty( $instance['title'] ) ? $instance['title'] : '';
				$show_title = ! empty( $instance['show_title'] ) ? $instance['show_title'] : '';
				$category_slug = ! empty( $instance['category_slug'] ) ? $instance['category_slug'] : '';
				$category = ! empty( $instance['category'] ) ? $instance['category'] : '';
				$dcw_option_name =  __( 'Select A Category', 'bt_plugin' );
				$dcw_depth = ! empty( $instance['dcw_depth'] ) ? $instance['dcw_depth'] : '';
				$display_empty_categories = ! empty( $instance['display_empty_categories'] ) ? $instance['display_empty_categories'] : '';
				$showcount_value = ! empty( $instance['showcount_value'] ) ? $instance['showcount_value'] : '';
				$show_format= ! empty( $instance['show_format'] ) ? $instance['show_format'] : '';
				$dcw_exclude_slug = ! empty( $instance['dcw_exclude_slug'] ) ? $instance['dcw_exclude_slug'] : '';

				$categories = get_categories(array( 'hide_empty' => 0));
		 
				$cat_options = array();
				$cat_options[] = '<option value="BLANK">Select one...</option>';
				foreach ($categories as $cat) {
					$selected = ($category == $cat->cat_ID) ? ' selected="selected"' : '';
					$cat_options[] = '<option value="' . $cat->cat_ID .'"' . $selected . '>' . $cat->name . '</option>';
				}

				$depth_options = array();
				//$depth_options[] = '<option value="BLANK">Select one...</option>';
				$depths = array(
					"All Categories and child Categories"	=>	"0",
					"Show only top level Categories"		=>	"1",
					"All Categories displayed in flat (no indent) form (overrides hierarchical)"	=>	"-1"
				);
				foreach ($depths as $key => $value) {
					$selected = ( $value == $dcw_depth ) ? ' selected="selected"' : '';
					$depth_options[] = '<option value="' . $value . '"' . $selected . '>' . $key . '</option>';
				}
				?>
				<p>
					<label for="<?php echo $this->get_field_id('title'); ?>">
						<?php _e('Title'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
					</label>
				</p>
				<p>
					<?php _e('Show title'); ?> <br>
					<input name="<?php echo $this->get_field_name('show_title'); ?>" type="radio" value="true" <?php if(esc_attr($show_title)==0) echo "checked"; ?> />Yes &nbsp; 
					<input name="<?php echo $this->get_field_name('show_title'); ?>" type="radio" value="false"  <?php if(esc_attr($show_title)==2) echo "checked"; ?>/>No 
				</p>
				<p>
					<label for="<?php echo $this->get_field_id('category_slug'); ?>">
						<?php _e('Category slug  (optional)'); ?> <input class="widefat" id="<?php echo $this->get_field_id('category_slug'); ?>" name="<?php echo $this->get_field_name('category_slug'); ?>" type="text" value="<?php echo esc_attr($category_slug); ?>" />
					</label>
				</p>
				<p>
					<label for="<?php echo $this->get_field_id('category'); ?>">
						<?php _e('Choose category (optional)'); ?>
					</label>
					<select id="<?php echo $this->get_field_id('category'); ?>" class="widefat" name="<?php echo $this->get_field_name('category'); ?>">
						<?php echo implode('', $cat_options); ?>
					</select>
				</p>
				<p>
					<label for="<?php echo $this->get_field_id('dcw_exclude_slug'); ?>">
						<?php _e('Category slug\'s to exclude (optional)'); ?>
						<textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'dcw_exclude_slug' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'dcw_exclude_slug' ) ); ?>" ><?php echo esc_attr($dcw_exclude_slug); ?></textarea>
					</label>
					<br><?php _e('<small>Ex: slug1,slug2,slug3 (comma-separated list of category slugs)</small>'); ?>
				</p>
				<p>
					<label for="<?php echo $this->get_field_id('dcw_depth'); ?>">
						<?php _e('Levels in the hierarchy to show (optional)'); ?>
					</label>
					<select id="<?php echo $this->get_field_id('dcw_depth'); ?>" class="widefat" name="<?php echo $this->get_field_name('dcw_depth'); ?>">
						<?php echo implode('',$depth_options); ?>
					</select>
				</p>
				<p>
					<?php _e('Dispay as ...'); ?> <br>
					<input name="<?php echo $this->get_field_name('show_format'); ?>" type="radio" value="0" <?php if(esc_attr($show_format)==0) echo "checked"; ?> />List &nbsp; 
					<input name="<?php echo $this->get_field_name('show_format'); ?>" type="radio" value="2"  <?php if(esc_attr($show_format)==2) echo "checked"; ?>/>Drop Down 
				</p>
				<p>
					<?php _e('Show post counts'); ?> <br>
					<input name="<?php echo $this->get_field_name('showcount_value'); ?>" type="radio" value="1" <?php if(esc_attr($showcount_value)==1) echo "checked"; ?> />Yes &nbsp; 
					<input name="<?php echo $this->get_field_name('showcount_value'); ?>" type="radio" value="0"  <?php if(esc_attr($showcount_value)==0) echo "checked"; ?>/>No	
				</p>
				<p>
					<?php _e('Display Empty categories'); ?> <br>
					<input name="<?php echo $this->get_field_name('display_empty_categories'); ?>" type="radio" value="0" <?php if(esc_attr($display_empty_categories)==0) echo "checked"; ?> />Yes &nbsp; 
					<input name="<?php echo $this->get_field_name('display_empty_categories'); ?>" type="radio" value="1"  <?php if(esc_attr($display_empty_categories)==1) echo "checked"; ?>/>No 
				</p>
				<?php
		}

		public function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			$instance['title'] = $new_instance['title'];
			$instance['show_title'] = $new_instance['show_title'];
			$instance['category_slug'] = $new_instance['category_slug'];
			$instance['category'] = $new_instance['category'];
			$instance['dcw_exclude_slug'] = $new_instance['dcw_exclude_slug'];
			$instance['dcw_depth'] = $new_instance['dcw_depth'];
			$instance['display_empty_categories'] = $new_instance['display_empty_categories'];
			$instance['showcount_value'] = $new_instance['showcount_value'];
			$instance['show_format'] = $new_instance['show_format'];			

			return $instance;
		}

	}
}


if ( ! function_exists( 'register_bt_widgets' ) ) {
	function register_bt_widgets() {
		register_widget( 'BT_Gallery' );
		register_widget( 'BT_Text_Image' );
		register_widget( 'BT_Banner_Widget' );
		register_widget( 'BT_Icon_Widget' );
		register_widget( 'BT_Weather_Widget' );
		register_widget( 'BT_Time_Widget' );
		register_widget( 'BT_Recent_Posts' );
		register_widget( 'BT_Recent_Comments' );
		register_widget( 'BT_Instagram' );
		register_widget( 'BT_Twitter_Widget' );
		register_widget( 'BT_Date_Widget' );

		register_widget( 'BT_Custom_Categories_Widget' );
	}
}
add_action( 'widgets_init', 'register_bt_widgets' );

// portfolio
if ( ! function_exists( 'bt_create_portfolio' ) ) {
	function bt_create_portfolio() {
		register_post_type( 'portfolio',
			array(
				'labels' => array(
					'name'          => __( 'Portfolio', 'bt_plugin' ),
					'singular_name' => __( 'Portfolio Item', 'bt_plugin' )
				),
				'public'        => true,
				'has_archive'   => true,
				'menu_position' => 5,
				'supports'      => array( 'title', 'editor', 'thumbnail', 'author', 'comments', 'excerpt' ),
				'rewrite'       => array( 'with_front' => false, 'slug' => 'portfolio' )
			)
		);
		register_taxonomy( 'portfolio_category', 'portfolio', array( 'hierarchical' => true, 'label' => __( 'Portfolio Categories', 'bt_plugin' ) ) );
	}
}
add_action( 'init', 'bt_create_portfolio' );

if ( ! function_exists( 'bt_rewrite_flush' ) ) {
	function bt_rewrite_flush() {
		// First, we "add" the custom post type via the above written function.
		// Note: "add" is written with quotes, as CPTs don't get added to the DB,
		// They are only referenced in the post_type column with a post entry, 
		// when you add a post of this CPT.
		bt_create_portfolio();

		// ATTENTION: This is *only* done during plugin activation hook in this example!
		// You should *NEVER EVER* do this on every page load!!
		flush_rewrite_rules();
	}
}
register_activation_hook( __FILE__, 'bt_rewrite_flush' );


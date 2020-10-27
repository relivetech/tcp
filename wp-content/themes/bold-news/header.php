<!DOCTYPE html>
<html <?php language_attributes(); ?> <?php boldthemes_theme_data(); ?>>
<head>


<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-K64KBM7');</script>
<!-- End Google Tag Manager -->

<?php

	boldthemes_set_override();
	boldthemes_header_init();
	boldthemes_header_meta();

	$body_style = '';

	$page_background = boldthemes_get_option( 'page_background' );
	if ( $page_background ) {
		if ( is_numeric( $page_background ) ) {
			$page_background = wp_get_attachment_image_src( $page_background, 'full' );
			$page_background = $page_background[0];
		}
		$body_style = ' style="background-image:url(' . $page_background . ')"';
	}

	$header_extra_class = ''; 

	if ( boldthemes_get_option( 'boxed_menu' ) ) {
		$header_extra_class .= 'gutter ';
	}

	wp_head(); ?>
	
</head>

<body <?php body_class(); ?> data-autoplay="<?php echo intval( boldthemes_get_option( 'autoplay_interval' ) ); ?>" <?php echo wp_kses_post( $body_style ); ?>>
<?php 

echo boldthemes_preloader_html(); ?>

<?php get_template_part( 'views/ticker' ); ?>

<div class="btPageWrap" id="top">
	
    <header class="mainHeader btClear <?php echo esc_attr( $header_extra_class ); ?>">
        <div class="port">
		<?php echo do_shortcode('[pj-news-ticker]'); ?>
			<?php echo boldthemes_top_bar_html( 'top' ); ?>
			
			<div class="btLogoArea menuHolder btClear">
				<?php if ( has_nav_menu( 'primary' ) ) { ?>
					<span class="btVerticalMenuTrigger">&nbsp;<?php echo boldthemes_get_icon_html( 'fa_f0c9', '#', '', 'btIcoDefaultType' ); ?></span>
					<span class="btHorizontalMenuTrigger">&nbsp;<?php echo boldthemes_get_icon_html( 'fa_f0c9', '#', '', 'btIcoDefaultType' ); ?></span>
				<?php } ?>
				<div class="logo">
					<span>
						<?php boldthemes_logo( 'header' ); ?>
					</span>
				</div><!-- /logo -->
				
				<?php 
					if ( boldthemes_get_option( 'menu_type' ) == 'hLeftBelow' || boldthemes_get_option( 'menu_type' ) == 'hRightBelow' ) {
						echo boldthemes_top_bar_html( 'banner' );
						echo '</div><!-- /menuHolder -->';
						echo '<div class="btBelowLogoArea btClear">';
					}
				?>
				<div class="menuPort">
					<?php 
					if ( boldthemes_get_option( 'menu_type' ) == 'hLeftBelow' || boldthemes_get_option( 'menu_type' ) == 'hRightBelow' ) { ?>
					<div class="logoBelowInline">
						<span>
							<?php boldthemes_logo( 'header' ); ?>
							
						</span>
					</div><!-- /logo -->
					<?php } ?>
					<?php echo boldthemes_top_bar_html( 'menu' ); ?>
					
					<nav>
						<?php boldthemes_nav_menu(); ?>
						
					</nav>
				</div><!-- .menuPort -->
			</div><!-- /menuHolder / btBelowLogoArea -->
		</div><!-- /port -->
    </header><!-- /.mainHeader -->
	<?php 
		global $bt_global_exclude_ids; 
		$bt_global_exclude_ids = array(); 

	?>
	
	<div class="btContentWrap btClear">
		<?php boldthemes_header_headline( array( 'breadcrumbs' => true ) ); ?>
		<?php if ( BoldThemesFramework::$page_for_header_id != '' && ! is_search() ) { ?>
			<?php
				
				$content = get_post( BoldThemesFramework::$page_for_header_id );				
				$top_content = $content->post_content;				
				if ( $top_content != '' ) {
					$top_content = do_shortcode( $top_content );
				}
				echo '<div class = "btBlogHeaderContent">' . wp_kses_post( $top_content ) . '</div>';
			?>
		<?php } ?>
		<div class="btContentHolder">
			
			<div class="btContent">
			
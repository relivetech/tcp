<?php

$strings = 'tinyMCE.addI18n( "' . esc_js( _WP_Editors::$mce_locale ) . '.boldthemes_theme",
	{
		drop_cap: "' . esc_js( esc_html__( 'Drop Cap', 'bold-news' ) ) . '",
		highlight: "' . esc_js( esc_html__( 'Highlight', 'bold-news' ) ) . '"
	}
)';
<?php

	add_action('admin_init', 'plugin_settings');
	function plugin_settings(){
		register_setting( 'option_group', 'instagram');
	}
	
	add_action('admin_menu', 'add_plugin_page');
	function add_plugin_page(){
		add_menu_page( 'Instagram posts settings', 'Instagram posts', 'manage_options', 'instagram-options', 'options_page_output', plugin_dir_url( __FILE__ ) .'icon.png', 4 );
	}

?>
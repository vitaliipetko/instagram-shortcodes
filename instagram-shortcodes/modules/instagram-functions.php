<?php
	
	/**
	 * Functions module.
	 *
	 * @link       vitaliipetko.info
	 * @since      1.0.1
	 *
	 * @package    Instagram
	 * @subpackage Instagram/module
	 */

	/**
	 *
	 * @package    Instagram
	 * @subpackage Instagram/module
	 * @author     Vitalii Petko <vitaliypetko@gmail.com>
	 */

	add_action('admin_init', 'plugin_settings');
	function plugin_settings(){
		register_setting( 'option_group', 'instagram');
	}
	
	add_action('admin_menu', 'add_plugin_page');
	function add_plugin_page(){
		add_menu_page( 'Instagram posts settings', 'Instagram posts', 'manage_options', 'instagram-options', 'options_page_output', plugin_dir_url( __FILE__ ) .'icon.png', 4 );
	}

	// Регистрация виджета консоли
	add_action('wp_dashboard_setup', 'add_dashboard_widgets' );

	// Выводит контент
	function dashboard_widget_function( $post, $callback_args ) {
		echo "Всем привет! Это мой первый виджет!";
	}

	// Используется в хуке
	function add_dashboard_widgets() {
		wp_add_dashboard_widget('dashboard_widget', 'Метабокс в консоли', 'dashboard_widget_function');
	}

?>
<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              vitaliipetko.info
 * @since             1.0.0
 * @package           Instagram
 *
 * @wordpress-plugin
 * Plugin Name:       Instagram posts
 * Plugin URI:        vitaliipetko.info
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Vitalii Petko
 * Author URI:        vitaliipetko.info
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       instagram
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PLUGIN_NAME_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-instagram-activator.php
 */
function activate_instagram() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-instagram-activator.php';
	Instagram_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-instagram-deactivator.php
 */
function deactivate_instagram() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-instagram-deactivator.php';
	Instagram_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_instagram' );
register_deactivation_hook( __FILE__, 'deactivate_instagram' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-instagram.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_instagram() {
	$plugin = new Instagram();
	$plugin->run();

	//main function
	function get_instagram($user, $imgs = 4, $size = 0){
		if ($user) {
			$data = file_get_contents("https://www.instagram.com/".$user."/?__a=1");
			$data = json_decode($data, true);
			//main array
			$instagram = array(
				'user'	=> [],
				'posts'	=> []
			);		


			$args = array(
					'id'	=> $data['user']['id'],
					'name'	=> $data['user']['full_name'],
					'thumb'	=> $data['user']['profile_pic_url_hd'],
					'link' => 'https://www.instagram.com/'.$user.'/',
					'bio'	=> $data['user']['biography'],
					'followers'	=> $data['user']['followed_by']['count'],
				);

			$instagram['user'] = $args;

			$posts = $data['user']['media']['nodes'];

			foreach ($posts as $key => $value) {
				$caption = mb_strimwidth($value['caption'], 0, 100, "...");
				$args = array(
					'id'		=> $value['id'],
					'img'		=> $value['thumbnail_resources'][$size]['src'],
					'link'	=> 'https://www.instagram.com/p/'.$value['code'],
					'title'	=> $caption,
					'comments' => $value['comments']['count'],
					'likes' => $value['likes']['count'],
					'date' => date("m.d.Y",$value['date'])
				);

				array_push($instagram['posts'], $args);

				if ($key == ($imgs-1)) {
					break;
				}
			}

			return $instagram;
		}
		return false;
	}
}
run_instagram();

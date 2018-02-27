<?php

/**
 * Fired during plugin activation
 *
 * @link       vitaliipetko.info
 * @since      1.0.0
 *
 * @package    Instagram
 * @subpackage Instagram/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Instagram
 * @subpackage Instagram/includes
 * @author     Vitalii Petko <vitaliypetko@gmail.com>
 */
class Instagram_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		if (!get_option('instagram')) {
			$args = array(
				'user' => 'instagram',
				'imgs' => '4'
			);
			update_option('instagram', $args);
		}
	}

}

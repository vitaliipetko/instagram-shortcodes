<?php
	
	/**
	 * Data Base module.
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

	function instagram_create_table() {

		global $wpdb;
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

		$table_name = $wpdb->get_blog_prefix() . 'instagram';
		$charset_collate = "DEFAULT CHARACTER SET {$wpdb->charset} COLLATE {$wpdb->collate}";

		$sql = "CREATE TABLE {$table_name} (
		id  bigint(20) unsigned NOT NULL auto_increment,
		user_name varchar(255) NOT NULL default '',
		imgs varchar(20) NOT NULL default '',
		position varchar(255) NOT NULL default '',
		thumb varchar(255) NOT NULL default '',
		alert varchar(20) NOT NULL default '',
		PRIMARY KEY  (id),
		KEY alert (alert)
		)
		{$charset_collate};";

		dbDelta($sql);
	}

	function instagram_delete_table() {

		global $wpdb;
		$table_name = $wpdb->get_blog_prefix() . 'instagram';
		$wpdb->query("DROP TABLE $table_name");
	}

	function shortcodes() {

		global $wpdb;
		$table_name = $wpdb->get_blog_prefix() . 'instagram';
		$results = $wpdb->get_results("SELECT ID FROM $table_name", ARRAY_A);

		return $results;
	}

	function shortcode($id) {

		global $wpdb;
		$table_name = $wpdb->get_blog_prefix() . 'instagram';
		$results = $wpdb->get_results("SELECT ID, user_name, imgs, position, thumb FROM $table_name WHERE ID=$id", ARRAY_A);

		return $results[0];
	}

	function instagram_update($id,$user_name,$imgs,$position,$thumb){

		global $wpdb;
		$table_name = $wpdb->get_blog_prefix() . 'instagram';
		$wpdb->update( $table_name,
			array('user_name' => $user_name, 'imgs' => $imgs, 'position' => $position, 'thumb' => $thumb),
			array('ID' => $id)
		);
	}

	function instagram_new($user_name,$imgs,$position,$thumb){

		global $wpdb;
		$table_name = $wpdb->get_blog_prefix() . 'instagram';
		$wpdb->insert( $table_name,
			array('ID' => NULL,'user_name' => $user_name, 'imgs' => $imgs, 'position' => $position, 'thumb' => $thumb)
		);
		return $wpdb->show_errors;
	}

	function instagram_delete($id){

		global $wpdb;
		$table_name = $wpdb->get_blog_prefix() . 'instagram';
		$wpdb->delete( $table_name, array('ID' => $id));
	}

?>
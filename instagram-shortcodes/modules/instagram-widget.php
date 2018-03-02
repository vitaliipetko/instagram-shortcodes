<?php

	/**
	 * Widget module.
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

	class Instagram_Widget extends WP_Widget {

		function __construct() {
			parent::__construct(
				'',
				'Instagram Shortcode',
				array( 'description' => 'Вывод последних постов')
			);

			if ( is_active_widget( false, false, $this->id_base ) || is_customize_preview() ) {
				add_action('wp_head', array( $this, 'add_my_widget_style' ) );
			}
		}

		function widget( $args, $instance ) {
			$shortcode = $instance['shortcode'] ;
			do_shortcode("[instagram id='".esc_attr( $shortcode )."']");
		}

		function form( $instance ) { ?>
			<p>
				<select id="<?php echo $this->get_field_id( 'shortcode' ); ?>" name="<?php echo $this->get_field_name( 'shortcode' ); ?>">
					<?php
					$shortcodes = shortcodes();
					foreach ($shortcodes as $result) { ?>
						<?php $user = shortcode($result['ID']); ?>
						<option value="<?php echo $result['ID']; ?>" <?php echo $instance['shortcode'] == $result['ID'] ? 'selected' : ''; ?>><?php echo $user['user_name']; ?></option>
					<?php } ?>
				</select>
			</p>
		<?php	}

		function update( $new_instance, $old_instance ) {
			$instance = array();
			$instance['shortcode'] = ( ! empty( $new_instance['shortcode'] ) ) ? strip_tags( $new_instance['shortcode'] ) : '';

			return $instance;
		}

	} 

	function register_foo_widget() {
		register_widget( 'Instagram_Widget' );
	}
	if ($shortcodes = shortcodes()) {
		add_action( 'widgets_init', 'register_foo_widget' );
	}

<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       vitaliipetko.info
 * @since      1.0.0
 *
 * @package    Instagram
 * @subpackage Instagram/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Instagram
 * @subpackage Instagram/admin
 * @author     Vitalii Petko <vitaliypetko@gmail.com>
 */
class Instagram_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Instagram_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Instagram_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/instagram-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Instagram_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Instagram_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/instagram-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function admin_backend() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Instagram_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Instagram_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

			add_action('admin_menu', 'add_plugin_page');
			function add_plugin_page(){
				add_menu_page( 'Instagram posts settings', 'Instagram posts', 'manage_options', 'instagram-options', 'options_page_output', plugin_dir_url( __FILE__ ).'/icon.png', 4 );
			}

			function options_page_output(){
				?>
				<div class="container">
		      <div class="instagram">
		        <div class="instagram__logo"></div>
		        <form action="options.php" method="POST"><table class="form-table">
		        	<?php
		        		settings_fields( 'option_group' );     // скрытые защитные поля
		        		do_settings_sections( 'instagram_options' ); // секции с настройками (опциями). У нас она всего одна 'section_id'
		        	?>
		        	<label for="submit" class="submit">
		        	<?php
		        		submit_button(' ','','submit', false);
		        		$data = get_instagram(get_option('instagram')['user'], get_option('instagram')['imgs'], 3);
		        	?>
		        	</label>
		        </form>
		        <?php if ($data) { ?>
		        <div class="instagram__box">
		        	<div class="instagram__thumb"><a href="<?php echo $data['user']['link']; ?>" target="_blank"><img src="<?php echo $data['user']['thumb']; ?>" alt="">
		        		<p class="name">@<?php echo $data['user']['name']; ?></p>
		        	  <p>Followers: <span><?php echo $data['user']['followers']; ?></span></p></a>
		        	</div>
		        	<div class="instagram__plugin">
		        		<?php foreach ($data['posts'] as $post) { ?>
		        			<a href="<?php echo $post['link']; ?>" target="_blank" title="<?php echo $post['title']; ?>"><div class="img">
		        					<img src="<?php echo $post['img']; ?>" alt="">
		        					<span class="instagram__plugin--likes"><?php echo $post['likes']; ?></span><span class="instagram__plugin--comments"><?php echo $post['comments']; ?></span>
		        					        	</div></a>
		        		<?php } ?>
		        	</div>
		        </div>
		        <?php } ?>
		      </div>
		    </div>
				<?php
			}
			
			add_action('admin_init', 'plugin_settings');
			function plugin_settings(){
				register_setting( 'option_group', 'instagram', 'sanitize_callback' );
				add_settings_section( 'section_id', '', '', 'instagram_options' ); 
				add_settings_field('user', '<i class="user"></i>', 'user_field', 'instagram_options', 'section_id' );
				add_settings_field('imgs', 'Колличество постов', 'user_imgs', 'instagram_options', 'section_id' );
			}

			function user_field(){
				$val = get_option('instagram');
				$val = $val ? $val['user'] : null;
				?>
				<input type="text" id="instagram_user" name="instagram[user]" value="<?php echo esc_attr( $val ) ?>" placeholder="User name" />
				<?php
			}

			function user_imgs(){
				$val = get_option('instagram');
				$val = $val ? $val['imgs'] : '1';
				?>
				<input type="number" id="instagram_img" min="1" max="12" name="instagram[imgs]" value="<?php echo $val ?>" />
				<?php
			}

			function sanitize_callback( $options ){ 
				// очищаем
				foreach( $options as $name => & $val ){
					if( $name == 'user' )
						$val = strip_tags( $val );

					if( $name == 'imgs' )
						$val = intval( $val );
				}

				return $options;
			}

	}

}

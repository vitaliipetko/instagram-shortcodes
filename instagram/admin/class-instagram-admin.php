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
		wp_enqueue_script( 'slick' , plugin_dir_url( __FILE__ ) . 'js/slick.min.js', array( 'jquery' ), false );

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
			add_action('admin_init', 'plugin_settings');
			function plugin_settings(){
				register_setting( 'option_group', 'instagram');
			}

			function options_page_output(){
				?>
				<div class="container">
		      <div class="instagram">
		        <div class="instagram__logo"></div>
		        <form id="instagram-form" action="options.php" method="POST">
		        	<?php
		        		settings_fields( 'option_group' );
		        		$data = get_instagram(get_option('instagram')['user'], get_option('instagram')['imgs'], 3);
		        	?>
		        	<div class="text-center"><i class="user"></i>
		        	  <input type="text" id="instagram_user" name="instagram[user]" value="<?php echo get_option('instagram')['user']; ?>">
		        	</div>
		        	<div class="instagram__settings">
		        	  <p class="instagram__title">Настройки</p>
		        	  <div class="row">
		        	    <label for="instagram_img">
		        	    	<p>Колличество постов</p>
		        	    	<select name="instagram[imgs]" id="instagram_img">
		        	    		<?php for ($i=1; $i < 13 ; $i++) { ?>
		        	    			<option value="<?php echo $i; ?>" <?php echo $selected = get_option('instagram')['imgs'] == $i ? 'selected' : '' ?>><?php echo $i; ?></option>
		        	    		<?php } ?>
		        	    	</select>
		        	    </label>
		        	    <label for="instagram_position">
		        	    	<p>Способ отображения</p>
		        	      <select id="instagram_position" name="instagram[settings][position]">
		        	        <option value="mini" <?php echo $selected = get_option('instagram')['settings']['position'] == 'mini' ? 'selected' : '' ?>>Маленькие фото</option>
		        	        <option value="big" <?php echo $selected = get_option('instagram')['settings']['position'] == 'big' ? 'selected' : '' ?>>Большие фото</option>
		        	        <!-- <option value="slider" <?php echo $selected = get_option('instagram')['settings']['position'] == 'slider' ? 'selected' : '' ?>>Слайдер</option> -->
		        	      </select>
		        	    </label>
		        	    <label for="instagram_thumb">
		        	    	<p>Информация о акаунте</p>
		        	    	<input type="hidden" name="instagram[settings][thumb]" value="0">
		        	    	<input id="instagram_thumb" type="checkbox" name="instagram[settings][thumb]" value="1" <?php echo $selected = get_option('instagram')['settings']['thumb'] == '1' ? 'checked' : '' ?>>
		        	    	<span>Отображать</span>
		        	    </label>
		        	  </div>
		        	  <label class="submit" for="submit">
		        	    <button class="button button-primary" type="submit" name="submit" id="submit">Сохранить</button>
		        	  </label>
		        	</div>
		        </form>
		        <div class="instagram__ajax">
		        	<?php if ($data) { ?>
		        	<div class="instagram__box">
		        		<div class="instagram__thumb" <?php echo $selected = get_option('instagram')['settings']['thumb'] != '1' ? 'style="display:none;"' : ''; ?>>
		        			<a href="<?php echo $data['user']['link']; ?>" target="_blank">
		        				<img src="<?php echo $data['user']['thumb']; ?>" alt="">
				        		<p class="name">@<?php echo $data['user']['name']; ?></p>
				        	  <p>Followers: <span><?php echo $data['user']['followers']; ?></span></p>
				        	</a>
		        		</div>
		        		<div class="instagram__plugin <?php echo get_option('instagram')['settings']['position']; ?>">
		        			<div class="row">
			        			<?php foreach ($data['posts'] as $post) { ?>
			        				<a href="<?php echo $post['link']; ?>" target="_blank" title="<?php echo $post['title']; ?>">
			        					<div class="img">
			        						<img src="<?php echo $post['img']; ?>" alt="">
			        						<span class="instagram__plugin--likes"><?php echo $post['likes']; ?></span>
			        						<span class="instagram__plugin--comments"><?php echo $post['comments']; ?></span>
							        	</div>
							        </a>
			        			<?php } ?>
			        		</div>
		        		</div>
		        	</div>
		        	<?php } ?>
		        </div>
		      </div>
		    </div>
				<?php
			}

			add_action('wp_ajax_instagram', 'instagram_callback');
			function instagram_callback() {
				$data = get_instagram($_POST['user'], $_POST['imgs'], 3); ?>
				<div class="instagram__ajax">
					<?php if ($data && $data['user']['status'] != 'true') { ?>
					<div class="instagram__box">
						<div class="instagram__thumb" <?php echo $selected = $_POST['thumb'] != '1' ? 'style="display:none;"' : ''; ?>>
							<a href="<?php echo $data['user']['link']; ?>" target="_blank">
								<img src="<?php echo $data['user']['thumb']; ?>" alt="">
		        		<p class="name">@<?php echo $data['user']['name']; ?></p>
		        	  <p>Followers: <span><?php echo $data['user']['followers']; ?></span></p>
		        	</a>
						</div>
						<div class="instagram__plugin <?php echo $_POST['position']; ?>">
							<div class="row">
								<?php foreach ($data['posts'] as $post) { ?>
									<a href="<?php echo $post['link']; ?>" target="_blank" title="<?php echo $post['title']; ?>">
										<div class="img">
											<img src="<?php echo $post['img']; ?>" alt="">
											<span class="instagram__plugin--likes"><?php echo $post['likes']; ?></span>
											<span class="instagram__plugin--comments"><?php echo $post['comments']; ?></span>
										</div>
									</a>
								<?php } ?>
							</div>
						</div>
					</div>
					<?php } elseif ($data['user']['status'] == 'true') { ?>
						<div class="instagram__box disabled">
							<p class="error">У пользователя приватная страница.</p>
						</div>
					<?php } else {?>
						<div class="instagram__box disabled">
							<p class="error">Пользователь не найден.</p>
						</div>
					<?php } ?>
				</div>
				<?php wp_die();
			}

	}

}

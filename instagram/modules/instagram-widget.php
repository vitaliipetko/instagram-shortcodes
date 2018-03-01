<?php

	/**
	 * Добавление нового виджета Foo_Widget.
	 */
	class Instagram_Widget extends WP_Widget {

		// Регистрация виджета используя основной класс
		function __construct() {
			// вызов конструктора выглядит так:
			// __construct( $id_base, $name, $widget_options = array(), $control_options = array() )
			parent::__construct(
				'', // ID виджета, если не указать (оставить ''), то ID будет равен названию класса в нижнем регистре: foo_widget
				'Instagram',
				array( 'description' => 'Вывод последних постов', /*'classname' => 'my_widget',*/ )
			);

			// скрипты/стили виджета, только если он активен
			if ( is_active_widget( false, false, $this->id_base ) || is_customize_preview() ) {
				// add_action('wp_enqueue_scripts', array( $this, 'add_my_widget_scripts' ));
				add_action('wp_head', array( $this, 'add_my_widget_style' ) );
			}
		}

		/**
		 * Вывод виджета во Фронт-энде
		 *
		 * @param array $args     аргументы виджета.
		 * @param array $instance сохраненные данные из настроек
		 */
		function widget( $args, $instance ) {
			$shortcode = $instance['shortcode'] ;

			// echo $args['before_widget'];
			// if ( ! empty( $title ) ) {
			// 	echo $args['before_title'] . $title . $args['after_title'];
			// }
			// echo __( 'Hello, World!', 'text_domain' );
			// echo $args['after_widget'];
			do_shortcode("[instagram id='".esc_attr( $shortcode )."']");
		}

		/**
		 * Админ-часть виджета
		 *
		 * @param array $instance сохраненные данные из настроек
		 */
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

		/**
		 * Сохранение настроек виджета. Здесь данные должны быть очищены и возвращены для сохранения их в базу данных.
		 *
		 * @see WP_Widget::update()
		 *
		 * @param array $new_instance новые настройки
		 * @param array $old_instance предыдущие настройки
		 *
		 * @return array данные которые будут сохранены
		 */
		function update( $new_instance, $old_instance ) {
			$instance = array();
			$instance['shortcode'] = ( ! empty( $new_instance['shortcode'] ) ) ? strip_tags( $new_instance['shortcode'] ) : '';

			return $instance;
		}

		// скрипт виджета
		function add_my_widget_scripts() {
			// фильтр чтобы можно было отключить скрипты
			if( ! apply_filters( 'show_my_widget_script', true, $this->id_base ) )
				return;

			$theme_url = get_stylesheet_directory_uri();

			wp_enqueue_script('my_widget_script', $theme_url .'/my_widget_script.js' );
		}

		// стили виджета
		function add_my_widget_style() {
			// фильтр чтобы можно было отключить стили
			if( ! apply_filters( 'show_my_widget_style', true, $this->id_base ) )
				return;
			?>
			<style type="text/css">
				.my_widget a{ display:inline; }
			</style>
			<?php
		}

	} 
	// конец класса Foo_Widget

	// регистрация Foo_Widget в WordPress
	function register_foo_widget() {
		register_widget( 'Instagram_Widget' );
	}
	add_action( 'widgets_init', 'register_foo_widget' );

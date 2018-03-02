<?php
	
	/**
	 * Shortcode module.
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

	function instagram_shortcode_func( $atts ) {
			$user = shortcode($atts['id']);
			if ($user) {
				$data = get_instagram($user['user_name'], $user['imgs'], 3);
			}
		?>	
		<div class="instagram">
      <div class="container">
      	<?php if ($data) { ?>
	      	<div class="instagram__box">
	      		<div class="instagram__thumb" <?php echo $selected = $user['thumb'] != '1' ? 'style="display:none;"' : ''; ?>>
	      			<a href="<?php echo $data['user']['link']; ?>" target="_blank">
	      				<img src="<?php echo $data['user']['thumb']; ?>" alt="">
		        		<p class="name">@<?php echo $data['user']['name']; ?></p>
		        	  <p>Followers: <span><?php echo $data['user']['followers']; ?></span></p>
		        	</a>
	      		</div>
	      		<div class="instagram__plugin <?php echo $user['position']; ?>">
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
	<?php }
	add_shortcode( 'instagram', 'instagram_shortcode_func' );

?>
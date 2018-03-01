<?php

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

?>
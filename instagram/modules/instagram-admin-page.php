<?php
	
		function options_page_output(){ ?>
			<div class="container">
				<div class="text-center">
					<?php if ($_GET['status'] == 'true') { ?>
					<p class="true">Данныйе обновлены</p>
					<?php } elseif ($_GET['status'] == 'false') { ?>
					<p class="false">Произошла ошибка</p>
					<?php } ?>
				</div>
	      <div class="instagram">

	        <a href="admin.php?page=instagram-options"><div class="instagram__logo"></div></a>
					<?php if ($_GET['fun'] == 'add') {
						instagram_add();
					} elseif (!$_GET['fun']) { 
		        instagram_mainpage();
					} elseif ($_GET['fun'] == 'update') {
						instagram_update($_GET['id'],$_GET['user_name'],$_GET['imgs'],$_GET['position'],$_GET['thumb']);
					} elseif ($_GET['fun'] == 'edit') {
						instagram_edit();
					} elseif ($_GET['fun'] == 'delete') {
						instagram_delete($_GET['id']);
					} elseif ($_GET['fun'] == 'new') {
						echo instagram_new($_GET['user_name'],$_GET['imgs'],$_GET['position'],$_GET['thumb']);
					}?>
	      </div>
	    </div>
		<?php }

		function instagram_mainpage() { ?>
			<?php if ($shortcodes = shortcodes()) { ?>
	      <div class="instagram__shortcodes">
	      	<table>
	        	<tbody>
	        		<thead>
	        			<tr>
	        				<td>Имя пользователя</td>
	        				<td>Шорткод</td>
	        				<td></td>
	        				<td><a href="admin.php?page=instagram-options&fun=add">+</a></td>
	        			</tr>
	        		</thead>
	        		<?php 
	        			$shortcodes = shortcodes();
	        			foreach ($shortcodes as $result) {
	        				$code = shortcode($result['ID']);
	        				echo "<tr><td>$code[user_name]</td><td class='code'>[instagram id=$code[ID]]</td><td><a href='admin.php?page=instagram-options&fun=edit&id=$code[ID]'>Редактировать</a><td><a href='admin.php?page=instagram-options&fun=delete&id=$code[ID]' class='delete'>Удалить</a></td></tr>";
	        			}
	        		?>
	        	</tbody>
	      	</table>
	      </div>
	    <?php } else { ?>
	    <div class="first">
	    	<p>Добавить шорткод</p>
	    	<a href="admin.php?page=instagram-options&fun=add"></a>
	    </div>
	    <?php } ?>
		<?php }

		function instagram_add() { ?>
			<form id="instagram-form" class="instagram-add" action="admin.php" method="GET">			
				<input type="hidden" name="page" value="instagram-options">
				<input type="hidden" name="fun" value="new">
				<div class="text-center"><i class="user"></i>
				  <input type="text" id="instagram_user" name="user_name" placeholder="User">
				</div>
				<div class="instagram__settings">
				  <p class="instagram__title">Настройки</p>
				  <div class="row">
				    <label for="instagram_img">
				    	<p>Колличество постов</p>
				    	<select name="imgs" id="instagram_img">
				    		<?php for ($i=1; $i < 13 ; $i++) { ?>
				    			<option value="<?php echo $i; ?>" <?php echo $i==6 ? 'selected' : ''; ?>><?php echo $i; ?></option>
				    		<?php } ?>
				    	</select>
				    </label>
				    <label for="instagram_position">
				    	<p>Способ отображения</p>
				      <select id="instagram_position" name="position">
				        <option value="mini">Маленькие фото</option>
				        <option value="big">Большие фото</option>
				      </select>
				    </label>
				    <label for="instagram_thumb">
				    	<p>Информация о акаунте</p>
				    	<input type="hidden" name="thumb" value="0">
				    	<input id="instagram_thumb" type="checkbox" name="thumb" value="1" checked>
				    	<span>Отображать</span>
				    </label>
				  </div>
				  <label class="submit" for="submit">
				    <button class="button button-primary" type="submit" id="submit" disabled>Добавить</button>
				  </label>
				</div>
			</form>
      <div class="instagram__ajax">
      </div>
		<?php }

		function instagram_edit() { ?>
			<form id="instagram-form" class="instagram-update" action="admin.php" method="GET">
				<?php
					$id = $_GET['id'];
					$user = shortcode($id);
					$data = get_instagram($user['user_name'], $user['imgs'], 3);
				?>				
				<input type="hidden" name="page" value="instagram-options">
				<input type="hidden" name="fun" value="update">
				<input type="hidden" name="id" value="<?php echo $id; ?>">
				<div class="text-center"><i class="user"></i>
				  <input type="text" id="instagram_user" name="user_name" value="<?php echo $user['user_name']; ?>" placeholder="User">
				</div>
				<div class="instagram__settings">
				  <p class="instagram__title">Настройки</p>
				  <div class="row">
				    <label for="instagram_img">
				    	<p>Колличество постов</p>
				    	<select name="imgs" id="instagram_img">
				    		<?php for ($i=1; $i < 13 ; $i++) { ?>
				    			<option value="<?php echo $i; ?>" <?php echo $selected = $user['imgs'] == $i ? 'selected' : '' ?>><?php echo $i; ?></option>
				    		<?php } ?>
				    	</select>
				    </label>
				    <label for="instagram_position">
				    	<p>Способ отображения</p>
				      <select id="instagram_position" name="position">
				        <option value="mini" <?php echo $selected = $user['position'] == 'mini' ? 'selected' : '' ?>>Маленькие фото</option>
				        <option value="big" <?php echo $selected = $user['position'] == 'big' ? 'selected' : '' ?>>Большие фото</option>
				      </select>
				    </label>
				    <label for="instagram_thumb">
				    	<p>Информация о акаунте</p>
				    	<input type="hidden" name="thumb" value="0">
				    	<input id="instagram_thumb" type="checkbox" name="thumb" value="1" <?php echo $selected = $user['thumb'] == '1' ? 'checked' : '' ?>>
				    	<span>Отображать</span>
				    </label>
				  </div>
				  <label class="submit" for="submit">
				    <button class="button button-primary" type="submit" id="submit">Сохранить</button>
				  </label>
				</div>
			</form>
      <div class="instagram__ajax">
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
		<?php }
?>
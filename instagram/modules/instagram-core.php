<?php
	
	//main function
	function isJSON($string) {
	    return ((is_string($string) && (is_object(json_decode($string)) || is_array(json_decode($string))))) ? true : false;
	}

	function get_instagram($user, $imgs = 4, $size = 0){
		$data = file_get_contents("https://www.instagram.com/".$user."/?__a=1");
		if(isJSON($data)) {
			$data = json_decode($data, true);
			//main array
			$instagram = array(
				'user'	=> [],
				'posts'	=> []
			);

			$args = array(
					'status' => $data['user']['is_private'],
					'id'	=> $data['user']['id'],
					'name'	=> $data['user']['full_name'] != '' ? $data['user']['full_name'] : $user,
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
		} else {
			return false;
		}
	}
	
?>
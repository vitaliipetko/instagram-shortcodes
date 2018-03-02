(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
	 $(document).ready(function() {

	 		$('#instagram-form').submit(function(event) {
	 			if ($('#submit').prop('disabled')) {
	 				event.preventdefault()
	 			}
	 		});

	 		function update_item() {
	 			var data = $('.instagram-update').serialize();
	 			$.ajax({
	 				url: 'admin.php',
	 				type: 'GET',
	 				data: data,
	 			})
	 			.done(function() {
	 				console.log("success");
	 			})
	 			.fail(function() {
	 				console.log("error");
	 			})
	 			.always(function() {
	 				console.log("complete");
					window.location.href = "admin.php?page=instagram-options&status=true";
	 			});	 			
	 		}

	 		function delete_item(data) {
	 			$.ajax({
	 				url: 'admin.php',
	 				type: 'GET',
	 				data: data,
	 			})
	 			.done(function() {
	 				console.log("success");
	 			})
	 			.fail(function() {
	 				console.log("error");
	 			})
	 			.always(function() {
	 				console.log(data);
					window.location.href = "admin.php?page=instagram-options&status=true";
	 			});
	 		}

	 		function add_item() {
	 			var data = $('.instagram-add').serialize();
	 			$.ajax({
	 				url: 'admin.php',
	 				type: 'GET',
	 				data: data,
	 			})
	 			.done(function() {
	 				console.log("success");
	 			})
	 			.fail(function() {
	 				console.log("error");
	 			})
	 			.always(function() {
	 				console.log(data);
					window.location.href = "admin.php?page=instagram-options&status=true";
	 			});	 			
	 		}

	 		function loading() {
	 			$('#submit').prop('disabled', true);
	 			$('.instagram__ajax').css('opacity', '0.3');
	 			var thumb = '';
	 			if ($('#instagram_thumb').prop('checked')) {
	 				thumb = '1';
	 			} else {
	 				thumb = '0';
	 			};
	 			$(".instagram__ajax").load(
	 			  "/wp-admin/admin-ajax.php .instagram__box",
	 			  {
	 			  	action: 'instagram',
	 			  	user: $('#instagram_user').val(),
	 			  	imgs: $('#instagram_img').val(),
	 			  	position: $('#instagram_position').val(),
	 			  	thumb: thumb,
	 			  },
		 			function(){
			 			$('.instagram__ajax').css('opacity', '1');
			 			if ($('.instagram__box').hasClass('disabled')){
			 				$('#submit').prop('disabled', true);
			 			} else {
			 				$('#submit').prop('disabled', false);
			 			};
			 			$('.slider .row').slick({
				 			infinite: true,
				 			slidesToShow: 1,
				 			slidesToScroll: 1,
				 			centerMode: true,
				 			dots: false,
				 			arrows: false
			 			});
		 			}
	 			);
	 		};

	 		$('.instagram-update').submit(function(event) {
	 			event.preventDefault();
	 			update_item();
	 		});

	 		$('.instagram-add').submit(function(event) {
	 			event.preventDefault();
	 			add_item();
	 		});

	 		$('.delete').click(function(event) {
	 			event.preventDefault();
	 			var data = $(this).attr('href');

	 			data = data.replace('admin.php?', '');
	 			delete_item(data);
	 		});

	 		$('#search').click(function(event) {
	 			loading();
	 		});

	 		$('#instagram_user').change(function(event) {
	 			loading();
	 		});

	 		$('#instagram_img').change(function(event) {
	 			loading();
	 		});

	 		$('#instagram_position').change(function(event) {
 				loading();
	 		});

	 		$('#instagram_thumb').change(function(event) {
	 			if ($('#instagram_thumb').prop('checked')) {
	 				$('.instagram__thumb').slideDown(400);
	 			} else {
	 				$('.instagram__thumb').slideUp(400);
	 			};
	 		});
	 });
})( jQuery );


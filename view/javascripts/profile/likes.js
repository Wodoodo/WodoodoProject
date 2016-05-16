$(document).ready(function(){

	$('.like_button').click(function(){
		var parentEl = $(this).parent(); 
		var like = parentEl.attr('like');
		var postId = parentEl.attr('postid');
		var countLike = parentEl.children('.like_number').text();
		var parentBlock = parentEl.parent();
		var likesBlock = parentBlock.children('.likers_block');
		var photoBlock = likesBlock.children('.likers_photo_block');
		if(like == "false"){
			parentEl.attr('class', 'btn_like_press');
			parentEl.children('.like_number').text(++countLike);
			parentEl.attr('like', true);
			$.ajax({ 
				type: "POST",
				url: "/profile/user/addLike", 
				data: ({postId : postId}), 
				success: function() 
				{ 
					
				}
			});
			$.ajax({ 
				type: "POST",
				url: "/profile/user/getLikers", 
				data: ({postId : postId}), 
				success: function(response) 
				{ 
					var child = photoBlock.children();
					for (var i = 0; i < child.length; i++){
						child.remove();
					}
					response = JSON.parse(response);
					var likers = '', numRows;
					if(response.num_rows > 5)
						numRows = 5;
					else
						numRows = response.num_rows;
					for(var i = 0; i < numRows; i++){
						likers += '<a href="/profile/user?id='+ response.rows[i]['user_id'] +'"><img src="/view/images/users/'+ response.rows[i]['user_photo'] +'" title="'+ response.rows[i]['user_firstname'] + ' ' + response.rows[i]['user_lastname'] +'"></a> ';
					}
					photoBlock.append(likers);
				}
			});

		}
		else{
			parentEl.attr('class', 'btn_like');
			parentEl.children('.like_number').text(--countLike);
			parentEl.attr('like', false);
			$.ajax({ 
				type: "POST",
				url: "/profile/user/deleteLike", 
				data: ({postId : postId}), 
				success: function() 
				{ 
					
				}
			});
			$.ajax({ 
				type: "POST",
				url: "/profile/user/getLikers", 
				data: ({postId : postId}), 
				success: function(response) 
				{ 
					var child = photoBlock.children();
					for (var i = 0; i < child.length; i++){
						child.remove();
					}
					response = JSON.parse(response);
					var likers = '', numRows;
					if(response.num_rows > 5)
						numRows = 5;
					else
						numRows = response.num_rows;
					for(var i = 0; i < numRows; i++){
						likers += '<a href="/profile/user?id='+ response.rows[i]['user_id'] +'"><img src="/view/images/users/'+ response.rows[i]['user_photo'] +'" title="'+ response.rows[i]['user_firstname'] + ' ' + response.rows[i]['user_lastname'] +'"></a> ';
					}
					photoBlock.append(likers);
				}
			});

		}
	})

	var isOpen = false;
	$('.all_likers_btn').click(function(){
		var parentEl = $(this).parent(); 
		var likesBlock = parentEl.children();
		var postId = likesBlock.attr('postid');
		var photoBlock = $('.photo_users_block');
		if(!isOpen){
			isOpen = true;
			$('.all_likers_block').css({
				display: 'block'
			})
			$.ajax({ 
				type: "POST",
				url: "/profile/user/getLikers", 
				data: ({postId : postId}), 
				success: function(response) 
				{ 
					var child = photoBlock.children();
					for (var i = 0; i < child.length; i++){
						child.remove();
					}
					response = JSON.parse(response);
					var likers = '';
					for(var i = 0; i < response.num_rows; i++){
						likers += '<a target="_blank" href="/profile/user?id='+ response.rows[i]['user_id'] +'"><img src="/view/images/users/'+ response.rows[i]['user_photo'] +'" title="'+ response.rows[i]['user_firstname'] + ' ' + response.rows[i]['user_lastname'] +'"><p>'+ response.rows[i]['user_firstname'] + '<br>' + response.rows[i]['user_lastname'] +'</p></a> ';
					}
					photoBlock.append(likers);
				}
			});
		}
	})

	$('#close_block').click(function(){
		isOpen = false;
		$('.all_likers_block').css({
			display: 'none'
		})
	})

	/*$('.all_likers_block').click(function(){
		isOpen = false;
		$('.all_likers_block').css({
			display: 'none'
		})
	})*/
	
});
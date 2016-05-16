$(document).ready(function(){

	$('.like_button').click(function(){
		var parentEl = $(this).parent(); 
		var like = parentEl.attr('like');
		var postId = parentEl.attr('postid');
		var countLike = parentEl.children('.like_number').text();
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
		}
	})
	
	$('.like_number').hover(function(){
		var countLike = $(this).text();
		if(countLike != 0)
		{
			var parentEl = $(this).parent(); 
			var postId = parentEl.attr('postid');
			var parentBlock = parentEl.parent();
			var likesBlock = parentBlock.children('.likers_block');
			var photoBlock = likesBlock.children('.likers_photo_block');
			$.ajax({ 
				type: "POST",
				url: "/profile/user/getLikers", 
				data: ({postId : postId}), 
				success: function(response) 
				{ 
					response = JSON.parse(response);
					var likers = '', numRows;
					if(response.num_rows > 5)
						numRows = 5;
					else
						numRows = response.num_rows;
					for(var i = 0; i < numRows; i++){
						likers += '<a href="/profile/user?id='+ response.rows[i]['user_id'] +'"><img src="/view/images/users/'+ response.rows[i]['user_photo'] +'"></a>';
					}
					photoBlock.append(likers);
				}
			});
			likesBlock.css({
				display: 'block'
			});
			//clearTimeout(timeoutId);
			var child = photoBlock.children();
			for (var i = 0; i < child.length; i++){
				child.remove();
			}
		}
	}).mouseleave(function(){
		var parentEl = $(this).parent();
		var parentBlock = parentEl.parent();
		var likesBlock = parentBlock.children('.likers_block');
		likesBlock.css({
			display: 'none'
		});
	})

	$('.likers_block').hover(function(){
		$(this).css({
			display: 'block'
		});
	}).mouseleave(function(){
		$(this).css({
			display: 'none'
		});
	})
});
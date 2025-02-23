$(document).ready(function(){
	 $("#message_list").mCustomScrollbar({
		 updateOnContentResize: true,
		 autoDraggerLength: true
	 });
	 $(document).on("click",".connections_container_left", function(){
                 $current = $(this);
		 if($current.hasClass('active')) {
			e.preventDefault();
			return false;
		 }
		 $('.connections_container_left').removeClass('active');
		 $('.connections_container_left').css('cursor', 'pointer');
		 var id_arr = $(this).attr('id');
		 var id = id_arr.split('_')[1];
		 var page = $('.page_info').val();
		 if(page == 'archived') {
			 var archive = 1;
		 }
		 else {
			 var archive = 0;
		 }
		 var params = { 'method' : 'get_user_messages','id' : id, 'archive' : archive};

		 $(this).addClass('active');
		 $("#message_list").html("<div style='width:70px;margin:auto;top:35%;'><img src='"+$.app.urls('base_url')+"template/images/ajax-loader.gif'></div>");
		 $('input[name="chat_user_id"]').val(id);
		 $(this).css('cursor', 'default');

		 $.app.ajax('POST', $.app.urls('base_url')+'index.php?teacher/ajax', params, function(response){
			if(response.status == 'success') {
				$("#message_list").html(response.html);
				$("#message_list").scrollTop( $("#message_list").prop("scrollHeight"));
				$("#message_list").mCustomScrollbar({
					 scrollButtons:{
						enable:true
					 },
					 updateOnContentResize: true,
					 autoDraggerLength: true
				});
//				$('.btn-container').addClass('hide');
			}
			else if(response.status == 'failure') {

			}
		 });
		 return false;
	 });

	 $(document).on('click', '#comment_button', function(){
		 var message      = $('#message').val();
		 var chat_user_id = $('input[name="chat_user_id"]').val();
		 var params = {'method' : 'send_message', 'message' : message, 'chat_user_id' : chat_user_id };
		 $.app.ajax('POST', $.app.urls('base_url')+'index.php?teacher/ajax', params, function(response){
			if(response.status == 'success') {
				$("#body_msg").append(response.html);
				$('#message').val('');
				$("#message_list").mCustomScrollbar("update");
			}
			else if(response.status == 'failure') {

			}
		 });
		 return false;
	 });

	 $(document).on('click', '.btn-container a.archive', function(e){
		e.preventDefault();
		var id = $(this).parents('.connections_container_left').attr("id").replace("connection_", "");
		var params = {'method' : 'archive_msg', 'id' : id};
		$.app.ajax('POST', $.app.urls('base_url')+'message/ajax', params, function(response){
			if(response.status == 'success') {
				$('#connection_'+id).fadeOut().remove();
				if($(".connections_container_left").length == 0) {
					$('#dialog_box').fadeOut().remove();
				}
				
			}
			else if(response.status == 'failure') {

			}
		 });
		 return false;
	 });

	 $(document).on('click', '.btn-container a.unarchive', function(e){
		e.preventDefault();
		var id = $(this).parents('.connections_container_left').attr("id").replace("connection_", "");
		var params = {'method' : 'unarchive_msg', 'id' : id};
		$.app.ajax('POST', $.app.urls('base_url')+'message/ajax', params, function(response){
			if(response.status == 'success') {
				$('#connection_'+id).fadeOut().remove();
				if($(".connections_container_left").length == 0) {
					$('#dialog_box').fadeOut().remove();
				}
				
			}
			else if(response.status == 'failure') {

			}
		 });
		 return false;
	 });

	 $(document).on('click', '.btn-container a.delete', function(e){
	 	$('#alert-box-modal').modal('show');
	 });
	 $(document).on('click', '#delete-message', function(e){
			var id = $(this).parents('.connections_container_left').attr("id").replace("connection_", "");
			var params = {'method' : 'delete_msg', 'id' : id};
			$.app.ajax('POST', $.app.urls('base_url')+'message/ajax', params, function(response){
				if(response.status == 'success') {
					$('#connection_'+id).fadeOut().remove();
					if($(".connections_container_left").length == 0) {
						$('#dialog_box').fadeOut().remove();
					}

				}
				else if(response.status == 'failure') {

				}
			 });
			 return false;
	 });

	 $(document).on('click', '.connections_req_container_left', function(){
		 $current = $(this);
		 if($current.hasClass('active')) {
			e.preventDefault();
			return false;
		 }
		 $('.connections_req_container_left').removeClass('active');
		 $('.connections_req_container_left').css('cursor', 'pointer');
		 var id_arr = $(this).attr('id');
		 var id = id_arr.split('_')[1];

		 $(this).addClass('active');
		 $(this).css('cursor', 'default');
		 $('input[name="chat_user_id"]').val(id);
		 $("#message_list").html("<div style='width:70px;margin:auto;top:35%;'><img src='"+$.app.urls('base_url')+"assets/images/ajax-loader.gif'></div>");

		 var params = {'method' : 'get_req_msg', 'id' : id};
		 $.app.ajax('POST', $.app.urls('base_url')+'message/ajax', params, function(response){
			if(response.status == 'success') {
				$("#message_list").html(response.html);
				$("#message_list").scrollTop( $("#message_list").prop("scrollHeight"));
				$("#message_list").mCustomScrollbar({
					 scrollButtons:{
						enable:true
					 }
				});			
			}
			else if(response.status == 'failure') {

			}
		 });
		 return false;
	 });

	 $(document).on('click', '.accept', function(){

	 	$('#accept-name').text($('.user_name').text());	 	
	 	$('#accept-request-modal').modal('show');

		 var id = $('input[name="chat_user_id"]').val();
		 var params = {'method' : 'accept_req', 'id' : id};
		 $.app.ajax('POST', $.app.urls('base_url')+'message/ajax', params, function(response){
			if(response.status == 'success') {
				$('#connection_'+id).fadeOut().remove();
				if($(".connections_req_container_left").length == 0) {
					$('#dialog_box').fadeOut().remove();
				}
				else {
					$("#message_list").html("<div class='alert alert-info'>Please select a user.</div>");
				}
			}
			else if(response.status == 'failure') {

			}
		 });
	 });

	 $(document).on('click', '.reject', function(){
		 var id = $('input[name="chat_user_id"]').val();
		 var params = {'method' : 'delete_req', 'id' : id};
		 $.app.ajax('POST', $.app.urls('base_url')+'message/ajax', params, function(response){
			if(response.status == 'success') {
				$('#connection_'+id).fadeOut().remove();
				if($(".connections_req_container_left").length == 0) {
					$('#dialog_box').fadeOut().remove();
				}
				else {
					$("#message_list").html("<div class='alert alert-info'>Please select a user.</div>");
				}
			}
			else if(response.status == 'failure') {

			}
		 });
	 });
});



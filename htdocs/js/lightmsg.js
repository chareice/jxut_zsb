$(function (){
		$("div.amsg div.msg_info input[type=button]").parent().parent()
							.addClass("newmsg");					
		$("div.amsg div.msg_info input[type=button]").click(function(){
			var now = $(this).parent().parent();		
			var msg_to_id= $(this).parent().children("input.msg_to_id").val();
			$.ajax({
				url:"/message/setstatus",
				data:{msg_to_id:msg_to_id},
				async:false,
				cache:false,
				type:"POST",
				global:false,
				success:function(){
					now.removeClass("newmsg");
					now.children("div.msg_info").children("input[type=button]").hide();
					$.blinkTitle.clear(timerArr);
				},
			});
		});
});

$(function(){
		$("div.amsg span.replay").click(function(){
			$("#comment").dialog({ 
				height: 300,
				width: 350,
				modal: true,
				buttons: { 
						发送: function() {
								
						},
						取消: function() {
								$( this ).dialog( "close" );
						}
				} });
		});
});
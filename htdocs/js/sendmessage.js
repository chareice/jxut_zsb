$(document).ready(function(){
	$(this).ajaxStart(function(){
			$("#alert").show();
		});
	$(this).ajaxComplete(function(){
			$("#alert").hide();
		});
	var userid = $("span.user_info").hide().text();
	var j = new Array();
	$("#send").click(function(){		
		$(":checkbox:checked").each(function(i,e){  
			var receive = $(this).val();  
			j[i]= receive;
		});  
		var message=$("textarea.message").val();
		$.post("/message/send",{message:message,user_id:userid,receive:j},function(){
			alert("消息发送成功");
		});
	});
});

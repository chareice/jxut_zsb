$(function(){
	$("#login").submit(function(){
		u = $("#username").val().replace(/^\s+|\s+$/g,"");
		p = $("#password").val();
		if(!u.length){
			alert("请填写用户名");
		}
		alert(u);
		return false;
	});
});
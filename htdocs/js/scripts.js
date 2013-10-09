$(document).ready(function(){
	$("#status-publish").click(function(event){
		if(!confirm('点击确定 发布新闻'))
		event.preventDefault();
	});
	$("#status-unpublish").click(function(event){
		if(!confirm('点击确定 下线新闻'))
		event.preventDefault();
	});
	$("#status-delete").click(function(event){
		if(!confirm('点击确定 删除新闻'))
		event.preventDefault();
	});
	$('#bread').children(':not(a)').click(function(){
		$(".preview-status").slideToggle("slow");
	});
})
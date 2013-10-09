$(function(){
	/*
	$(document).click(function(e){
		var target = $(e.target);
		if(!target.closest("#popwindow").length){
			if($("#popwindow").css("display") != "none"){
				$("#popwindow-container").slideUp(100);
				$("#popwindow table tbody").remove();
			}
		}

	});*/

	$("#bottom_left_controller").click(function(e){
		changeView("bottom_left");
		editor = new baidu.editor.ui.Editor();
		editor.render('bottom_left_content');
		loadBottomLeft();
		e.stopPropagation();
	});

	$("#top_nav_controller").click(function(e){
		changeView("top_nav");
		loadHeader();
		e.stopPropagation();
	});
	$("#bottom_right_controller").click(function(e){
		changeView("bottom_right");
		loadBottomRight();
		e.stopPropagation();
	});

	$("#top_nav_new").click(function(){
		var name = $("#top_nav_name").val();
		var url = $("#top_nav_url").val();
		var rankid = $("#top_nav_rankid").val();
		$.ajax({
			'url':'/admin/newobject/',
			'type':'POST',
			'data':{action:'header',name:name,url:url,rankid:rankid},
			'success':function(data){
				if(data == "success"){
					alert("添加成功");
				}else{
					alert("添加失败");
				}
			}
		});
		loadHeader();
		return false;
	});

	$("#bottom_right_new").click(function(){
		var name = $("#bottom_right_name").val();
		var url = $("#bottom_right_url").val();
		var rankid = $("#bottom_right_rankid").val();
		$.ajax({
			'url':'/admin/newobject/',
			'type':'POST',
			'data':{action:'bottomright',name:name,url:url,rankid:rankid},
			'success':function(data){
				if(data == "success"){
					alert("添加成功");
				}else{
					alert("添加失败");
				}
			}
		});
		loadBottomRight();
		return false;
	});

	$("#bottom_left_new").click(function(){
		var name = $("#bottom_left_name").val();
		var content = editor.getContent();
		var rankid = $("#bottom_left_rankid").val();
		$.ajax({
			'url':'/admin/newobject/',
			'type':'POST',
			'data':{action:'bottomleft',name:name,content:content,rankid:rankid},
			'success':function(data){
				if(data == "success"){
					alert("添加成功");
				}else{
					alert("添加失败");
				}
			}
		});
		loadBottomLeft();
		return false;
	});
	//待修改的函数
	$("#bottom_left_edit").click(function(){
		if(typeof(editid)=='undefined'){
			alert("未选择修改的项目");
			return false;
		}
		var name = $("#bottom_left_name").val();
		var content = editor.getContent();
		var rankid = $("#bottom_left_rankid").val();
		$.ajax({
			'url':'/admin/editobject/',
			'type':'POST',
			'data':{action:'bottomleft',id:editid,name:name,content:content,rankid:rankid},
			'success':function(data){
				if(data == "success"){
					alert("修改成功");
				}else{
					alert("修改失败");
				}
			}
		});
		loadBottomLeft();
		return false;
	});


	$("#top_nav_edit").click(function(){
		if(typeof(editid)=='undefined'){
			alert("未选择修改的项目");
			return false;
		}
		var name = $("#top_nav_name").val();
		var url = $("#top_nav_url").val();
		var rankid = $("#top_nav_rankid").val();
		$.ajax({
			'url':'/admin/editobject/',
			'type':'POST',
			'data':{action:'header',id:editid,name:name,url:url,rankid:rankid},
			'success':function(data){
				if(data == "success"){
					alert("修改成功");
				}else{
					alert("修改失败");
				}
			}
		});
		loadHeader();
		return false;
	});

	$("#bottom_right_edit").click(function(){
		if(typeof(editid)=='undefined'){
			alert("未选择修改的项目");
			return false;
		}
		var name = $("#bottom_right_name").val();
		var url = $("#bottom_right_url").val();
		var rankid = $("#bottom_right_rankid").val();
		$.ajax({
			'url':'/admin/editobject/',
			'type':'POST',
			'data':{action:'bottomright',id:editid,name:name,url:url,rankid:rankid},
			'success':function(data){
				if(data == "success"){
					alert("修改成功");
				}else{
					alert("修改失败");
				}
			}
		});
		loadBottomRight();
		return false;
	});

});
var loadBottomLeft = function(){
	$(".list tbody").remove();
	$.ajax({
		'url':'/admin/getbottomleft',
		'success':function(data){
			var tbody = '<tbody class="bottomleft">';
			$.each(data,function(i,h){
				tbody += '<tr data-id="'+h.id+'"><td>'+h.name+'</td><td style="display:none">'+h.content+'</td><td>'+h.rankid+'</td><td><button class="edit">修改</button><button class="delete">删除</button></td></tr>';
			});
			tbody += "</tbody>";
			$("#popwindow .list").append(tbody);
			$(".list .bottomleft button.edit").click(editHandle);
			$(".list .bottomleft button.delete").click(deleteHandle);
		}
	});
}

var loadHeader = function(){
	$(".list tbody").remove();
	$.ajax({
		'url':'/admin/getheader',
		'success':function(data){
			var tbody = '<tbody class="header">';
			$.each(data,function(i,h){
				tbody += '<tr data-id="'+h.id+'"><td>'+h.content+'</td><td>'+h.url+'</td><td>'+h.rankid+'</td><td><button class="edit">修改</button><button class="delete">删除</button></td></tr>';
			});
			tbody += "</tbody>";
			$("#popwindow .list").append(tbody);
			$(".list .header button.edit").click(editHandle);
			$(".list .header button.delete").click(deleteHandle);
		}
	});
}
var loadBottomRight = function(){
	$(".list tbody").remove();
	$.ajax({
		'url':'/admin/getbottomright',
		'success':function(data){
			var tbody = '<tbody class="bottomright">';
			$.each(data,function(i,h){
				tbody += '<tr data-id="'+h.id+'"><td>'+h.content+'</td><td>'+h.url+'</td><td>'+h.rankid+'</td><td><button class="edit">修改</button><button class="delete">删除</button></td></tr>';
			});
			tbody += "</tbody>";
			$("#popwindow .list").append(tbody);
			$(".list .bottomright button.edit").click(editHandle);
			$(".list .bottomright button.delete").click(deleteHandle);
		}
	});
}
var editHandle = function(e){
	var table = $(e.target).closest('tr');
	var id = table.data('id');
	var action = $(e.target).closest('tbody').attr('class');
	if(action == "header"){
		var name = $(table.children()[0]).text();
		var url = $(table.children()[1]).text();
		var rankid  = $(table.children()[2]).text();
		$("#top_nav_name").val(name);
		$("#top_nav_url").val(url);
		$("#top_nav_rankid").val(rankid);
	}else if(action == "bottomleft"){
		var name = $(table.children()[0]).html();
		var content = $(table.children()[1]).html();
		var rankid  = $(table.children()[2]).html();
		$("#bottom_left_name").val(name);
		editor.setContent(content);
		$("#bottom_left_rankid").val(rankid);
	}else if(action == "bottomright"){
		var name = $(table.children()[0]).text();
		var url = $(table.children()[1]).text();
		var rankid  = $(table.children()[2]).text();
		$("#bottom_right_name").val(name);
		$("#bottom_right_url").val(url);
		$("#bottom_right_rankid").val(rankid);
	}
	window.editid = id;
}
var deleteHandle = function(e){
	if(!confirm("确定删除？不可恢复。")){
		return false;
	}
	var table = $(e.target).closest('tr');
	var id = table.data('id');
	var action = $(e.target).closest('tbody').attr('class');
	$.ajax({
		url:'/admin/deleteobject',
		type:'POST',
		data:{action:action,id:id},
		success:function(data){
			if(data == "success"){
				alert("删除成功");
				if(action == "header"){
					loadHeader();
				}else if(action == "bottomleft"){
					loadBottomLeft();
				}else if(action == "bottomright"){
					loadBottomRight();
				}
			}else{
				alert("删除失败");
			}
		}
	});
}
var changeView = function(active){
	var list = $("#popcontent").children();
	$.each(list,function(i,c){
		if(c.id == active){
			$(this).show();
		}else{
			$(this).hide();
		}
	});
	var viewHeight = $(window).height();
	var viewWidth = $(window).width();
	var mt = viewHeight / 10;
	var pop = document.getElementById("popwindow");
	var con = document.getElementById("popwindow-container");
	con.style.height = viewHeight + "px";
	pop.style.height = (viewHeight - mt) + "px";
	pop.style.width = viewWidth + "px";
	pop.style.marginTop = mt / 2 + "px";
	$("#popwindow-container").slideDown(100);
}
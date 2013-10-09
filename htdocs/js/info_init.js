$(document).ready(function(){
	$("#info_center_loading").submit(function(){
		id = $("#info_center_id").val();
		name = $("#info_center_name").val();
		if(name==""){
			loading(id);
		}
		else{
			$("#city-container").hide();
			$("#result").html("");
			addnew(id,name);
		}
		return false;		
	});
	$("#info_main").submit(function(){
		place = $("#county").val();
		num = $("#info_num").val();
		id = $("#info_center_id").val();
		infoinner(place,num,id);
		return false;
	});
});

function addnew(id,name){
	$.ajax({
			url:"/work/infoaddnew",
			type:"POST",
			data:{id:id,name:name},
			success:function(data){
				if(data == "success"){
					$("#city-container").show();
				}
				else{
					alert("已存在");
				}
			}
		});
}
function infoinner(place,num,id){
	$.ajax({
			url:"/work/infoinneradd",
			type:"POST",
			data:{place:place,num:num,id:id},
			success:function(){
				alert("添加成功");
				$("#info_center_name,#info_num").val("");
				loading(id);
			}
		});
}
function loading(id){
	$.ajax({
			url:"/work/getinner",
			type:"POST",
			data:{id:id},
			success:function(data){
				if(data.length == 0){
					alert("没有相关信息");
				}
				else{
					$("#city-container").show();
					html="";
					html += "<table class=\"table span2 table-striped table-bordered table-condensed\">\
							 	<thead>\
							 		<tr>\
							 			<td>地区</td>\
							 			<td>姓名</td>\
							 			<td>数量</td>\
							 		</tr>\
							 	</thead>\
							 	<tbody>"
					$.each(data,function(index,item){
						$("#result").html("");
						html += "<tr><input class=\"inner_id\" value=\""+item.inner_id+"\" type=\"hidden\"/><td>"+item.FULL_NAME+"</td><td class=\"name\">"+item.name+"</td><td>"+item.count+"</td><td><button class=\"btn btn-mini change\">修改</button></td><td><button class=\"btn btn-mini btn-danger delete\">删除</button></td></tr>";
					});
					html+="</tbody></table>";
					$("#result").html(html);
					$("button.change").click(function(event){
						inner_id = $(event.target).closest("tr").children(".inner_id").val();
						count = prompt("请输入修改后的数量");
						if(count){
							$.ajax({
							url:"/work/editinner",
							type:"POST",
							data:{inner_id:inner_id,count:count},
							success:function(data){
									loading(id);
								},
							});
						}
					});
					$("button.delete").click(function(event){
						if(confirm("确定删除吗？")){
							inner_id = $(event.target).closest("tr").children(".inner_id").val();
							$.ajax({
								url:"/work/deleteinfo",
								type:"POST",
								data:{inner_id:inner_id},
								success:function(data){
										loading(id);
									},
							});
						}
					});
					return true;
				}
			}
		});
}
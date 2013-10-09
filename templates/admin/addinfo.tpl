{include file="header.tpl"}
{literal}
<script type="text/javascript">
	$(function(){
		$("#sub").click(function(){
			$.post("/pinyin.php",{chinese:$(".info_title").val()},function(data){
				$("#py").val(($(".info_header").val())+data);
				$.ajax({
					url:"/admin/addinfo",
					type:"POST",
					cache:false,
					data:{t:$(".info_title").val(),p:$("#py").val(),c:editor.getContent()},
					success:function(data){
						$("#loadq").val(data);
						alert("成功");
					}
				});
			});			
		});
		$("#load").click(function(){
			$.ajax({
					url:"/admin/addinfo",
					type:"POST",
					cache:false,
					data:{a:"1",q:$("#loadq").val()},
					success:function(data){
						$(".info_title").val(data.t);
						//$(".info_textarea").val(data.c);
						editor.setContent(data.c);
						$(".info_header").val(data.k);
					}
				});
		});
		$("#edit").click(function(){
		$.post("/pinyin.php",{chinese:$(".info_title").val()},function(data){
			$("#py").val(($(".info_header").val())+data);
			$.ajax({
					url:"/admin/addinfo",
					type:"POST",
					cache:false,
					data:{e:"1",q:$("#loadq").val(),t:$(".info_title").val(),p:$("#py").val(),c:editor.getContent()},
					success:function(data){
						alert("修改成功");
					}
				});
		})
		})
		editor = new baidu.editor.ui.Editor();
   		editor.render('baidu_editor');
	})
</script>
{/literal}
	<hr/>
	<input id="loadq" type="text" placeholder="加载原始记录"><input id="load" type="submit" value="加载"/><br/>
	<hr/>添加底部面板可查询信息</br>
	<input type="text" class="info_title" placeholder="标题"/><br/><input type="text" class="info_header" placeholder="命名空间"/></br>
	<input type="hidden" id="py"/>
	<input id="sub" type="submit" value="添加新数据"/><input id="edit" type="submit" value="修改原始数据"/>
	<textarea placeholder="内容" class="info_textarea" id="baidu_editor"></textarea>
	
{include file="footer.tpl"}
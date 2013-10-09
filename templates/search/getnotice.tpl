{include file="header.tpl"}
{literal}
<style>
#notice_result table td{
	border:1px solid #ccc;
	padding:10px;
}
</style>
<script>
	function jsonpcallback(data){
	
              html="<table><thead><tr><td>姓名</td><td>地址</td><td>号码</td><td>单号</td></tr></thead><tbody>"
		$.each(data,function(i,v){
                 	html+="<tr><td>"+v['name']+"</td><td>"+v['address']+"</td><td>"+v['phone']+"</td><td>"+v['ems']+"</td>"
			});
	      html+="</tbody></table>";
                	     $("#notice_result").append(html);
	}
$(document).ready(function(){
	$("#getnotice").submit(function(){
		$("#notice_result").html("");
		$.ajax({
 		   url:"/search/getcalinda/?q="+$("#getnotice_user").val(),
 		   type:"GET",
		   dataType:"json",
 		   success:function(data){
			if(data.length>0){
				html="<table style=\"border:1px solid #ccc;background:#fff;margin-top:10px\"><thead><tr><td>姓名</td><td>地址</td><td>号码</td><td>单号</td></tr></thead><tbody>"
				$.each(data,function(i,v){
                 			html+="<tr><td>"+v['name']+"</td><td>"+v['address']+"</td><td>"+v['phone']+"</td><td>"+v['ems']+"</td>"
				});
	      			html+="</tbody></table>";
			}
			else{
				html = "No result below to show...";
			}
                	$("#notice_result").append(html);
			}
		});
		return false;
	});
});
</script>
{/literal}
<form id="getnotice" action="/search/" method="get">
	考生姓名：<input name="q" id="getnotice_user">
	<button type="submit">提交</button>
</form>
<div id="notice_result">
</div>
{include file="footer.tpl"}
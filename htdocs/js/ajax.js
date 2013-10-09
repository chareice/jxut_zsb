$(document).ready(function(){
	$(".hidden").hide();
	$("#change").click(function(){
		htmlobj=$.ajax({url:"/admin/ajax",async:false});
		$("#ajax").html(htmlobj.responseText);
	});
	var edit = $('table .canedit').css('color','red');
	edit.click(function(){
		var inputobj = $("<input type=\"text\">");
		var onedit = $(this);
		var text = onedit.html();
		onedit.html("");
		inputobj.css("border","0")
                .css("font-size",onedit.css("font-size"))
                .css("font-family",onedit.css("font-family"))  
                .css("color","red")
				.css("text-align","center")
                .width(onedit.width())
                .val(text)
                .appendTo(onedit)
				.click(function(){
					return false;
				})
				.blur(function(){
					var inhtml = $(this).val();
					if(inhtml.length==0)
						{alert("必须填写");
							$(this)[0].focus();
						}
					else 
					$(this).css('color','#000')
					.css("background-color",onedit.css("background-color"));
					var tr =$(this).parent().parent().children(".user_id").css("background-color","yellow");
					$.ajax({url:"/admin/ajax?user_id="+tr.text()+"&name="+$(this).val(),async:false});
				})
				.focus(function(){
					$(this).css('color','red')
					.css("background-color","orange");
				})
	});
	
});
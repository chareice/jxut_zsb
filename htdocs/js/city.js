$(document).ready(function(){
	$("input#action").click(function(){
		var q=$("#q").val();
		$.getJSON("/info/citypro?q="+q,function(json){
			$("div#result table tbody").html("");
			$.each(json,function(i,city){
				$("div#result table tbody").append(
					"<tr>"+
						"<td>"+city.full_name+"</td>"+
						"<td>"+city.phone_code+"</td>"+
						"<td>"+city.zip_code+"</td>"+
					"</tr>"
				);
			});
		});
	});
	
});
$(document).ready(function(){
		var edit = $('table#users tbody tr td.canedit').css('color','red');
		edit.click(function(){
			var tr = $(this).parent().css('background-color','yellow')
			tr.children(".username").css('color','red')
		});
});
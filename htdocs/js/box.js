$(function(){
	var pro = [
			{value: "AH", name: "安徽"},
			{value: "BJ", name: "北京"},
			{value: "CQ", name: "重庆"},
			{value: "FJ", name: "福建"},
			{value: "GD", name: "广东"},
			{value: "GS", name: "甘肃"},
			{value: "GX", name: "广西"},
			{value: "GZ", name: "贵州"},
			{value: "HA", name: "河南"},
			{value: "HB", name: "湖北"},
			{value: "HE", name: "河北"},
			{value: "HI", name: "海南"},
			{value: "HL", name: "黑龙江"},
			{value: "HN", name: "湖南"},
			{value: "JX", name: "江西"},
			{value: "JL", name: "吉林"},
			{value: "JS", name: "江苏"},			
			{value: "LN", name: "辽宁"},
			{value: "NM", name: "内蒙古"},
			{value: "NX", name: "宁夏"},
			{value: "QH", name: "青海"},
			{value: "SC", name: "四川"},
			{value: "SD", name: "山东"},
			{value: "SH", name: "上海"},
			{value: "SN", name: "陕西"},
			{value: "SX", name: "山西"},
			{value: "TJ", name: "天津"},
			{value: "XJ", name: "新疆"},
			{value: "XZ", name: "西藏"},
			{value: "YN", name: "云南"},
			{value: "ZJ", name: "浙江"},
		];
		$( "#main-serch" ).autocomplete({
			source:pro,
			focus:function(event,ui){
					//$("#main-serch").val(ui.item.value);
					return false;
			},
			select: function( event, ui ) {
					$( "#main-serch" ).val( ui.item.value);
					return false;
			},
			autoFocus:true,//自动获取第一条结果焦点
			delay:0,//延迟时间
			minLength:1,
		}).data( "autocomplete" )._renderItem = function( ul, item ) {
			return $( "<li></li>" )
				.data( "item.autocomplete", item )
				.append( "<a>" + item.value + "[" + item.name + "]"+"</a>" )
				.appendTo( ul );
			};
});
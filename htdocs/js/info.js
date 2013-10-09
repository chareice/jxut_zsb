var province = [
			{abb: "AH", pro_n: "安徽"},
			{abb: "BJ", pro_n: "北京"},
			{abb: "CQ", pro_n: "重庆"},
			{abb: "FJ", pro_n: "福建"},
			{abb: "GD", pro_n: "广东"},
			{abb: "GS", pro_n: "甘肃"},
			{abb: "GX", pro_n: "广西"},
			{abb: "GZ", pro_n: "贵州"},
			{abb: "HA", pro_n: "河南"},
			{abb: "HB", pro_n: "湖北"},
			{abb: "HE", pro_n: "河北"},
			{abb: "HI", pro_n: "海南"},
			{abb: "HL", pro_n: "黑龙江"},
			{abb: "HN", pro_n: "湖南"},
			{abb: "JX", pro_n: "江西"},
			{abb: "JL", pro_n: "吉林"},
			{abb: "JS", pro_n: "江苏"},			
			{abb: "LN", pro_n: "辽宁"},
			{abb: "NM", pro_n: "内蒙古"},
			{abb: "NX", pro_n: "宁夏"},
			{abb: "QH", pro_n: "青海"},
			{abb: "SC", pro_n: "四川"},
			{abb: "SD", pro_n: "山东"},
			{abb: "SH", pro_n: "上海"},
			{abb: "SN", pro_n: "陕西"},
			{abb: "SX", pro_n: "山西"},
			{abb: "TJ", pro_n: "天津"},
			{abb: "XJ", pro_n: "新疆"},
			{abb: "XZ", pro_n: "西藏"},
			{abb: "YN", pro_n: "云南"},
			{abb: "ZJ", pro_n: "浙江"},
         ];
 
             $(function() {
                 $('#main-serch').autocomplete(province, {
                     max: 34,    //列表里的条目数
                     minChars: 0,    //自动完成激活之前填入的最小字符
                     width: 160,     //提示的宽度，溢出隐藏
                     scrollHeight: 300,   //提示的高度，溢出显示滚动条
                     matchContains: false,    //包含匹配，就是data参数里的数据，是否只要包含文本框里的数据就显示
                     autoFill: false,    //自动填充
                     formatItem: function(row, i, max) {
                         return i + '/' + max + ':"' + row.abb + '"[' + row.pro_n + ']';
                     },
                     formatMatch: function(row, i, max) {
                         return row.abb + row.pro_n;
                     },
                     formatResult: function(row) {
                         return row.abb;
                     }
                 }).result(function(event, row, formatted) {	 
				 $.getJSON("/info/search?q="+$("#main-serch").val(),function(v){
							createcity(v.n);
							$("#info-result").html(v.c);
							$("#info-result table:first").prepend('<caption>'+v.n+'</caption>');
							});
							$("#main-serch").val("");
				/*$.getJSON("/info/search?q="+$("#main-serch").val(),function(v){
					createcity(v.n);
				});		*/	
				
				function createcity(te){
					new PCAS("province","city","area",te);
				}
				 });
				 /*------------------------------------------查分↓
				 $("#add-info .stp2 input[type=radio]").click(function(event){
					$target = $(event.target);
					if($target.closest('.stp2').length&&($target.attr("value")==11)){//检测到步骤二艺术被点击
						$("fieldset.stp3").hide();
						$("fieldset.art").show();
					}
					else{//----------------------------------------------------------普通类处理
						$("fieldset.art").hide();
						$("fieldset.stp3").show();
					}	
				 });
				 $("#add-info input[type=submit]").click(function(){
					pro = $("#addpro").val();
					mark = $("#addmark").val();
					if(!$("input[name=b]")[2].checked){//未选中艺术
						identity = $("input[name=a]:checked").val()+$("input[name=b]:checked").val()+$("input[name=c]:checked").val();
					}
					else{
						identity = $("input[name=a]:checked").val()+$("input[name=b]:checked").val()+$("input[name=d]:checked").val()+$("input[name=e]:checked").val()+$("input[name=f]:checked").val()+$("input[name=g]:checked").val();
					}
					//$("#mark-result").append("省份："+pro+"\n分数："+mark+"\n识别码："+identity);
					$("#mark-result").append("INSERT INTO 2011_MARK VALUE(\""+pro+"\",\""+mark+"\",\""+identity+"\")<br/>");
				 });*/
             });

			 /*$(document).ready(function() {     
    var serch = $('input#main-serch');     
    serch.addClass("idleField");     
    serch.focus(function() {     
        $(this).removeClass("idleField").addClass("focusField");     
        if (this.value == this.defaultValue){      
            this.value = '';     
        }     
        if(this.value != this.defaultValue){     
            this.select();     
        }     
    });     
    serch.blur(function() {     
        $(this).removeClass("focusField").addClass("idleField");     
        if ($.trim(this.value) == ''){     
            this.value = (this.defaultValue ? this.defaultValue : ''); 
        }
//		else
//			alert($(this).val());
    });
	serch.ajaxStart(function(){
		$('span').html("<img src='/image/loding/2008228102611_26_mb5u_com.gif'/>");
	});
	serch.keyup(function(event){
		if(event.keyCode==8){
			$(this).html("");
		}
		if(serch.val().length<3){
		var htmlobj=$.ajax({
			url:"/info/serch?q="+$(this).val(),
			async:false,
			//dataType:"json"
		});
		$('span').text(htmlobj.responseText);}
	});
});   */
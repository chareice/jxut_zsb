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
						window.location.href="/admin/infoedit?q="+$("#main-serch").val();
				 });
   				editor = new baidu.editor.ui.Editor();
   				editor.render('baidu_editor');
             });
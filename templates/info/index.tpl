{include file='header.tpl' section="info"}
<script type="text/javascript" src="/js/jquery/ac.js"></script>
<link rel="Stylesheet" href="/js/jquery/ac.css" />
<script type="text/javascript" src="/js/info.js"></script>
<script type="text/javascript" src="/js/cityselect.js"></script>	<div style="display:none"><select style="display：
none" id="province" name="province"></select>
		<select id="city" name="city"></select><select id="area" name="area">
		</select><input type="button" id="serch_person" value="查询负责老师（未开放）"/></div>
<div id="main-serch-container">
	<div id="main-select-container">
		<input id="main-serch" type="search"/>
<!--<br/><div style="color:red">样式表重要改动，请在页面中右键单击后选择重新载入刷新浏览器缓存。[7-31]</div>-->
	</div>	
</div>
<div id="info-result-container">
<section id="info-result"></section>
</div>
<script language="javascript" defer>
new PCAS("province","city","area");
</script>
<!--注释于2012年4月27日23:28:11

{literal}
 <script type="text/javascript">
var mark_nor = new Array();
var mark_art = new Array();
var nor_wen = /^[0-1]{2}01[0-1]{2}$/;
var nor_li = /^[0-1]{2}10[0-1]{2}$/;
temp = new Array();
jxtemp = new Array();
var jsona;
var identity;
var temp_art = new Array();
function mark(identity, mark) {
	this.identity = identity;
	this.mark = mark;
}
function getQ(q) {
	switch (q) {
	case "1":
		return "文科";
		break;
	case "2":
		return "理科";
		break;
	case "3":
		return "艺术";
		break;
	default:
		return false;
	}
}
function art_process() {
	var result = "没有相关的记录哦";
	if (jsona.pro == "江西省"){
	identity = $("input[name=a]:checked").val() + "11" + $("input[name=d]:checked").val() + $("input[name=e]:checked").val() + $("input[name=f]:checked").val() + $("input[name=g]:checked").val();
	}
	else 
	identity = temp_art[0] + "11" + $("input[name=d]:checked").val() + $("input[name=e]:checked").val() + $("input[name=f]:checked").val() + $("input[name=g]:checked").val();
	result = eval("jsona[\"" + identity + "\"]");
	if (!result) {
		result = "系统中无相关记录";
	}
	$("#result").text(result);
}
function process(i, type) {
	if (nor_wen.test(mark_nor[i].identity) && (dec == "1")) {
		if (/^[0-1]{2}0101$/.test(mark_nor[i].identity))
		 temp.push(type + "本科：" + mark_nor[i].mark + "分");
		else
		 temp.push("; 专科：" + mark_nor[i].mark + "分<br/>");
	}
	 else if (nor_li.test(mark_nor[i].identity) && (dec == "2")) {
		if (/^[0-1]{2}1001$/.test(mark_nor[i].identity))
		 temp.push(type + "本科：" + mark_nor[i].mark + "分");
		else
		 temp.push("; 专科：" + mark_nor[i].mark + "分<br/>");
	}
}
$(function() {
	$('.result').ajaxStart(function() {
		$(this).hide(300);
	});
	$("#sendq").submit(function() {
		q = $("#q").val().substr(0, 2);
		dec = $("#q").val().substr( - 1, 1);
		$.getJSON("/getmark.php?q=" + q,
		function(json) {
			jsona = json;
			$("#result").html("");
			$("#art_title").text("");
			temp = [];
			mark_nor = [];
			mark_art = [];
			for (i in json) {
				$('.result').show(500);
				if (i.length == 6) {
					mark_nor.push(new mark(i, json[i]));
				}
				 else if (i.length == 12)
				 mark_art.push(new mark(i, json[i]));
			}
			if (dec == "3")
			 {
				$(".art input[type = radio][checked=checked]").attr("checked", 'checked');
				$("#select_fields").show();
				$(".art").show();
				if (mark_art.length != 0) {
					for (i = 0; i != 6; i++) {
						temp_art[i] = mark_art[0].identity.substr(i * 2, 2);
					}
					if (json.pro != "江西省") {
						$(".first").hide();
					}
					for (i = 2; i != temp_art.length; i++) {
						if (temp_art[i] == "00") {
							atemp = i - 2;
							artname = ".art" + atemp;
							$(artname).hide();
						}
					}
				}
				art_process();
				return;
			}
			var type;
			$("#select_fields").hide();
			for (i = 0; i != mark_nor.length; i++) {
				if (/^01/.test(mark_nor[i].identity)) {
					process(i, type = "二本");
				}
				 else if (/^10/.test(mark_nor[i].identity)) {
					process(i, type = "三本");
				}
				 else if (/^00/.test(mark_nor[i].identity)) {
					process(i, type = "");
				}
				 else if (/^11/.test(mark_nor[i].identity)) {
					process(i, type = "三校");
				}
			}
			result = json.pro + " " + getQ(dec) + "<br/>" + temp.toString().replace(/,/g, "");
			$("#result").html(result);
		});
		return false;
	});
	$("#select_fields").change(function() {
		art_process();
		$("#art_title").text(jsona.pro);
	});
});
        </script>
        <style>
            #main{ text-align:center; }
            #q,#submit{text-align:center;}
            #submit{padding: 7px; background:yellow;border-bottom-colors: none;
                border-image: none;
                border-left-colors: none;
                border-right-colors: none;
                border-top-colors: none;
                background: none repeat scroll 0 0 #ccc;
                border-color: #EBEBEB #DDDDDD #B7B7B7;
                border-left: 1px solid #DDDDDD;
                border-radius: 4px 4px 4px 4px;
                border-right: 1px solid #DDDDDD;
                border-style: solid;
                border-width: 1px;font-size: 24px; }
          #main input[type="text"]{
                border-bottom-colors: none;
                border-image: none;
                border-left-colors: none;
                border-right-colors: none;
                border-top-colors: none;
                background: none repeat scroll 0 0 #FFFFFF;
                border-color: #EBEBEB #DDDDDD #B7B7B7;
                border-left: 1px solid #DDDDDD;
                border-radius: 4px 4px 4px 4px;
                border-right: 1px solid #DDDDDD;
                border-style: solid;
                border-width: 1px;
                color: #333333;
                font-size: 24px;
                line-height: 30px;
                outline: medium none;
                padding: 7px;
                width: 3em;
          }
		  #main fieldset{
			padding:1em;
		  }
        </style>{/literal}
    </head>
    
    <body>
        <div id="main">
            <form id="sendq" action="">
                <input id="q" type="text" maxlength="3"/>
                <button id="submit">
                    提交
                </button>
            </form>
          <div class="result" style="display:none;">
                <p>
                    您查询的是：
                </p>
            <div id="art_title"></div>
                <div id="result" style="font-size:20px;">
                </div>
              <div id="select_fields" style="width:180px;margin:0 auto;display:none">
                <fieldset class="first art">
		<legend>选择</legend>
                	<label style="display:none"><input type="radio" name="a" value="00"checked="checked"/>默认值</label>
		<label><input type="radio" name="a" value="01"/>二本</label>
		<label><input type="radio" name="a" value="10"/>三本</label>
		<label><input type="radio" name="a" value="11"/>三校</label>
	</fieldset>
        <fieldset class="art0 art">
		<legend>艺术类型</legend>
          <label style="display:none"><input type="radio" name="d" value="00"checked="checked"/>默认值</label>
		<label><input type="radio" name="d" value="01"/>美术</label>
		<label><input type="radio" name="d" value="10"/>音乐</label>
		<label><input type="radio" name="d" value="11"/>舞蹈</label>
	</fieldset>         	
            <fieldset class="art1 art">
		<legend>艺术文理</legend>
                          <label style="display:none"><input type="radio" name="e" value="00"checked="checked"/>默认值</label>
		<label><input type="radio" name="e" value="01"/>文科</label>
		<label><input type="radio" name="e" value="10"/>理科</label>
	</fieldset>
	<fieldset class="art2 art">
        		          <label style="display:none"><input type="radio" name="f" value="00"checked="checked"/>默认值</label>
		<legend>艺术本专</legend>
		<label><input type="radio" name="f" value="01"/>本科</label>
		<label><input type="radio" name="f" value="10"/>专科</label>
	</fieldset>
	<fieldset class="art3 art">
                  <label style="display:none"><input type="radio" name="g" value="00"checked="checked"/>默认值</label>
		<legend>文化、专业</legend>
		<label><input type="radio" name="g" value="01"/>文化</label>
		<label><input type="radio" name="g" value="10"/>专业</label>
	</fieldset>
      </div>
                  </div>
        </div>-->
{include file='footer.tpl' section='info'}
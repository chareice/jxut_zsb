<!doctype html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>主页</title>
	<link rel="stylesheet" type="text/css" href="/style/info_index.css">
	<script type="text/javascript" src="/js/jquery/jquery.js"></script>
	<script type="text/javascript" src="/js/info_init.js"></script>
</head>
<body>
<div class="container"><div class="span4 raw">
  <form class="well form-inline" id="info_center_loading">
  <input type="text" class="input-small" placeholder="工号(学号)" id="info_center_id">
  <input type="text" class="input-small" placeholder="姓名" id="info_center_name">
  <button type="submit" class="btn">加载</button>
</form>
</div>
<div class="raw" id="result"></div>
<div class="well span3 raw" id="city-container" style="display:none">
	<select id="province" onchange="setCity(this.value);getArea();" name="province" runat="server">
	 	<option value="">--请选择省份--</option>
	</select>
	<select id="city" onchange="setCounty(this.value);getArea();" name="city" runat="server">
		<option value="" selected="selected">--请选择城市--</option>
	</select>
	<select id="county" name="county" runat="server" onchange="getArea();">
		<option value="" selected="selected" >--请选择地区--</option>
	</select>
	<form class="form-inline" id="info_main">
	     数量：<input type="text" class="input-small" id="info_num">
	    	<button type="submit" class="btn">提 交</button>
			<input type="hidden" name="area" id="area" value=""/>
			<input type="hidden" name="area1" id="area1" value=""/>
			<input type="hidden" name="area2" id="area2" value=""/>
	</form>
</div>
<script type="text/javascript" src="/js/city_select.js"></script>
</div>
</body>
</html>
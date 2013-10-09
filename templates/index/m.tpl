<!doctype>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<meta charset="utf8"/>
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.1.0-rc.1/jquery.mobile-1.1.0-rc.1.min.css" />
	<script src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.1.0-rc.1/jquery.mobile-1.1.0-rc.1.min.js"></script>
</head>
<body>
<div data-role="page" id="Cars">
<a href="/index/" data-role="button" 
data-icon="info">Button</a>
   <div data-role="header" data-position="inline">
   <a href="cancel.html" data-icon="delete">Cancel</a>
   <h1>Edit Contact</h1>
   <a href="save.html" data-icon="check">Save</a>
	</div>
   <div data-role="content">   
      <p>We can add a list of cars</p>
   </div><!-- /content -->
   <ul data-role="listview" data-inset="true" data-filter="true">
	<li><a href="#">Acura</a></li>
	<li><a href="#">Audi</a></li>
	<li><a href="#">BMW</a></li>
	<li><a href="#">Cadillac</a></li>
	<li><a href="#">Ferrari</a></li>
</ul>
   <div data-role="footer">
      <h4>Page Footer</h4>
   </div><!-- /footer -->
</div><!-- /page -->
<!-- Start of third page -->
<div data-role="page" id="Trains">
   <div data-role="header">
      <h1>Trains</h1>
   </div><!-- /header -->
   <div data-role="content">   
      <p>We can add a list of trains</p>
   </div><!-- /content -->
   <div data-role="footer">
      <h4>Page Footer</h4>
   </div><!-- /footer -->
</div><!-- /page -->
<!-- Start of fourth page -->
<div data-role="page" id="Planes">
   <div data-role="header">
      <h1>Planes</h1>
</div><!-- /header -->
   <div data-role="content">   
      <p>We can add a list of planes</p>
   </div><!-- /content -->
   <div data-role="footer">
   <h4>Page Footer</h4>
</div><!-- /footer -->
</div><!-- /page --></body>
</html>
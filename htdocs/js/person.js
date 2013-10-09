/*$(document).ready(function() { 
		$("#serch_person").click(function(){
		var place = $("#province").val()+$("#city").val()+$("#area").val();
		$("table#person caption").text(place);
	});
});*/
$(document).ready(function(){
	/*var opts = {
  lines: 10, // The number of lines to draw
  length: 7, // The length of each line
  width: 4, // The line thickness
  radius: 10, // The radius of the inner circle
  color: '#a6a6a6', // #rgb or #rrggbb
  speed: 3, // Rounds per second
  trail: 10, // Afterglow percentage
  shadow: true, // Whether to render a shadow
  hwaccel: false // Whether to use hardware acceleration
};
	var target = document.getElementById('alert');
	var spinner = new Spinner(opts).spin(target);*/
	var cl = new CanvasLoader('alert');
	cl.setShape('spiral');
	cl.setDiameter(40); // default is 40
	cl.setDensity(60); // default is 40
	cl.setRange(0.8); // default is 1.3
	cl.setSpeed(3);
	cl.setColor('#fff');
	cl.setFPS(41); // default is 24
	cl.show(); // Hidden by default
});
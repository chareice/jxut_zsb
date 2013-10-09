/*                                                   ©2011-2012
 *  ■ ■ ■ ■ ■    ■         ■         ■          ■ ■ ■ ■      ■ ■ ■ ■ ■     ■ ■ ■ ■ ■    ■ ■ ■ ■ ■   ■ ■ ■ ■ ■
 * ■             ■         ■        ■ ■         ■       ■    ■                 ■       ■            ■
 * ■             ■         ■       ■   ■        ■       ■    ■                 ■       ■            ■
 * ■             ■ ■ ■ ■ ■ ■      ■     ■       ■ ■ ■ ■      ■ ■ ■ ■ ■         ■       ■            ■ ■ ■ ■ ■
 * ■             ■         ■     ■ ■ ■ ■ ■      ■ ■          ■                 ■       ■            ■ 
 * ■             ■         ■     ■       ■      ■    ■       ■                 ■       ■            ■
 *  ■ ■ ■ ■ ■    ■         ■     ■       ■      ■       ■    ■ ■ ■ ■ ■     ■ ■ ■ ■ ■    ■ ■ ■ ■ ■   ■ ■ ■ ■ ■ 
 */
if ($.browser.msie) {
	alert("您使用的是不被支持的IE浏览器，请升级您的浏览器\n如果已经在使用“双核浏览器”，请其切换至极速模式");
	window.location.href("/help#llq");
}
$(function() {
	var cl = new CanvasLoader('alert');
	cl.setShape('spiral');
	cl.setDiameter(40);
	cl.setDensity(60);
	cl.setRange(0.8);
	cl.setSpeed(3);
	cl.setColor('#248ccc');
	cl.setFPS(41);
	cl.show();
	$(this).ajaxStart(function() {
		$("#alert").show();
	});
	$(this).ajaxComplete(function() {
		$("#alert").fadeOut();
	});
	if ($.browser.mozilla) {
		$("#search-input").css("height", "23px");
	}
	$(window).scroll(function() {
		if ($(window).scrollTop() > 50) {
			$("#toolBackTo").fadeIn(500);
		}
		 else
		 {
			$("#toolBackTo").fadeOut(500);
		}
	});
	$("#toolBackTo").mouseover(function() {
		$("img.back-tip").show();
	}).mouseout(function() {
		$("img.back-tip").hide();
	});
	$("#apps-panel .popupwindow").mouseover(function() {
		$(this).addClass("actived");
	}).mouseout(function() {
		$(this).removeClass("actived");
	});
	$("#jump-panel .popupwindow strong").click(function() {
		$(this).closest(".popupwindow").toggleClass("actived");
		if ($(".mynotes #note_status").val() == "0") {
			$.post("/account/note", {
				act: "get"
			},
			function(data) {
				$(".mynotes #note_status").val(1);
			});
		}
	});
	$("a.login").click(function(event) {
		$("#login").toggle("slow").closest("li.login").toggleClass("active-trail");
		return false;
	});
	$("#search").focus(function() {
		$(this).closest("li.liserach").addClass("active-trail");
		$(".liserach .arrow_box").show(400);
	}).blur(function() {
		$(this).closest("li.liserach").removeClass("active-trail");
		$(".liserach .arrow_box").hide(300);
	})
	 $(document).click(function(e) {
		var $target = $(e.target);
		if ((!$target.closest('.note').length) && ($(".mynotes").css("display") != "none"))
		 $(".mynotes").closest(".popupwindow").removeClass("actived");
		if ((!$target.closest('.login').length) && ($("#login").css("display") != "none"))
		 $("#login").hide("1000").closest("li.login").removeClass("active-trail");
	});
	$("#logout").click(function(event) {
		if (!confirm('确定退出？'))
		 event.preventDefault();
	})
	 $("#bottombar table.ainfo td a[href*='#']").click(function(e) {
		thi = $(this);
		getinfo(e, thi)
	});
	h1 = $(".main1").height();
	h2 = $(".main2").height();
	if (h1 < h2)
	 $(".main1").animate({
		height: h2
	},
	"slow");
	else
	 $(".main2").animate({
		height: h1
	},
	"slow");
	$(".mynotes .add").click(function() {
		$("#add_dialog").show();
	});
//----------------------------------------------------笔记↓
	$("#add_dialog button[type=submit]").click(function() {
		var title = $("#note_title_add").val();
		var content = $("#note_content_add").val();
		$.post("/account/note", {
			act: "add",
			title: title,
			content: content
		},
		function(data) {
			$(data).each(function(i,v){
				$("#note_preview").append(v.t);
				$("#note_main").append(v.c);
			});
		});
	});
	$('a[href*=#]').click(function() {
		if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
			var $target = $(this.hash);
			$target = $target.length && $target || $('[name=' + this.hash.slice(1) + ']');
			if ($target.length) {
				var targetOffset = $target.offset().top;
				$('html,body').animate({
					scrollTop: targetOffset
				},
				500);
				return false;
			}
		}
	});
});
function abc() {
	$('html,body').animate({
		scrollTop: 10
	},
	500);
	return false;
}
 (function($) {
	$.extend({
		blinkTitle: {
			show: function() {
				var step = 0,
				_title = document.title;
				var timer = setInterval(function() {
					step++;
					if (step == 3) {
						step = 1
					};
					if (step == 1) {
						document.title = '【请查看新消息】'
					};
					if (step == 2) {
						document.title = '【新消息】' + _title
					};
				},
				500);
				return [timer, _title];
			},
			clear: function(timerArr) {
				if (timerArr) {
					clearInterval(timerArr[0]);
					document.title = timerArr[1];
				};
			}
		}
	});
})(jQuery);
function getnew(title) {
	$.ajax({
		url: "/message/getnew",
		async: false,
		cache: false,
		type: "POST",
		global: false,
		dataType: "json",
		beforeSend: function() {
			if (title)
			 $.blinkTitle.clear(timerArr);
		},
		success: function(json) {
			if (json != 0) {
				if (title) timerArr = $.blinkTitle.show();
				if (json >= 10)
				 $("#message-notice #notic").html('<img src="/image/number/m.png"/>');
				else
				 $("#message-notice #notic").html('<img src="/image/number/' + json + '.png"/>');
			}
			 else
			 $("#message-notice").children("span").html("");
		},
	});
};
$(function() {
	$("#message-notice").click(function() {
		$(this).children("span").html("");
		win = window.open('/message', 'message', 'alwaysRaised=yes,z-look=yes');
		win.focus();
	});
});
function getinfo(e, thi) {
	w = $(thi).closest(".window");
	$.post("/info/main", {
		q: $(thi).attr("href").substr(11)
	},
	function(data) {
		$(".info-container").children(".info").children("tbody").children("tr").children(".infot").html(data.t);
		$(".info-container").children(".info").children("tbody").children("tr").children(".infoc").html(data.c);
		$(".info-container a[href*='#']").click(function(e, thi) {
			thi = $(this);
			getinfo(e, thi);
		});
		$(".info-container").slideDown(300);
	});
	e.preventDefault();
}
//-------------------------------------------------------对象转JSON
function toJson(o) {
	var str = "";
	for (i in o)
	 str += '"' + i + '":"' + o[i] + '",';
	return "{" + str.slice(0, -1) + "}";
};
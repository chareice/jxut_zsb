$(function(){
		$("#toolBackTo").mouseover(function(){
		$("img.back-tip").show();
		}).mouseout(function(){$("img.back-tip").hide();});
		$(window).scroll(function(){
			if ($(window).scrollTop()>100){
				$("#toolBackTo").fadeIn(500);
				}
				else
				{
				$("#toolBackTo").fadeOut(500);
			}});
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
		
function abc(){
 $('html,body').animate({
                    scrollTop:10
                },
                500);
                return false;
}
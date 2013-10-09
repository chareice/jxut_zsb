/*                                                   ©2011-2012
 *  ■ ■ ■ ■ ■    ■         ■         ■          ■ ■ ■ ■      ■ ■ ■ ■ ■     ■ ■ ■ ■ ■    ■ ■ ■ ■ ■   ■ ■ ■ ■ ■
 * ■             ■         ■        ■ ■         ■       ■    ■                 ■       ■            ■
 * ■             ■         ■       ■   ■        ■       ■    ■                 ■       ■            ■
 * ■             ■ ■ ■ ■ ■ ■      ■     ■       ■ ■ ■ ■      ■ ■ ■ ■ ■         ■       ■            ■ ■ ■ ■ ■
 * ■             ■         ■     ■ ■ ■ ■ ■      ■ ■          ■                 ■       ■            ■ 
 * ■             ■         ■     ■       ■      ■    ■       ■                 ■       ■            ■
 *  ■ ■ ■ ■ ■    ■         ■     ■       ■      ■       ■    ■ ■ ■ ■ ■     ■ ■ ■ ■ ■    ■ ■ ■ ■ ■   ■ ■ ■ ■ ■ 
 */
$(document).ready(function(){
	$("#message-box").tabs();
    function sendmessage(message,j){
        $.ajax({
                url:"/message/send",
                type:"POST",
                data:{message:message,receive:j},
                success:function(){
						alert("发送成功")},
        });
    }   
    var j = new Array();
    
    $("#send").click(function(){        //发消息
        $(":checkbox:checked").each(function(i,e){  
            var receive = $(this).val();  
            j[i]= receive;
        });  
        var message=$("textarea.message").val();
        sendmessage(message,j);
    });
    function dateplus(data){
        if(data.length==1)
            data = "0"+data;
        return data;
    }
    function datechange(da){//转换时间
        date = new Date();
        date.setTime(da*1000);
        month = dateplus((date.getMonth() + 1).toString());
        day = dateplus(date.getDate().toString());
        hours = dateplus(date.getHours().toString());
        min = dateplus(date.getMinutes().toString());
        return month+"-"+day+" "+hours+":"+min;
    };
    function getmsgloop(){
        getnew(true);
    }
    setInterval(getmsgloop,60000);
    getmsg();
    $("#message-box ul li span.getin").click(function(){
        getmsg();
    });
    $("#message-box ul li span.getout").click(function(){
        getout();
    });
    function getout(pages){
        if(!pages)
            pages = 1;
        $.ajax({
        url:"/message/getout",
        type:"POST",
        cache:false,
        data:{page:pages},
        success:function(data){
            $("#out-message").html("");
            $.each(data,function(k,v){
                if(v.page){
                    $("#out-message")
                    .append('<footer class="out-footer">\
                                <input type="hidden" class="page" value="'+v.page+'"/>\
                                <section class="gotopage"></section>\
                            </footer>');
                    $("#out-message footer.out-footer").append('<span class="details">'+v.page+'\/'+v.pagesum+'</span>');
                    if(v.pagesum == 1)
						;
					else if(v.page==1)
                        $("#out-message footer.out-footer .gotopage").html('<span class="next">下一页</span>');
                    else if(v.page==v.pagesum)
                    $("#out-message footer.out-footer .gotopage").html('<span class="last">上一页</span>')
                    else
                    $("#out-message footer.out-footer .gotopage").html('<span class="last">上一页</span>|<span class="next">下一页</span>')
                }
                else
                $("#out-message").append('<article class="omsg clearfix">\
                                            <header>\
                                                <time>'+datechange(v.t)+'</time>\
                                                <input class="msg_id" type="hidden" value="'+v.i+'">\
												<span class="spe">消息报告</span>\<span class="del" style="display:none;">删除</span>\
                                                \
                                            </header>\
                                            <section>\
                                                <p>'+v.m+'</p>\
                                            </section>\
                                          </article>');
            });
            $("#view-status").dialog({ 
                autoOpen:false,
                height: 350,
                width: 350,
                modal: true,
                buttons: { 
                        确定: function() {
                                $( this ).dialog( "close" );
                        }
                } });
            $("article.omsg header span").css("cursor","pointer");
            $("article.omsg header span.spe").click(function(){
                msg_id = $(this).parent().children("input.msg_id").val();
                
                //bind('dialogopen',function(){
                    now = $(this);
                    $.ajax({
                        url:"/message/getstatus",
                        type:"POST",
                        cache:false,
                        data:{msg_id:msg_id},
                        success:function(data){
                            $("#view-status").html("");
                            $.each(data,function(k,v){
                                if(v.s=='V'||v.s=='D')
                                    status = "已读"
                                else
                                    status = "未读"
                                $("#view-status").append("<li>"+v.n+"--------"+status+"</li>")
                            });
                            $("#view-status").dialog('open');
                            }
                        });
                    //});
            });
			$("article.omsg header span").mouseover(function(){
                $(this).parent().children("span.del").show();
            }).mouseout(function(){$(this).parent().children("span.del").hide();});
			
			$("article.omsg header span.del").click(function(){
                msg_id = $(this).parent().children("input.msg_id").val();
				now = $(this).parent().parent();
				if(confirm('确定删除？不可恢复')){
                    $.ajax({
                        url:"/message/setdel",
                        data:{msg_id:msg_id},
                        async:false,
                        cache:false,
                        type:"POST",
                        global:false,
                        success:function(){
                            page = $(".out-footer input.page").val();
                            now.effect("puff",500);
                            getout(page);
                        },
                    });
                }
			});
			
            $("#out-message footer.out-footer .gotopage span.next").click(function(){//分页
                page = $(".out-footer input.page").val();
                getout(++page);
            });
            $("#out-message footer.out-footer .gotopage span.last").click(function(){//分页
                page = $(".out-footer input.page").val();
                getout(--page);
            });
        }
        });
    }
    //↓在in-message中构建HTML架构的主要函数↓
    function getmsg(pages){ 
        if(!pages)
            pages = 1;
        $.ajax({
        url:"/message/getmsg",
        type:"POST",
        cache:false,
        data:{page:pages},
        success:function(data){
            $("#in-message").html("");
            //getnew();
            $.each(data,function(k,v){
                if(v.page){
                    $("#in-message")
                    .append('<footer class="in-footer">\
                                <input type="hidden" class="page" value="'+v.page+'"/>\
                                <section class="gotopage"></section>\
                            </footer>');
                    $("#in-message footer.in-footer").append('<span class="details">'+v.page+'\/'+v.pagesum+'</span>');
                    if(v.pagesum == 1)
						;
					else if(v.page==1)
                        $("#in-message footer.in-footer .gotopage").html('<span class="next">下一页</span>');
                    else if(v.page==v.pagesum)
                    $("#in-message footer.in-footer .gotopage").html('<span class="last">上一页</span>')
                    else
                    $("#in-message footer.in-footer .gotopage").html('<span class="last">上一页</span>|<span class="next">下一页</span>')
                }
                else
                $("#in-message")
                .append('<article class="amsg clearfix">\
                            <header>\
                                <input class="msg_status" type="hidden" value="'+v.msg_status+'"/>\
                                <input class="from_id" type="hidden" value="'+v.from_id+'"/>\
                                <input class="msg_to_id" type="hidden" value="'+v.msg_to_id+'">\
                                <span class="from">'+v.realname+'</span>\
                                <input class="toggle" style="display:none" type="button" value="置为已读"/>\
                                <time>'+datechange(v.msg_created)+'</time>\
                            </header>\
                            <section class="content">\
                                <p>'+v.message+'</p>\
                            </section>\
                            <footer>\
                                <p class="reply">'+"回复"+'</p><p class="del" style="display:none">'+"删除"+'</p>\
                            </footer>\
                         </article>');
            });
            
            $("article.amsg").each(function(){
                if($(this).children("header").children("input.msg_status").val()=="N"){
                    $(this).addClass("newmsg").children("header").children("input.toggle").show();
                }
            });
            $("article.newmsg").effect( "slide",500);
            $("article.newmsg header span").effect("pulsate",300);
            $("#in-message footer.in-footer .gotopage span.next").click(function(){//分页
                page = $(".in-footer input.page").val();
                getmsg(++page);
            });
            $("#in-message footer.in-footer .gotopage span.last").click(function(){//分页
                page = $(".in-footer input.page").val();
                getmsg(--page);
            });
            $("article.amsg footer p.reply").click(function(){
            now = $(this);
            $("#comment").dialog({ 
                height: 350,
                width: 350,
                modal: true,
                buttons: { 
                        发送: function() {
                                message = $("#comment textarea").val();
                                var j = new Array();
                                j[0]=now.parent().parent().children("header").children("input.from_id").val();
                                sendmessage(message,j);
                                $( this ).dialog( "close" );
                        },
                        取消: function() {
                                $( this ).dialog( "close" );
                        }
                } });
            });
            $("article.amsg footer p.del").click(function(){
            var now = $(this).parent().parent();
            var msg_to_id = $(this).parent().parent().children("header").children("input.msg_to_id").val();
                if(confirm('确定删除？不可恢复')){
                    $.ajax({
                        url:"/message/setstatus",
                        data:{msg_to_id:msg_to_id,act:"del"},
                        async:false,
                        cache:false,
                        type:"POST",
                        global:false,
                        success:function(){
                            page = $(".in-footer input.page").val();
                            now.effect("puff",500);
                            getmsg(page);
                        },
                    });
                }
            });
            /*$("article.amsg").mouseover(function(){
                $(this).children("footer").children("p.reply").show();
            }).mouseout(function(){$(this).children("footer").children("p.reply").hide();});*/
            
            $("article.amsg footer").mouseover(function(){
                $(this).children("p.del").show();
            }).mouseout(function(){$(this).children("p.del").hide();});
            $("#in-message article.newmsg header input.toggle").click(function(){
                var now = $(this).parent().parent();
                var msg_to_id = $(this).parent().children("input.msg_to_id").val();
                $.ajax({
                    url:"/message/setstatus",
                    data:{msg_to_id:msg_to_id,act:"view"},
                    async:false,
                    cache:false,
                    type:"POST",
                    global:false,
                    success:function(){
                        now.removeClass("newmsg");
                        now.children("header").children("input.toggle").effect("explode");
                        getmsgloop();
                    },
                });
            });
        },
    });
    }
});

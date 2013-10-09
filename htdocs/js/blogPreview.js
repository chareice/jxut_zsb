Event.observe(window, 'load', function() {

    var publishButton   = $('status-publish');
    var unpublishButton = $('status-unpublish');
    var deleteButton    = $('status-delete');

    if (publishButton) {
        publishButton.observe('click', function(e) {
            if (!confirm('点击确定 发布新闻'))
                Event.stop(e);
        });
    }

    if (unpublishButton) {
        unpublishButton.observe('click', function(e) {
            if (!confirm('点击确定 下线新闻'))
                Event.stop(e);
        });
    }

    if (deleteButton) {
        deleteButton.observe('click', function(e) {
            if (!confirm('点击确定 删除新闻'))
                Event.stop(e);
        });
    }
});

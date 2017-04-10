function resizeIframe(iframeID) {   

    var iframe = $('#' + iframeID, window.parent.document);

    var contentIframe = $('#contentIframe').innerHeight();
    $(iframe).attr('height', (contentIframe+50) + 'px');            

} 

$('.search-button').click(function () {
    var content = $(this).text();
    if (content == 'Hide') {
        $(this).html('Show');
    } else {
        $(this).html('Hide');
    }

    $(this).parent().parent().find('.panel-body').toggle();
    return false;
});


$('.search-form form').submit(function () {
    var gridId = $('.grid-view').attr('id');
    $.fn.yiiGridView.update(gridId, {
        url: $(this).attr('action'),
        data: $(this).serialize()
    });

    console.log(gridId);
    console.log($(this).serialize());
    return false;
});

$('#clearsearch').click(function () {
    var id = 'search-form';
    var inputSelector = '#' + id + ' input, ' + '#' + id + ' select';
   $(inputSelector).each(function (i, o) {
		if($(o).attr('type') != 'hidden') {
			$(o).val('');
		}
   });
    var data = $.param($(inputSelector));
    var gridId = $('.grid-view').attr('id');
    $.fn.yiiGridView.update(gridId, {data: data});
    return false;
});

$('.deleteall-button').click(function (e) {
    e.preventDefault();
    var gridId = $('.grid-view').attr('id');
    var actionUrl = $(this).attr('href');
    var atLeastOneIsChecked = $('input[name=\"' + gridId + '_c0[]\"]:checked').length > 0;
    if (!atLeastOneIsChecked)
    {
        alert('Please select at least one record to delete');
    }
    else if (window.confirm('Are you sure you want to delete the selected records?'))
    {
        var formObj = $('.grid-view').closest('form');
        if (formObj)
        {
            document.getElementById(formObj.attr('id')).action = actionUrl;
            document.getElementById(formObj.attr('id')).submit();
        }
    }
});


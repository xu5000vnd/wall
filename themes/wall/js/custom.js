function resizeIframe(iframeID) {   

    var iframe = $('#' + iframeID, window.parent.document);

    var contentIframe = $('#contentIframe').innerHeight();
    $(iframe).attr('height', (contentIframe+50) + 'px');            

} 
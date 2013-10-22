function gotoback(url)
{
    window.location.href=url;
}
function remove(message, url)
{
    if(!confirm(message)) return;
	
    window.location.href=url;
	
    return;
}
function popupWindow(mypage, myname, w, h, scroll) {
    var winl = (screen.width - w) / 2;
    var wint = (screen.height - h) / 2;
    winprops = 'height='+h+',width='+w+',top='+wint+',left='+winl+',scrollbars='+scroll+',resizable'
    win = window.open(mypage, myname, winprops)
    if (parseInt(navigator.appVersion) >= 4) {
        win.window.focus();
    }
}

function dosubmit(formId, actionURL)
{
    var f = document.getElementById(formId);
    f.action = actionURL;
    return f.submit();
}
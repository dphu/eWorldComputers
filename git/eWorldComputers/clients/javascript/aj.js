//from admin config
function clearBlock(containerID)
{
    var container = getContainerID(containerID);
	
    if (container) {
        container.innerHTML = '';
        container.style.display = 'none';
    }
}
function getBlock(containerID, blockID, protectdata)
{
    var container = getContainerID(containerID);
	
    if (!container) {
        return;
    }

    container.style.display = '';
    if (!protectdata) {
        container.innerHTML = 'loading...';//<img src="images/loading.gif" />';
    }   
	
    if (document.getElementById) {
        var e = window.ActiveXObject ? new ActiveXObject("Microsoft.XMLHTTP") : new XMLHttpRequest();
    }
	
    if (e) {
        e.onreadystatechange = function()
        {
            if (e.readyState == 4 && e.status == 200) {
                container.innerHTML = e.responseText;
            }
        }
    }
	
    e.open("POST", 'getblock.php', true);
    e.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    e.send('blockid='+blockID);
}

//show data co san.... (disbled)
function getBlockEx(containerID, sid)
{
    var container = getContainerID(containerID);

    if (!container) {
        //alert('The container "'+containerID+'" does not exist!');
        return;
    }

    container.style.display = '';
    container.innerHTML = '<img src="images/loading.gif" />';
	
    if (document.getElementById) {
        var e = window.ActiveXObject ? new ActiveXObject("Microsoft.XMLHTTP") : new XMLHttpRequest();
    }
	
    if (e) {
        e.onreadystatechange = function()
        {
            if (e.readyState == 4 && e.status == 200) {
                container.innerHTML = e.responseText;
            }
        }
    }
	
    e.open("POST", 'getblockex.php', true);
    e.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    e.send('sid='+sid);
	
    document.getElementById('mainbody').scrollTop = 0;
}



//nap module theo yeu cau...
var capchaidx = 0;
function loadModule(moduleName, param, containerID, sid, noSavePostBack, u)
{
    if(!u&&t(moduleName,param,containerID))return;
	
    noSavePostBack = noSavePostBack ? 1 : 0;
    var container = getContainerID(containerID);

    if (!container) {
        //alert('The container "'+containerID+'" does not exist!');
        return;
    }

    container.style.display = '';
    container.innerHTML = 'loading...';//'<img src="images/loading.gif" />';
	
    if (document.getElementById) {
        var e = window.ActiveXObject ? new ActiveXObject("Microsoft.XMLHTTP") : new XMLHttpRequest();
    }
	
    if (e) {
        e.onreadystatechange = function()
        {
            if (e.readyState == 4 && e.status == 200) {
                container.innerHTML = e.responseText;
                loadTitle();
                if (moduleName == 'xemchittietnhadat') {
                    var imgcapcha = getContainerID('img-capcha');
                    if (imgcapcha) {
                        imgcapcha.src = 'php_captcha.php';
                    } 
                }
            }
        }
    }
	
    e.open("POST", 'loadmodule.php', true);
    e.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    e.send('moduleName='+moduleName+'&param='+param+'&containerID='+containerID/*+'&sid='+sid*/+'&noSavePostBack='+noSavePostBack);
	
    if (moduleName != 'chonhuyen' && moduleName != 'videoclip') {
        document.getElementById('mainbody').scrollTop = 0;
    }
}

function reloadcapcha()
{/*return;
	var imgcapcha = getContainerID('img-capcha');
	if (!imgcapcha) {
		return;
	} 
	
	var e = window.ActiveXObject ? new ActiveXObject("Microsoft.XMLHTTP") : new XMLHttpRequest();
	e.onreadystatechange = function()
							{
								if (e.readyState == 4 && e.status == 200) {
									imgcapcha.src = e.responseText;
								}
							}
	e.open("POST", 'php_captcha.php', true);
	e.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	e.send(null);*/
}

function delcapcha()
{/*return;
	if (document.getElementById) {
		var e = window.ActiveXObject ? new ActiveXObject("Microsoft.XMLHTTP") : new XMLHttpRequest();
	}	
	
	e.open("POST", 'delcapcha.php', true);
	e.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	e.send(null);*/
}

function getContainerID(containerID)
{
    return document.getElementById(containerID);
}

////////////////////// online ////////////////////////////
function whoonline()
{
    var container = getContainerID('whoonline');
	
    if (!container) {
        setTimeout("whoonline()", 2000);
        return;
    }

    setTimeout("whoonline()", 20000);

    if (container.innerHTML == '{whoonline}') container.innerHTML = 'loading...';

    if (document.getElementById) {
        var e = window.ActiveXObject ? new ActiveXObject("Microsoft.XMLHTTP") : new XMLHttpRequest();
    }
	
    if (e) {
        e.onreadystatechange = function()
        {
            if (e.readyState == 4 && e.status == 200) {
                container.innerHTML = e.responseText;
            }
        }
    }
	
    e.open("POST", 'loadmodule.php', true);
    e.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    e.send('moduleName=getwhoonline&param=0&containerID=whoonline&noSavePostBack=1');
	
}
////////////////////// visitor ////////////////////////////
function visitor()
{
    var container = getContainerID('visitor');
	
    if (!container) {
        setTimeout("visitor()", 2000);
        return;
    }

    setTimeout("visitor()", 20000);

    if (container.innerHTML == '{visitor}') container.innerHTML = 'loading...';

    if (document.getElementById) {
        var e = window.ActiveXObject ? new ActiveXObject("Microsoft.XMLHTTP") : new XMLHttpRequest();
    }
	
    if (e) {
        e.onreadystatechange = function()
        {
            if (e.readyState == 4 && e.status == 200) {
                container.innerHTML = e.responseText;
            }
        }
    }
	
    e.open("POST", 'loadmodule.php', true);
    e.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    e.send('moduleName=getvisitor&param=0&containerID=visitor&noSavePostBack=1');
}
////////////////////// bao dong 1 - 2  ////////////////////////////
function baodong(id, type, msg)
{
    if (document.getElementById) {
        var e = window.ActiveXObject ? new ActiveXObject("Microsoft.XMLHTTP") : new XMLHttpRequest();
    }
	
    e.open("POST", 'loadmodule.php', true);
    e.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    e.send('moduleName=baodong&param='+id+'|'+type+'&containerID=none&noSavePostBack=1');
	
    alert(msg);
}

function loadTitle()
{
    //setTimeout("loadTitle()", 5000);
	
    if (document.getElementById) {
        var e = window.ActiveXObject ? new ActiveXObject("Microsoft.XMLHTTP") : new XMLHttpRequest();
    }
	
    if (e) {
        e.onreadystatechange = function()
        {
            if (e.readyState == 4 && e.status == 200) {
                document.title = e.responseText;
            }
        }
    }
	
    e.open("POST", 'loadtitle.php', true);
    e.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    e.send(null);
}

t=function(m,p,c){
    var l=new Array();
    try{
        l=modulesList.split(',');
    }catch(e){
        return 0;
    }
    for(var i=0;i<l.length;i++)if(m==l[i]){
        window.location.href='index.php?u='+m+','+p+','+c;
        return 1;
    }
    return 0;
}
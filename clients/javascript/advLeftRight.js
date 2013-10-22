window.onresize = ShowAdDiv;
	
function FloatTopDiv()
{
    var ns = (navigator.appName.indexOf("Netscape") != -1);
    if(!ns)
    {
        startLX = ((document.body.clientWidth -1230)/2) + 115 , startLY = 5;
        startLX = 0;
        //startRX = ((document.body.clientWidth -770)/2) + 770 +2 , startRY = 62;
        startRX = ((document.body.clientWidth)/2) + 390 , startRY = 5;
    }
    else
    {
        startLX = ((document.body.clientWidth -1230)/2) + 112 , startLY = 5;
        startRX = ((document.body.clientWidth)/2) + 390 , startRY = 5;
    }

    var d = document;
    function ml(id)
    {
        var el=d.getElementById?d.getElementById(id):d.all?d.all[id]:d.layers[id];
        el.sP=function(x,y){
            this.style.left=x;
            this.style.top=y;
        };
        el.x = startRX;
        el.y = startRY;
        return el;
    }
    function m2(id)
    {
        var e2=d.getElementById?d.getElementById(id):d.all?d.all[id]:d.layers[id];
        e2.sP=function(x,y){
            this.style.left=x;
            this.style.top=y;
        };
        e2.x = startLX;
        e2.y = startLY;
        return e2;
    }
    window.stayTopLeft=function()
    {
        if (document.documentElement && document.documentElement.scrollTop)
            var pY =  document.documentElement.scrollTop;
        else if (document.body)
            var pY =  document.body.scrollTop;
        if (document.body.scrollTop > 30){
            startLY = 3;
            startRY = 3;
        } else {
            startLY = 5;
            startRY = 5;
        };
        ftlObj.y += (pY+startRY-ftlObj.y)/16;
        ftlObj.sP(ftlObj.x, ftlObj.y);
        ftlObj2.y += (pY+startLY-ftlObj2.y)/16;
        ftlObj2.sP(ftlObj2.x, ftlObj2.y);
        setTimeout("stayTopLeft()", 1);
    }
    ftlObj = ml("divAdRight");
    //stayTopLeft();
    ftlObj2 = m2("divAdLeft");
    stayTopLeft();
}
	
function ShowAdDiv()
{
    var objAdDivRight = document.getElementById("divAdRight");
    var objAdDivLeft = document.getElementById("divAdLeft");
    if (document.body.clientWidth < 980)
    {
        objAdDivRight.style.display = "none";
        objAdDivLeft.style.display = "none";
    }
    else
    {
        objAdDivRight.style.display = "block";
        objAdDivLeft.style.display = "block";
        FloatTopDiv();
    }
}
ShowAdDiv();
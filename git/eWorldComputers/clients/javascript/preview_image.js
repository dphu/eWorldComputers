<!--

Xoffset= -200;    // modify these values to ...
Yoffset= +20;    // change the popup position.

var old,skn,iex=(document.all),yyy=-1000;

var ns4=document.layers
var ns6=document.getElementById&&!document.all
var ie4=document.all

if (ns4)
    skn=document.dek
else if (ns6)
    skn=document.getElementById("dek").style
else if (ie4)
    skn=document.all.dek.style
if(ns4)document.captureEvents(Event.MOUSEMOVE);
else{
    skn.visibility="visible"
    skn.display="none"
}
document.onmousemove=get_mouse;

function popup(msg,bak,x_offset,y_offset){
    //msg = eval(msg);
    if (msg != ""){
        msg = "<img src=\"" + msg + "\" border=0 width='200'>"
    }else{
        x_offset = +2;
        y_offset = +20;
        msg = "none"
    }
	
    var content="<TABLE bgcolor=#000000 Width=100 CELLPADDING=0 CELLSPACING=1 "+
    "BGCOLOR="+bak+"><TD ALIGN=left bgcolor=white><FONT COLOR=black SIZE=1>"+msg+"</FONT></TD></TABLE>";
    yyy=Yoffset;
    if(ns4){
        skn.document.write(content);
        skn.document.close();
        skn.visibility="visible"
        }
    if(ns6){
        document.getElementById("dek").innerHTML=content;
        skn.display=''
        }
    if(ie4){
        document.all("dek").innerHTML=content;
        skn.display=''
        }
    Xoffset = x_offset;
    Yoffset = y_offset;
}

function get_mouse(e){
    //alert("a");
    var x=(ns4||ns6)?e.pageX:event.x+document.body.scrollLeft;
    skn.left= x+Xoffset;
    var y=(ns4||ns6)?e.pageY:event.y+document.body.scrollTop;
    skn.top= y+yyy;
	
}

function kill(){
    yyy=-1000;
    if(ns4){
        skn.visibility="hidden";
    }
    else if (ns6||ie4)
        skn.display="none"
}

function preview_image(path){																			

    var msg;
    var bak = "#FFFFFF";	
    for(i=0; i<path.length; i++){
        if(path.charAt(i)=="\\"){					
            path=path.replace("\\","/");
        }
    }
    msg=path;
			
			
    popup(msg,bak,-210,-70);			
};				

//-->

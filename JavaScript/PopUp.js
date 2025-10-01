<DIV ID="dek"></DIV>

<SCRIPT TYPE="text/javascript">
<!--

//Pop up information box II (Mike McGrath (mike_mcgrath@lineone.net,  https://website.lineone.net/~mike_mcgrath))
//Permission granted to Dynamicdrive.com to include script in archive
//For this and 100's more DHTML scripts, visit https://dynamicdrive.com

Xoffset=-60;    // modify these values to ...
Yoffset= -30;    // change the popup position.

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

function popup(msg,bak){

if (msg.length >= 1 && msg.length < 21)
{
    Xoffset= -90;
    Yoffset= -25;
    WIDTH  =  151;
}

else if (msg.length >= 21 && msg.length < 50)
{
    Xoffset= -90;
    Yoffset= -40;
    WIDTH  =  200;
}
else if (msg.length >= 50 && msg.length < 130)
{
    Xoffset= -130;
    Yoffset= -40;
    WIDTH  =  350;

}
else if (msg.length >= 130 && msg.length < 301)
{
    Xoffset= -250;
    Yoffset= -60;
    WIDTH  =  600;
}
else if (msg.length >= 301 && msg.length < 501)
{
    Xoffset= -290;
    Yoffset= -90;
    WIDTH  =  650;
}
var content="<TABLE  WIDTH="+WIDTH+" BORDER=1 BORDERCOLOR=black CELLPADDING=1 CELLSPACING=0 "+
"BGCOLOR="+bak+"><TD ALIGN=center><FONT COLOR=black SIZE=1>"+msg+"</FONT></TD></TABLE>";
yyy=Yoffset;
 if(ns4){skn.document.write(content);skn.document.close();skn.visibility="visible"}
 if(ns6){document.getElementById("dek").innerHTML=content;skn.display=''}
 if(ie4){document.all("dek").innerHTML=content;skn.display=''}
}

function get_mouse(e){
var x=(ns4||ns6)?e.pageX:event.x+document.body.scrollLeft;
skn.left=x+Xoffset;
var y=(ns4||ns6)?e.pageY:event.y+document.body.scrollTop;
skn.top=y+yyy;
}

function kill(){
yyy=-1000;
if(ns4){skn.visibility="hidden";}
else if (ns6||ie4)
skn.display="none"
}
//-->
</SCRIPT>
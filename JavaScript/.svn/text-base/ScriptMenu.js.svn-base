<!--

document.WM = new Object();
document.WM.menu = new Object();
document.WM.menu.dropdown = new Array();

function WM_initializeToolbar()
{
    var i;
    if (document.all)
    {
        for(i = 0; i < document.all('container').all.length; i++)
            if ((document.all('container').all[i].className == 'header') ||(document.all('container').all[i].className == 'links'))
                document.WM.menu.dropdown[document.WM.menu.dropdown.length] = document.all('container').all[i];
    }
    else
    {
        if (document.getElementsByTagName && document.getElementById)
        {
            var contained = document.getElementById('container').getElementsByTagName('div');
            for(i = 0; i < contained.length; i++)
                if ((contained[i].getAttribute('class') == 'header') ||(contained[i].getAttribute('class') == 'links'))
                    document.WM.menu.dropdown[document.WM.menu.dropdown.length] = contained[i];
        }
    }
}

function WM_collapse(item)
{
    if(document.WM.menu.dropdown.length)
    {
        if (document.WM.menu.dropdown[item + 1].style.display == 'none')
            document.WM.menu.dropdown[item + 1].style.display = '';
        else
            document.WM.menu.dropdown[item + 1].style.display = 'none';
    }
}

function mOvr(src,clrOver) 
{
    if (!src.contains(event.fromElement))
    {
        src.style.cursor = 'hand';
        src.bgColor = clrOver;
    }
}

function mOut(src,clrIn)
{
    if (!src.contains(event.toElement))
    {
        src.style.cursor = 'default';
        src.bgColor = clrIn;
    }
}

function mOvrf(src,clrOver) 
{
    if (!src.contains(event.fromElement))
    {
        src.style.cursor = 'hand';
        src.Color = clrOver;
    }
}

function mOutf(src,clrIn)
{
    if (!src.contains(event.toElement))
    {
        src.style.cursor = 'default';
        src.Color = clrIn;
    }
}
-->

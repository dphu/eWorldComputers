// JavaScript Document

function isnumber(s)
{
    while(s.length)
    {
        switch(s.substring(0,1))
        {
            case '0':
                break;
            case '1':
                break;
            case '2':
                break;
            case '3':
                break;
            case '4':
                break;
            case '5':
                break;
            case '6':
                break;
            case '7':
                break;
            case '8':
                break;
            case '9':
                break;
            default:
                return false;
        }
        s=s.substring(1,s.length);
    }
    return true;
}

function check_number(textbox, default_value)
{
    if(!isnumber(textbox.value))
    {
        alert('Chi duoc nhap gia tri so!');
        textbox.value=default_value;
        textbox.select();
        return false;
    }
    return true;
}

function trimAll(sString) 
{
    while (sString.substring(0,1) == ' ')
    {
        sString = sString.substring(1, sString.length);
    }
    while (sString.substring(sString.length-1, sString.length) == ' ')
    {
        sString = sString.substring(0,sString.length-1);
    }
    return sString;
}

function is_empty(obj) // obj la textbox hoac textare
{
    if(trimAll(obj.value)=='') 
        return true;
    else
        return false;    
}
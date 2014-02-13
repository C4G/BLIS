/************************************
(C) Toni Bennasar 2007
http://chmprocessor.sf.net
Under GPL license.

Miscelaneous functions.

*************************************/

function safeUnescape( text ) {
    try {
        return decodeURIComponent(text);
    }
    catch( ex ) {
        return unescape(text);
    }
}

function getURLParam( url , strParamName ){

	var strReturn = "";
	var strHref = url;
	if ( strHref.indexOf("?") > -1 ){
		var strQueryString = strHref.substr(strHref.indexOf("?"))/*.toLowerCase()*/;
		var aQueryString = strQueryString.split("&");
		for ( var iParam = 0; iParam < aQueryString.length; iParam++ ) {
			if ( aQueryString[iParam].indexOf(strParamName/*.toLowerCase()*/ + "=") > -1 ) {
				var aParam = aQueryString[iParam].split("=");
				strReturn = aParam[1];
				break;
			}
		}
	}
	//return unescape(strReturn);
	//return decodeURIComponent(strReturn);
	return safeUnescape(strReturn);
}

function getURLParamCurrentWindow( strParamName ){
	var strHref = window.location.href;
	return getURLParam( strHref , strParamName );
}

function stopEvent(e) {
    if (!e) e = window.event;
    if (e.stopPropagation) {
        e.stopPropagation();
    } else {
        e.cancelBubble = true;
    }
}

function cancelEvent(e) {
    if (!e) e = window.event;
    if (e.preventDefault) {
        e.preventDefault();
    } else {
        e.returnValue = false;
    }
}


function startsWith( str , startStr ) {
    return str.indexOf( startStr ) == 0;
}

function endsWith( str , endStr ) {
    var endIndex = str.length - endStr.length;
    if( endIndex < 0 )
        return false;
    return str.indexOf( endStr ) == endIndex;
}


function lastIndexOf( character , text ) {
    for( i= (text.length-1) ; i>=0; i-- ) {
        if( text.charAt( i ) == character )
            return i;
    }
    return -1;
}

function getPageTitle( url ) {
    idx = lastIndexOf( '/' , url );
    if( idx >= 0 )
        return url.substring( idx + 1 );
    else
        return url;
}

// Convert a strin to another in lowercase and without strange characters (á,â,ä, etc.)
function normalizeString( str ) {
    var lower = str.toLowerCase();
    var result = "";
    for( var i=0; i<lower.length; i++ ) {
        var c = lower.charAt(i);
        switch( c ) {
            case 'á':
            case 'à':
            case 'ä':
            case 'â':
                c = 'a';
                break;
            case 'é':
            case 'è':
            case 'ë':
            case 'ê':
                c = 'e';
                break;
            case 'í':
            case 'ì':
            case 'ï':
            case 'î':
                c = 'i';
                break;
            case 'ó':
            case 'ò':
            case 'ö':
            case 'ô':
                c = 'o';
                break;
            case 'ú':
            case 'ù':
            case 'ü':
            case 'û':
                c = 'u';
                break;
        }
        result += c;
    }
    return result;
}

function f_clientWidth() {
	return f_filterResults (
		window.innerWidth ? window.innerWidth : 0,
		document.documentElement ? document.documentElement.clientWidth : 0,
		document.body ? document.body.clientWidth : 0
	);
}
function f_clientHeight() {
	return f_filterResults (
		window.innerHeight ? window.innerHeight : 0,
		document.documentElement ? document.documentElement.clientHeight : 0,
		document.body ? document.body.clientHeight : 0
	);
}

function f_filterResults(n_win, n_docel, n_body) {
	var n_result = n_win ? n_win : 0;
	if (n_docel && (!n_result || (n_result > n_docel)))
		n_result = n_docel;
	return n_body && (!n_result || (n_result > n_body)) ? n_body : n_result;
}

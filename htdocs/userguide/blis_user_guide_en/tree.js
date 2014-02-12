
/************************************
(C) Toni Bennasar 2007
http://chmprocessor.sf.net
Under GPL license.

Functions to create a content tree for many web pages.

*************************************/

var contentTree = new Object();

contentTree.pageloaded = function() {

    // Get the title of the loaded page:
    pageRelativeUrl = getPageTitle( contentTree.frame.contentWindow.document.location.href )
    
    // Search the link to this page
    node = contentTree.seachLinkByHref( pageRelativeUrl );
    if( node == "" ) {
        // Try to search by the page title, without internal reference:
        idx = pageRelativeUrl.indexOf( "#" )
        if( idx >= 0 )
            pageRelativeUrl = pageRelativeUrl.substring( 0 , idx );
        
        node = contentTree.seachLinkByFileTitle( pageRelativeUrl );
    }
    
    if( node != "" ) {
        // If its found, select it over the tree:
        contentTree.selectLink( node , true , false );
    }
}

// Initializes the tree.
// tree : UL element that contains the tree
// frame: The frame that will contain the topic pages.
// url: Input URL of the page.
contentTree.create = function( tree , contentFrame , url ) {

	// Store ref to tree elements:
	contentTree.frame = contentFrame;
	contentTree.tree = tree;
	contentTree.selectedLink = "";

	// Change the links to open his ref into the iframe
	contentTree.links = tree.getElementsByTagName("a");

	// Create click events for the links:
	for (var i=0; i<contentTree.links.length; i++) {
		contentTree.links[i].onclick = function(e){
			contentTree.frame.src = this.href;
			contentTree.selectLink( this , false , true );
			//e.stopPropagation();
			stopEvent(e);
			return false;
		}
	}

	// Prepare all the submenus
	var submenus = tree.getElementsByTagName("ul");
	for( var i=0; i< submenus.length; i++ ) {
		var sb = submenus[i];
		sb.parentNode.className="submenu";
		sb.setAttribute("status", "closed");

		// click open the submenu:
		sb.parentNode.onclick = function(e) {
			var ulChild=this.getElementsByTagName("ul")[0];
			if( ulChild.getAttribute("status") == "closed" ) {
				contentTree.openUlElement( ulChild );
			}
			else if( ulChild.getAttribute("status") == "open" ) {
				ulChild.style.display="none";
				ulChild.setAttribute("status", "closed");
				this.style.backgroundImage="url(more.gif)";
			}
			//e.stopPropagation();
			stopEvent(e);
		}
		// To avoid events when the submenu items are pressed.
		sb.onclick=function(e){
			//e.stopPropagation();
			stopEvent(e);
		}
	}

	// Load the default page, or the selected topic page:
	var topic = getURLParam( url , "topic");
	var topicLink = "";
	if( topic != "" )
		topicLink = contentTree.seachLinkByTitle( topic );
	if( topicLink != "" )
		contentTree.selectLink( topicLink , true , true );
	else if( contentTree.links.length > 0 )
		contentTree.selectLink( contentTree.links[0] , true , true );

    // When an internal link is clicked follow the selection at the tree:
    contentFrame.onload_1 = function(){ contentTree.pageloaded(); }
    
}

contentTree.openUlElement = function( ulElement ) {
	if( ulElement.getAttribute("status") == "closed" ) {
		ulElement.style.display="block";
		ulElement.setAttribute("status", "open");
		ulElement.parentNode.style.backgroundImage="url(less.gif)";
	}
}

contentTree.selectUrl = function( url ) {
    var lnk = contentTree.seachLinkByHref( url );
    if( lnk == "" )
        // URL not found
        contentTree.frame.src = url
    else
        contentTree.selectLink( lnk , true , true );
}

contentTree.selectLink = function( lnkObject , expandTree , loadContentFrame ) {

	if( contentTree.selectedLink != "" )
		contentTree.selectedLink.style.backgroundColor = contentTree.notSelectedBg ;
	else
		contentTree.notSelectedBg = lnkObject.style.backgroundColor;
		
	if( loadContentFrame )
	    contentTree.frame.src = lnkObject.href;
	
	contentTree.selectedLink = lnkObject;
	lnkObject.style.backgroundColor = "cyan" ;

	if( expandTree ) {
		var ulElement = lnkObject.parentNode.parentNode;
		while( ulElement != contentTree.tree ) {
			contentTree.openUlElement( ulElement );
			ulElement = ulElement.parentNode.parentNode;
		}
	}
}

// Search a link into the tree by his text:
contentTree.seachLinkByTitle = function( strTitle ) {
    var strTitleLower = strTitle.toLowerCase()
	for (var i=0; i<contentTree.links.length; i++) {
	
	    // Get the text of the link, without return carriages
	    var linkText = contentTree.links[i].innerHTML.toLowerCase();
	    linkText = linkText.replace(/\n/," ");
	    linkText = linkText.replace(/\r/,"");
	    
		if( linkText == strTitleLower )
			return contentTree.links[i];
	}
	return "";
}

// Search a link into the tree by his href:
contentTree.seachLinkByHref = function( strHref ) {
	for (var i=0; i<contentTree.links.length; i++) {
	    //var aux = unescape( contentTree.links[i].href );
	    var aux = contentTree.links[i].href;
        if( aux == strHref || endsWith( aux , "/" + strHref ) )
			return contentTree.links[i];
    }
	return "";
}

contentTree.seachLinkByFileTitle = function( strFile ) {
	for (var i=0; i<contentTree.links.length; i++) {
	
	    //var aux = getPageTitle( unescape( contentTree.links[i].href ) );
	    var aux = getPageTitle( contentTree.links[i].href );
	    
        if( aux == strFile )
			return contentTree.links[i];
        else {
            idx = aux.indexOf( "#" )
            if( idx >= 0 ) {
                aux = aux.substring( 0 ,  idx );
                if( aux == strFile )
			        return contentTree.links[i];
			}
        }
    }
	return "";
}


// Search links that contains
contentTree.searchByContent = function( strSearch , idList , idTopicsList ) {

    var list = document.getElementById( idList );
	list.options.length=0;
	if( strSearch == "" )
		return;
	var topicsList = document.getElementById( idTopicsList );
    //var strLower = strSearch.toLowerCase();
    var strLower = normalizeString( strSearch );
    for (var i=0; i<topicsList.options.length; i++) {
		if( normalizeString( topicsList.options[i].text ).indexOf( strLower ) >= 0 ) {
			var opt = new Option( topicsList.options[i].text );
			opt.value = topicsList.options[i].value ;
			list.options[ list.options.length ] = opt;
		}
	}
	list.ondblclick = function(e) {
		if( list.selectedIndex >= 0 )
			contentTree.selectUrl( list.options[ list.selectedIndex ].value );
	}
}


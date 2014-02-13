var selectedContent = 0;
var tabLinks;
var contents;

function initializeTab( linkIds , contentsIds ) {

	tabLinks = new Array( linkIds.length );
	for( var i=0; i< linkIds.length; i++ ) {
		tabLinks[i] = document.getElementById( linkIds[i] );
		tabLinks[i].onclick = function( e ) {
			// Search wich links is pressed
			for( var j=0; j<tabLinks.length; j++ ) {
				if( tabLinks[j] == this ) {
					contents[selectedContent].style.display="none";
					selectedContent = j;
					contents[j].style.display="block";
				}
			}
			stopEvent(e);
			return false;
		}
	}

	contents = new Array( contentsIds.length );
	for( var i=0; i < contentsIds.length; i++ ) {
		contents[i] = document.getElementById( contentsIds[i] );
		if( i > 0 )
			contents[i].style.display="none";
	}
}

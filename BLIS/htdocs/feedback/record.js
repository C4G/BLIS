jQuery(document).ready(function()
					{
					  // first report the user properties
					  jQuery.post("UserProps.php",
							  {
							      navigator_appCodeName: navigator.appCodeName,
							      navigator_appName: navigator.appName,
							      navigator_appVersion: navigator.appVersion,
							      navigator_cookieEnabled: navigator.cookieEnabled,
							      navigator_platform: navigator.platform,
							      navigator_userAgent: navigator.userAgent,
							      navigator_systemLanguage: navigator.systemLanguage,
							      navigator_userLanguage: navigator.userLanguage,
							      navigator_language: navigator.language,
							      screen_availHeight: screen.availHeight,
							      screen_availWidth: screen.availWidth,
							      screen_colorDepth: screen.colorDepth,
							      screen_height: screen.height,
							      screen_width: screen.width
							  }
						    );

					  // now set up a timer to periodically measure delay
					  
						var start = new Date();
						var t1 = start.getTime();
						var param="&sid="+Math.random();
						var page_name = window.location.pathname;
						var request_uri = window.location.href;
						jQuery.get("blank.txt?"+param,function() 
											{
											  var end = new Date();
											  t2 = end.getTime();											  
											//alert(t2-t1);
											  jQuery.post("Latency.php", { latency: (t2-t1), page: page_name, uri: request_uri } );
											}
							 );					  
					}
				 );
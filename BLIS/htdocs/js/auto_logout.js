/*
Enables auto-logout when session times out
See includes/script_elems.php to enable
*/

// Set timeout interval below
timeout_interval = 30000; // in millisecs

function set_interval()
{
	//the interval 'timer' is set as soon as the page loads
	timer=setInterval("auto_logout()",timeout_interval);
	// the figure '10000' above indicates how many milliseconds the timer be set to.
	//Eg: to set it to 5 mins, calculate 5min= 5x60=300 sec = 300,000 millisec. So set it to 3000000
}

function reset_interval()
{
	//resets the timer. The timer is reset on each of the below events:
	// 1. mousemove   2. mouseclick   3. key press 4. scroliing
	//first step: clear the existing timer
	clearInterval(timer);
	//second step: implement the timer again
	timer=setInterval("auto_logout()",timeout_interval);
}
 
function auto_logout()
{
	//this function will redirect the user to the logout script
	window.location="logout.php?timeout";
}

$(document).ready( function() {
	$('body').click( function() {reset_interval();})
	$('body').mousemove( function() {reset_interval();})
	$('body').keypress( function() {reset_interval();})
	$('body').scroll( function() {reset_interval();})	
	set_interval();
});
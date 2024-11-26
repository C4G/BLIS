<?php
#
# Contains function calls for MySQL DB connection and query execution
# For e.g., use query_associative_all() instead of mysql_query()
#

require_once(__DIR__."/composer.php");
require_once(__DIR__."/db_constants.php" );
require_once(__DIR__."/debug_lib.php");

$con = mysql_connect( $DB_HOST, $DB_USER, $DB_PASS );
if (!$con) {
    die('Could not connect: ' . mysql_error());
}
$LOG_QUERIES = true;

mysql_select_db( $DB_NAME, $con );

function _db_get_username() {
    if (isset($_SESSION['username'])) {
        return $_SESSION['username'];
    } else {
        return "(unset)";
    }
}

function query_insert_one($query)
{
	# Single insert statement
	global $con, $LOG_QUERIES;
    mysql_query( $query, $con ) or die(mysql_error());
	if($LOG_QUERIES == true) {
        DebugLib::logDBUpdates($query, db_get_current());
        DebugLib::logQuery($query, db_get_current(), _db_get_username());
    }
}


function query_update($query)
{	
	# Single update statement
	global $con, $LOG_QUERIES;
    mysql_query( $query, $con ) or die(mysql_error());
	if($LOG_QUERIES == true)	
    {
		DebugLib::logQuery($query, db_get_current(), _db_get_username());
		DebugLib::logDBUpdates($query, db_get_current());
    }
}

function query_delete($query)
{
	# Single delete from statement
	global $con, $LOG_QUERIES;
	mysql_query( $query, $con ) or die(mysql_error());
	if($LOG_QUERIES == true)
    {
		DebugLib::logQuery($query, db_get_current(), _db_get_username());
		DebugLib::logDBUpdates($query, db_get_current());
    }
}

function query_alter($query)
{
	# Single ALTER statement
	global $con, $LOG_QUERIES;
    mysql_query( $query, $con ) or die(mysql_error());
	if($LOG_QUERIES == true)
    {
		DebugLib::logQuery($query, db_get_current(), _db_get_username());
		DebugLib::logDBUpdates($query, db_get_current());
    }
}

function query_associative_all($query) 
{
    global $con, $LOG_QUERIES;
	if( !($result = mysql_query( $query, $con ) ) ) 
	{
        return null;
    }
    $retval = array();
    while ( $row = mysql_fetch_assoc($result) ){ $retval[] = $row; }
	if($LOG_QUERIES == true) {
		DebugLib::logQuery($query, db_get_current(), _db_get_username());
		DebugLib::logDBUpdates($query, db_get_current());
    }
    return $retval;
}

function query_associative_one( $query ) 
{
    global $con, $LOG_QUERIES;
	if( !($result =  mysql_query( $query, $con ) ) ) 
	{
        return null;
    }
    $retval = mysql_fetch_assoc( $result );
	if($LOG_QUERIES == true)
    {
		DebugLib::logQuery($query, db_get_current(), _db_get_username());
		DebugLib::logDBUpdates($query, db_get_current());
    }
	return $retval;
}

function query_num_rows( $table_name )
{
	global $con, $LOG_QUERIES;
	$query_string =
		"SELECT COUNT(*) AS val FROM $table_name";
	$record = query_associative_one($query_string);
	if($LOG_QUERIES == true)
    {
		DebugLib::logQuery($query_string, db_get_current(), _db_get_username());
		DebugLib::logDBUpdates($query, db_get_current());
    }
	return $record['val'];
}

function query_empty_table( $table_name )
{
	# Empty all data in the given table
	global $con, $LOG_QUERIES;
	$query_string = "DELETE FROM $table_name";
	query_blind($query_string);
	
	if($LOG_QUERIES == true)	
    {
		DebugLib::logQuery($query_string, db_get_current(), _db_get_username());
		DebugLib::logDBUpdates($query, db_get_current());
    }
}

function db_escape( $value ) 
{
    $retval = mysql_real_escape_string( $value );
    return $retval;
}

function db_prep_int( $value, $zero_ok ) 
{
    if( 
            !isset( $value ) ||
            (is_null($value)) ||
            !is_numeric($value)
      )
    {
        $value = 'null';
    }
    else 
	{
        if( 
                ($value == 0 ) &&
                ( !$zero_ok ) 
          )
        {
            $value = 'null';
        }
    }
    return $value;
}

function db_prep_string( $value ) 
{
    if( 
            !isset( $value ) ||
            (is_null($value)) ||
            preg_match( '/^\s+$/', $value ) ||
            ( $value == '' )
      )
    {
        $value = 'null';
    }
    else 
	{
        $value = "'$value'";
    }
    return $value;
}

function get_last_db_error() 
{
    global $con, $LOG_QUERIES;
    $retval = mysql_error( $con );
    return $retval;
}

function query_blind( $query ) 
{
    global $con, $LOG_QUERIES;
    $result = mysql_query( $query, $con );
	if($LOG_QUERIES == true)
    {
		DebugLib::logQuery($query, db_get_current(), _db_get_username());
		DebugLib::logDBUpdates($query, db_get_current());
    }
    return $result;
}

function get_last_insert_id() 
{
    global $con, $LOG_QUERIES;
    $retval = mysql_insert_id( $con );
    return $retval;
}

function db_change($db_name) 
{
	global $con, $LOG_QUERIES;
	mysql_select_db( $db_name, $con );
}

function db_create($db_name)
{
	global $con, $LOG_QUERIES;
	$query_string = "CREATE DATABASE $db_name;";
	mysql_query($query_string, $con);
}

function db_delete($db_name)
{
	global $con, $LOG_QUERIES;
	$query_string = "DROP DATABASE ".$db_name;
	mysql_query($query_string, $con);
}

function db_get_current()
{
	global $con, $LOG_QUERIES;
	$query_string = "SELECT DATABASE() AS db_name";
	$record = mysql_query($query_string, $con);
	$row = mysql_fetch_assoc($record);
	return $row['db_name'];
}

function db_close() 
{
	global $con, $LOG_QUERIES;
	mysql_close($con);
}

?>
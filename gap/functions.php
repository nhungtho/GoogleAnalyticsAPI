<?php
session_start();

//date_default_timezone_set('America/Chicago');

/* ################################################ */
// Set up database values.
/* ################################################ */
// SQL variables
$query = "";
$SQL = "";

// 1.  Create variables that will set the hostname, username & password
$hostname = "tvimysql01.tvi-mp3.com";
$dbusername = "ga";
$dbpassword = "nR4TTZM9yxm6FyPa";
$databasename = "GoogleAnalytics";

// 2.  Set the connection information to connect to the MySQL database
$conn = mysql_connect($hostname, $dbusername, $dbpassword)
	or die('Cannot connect to MySQL server');

// 3.  Select the database to use
mysql_select_db($databasename)
	or die('Cannot open database.');


// Steps 1-3 are the re-usable parts.

//******************************************************************************
function db_sqlstr($sString)
{
  extract($GLOBALS);
// DESCRIPTION:
// Returns string with single quotes around it and internal single quotes cleaned up.
// Used to prevent ' (quotes) from disrupting the formatting of the query.
// INPUTS/OUTPUTS:
// sString = string to convert
// RETURN VALUE:
//
//******************************************************************************
// Return string with single quotes
// turned into 2 single quotes
  if (!is_null($sString))
  {
	$function_ret = "'".addslashes($sString)."'";
  }
    else
  {
	$function_ret="''";
  } 

  return $function_ret;
} 

?>

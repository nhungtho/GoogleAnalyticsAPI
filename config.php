<?php
########## Google Settings.. Client ID, Client Secret #############
$google_client_id 				= '417811993981-bjr47i47stiika3qt9b197a603p5qk8p.apps.googleusercontent.com';
$google_client_secret 			= 'j_8pytF35BwFLtUNnkM29cci';
$google_redirect_url 			= 'http://www.tviwebdev2.com/analytics/update_pages.php';
$page_url_prefix				= 'http://www.tviwebdev2.com/analytics';

########## Google analytics Settings.. #############
$google_analytics_profile_id 	= 'ga:81491726'; //find the site profile id in google analystic
$google_analytics_dimensions 	= 'ga:landingPagePath,ga:pageTitle'; //no change needed (optional)
$google_analytics_metrics 		= 'ga:pageviews'; //no change needed (optional)
$google_analytics_sort_by 		= '-ga:pageviews'; //no change needed (optional)
$google_analytics_max_results 	= '20'; //no change needed (optional)

########## MySql details #############
$db_username 					= "tviadmin"; //Database Username
$db_password 					= "jgpyCOxjo8zc4vz"; //Database Password
$hostname 						= "tviweb01.tvi-mp3.com"; //Mysql Hostname
$db_name 						= "GoogleAnalytics"; //Database Name
###################################################################

$mysqli = new mysqli($hostname,$db_username,$db_password,$db_name);
?>
<?php
require 'functions.php';
define('ga_email','willut72@gmail.com');
define('ga_password','texasfootball');
define("MAX_RESULTS", 30);
require 'gapi.class.php';
$ids = array();
$result2 = mysql_query("SELECT `Google Profile ID` FROM `dealer` ORDER BY `Index` ASC LIMIT ".MAX_RESULTS);
while($row = mysql_fetch_array($result2)) {
	$ids[] = $row[0];
}
foreach($ids as $id) 
{
echo $id."<br/>";
$SQL = "UPDATE `dealer` SET `Report done` = `Report done` + 1 WHERE `Google Profile ID` = '$id'";			
		if (mysql_query($SQL)) {
			echo "saved";
		} else {
			echo "something went wrong";
			exit;
		}
$ga = new gapi(ga_email,ga_password);

$today = date('Y-m-d');
$search = array("2009","2010","01","02","03","04","05","06","07","08","09","10","11","12");
$replace = array("","","January","February","March","April","May","June","July","August","September","October","November","December");
$search2 = array ("<");
$replace2 = array ("");

$ga->requestReportData($id,array('day', 'month','year'),array('pageviews','visits','bounces','visitors','avgTimeOnPage','pageviewsPerVisit', 'percentNewVisits', 'visitBounceRate'),array('-year','-month') ,$filter=null,$start_date='2014-01-01',$end_date=$today,$start_index=1,$max_results=10);

?>
<table width="99%" align="center">
<tr>
<th>Date</th>
<th>Visits</th>
<th>Pageviews</th>
<th>Bounces</th>
<th>Visitors</th>
<th>Avg Time on Page (seconds)</th>
<th>Page View Per Visit</th>
</tr>
<?php
foreach($ga->getResults() as $result){
?>
<tr valign="center" align="center">
<td><?php $date = $result->getYear(str_replace($search2,$replace2,$result))."-".$result->getMonth($result)."-".$result->getDay($result); echo $date?></td>

<td><?php $visit = $result->getVisits(); echo $visit;?></td>
<td><?php $pageview = $result->getPageviews(); echo $pageview;?></td>
<td><?php $bounce = $result->getBounces(); echo $bounce;?></td>
<td><?php $visitor = $result->getVisitors(); echo $visitor;?></td>
<td><?php $timeonpage = $result->getavgTimeOnPage(); echo $timeonpage; ?></td>
<td><?php $viewpervisit = $result->getpageviewsPerVisit(); echo $viewpervisit;?></td><?php $bouncerate = $result->getvisitBounceRate();$percentnewvisit = $result->getpercentNewVisits();?>
</tr>
<?php
$SQL = "INSERT INTO `visits` (`Google Profile ID`, `Date`, `Visits`, `Pageviews`, `Bounces`, `Unique Visitors`, `Avg Time on Page (seconds)`, `Page View Per Visit`, `Bounce Rate`, `% New Visits`, `type of report`)";
		$SQL .= " VALUES ";
		$SQL .= "('$id', '$date', '$visit', '$pageview', '$bounce', '$visitor', '$timeonpage', '$viewpervisit', '$bouncerate', '$percentnewvisit', 'from 2014-01-01')";
			// Insert the values
		if (mysql_query($SQL)) {
			echo "saved";
		} else {
			echo "something went wrong";
			exit;
		}
}
?>
</table>


<?php
 
/* *********************************query mobile trafic******************************************************************************************/ 
$ga->requestReportData($id,array('mobileDeviceInfo', 'source'),array('visits','pageviews', 'timeOnSite'),array('-visits') ,$filter=null,$start_date='2014-01-01',$end_date=$today,$start_index=1,$max_results=100);


?>
<table width="99%" align="center">
<tr>
<th>mobileDeviceInfo</th>
<th>source</th>
<th>Visits</th>
<th>pageviews</th>
<th>timeOnSite</th>

</tr>
<?php
foreach($ga->getResults() as $result)
{
?>
<tr valign="center" align="center">
<td><?php $mobileDeviceInfo = $result->getmobileDeviceInfo(); echo $mobileDeviceInfo?></td>

<td><?php $source = $result->getsource(); echo $source;?></td>
<td><?php $visits = $result->getvisits(); echo $visits;?></td>
<td><?php $pageviews = $result->getpageviews(); echo $pageviews;?></td>
<td><?php $timeOnSite = $result->gettimeOnSite(); echo $timeOnSite;?></td>
</tr>
<?php
$SQL = "INSERT INTO `mobile device` (`Google Profile ID`, `devices`, `source`,`visits`,`pageviews`,`time on site`, `type of report`)";
		$SQL .= " VALUES ";
		$SQL .= "('$id', '$mobileDeviceInfo','$source','$visits','$pageviews','$timeOnSite', 'from 2014-01-01'                               )";
			// Insert the values
		if (mysql_query($SQL)) {
			echo "saved";
		} else {
			echo "something went wrong";
			exit;
		}
}
?>
</table>

<?php
 
/* *********************************query browser  and Operating system******************************************************************************************/ 
$ga->requestReportData($id,array('browser','operatingSystem'),array('visits', 'percentNewVisits', 'newVisits'),array('-visits') ,$filter=null,$start_date='2014-01-01',$end_date=$today,$start_index=1,$max_results=100);


?>
<table width="99%" align="center">
<tr>
<th>Browsers</th>
<th>operatingSystem</th>
<th>Visits</th>
<th>% New Visits</th>
<th>New Visits</th>
</tr>
<?php
foreach($ga->getResults() as $result){
?>
<tr valign="center" align="center">
<td><?php $browser = $result->getbrowser(); echo $browser;?></td>
<td><?php $operatingSystem = $result->getoperatingSystem(); echo $operatingSystem;?></td>
<td><?php $visit = $result->getVisits(); echo $visit;?></td>
<td><?php $percentnewvisit = $result->getpercentNewVisits(); echo $percentnewvisit;?></td>
<td><?php $newvisit = $result->getnewVisits(); echo $newvisit;?></td>
</tr>
<?php
$SQL = "INSERT INTO `topbrowsers` (`Google Profile ID`,`name`,`os`,`visits`,`new visit`,`% new visits`, `type of report`)";
		$SQL .= " VALUES ";
		$SQL .= "('$id', '$browser','$operatingSystem','$visit','$newvisit','$percentnewvisit', 'from 2014-01-01')";
			// Insert the values
		if (mysql_query($SQL)) {
			echo "saved";
		} else {
			echo "something went wrong";
			exit;
		}
}
?>
</table>
<?php
/* *********************************Referring Sites******************************************************************************************/ 
$ga->requestReportData($id,array('source'),array('visits', 'timeOnSite', 'exits'),array('-visits') ,$filter='medium==referral',$start_date='2014-01-01',$end_date=$today,$start_index=1,$max_results=100);

?>
<table width="99%" align="center">
<tr>
<th>source</th>
<th>Visits</th>
<th>timeOnSite</th>
<th>exits</th>
</tr>
<?php
foreach($ga->getResults() as $result){
?>
<tr valign="center" align="center">
<td><?php $source = $result->getsource(); echo $source;?></td>
<td><?php $visit = $result->getVisits(); echo $visit;?></td>
<td><?php $timeOnSite = $result->gettimeOnSite(); echo $timeOnSite;?></td>
<td><?php $exits = $result->getexits(); echo $exits;?></td>
</tr>
<?php
$SQL = "INSERT INTO `referring sites` (`Google Profile ID`,`referring source`,`visits`, `time on site`, `exits`, `type of report`)";
		$SQL .= " VALUES ";
		$SQL .= "('$id', '$source', '$visit', '$timeOnSite','$exits', 'from 2014-01-01')";
			// Insert the values
		if (mysql_query($SQL)) {
			echo "saved";
		} else {
			echo "something went wrong";
			exit;
		}
}
?>
</table>
<?php
/* *********************************Organic Search******************************************************************************************/ 
$ga->requestReportData($id,array('source'),array('visits', 'timeOnSite', 'exits'),array('-visits') ,$filter='medium==organic',$start_date='2014-01-01',$end_date=$today,$start_index=1,$max_results=100);

?>
<table width="99%" align="center">
<tr>
<th>search engine</th>
<th>Visits</th>
<th>timeOnSite</th>
<th>exits</th>
</tr>
<?php
foreach($ga->getResults() as $result){
?>
<tr valign="center" align="center">
<td><?php $source = $result->getsource(); echo $source;?></td>
<td><?php $visit = $result->getVisits(); echo $visit;?></td>
<td><?php $timeOnSite = $result->gettimeOnSite(); echo $timeOnSite;?></td>
<td><?php $exits = $result->getexits(); echo $exits;?></td>
</tr>
<?php
$SQL = "INSERT INTO `organic search` (`Google Profile ID`,`search engine`,`visits`, `time on site`, `exits`, `type of report`)";
		$SQL .= " VALUES ";
		$SQL .= "('$id', '$source', '$visit', '$timeOnSite','$exits', 'from 2014-01-01')";
			// Insert the values
		if (mysql_query($SQL)) {
			echo "saved";
		} else {
			echo "something went wrong";
			exit;
		}
}
?>
</table>
<?php
/* *********************************Paid Search******************************************************************************************/ 
$ga->requestReportData($id,array('source'),array('visits', 'timeOnSite', 'exits'),array('-visits') ,$filter='medium==cpa,medium==cpc,medium==cpm,medium==cpp,medium==cpv,medium==ppc',$start_date='2014-01-01',$end_date=$today,$start_index=1,$max_results=100);

?>
<table width="99%" align="center">
<tr>
<th>source</th>
<th>Visits</th>
<th>timeOnSite</th>
<th>exits</th>
</tr>
<?php
foreach($ga->getResults() as $result){
?>
<tr valign="center" align="center">
<td><?php $source = $result->getsource(); echo $source;?></td>
<td><?php $visit = $result->getVisits(); echo $visit;?></td>
<td><?php $timeOnSite = $result->gettimeOnSite(); echo $timeOnSite;?></td>
<td><?php $exits = $result->getexits(); echo $exits;?></td>
</tr>
<?php
$SQL = "INSERT INTO `paid search` (`Google Profile ID`,`source`,`visits`, `time on site`, `exits`, `type of report`)";
		$SQL .= " VALUES ";
		$SQL .= "('$id', '$source', '$visit', '$timeOnSite','$exits', 'from 2014-01-01')";
			// Insert the values
		if (mysql_query($SQL)) {
			echo "saved";
		} else {
			echo "something went wrong";
			exit;
		}
}
?>
</table>
<?php
/* *********************************Paid keywords******************************************************************************************/ 
$ga->requestReportData($id,array('adKeywordMatchType'),array('visits', 'percentNewVisits', 'newVisits'),array('-adKeywordMatchType') ,$filter=null,$start_date='2014-01-01',$end_date=$today,$start_index=1,$max_results=100);


?>
<table width="99%" align="center">
<tr>
<th>Ad keywords</th>
<th>Visits</th>
<th>% New Visits</th>
<th>New Visits</th>
</tr>
<?php
foreach($ga->getResults() as $result){
?>
<tr valign="center" align="center">
<td><?php $adKeywordMatchType = $result->getadKeywordMatchType(); echo $adKeywordMatchType;?></td>

<td><?php $visit = $result->getVisits(); echo $visit;?></td>
<td><?php $percentnewvisit = $result->getpercentNewVisits(); echo $percentnewvisit;?></td>
<td><?php $newvisit = $result->getnewVisits(); echo $newvisit;?></td>
</tr>
<?php
$SQL = "INSERT INTO `ad words` (`Google Profile ID`,`keywords`,`visits`,`new visits`,`% new visits`, `type of report`)";
		$SQL .= " VALUES ";
		$SQL .= "('$id', '$adKeywordMatchType', '$visit', '$newvisit','$percentnewvisit', 'from 2014-01-01')";
			// Insert the values
		if (mysql_query($SQL)) {
			echo "saved";
		} else {
			echo "something went wrong";
			exit;
		}
}
?>
</table>
<?php
/* *********************************Organic Keywords******************************************************************************************/
$ga->requestReportData($id,array('keyword'),array('visits', 'percentNewVisits', 'newVisits'),array('-visits') ,$filter='medium==organic',$start_date='2014-01-01',$end_date=$today,$start_index=1,$max_results=100);

?>
<table width="99%" align="center">
<tr>
<th>keyword</th>
<th>Visits</th>
<th>% New Visits</th>
<th>New Visits</th>
</tr>
<?php
foreach($ga->getResults() as $result){
?>
<tr valign="center" align="center">
<td><?php $keyword = $result->getkeyword(); echo $keyword;?></td>

<td><?php $visit = $result->getVisits(); echo $visit;?></td>
<td><?php $percentnewvisit = $result->getpercentNewVisits(); echo $percentnewvisit;?></td>
<td><?php $newvisit = $result->getnewVisits(); echo $newvisit;?></td>
</tr>
<?php
$SQL = "INSERT INTO `organic keywords` (`Google Profile ID`,`keywords`,`visits`,`new visits`,`% new visits`, `type of report`)";
		$SQL .= " VALUES ";
		$SQL .= "('$id', '$keyword', '$visit', '$newvisit','$percentnewvisit', 'from 2014-01-01')";
			// Insert the values
		if (mysql_query($SQL)) {
			echo "saved";
		} else {
			echo "something went wrong";
			exit;
		}
}
?>
</table>
<?php
/* *********************************Direct Landing Page******************************************************************************************/ 
$ga->requestReportData($id,array('landingPagePath'),array('visits', 'pageviews', 'newVisits','uniquePageviews', 'avgTimeOnPage'),array('-visits') ,$filter=null,$start_date='2014-01-01',$end_date=$today,$start_index=1,$max_results=10);

?>
<table width="99%" align="center">
<tr>
<th>landingPagePath</th>
<th>Visits</th>
<th>New Visits</th>
<th>Pagviews</th>
<th>Unique Pageviews</th>
<th>Average time on page</th>
</tr>
<?php
foreach($ga->getResults() as $result){
?>
<tr valign="center" align="center">
<td><?php $landingPagePath = $result->getlandingPagePath(); echo $landingPagePath;?></td>

<td><?php $visit = $result->getVisits(); echo $visit;?></td>
<td><?php $newvisit = $result->getnewVisits(); echo $newvisit;?></td>
<td><?php $pageviews = $result->getpageviews(); echo $pageviews;?></td>
<td><?php $uniquePageviews = $result->getuniquePageviews(); echo $uniquePageviews;?></td>
<td><?php $avgTimeOnPage = $result->getavgTimeOnPage(); echo $avgTimeOnPage;?></td>
</tr>
<?php
$SQL = "INSERT INTO `top landing pages` (`Google Profile ID`,`landing page path`,`visits`,`new visits`,`pageviews`,`unique pageviews`, `avg time on page (s)`, `type of report`)";
		$SQL .= " VALUES ";
		$SQL .= "('$id', '$landingPagePath', '$visit', '$newvisit','$pageviews', '$uniquePageviews','$avgTimeOnPage', 'from 2014-01-01')";
			// Insert the values
		if (mysql_query($SQL)) {
			echo "saved";
		} else {
			echo "something went wrong";
			exit;
		}
}
?>
</table>

<?php
/* *********************************Event Tracking******************************************************************************************/ 
$ga->requestReportData($id,array('eventLabel'),array('totalEvents', 'uniqueEvents', 'visitsWithEvent', 'avgEventValue'),array('-eventLabel') ,$filter=null,$start_date='2014-01-01',$end_date=$today,$start_index=1,$max_results=100);

?>
<table width="99%" align="center">
<tr>
<th>Event Label</th>
<th>Total Events</th>
<th>Unique Events</th>
<th>visits With Event</th>
<th>avg Event Value</th>
</tr>
<?php
foreach($ga->getResults() as $result)
{
?>
<tr valign="center" align="center">
<td><?php $eventLabel = $result->geteventLabel(); echo $eventLabel;?></td>
<td><?php $totalEvents = $result->gettotalEvents(); echo $totalEvents;?></td>
<td><?php $uniqueEvents = $result->getuniqueEvents(); echo $uniqueEvents;?></td>
<td><?php $visitsWithEvent = $result->getvisitsWithEvent(); echo $visitsWithEvent;?></td>
<td><?php $avgEventValue = $result->getavgEventValue(); echo $avgEventValue;?></td>
<?php
$SQL = "INSERT INTO `event tracking` (`Google Profile ID`,`event label`,`total events`,`unique events`,`visits with events`,`avg event value`, `type of report`)";
		$SQL .= " VALUES ";
		$SQL .= "('$id', '$eventLabel', '$totalEvents', '$uniqueEvents','$visitsWithEvent', '$avgEventValue', 'from 2014-01-01')";
			// Insert the values
		if (mysql_query($SQL)) {
			echo "saved";
		} else {
			echo "something went wrong";
			exit;
		}
}
?>
</table>
<?php
}
?>
<?php
define('ga_email','willut72@gmail.com');
define('ga_password','texasfootball');
define('ga_profile_id','81491726');

require 'gapi.class.php';
require 'functions.php';
$ga = new gapi(ga_email,ga_password);

$today = date('Y-m-d');
$search = array("2009","2010","01","02","03","04","05","06","07","08","09","10","11","12");
$replace = array("","","January","February","March","April","May","June","July","August","September","October","November","December");
$search2 = array ("<");
$replace2 = array ("");

$ga->requestReportData(ga_profile_id,array('day', 'month','year'),array('pageviews','visits','bounces','visitors','avgTimeOnPage','pageviewsPerVisit'),array('-year','-month') ,$filter=null,$start_date='2014-01-01',$end_date=$today,$start_index=1,$max_results=1000);
?>

<?php
$mode = "";
$pageview = "";
$visit = "";
$bounce = "";
$visitor = "";
$timeonpage = "";
$viewpervisit = "";
$date = "";
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
$mode = $_POST["mode"];
$pageview = $_POST["pageview"];
$visit = $_POST["visit"];
$bounce = $_POST["bounce"];
$visitor = $_POST["visitor"];
$timeonpage = $_POST["timeonpage"];
$viewpervisit = $_POST["viewpervisit"];
$date = $_POST["date"];
}
///////////////////////////////////INSERT TO SERVER///////////////////////////////////////

if ($mode == "savenew") {
	$bIsAllValid = 1;	// true
	echo "post: $date";
	if ($bIsAllValid == 1)
	{

		$SQL = "INSERT INTO	`visits` (`Date`, `Visits`, `Pageviews`, `Bounces`, `Visitors`, `Avg Time on Page (seconds)`, `Page View Per Visit`) ";
		$SQL .= " VALUES ";
		$SQL .= "('$date', '$visit', '$pageview', '$bounce', '$visitor', '$timeonpage', '$viewpervisit)";
			// Insert the values
		if (mysql_query($SQL)) {
			echo "saved";
		} else {
			echo "something went wrong";
			exit;
		}
			
	 }

}
?>
<form name="data" action="" method="post">
<input type="hidden" name="mode" value="savenew"/>
<table width="99%" align="center">
<tr>
<th>Date</th>
<th>Pageviews</th>
<th>Visits</th>
<th>Bounces</th>
<th>Visitors</th>
<th>Avg Time on Page (seconds)</th>
<th>Page View Per Visit</th>
</tr>
<?php
foreach($ga->getResults() as $result):
?>
<tr valign="center" align="center">
<td><?php echo $result->getDay($result)."-".$result->getMonth($result)."-".$result->getYear(str_replace($search2,$replace2,$result)) ?></td>
<input name="date" type="hidden" value="<?php echo $result->getDay($result)."-".$result->getMonth($result)."-".$result->getYear(str_replace($search2,$replace2,$result)) ?>"/>
<td><?php echo $result->getPageviews() ?></td>
<input type="hidden"  name="pageview" value="<?php echo $result->getPageviews() ?>"/>
<td><?php echo $result->getVisits() ?></td>
<input type="hidden" name="visit" value="<?php echo $result->getVisits() ?>"/>
<td><?php echo $result->getBounces() ?></td>
<input type="hidden" name="bounce" value="<?php echo $result->getBounces() ?>"/>
<td><?php echo $result->getVisitors() ?></td>
<input type="hidden" name="visitor" value="<?php echo $result->getVisitors() ?>"/>
<td><?php echo $result->getavgTimeOnPage() ?></td>
<input type="hidden"  name="timeonpage" value="<?php echo $result->getavgTimeOnPage() ?>"/>
<td><?php echo $result->getpageviewsPerVisit() ?>
<input type="hidden" name="viewpervisit" value="<?php echo $result->getpageviewsPerVisit() ?>"/>
</td>
</tr>
<?php
endforeach
?>
</table>
<input type="submit" name="submit" value="submit" />
</form>
<br/><br/>

<iframe allowtransparency="true" scrolling="no" frameborder="0" style="border: none; width: 550px; height:600px;" src="http://path.to/gapistats.php"></iframe>

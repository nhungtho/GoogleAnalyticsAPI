<?php
//session_start for caching, if desired
session_start();
//get the class
require 'ga/analytics.class.php';
//sign in and grab profile
$analytics = new analytics('willut@gmail.com', 'texasfootball');
$analytics->setProfileByName('mazda-atlanta');
//set the date range for which I want stats for (could also be $analytics->setDateRange('YYYY-MM-DD', 'YYYY-MM-DD'))
$analytics->setDateRange(date('2014-02-01'), date('2014-02-11'));
//get array of visitors by day
print_r($analytics->getVisitors());
//get array of pageviews by day
print_r($analytics->getPageviews());
?>
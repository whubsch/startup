<?
/*
======================================================================
Get, cache, and output contents of a RSS XML file
Author: George at JavaScriptKit.com/ DynamicDrive.com
Created: Feb 1st, 2006. Updated: Feb 1st, 2006
======================================================================
*/

header('Content-type: text/xml');

// -------------------------------------------------------------------
// Enter list of possible RSS feeds to fetch inside array:
// -------------------------------------------------------------------

$rsslist=array(
"WaPo" => "http://feeds.washingtonpost.com/rss/politics",
"BBC" => "http://feeds.bbci.co.uk/news/world/rss.xml",
"NYTimes" => "http://rss.nytimes.com/services/xml/rss/nyt/HomePage.xml",
);

$cachefolder="cache"; //path to cache directory. No trailing "/". Set dir permission to read/write!

// -------------------------------------------------------------------
// Determine which RSS file to actually fetch
// Based on the value of the "id" parameter of the URL string mapping to the RSS array's key
// -------------------------------------------------------------------

$rssid=$_GET['id'];
$rssurl=isset($rsslist[$rssid])? $rsslist[$rssid] : die("Error: Can't find requested RSS in list.");
$localfile=$cachefolder. "/" . urlencode($rssurl); //Name cache file based on RSS URL

// -------------------------------------------------------------------
// Get the minutes to cache the local RSS file based on "cachetime" parameter of URL string
// -------------------------------------------------------------------

$cacheminutes=(int) $_GET["cachetime"]; //typecast "cachetime" parameter as integer (0 or greater)

// -------------------------------------------------------------------
// fetchfeed() gets the contents of an external RSS feed,
// and saves its contents to the "cached" file on the server
// -------------------------------------------------------------------

function fetchfeed(){
global $rssurl, $localfile;
$contents=file_get_contents($rssurl); //fetch RSS feed
$fp=fopen($localfile, "w");
fwrite($fp, $contents); //write contents of feed to cache file
fclose($fp);
}

// -------------------------------------------------------------------
// outputrsscontent() outputs the contents of a RSS feed using the cached local RSS file
// It checks if a cached version of the RSS feed is available, and if not, creates one first.
// -------------------------------------------------------------------

function outputrsscontent(){
global $rssurl, $localfile, $cacheminutes;
if (!file_exists($localfile)){ //if cache file doesn't exist
touch($localfile); //create it
chmod($localfile, 0666); 
fetchfeed(); //then populate cache file with contents of RSS feed
}
else if (((time()-filemtime($localfile))/60)>$cacheminutes) //if age of cache file great than cache minutes setting
fetchfeed();
readfile($localfile); //return the contents of the cache file
}

outputrsscontent();
?>
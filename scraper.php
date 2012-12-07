<?php
require_once('lib/simple_html_dom.php');

// $parkId='281228'; // Curry Hammock //
// $parkName = "Curry Hammock";

$parkId='281005'; // Bahia Honda //
$parkName = "Bahia Honda";

// $parkId='281050'; // Long Key //
// $parkName = "Long Key";

// $parkId='281003'; // Anastasia // 
// $parkName = "Anastasia";

$contractCode='FL';
$lengthOfStay='2';
$eqplen='25';
$waterfront=''; //3011 for waterfront and blank for any site
$arvdate='12/20/2012';
$enddate='1/1/2013';

$alertthreshold = '2';
$siteType='2001'; //2001 for RV only
$expfits='true';
$hookup='electric';
$range='2';
$page='calendar';
$siteTypeFilter='RV%20or%20Tent';

$html = new simple_html_dom();

$url = 'http://www.reserveamerica.com/campsiteCalendar.do?submitSiteForm=true';
$url .= '&parkId='.$parkId.'';
$url .= '&eqplen='.$eqplen.'';
$url .= '&waterfront='.$waterfront.'';
$url .= '&arvdate='.$arvdate.'';
$url .= '&enddate='.$enddate.'';
$url .= '&lengthOfStay='.$lengthOfStay.'';
$url .= '&contractCode='.$contractCode.'';
$url .= '&page=calendar';
$url .= '&range=2';
$url .= '&hookup=electric';
$url .= '&siteType=2001';
$url .= '&expfits=true';
$url .= '&siteTypeFilter=RV%20or%20Tent';

$html->load_file($url);

$ret_msg = $html->find('.msg');

$ret = $html->find('.avail');
$i = 0;
while ($i < count($ret)){
	// echo $ret[$i]."\n\n";
	$i++;
}

if ($ret_msg[0] == "<div class='msg topofpage'>No suitable availability shown</div>"){
	echo "Nothing found at ".$parkName.". <a href=\"".$url."\" target=_blank>Go see for yourself</a>. ";
} else {
	if ($i > 0){
		if ($i == 1){
			$isorare = "is";
			$siteorsites = "opening";
		} else {
			$isorare = "are";
			$siteorsites = "openings";
		}
		echo "There ".$isorare." ".$i." ".$siteorsites." available at ".$parkName.". <a href=\"".$url."\" target=_blank>Click here to view</a>. ";
	}
	// Open send an alert
	if ($i >= $alertthreshold){
		echo "Threshold of ".$alertthreshold." reached. Send an alert.";
	} else {
		echo "Openings did not reach desired threshold of ".$alertthreshold.". No alert sent.";
	}
}
?>
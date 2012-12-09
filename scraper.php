<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set("memory_limit","128M");
set_time_limit(0);

require_once('lib/simple_html_dom.php');

if(isset($_GET['iso'])){
	$isolate=$_GET['iso'];
} else {
	$isolate='';
}

if(isset($_GET['re'])){
	$recipient=$_GET['re'];
} else {
	$recipient='name@example.com';
}

if ($isolate == '281228'){
$parkarray[0]['parkId']='281228'; // Curry Hammock //
$parkarray[0]['parkName']='Curry_Hammock_Sp';
$parkarray[0]['contractCod']='FL';
}

if ($isolate == '281005'){
$parkarray[1]['parkId']='281005'; // Bahia Honda //
$parkarray[1]['parkName']='Bahia_Honda_Sp';
$parkarray[1]['contractCod']='FL';
}

if ($isolate == '281050'){
$parkarray[2]['parkId']='281050'; // Long Key //
$parkarray[2]['parkName']='Long_Key_Sp';
$parkarray[2]['contractCod']='FL';
}

if ($isolate == '281003'){
$parkarray[3]['parkId']='281003';
$parkarray[3]['parkName']='Anastasia_Sp';
$parkarray[3]['contractCod']='FL';
}

if ($isolate == '281015'){
$parkarray[4]['parkId']='281015';
$parkarray[4]['parkName']='John_Pennekamp_Coral_Reef_Sp';
$parkarray[4]['contractCod']='FL';
}

if ($isolate == '281068'){
$parkarray[5]['parkId']='281068';
$parkarray[5]['parkName']='St_George_Island_Sp';
$parkarray[5]['contractCod']='FL';
}

if ($isolate == '281069'){
$parkarray[6]['parkId']='281069';
$parkarray[6]['parkName']='St_Joseph_Peninsula_Sp';
$parkarray[6]['contractCod']='FL';
}

if ($isolate == '281250'){
$parkarray[7]['parkId']='281250';
$parkarray[7]['parkName']='Topsail_Hill_Preserve_State_Park_Gregory_E_Moore_Rv_Resort';
$parkarray[7]['contractCod']='FL';
}

if ($isolate == '281067'){
$parkarray[8]['parkId']='281067';
$parkarray[8]['parkName']='St_Andrews_Sp';
$parkarray[8]['contractCod']='FL';
}

if ($isolate == '281186'){
$parkarray[9]['parkId']='281186';
$parkarray[9]['parkName']='Henderson_Beach_Sp';
$parkarray[9]['contractCod']='FL';
}

if ($isolate == '281033'){
$parkarray[10]['parkId']='281033';
$parkarray[10]['parkName']='Grayton_Beach_Sp';
$parkarray[10]['contractCod']='FL';
}

if ($isolate == '281045'){
$parkarray[11]['parkId']='281045';
$parkarray[11]['parkName']='Koreshan_State_Historic_Site';
$parkarray[11]['contractCod']='FL';
}

if ($isolate == '281053'){
$parkarray[12]['parkId']='281053';
$parkarray[12]['parkName']='Manatee_Springs_Sp';
$parkarray[12]['contractCod']='FL';
}


if(isset($_GET['l'])){
	$lengthOfStay=$_GET['l'];
} else {
	$lengthOfStay="3";
}

if(isset($_GET['e'])){
	$alertthreshold=$_GET['e'];
} else {
	$alertthreshold="3";
}

if(isset($_GET['wf'])){
	$wf="3011"; //3011 for waterfront and blank for any site
	$wfstatus = "checked";
} else {
	$wf="";
	$wfstatus = "";
}

if(isset($_GET['arr'])){
	$arr=$_GET['arr'];
} else {
	$arr="12/20/2012";
}

if(isset($_GET['dep'])){
	$dep=$_GET['dep'];
} else {
	$dep="1/3/2013";
}
echo "<form action=\"scraper.php\" method=\"get\">\n";
echo "Length of stay (l): <input type=\"text\" name=\"l\" value=\"".$lengthOfStay."\"> <br>\n";
echo "Threshold (e):  <input type=\"text\" name=\"e\" value=\"".$alertthreshold."\"> <br>\n";
echo "Range Start (arr):  <input type=\"text\" name=\"arr\" value=\"".$arr."\"> <br>\n";
echo "Range End (dep):  <input type=\"text\" name=\"dep\" value=\"".$dep."\"> <br>\n";
echo "Type (wf):  <input type=\"checkbox\" name=\"wf\" value=\"3011\" ".$wfstatus."> Waterfront<br>\n";
echo "<input type=\"submit\" value=\"Submit\"></form>\n";
	
foreach($parkarray as $park){
	$parkId = $park['parkId'];
	$parkName = $park['parkName'];
	$contractCode = $park['contractCod'];
	$eqplen='25';
	$waterfront=$wf;
	$arvdate=$arr;
	$enddate=$dep;
	$siteType='2001'; //2001 for RV only
	$expfits='true';
	$hookup='electric';
	$range='2';
	$page='calendar';
	$siteTypeFilter='RV%20or%20Tent';
	
	$url = 'http://www.reserveamerica.com/camping/'.$parkName.'/r/campsiteCalendar.do?submitSiteForm=true';
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
	
	$html = new simple_html_dom();
	$html->load_file($url);
	
	$ret_msg = $html->find('.msg');
	
	$ret = $html->find('.avail');
	$i = 0;
	while ($i < count($ret)){
		// echo $ret[$i]."\n\n";
		$i++;
	}
	if (in_array("<div class='msg topofpage'>No suitable availability shown</div>", $ret_msg)){
		echo "Nothing found at ".$parkName.". <a href=\"".$url."\" target=_blank>Go see for yourself</a>. <br><br>";
	} else {
		// threshold check
		if ($i >= $alertthreshold){
			$threshold = true;
		} else {
			$threshold = false;
		}
		if ($i > 0){
			if ($i == 1){
				$isorare = "is";
				$siteorsites = "opening";
			} else {
				$isorare = "are";
				$siteorsites = "openings";
			}
			if ($threshold == true){
				echo "<strong>";
			}
			echo "There ".$isorare." ".$i." ".$siteorsites." available at ".$parkName.". <a href=\"".$url."\" target=_blank>Click here to view</a>.";		

			$to      = $recipient;
			$subject = 'Campsites found by Dan\'s Reserve America Scraper!!!';
			$message = "There ".$isorare." ".$i." ".$siteorsites." available at ".$parkName." between ".$arr." and ".$dep.".\r\n\r\n".$url;
			$headers = 'From: noreply@malimish.com' . "\r\n" .
			    'Reply-To: noreply@malimish.com' . "\r\n" .
			    'X-Mailer: PHP/' . phpversion();
			
			mail($to, $subject, $message, $headers);
			
			if ($threshold == true){
				echo "</strong> <br><br>";
			}
		}
	}
}
?>
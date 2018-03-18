<?php
	$section = "diary";
	$page = "Diary";

	include "/srv/ath/src/php/mng/common.php";

	$errors = array();
	$pagetitle = "Diary";
	$pagescript = array();
	$pagestyle = array();

	include "/srv/ath/pub/mng/tmpl/header.php";

if(!isset($siteMods['diary'])){
	?>
	<h2>This Athena Module has not been activated</h2>
	<?php
	include "/srv/ath/pub/mng/tmpl/footer.php";
	exit;
	}


?>

<h2 style="margin-top: 0px;">
	Diary
<a class="btn btn-primary btn-xs" href="/diary/add.php" title="Add a new Diary Item">Add a new Diary Item</a>
</h2>




<div id=searchres><p>
<?php


$id = ((isset($_GET['q']))&&($_GET['q'] != '')) ? $_GET['q'] : '';

#$staffid = ((isset($_GET['staffid']))&&(is_numeric($_GET['staffid'] ))&&($_GET['staffid'] > 0)) ? $_GET['staffid'] : '';

$min = date("i");
$hour = date("H");
$day = date("d");
$month = date("m");
$year = date("Y");

$start = mktime($hour, $min, 0, $month, $day, $year);


$from = ((isset($_GET['from']))&&(is_numeric($_GET['from'] ))) ? $_GET['from'] : mktime(0, 0, 0, date("m"), 1,   date("Y"));
$showingMonth = date("F",$from);
$showingMonthNo = date("m",$from);
$showingYear = date("Y",$from);
$to = mktime(23, 59, 59, date("m",$from)+1, date("d",$from)-1,   date("Y",$from));


$showFrom = $from;
while(date("l",$showFrom)!='Monday'){
	$showFrom = $showFrom - (60*60*24);
}
$retHTML ='';
for ($i = $showFrom; $i < $from; $i=$i+(60*60*24)) {
	$retHTML .= getBlankDiaryDayHTML($i);
}


$cnt = 1;
for ($i = $from; $i <= $to; $i=mktime(0, 0, 0, date("m",$i), date("d",$i)+1,   date("Y",$i))) { # Loop thru the days, avoiding Daylight Saving issues

	if(checkdate($showingMonthNo, $cnt, $showingYear)){
		$retHTML .= getDiaryDayHTML($i,$staffid);
		$cnt++;
	}
}

$showTo = $to;
while(date("l",$showTo)!='Sunday'){
	$showTo = $showTo + (60*60*24);
}

for ($i = $to; $i < $showTo; $i=$i+(60*60*24)) {
	$retHTML .= getBlankDiaryDayHTML($i);
}

$retHTML .= '</ul><br clear=all />';
$lastmonth = mktime(0, 0, 0, date("m",$from)-1, date("d",$from),   date("Y",$from));
$nextmonth = mktime(0, 0, 0, date("m",$from)+1, date("d",$from),   date("Y",$from));
?>
<a href="/diary/?from=<?php echo $lastmonth ?>">&lt;--Last</a>
|
<?php
echo 'Showing Month:' . $showingMonth . '/' .  $showingYear;
?>
|
<a href="/diary/?from=<?php echo $nextmonth ?>">Next--&gt;</a>

<br clear=all />

<?php
echo $retHTML;

?>
</p></div>
<?php
	include "/srv/ath/pub/mng/tmpl/footer.php";
?>
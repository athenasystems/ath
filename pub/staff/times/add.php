<?php
$page = "Staff Times";

include "/srv/ath/src/php/staff/common.php";

$errors = array();

if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {
    
    $required = array(
        "staffid"
    );
    $errors = check_required($required, $_POST);
    
    if (empty($errors)) {
        
        $logContent = "\n";
        
        $fields = array_merge($required, array(
            "notes"
        ));
        
        foreach ($fields as $name) {
            $dbvalues[$name] = $_POST[$name];
            $logContent .= $name . ':' . $_POST[$name] . "<br>";
        }
        
        $itemArray = $_POST['item'];
        
        $itemno = 1;
        
        foreach ($itemArray as &$itemValues) {
            
            $start = mktime($itemValues['start']['hour'], $itemValues['start']['minute'], 0, $itemValues['start']['month'], $itemValues['start']['day'], $itemValues['start']['year']);
            
            $lstart = mktime($itemValues['lstart']['hour'], $itemValues['lstart']['minute'], 0, $itemValues['start']['month'], $itemValues['start']['day'], $itemValues['start']['year']);
            
            $finish = mktime($itemValues['end']['hour'], $itemValues['end']['minute'], 0, $itemValues['end']['month'], $itemValues['end']['day'], $itemValues['end']['year']);
            
            $lfinish = mktime($itemValues['lend']['hour'], $itemValues['lend']['minute'], 0, $itemValues['end']['month'], $itemValues['end']['day'], $itemValues['end']['year']);
            
            $logContent .= $itemValues['start']['hour'] . '-' . $itemValues['start']['minute'] . ' | ' . $itemValues['start']['month'] . '-' . $itemValues['start']['day'] . '-' . $itemValues['start']['year'] . ' | ' . $start . '<br>';
            
            $logContent .= $itemValues['lstart']['hour'] . '-' . $itemValues['lstart']['minute'] . ' | ' . $itemValues['start']['month'] . '-' . $itemValues['start']['day'] . '-' . $itemValues['start']['year'] . ' | ' . $lstart . '<br>';
            
            $logContent .= $itemValues['lend']['hour'] . '-' . $itemValues['lend']['minute'] . ' | ' . $itemValues['end']['month'] . '-' . $itemValues['end']['day'] . '-' . $itemValues['end']['year'] . ' | ' . $lfinish . '<br>';
            
            $logContent .= $itemValues['end']['hour'] . '-' . $itemValues['end']['minute'] . ' | ' . $itemValues['end']['month'] . '-' . $itemValues['end']['day'] . '-' . $itemValues['end']['year'] . ' | ' . $finish . '<br>';
            
            if ((isset($itemValues['timesid'])) && (is_numeric($itemValues['timesid'])) && ($itemValues['timesid'] > 0)) {
                $timesUpdate = new Times();
                $timesUpdate->setTimesid($itemValues['timesid']);
                $timesUpdate->setStaffid($_POST['staffid']);
                $timesUpdate->setStart($start);
                $timesUpdate->setFinish($finish);
                $timesUpdate->setNotes($_POST['notes']);
                $timesUpdate->setTimes_typesid($_POST['times_typesid']);
                $timesUpdate->setLstart($lstart);
                $timesUpdate->setLfinish($lfinish);
                $timesUpdate->updateDB();
            } else {
                $timesNew = new Times();
                $timesNew->setStaffid($_POST['staffid']);
                $timesNew->setIncept(time());
                $timesNew->setStart($start);
                $timesNew->setFinish($finish);
                $timesNew->setNotes($_POST['notes']);
                $timesNew->setDay($itemValues['day']);
                $timesNew->setTimes_typesid($itemValues['times_typesid']);
                $timesNew->setLstart($lstart);
                $timesNew->setLfinish($lfinish);
                $timesNew->insertIntoDB();
            }
            
            $itemno ++;
        }
        
        $logresult = logEvent(26, $logContent);
        
        // header("Location: /quotes/?highlight=". $result['id']);
        // exit();
    }
}
$pagetitle = "Staff Times";
$pagescript = array();
$pagestyle = array();

include "/srv/ath/pub/staff/tmpl/header.php";

if (! isset($siteMods['timesheets'])) {
    ?>
<h2>This Athena Module has not been activated</h2>
<?php
    include "/srv/ath/pub/staff/tmpl/footer.php";
    exit();
}

// print $logContent;

if ((isset($_GET['from'])) && ($_GET['from'] != '')) {
    $day = $_GET['from'];
} else {
    
    $day = findLastMonMidnight();
}

$week = date("W", $day);

// if((date("I", $day)) && (!date("I", ($day- (60*60*24*7))))){
// $lastmon = findLastMonMidnight($day - ((60*60*24*6) + (60*60*23)));
// }else{
$lastmon = mktime(0, 0, 0, date("m", $day), date("d", $day) - 7, date("Y", $day));

// findLastMonMidnight($day - (60*60*24*7));
// }

// $lastmon = findLastMonMidnight($day - (60*60*24*7)) ;
$nextmon = mktime(0, 0, 0, date("m", $day), date("d", $day) + 7, date("Y", $day));
$weekBegin = date("d-m-Y", $day);
$holHTML = getHolidayData($staffid);
?>

<h2>Staff Times for <?php echo getStaffName($staffid)?> - Week <?php echo $week?></h2>
<h2>
	<a
		href="/times/add?id=<?php echo $staffid?>&from=<?php echo $lastmon?>">&lt;--
		Back 1 Week</a> | Week Starting: <?php echo $weekBegin?> | <a
		href="/times/add?id=<?php echo $staffid?>&from=<?php echo $nextmon?>">Forward
		1 Week --&gt;</a>
</h2>

<form
	action="<?php echo $_SERVER['PHP_SELF']?>?id=<?php echo $staffid?>&go=y&from=<?php echo $_GET['from']?>"
	enctype="multipart/form-data" method="post"><?php echo form_fail(); ?>

<fieldset class="form-group">

		<ol>

<?php
$stored = 0;
for ($i = 0; $i < 7; $i ++) {
    $sqltext = "SELECT timesid, start, finish,lstart, lfinish, times_typesid, notes FROM times WHERE staffid='" . $staffid . "' AND day=" . $day;
    $res = $dbsite->query($sqltext); # or die("Cant get Staff Times");
    $stored = '';
    
    if (! empty($res)) {
        $rd = $res[0];
        
        // If we have stored values ...
        $stored = 'background-color:#eee;';
        
        $date['hour'] = date("H", $r->start);
        $date['minute'] = date("i", $r->start);
        
        $ldate['hour'] = date("H", $r->lstart);
        $ldate['minute'] = date("i", $r->lstart);
    } else {
        
        // If we do not have stored values ...
        if ($i > 4) {
            $date['hour'] = '00';
            $date['minute'] = '00';
            
            $ldate = $date;
            $ldate['hour'] = '00';
            $ldate['minute'] = '00';
        } else {
            $date['hour'] = $shift['start_hour'];
            $date['minute'] = $shift['start_min'];
            
            $ldate = $date;
            $ldate['hour'] = $lunch['start_hour'];
            $ldate['minute'] = $lunch['start_min'];
        }
    }
    
    $date['year'] = date("Y", $day);
    $date['month'] = date("m", $day);
    $date['day'] = date("d", $day);
    
    $ldate['year'] = date("Y", $day);
    $ldate['month'] = date("m", $day);
    $ldate['day'] = date("d", $day);
    
    $thisday = date("l", $day);
    
    $realDayTimes = <<<EOF
	{$date['hour']}:{$date['minute']} till
EOF;
    $realDayLTimes = <<<EOF
	lunch from {$ldate['hour']}:{$ldate['minute']}	till
EOF;
    
    $html .= <<<EOF
<div style="padding:10px;">

	<div style="float:left;width:120px;font-size:130%;$stored">
	<a href="javascript:void(0);" title="daydetail$i" onclick="showHideDetail('daydetail$i')">$thisday</a>
	</div>



	<div style="float:left;$stored" id=fbdaydetail$i>
	<a href="javascript:void(0);" title="daydetail$i" onclick="showHideDetail('daydetail$i')">Show details</a>
	</div>

	<div style="padding:6px;margin:4px;border:1px #eee solid;width:750px;float:left;display:none;" id="daydetail$i">

EOF;
    
    $html .= "<h2 >" . date("l", $day) . "</h2>";
    
    $html .= "<ul style=\"border:1px solid #eee;margin:2px;padding:2px;width:540px;float:left;$stored\">";
    
    $html .= html_shiftselect('Work Start ', "item[$i][start]", $date, 'y', 'return', $day);
    
    $html .= html_shiftselect('Lunch Start ', "item[$i][lstart]", $ldate, 'y', 'return', $day);
    
    if (! empty($res)) {
        
        // If we have stored values ...
        $date['hour'] = date("H", $r->finish);
        $date['minute'] = date("i", $r->finish);
        $ldate['hour'] = date("H", $r->lfinish);
        $ldate['minute'] = date("i", $r->lfinish);
    } else {
        // If we do not have stored values ...
        if ($i > 4) {
            $date['hour'] = '00';
            $date['minute'] = '00';
            $r->times_typesid = 2;
            
            $ldate = $date;
            $ldate['hour'] = '00';
            $ldate['minute'] = '00';
        } elseif ($i == 4) {
            $date['hour'] = $shift['finish_hour'] - 1;
            $date['minute'] = $shift['finish_min'];
            
            $ldate = $date;
            $ldate['hour'] = $lunch['finish_hour'];
            $ldate['minute'] = $lunch['finish_min'];
        } else {
            $date['hour'] = $shift['finish_hour'];
            $date['minute'] = $shift['finish_min'];
            $r->times_typesid = 1;
            
            $ldate = $date;
            $ldate['hour'] = $lunch['finish_hour'];
            $ldate['minute'] = $lunch['finish_min'];
        }
    }
    
    $realDayTimes .= <<<EOF
	{$date['hour']}:{$date['minute']}
EOF;
    $realDayLTimes .= <<<EOF
	{$ldate['hour']}:{$ldate['minute']}
EOF;
    
    $html .= html_shiftselect('Lunch End ', "item[$i][lend]", $ldate, 'y', 'return', $day);
    
    $html .= html_shiftselect('Work End ', "item[$i][end]", $date, 'y', 'return', $day);
    
    $html .= html_hidden("item[$i][day]", $day, 'return');
    
    $html .= "</ul>";
    
    $html .= "<ul style=\"text-align:left;border:1px solid #eee;margin:2px;padding:2px;width:440px;float:left;$stored\">";
    
    $html .= times_type_select('Type', "item[$i][times_typesid]", $r->times_typesid, 0, 0);
    
    $html .= html_text("Notes", "item[$i][notes]", $r->notes, '', '', 'return', 0);
    
    $html .= html_hidden("item[$i][timesid]", $r->timesid);
    
    $html .= "</ul> </div>  ";
    
    $html .= <<<EOF
	<div style="float:left;width:360px;font-size:100%;margin-left:20px;$stored">$realDayTimes . $realDayLTimes</div>
</div> <br clear=all />
EOF;
    
    $day = $day + (60 * 60 * 24);
}

print <<<EOF

$html

EOF;

?>

</ol>

	</fieldset>

	<fieldset class="form-group"><?php
if ((! $stored) || ($seclevel < 2) || ($r->incept < (time() - (60 * 60)))) {
    html_button("Save changes");
}
if ($stored) {
    ?> Changes have been saved for this week <?php
}
html_hidden("staffid", $staffid);

// html_hidden ("timesid",$r->timesid);

?></fieldset>

</form>

<ol>
	<li>Working day is <?php echo $shift['start_hour']?>:<?php echo $shift['start_min']?>&nbsp;
till <?php echo $shift['finish_hour']?>:<?php echo $shift['finish_min']?></li>
	<li>Lunch is
from <?php echo $lunch['start_hour']?>:<?php echo $lunch['start_min']?> till <?php echo $lunch['finish_hour']?>:<?php echo $lunch['finish_min']?></li>
	<li>If you just did a normal week click Save Changes.</li>
	<li>If you have done any overtime or want to add a period of Holiday or
		Sickness, click on the Day and fill in the details.</li>
	<li><?php echo $holHTML?></li>
</ol>




<?php
include "/srv/ath/pub/staff/tmpl/footer.php";
?>

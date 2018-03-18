<?php


$section = "Reports";
$page = "Site Log";

include "/srv/ath/src/php/mng/common.php";

$errors = array();

$pagetitle = "Site Log";
$pagescript = array();
$pagestyle = array();

include "/srv/ath/pub/mng/tmpl/header.php";
include "helptab.php";

$days = (isset($_GET['days'])) ? $_GET['days'] : 1 ;

# AND mem.memid=sitelog.staffid
#, memid, nick, fname, sname, prefname, email
$now = time();

# sitelogid, incept, staffid, level, event, content, eventsid

$days_ago = $now - (60*60*24*$days);
$sqltext = "SELECT athdb$sitesid.sitelog.sitelogid, athdb$sitesid.sitelog.incept,
athdb$sitesid.sitelog.content, athdb$sitesid.sitelog.eventsid, athdb$sitesid.sitelog.staffid,athcore.events.name
FROM athdb$sitesid.sitelog,athcore.events
WHERE events.eventsid=athdb$sitesid.sitelog.eventsid";

$evid='';
if(isset($_GET['eventsid']) && $_GET['eventsid']!='' && is_numeric($_GET['eventsid']) && $_GET['eventsid']>0){
	$sqltext .= " AND athdb$sitesid.sitelog.eventsid=" . $_GET['eventsid'];
	$evid = $_GET['eventsid'];
}

$sqltext .= " AND athdb$sitesid.sitelog.eventsid<>9 ";
$sqltext .= " AND athdb$sitesid.sitelog.eventsid<>10 ";
$sqltext .= " AND athdb$sitesid.sitelog.incept>" . $days_ago . " ORDER BY athdb$sitesid.sitelog.incept DESC";

#print $sqltext;
$res = $dbsys->query($sqltext);

$row_count = count($res);

$bodyHTML = <<< EOHTML
<br clear=all>
<div style="width:150px;float:left;">When</div>
<div style="width:250px;float:left;">Who</div>
<div style="width:250px;float:left;">What</div>
<div style="width:250px;float:left;">Detail</div>
<br clear="all">
EOHTML;

$summaryHTML = "<table style=\"float:right;\">";
#print $row_count;

$cnt=0;

if (! empty($res)) {
	foreach($res as $r) {
		$totals[$r->eventsid]=0;
	}

	foreach($res as $r) {


		$totals[$r->eventsid]++;

		$incept = date('d-m-Y h:i A',$r->incept);
		if(isset($r->staffid)){
			$staffName = getStaffName($r->staffid);
		}else{
			$r->staffid = '';
		}
		$r->content= strip_tags ( $r->content );

		$bodyHTML .= <<< EOHTML
<div style="width:150px;float:left;">$incept</div>
<div style="width:250px;float:left;"> $staffName</div>
<div style="width:250px;float:left;"> {$r->name} </div>
<div style="width:280px;float:left;">
<div style="float:left;" id=fblogdetail$cnt>
<a href="javascript:void(0);" title="{$r->content}" onclick="showHide('logdetail$cnt')">
Show Items</a></div>
<div style="padding:6px;margin:4px;border:1px #eee solid;width:250px;float:left;display:none;" id="logdetail$cnt">
{$r->content}</div>
</div>
<br clear="all">
EOHTML;

$cnt++;

	}
	$bodyHTML .= <<< EOHTML

EOHTML;
	$summaryHTML .= "<tr><td>No of Events in the last $days days:</td><td>$row_count</td></tr>";
	foreach($totals as $key => $value){

		$name =	getEventName($key);

		$summaryHTML .= "<tr><td>Total $name:</td><td>$value</td></tr>";
	}
}

$summaryHTML .= "</table><br clear=all>";

#include "/srv/ath/pub/mng/reports/linkstab.php";
?>
<h2>Site Activity Log</h2>
<div style="float: right; font-size: 80%; width: 350px;">

	<form action="<?php echo $_SERVER['PHP_SELF']?>" method=get>
		<fieldset>
			<ol>
				<?php
				event_select('Show Events','eventsid',$evid);
				days_select('Days to show','days',$days)
				?>
			</ol>

		</fieldset>

	</form>

</div>
<div style="float: left; font-size: 80%; width: 350px;">
	<?php print $summaryHTML;?>
</div>

<br clear=all>

<div style="width: 1000px;">
	<?php print $bodyHTML;?>
</div>
<script>
setTimeout("beginrefresh()",80000);
function beginrefresh(){
location.reload(true);
}
</script>
<?php
include "/srv/ath/pub/mng/tmpl/footer.php" ;
?>

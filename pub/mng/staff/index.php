<?php
$section = "Contacts";
$page = "Staff";

include "/srv/ath/src/php/mng/common.php";

$errors = array();

if ((isset($_GET['go'])) && ($_GET['go'] == "y")) {
    
    $staffUpdate = new Staff();
    
    $staffUpdate->setStaffid($staffid);
    $staffUpdate->setTheme($_GET['nt']);
    
    $staffUpdate->updateDB();
    
    $dets = getStaffDets($staffid);
}

$pagetitle = "staff";
$pagescript = array();
$pagestyle = array();

include "/srv/ath/pub/mng/tmpl/header.php";
$query = ((isset($_GET['q'])) && ($_GET['q'] != '')) ? $_GET['q'] : '';
// include "/srv/ath/pub/mng/contacts/linkstab.php";
?>

<h2 style="margin-top: 0px;">
	Staff <a class="btn btn-primary btn-xs" href="/staff/add"
		title="Add new Staff Member">Add a New Staff Member</a>

</h2>

<?php
$from = ((isset($_GET['from'])) && (is_numeric($_GET['from']))) ? $_GET['from'] : 0;
$perpage = ((isset($_GET['perpage'])) && (is_numeric($_GET['perpage']))) ? $_GET['perpage'] : $ppage;
$newfrom = $from + $perpage;

$sqltext = "SELECT SQL_CALC_FOUND_ROWS * FROM staff,pwd
WHERE ((fname LIKE '" . $query . "%') OR (sname LIKE '" . $query . "%'))
AND status='active'
AND staff.staffid=pwd.staffid
AND staff.staffid>1000
LIMIT $from,$perpage";
$res = $dbsite->query($sqltext); // or die("Cant get staff");

$total_rows = getTotalRows();
$endofsearch = ($total_rows <= $newfrom) ? $total_rows : ($newfrom);

if (($endofsearch <= $total_rows) || (isset($_GET['q']))) {
    
    $searchForm = '<label for="q"></label>
	<input type="text" id="q" name="q" value="' . $query . '" style="width: 160px;"
	placeholder="Search By Name" class=" form-control">';
    
    printSearchBar($searchForm, $newfrom, $perpage, $endofsearch, $total_rows);
}

if (! empty($res)) {
    foreach ($res as $r) {
        
        $jobTitle = '';
        if ($r->jobtitle != '') {
            $jobTitle = '<span style="font-size:70%"> - ' . $r->jobtitle . '</span>';
        }
        
        // $holHTML = getHolidayData($r->staffid);
        ?>

<div class="panel panel-default">
	<div class="panel-heading">
		<div
			style="width: 10px; background-color: <?php echo $owner->colour;?>; float: left; margin-right: 5px;">&nbsp;</div>
		<h3 class="panel-title">
			<?php echo htmlentities($r->fname . ' ' . $r->sname)?>
		</h3>
	</div>
	<div class="panel-body">
		<a href="/staff/login.php?id=<?php echo $r->staffid?>"
			title="Log in Details">Log in Details</a> | <a
			href="/staff/edit.php?id=<?php echo $r->staffid?>"
			title="Edit this person's details">Edit Details</a>


		<?php
        $asStaff = '';
        $theme = '';
        
        if ($r->staffid == 1001) {
            $asStaff = '&as_staff=1';
        }
        
        ?>

		<?php
        
        if ($r->usr != 'admin') {
            ?>
		| <a href="/staff/access?id=<?php echo $r->staffid?>"
			title="Choose Access rights for users">Athena Access</a>
		<?php
        }
        ?>

		| <a href="/loginas.php?stid=<?php echo $r->staffid . $asStaff ; ?>"
			target="_blank" title="Log In As ...">Staff Control Portal </a>
		<?php
        
        if ($r->seclev == 1) {
            ?>
		<br>Access: Administrator
		<?php
        } else {
            ?>
		<br>Access: Staff 
		<?php
        }
        
        if ($r->staffid == $staffid) {
            $nexttheme = $dets->theme + 1;
            if ($nexttheme > 3) {
                $nexttheme = 1;
            }
            ?>
            <a href="/staff/index?go=y&nt=<?php echo $nexttheme;?>">Theme
			--></a>
            <?php
        }
        ?>
	</div>
</div>

<?php
    }
} else {
    ?>
No results found ...
<?php
}

if ($endofsearch <= $total_rows) {
    printSearchFooter($newfrom, $perpage, $query, '', '', '', '', $total_rows);
}
include "/srv/ath/pub/mng/tmpl/footer.php";
?>

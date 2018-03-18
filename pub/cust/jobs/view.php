<?php

$section = "jobs";
$page = "Jobs";

include "/srv/ath/src/php/cust/common.php";

$errors = array();

$sqltext = "SELECT jobs.incept,jobs.jobno,jobs.jobsid,jobs.done,jobs.jobcontent,jobs.notes,cust.co_name,
				items.content,items.quantity,items.price,
				quotes.quotesid,quotes.content as qcontent,quotes.quoteno,quotes.staffid,quotes.contactsid
				FROM jobs,items,quotes,cust
				WHERE items.itemsid=jobs.itemsid
				AND items.quotesid=quotes.quotesid
				AND quotes.custid=cust.custid
				AND quotes.custid=$custID
				AND jobs.jobsid='". addslashes($_GET['id']) ."'";

$res = $dbsite->query($sqltext); # or die("Cant get jobs");
$r = $res[0];

$jno = $r->jobno;



$custFileStore = '/srv/ath/var/files/cust/'.$custDets->filestr ;

if(( isset($_GET['go']) && ($_GET['go']=='delfile') ) && ( isset($_GET['fn']) && ($_GET['fn']!='') )){

	unlink( $custFileStore . '/' . base64_decode( $_GET['fn'] ) );

}



$pagetitle = "Edit Job";
$pagescript = array();
$pagestyle = array();

include "/srv/ath/pub/cust/tmpl/header.php";

if(!isset($siteMods->jobs)){
	?>
	<h2>This Athena Module has not been activated</h2>
	<?php
	include "/srv/ath/pub/cust/tmpl/footer.php";
	exit;
	}


if( isset($_GET['nf']) && ($_GET['nf']=='y') ){
	?>
	<br>
	<div style="display: block;">
		<span id=help>Your file has been uploaded and is available below.
			Athena has sent an email to <?php echo $owner->co_name?> to let them know.
		</span>
	</div>
	<br>
	<?php
	}

?>
<br>
<span id=pageactions>
<span style="font-size: 90%;color:#999;">For this Job:- </span>

	<a href="/jobs/files?jobno=<?php echo $r->jobno?>">Share Files</a>

</span>



<h1>View a Job <span><a href="/jobs/files.php?jobno=<?php echo $r->jobno?>"
	title="Add a File">Add a File</a></span></h1>

<?php echo form_fail(); ?>
<h2>Job No: <?php echo $r->jobno?></h2>

<?php
$content = '<a href="/quotes/view.php?id='.$r->quotesid.'" title="View Quote">'.$r->quoteno.'</a>';
tablerow("From Quote No",$content);
tablerow("Customer",$r->co_name);

tablerow("Job Description",stripslashes($r->jobcontent));
tablerow("Item Description",stripslashes($r->content));

tablerow("Delivery",$r->delivery);
tablerow("Quantity",$r->quantity);
tablerow("Date Started",date("Y-m-d", $r->incept));

if( (is_numeric($r->done)) && ($r->done>0 ) ){
	$content = date("Y-m-d", $r->done);
}else{
	$content = "Not Done Yet";
}
tablerow("Date Completed",$content);
tablerow("Internal Contact",getStaffName($r->staffid));
tablerow("External Contact",getCustExtName($r->contactsid));

?>


<br>
<p>&nbsp;</p>
<ol><li id="filestitle">Shared Files</li>


<?php

if ($handle = opendir($custFileStore) ) {

	$cnt =0;
	while (false !== ($entry = readdir($handle))) {


		if(preg_match("/^$jno\./", $entry)){


				$cnt++;


			$webCustFileStore = '/files/' . $custDets->filestr . '/' . $entry ;

			?>
	<li>	<a href="<?php echo $webCustFileStore; ?>" title="Download File">File name: <?php

	$entryFileName = $entry;
	$entryFileName = preg_replace('/^.*?\..*?\./', '', $entryFileName);
	$entryFileName = preg_replace('/\.zip$/', '', $entryFileName);
	echo $entryFileName;
	 ?></a><br>
	<span style="color:#666;font-size: 80%;">
	<?php

	if(preg_match('/\.I\./', $entry)){
		echo "File was uploaded by : " . $owner->co_name . "<br>";
	}elseif(preg_match('/\.C\./', $entry)){
		echo "File was uploaded by : " . $r->co_name . "<br>";
	}

	echo "File was last modified on : " . date ("F d Y H:i:s.", filemtime("$custFileStore/$entry"));

	?>

	</span>

	<?php

	if(preg_match('/\.C\./', $entry)){
		?>
		<a
		href="<?php echo $_SERVER['PHP_SELF']?>?id=<?php echo $r->quotesid?>&go=delfile&fn=<?php echo base64_encode( $entry ) ; ?>"
		style="font-size: 80%; color: red;" onclick="return confirmSubmit()">Delete</a><br>
		<?php
	}

	?>

	<br><br>
	</li>
			<?php

		}
	}

	if($cnt==0){
		?>
	<li>There are no files shared for this job</li>
	<?php
	}

	closedir($handle);



}


?>
</ol>

<script>
<!--
function confirmSubmit()
{
var agree=confirm("Are you sure you wish to delete this file?");
if (agree)
	return true ;
else
	return false ;
}
// -->
</script>
<?php


include "/srv/ath/pub/cust/tmpl/footer.php";
?>

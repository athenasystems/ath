<?php $section = "Jobs";$page = "Jobs Delivered";include "/srv/ath/src/php/mng/common.php";$errors = array();if( (isset($_GET['go'])) && ($_GET['go'] == "mkpdf") ){	
	passthru("perl /srv/ath/src/perl/mng/root_delivery_note.pl " . $_GET['id'] . " " . $sitesid );
	
}$pagetitle = "Jobs";$pagescript = array();$pagestyle = array();$errors = array();$done = "";if( (isset($_GET['go'])) && ($_GET['go'] == "y") ){	$required = array( "jobsid" );	$errors = check_required($required, $_POST);	if(empty($errors)){		$logContent	.= "Delivered Goods\n";		$jobsUpdate = new Jobs();				$jobsUpdate->setJobsid($_POST['jobsid']);		$jobsUpdate->setDatedel($_POST['datedel']);		$jobsUpdate->updateDB();						if($_FILES['sigfile']['name'] != ""){			$jobno = getJobNoByID($_POST['jobsid']);			$jobdir = getPathToFilesReal($jobno) . '/files/';			$input['sigfile'] = file_upload("sigfile", $jobdir);		}		$logresult = logEvent(25,$logContent);		$done = "<h2>The Delivery has been recorded</h2><a href=\"/delivery/delivered.php\">&lt;-- Back</a>";	}}include "/srv/ath/pub/mng/tmpl/header.php";?><br><h2>	<?php echo $owner->co_nick; ?>	Job Delivered</h2><?php if($done != ''){	print $done;}else{	?><form  action="<?php echo $_SERVER['PHP_SELF']?>?go=y"	enctype="multipart/form-data" method="post" style="font-size: 140%;"	id=jobdelform>	<?php echo form_fail(); ?>	<ol style="list-style-type: none;">		<?php 		jobsid_delivery_select('Job No *','jobsid',$_GET['id']);		?>		<li>&nbsp;</li>		<?php 		$jobsid=$_GET['id'];					if($_GET['id']){			$sqltextJob = "SELECT quotes.contactsid FROM jobs,items,quotes			WHERE quotes.quotesid=items.quotesid			AND items.itemsid=jobs.itemsid			AND jobsid=" . $jobsid;
			$qJob = $dbsite->query($sqltextJob) or die("Cant get Job");
			$rJob = $qJob[0];
			$delnoteno = getJobNoByID($jobsid);
			$delnoteno = preg_replace("/J/","D",$delnoteno);
			
			$docTitlePrefix = preg_replace('/\W/', '_', $owner->co_name);			$docTitlePrefix = preg_replace('/__/', '_', $docTitlePrefix);
			$docTitle = $dataDir . "/delivery/".$docTitlePrefix."_Delivery_Note_" . $delnoteno . '.pdf';
			$docWebName = "/pdf/delivery/".$docTitlePrefix."_Delivery_Note_" . $delnoteno . '.pdf';

			if(file_exists($docTitle)){
				$pdfExists = 1;
				$retHTML .= <<<EOF
	<li> <a href="$docWebName" title="Download Delivery Note PDF">Download Delivery Note <img src="/img/pdf-logo.png" width=40 align=top /></a></li>
EOF;

			}else{

				$retHTML .= <<<EOF
	<li><a href="/delivery/delivered.php?go=mkpdf&id=$jobsid" title="Create Delivery Note PDF">Create Delivery Note PDF</a></li>
EOF;
			}		}		echo $retHTML;		?>		<li>&nbsp;</li>		<?php 		html_file("Add Signature", 'sigfile');	#	html_checkbox('Create Invoice', 'mkinvoice', 1,1);		if($rJob->contactsid){	#		html_checkbox('Message Contact: ' . getCustExtName($rJob->contactsid), 'msgcontact', 1);		}	#	html_checkbox('Send Invoice To Customer', 'sendinvoice', 1);		?>	</ol>	<br> <input type="submit" value="Complete Delivery" 		style="font-size: 80%"></form><?php }include "/srv/ath/pub/mng/tmpl/footer.php";?>
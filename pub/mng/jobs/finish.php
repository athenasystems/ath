<?php
$section = "jobs";
include "/srv/ath/src/php/mng/common.php";

$sqltext = "SELECT * FROM jobs WHERE jobsid=" . $_GET['id'];
$res = $dbsite->query($sqltext); # or die("Cant get jobs");
if (empty($res)) {
    header("Location: /jobs/?NoSuchJob");
}

$jobsUpdate = new Jobs();
$jobsUpdate->setJobsid($_GET['id']);
$jobsUpdate->setDone(time());
$jobsUpdate->updateDB();

header("Location: /jobs/?highlight=" . $result['id']);

exit();

?>

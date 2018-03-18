<h3>Your Jobs</h3>
<?php
$sqltext = "SELECT joblog.jobsid,joblog.owner,joblog.stagesid,joblog.incept
			FROM joblog,jobs
			WHERE joblog.jobsid=jobs.jobsid
			AND joblog.jobsid=" . $_GET['id'] . "
			AND owner=$staffid
			ORDER BY joblog.incept";

print $sqltext;

$res = $dbsite->query($sqltext); // or die("Cant get Jobs");
if (! empty($res)) {

    $retHTML = '<ul>';

    foreach ($res as $r) {

        $retHTML .= getJobMiniRowHTML($r);
    }

    $retHTML .= '</ul>';
}
print $retHTML;

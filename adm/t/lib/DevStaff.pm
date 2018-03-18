package DevStaff;

sub moveJobStage {

	my $dbh     = shift;
	my $mech    = shift;
	my $sitesid = shift;

	my ( $webhost, $inthost, $custhost, $supphost, $admhost, $staffhost ) = Athena::getHostName();

	#	my ( $admin_logon, $pass ) = AthenaTest::getStaffLogin($dbh);
	#	&AthenaTest::login( $mech, $admin_logon, $pass, $staffhost, $sitesid );
	print ".";
	my $staffid = AthenaTest::getAStaffID($dbh);

	my $jobsid = AthenaTest::getAJobID($dbh);

	my $uri = $staffhost . '/tcard/';

	#print $uri . "\n";

	$mech->get($uri);

	my @forms      = $mech->forms;
	my $form2click = int( rand($#forms) );

	#print $form2click;

	# move the job on one stage
	$mech->submit_form( form_number => $form2click );

	#print $mech->url;

	$mech->submit_form();

	if ( $mech->success() ) {
		return 1;
	}
	else {
		return 0;
	}
}

sub doTimesheet {

	my $dbh     = shift;
	my $mech    = shift;
	my $sitesid = shift;

	my ( $webhost, $inthost, $custhost, $supphost, $admhost, $staffhost ) = Athena::getHostName();

	my $sql = "SELECT logon,init_pw,fname,sname FROM staff,pwd 
					 WHERE fname<>'System' 
					 AND sname<>'Administrator' 
					 AND staff.staffid=pwd.staffid";
					 #AND pwd.seclev>1

	my $cursor = $dbh->prepare($sql);
	my $rtn    = $cursor->execute();

	my $uri = $staffhost . '/times/add';

	while ( my @row = $cursor->fetchrow_array ) {
		my ( $admin_logon, $pass, $fname, $sname ) = @row;
		&AthenaTest::login( $mech, $admin_logon, $pass, $staffhost, $sitesid );
		print "Logged in as $fname, $sname ";
		
		$mech->get($uri);
		
		for ( my $i = 0 ; $i < 12 ; $i++ ) {
			print ".";
			$mech->follow_link( text_regex => qr/Back 1 Week/i );
			#print "Adding Times " . $mech->uri . "\n";
			$mech->submit_form();
		}
		print "\n";

	}

	#print $uri . "\n";

	if ( $mech->success() ) {
		return 1;
	}
	else {
		return 0;
	}
}

1;

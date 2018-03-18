package DevTest;

sub db_init {
	my $dbhroot = shift;
	my $pw      = Athena::getrootDBPass();
	my $admpw   = Athena::getDBPass();

	print "Dropping the Athena DB\n";
	print "Deleting old athdbs\n";
	for ( my $i = 100 ; $i < 200 ; $i++ ) {
		my $sql    = "DROP DATABASE IF EXISTS `athdb$i`;";
		my $cursor = $dbhroot->prepare($sql);
		my $rtn    = $cursor->execute();
	}

	#	system("mysql -uroot -p'$pw' < /srv/ath/src/sql/drop.sql");

	print "Creating DB and populate with static data\n";

	# Clear Database
	print "Setting up the athcore DB\n";
	system("mysql -uroot -p'$pw' < /srv/ath/src/sql/athcore.sql");

	# DO GRANTS
	print "Doing Grants on DB\n";
	my $string = '';
	open FILE, "/srv/ath/src/sql/grants.sql"
	  or die "Couldn't open file: $!";
	while (<FILE>) {
		$string .= $_;
	}
	close FILE;

	$string =~ s/ROOTPWD/$pw/gs;
	$string =~ s/PWD/$admpw/gs;

	my $grant_filename = time() . '_AthenaGrants.sql';
	open GFILE, ">/tmp/$grant_filename" or die "Couldn't open file: $!";
	print GFILE $string;
	close GFILE;
	system("mysql -uroot -p'$pw' < /tmp/$grant_filename");
	unlink($grant_filename);

	# Clear some Files
	open FILE, ">/srv/ath/etc/admins" or die "Couldn't open file: $!";
	close FILE;
	open FILE, ">/srv/ath/etc/users" or die "Couldn't open file: $!";
	close FILE;

	open FILE, ">/srv/ath/etc/custs" or die "Couldn't open file: $!";
	close FILE;

	open FILE, ">/srv/ath/etc/supps" or die "Couldn't open file: $!";
	close FILE;
	open( FH, ">/srv/etc/httpd/live/athenasites.conf" );
	close(FH);

	# Clear some Folders
	system("rm -rf /srv/sites/10*");
	system("rm -rf /srv/ath/var/data/*");

	return 1;
}

sub set_initialInvoiceNo {
	my $dbh  = shift;
	my $mech = shift;

	my ( $webhost, $inthost, $custhost, $supphost, $admhost ) =
	  Athena::getHostName();

	# form details
	my %fields = (
		i => int( rand(500) )
	);

	my $uri = $inthost . '/acc/init_nos.php';
	$mech->get($uri);

	#print "\n$mech->#### $uri\n";
	#print $mech->content() . "\n\n";
	# Set Initials
	$mech->submit_form( with_fields => \%fields );

}
sub set_initialQuoteno {
	my $dbh  = shift;
	my $mech = shift;

	my ( $webhost, $inthost, $custhost, $supphost, $admhost ) =
	  Athena::getHostName();

	# form details
	my %fields = (
		q => int( rand(500) )
	);

	my $uri = $inthost . '/acc/init_nos.php';
	$mech->get($uri);

	#print "\n$mech->#### $uri\n";
	#print $mech->content() . "\n\n";
	# Set Initials
	$mech->submit_form( with_fields => \%fields );

}

sub updateOwner {

	my $dbh   = shift;
	my $mech  = shift;
	my $coweb = shift;
	my $fname = shift;
	my $sname = shift;
	$coweb =~ s/\W//g;
	
	my ( $webhost, $inthost, $custhost, $supphost, $admhost ) =
	  Athena::getHostName();
	my ( $strName, $city, $county, $country, $postcode ) =
	  AthenaTest::getAddress;

	# form details
	my $add1  = $strName;
	my $add2  = '';
	my $add3  = '';
	my $tel   = AthenaTest::getPhoneNumber;
	my $fax   = AthenaTest::getPhoneNumber;
	my $mob   = AthenaTest::getPhoneNumber;
	my $email = $fname.'.'.$sname.'@'.$coweb.'.com';
	my $web   = 'www.';

	my %fields = (
		co_no    => AthenaTest::generate_random_string(9),
		vat_no   => AthenaTest::generate_random_string(10),
		eoyday   => 26,
		eoymonth => 5,
		add1     => $add1,
		add2     => $add2,
		add3     => $add3,
		city     => $city,
		county   => $county,
		country  => $country,
		postcode => $postcode,
		fax      => $fax,
		tel      => $tel,
		mob      => $mob,
		email    => $email,
		web      => lc("www.$coweb.com")
	);

	my $uri = $inthost . '/acc/company';
	$mech->get($uri);

	#print "\n$mech->#### $uri\n";
	#print $mech->content() . "\n\n";
	# add the supp
	$mech->submit_form( with_fields => \%fields );


	# Add Owner name
	%fields = (
		jobtitle => 'Business Owner'
	);
	$uri = $inthost . '/staff/edit?id=1001';
	$mech->get($uri);
	$mech->submit_form( with_fields => \%fields );
	
	
}

sub add_modules {

	my $dbh  = shift;
	my $mech = shift;
	my $array_ref = shift;
	my @mods = @{$array_ref};

	my ( $webhost, $inthost, $custhost, $supphost, $admhost ) =
	  Athena::getHostName();

	foreach (@mods) {
		my $uri = $inthost . '/acc/agree?pid=' . $_;
		$mech->get($uri);
		$mech->submit_form(
			form_name => 'agreeform',
			button    => 'agree'
		);
	}
	return 1;
}

sub updateStages {
	my $dbh  = shift;
	my $mech = shift;

	my ( $webhost, $inthost, $custhost, $supphost, $admhost ) =
	  Athena::getHostName();
	my ( $strName, $city, $county, $country, $postcode ) =
	  AthenaTest::getAddress;

	# form details

	my %fields = (
		stage1 => 'Quote',
		stage2 => 'Design',
		stage3 => 'Manufacture',
		stage4 => 'Packing',
		stage5 => 'Delivery',
		stage6 => 'Sent'
	);

	my $uri = $inthost . '/stages/';
	$mech->get($uri);

	# add the supp
	$mech->submit_form( with_fields => \%fields );

}

sub updateTeams {

	my $dbh  = shift;
	my $mech = shift;

	my ( $webhost, $inthost, $custhost, $supphost, $admhost ) =
	  Athena::getHostName();
	my ( $strName, $city, $county, $country, $postcode ) =
	  AthenaTest::getAddress;

	# form details

	my %fields = (
		team1 => 'Management',
		team2 => 'Finance',
		team3 => 'Design',
		team4 => 'Manufacture',
		team5 => 'Delivery',
		team6 => 'Sales',
		team7 => 'Marketing'
	);

	my $uri = $inthost . '/teams/';
	$mech->get($uri);

	# add the supp
	$mech->submit_form( with_fields => \%fields );

}

sub example {

	my $dbh     = shift;
	my $mech    = shift;
	my $sitesid = shift;

	my ( $webhost, $inthost, $custhost, $supphost, $admhost, $staffhost ) =
	  Athena::getHostName();
	my ( $admin_logon, $pass ) =
	  AthenaTest::getNonRootAdminLogin( $dbh, $sitesid );
	&AthenaTest::login( $mech, $admin_logon, $pass, $inthost, $sitesid );

	if ( $mech->success() ) {
		return 1;
	} else {
		return 0;
	}
}

1;

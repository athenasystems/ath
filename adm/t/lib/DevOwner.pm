package DevOwner;

use strict;

sub add_staff {

	my $dbh   = shift;
	my $mech  = shift;
	my $fname = shift;
	my $sname = shift;

	my ( $webhost, $inthost, $custhost, $supphost, $admhost, $staffhost ) =
	  Athena::getHostName();

	my $mob   = &AthenaTest::getPhoneNumber;
	my $email = $fname . '.' . $sname . '@athena.systems';
	my $logon = Athena::generatePwd(10);

	my $uri = $inthost . '/staff/add.php';

	#print "$uri ...............\n";
	$mech->get($uri);

	#print $mech->content;

	my ( $strName, $city, $county, $country, $postcode ) =
	  &AthenaTest::getAddress;

	# form details
	my $add1 = $strName;
	my $add2 = '';
	my $add3 = '';
	my $tel  = &AthenaTest::getPhoneNumber;
	my $fax  = &AthenaTest::getPhoneNumber;

	# field details

	my %fields = (
		fname    => $fname,
		sname    => $sname,
		add1     => $add1,
		add2     => $add2,
		add3     => $add3,
		city     => $city,
		county   => $county,
		country  => $country,
		postcode => $postcode,
		tel      => $tel,
		mob      => $mob,
		email    => $email

	);

	$mech->submit_form( with_fields => \%fields );

#my ($id) = $dbh->selectrow_array("SELECT staffid FROM staff ORDER BY staffid DESC LIMIT 1;");

	if ( $mech->success() ) {
		return 1;
	} else {
		return 0;
	}
}

sub staffAccess {
	my $dbh     = shift;
	my $mech    = shift;
	my $sitesid = shift;

	my ( $webhost, $inthost, $custhost, $supphost, $admhost, $staffhost ) =
	  Athena::getHostName();

	my $sql = "SELECT staffid FROM staff 
	
	ORDER BY staffid
	LIMIT 4;";

	my $cursor = $dbh->prepare($sql);
	my $rtn    = $cursor->execute();

	while ( my @row = $cursor->fetchrow_array ) {

		my %fields = ( seclev => 1 );

		my $uri = $inthost . '/staff/access?id=' . $row[0];
		$mech->get($uri);

		# add staff member to admin group
		$mech->submit_form( with_fields => \%fields );

	}

	if ( $mech->success() ) {
		return 1;
	} else {
		return 0;
	}
}

sub add_cust {

	my $dbh     = shift;
	my $mech    = shift;
	my $co_name = shift;
	my $fname   = shift;
	my $sname   = shift;

	my ( $webhost, $inthost, $custhost, $supphost, $admhost, $staffhost ) =
	  Athena::getHostName();

	my $co_nameStr = $fname .'.'.$sname;
	$co_nameStr =~ s/\s//g;
	my $email = $co_nameStr . '@athena.systems';

	# form details

	my ( $strName, $city, $county, $country, $postcode ) =
	  &AthenaTest::getAddress;

	# form details
	my $add1 = $strName;
	my $add2 = '';
	my $add3 = '';
	my $tel  = &AthenaTest::getPhoneNumber;
	my $fax  = &AthenaTest::getPhoneNumber;
	my $mob  = &AthenaTest::getPhoneNumber;

	my %fields = (
		fname    => $fname,
		sname    => $sname,
		co_name  => $co_name,
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
		email    => $email
	);

	my $uri = $inthost . '/customers/add.php';
	$mech->get($uri);

	# add the supp
	$mech->submit_form( with_fields => \%fields );

	#	my $statement = "SELECT custid FROM cust  ORDER BY custid DESC LIMIT 1";
	#	my $custid    = $dbh->selectrow_array($statement);

#	if ( !DevTest::add_cust_contact( $dbh, $mech, $sitesid, 'Sys', 'Admin', $custid ) ) {
#		print "Couldn't add customer contact\n";
#	}

	if ( $mech->success() ) {
		return 1;
	} else {
		return 0;
	}
}

sub add_cust_contact {

	my $dbh   = shift;
	my $mech  = shift;
	my $fname = shift;
	my $sname = shift;

	my ( $webhost, $inthost, $custhost, $supphost, $admhost, $staffhost ) =
	  Athena::getHostName();

	# form details
	my $mob   = &AthenaTest::getPhoneNumber;
	my $email = $fname . '.' . $sname . '@athena.systems';

	# field details

	my %fields = (
		fname => $fname,
		sname => $sname,
		mob   => $mob,
		email => $email
	);

	# Get Random custid
	my $custid = &AthenaTest::getACustID($dbh);

	$fields{'custid'} = $custid;

	my $uri = $inthost . '/contacts/add.php';
	$mech->get($uri);

	# add the contact
	$mech->submit_form( with_fields => \%fields );

	#my $HTML = $mech->content();
	#print $HTML;

	if ( $mech->success() ) {
		return 1;
	} else {
		return 0;
	}
}

sub add_supp {

	my $dbh     = shift;
	my $mech    = shift;
	my $co_name = shift;

	my ( $webhost, $inthost, $custhost, $supphost, $admhost, $staffhost ) =
	  Athena::getHostName();

	my $co_nameStr = $co_name;
	$co_nameStr =~ s/\W/\./g;
	my $email = $co_nameStr . '@athena.systems';

	# form details

	my ( $strName, $city, $county, $country, $postcode ) =
	  &AthenaTest::getAddress;

	# form details
	my $add1 = $strName;
	my $tel  = &AthenaTest::getPhoneNumber;
	my $fax  = &AthenaTest::getPhoneNumber;

	my %fields = (
		co_name  => $co_name,
		add1     => $add1,
		city     => $city,
		county   => $county,
		country  => $country,
		postcode => $postcode,
		tel      => $tel,
		fax      => $fax,
		email    => $email
	);

	my $uri = $inthost . '/suppliers/add.php';
	$mech->get($uri);

	# add the supp
	$mech->submit_form( with_fields => \%fields );

	#	my $statement = "SELECT suppid FROM supp  ORDER BY suppid DESC LIMIT 1";
	#	my $suppid    = $dbh->selectrow_array($statement);

#	if ( !DevTest::add_supp_contact( $dbh, $mech, $sitesid, 'Sys', 'Admin', $suppid ) ) {
#		print "Couldn't add supplier\n";
#	}

	if ( $mech->success() ) {
		return 1;
	} else {
		return 0;
	}
}

sub add_supp_contact {

	my $dbh   = shift;
	my $mech  = shift;
	my $fname = shift;
	my $sname = shift;

	my ( $webhost, $inthost, $custhost, $supphost, $admhost, $staffhost ) =
	  Athena::getHostName();

	# form details
	my $mob   = &AthenaTest::getPhoneNumber;
	my $email = $fname . '.' . $sname . '@athena.systems';

	# field details

	my %fields = (
		fname => $fname,
		sname => $sname,
		mob   => $mob,
		email => $email
	);

	# Get Random suppid
	my $suppid = AthenaTest::getASuppID($dbh);

	$fields{'suppid'} = $suppid;

	my $uri = $inthost . '/contacts/add.php';
	$mech->get($uri);

	# add the contact
	$mech->submit_form( with_fields => \%fields );

	#my $HTML = $mech->content();
	#print $HTML;

	if ( $mech->success() ) {
		return 1;
	} else {
		return 0;
	}
}

sub add_quote {

	my $dbh     = shift;
	my $mech    = shift;
	my $sitesid = shift;

	my ( $webhost, $inthost, $custhost, $supphost, $admhost, $staffhost ) =
	  &Athena::getHostName();

	my $custid = &AthenaTest::getACustID($dbh);

	my $uri = $inthost . '/quotes/add?d=1&id=' . $custid;

	#print "$uri ...............\n";

	$mech->get($uri);

	my %fields = (
		custid               => $custid,
		'item[0][content]'   => &AthenaTest::generate_random_sentence,
		'item[0][singleprice]' => int( rand(200) + 10 ),
		'item[1][content]'   => &AthenaTest::generate_random_sentence,
		'item[1][quantity]'  => int( rand(20) + 1 ),
		'item[1][price]'     => int( rand(200) + 10 ),
		'item[2][content]'   => &AthenaTest::generate_random_sentence,
		'item[2][hours]'     => int( rand(20) + 1 ),
		'item[2][rate]'      => ( int( rand(7) + 1 ) ) * 5
	);
	my $cnt = rand(18) + 3;

	for ( my $i = 3 ; $i < $cnt ; $i++ ) {
		if ( $i % 2 ) {
			$fields{ 'item[' . $i . '][content]' } =
			  &AthenaTest::generate_random_sentence;
			$fields{ 'item[' . $i . '][quantity]' } = int( rand(20) + 1 );
			$fields{ 'item[' . $i . '][price]' }    = int( rand(200) + 10 );
		} else {
			$fields{ 'item[' . $i . '][content]' } =
			  &AthenaTest::generate_random_sentence;
			$fields{ 'item[' . $i . '][hours]' } = int( rand(20) + 1 );
			$fields{ 'item[' . $i . '][rate]' }  = ( int( rand(7) + 1 ) ) * 5;

		}
	}

	$mech->submit_form( with_fields => \%fields );

	# my @keys = sort { $a cmp $b } keys %fields;
	#    foreach my $key ( @keys ) {
	#   print "$key => $fields{$key} \n";
	#   }
	#my $HTML =  $mech->content();
	#print $HTML;

	if ( $mech->success() ) {
		my $statement =
		  "SELECT quotesid FROM quotes  ORDER BY quotesid DESC LIMIT 1";
		my ($quotesid) = $dbh->selectrow_array($statement);

		my $noItems = int( rand(6) );
		for ( my $i = 0 ; $i < $noItems ; $i++ ) {
			&DevOwner::add_quote_item( $dbh, $mech, $sitesid, $quotesid );
		}

		#
		# Make Quote Live
		#
		print '|';

		if ( !DevOwner::make_quote_live( $dbh, $mech, $sitesid, $quotesid ) ) {
			print "Couldn't Make Quote Live\n";
		}

		return 1;
	} else {
		return 0;
	}
}

sub add_quote_item {

	my $dbh      = shift;
	my $mech     = shift;
	my $sitesid  = shift;
	my $quotesid = shift;

	my ( $webhost, $inthost, $custhost, $supphost, $admhost, $staffhost ) =
	  Athena::getHostName();

	my $uri = $inthost . '/quotes/addqitems?id=' . $quotesid;

	#print "$uri ...............\n";

	$mech->get($uri);

	my %fields = ();

	$fields{"itemcontent"} = &AthenaTest::generate_random_sentence;
	$fields{"quantity"}    = int( rand(12) ) + 1;
	$fields{"price"}       = int( rand(1200) );

	$mech->submit_form( with_fields => \%fields );

	if ( $mech->success() ) {
		return 1;
	} else {
		return 0;
	}
}

sub make_quote_live {

	my $dbh      = shift;
	my $mech     = shift;
	my $sitesid  = shift;
	my $quotesid = shift;

	my ( $webhost, $inthost, $custhost, $supphost, $admhost, $staffhost ) =
	  Athena::getHostName();

	my $uri = $inthost . '/quotes/status?id=' . $quotesid;

	#print "$uri ...............\n";

	$mech->get($uri);

	#my $HTML =  $mech->content();
	#	print $HTML;
	# field details

	my %fields = ();

	$fields{"live"} = 1;

	$mech->submit_form( with_fields => \%fields );

	# my @keys = sort { $a cmp $b } keys %fields;
	#    foreach my $key ( @keys ) {
	#   print "$key => $fields{$key} \n";
	#   }
	#my $HTML =  $mech->content();
	#print $HTML;

	if ( $mech->success() ) {
		return 1;
	} else {
		return 0;
	}
}

sub add_job {

	my $dbh    = shift;
	my $mech   = shift;
	my $custid = shift;

	my ( $webhost, $inthost, $custhost, $supphost, $admhost, $staffhost ) =
	  Athena::getHostName();

	if ( !defined($custid) ) {
		$custid = AthenaTest::getACustID($dbh);
	}
	my %fields = ();
	$fields{"custid"}      = $custid;
	$fields{"custref"}     = &AthenaTest::generate_random_string(10);
	$fields{"itemcontent"} = &AthenaTest::generate_random_sentence;
	$fields{"quantity"}    = int( rand(12) ) + 1;
	$fields{"price"}       = int( rand(1000) );

	my $uri = $inthost . '/jobs/add';
	$mech->get($uri);

	# add the supp
	$mech->submit_form( with_fields => \%fields );

	if ( $mech->success() ) {
		return 1;
	} else {
		return 0;
	}

}

sub add_job_from_quote {

	my $dbh  = shift;
	my $mech = shift;

	my ( $webhost, $inthost, $custhost, $supphost, $admhost, $staffhost ) =
	  Athena::getHostName();

	my $statement = "SELECT qitemsid,price FROM qitems 
					WHERE  NOT EXISTS 
					( SELECT * FROM items WHERE qitems.qitemsid=items.qitemsid ) 
					
					AND price IS NOT NULL
					ORDER BY RAND() LIMIT 1";
	my ($itemsid) = $dbh->selectrow_array($statement);

	my $custid = AthenaTest::getACustID($dbh);

	my %fields = ();
	$fields{"custref"} = AthenaTest::generate_random_string(10);

	my $uri = $inthost . '/jobs/add.php?id=' . $itemsid;
	$mech->get($uri);

	# add the job
	$mech->submit_form( with_fields => \%fields );

	if ( $mech->success() ) {
		return 1;
	} else {
		return 0;
	}

}

sub add_job_items {

	my $dbh     = shift;
	my $mech    = shift;
	my $sitesid = shift;
	my $jobsid  = shift;

	my ( $webhost, $inthost, $custhost, $supphost, $admhost, $staffhost ) =
	  Athena::getHostName();

	my $sql = "SELECT jobitemsid FROM jobitems,jobs 
	WHERE jobsid=$jobsid
	AND jobs.itemsid=jobitems.itemsid";

	my $cursor = $dbh->prepare($sql);
	my $rtn    = $cursor->execute();

	while ( my @row = $cursor->fetchrow_array ) {

		my $jobitemsid = $row[0];

		#	my ($noOfSubItems) =

		#	while($dbh->selectrow_array($statement)){

		#	for ( my $i = 0 ; $i < $noOfSubItems ; $i++ ) {

		my %fields = (
			jobitemcontent => &AthenaTest::generate_random_string(10),
			notes          => &AthenaTest::generate_random_sentence
		);

		#,		cost           => int( rand(10000) )
		#		for ( my $i = 0 ; $i < 10 ; $i++ ) {
		#			if ( ( $i == 1 ) || ( $i == 3 ) || ( $i == 8 ) ) { next; }
		#			$fields{ 'est_' . $i } = int( rand(10) ) + 1;
		#		}
		my $uri = $inthost . "/jobitems/edit?id=$jobitemsid";
		$mech->get($uri);

		# edit the job item
		$mech->submit_form( with_fields => \%fields );

		#print $mech->content ."\n";exit;
	}
	if ( $mech->success() ) {
		return 1;
	} else {
		return 0;
	}
}

sub mark_job_finished {

	my $dbh  = shift;
	my $mech = shift;

	my ( $webhost, $inthost, $custhost, $supphost, $admhost, $staffhost ) =
	  Athena::getHostName();
	my $uri = $inthost . "/jobs/?from=0&perpage=4000";
	$mech->get($uri);

	#	print $mech->content;exit;

	$mech->follow_link( text => 'Mark Finished', n => 1 );

	if ( $mech->success() ) {
		return 1;
	} else {
		return 0;
	}

}

sub add_invoice {
	my $dbh  = shift;
	my $mech = shift;

	my ( $webhost, $inthost, $custhost, $supphost, $admhost, $staffhost ) =
	  &Athena::getHostName();

	my $custid = &AthenaTest::getACustID($dbh);
	my $uri    = $inthost . "/invoices/add?d=1&id=" . $custid;
	$mech->get($uri);

	#print "$uri ...............\n";
	my %fields = (
		custid               => $custid,
		'item[0][content]'   => &AthenaTest::generate_random_sentence,
		'item[0][singleprice]' => int( rand(200) + 10 ),
		'item[1][content]'   => &AthenaTest::generate_random_sentence,
		'item[1][quantity]'  => int( rand(20) + 1 ),
		'item[1][price]'     => int( rand(200) + 10 ),
		'item[2][content]'   => &AthenaTest::generate_random_sentence,
		'item[2][hours]'     => int( rand(20) + 1 ),
		'item[2][rate]'      => ( int( rand(7) + 1 ) ) * 5
	);
	my $cnt = rand(18) + 3;

	for ( my $i = 3 ; $i < $cnt ; $i++ ) {
		if ( $i % 2 ) {
			$fields{ 'item[' . $i . '][content]' } =
			  &AthenaTest::generate_random_sentence;
			$fields{ 'item[' . $i . '][quantity]' } = int( rand(20) + 1 );
			$fields{ 'item[' . $i . '][price]' }    = int( rand(200) + 10 );
		} else {
			$fields{ 'item[' . $i . '][content]' } =
			  &AthenaTest::generate_random_sentence;
			$fields{ 'item[' . $i . '][hours]' } = int( rand(20) + 1 );
			$fields{ 'item[' . $i . '][rate]' }  = ( int( rand(7) + 1 ) ) * 5;

		}
	}

	#	my $contactsid = AthenaTest::getACustContactID( $dbh, $custid );
	#	$fields{"contactsid"} = $contactsid;

	#$fields{"content"}    = AthenaTest::generate_random_sentence;

	# edit the job item
	$mech->submit_form( with_fields => \%fields );
#	print $mech->content;exit;
}

sub add_cost {
	my $dbh     = shift;
	my $mech    = shift;
	my $co_name = shift;
	my $price   = ( int( rand(20) ) + 1 ) * 5;
	my ( $webhost, $inthost, $custhost, $supphost, $admhost, $staffhost ) =
	  Athena::getHostName();
	  
	my $uri = $inthost . "/costs/add";
	$mech->get($uri);

	my %fields = (
		expsid      => ( int( rand(8) ) + 1 ),
		price       => $price,
		description => &AthenaTest::generate_random_sentence,
		supplier    => $co_name
	);

	# Add the cost
	$mech->submit_form( with_fields => \%fields );

}

sub add_new_invoice {
	my $dbh      = shift;
	my $mech     = shift;
	my $price    = ( int( rand(20) ) + 1 ) * 5;
	my $quantity = int( rand(20) ) + 1;
	my $custid   = &AthenaTest::getACustID($dbh);

	my ( $webhost, $inthost, $custhost, $supphost, $admhost, $staffhost ) =
	  &Athena::getHostName();

	my %fields = (
		custid      => $custid,
		price       => $price,
		description => &AthenaTest::generate_random_sentence,
		quantity    => $quantity
	);

	my $uri = $inthost . "/invoices/add?id=$custid";
	$mech->get($uri);

	# edit the job item
	$mech->submit_form( with_fields => \%fields );

}

sub response_quote_request {

	my $dbh  = shift;
	my $mech = shift;

	#	my $sitesid = shift;

	my ( $webhost, $inthost, $custhost, $supphost, $admhost, $staffhost ) =
	  Athena::getHostName();

#	my ( $admin_logon, $pass ) = AthenaTest::getNonRootAdminLogin( $dbh, $sitesid );
#	&AthenaTest::login( $mech, $admin_logon, $pass, $inthost, $sitesid );

	my $statement = "SELECT itemsid FROM quotes,items 
					WHERE origin='ext' AND 
					quotes.quotesid=items.quotesid AND
					(items.price IS NULL OR
					items.delivery IS NULL)
					ORDER BY RAND() LIMIT 1";

	while ( my ($itemsid) = $dbh->selectrow_array($statement) ) {
		if ( ( !defined($itemsid) ) || ( $itemsid eq '' ) ) {
			return 0;
		}
		my $uri = $inthost . '/items/edit.php?id=' . $itemsid;

		#print "$uri ...............\n";

		$mech->get($uri);

		# field details

		my %fields = ();

		my $deltime = int( rand(6) ) + 1;
		my $deloffdate = time() + ( $deltime * 60 * 60 * 24 * 6 );

		my ( $sec, $min, $hour, $mday, $mon, $year, $wday, $yday, $isdst ) =
		  localtime($deloffdate);
		my $deloffdateCP = $mday . '-' . ( $mon + 1 ) . '-' . ( $year - 100 );

		$fields{"delivery"} = ( int( rand(6) ) + 1 ) . ' weeks';
		$fields{"price"}    = int( rand(1200) );
		$fields{"dateoff"}  = $deloffdateCP;

		$mech->submit_form( with_fields => \%fields );
	}

	# my @keys = sort { $a cmp $b } keys %fields;
	#    foreach my $key ( @keys ) {
	#   print "$key => $fields{$key} \n";
	#   }
	#my $HTML =  $mech->content();
	#print $HTML;

	if ( $mech->success() ) {
		return 1;
	} else {
		return 0;
	}
}

sub editCustomer {

	my $dbh     = shift;
	my $mech    = shift;
	my $sitesid = shift;

	my ( $webhost, $inthost, $custhost, $supphost, $admhost, $staffhost ) =
	  Athena::getHostName();

	my $rand_hex = join "", map { unpack "H*", chr( rand(256) ) } 1 .. 6;
	$rand_hex = '#' . $rand_hex;

	my %fields = ( colour => $rand_hex );

	my $uri =
	    $inthost
	  . '/customers/edit.php?id='
	  . &AthenaTest::getACustID( $dbh, $sitesid );
	$mech->get($uri);

	# edit the cust
	$mech->submit_form( with_fields => \%fields );

	if ( $mech->success() ) {
		return 1;
	} else {
		return 0;
	}
}

sub editSupplier {

	my $dbh  = shift;
	my $mech = shift;

	my ( $webhost, $inthost, $custhost, $supphost, $admhost, $staffhost ) =
	  Athena::getHostName();

	my $rand_hex = join "", map { unpack "H*", chr( rand(256) ) } 1 .. 6;
	$rand_hex = '#' . $rand_hex;

	my %fields = ( colour => $rand_hex );

	my $uri =
	  $inthost . '/suppliers/edit.php?id=' . AthenaTest::getASuppID($dbh);
	$mech->get($uri);

	# edit the supplier
	$mech->submit_form( with_fields => \%fields );

	if ( $mech->success() ) {
		return 1;
	} else {
		return 0;
	}
}

sub requestSupplierQuote {

	my $dbh     = shift;
	my $mech    = shift;
	my $sitesid = shift;

	my ( $webhost, $inthost, $custhost, $supphost, $admhost, $staffhost ) =
	  Athena::getHostName();

	my $deltime = int( rand(6) ) + 1;
	my $delreqdate = time() + ( $deltime * 60 * 60 * 24 * 7 );
	my ( $sec, $min, $hour, $mday, $mon, $year, $wday, $yday, $isdst ) =
	  localtime($delreqdate);
	my $delreqdateCP = $mday . '-' . ( $mon + 1 ) . '-' . ( $year - 100 );

	my %fields = (
		staffid  => &AthenaTest::getAStaffID( $dbh, $sitesid ),
		content  => &AthenaTest::generate_random_sentence,
		datereq  => $delreqdateCP,
		quantity => int( rand(12) ) + 1,
		jobno    => &AthenaTest::getAJobNo( $dbh,   $sitesid ),
		notes    => &AthenaTest::generate_random_sentence
	);

#
#	my ( $admin_logon, $pass ) = AthenaTest::getNonRootAdminLogin( $dbh, $sitesid );
#	&AthenaTest::login( $mech, $admin_logon, $pass, $inthost );

	my $uri = $inthost . '/orders/add.php';
	$mech->get($uri);

	# add the quote request to supplier
	$mech->submit_form( with_fields => \%fields );

	if ( $mech->success() ) {
		return 1;
	} else {
		return 0;
	}
}

sub sendRequestSupplierQuote {

	my $dbh  = shift;
	my $mech = shift;

	my ( $webhost, $inthost, $custhost, $supphost, $admhost, $staffhost ) =
	  Athena::getHostName();

	my $ordersid = AthenaTest::getAnOrderID($dbh);
	my $uri      = $inthost . "/orders/send?id=$ordersid";
	$mech->get($uri);

	my $sql    = "SELECT suppid,co_name FROM supp ORDER BY RAND() LIMIT 2";
	my $cursor = $dbh->prepare($sql);
	my $rtn    = $cursor->execute();
	while ( my @row = $cursor->fetchrow_array ) {
		my $suppid = $row[0];
		$mech->tick( 'suppids[]', $suppid );
	}

	# add the quote request to supplier
	$mech->submit_form();

	if ( $mech->success() ) {
		return 1;
	} else {
		return 0;
	}
}

sub agree_to_supplier_quote {

	my $dbh  = shift;
	my $mech = shift;

	my ( $webhost, $inthost, $custhost, $supphost, $admhost, $staffhost ) =
	  Athena::getHostName();

#	my ( $admin_logon, $pass ) = AthenaTest::getNonRootAdminLogin( $dbh, $sitesid );
#	&AthenaTest::login( $mech, $admin_logon, $pass, $inthost, $sitesid );

	my $uri = $inthost . '/orders/';

	#print $uri ."\n";
	$mech->get($uri);

	# get all links whose text is "View Offer"
	my @supp_orders = $mech->find_all_links(
		tag        => "a",
		text_regex => qr/^View Offer/,
	);

	#print $#supp_orders . "\n";
	#exit;

	if ( defined( $supp_orders[0] ) ) {
		my $lnk2follow = int( rand($#supp_orders) );

		$mech->follow_link( text => 'View Offer', n => $lnk2follow );

		my $deltime = int( rand(6) ) + 1;
		my $delreqdate = time() + ( $deltime * 60 * 60 * 24 * 7 );
		my ( $sec, $min, $hour, $mday, $mon, $year, $wday, $yday, $isdst ) =
		  localtime($delreqdate);
		my $delreqdateCP = $mday . '-' . ( $mon + 1 ) . '-' . ( $year - 100 );

		my %fields = ( dateok => $delreqdateCP );

#	$statement = "SELECT suppid FROM order_req WHERE orderid=$ordersid ORDER BY order_reqid";
#	my ($suppid) = $dbh->selectrow_array($statement);
#my $uri = $inthost . '/orders/view_offer?id=' . $ordersid . '&suppid=' . $suppid;
#print $uri . "\n";
#$mech->get($uri);

		# add the order request
		$mech->submit_form( with_fields => \%fields );
	}
	if ( $mech->success() ) {
		return 1;
	} else {
		return 0;
	}
}

sub add_stock {

	my $dbh     = shift;
	my $mech    = shift;

	my ( $webhost, $inthost, $custhost, $supphost, $admhost, $staffhost ) =
	  Athena::getHostName();

	
	my %fields = (
		name  => 'Product '.int(rand(10000)+1),
		description  => &AthenaTest::generate_random_sentence,
		stockq  => int( rand(12) ) + 1,
		sku    => &AthenaTest::generate_random_string(10),
		price    => int( rand(120) ) + 1
	);


	my $uri = $inthost . '/stock/add.php';
	$mech->get($uri);

	# add the quote request to supplier
	$mech->submit_form( with_fields => \%fields );

	if ( $mech->success() ) {
		return 1;
	} else {
		return 0;
	}
}


1;


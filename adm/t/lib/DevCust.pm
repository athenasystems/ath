package DevCust;

use strict;

sub add_cust_quote_request {

	my $dbh     = shift;
	my $mech    = shift;
	my $sitesid = shift;

	my ( $webhost, $inthost, $custhost, $supphost, $admhost, $staffhost ) =
	  Athena::getHostName();
	my ( $admin_logon, $pass ) = AthenaTest::getCustLogin( $dbh );
	&AthenaTest::login( $mech, $admin_logon, $pass, $custhost, $sitesid );

	my $custid = AthenaTest::getACustID($dbh);

	my %fields = ();

	$fields{"custid"} = $custid;

	#	my $contactsid = AthenaTest::getACustContactID( $dbh, $custid );
	#	$fields{"contactsid"} = $contactsid;

	#$fields{"staffid"} = &AthenaTest::getAStaffID( $dbh, $sitesid );
	#$fields{"content"} = &AthenaTest::generate_random_sentence;

	my $noOfQuoteItems = int( rand(10) ) + 1;

	for ( my $i = 0 ; $i < $noOfQuoteItems ; $i++ ) {

		my $deltime = int( rand(6) ) + 1;
		my $delreqdate = time() + ( $deltime * 60 * 60 * 24 * 7 );

		my ( $sec, $min, $hour, $mday, $mon, $year, $wday, $yday, $isdst ) =
		  localtime($delreqdate);
		my $delreqdateCP = $mday . '-' . ( $mon + 1 ) . '-' . ( $year - 100 );

		$fields{"item[$i][content]"}  = &AthenaTest::generate_random_sentence;
		$fields{"item[$i][quantity]"} = int( rand(12) ) + 1;

		$mon++;
		$year                               = $year - 100;
		$fields{"item[$i][datereq][day]"}   = $mday;
		$fields{"item[$i][datereq][month]"} = $mon;
		$fields{"item[$i][datereq][year]"}  = $year;

	}

	my $uri = $custhost . '/quotes/add.php';

	#print $uri ."\n";
	$mech->get($uri);

	# print $mech->content ."\n";

	# add the cust
	$mech->submit_form( with_fields => \%fields );

	if ( $mech->success() ) {
		return 1;
	} else {
		return 0;
	}
}

sub custAgreeToQuote {

	my $dbh     = shift;
	my $mech    = shift;
	my $sitesid = shift;

	my ( $webhost, $inthost, $custhost, $supphost, $admhost, $staffhost ) =
	  Athena::getHostName();

	my $custid = AthenaTest::getACustID($dbh);

	my ( $admin_logon, $pass ) =
	  AthenaTest::getCustLogin( $dbh, $sitesid, $custid );
	&AthenaTest::login( $mech, $admin_logon, $pass, $custhost, $sitesid );

	my $uri = $custhost . '/quotes/';

	#print $uri . "\n";
	$mech->get($uri);

	# get all links whose text is "View Offer"
	my @orders = $mech->find_all_links(
		tag        => "a",
		text_regex => qr/^View Offer/,
	);

	#print $#orders . " - $custid\n";

	#exit;

	my $lnk2follow = int( rand($#orders) );

	# go to quote
	$mech->follow_link( text => 'View Offer', n => $lnk2follow );

	my @frms = $mech->forms;
	if ( defined( $frms[0] ) ) {

		#	print $#frms . " Agree to this Items\n";

		my $form2click = int( rand($#frms) );

		# agree to quote
		$mech->submit_form( form_number => $form2click );
	} else {
		print "No Forms here\n";
	}
	if ( $mech->success() ) {
		return 1;
	} else {
		return 0;
	}
}

1;

package DevSupp;

sub supp_quote_request_response {

	my $dbh     = shift;
	my $mech    = shift;
	my $sitesid = shift;

	my $suppid = AthenaTest::getASuppID($dbh);

	my ( $webhost, $inthost, $custhost, $supphost, $admhost, $staffhost ) = Athena::getHostName();
	my ( $admin_logon, $pass ) = AthenaTest::getSuppLogin( $dbh, $suppid );
	&AthenaTest::login( $mech, $admin_logon, $pass, $supphost, $sitesid );

	my $uri = $supphost . '/quotes/';

	#print $uri ."\n";
	$mech->get($uri);

	# get all links whose text is "View Request for Quote"
	my @supp_orders = $mech->find_all_links(
		tag        => "a",
		text_regex => qr/^View Request for Quote/,
	);

	#print $#supp_orders . "\n";

	#exit;

	my $lnk2follow = int( rand($#supp_orders) );

	$mech->follow_link( text => 'View Request for Quote', n => $lnk2follow );

	my $deltime = int( rand(6) ) + 1;
	my $delreqdate = time() + ( $deltime * 60 * 60 * 24 * 7 );
	my ( $sec, $min, $hour, $mday, $mon, $year, $wday, $yday, $isdst ) = localtime($delreqdate);
	my $delreqdateCP = $mday . '-' . ( $mon + 1 ) . '-' . ( $year - 100 );

	my %fields = (
		dateoff  => $delreqdateCP,
		priceoff => int( rand(1200) ) + 20,
		notes    => AthenaTest::generate_random_sentence
	);

	#my $uri = $supphost . '/quotes/view.php?id=' . $ordersid;

	#print $uri ."\n";
	#$mech->get($uri);

	#print $mech->content ."\n";

	# add the supp
	$mech->submit_form( with_fields => \%fields );

	if ( $mech->success() ) {
		return 1;
	}
	else {
		return 0;
	}
}





1;

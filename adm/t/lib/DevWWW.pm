package DevWWW;

sub add_site {

	my $mech    = shift;
	my $co_name = shift;
	my $fname   = shift;
	my $sname   = shift;
	my ( $webhost, $inthost, $custhost, $supphost, $admhost ) =
	  Athena::getHostName();
	my ( $strName, $city, $county, $country, $postcode ) =
	  AthenaTest::getAddress;

	# form details
	my $tel   = AthenaTest::getPhoneNumber;
	my $email = 'wmodtest@gmail.com';

	my $uri = 'https://signup.athena.systems/?b='.int(rand(2));

	#print "$uri ...............\n";
	$mech->get($uri);

	# field details
	my %fields = (
		fname   => $fname,
		sname   => $sname,
		co_name => $co_name,
		tel     => $tel,
		email   => $email
	);

	$mech->submit_form( with_fields => \%fields );

	#print "Got to " . $mech->uri();

	if ( $mech->success() ) {
		return 1;
	} else {
		return 0;
	}
}

sub rfq {

	my $dbh     = shift;
	my $mech    = shift;
	my $sitesid = shift;
	my $fname   = shift;
	my $sname   = shift;

	# form details
	my $tel   = AthenaTest::getPhoneNumber;
	my $email = 'wmodtest@gmail.com';

	my %fields = (
		fname   => $fname,
		sname   => $sname,
		tel     => $tel,
		email   => $email,
		content => AthenaTest::generate_random_sentence
	);

	my $uri = 'https://' . $sitesid . '.athena.systems/quote';
	$mech->get($uri);

	#print "\n$mech->#### $uri\n";
	#print $mech->content() . "\n\n";
	# add the supp
	$mech->submit_form( with_fields => \%fields );

}

1;

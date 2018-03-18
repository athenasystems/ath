package AthenaTest;

use strict;

sub dbsysconnect {
	my $dbh =
	  DBI->connect( "DBI:mysql:athcore:localhost", 'athena',
		Athena::getDBPass(), { RaiseError => 1 } );
	return ($dbh);
}

sub login {

	my ( $mech, $logon, $pass, $host, $sitesid ) = @_;

	my $uri = 'https://' . $sitesid . '.athena.systems/login.php';

	#my $uri = "$host/login.php";

	#print "Tried:" . $logon . ':' . $pass . ':' . $uri . "\n";

	$mech->get($uri);
	
	my $type = '';
	
	if($host=~/mng/){
		$type = 'staff';
	}elsif($host=~/customers/){
		$type = 'cust';
	}elsif($host=~/suppliers/){
		$type = 'supp';
	}

	#print $mech->content();
	my $ppw    = `/usr/bin/php /srv/ath/src/php/adm/uncrypt.php $sitesid $type`;
	my %fields = (

		#sid  => $sitesid,
		nick => $logon,
		pw   => $ppw
	);

	#print "Tried:$sitesid $pass " . $ppw . ':' . $fields{'nick'} . "\n";

	$mech->submit_form( with_fields => \%fields );

	#print "Got to ..." . $mech->uri() . "\n";

	$mech->submit_form();

	#print "Got to ..." . $mech->uri() . "\n";
	#
	return $mech;
}

sub generate_random_sentence {

	my $sentence = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat';
	my @words = split(/ /,$sentence);
	my $l = int(rand(scalar(@words)+1));
	my $ret = '';
	for(my $i=0;$i<$l;$i++){
		$ret .= $words[$i] . ' ';
	}
	return $ret;
}

sub generate_random_string {
	my $length_of_randomstring = shift;    # the length of
	                                       # the random string to generate

	my @chars = ( 'a' .. 'z', 'A' .. 'Z', '0' .. '9', '_' );
	my $random_string;
	foreach ( 1 .. $length_of_randomstring ) {

		# rand @chars will generate a random
		# number between 0 and scalar @chars
		$random_string .= $chars[ rand @chars ];
	}
	return $random_string;
}

sub cleanText {
	my $text = shift;
	$text =~ s/'/\\'/gs;
	return $text;

}

sub getPhoneNumber {
	return
	    '+44' . ' '
	  . int( rand(1000) + 800 ) . ' '
	  . int( rand(100000) + 80000 );
}

sub getStreetName {

	my @nms = ();
	open( FHMQ, "</srv/ath/adm/t/dev/rsc/sn_out.txt" );
	while (<FHMQ>) {
		chomp;
		s/\r//g;
		tr/[A-Z]/[a-z]/;
		s/\b([a-z])/\u$1/g;
		push( @nms, $_ );
	}
	close(FHMQ);

	my $ret = $nms[ ( int( rand( @nms + 1 ) ) ) ];

	return $ret;
}

sub getAddress {

	open( FHM, "</srv/ath/adm/t/dev/rsc/uk_postcodes.csv" );

	my $toGet = int( rand(2849) );
	my $cnt   = 0;
	my ( $postcode, $town, $county, $country );
	while (<FHM>) {
		$cnt++;
		if ( $cnt != $toGet ) { next; }
		chomp;
		s/\r//g;

		#print "\nhere\n";

		#s/\b([a-z])/\u$1/g;
		( $postcode, $town, $county, $country ) = split( /,/, $_ );
		last;
	}
	close(FHM);
	my $strName = int( rand(300) ) . ' ' . getStreetName;
	$postcode =
	  $postcode . ' ' . uc( generate_random_string(2) ) . int( rand(100) );

	#print "\n$strName\n";
	return ( $strName, $town, $county, $country, $postcode );
}

sub getAdminLogin {

	my $dbhsite = shift;

	my $statement = "SELECT usr,init FROM pwd
					WHERE staffid=1000 LIMIT 1";

	my ( $admin_logon, $pass ) = $dbhsite->selectrow_array($statement);

	#my $plain_pw = uncrypt($pass);

	#	print "Tried:$admin_logon, $pass $plain_pw \n";
	return ( $admin_logon, $pass );
}

sub getNonRootAdminLogin {

	my $dbh = shift;

	my $statement = "SELECT logon,init_pw FROM staff,pwd 
					WHERE fname<>'Athena' 
					AND sname<>'Admin' 
					AND seclev=1 
					AND staff.staffid=pwd.staffid
					ORDER BY RAND() LIMIT 1";

	my ( $admin_logon, $pass ) = $dbh->selectrow_array($statement);

	return ( $admin_logon, $pass );
}

sub getSuppLogin {

	my $dbh    = shift;
	my $suppid = shift;

	my $statement = "SELECT logon,init_pw FROM contacts 
	WHERE fname<>'System' 
	AND sname<>'Administrator' 
	AND suppid=$suppid 
	ORDER BY contactsid LIMIT 1";

	#print $statement;
	my ( $supp_logon, $pass ) = $dbh->selectrow_array($statement);

	return ( $supp_logon, $pass );
}

sub getASuppLogin {

	my $dbh = shift;

	my $statement =
	  "SELECT logon,init_pw FROM contacts  ORDER BY contactsid LIMIT 1";

	my ( $supp_logon, $pass ) = $dbh->selectrow_array($statement);

	return ( $supp_logon, $pass );
}

sub getCustLogin {

	my $dbh    = shift;
	my $custid = shift;

	my $statement = 'SELECT usr,init 
	FROM pwd  
	WHERE usr LIKE "ca10%" 
	ORDER BY custid LIMIT 1';
	
	#print $statement;
	my ( $cust_logon, $pass ) = $dbh->selectrow_array($statement);
	#print "Tried:$cust_logon, $pass \n";
	return ( $cust_logon, $pass );
}

sub getStaffLogin {

	my $dbh = shift;

	my $statement = "SELECT logon,init_pw FROM staff,pwd 
					 WHERE fname<>'System' 
					 AND sname<>'Administrator' 
					 AND staff.staffid=pwd.staffid
					 AND pwd.seclev>1
					 ORDER BY RAND() LIMIT 1";

	my ( $staff_logon, $pass ) = $dbh->selectrow_array($statement);

	return ( $staff_logon, $pass );
}

sub getACustID {
	my $dbh = shift;

	my $statement =
	  "SELECT custid FROM cust WHERE custid>0 ORDER BY RAND() LIMIT 1";
	my ($custid) = $dbh->selectrow_array($statement);
	return $custid;
}

sub getACustWithFinishedJobsID {
	my $dbh = shift;

	my $statement = "SELECT custid FROM jobs WHERE custid>0 AND
	done>0 ORDER BY RAND() LIMIT 1";
	my ($custid) = $dbh->selectrow_array($statement);
	return $custid;
}

sub getASuppID {
	my $dbh = shift;

	my $statement = "SELECT suppid FROM supp ORDER BY RAND() LIMIT 1";
	my ($suppid) = $dbh->selectrow_array($statement);
	return $suppid;
}

sub getAStaffID {
	my $dbh       = shift;
	my $statement = "SELECT staffid FROM staff 
	WHERE fname<>'System' 
	AND sname<>'Administrator' 
	ORDER BY RAND() LIMIT 1";
	my ($staffid) = $dbh->selectrow_array($statement);
	return $staffid;
}

sub getACustContactID {
	my $dbh    = shift;
	my $custid = shift;

	my $statement = "SELECT contactsid FROM contacts 
	WHERE fname<>'System' 
	AND sname<>'Administrator' 
	AND custid=$custid 
	ORDER BY RAND() LIMIT 1";
	my ($contactsid) = $dbh->selectrow_array($statement);
	return $contactsid;
}

sub getAnOrderID {
	my $dbh       = shift;
	my $statement = "SELECT ordersid FROM orders  ORDER BY RAND() LIMIT 1";
	my ($staffid) = $dbh->selectrow_array($statement);
	return $staffid;
}

sub getAJobNo {
	my $dbh       = shift;
	my $statement = "SELECT jobno FROM jobs  ORDER BY RAND() LIMIT 1";
	my ($staffid) = $dbh->selectrow_array($statement);
	return $staffid;
}

sub getAJobID {
	my $dbh       = shift;
	my $statement = "SELECT jobsid FROM jobs  ORDER BY RAND() LIMIT 1";
	my ($jobsid)  = $dbh->selectrow_array($statement);
	return $jobsid;
}

sub getATeamID {
	my $dbh       = shift;
	my $sitesid   = shift;
	my $statement = "SELECT teamsid FROM teams ORDER BY RAND() LIMIT 1";    #
	my ($jobsid)  = $dbh->selectrow_array($statement);
	return $jobsid;
}

sub generatelogon {
	my $fname = shift;
	my $sname = shift;
	my $logon = lc("$fname.$sname");
	my $cnt   = 1;

	return $logon;

}

sub docrypt {
	my $plain_text = shift;

	my $key       = "gg65RxmMmJjk9Io0OhR4eDtY";    # 24 bit Key
	my $iv        = "fYfhHeDm";                    # 8 bit IV
	my $bit_check = 8;                             # bit amount for diff algor.

	my $algorithm = "tripledes";
	my $mode      = "cbc";
	my $obj       = Crypt::MCrypt->new(
		algorithm => $algorithm,
		mode      => $mode,
		key       => $key,
		iv        => $iv,
	);
	my $hash = $obj->decrypt($plain_text);
	return $hash;
}

sub uncrypt {

	my $hash = shift;

	my $key       = "gg65RxmMmJjk9Io0OhR4eDtY";    # 24 bit Key
	my $iv        = "fYfhHeDm";                    # 8 bit IV
	my $bit_check = 8;                             # bit amount for diff algor.

	my $algorithm = "tripledes";
	my $mode      = "cbc";
	my $obj       = Crypt::MCrypt->new(
		algorithm => $algorithm,
		mode      => $mode,
		key       => $key,
		iv        => $iv,
	);
	my $plain_text = $obj->decrypt($hash);
	return $plain_text;
}
1;

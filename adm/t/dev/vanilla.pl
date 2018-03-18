#!/usr/bin/perl

my $user = $>;
if ($user) {
	print "\nGotta be root! Not " . $user . "\n";
	exit;
}
use strict;
use WWW::Mechanize;
use DBI;
use lib('/srv/ath/src/perl/lib/');
use Athena;
use lib('/srv/ath/adm/t/lib/');
use AthenaTest;
use DevTest;
use DevOwner;
use DevCust;
use DevSupp;
use DevStaff;
use DevWWW;

my @male    = ();
my @female  = ();
my @surname = ();
loadNames();

#system("/srv/ath/adm/phpStartPoint.pl athcore");
#system("/srv/ath/adm/phpStartPoint.pl athdb100");

my $mech = WWW::Mechanize->new( 'ssl_opts' => { 'verify_hostname' => 0 } );

my $quick = shift;
if ( !defined($quick) ) { $quick = 0; }
my $noOfSites                        = ($quick) ? 1 : 3;
my $noOfStaff                        = ($quick) ? 1 : 3;
my $noOfSuppliers                    = ($quick) ? 1 : 6;
my $noOfSuppContacts                 = ($quick) ? 1 : $noOfSuppliers * 2;
my $noOfCustomers                    = ($quick) ? 1 : 6;
my $noOfCustContacts                 = ($quick) ? 1 : $noOfCustomers * 2;
my $noOfQuotes                       = ($quick) ? 1 : 12;
my $CustomersInitiatesRequestQuote   = ($quick) ? 1 : 12;
my $noOfOwnerQuoteResponses          = ($quick) ? 1 : 6;
my $noOfJobs                         = ($quick) ? 1 : 60;
my $noOfFinishedJobs                 = ($quick) ? 1 : 30;
my $noOfTcardMoves                   = ($quick) ? 1 : 260;
my $noOfInvoices                     = ($quick) ? 1 : 12;
my $noOfRequestQuotes                = ($quick) ? 1 : 20;
my $noOfSupplierRespondsQuoteRequest = ($quick) ? 1 : 20;
my $noOfAgreeToQuote                 = ($quick) ? 1 : 12;
my $noOfTasks                        = ($quick) ? 1 : 12;
my $noOfCosts                        = ($quick) ? 1 : 12;
my $noOfStock                        = ($quick) ? 1 : 12;

# Add Sites
print "\n#### Adding new Sites ";
for ( 1 .. $noOfSites ) {
	my ( $fname, $sname ) = split( / /, &getName('rn') );
	my ($coname) = &getName('c');
	if ( !DevWWW::add_site( $mech, $coname,$fname, $sname ) ) {
		print " Couldn't add Site\n";
	}
	system("php /srv/ath/src/php/cron/new.site.php");

	#next;
	my $dbhroot = &Athena::dbrootconnect();
	my $sql = "SELECT sitesid,co_name FROM sites ORDER BY sitesid DESC LIMIT 1";

	my $cursor = $dbhroot->prepare($sql);
	my $rtn    = $cursor->execute();

	my @row     = $cursor->fetchrow_array;
	my $sitesid = lc( $row[0] );
	my $co      = $row[1];

	my $dbhsite = Athena::dbsiteconnect($sitesid);

	#
	my ( $webhost, $inthost, $custhost, $supphost, $admhost, $staffhost ) =
	  Athena::getHostName();
	my ( $admin_logon, $pass ) =
	  AthenaTest::getAdminLogin( $dbhsite, $sitesid );

	&AthenaTest::login( $mech, $admin_logon, $pass, $inthost, $sitesid );

	print "\n#### Updating Site Owner ";
	print ".";
	( $fname, $sname ) = split( / /, &getName('rn') );
	if ( !DevTest::updateOwner( $dbhsite, $mech, $co, $fname, $sname ) ) {
		print "Couldn't update owner\n";
	}

	# Add Modules
	print "\n#### Adding new Modules Site No: $sitesid ";
	print ".";
	my @mods = (1,28);
	if ( !DevTest::add_modules( $dbhsite, $mech, \@mods ) ) {
		print "Couldn't add Modules\n";
	}

	# Set Initial Numbering
	print "\n#### Setting Initial Numbering Site No: $sitesid ";
	print ".";
	if ( !DevTest::set_initialInvoiceNo( $dbhsite, $mech ) ) {
		print "Couldn't Set Initial Numbering ";
	}
	if ( !DevTest::set_initialQuoteno( $dbhsite, $mech ) ) {
		print "Couldn't Set Initial Numbering ";
	}

	# Add Customers
	print "\n#### Adding new Customers Site No: $sitesid ";
	my $cnt = 0;
	for ( 1 .. $noOfCustomers ) {
		print ".";
		my ($coname) = &getName('c');
		my ( $fname, $sname ) = split( / /, &getName('rn') );
		if ( $cnt % 2 ) { $coname = ''; }
		if ( !DevOwner::add_cust( $dbhsite, $mech, $coname, $fname, $sname ) ) {
			print "Couldn't add Customers\n";
		}
		$cnt++;
	}

	# Create Invoice
	print "\n#### Creating new Invoice Site No: $sitesid ";
	for ( 1 .. $noOfInvoices ) {
		print ".";
		if ( !DevOwner::add_invoice( $dbhsite, $mech ) ) {
			print "Couldn't add invoice\n";
		}

	}

	# Owner Adds a Quote
	print "\n#### Owner Adding new Quotes Site No: $sitesid ";
	for ( 1 .. $noOfQuotes ) {
		print ".";
		if ( !DevOwner::add_quote( $dbhsite, $mech, $sitesid ) ) {
			print "Couldn't add quote\n";
		}
	}

	# Edit Customers
	print "\n#### Editing Customers Site No: $sitesid ";
	for ( 1 .. $noOfCustomers ) {
		print ".";
		if ( !DevOwner::editCustomer( $dbhsite, $mech, $sitesid ) ) {
			print "Couldn't edit Customers\n";
		}
	}

	# Add RFQ
	print "\n#### Requesting a Quote Site No: $sitesid ";
	for ( 1 .. $noOfQuotes ) {
		print ".";
		my ( $fname, $sname ) = split( / /, &getName('rn') );
		if ( !DevWWW::rfq( $dbhsite, $mech, $sitesid, $fname, $sname ) ) {
			print "Requesting a Quote\n";
		}
	}

	# Add Costs
	print "\n#### Owner Adding Costs Site No: $sitesid ";
	for ( 1 .. $noOfCosts ) {
		print ".";
		my ($coname) = &getName('c');
		if ( !DevOwner::add_cost( $dbhsite, $mech, $coname ) ) {
			print "Couldn't add Costs\n";
		}
	}


	# Add Modules
	print "\n#### Adding new Modules Site No: $sitesid ";
	print ".";
	@mods = (7,13,14,15,17);
	if ( !DevTest::add_modules( $dbhsite, $mech, \@mods ) ) {
		print "Couldn't add Modules\n";
	}


	# Add Staff
	print "\n#### Adding new Staff Site No: $sitesid ";
	for ( 1 .. $noOfStaff ) {
		print ".";
		my ( $fname, $sname ) = split( / /, &getName('rn') );
		#print "$fname, $sname\n";
		if ( !DevOwner::add_staff( $dbhsite, $mech, $fname, $sname ) ) {
			print "Couldn't add staff\n";
		}
	}
	
	# Add Stock
	print "\n#### Adding new Stock Site No: $sitesid ";
	for ( 1 .. $noOfStock  ) {
		print ".";
		if ( !DevOwner::add_stock( $dbhsite, $mech ) ) {
			print "Couldn't add Stock\n";
		}
	}
	

	print "\n#### Making the Web Pages for Site No: $sitesid";
	system(
		"sudo /usr/bin/perl /srv/ath/src/perl/cron/build.web.pages.pl $sitesid"
	);

	print "\n#### Done Site No: $sitesid\n\n";
}
print "\n\n#### Done All\n\n";
exit;

sub loadNames {
	open( FHM, "</srv/ath/adm/t/dev/rsc/dist.male.first" );
	while (<FHM>) {
		chomp;
		s/^(\w+).*$/$1/;
		tr/A-Z/a-z/;
		s/\b([a-z])/\u$1/g;
		push( @male, $_ );
	}

	open( FHF, "</srv/ath/adm/t/dev/rsc/dist.female.first" );
	while (<FHF>) {
		chomp;
		s/^(\w+).*$/$1/;
		tr/A-Z/a-z/;
		s/\b([a-z])/\u$1/g;
		push( @female, $_ );
	}

	open( FHS, "</srv/ath/adm/t/dev/rsc/dist.all.last" );
	while (<FHS>) {
		chomp;
		s/^(\w+).*$/$1/;
		tr/A-Z/a-z/;
		s/\b([a-z])/\u$1/g;
		push( @surname, $_ );
	}
}

sub getName {
	my $type = shift;

	my @coname = (
		"Corp",        "Products",  "Company",     "Enterprise",
		"Associates",  "Bank",      "Propane",     "Automation",
		"Warehousing", "Motors",    "Pictures",    "and Co.",
		"Toys",        "Fuels",     "Inc.",        "Co. Ltd",
		"Foundry",     "Logistics", "Corporation", "Industries",
		"Ltd",         "and Sons",  "Agency",      "Institute"
	);

	my $ret = '';
	if ( $type eq 'rf' ) {    # Random First Name
		if ( time % 2 ) {
			$type = 'm';
		} else {
			$type = 'f';
		}
	}
	if ( $type eq 'rn' ) {    # Random Full Name
		if ( time % 2 ) {
			$type = 'ms';
		} else {
			$type = 'fs';
		}
	}

	if ( $type eq 'm' ) {
		$ret = $male[ ( int( rand( @male + 1 ) ) ) ];
	} elsif ( $type eq 'f' ) {
		$ret = $female[ ( int( rand( @female + 1 ) ) ) ];
	} elsif ( $type eq 's' ) {
		$ret = $surname[ ( int( rand( @surname + 1 ) ) ) ];
	} elsif ( $type eq 'ms' ) {
		$ret =
		    $male[ ( int( rand( @male + 1 ) ) ) ] . ' '
		  . $surname[ ( int( rand( @surname + 1 ) ) ) ];

	} elsif ( $type eq 'fs' ) {
		$ret =
		    $female[ ( int( rand( @female + 1 ) ) ) ] . ' '
		  . $surname[ ( int( rand( @surname + 1 ) ) ) ];

	} elsif ( $type eq 'c' ) {
		$ret =
		    $surname[ ( int( rand( @surname + 1 ) ) ) ] . ' '
		  . $coname[ ( int( rand(@coname) ) ) ];

	} else {

	}

	return $ret;
}


#!/usr/bin/perl
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

my $user = $>;
if ($user) { print "\nGotta be root! Not " . $user . "\n"; exit; }
system("clear");

# Clear the File Stores
system("rm -rf /srv/ath/var/files/*");
system("rm -rf /srv/ath/var/data/*");
system("mkdir -p /srv/ath/var/files/cust");
system("mkdir -p /srv/ath/var/files/supp");
system("mkdir -p /srv/ath/var/files/int");

system("chown www-data:root -R /srv/ath/var/files/*");

system("mkdir -p /srv/ath/var/data");

# Clear the Login Pages
system("rm -rf /srv/ath/pub/login/*");

# Clear SSL certs
print "Clearing the SSL Certificates\n";
system("/srv/ath/adm/t/dev/clearSSL.pl");

# db details
print "Connecting to DB as root...\n";
my $dbhroot = &AthenaTest::dbrootconnect();

# Clear Sys Database
print "Clearing and Remaking the Sys DB ...\n";
if ( !DevTest::db_init($dbhroot) ) {
	print "Couldn't clear and remake Sys DB\n";
}

# Load Names
#print "Loading Names ...\n";
my @male    = ();
my @female  = ();
my @surname = ();
loadNames();

my @statlines = ();

my $quick = 0;

my $noOfSites                        = ($quick) ? 1 : 3;
my $noOfStaff                        = ($quick) ? 6 : 12;
my $noOfSuppliers                    = ($quick) ? 1 : 6;
my $noOfSuppContacts                 = ($quick) ? 1 : $noOfSuppliers * 15;
my $noOfCustomers                    = ($quick) ? 1 : 10;
my $noOfCustContacts                 = ($quick) ? 1 : $noOfCustomers * 15;
my $noOfQuotes                       = ($quick) ? 1 : 60;
my $CustomersInitiatesRequestQuote   = ($quick) ? 1 : 12;
my $noOfOwnerQuoteResponses          = ($quick) ? 1 : 6;
my $noOfJobs                         = ($quick) ? 1 : 60;
my $noOfFinishedJobs                 = ($quick) ? 1 : 30;
my $noOfTcardMoves                   = ($quick) ? 1 : 260;
my $noOfInvoices                     = ($quick) ? 1 : 9;
my $noOfRequestQuotes                = ($quick) ? 1 : 20;
my $noOfSupplierRespondsQuoteRequest = ($quick) ? 1 : 20;
my $noOfAgreeToQuote                 = ($quick) ? 1 : 12;
my $noOfTasks                        = ($quick) ? 1 : 12;

push( @statlines,
"Site Stats - no Of Staff: $noOfStaff | no Of Suppliers: $noOfSuppliers | no Of SuppContacts: $noOfSuppContacts |  no Of Quotes: $noOfQuotes"
);

# Get DB Handle
my $dbhsys = Athena::dbsysconnect();

# Get Mechanize Handle
my $mech = WWW::Mechanize->new('ssl_opts' => { 'verify_hostname' => 0 });

for ( 1 .. ($noOfSites) ) {

	# Add Owner
	my ($coname) = &getName('c');
	print "\n#### Adding new site \n";
	if ( !DevTest::add_site( $mech, $coname ) ) {
		print "Couldn't add site\n";
		exit;
	}

	# Create new site DB
	print "Completing sign up and create new site db\n";
	system("php /srv/ath/src/php/cron/new.site.php");

	my ($sitesid) = $dbhsys->selectrow_array('SELECT sitesid FROM athcore.sites ORDER BY sitesid DESC LIMIT 1;');

	if ( !$sitesid ) {
		print "Got No SiteID!\n";
		exit;
	}

	print "#######################\nAdded Site ID:$sitesid\n#######################\n";

	# Add Data Folders
	my $add_cmd = "perl /srv/ath/adm/t/dev/adm/mkInitFolders.pl $sitesid";

	#	print $add_cmd . "\n";
	system($add_cmd);

	my $dbhsite = Athena::dbsiteconnect($sitesid);

	#my @mods=(0,5,6,13,14,15,17,20);
	#	my @mods = ( 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21 );
	#
	#	my $sql    = "INSERT INTO athcore.mods (sitesid,modulesid) VALUES (?,?)";
	#	my $cursor = $dbhsys->prepare($sql);
	#	foreach my $modid (@mods) {
	#		my $rtn = $cursor->execute( $sitesid, $modid );
	#	}

#	my $statement = "SELECT init_pw FROM staff ORDER BY staffid LIMIT 1";
#	my $pwd       = $dbhsite->selectrow_array($statement);
#	print "\nAA100 $pwd\n";

	my ( $webhost, $inthost, $custhost, $supphost, $admhost, $staffhost ) = Athena::getHostName();
	my ( $admin_logon, $pass ) = AthenaTest::getAdminLogin($dbhsite);
	&AthenaTest::login( $mech, $admin_logon, $pass, $inthost, $sitesid );

	# Update Owner Details
	print "\n#### Updating Site Owner Details \n";
	print ".";
	if ( !DevTest::updateOwner( $dbhsite, $mech ) ) {
		print "Couldn't update owner\n";
	}

	# Creating Site Teams
	print "\n#### Creating Site Teams\n";
	print ".";
	if ( !DevTest::updateTeams( $dbhsite, $mech ) ) {
		print "Couldn't Create Site Teams\n";
	}

	# Creating Site Stages
	print "\n#### Creating Site Stages\n";
	print ".";
	if ( !DevTest::updateStages( $dbhsite, $mech ) ) {
		print "Couldn't Create Site Stages\n";
	}

	# Add Staff
	print "\n#### Adding new Staff \n";
	for ( 1 .. $noOfStaff ) {
		print ".";
		my ( $fname, $sname ) = split( / /, &getName('rn') );
		if ( !DevOwner::add_staff( $dbhsite, $mech, $fname, $sname ) ) {
			print "Couldn't add staff\n";
		}
	}

	# Adding Admin Staff permissions
	print "\n#### Adding Admin Staff permissions \n";
	for ( 1 .. $noOfStaff ) {
		print ".";
		my ( $fname, $sname ) = split( / /, &getName('rn') );
		if ( !DevOwner::staffAccess( $dbhsite, $mech ) ) {
			print "Couldn't add Admin Staff permissions\n";
		}
	}

	# Use a Non Root Admin
	my ( $admin_logon, $pass ) = AthenaTest::getNonRootAdminLogin($dbhsite);
	&AthenaTest::login( $mech, $admin_logon, $pass, $inthost, $sitesid );

	# Add Customers
	print "\n#### Adding new Customers \n";
	for ( 1 .. $noOfCustomers ) {
		print ".";
		my ($coname) = &getName('c');
		if ( !DevOwner::add_cust( $dbhsite, $mech, $coname ) ) {
			print "Couldn't add Customers\n";
		}
	}

	# Edit Customers
	print "\n#### Editing Customers \n";
	for ( 1 .. $noOfCustomers ) {
		print ".";
		if ( !DevOwner::editCustomer( $dbhsite, $mech ) ) {
			print "Couldn't edit Customers\n";
		}
	}

	# Add Customers Contacts
	print "\n#### Adding a new Customers's Contacts \n";
	for ( 1 .. $noOfCustContacts ) {
		print ".";
		my ( $fname, $sname ) = split( / /, &getName('rn') );
		if ( !DevOwner::add_cust_contact( $dbhsite, $mech, $fname, $sname ) ) {
			print "Couldn't add staff\n";
		}
	}

	# Add Suppliers
	print "\n#### Adding new Suppliers \n";
	for ( 1 .. $noOfSuppliers ) {
		print ".";
		my ($coname) = &getName('c');
		if ( !DevOwner::add_supp( $dbhsite, $mech, $coname ) ) {
			print "Couldnt add supplier\n";
		}
	}

	# Editing Suppliers

	print "\n#### Editing Supplier \n";
	for ( 1 .. $noOfSuppliers ) {
		print ".";
		if ( !DevOwner::editSupplier( $dbhsite, $mech ) ) {
			print "Couldn't edit Supplier\n";
		}
	}

	# Add Suppliers Contacts
	print "\n#### Adding a new Supplier's Contacts \n";
	for ( 1 .. $noOfSuppContacts ) {
		print ".";
		my ( $fname, $sname ) = split( / /, &getName('rn') );

		if ( !DevOwner::add_supp_contact( $dbhsite, $mech, $fname, $sname ) ) {
			print "Couldn't add supplier\n";
		}
	}

	# Create Task
	print "\n#### Creating new Tasks\n";
	for ( 1 .. $noOfTasks ) {
		print ".";
		if ( !DevOwner::add_task( $dbhsite, $mech ) ) {
			print "Couldn't add Tasks\n";
		}

	}

	# Customers Initiates a request for Quote from owner
	print "\n#### Customers Initiates a request for Quote\n";
	for ( 1 .. $CustomersInitiatesRequestQuote ) {
		print ".";
		if ( !DevCust::add_cust_quote_request( $dbhsite, $mech, $sitesid ) ) {
			print "Couldn't do Customers Initiates a request for Quote\n";
		}
	}

	# Owner responds to Customer Initiated Quote
	print "\n#### Owner responds to Customer Initiated Quote\n";
	for ( 1 .. $noOfOwnerQuoteResponses ) {
		print ".";
		if ( !DevOwner::response_quote_request( $dbhsite, $mech ) ) {
			print "Couldn't respond to quote\n";
		}
	}

	# Customer agrees to quote
	print "\n#### Customer agrees to quote \n";
	for ( 1 .. $noOfAgreeToQuote ) {
		print ".";
		if ( !DevCust::custAgreeToQuote( $dbhsite, $mech, $sitesid ) ) {
			print "Couldn't do Customer agrees to quote\n";
		}
	}

	# Owner Adds a Quote
	print "\n#### Owner Adding new Quotes \n";
	for ( 1 .. $noOfQuotes ) {
		print ".";
		if ( !DevOwner::add_quote( $dbhsite, $mech ) ) {
			print "Couldn't add quote\n";
		}
	}

	# Create Job
	print "\n#### Creating new Jobs\n";
	for ( 1 .. $noOfJobs ) {
		print ".";
		if ( !DevOwner::add_job( $dbhsite, $mech ) ) {
			print "Couldn't add job\n";
		}
	}

	my ( $admin_logon, $pass ) = AthenaTest::getStaffLogin($dbhsite);
	&AthenaTest::login( $mech, $admin_logon, $pass, $staffhost, $sitesid );

	#Staff move Jobs on the TCard
	print "\n#### Staff move Jobs on the TCard \n";
	for ( 1 .. $noOfTcardMoves ) {
		print ".";
		if ( !DevStaff::moveJobStage( $dbhsite, $mech, $sitesid ) ) {
			print "Couldn't move Jobs on the TCard\n";
		}
	}

	# Do Staff timesheets
	print "\n#### Do Staff timesheets\n";
	if ( !DevStaff::doTimesheet( $dbhsite, $mech, $sitesid ) ) {
		print "Couldn't Do Staff timesheets\n";
	}

	# Mark Job Finished
	print "\n#### Marking Jobs as Finished\n";
	for ( 1 .. $noOfFinishedJobs ) {
		print ".";
		if ( !DevOwner::mark_job_finished( $dbhsite, $mech ) ) {
			print "Couldn't finish job\n";
		}
	}

	# Create Invoice
	print "\n#### Creating new Invoice\n";
	for ( 1 .. $noOfInvoices ) {
		print ".";
		if ( !DevOwner::add_invoice( $dbhsite, $mech ) ) {
			print "Couldn't add invoice\n";
		}

	}

	#	Ordering from Suppliers

	# Request Quotes from Suppliers
	print "\n#### Request Quotes from Suppliers\n";
	for ( 1 .. $noOfRequestQuotes ) {
		print ".";
		if ( !DevOwner::requestSupplierQuote( $dbhsite, $mech ) ) {
			print "Couldn't Request Quotes from Supplier\n";
		}
	}

	# Send Request Quotes to Suppliers
	print "\n#### Send Request Quotes to Suppliers\n";
	for ( 1 .. $noOfRequestQuotes ) {
		print ".";
		if ( !DevOwner::sendRequestSupplierQuote( $dbhsite, $mech ) ) {
			print "Couldn't do it\n";
		}
	}

	# Supplier responds to quote request
	print "\n#### Supplier responds to quote request \n";
	for ( 1 .. $noOfSupplierRespondsQuoteRequest ) {
		print ".";
		if ( !DevSupp::supp_quote_request_response( $dbhsite, $mech, $sitesid ) ) {
			print "Couldn't do it\n";
		}
	}

	# Agree to quote from Supplier
	print "\n#### Agree to quote from Supplier \n";
	for ( 1 .. $noOfAgreeToQuote ) {
		print ".";
		if ( !DevOwner::agree_to_supplier_quote( $dbhsite, $mech ) ) {
			print "Couldn't respond to quote\n";
		}
	}



	print "\n\n#### Site Stats ...;\n";

	# Print Out Stats
	foreach (@statlines) {
		print $_ . "\n";
	}

	print "\n\n";
}


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
		"Corp",       "Products", "Company",  "Enterprise", "Associates", "Automation",
		"and Co.",    "Inc.",     "Co. Ltd",  "Foundry",    "Logistics",  "Corporation",
		"Industries", "Ltd",      "and Sons", "Agency",     "Institute"
	);

	my $ret = '';
	if ( $type eq 'rf' ) {    # Random First Name
		if ( time % 2 ) {
			$type = 'm';
		}
		else {
			$type = 'f';
		}
	}
	if ( $type eq 'rn' ) {    # Random Full Name
		if ( time % 2 ) {
			$type = 'ms';
		}
		else {
			$type = 'fs';
		}
	}

	if ( $type eq 'm' ) {
		$ret = $male[ ( int( rand( @male + 1 ) ) ) ];
	}
	elsif ( $type eq 'f' ) {
		$ret = $female[ ( int( rand( @female + 1 ) ) ) ];
	}
	elsif ( $type eq 's' ) {
		$ret = $surname[ ( int( rand( @surname + 1 ) ) ) ];
	}
	elsif ( $type eq 'ms' ) {
		$ret = $male[ ( int( rand( @male + 1 ) ) ) ] . ' ' . $surname[ ( int( rand( @surname + 1 ) ) ) ];

	}
	elsif ( $type eq 'fs' ) {
		$ret = $female[ ( int( rand( @female + 1 ) ) ) ] . ' ' . $surname[ ( int( rand( @surname + 1 ) ) ) ];

	}
	elsif ( $type eq 'c' ) {
		$ret = $surname[ ( int( rand( @surname + 1 ) ) ) ] . ' ' . $coname[ ( int( rand(@coname) ) ) ];

	}
	else {

	}

	return $ret;
}

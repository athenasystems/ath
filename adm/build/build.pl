#!/usr/bin/perl
# /srv/ath/adm/build/build.pl
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
use DNS;

my $user = $>;
if ($user) { print "\nGotta be root! Not " . $user . "\n"; exit; }
system("clear");

print "Connecting to DB as root...\n";
my $dbhroot = &Athena::dbrootconnect();

# Clear Sys Database
print "Clearing and Remaking the Sys DB ...\n";
if ( !DevTest::db_init($dbhroot) ) {
	print "Couldn't clear and remake Sys DB\n";
}



exit;


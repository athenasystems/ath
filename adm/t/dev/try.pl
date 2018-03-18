#!/usr/bin/perl
my $user = $>;
if ($user) {
	print "\nGotta be root! Not " . $user . "\n";
	exit;
}
#system("clear");
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
use DNS;


# Get DB Handle
my $dbhsys = Athena::dbsysconnect();

#&DNS::make_dbathena($dbhsys);

&DNS::addToNamedLocal($dbhsys);

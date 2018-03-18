#!/usr/bin/perl

use strict;
use lib ('/srv/ath/src/perl/lib');
use Athena;
use Website;
use DBI;

my $sitesid = shift;
if ( ( !defined($sitesid) ) || ( $sitesid eq '' ) ) {
	print "\nNo site id ... exiting\n";
	exit;
}
my $domain = $sitesid . '.' . $Athena::domain;

# Get DB Handle
my $dbhsys  = Athena::dbsysconnect();

#print "\n\n#######Making the Web Pages for $domain\n";

&Website::makeWebPages($dbhsys,$sitesid);

exit;


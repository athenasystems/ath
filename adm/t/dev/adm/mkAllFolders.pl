#!/usr/bin/perl

use strict;
use DBI;

use lib('/srv/ath/src/perl/lib/');
use Athena;

#
# db details
#

print "Connecting to DB ...\n";

my $dbh = Athena::dbsiteconnect();

my $sql    = "SELECT quoteno FROM quotes;";
my $cursor = $dbh->prepare($sql);
$cursor->execute();

while ( my @row = $cursor->fetchrow_array ) {
	my $quoteno = $row[0];
	my $cmd = "/usr/bin/perl /srv/ath/src/perl/mng/mkFolders.pl " . $quoteno;
	print "Doing: $cmd\n";
	system($cmd);
}

$sql    = "SELECT jobno FROM jobs;";
$cursor = $dbh->prepare($sql);
$cursor->execute();

while ( my @row = $cursor->fetchrow_array ) {
	my $jobno = $row[0];
	my $cmd = "/usr/bin/perl /srv/ath/src/perl/mng/mkFolders.pl " . $jobno;
	print "Doing: $cmd\n";
	system($cmd);
}

exit;

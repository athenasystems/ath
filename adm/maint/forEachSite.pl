#!/usr/bin/perl

use strict;
use DBI;
use lib('/srv/ath/src/perl/lib/');
use Athena;

	my $dbhroot = &Athena::dbrootconnect();

my @ids = Athena::getSiteIDs($dbhroot);

foreach(@ids){
	
	my $sid = $_;

	my $dbhsite = Athena::dbsiteconnect($sid);

	my @sql = ();
	open( FH, "<sitesql" );
	while (<FH>) {
		chomp;
		push( @sql, $_ );
	}
	close(FH);

	foreach (@sql) {
		my $cmd = $_;
		print $sid."\t".$cmd . "\n";#next;
		my $rows = $dbhsite->do($cmd) or die $dbhsite->errstr;
	}

}


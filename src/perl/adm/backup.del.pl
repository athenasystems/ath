#!/usr/bin/perl
use strict;

use lib('/srv/ath/src/perl/lib/');
use Athena;
use DBI;

my $now       = time();
my $backupdir = '/backup/sources/ath';

opendir( DIR, $backupdir ) or die $!;

while ( my $file = readdir(DIR) ) {
	next if ( $file =~ /^\./ );

	my $ts = $file;
	$ts =~ s/\..*$//;
	if ( $ts < ( $now - ( 60 * 60 * 24 * 30 ) ) ) {
		my $cmd = "rm -f $backupdir/$file";

		print $cmd ."\n";
		system("$cmd");

	}
}

closedir(DIR);

exit;

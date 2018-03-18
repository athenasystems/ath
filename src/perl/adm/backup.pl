#!/usr/bin/perl
use strict;

use lib('/srv/ath/src/perl/lib/');
use Athena;
use DBI;

my $now       = time();
my $pw        = &Athena::getrootDBPass;
my $backupdir = '/backup/sources/ath';
my $dbsys     = &Athena::dbrootconnect();

my $cmd = "tar -czf $backupdir/$now.athena.code.tgz /srv/ath";

#print $cmd . "\n";
system($cmd);

my $cmd =
  "mysqldump -uroot -p'$pw' --databases athcore > $backupdir/$now.athcore.sql";

#print $cmd . "\n";
system($cmd);

$cmd = "tar -czf $backupdir/$now.athcore.sql.tgz $backupdir/$now.athcore.sql";

#print $cmd . "\n";
system($cmd);

$cmd = "rm -f $backupdir/$now.athcore.sql";

#print $cmd . "\n";
system($cmd);

my @ids = &Athena::getSiteIDs($dbsys);

foreach (@ids) {
	my $tmpSQL = "$backupdir/$now.athdb$_.sql";

	$cmd = "mysqldump -uroot -p'$pw' --databases athdb$_ > $tmpSQL";

	#print $cmd . "\n";
	system($cmd);

	$cmd = "tar -czf $backupdir/$now.athdb$_.sql.tgz $tmpSQL";

	#print $cmd . "\n";
	system($cmd);

	$cmd = "rm -f $tmpSQL";

	#print $cmd . "\n";
	system($cmd);
}

opendir( DIR, $backupdir ) or die $!;

while ( my $file = readdir(DIR) ) {
	next if ( $file =~ /^\./ );

	my $ts = $file;
	$ts =~ s/\..*$//;
	if ( $ts < ( $now - ( 60 * 60 * 24 * 30 ) ) ) {
		my $cmd = "rm -f $backupdir/$file";

		#print $cmd ."\n";
		system("$cmd");

	}
}

closedir(DIR);

exit;

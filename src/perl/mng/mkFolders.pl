#!/usr/bin/perl

use strict;

my $id      = shift;
my $sitesid = shift;

if ( !defined($id) )      { exit; }
if ( !defined($sitesid) ) { exit; }

my $sitepath = '/srv/ath/var/data/' . $sitesid;

my $type     = substr( $id, 0, 1 );
my $prefixyr = substr( $id, 1, 2 );

my $path;

if ( $type eq 'J' ) {

	my $subPath = $sitepath.'/jobs/J' . $prefixyr;
	&makeFolder($subPath);

	$path = $sitepath.'/jobs/J' . $prefixyr . '/' . $id;

	&makeFolder($path);
#	&makeFolder( $path . '/cnc-data' );
#	&makeFolder( $path . '/models' );
#	&makeFolder( $path . '/other_info' );
#	&makeFolder( $path . '/quote' );
#	&makeFolder( $path . '/files' );
}
elsif ( $type eq 'Q' ) {

	$path = $sitepath.'/quotes/Q' . $prefixyr . '/' . $id;

	&makeFolder($path);
}
else {
	exit;
}

system("sudo chown -R www-data:root $path");

exit;

sub makeFolder() {
	my $p = shift;
	unless ( -d $p ) {

		#print $p . "\n";
		system("mkdir -p $p");

		#system("chown www-data:root $p");
		#chown 1001, 1001, $p;
		#chmod 0777, $p;
	}
}

#!/usr/bin/perl

use strict;

my $sitesid = shift;

if(!defined($sitesid)){
	exit;
}

my $sitepath = '/srv/ath/var/data/'.$sitesid ;

system("rm -rf $sitepath");
&makeFolder($sitepath);
&makeFolder($sitepath.'/site');
&makeFolder($sitepath.'/jobs');
&makeFolder($sitepath.'/quotes');
&makeFolder($sitepath.'/pdf');
&makeFolder($sitepath.'/pdf/delivery');
&makeFolder($sitepath.'/pdf/invoices');
&makeFolder($sitepath.'/pdf/quotes');

my ( $sec, $min, $hour, $mday, $mon, $year, $wday, $yday, $isdst ) = localtime( time() );
my $prefixyr = substr( $year, 1, 2 );

&makeFolder($sitepath.'/jobs/J' . $prefixyr);
&makeFolder($sitepath.'/quotes/Q' . $prefixyr);

exit;

sub makeFolder() {
	my $p = shift;
 	my ($login,$pass,$uid,$gid) = getpwnam('www-data') or die "www-data not in passwd file";
	unless ( -d $p ) {
	#print "Mkdir at " . $p . "\n";
		mkdir($p);
		chown $uid,$gid, $p;
		chmod 0755, $p;
	}
}

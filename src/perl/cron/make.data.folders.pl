#!/usr/bin/perl

use strict;
use DBI;
use lib('/srv/ath/src/perl/lib/');
use Athena;

my $dataDir = Athena::getDataDir(100);

my $dbh = DBI->connect( 'DBI:mysql:db100:localhost', 'root', Athena::getDBPass(), { RaiseError => 1 } );

my $sqltext = "SELECT quoteno FROM quotes ORDER BY quotesid DESC";

my $sth = $dbh->prepare($sqltext);
$sth->execute();
while ( my $rItems = $sth->fetchrow_hashref ) {
        my %r     = %{$rItems};
        my $qno = $r{'quoteno'};

        my $prefixyr = substr( $qno, 1, 2 );

        my $subPath = $dataDir . '/quotes/Q' . $prefixyr . '/' . $qno;
        
       # print $subPath . "\n";

        unless( -d $subPath ){
                system("mkdir -p $subPath");
                system("chown www-data:www-data $subPath");
                system("chmod 777 $subPath");
        }

}



my $sqltext = "SELECT jobno FROM jobs ORDER BY jobsid DESC";

my $sth = $dbh->prepare($sqltext);
$sth->execute();
while ( my $rItems = $sth->fetchrow_hashref ) {
        my %r     = %{$rItems};
        my $jobno = $r{'jobno'};

        my $prefixyr = substr( $jobno, 1, 2 );

        my $subPath = $dataDir . '/jobs/J' . $prefixyr . '/' . $jobno;

     #   print $subPath . "\n";
        
        unless( -d $subPath ){
                system("mkdir -p $subPath");
                system("chown www-data:www-data $subPath");
                system("chmod 777 $subPath");
        }
}

exit;

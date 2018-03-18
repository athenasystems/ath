#!/usr/bin/perl
use strict;

use DBI;
use lib('/srv/ath/src/perl/lib/');
use Athena;
use Website;

my $sitesid = shift;

my $dir = "/srv/sites/$sitesid." . $Athena::domain . "/www";
mkdir($dir);

# Get DB Handle
my $dbhsys = Athena::dbsysconnect();
my %owner = Athena::getOwnerDetails( $dbhsys, $sitesid );

my $html = '';

open( FHIN, "</srv/ath/src/php/tmpl/web.quote.php" );
while (<FHIN>) {
	$html .= $_;
}
close(FHIN);

my $owl_drop = Athena::obscure($sitesid);

$html =~ s/OWLDROP/$owl_drop/s;
$html =~ s/SITESID/$sitesid/gs;

my $header = &Website::makeHeader( $owner{'co_name'} );
my $footer = &Website::makeFooter( \%owner );
print "Writing out Login page to $dir/quote.php\n";
open( FH, ">$dir/login.php" );
print FH $header.$html.$footer;
close(FH);

exit;

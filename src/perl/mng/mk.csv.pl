#!/usr/bin/perl
use strict;

use CGI;
use DBI;
use lib('/srv/ath/src/perl/lib/');
use Athena;

if(!Athena::chkCookie){	
	print CGI::header();
	print "Access Denied";
	exit;
}
my $form = new CGI;
my %fds = map { $_ => scalar $form->param($_) } $form->param;

my $sitesid = $fds{'sid'};

my $dbh     = &Athena::dbsiteconnect($sitesid);
my $dbhsys  = &Athena::dbsysconnect($sitesid);
my %owner   = Athena::getOwnerDetails( $dbhsys, $sitesid );
my $co_name = $owner{'co_name'};
$co_name =~ s/\W/_/g;

if ( $fds{'t'} eq 'inv' ) {

	my $docName = $co_name . '_Invoices_' . $sitesid . '.csv';

	my $sqltext = "SELECT invoices.invoiceno,invoices.incept,price
	FROM jobs,items,invoices
	WHERE jobs.itemsid=items.itemsid
	AND invoices.invoicesid=jobs.invoicesid";

	my $sth = $dbh->prepare($sqltext);
	$sth->execute();
	my $noOfRows = $sth->rows;

	my $cnt = 0;
	my $out = '"Date","Invoiceno","Amount"' . "\n";

	while ( my $row = $sth->fetchrow_hashref ) {
		my %r = %{$row};
		my ( $sec, $min, $hour, $mday, $mon, $year, $wday, $yday, $isdst ) =
		  localtime( $r{'incept'} );

		$out .=
		    '"'
		  . "$mday/$mon/$year" . '","'
		  . $r{'invoiceno'} . '","'
		  . $r{'price'} . '"' . "\n";

	}

	#print $out;
	# CGI Header designating the CSV data
	print CGI::header(
		-type       => 'application/plain',
		-attachment => $docName
	);

	print $out;

} elsif ( $fds{'t'} eq 'cost' ) {

	my $docName = $co_name . '_Costs_' . $sitesid . '.csv';

	my $sqltext = "SELECT * FROM costs";
	my $sth = $dbh->prepare($sqltext);
	$sth->execute();
	my $noOfRows = $sth->rows;

	my $cnt = 0;
	my $out = '"Date","Supplier","Amount"' . "\n";

	while ( my $row = $sth->fetchrow_hashref ) {
		my %r = %{$row};
		my ( $sec, $min, $hour, $mday, $mon, $year, $wday, $yday, $isdst ) =
		  localtime( $r{'incept'} );

		$out .=
		    '"'
		  . "$mday/$mon/$year" . '","'
		  . $r{'supplier'} . '","'
		  . $r{'price'} . '"' . "\n";

	}

	#print $out;
	# CGI Header designating the CSV data
	print CGI::header(
		-type       => 'application/plain',
		-attachment => $docName
	);

	print $out;

}

exit;

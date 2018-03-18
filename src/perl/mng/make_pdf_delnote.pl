#!/usr/bin/perl

use strict;
use POSIX qw(strftime);
use DBI;
use CGI;
use Locale::Currency::Format;

use lib qw(/srv/ath/src/perl/lib);
use Athena;
use PDF;

if ( !Athena::chkCookie ) {
	print CGI::header();
	print "Access Denied";
	exit;
}
my $form = new CGI;
my %fds = map { $_ => scalar $form->param($_) } $form->param;

my $id      = $fds{'id'};
my $sitesid = $fds{'sid'};

my $dataDir = Athena::getDataDir($sitesid);

my $dbh    = &Athena::dbsiteconnect($sitesid);
my $dbhsys = &Athena::dbsysconnect($sitesid);

my %owner = Athena::getOwnerDetails( $dbhsys, $sitesid );

use PDF::Create;

my $total      = 0;
my $totalprice = 0;

my %co_details = ();

my $sql = "SELECT cust.custid,cust.co_name,cust.inv_contact,addsid,
invoices.invoicesid,invoices.invoiceno,invoices.incept as invincept
FROM cust,invoices
WHERE invoices.custid=cust.custid
AND invoices.invoicesid=?";

#print $sql . "\n\n";

my $sth = $dbh->prepare($sql);

$sth->execute($id);

my $row = $sth->fetchrow_hashref;
my %r   = %{$row};

my $docPrefix = $owner{'co_name'};
$docPrefix =~ s/\W/_/g;
$docPrefix =~ s/__/_/g;

my $delnoteno = $r{'invoiceno'};
$delnoteno =~ s/^J/D/;

my $outputType = 'web';

#if ( $outputType eq 'web' ) {
my $docName = $docPrefix . '_Delivery_Note_' . $delnoteno . '.pdf';

# CGI Header designating the pdf data
print CGI::header(
	-type       => 'application/x-pdf',
	-attachment => $docName
);

# initialize PDF
my $pdf = new PDF::Create(
	'filename'     => '-',
	'PageMode'     => 'UseOutlines',
	'Author'       => $owner{'co_name'},
	'Title'        => $owner{'co_name'} . ' Delivery Note No: ' . $delnoteno,
	'CreationDate' => [localtime],
);

#}
#else {
#	$docName = "$dataDir/pdf/delivery/" . $docPrefix . '_Delivery_Note_' . $delnoteno . '.pdf';
#
#	# initialize PDF
#	$pdf = new PDF::Create(
#		'filename'     => $docName,
#		'PageMode'     => 'UseOutlines',
#		'Author'       => $owner{'co_name'},
#		'Title'        => $owner{'co_name'} . ' Delivery Note No: ' .$delnoteno,
#		'CreationDate' => [localtime],
#	);
#}

my $sqlCust =
  "SELECT * FROM cust,adds WHERE cust.addsid=adds.addsid AND custid=?";

$sth = $dbh->prepare($sqlCust);

$sth->execute( $r{'custid'} );

$row        = $sth->fetchrow_hashref;
%co_details = %{$row};
my ( $sec, $min, $hour, $mday, $mon, $year, $wday, $yday, $isdst ) =
  localtime( time() );
$year = $year + 1900;
$mon++;
my $incept = "$mday/$mon/$year";

my $ypos      = 720;
my $fontSmall = 12;

# add a A4 sized page
my $a4 = $pdf->new_page( 'MediaBox' => $pdf->get_page_size('A4') );

# Add a page which inherits its attributes from $a4
my $curr_page = $a4->new_page;

# Prepare a font
my $f1 = $pdf->font( 'BaseFont' => 'Times-Roman' );

# Prepare a Table of Content
my $toc =
  $pdf->new_outline( 'Title' => 'Title Page', 'Destination' => $curr_page );

$ypos = &PDF::pdf_header( $curr_page, $f1, $pdf, $ypos, $dataDir, $fontSmall,
	\%owner );

# Write some text
$curr_page->stringr( $f1, $fontSmall, 522, $ypos, "Date: $incept" );
$ypos -= 20;
if ( ( defined( $r{'custref'} ) ) && ( $r{'custref'} ne '' ) ) {
	$curr_page->stringr( $f1, $fontSmall, 522, $ypos,
		"Your Ref: $r{'custref'}" );
	$ypos -= 20;
}
$curr_page->stringr( $f1, $fontSmall, 522, $ypos,
	$owner{'co_nick'} . " Delivery Note No: $delnoteno" );

$ypos += 60;

$curr_page->printnl( "Delivery To:- ", $f1, $fontSmall, 42, $ypos );
$ypos -= 20;

$ypos = &PDF::addressTo( $dbh, $curr_page, $f1, $pdf, $ypos, $fontSmall,
	\%co_details, \%owner );
$ypos -= 40;

$curr_page->printnl( 'D E L I V E R Y   N O T E', $f1, 16, 190, $ypos );
$ypos -= 40;

my $sqltextItems = "SELECT * FROM iitems WHERE invoicesid=?";
my $sthItems     = $dbh->prepare($sqltextItems);
$sthItems->execute( $r{'invoicesid'} );
my $noOfRows = $sthItems->rows;

my $cnt = 0;

while ( my $row = $sthItems->fetchrow_hashref ) {
	my %item = %{$row};

	my @itemContents = split( /\b/, $item{'content'} );
	my $tmpStr = '';
	foreach (@itemContents) {
		$tmpStr .= $_;

		if ( length($tmpStr) > 90 ) {

			$curr_page->printnl( $tmpStr, $f1, $fontSmall, 42, $ypos );
			$ypos -= 20;
			$tmpStr = '';
		}
	}
	$curr_page->printnl( $tmpStr, $f1, $fontSmall, 42, $ypos );
	$ypos -= 20;
	my $linePrice = 0;
	if ( defined( $item{'hours'} ) && ( $item{'hours'} > 0 ) ) {

		$curr_page->printnl( 'Quanity: 1', $f1, $fontSmall, 42, $ypos );

		$ypos -= 40;

	}
	else {

		$curr_page->printnl( 'Quanity: ' . $item{'quantity'},
			$f1, $fontSmall, 42, $ypos );

		$ypos -= 40;

	}

	$cnt++;

	if ( ( $cnt < $noOfRows ) && ( $ypos < 200 ) ) {
		&PDF::footer( $curr_page, $f1, \%owner );
		$curr_page = &PDF::newPage($a4);
		$ypos      = 790;

		$curr_page->stringr( $f1, $fontSmall, 522, $ypos,
			$owner{'co_nick'} . " Delivery Note No: $delnoteno" );

		$ypos -= 60;

	}

	$total = $total + $linePrice;

}

$curr_page->stringr( $f1, $fontSmall, 522, $ypos,
	"Received in good condition ..................................." );
$ypos -= 50;

$curr_page->stringr( $f1, $fontSmall, 522, $ypos,
	"Date ..................................." );
$ypos -= 20;

# Build Footer
&PDF::footer( $curr_page, $f1, \%owner );

# Close the file and write the PDF
$pdf->close;

exit;


#!/usr/bin/perl

use strict;
use POSIX qw(strftime);
use DBI;
use CGI;
use Locale::Currency::Format;

use lib qw(/srv/ath/src/perl/lib);
use Athena;
use PDF;

#if ( !Athena::chkCookie ) {
#	print CGI::header();
#	print "Access Denied";
#	exit;
#}

my $form = new CGI;
my %fds = map { $_ => scalar $form->param($_) } $form->param;

my $id      = $fds{'id'};
my $sitesid = $fds{'sitesid'};
my $format  = ( defined( $fds{'format'} ) ) ? $fds{'format'} : 'web';

#print $id;

my $dbh    = &Athena::dbsiteconnect($sitesid);
my $dbhsys = &Athena::dbsysconnect($sitesid);

use PDF::Create;

my $total      = 0;
my $totalprice = 0;

my %co_details = ();

my $sql = "SELECT * FROM quotes WHERE quotes.quotesid=?";

#print $sql . "\n\n";

my $sth = $dbh->prepare($sql);

$sth->execute($id);

my $row = $sth->fetchrow_hashref;
my %r   = %{$row};

my %owner = Athena::getOwnerDetails( $dbhsys, $sitesid );
my %siteMods = Athena::getSiteMods( $dbhsys, $sitesid );

my $dataDir =
  '/srv/ath/var/data/' . $owner{'filestr'};    #Athena::getDataDir($sitesid);

my $docPrefix = $owner{'co_name'};
$docPrefix =~ s/\W/_/g;
$docPrefix =~ s/__/_/g;

my $docName    = '-';
my $docPDFName = '-';                          # default for web delivery

if ( $format eq 'web' ) {

	$docName = $docPrefix . '_Quote_' . $r{'quoteno'} . '.pdf';

	# CGI Header designating the pdf data
	print CGI::header(
		-type       => 'application/x-pdf',
		-attachment => $docName
	);
} else {
	$docPDFName =
	    $dataDir
	  . '/pdf/quotes/'
	  . $docPrefix
	  . '_Quote_'
	  . $r{'quoteno'} . '.pdf';
}

# initialize PDF
my $pdf = new PDF::Create(
	'filename'     => $docPDFName,
	'PageMode'     => 'UseOutlines',
	'Author'       => $owner{'co_name'},
	'Title'        => $owner{'co_name'} . " Quote No: " . $r{'quoteno'},
	'CreationDate' => [localtime],
);

my $sqlCust =
  "SELECT * FROM cust,adds WHERE cust.addsid=adds.addsid AND custid=?";

$sth = $dbh->prepare($sqlCust);

$sth->execute( $r{'custid'} );

$row        = $sth->fetchrow_hashref;
%co_details = %{$row};

my ( $sec, $min, $hour, $mday, $mon, $year, $wday, $yday, $isdst ) =
  localtime( $r{'incept'} );
$year = $year + 1900;
$mon++;
my $incept = "$mday/$mon/$year";

my $ypos      = 720;
my $fontSmall = 12;

# add a A4 sized page
my $a4 = $pdf->new_page( 'MediaBox' => $pdf->get_page_size('A4') );

# Add a page which inherits its attributes from $a4
my $curr_page = &PDF::newPage($a4);

# Prepare a font
my $f1 = $pdf->font( 'BaseFont' => 'Helvetica' );

# Prepare a Table of Content
my $toc =
  $pdf->new_outline( 'Title' => 'Title Page', 'Destination' => $curr_page );

$ypos = &PDF::pdf_header( $curr_page, $f1, $pdf, $ypos, $dataDir, $fontSmall,
	\%owner );

# Write Quote Details
$curr_page->stringr( $f1, $fontSmall, 522, $ypos, "Date: $incept" );
$ypos -= 20;
if ( $r{'custref'} ne '' ) {
	$curr_page->stringr( $f1, $fontSmall, 522, $ypos,
		"Your Ref: $r{'custref'}" );
	$ypos -= 20;
}
$curr_page->stringr( $f1, $fontSmall, 522, $ypos,
	$owner{'co_nick'} . " Quote No: $r{'quoteno'}" );
$ypos -= 20;
$ypos += 60;
$curr_page->printnl( "Quote For:- ", $f1, $fontSmall, 42, $ypos );
$ypos -= 20;

$ypos = &PDF::addressTo( $dbh, $curr_page, $f1, $pdf, $ypos, $fontSmall,
	\%co_details, \%owner );
	

if ( $r{'contactsid'} > 0 ) {
	$curr_page->printnl(
		"FAO: " . Athena::getCustExtName( $dbh, $r{'contactsid'} ),
		$f1, $fontSmall, 42, $ypos );
	$ypos -= 20;
}
$curr_page->printnl( 'Q U O T E', $f1, 18, 242, $ypos );
$ypos -= 40;

$curr_page->printnl( "Quote Description", $f1, $fontSmall, 42, $ypos );
$ypos -= 30;

$r{'content'} =~ s/\n/ /gs;

my @contents = split( /\b/, $r{'content'} );
my $tmpStr = '';
foreach (@contents) {
	$tmpStr .= $_;

	if ( length($tmpStr) > 80 ) {

		$curr_page->printnl( $tmpStr, $f1, $fontSmall, 42, $ypos );
		$ypos -= 20;
		$tmpStr = '';
	}
}
$curr_page->printnl( $tmpStr, $f1, $fontSmall, 42, $ypos );
$ypos -= 30;

#$curr_page->printnl("Item Description", $f1, $fontSmall, 42, $ypos);$ypos-=30;

$sqlCust = "SELECT * FROM qitems WHERE quotesid=?";

$sth = $dbh->prepare($sqlCust);

$sth->execute( $r{'quotesid'} );

my $noOfRows = $sth->rows;

$curr_page->printnl( $noOfRows . ' Items as follows',
	$f1, $fontSmall, 42, $ypos );
$ypos -= 20;

$curr_page->printnl( 'Description', $f1, $fontSmall, 42, $ypos );

#$curr_page->printnl( 'Delivery',    $f1, $fontSmall, 310, $ypos );
$curr_page->printnl( 'Quantity',   $f1, $fontSmall, 360, $ypos );
$curr_page->printnl( 'Unit Price', $f1, $fontSmall, 430, $ypos );
$curr_page->printnl( 'Price',      $f1, $fontSmall, 500, $ypos );

$ypos -= 30;

my $cnt = 0;
while ( my $itemr = $sth->fetchrow_hashref ) {
	my %ir = %{$itemr};
	my @itemContents = split( /\b/, $ir{'content'} );
	$tmpStr = '';
	foreach (@itemContents) {
		$tmpStr .= $_;

		if ( length($tmpStr) > 42 ) {
			$curr_page->printnl( $tmpStr, $f1, $fontSmall, 42, $ypos );
			$ypos -= 20;
			$tmpStr = '';
		}
	}

	$curr_page->printnl( $tmpStr, $f1, $fontSmall, 42, $ypos );

	#$ypos -= 20;
	#$curr_page->printnl( $ir{'delivery'}, $f1, $fontSmall, 320, $ypos );
	my $subtotal = 0;
	if ( defined( $ir{'hours'} ) && ( $ir{'hours'} > 0 ) ) {
		$curr_page->printnl( $ir{'hours'} . ' Hours',
			$f1, $fontSmall, 370, $ypos );
		$curr_page->printnl(
			'@ ' . currency_format( 'GBP', $ir{'rate'}, FMT_SYMBOL ),
			$f1, $fontSmall, 420, $ypos );
		$subtotal = $ir{'hours'} * $ir{'rate'};
	} else {
		$curr_page->printnl( $ir{'quantity'}, $f1, $fontSmall, 380, $ypos );
		$curr_page->printnl( currency_format( 'GBP', $ir{'price'}, FMT_SYMBOL ),
			$f1, $fontSmall, 430, $ypos );
		$subtotal = $ir{'quantity'} * $ir{'price'};
	}

	$curr_page->printnl( currency_format( 'GBP', $subtotal, FMT_SYMBOL ),
		$f1, $fontSmall, 500, $ypos );
	$ypos -= 20;
	$cnt++;

	if ( ( $cnt < $noOfRows ) && ( $ypos < 240 ) ) {
		&PDF::footer( $curr_page, $f1, \%owner );
		$curr_page = &PDF::newPage($a4);
		$ypos      = 790;

		$curr_page->stringr( $f1, $fontSmall, 522, $ypos,
			$owner{'co_name'} . " Quote No: $r{'quoteno'}" );

		$ypos -= 60;

		$curr_page->printnl( 'Description', $f1, $fontSmall, 42, $ypos );

		#$curr_page->printnl( 'Delivery',    $f1, $fontSmall, 310, $ypos );
		$curr_page->printnl( 'Quantity',   $f1, $fontSmall, 360, $ypos );
		$curr_page->printnl( 'Unit Price', $f1, $fontSmall, 430, $ypos );
		$curr_page->printnl( 'Price',      $f1, $fontSmall, 500, $ypos );
		$ypos -= 30;
	}

	$total = $total + $subtotal;
}

#
$totalprice = $total;

$ypos -= 30;
if ( $ypos < 200 ) {
	&PDF::footer( $curr_page, $f1, \%owner );
	$curr_page = &PDF::newPage($a4);
	$ypos      = 790;
	$curr_page->stringr( $f1, $fontSmall, 522, $ypos,
		$owner{'co_name'} . " Quote No: $r{'quoteno'}" );
	$ypos -= 60;
}

if ( defined( $siteMods{'vat'} ) ) {

	my $vat_rate     = Athena::getVAT_Rate( $r{'incept'} );
	my $vat_rateText = Athena::getVatText($vat_rate);

	my $vat = $total * $vat_rate;
	$totalprice = $total + $vat;
	$curr_page->stringr( $f1, $fontSmall, 522, $ypos,
		"Total (ex VAT) " . currency_format( 'GBP', $total, FMT_SYMBOL ) );
	$ypos -= 30;

	$curr_page->stringr( $f1, 14, 522, $ypos,
		"VAT \@ $vat_rateText " . currency_format( 'GBP', $vat, FMT_SYMBOL ) );
	$ypos -= 30;
}
$curr_page->stringr( $f1, 14, 522, $ypos,
	"Total " . currency_format( 'GBP', $totalprice, FMT_SYMBOL ) );
$ypos -= 30;

&PDF::footer( $curr_page, $f1, \%owner );

# Close the file and write the PDF
$pdf->close;

exit;

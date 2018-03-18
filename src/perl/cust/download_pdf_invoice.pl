#!/usr/bin/perl

use strict;
use POSIX qw(strftime);
use DBI;
use CGI;
use Locale::Currency::Format;

use lib qw(/srv/ath/src/perl/lib);
use Athena;

if ( !Athena::chkCookie ) {
	print CGI::header();
	print "Access Denied";
	#exit;
}

my $form = new CGI;
my %fds = map { $_ => scalar $form->param($_) } $form->param;

my $id      = $fds{'id'};
my $sitesid = $fds{'sid'};
my $format  = ( defined( $fds{'format'} ) ) ? $fds{'format'} : 'web';

my $dataDir = Athena::getDataDir($sitesid);

my $dbh    = &Athena::dbsiteconnect($sitesid);
my $dbhsys = &Athena::dbsysconnect($sitesid);

my %owner = Athena::getOwnerDetails( $dbhsys, $sitesid );
my %siteMods = Athena::getSiteMods( $dbhsys, $sitesid );

use PDF::Create;

my $total      = 0;
my $totalprice = 0;

my %co_details = ();

my $sql = "SELECT jobs.incept,jobs.jobno,jobs.jobsid,jobs.done,
jobs.custref,cust.custid,cust.co_name,cust.inv_contact,addsid,
invoices.invoicesid,invoices.invoiceno,invoices.incept as invincept
FROM jobs,cust,invoices
WHERE jobs.invoicesid = invoices.invoicesid
AND jobs.custid=cust.custid
AND invoices.invoicesid=?";

#print $sql . "\n\n";

my $sth = $dbh->prepare($sql);

my $ret = $sth->execute($id);

#f(( !defined($r{'invoiceno'}) )||($r{'invoiceno'} eq '')){
if ( $ret < 1 ) {
	print "No Invoice Found - exiting\n";
	exit;
}
my $row = $sth->fetchrow_hashref;
my %r   = %{$row};

my $docPrefix = $owner{'co_name'};
$docPrefix =~ s/\W/_/g;
$docPrefix =~ s/__/_/g;
my $docName    = '-';
my $docPDFName = '-';    # default for web delivery

if ( $format eq 'web' ) {
	$docName = $docPrefix . "_Invoice_" . $r{'invoiceno'} . '.pdf';

	# CGI Header designating the pdf data
	print CGI::header(
		-type       => 'application/x-pdf',
		-attachment => $docName
	);
} else {
	$docPDFName =
	    $dataDir
	  . '/pdf/invoices/'
	  . $docPrefix
	  . "_Invoice_"
	  . $r{'invoiceno'} . '.pdf';
}

# initialize PDF
my $pdf = new PDF::Create(
	'filename'     => $docPDFName,
	'PageMode'     => 'UseOutlines',
	'Author'       => $owner{'co_name'},
	'Title'        => $owner{'co_name'} . " Invoice No: " . $r{'invoiceno'},
	'CreationDate' => [localtime],
);

my $sqlCust =
  "SELECT * FROM cust,adds WHERE cust.addsid=adds.addsid AND custid=?";

$sth = $dbh->prepare($sqlCust);

$sth->execute( $r{'custid'} );
$row        = $sth->fetchrow_hashref;
%co_details = %{$row};

my ( $sec, $min, $hour, $mday, $mon, $year, $wday, $yday, $isdst ) =
  localtime( $r{'invincept'} );
$year = $year + 1900;
$mon++;
my $incept = "$mday/$mon/$year";

my $ypos      = 720;
my $fontSmall = 12;

# add a A4 sized page
my $a4 = $pdf->new_page( 'MediaBox' => $pdf->get_page_size('A4') );

# Add a page which inherits its attributes from $a4
my $curr_page = &newPage();

# Prepare a font
my $f1 = $pdf->font( 'BaseFont' => 'Times-Roman' );

# Prepare a Table of Content
my $toc =
  $pdf->new_outline( 'Title' => 'Title Page', 'Destination' => $curr_page );

pdf_header();

$curr_page->stringr( $f1, $fontSmall, 522, $ypos,
	"Invoice No: " . $r{'invoiceno'} );
$ypos -= 20;
$curr_page->stringr( $f1, $fontSmall, 522, $ypos, "Invoice Date: " . $incept );
$ypos -= 20;
$curr_page->stringr( $f1, $fontSmall, 522, $ypos,
	"Your Reference: " . $r{'custref'} );
$ypos -= 20;

$ypos += 60;

$curr_page->printnl( "Invoice To:- ", $f1, $fontSmall, 42, $ypos );
$ypos -= 20;
$curr_page->printnl( "$co_details{'co_name'}", $f1, $fontSmall, 42, $ypos );
$ypos -= 20;
$curr_page->printnl( "$co_details{'add1'}", $f1, $fontSmall, 42, $ypos );
$ypos -= 20;
if ( $co_details{'add2'} ne '' ) {
	$curr_page->printnl( "$co_details{'add2'}", $f1, $fontSmall, 42, $ypos );
	$ypos -= 20;
}
if ( $co_details{'add3'} ne '' ) {
	$curr_page->printnl( "$co_details{'add3'}", $f1, $fontSmall, 42, $ypos );
	$ypos -= 20;
}
if ( $co_details{'city'} ne '' ) {
	$curr_page->printnl( "$co_details{'city'}", $f1, $fontSmall, 42, $ypos );
	$ypos -= 20;
}
if ( $co_details{'county'} ne '' ) {
	$curr_page->printnl( "$co_details{'county'}", $f1, $fontSmall, 42, $ypos );
	$ypos -= 20;
}
$curr_page->printnl( "$co_details{'postcode'}", $f1, $fontSmall, 42, $ypos );
$ypos -= 20;

if ( $co_details{'inv_contact'} > 0 ) {
	$curr_page->printnl(
		"FAO: " . Athena::getCustExtName( $dbh, $co_details{'inv_contact'} ),
		$f1, $fontSmall, 42, $ypos );
	$ypos -= 20;
}

$curr_page->printnl( 'SALES INVOICE', $f1, 16, 222, $ypos );
$ypos -= 30;

my $sqltextItems = "SELECT * FROM jobs,items WHERE jobs.itemsid=items.itemsid
AND invoicesid=?";
my $sthItems = $dbh->prepare($sqltextItems);
$sthItems->execute( $r{'invoicesid'} );
my $noOfRows = $sthItems->rows;

my $cnt = 0;

while ( my $row = $sthItems->fetchrow_hashref ) {
	my %item = %{$row};

	my @itemContents = split( /\b/, $item{'content'} );
	my $tmpStr = '';
	foreach (@itemContents) {
		$tmpStr .= $_;

		if ( length($tmpStr) > 50 ) {

			$curr_page->printnl( $tmpStr, $f1, $fontSmall, 42, $ypos );
			$ypos -= 20;
			$tmpStr = '';
		}
	}
	$curr_page->printnl( $tmpStr, $f1, $fontSmall, 42, $ypos );
	$ypos -= 20;

	$curr_page->printnl( 'Quanity: ' . $item{'quantity'},
		$f1, $fontSmall, 42, $ypos );
	$curr_page->printnl(
		'Unit Price: ' . currency_format( 'GBP', $item{'price'}, FMT_SYMBOL ),
		$f1, $fontSmall, 152, $ypos );

	my $linePrice = $item{'quantity'} * $item{'price'};

	$curr_page->printnl(
		'Price: ' . currency_format( 'GBP', $linePrice, FMT_SYMBOL ),
		$f1, $fontSmall, 400, $ypos );
	$ypos -= 40;

	$cnt++;

	if ( ( $cnt < $noOfRows ) && ( $ypos < 200 ) ) {
		&footer();
		$curr_page = &newPage();
		$ypos      = 790;

		$curr_page->stringr( $f1, $fontSmall, 522, $ypos,
			$owner{'co_nick'} . " Invoice No: $r{'invoiceno'}" );

		$ypos -= 60;

	}

	$total = $total + ( $item{'quantity'} * $item{'price'} );

}

if ( $ypos < 240 ) {
	&footer();
	$curr_page = &newPage();
	$ypos      = 790;

	$curr_page->stringr( $f1, $fontSmall, 522, $ypos,
		$owner{'co_nick'} . " Invoice No: $r{'invoiceno'}" );

	$ypos -= 60;

}

#
$totalprice = $total;

$ypos -= 30;
if ( $ypos < 200 ) {
	&footer();
	$curr_page = &newPage();
	$ypos      = 790;
	$curr_page->stringr( $f1, $fontSmall, 522, $ypos,
		$owner{'co_name'} . " Invoice No: $r{'invoiceno'}" );
	$ypos -= 60;
}

if ( defined( $siteMods{'vat'} ) ) {

	my $vat_rate     = Athena::getVAT_Rate( $r{'invincept'} );
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
	"Amount Due " . currency_format( 'GBP', $totalprice, FMT_SYMBOL ) );
$ypos -= 30;

# Build Footer
&footer();

# Close the file and write the PDF
$pdf->close;

exit;

sub newPage() {

	# Add a page which inherits its attributes from $a4
	my $page = $a4->new_page;
	return $page;
}

sub footer() {

	# Build Footer
	$ypos = 70;

	$curr_page->stringc( $f1, 9, 300, $ypos,
		    $owner{'co_name'} . ','
		  . $owner{'add1'} . ','
		  . $owner{'add2'} . ','
		  . $owner{'city'} . ','
		  . $owner{'postcode'}
		  . ',' );
	$ypos -= 12;
	$curr_page->stringc( $f1, 9, 300, $ypos,
		'Tel: ' . $owner{'tel'} . ' Fax: ' . $owner{'fax'} );
	$ypos -= 12;
	$curr_page->stringc( $f1, 9, 300, $ypos,
		'Company No: ' . $owner{'co_no'} . '  VAT No: ' . $owner{'vat_no'} );
	$ypos -= 12;
	$curr_page->stringc( $f1, 9, 300, $ypos,
		'Email: ' . $owner{'email'} . '    Website: http://' . $owner{'web'} );
	$ypos -= 20;

}

sub pdf_header {

	# Get Header Image
	my $p1        = '';
	my $imgHeader = "$dataDir/site/pdf.header.jpg";
	if ( -e $imgHeader ) {
		$p1 = $pdf->image("$dataDir/site/pdf.header.jpg");
		$curr_page->image(
			'image'  => $p1,
			'xpos'   => 0,
			'ypos'   => $ypos,
			'xscale' => 0.8,
			'yscale' => 0.8
		);
		$ypos -= 45;

	} else {
		$ypos += 60;

		# Write out address
		$curr_page->stringr( $f1, 18, 522, $ypos, "$owner{'co_name'}" );
		$ypos -= 20;
		if ( $owner{'add1'} ne '' ) {
			$curr_page->stringr( $f1, $fontSmall, 522, $ypos,
				"$owner{'add1'}" );
			$ypos -= 20;
		}
		if ( $owner{'add2'} ne '' ) {
			$curr_page->stringr( $f1, $fontSmall, 522, $ypos,
				"$owner{'add2'}" );
			$ypos -= 20;
		}
		if ( $owner{'add3'} ne '' ) {
			$curr_page->stringr( $f1, $fontSmall, 522, $ypos,
				"$owner{'add3'}" );
			$ypos -= 20;
		}
		if ( $owner{'city'} ne '' ) {
			$curr_page->stringr( $f1, $fontSmall, 522, $ypos,
				"$owner{'city'}" );
			$ypos -= 20;
		}
		if ( $owner{'county'} ne '' ) {
			$curr_page->stringr( $f1, $fontSmall, 522, $ypos,
				"$owner{'county'}" );
			$ypos -= 20;
		}
		if ( $owner{'country'} ne '' ) {
			$curr_page->stringr( $f1, $fontSmall, 522, $ypos,
				"$owner{'country'}" );
			$ypos -= 20;
		}
		if ( $owner{'postcode'} ne '' ) {
			$curr_page->stringr( $f1, $fontSmall, 522, $ypos,
				"$owner{'postcode'}" );
			$ypos -= 20;
		}

		if ( $owner{'co_no'} ne '' ) {
			$curr_page->stringr( $f1, $fontSmall, 522, $ypos,
				"Company No: $owner{'co_no'}" );
			$ypos -= 20;
		}
		if ( $owner{'vat_no'} ne '' ) {
			$curr_page->stringr( $f1, $fontSmall, 522, $ypos,
				"VAT No: $owner{'vat_no'}" );
			$ypos -= 20;
		}
	}

}

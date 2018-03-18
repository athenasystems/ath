package PDF;

use strict;

sub newPage() {
	my $a4 = shift;

	# Add a page which inherits its attributes from $a4
	my $page = $a4->new_page;
	return $page;
}

sub footer() {
	my $curr_page = shift;
	my $f1        = shift;
	my $ownr      = shift;
	my %owner     = %{$ownr};

	# Build Footer
	my $ypos = 70;

	my $addLine = '';

	if ( $owner{'add1'} ne '' ) {
		$addLine .= $owner{'add1'} . ', ';
	}

	if ( $owner{'add2'} ne '' ) {
		$addLine .= $owner{'add2'} . ', ';
	}

	if ( $owner{'add3'} ne '' ) {
		$addLine .= $owner{'add3'} . ', ';
	}

	if ( $owner{'city'} ne '' ) {
		$addLine .= $owner{'city'} . ', ';
	}

	if ( $owner{'county'} ne '' ) {
		$addLine .= $owner{'county'} . ', ';
	}

	if ( $owner{'country'} ne '' ) {
		$addLine .= $owner{'country'} . ', ';
	}

	if ( $owner{'postcode'} ne '' ) {
		$addLine .= $owner{'postcode'};
	}

	$curr_page->stringc( $f1, 9, 300, $ypos, $addLine );
	$ypos -= 12;
	if ( $owner{'web'} ne '' ) {
		$curr_page->stringc( $f1, 9, 300, $ypos,
			'Tel: ' . $owner{'tel'} . ' Fax: ' . $owner{'fax'} );
		$ypos -= 12;
	}
	if ( $owner{'web'} ne '' ) {
		$curr_page->stringc( $f1, 9, 300, $ypos,
			    'Company No: '
			  . $owner{'co_no'}
			  . '  VAT No: '
			  . $owner{'vat_no'} );
		$ypos -= 12;
	}
	if ( $owner{'web'} ne '' ) {
		$curr_page->stringc( $f1, 9, 300, $ypos,
			    'Email: '
			  . $owner{'email'}
			  . '    Website: http://'
			  . $owner{'web'} );
		$ypos -= 20;
	}

}

sub pdf_header {
	my $curr_page = shift;
	my $f1        = shift;
	my $pdf       = shift;
	my $ypos      = shift;
	my $dataDir   = shift;
	my $fontSmall = shift;
	my $ownr      = shift;
	my %owner     = %{$ownr};

	# Get Header Image
	my $p1        = '';
	my $imgHeader = "$dataDir/pdf_header.jpg";
	if ( -e $imgHeader ) {
		$p1 = $pdf->image($imgHeader);
		$curr_page->image(
			'image'  => $p1,
			'xpos'   => 0,
			'ypos'   => $ypos,
			'xscale' => 1,
			'yscale' => 1
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
#
#		if ( $owner{'co_no'} ne '' ) {
#			$curr_page->stringr( $f1, $fontSmall, 522, $ypos,
#				"Company No: $owner{'co_no'}" );
#			$ypos -= 20;
#		}
#		if ( $owner{'vat_no'} ne '' ) {
#			$curr_page->stringr( $f1, $fontSmall, 522, $ypos,
#				"VAT No: $owner{'vat_no'}" );
#			$ypos -= 20;
#		}
	}
	return $ypos;

}

sub addressTo {
	my $dbh       = shift;
	my $curr_page = shift;
	my $f1        = shift;
	my $pdf       = shift;
	my $ypos      = shift;
	my $fontSmall = shift;
	my $co_dets   = shift;
	my $ownr      = shift;

	my %co_details = %{$co_dets};
	my %owner      = %{$ownr};

	


	$curr_page->printnl( "$co_details{'co_name'}", $f1, $fontSmall, 42, $ypos );
	$ypos -= 20;
	$curr_page->printnl( "$co_details{'add1'}", $f1, $fontSmall, 42, $ypos );
	$ypos -= 20;
	if ( $co_details{'add2'} ne '' ) {
		$curr_page->printnl( "$co_details{'add2'}", $f1, $fontSmall, 42,
			$ypos );
		$ypos -= 20;
	}
	if ( $co_details{'add3'} ne '' ) {
		$curr_page->printnl( "$co_details{'add3'}", $f1, $fontSmall, 42,
			$ypos );
		$ypos -= 20;
	}
	if ( $co_details{'city'} ne '' ) {
		$curr_page->printnl( "$co_details{'city'}", $f1, $fontSmall, 42,
			$ypos );
		$ypos -= 20;
	}
	if ( $co_details{'county'} ne '' ) {
		$curr_page->printnl( "$co_details{'county'}", $f1, $fontSmall, 42,
			$ypos );
		$ypos -= 20;
	}
	$curr_page->printnl( "$co_details{'postcode'}", $f1, $fontSmall, 42,
		$ypos );
	$ypos -= 20;

	if ( $co_details{'inv_contact'} > 0 ) {
		$curr_page->printnl(
			"FAO: "
			  . Athena::getCustExtName( $dbh, $co_details{'inv_contact'} ),
			$f1, $fontSmall, 42, $ypos
		);
		$ypos -= 20;
	}
return $ypos;
}
1;

package Website;

use strict;

sub makeHeader {
	my $co_name = shift;
	my $header  = '<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>' . $co_name . '</title>
<link href="/pub/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="/pub/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet">
  <link href="/pub/bootstrap/css/theme.css" rel="stylesheet">
  
<style type="text/css">
</style>
<script type="text/javascript" src="/js/common.js"></script>
<script type="text/javascript" src="/js/mng/common.js"></script>
</head>
<body role="document">
<div style="margin:10px;">';

	return $header;
}

sub makeNav {
	my $dbhsys  = shift;
	my $sitesid = shift;
	my $co_name = shift;

	my $html = '
<!-- Static navbar -->
<nav class="navbar navbar-inverse navbar-fixed-top">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed"
				data-toggle="collapse" data-target="#navbar" aria-expanded="false"
				aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span> <span
					class="icon-bar"></span> <span class="icon-bar"></span> <span
					class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="/">' . $co_name . '</a>
		</div>
		<div id="navbar" class="navbar-collapse collapse">
			<ul class="nav navbar-nav">
';

	$html .= <<EOHTML;
	<li class=""><a href="/quote" title="Request a Quote from $co_name">Quote</a></li>
</ul>
</div>
<!--/.nav-collapse -->
</div>
<!--/.container-fluid -->
</nav>
EOHTML

	return $html;

}

sub makeFooter {
	my $ownr   = shift;
	my %owner  = %{$ownr};
	my $footer = <<EOHTML;
	</div>	
	<div  class="text-center">
	<p>&copy; 2016 Athena Systems</p>
	<br><br>
	</div>	
    <script src="/pub/js/jquery.min.js"></script>    
    <script src="/pub/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>		
EOHTML

	return $footer;
}

sub makeAddressedFooter {
	my $ownr             = shift;
	my %owner            = %{$ownr};
	my $companyFooterTxt = &Athena::makeAddress( \%owner );

	$companyFooterTxt =~ s/Tel/<br>Tel/gs;
	$companyFooterTxt =~ s/Email/<br>Email/gs;
	$companyFooterTxt =~ s/Company No/<br>Company No/gs;
	$companyFooterTxt =~ s/Website/<br>Website/gs;

	my $footer = <<EOHTML;
	</div>
	<div  class="text-center">$companyFooterTxt<br>
	<p>&copy; 2016 Athena Systems</p><br><br></div>	
    <script src="/pub/js/jquery.min.js"></script>    
    <script src="/pub/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>		
EOHTML

	return $footer;
}

sub outputHTML {
	my $dbhsys  = shift;
	my $sitesid = shift;
	my $pg      = shift;
	my $html    = shift;
	my $sql =
	  "SELECT text FROM athdb$sitesid.web WHERE place='nav' AND page=?;";
	my $cursor = $dbhsys->prepare($sql);
	my $rtn    = $cursor->execute($pg);

	my @row     = $cursor->fetchrow_array;
	my $outFile = lc( $row[0] ) . '.html';
	if ( !-e "/srv/sites/$sitesid.athena.systems/www" ) {
		system("mkdir -p /srv/sites/$sitesid.athena.systems/www");
	}

	#	print $html;
	open( FH, ">/srv/sites/$sitesid.athena.systems/www/$outFile" );
	print FH $html;
	close(FH);

	return;
}

sub makeWebPages {
	my $dbhsys  = shift;
	my $sitesid = shift;
	my %owner   = Athena::getOwnerDetails( $dbhsys, $sitesid );
	my $co_name = $owner{'co_name'};

	#print "Making the Web Site for $sitesid\n";

	my $domain = $sitesid . '.athena.systems';

	my $sql    = "SELECT * FROM athdb$sitesid.web";
	my $cursor = $dbhsys->prepare($sql);
	my $rtn    = $cursor->execute();
	my $html   = '';
	open( FH, "</srv/ath/src/pub/startbootstrap/index.html" );
	while (<FH>) {
		$html .= $_;
	}
	close(FH);

	my ( $tagline, $abtHead, $abtTXT, $srvHead, $srvText );

	while ( my $row = $cursor->fetchrow_hashref ) {
		my %r     = %{$row};
		my $text  = $r{'text'};
		my $place = $r{'place'};

		if ( $place eq 'p1t' ) { }

		if ( $place eq 'headtag' ) {
			$html =~ s/TAGLINE/$text/gs;
		}

		if ( $place eq 'abouthead' ) {
			$html =~ s/ABOUTHEAD/$text/gs;
		}

		if ( $place eq 'abouttxt' ) {
			$html =~ s/ABOUTTXT/$text/gs;
		}

		if ( $place eq 'srv1head' ) {
			$html =~ s/SRV1HEAD/$text/gs;
		}

		if ( $place eq 'srv1txt' ) {
			$html =~ s/SRVTXT1/$text/gs;
		}

		if ( $place eq 'srv2head' ) {
			$html =~ s/SRV2HEAD/$text/gs;
		}

		if ( $place eq 'srv2txt' ) {
			$html =~ s/SRVTXT2/$text/gs;
		}
		if ( $place eq 'srv3head' ) {
			$html =~ s/SRV3HEAD/$text/gs;
		}

		if ( $place eq 'srv3txt' ) {
			$html =~ s/SRVTXT3/$text/gs;
		}

		if ( $place eq 'srv4head' ) {
			$html =~ s/SRV4HEAD/$text/gs;
		}

		if ( $place eq 'srv4txt' ) {
			$html =~ s/SRVTXT4/$text/gs;
		}

		#&outputHTML( $dbhsys, $sitesid, $pg, $html );

	}

	$html =~ s/CO_NAME/$co_name/gs;
	$html =~ s/TELNO/$owner{'tel'}/gs;
	$html =~ s/EMAIL/$owner{'email'}/gs;

	open( FH, ">/srv/sites/$domain/www/index.html" );
	print FH $html;
	close(FH);
	
	&Website::makeTmplPages(  $sitesid, \%owner );
	&Website::makeQuotePage( $dbhsys, $sitesid, \%owner );
	&Website::makeDonePage( $dbhsys, $sitesid, \%owner );
	&Website::makeLoginPage( $dbhsys, $sitesid, \%owner );
	&Website::makePwdResetPage( $sitesid, \%owner );
	&Website::makePwdReseterPage( $sitesid, \%owner );
}

sub makePageContent {
	my $dbhsys  = shift;
	my $sitesid = shift;
	my $pg      = shift;
	my $ownr    = shift;
	my %owner   = %{$ownr};

	my $map     = '';
	my $address = '';

	my $sql =
"SELECT text,place FROM athdb$sitesid.web WHERE place LIKE \"p%\" AND page=?;";
	my $cursor = $dbhsys->prepare($sql);
	my $rtn    = $cursor->execute($pg);

	#print "$sql\n";exit;
	my @txts   = ();
	my @titles = ();
	while ( my @row = $cursor->fetchrow_array ) {
		if ( $row[1] =~ /t/ ) {
			push( @titles, $row[0] );
		} else {
			push( @txts, $row[0] );
		}
	}

	my $pgText = '';
	for ( my $i = 0 ; $i <= $#titles ; $i++ ) {
		$pgText .= <<EOHTML;
<div class="panel panel-primary">
	<div class="panel-heading">
		<strong>$titles[$i]</strong>
	</div>
	<div class="panel-body">
		<p>
			$txts[$i]
EOHTML
		if ( $pg == 4 ) {
			$address = &Athena::makeAddress( \%owner );
			$address =~ s/,/<br>/gs;
			$pgText .= $address;
		}
		$pgText .= <<EOHTML;
</p></div></div>
EOHTML
		if ( $pg == 4 ) {
			my $q = $owner{'city'};
			$q =~ s/\W/\+/g;
			$pgText .= &getMapPageContent($q);
		}
	}
	return $pgText;
}

sub makeQuotePage {
	my $dbhsys  = shift;
	my $sitesid = shift;
	my $ownr    = shift;
	my %owner   = %{$ownr};
	my $co_name = $owner{'co_name'};

	my $htmlTmpl = '';
	open( FH, "</srv/ath/src/pub/startbootstrap/tmpl.html" );
	while (<FH>) {
		$htmlTmpl .= $_;
	}
	close(FH);

	my $html = <<EOHTML;
<h3>Request for Quote</h3>

<form action="/bin/quote.pl"
	enctype="multipart/form-data" method="post" name="editcust">
	
	<fieldset>


		<div class="form-group row"><label for="content" class=" col-sm-2 form-control-label">Description *</label>
	<div class="col-sm-10">
<textarea name="content" rows="4" cols="30" id="content" class="form-control "></textarea>
</div></div><div class="form-group row">
<label for="fname" class="col-sm-2 form-control-label">First Name *</label>
<div class="col-sm-10"><input type="text"
	name="fname" id="fname" value="" class=" form-control"  placeholder="First Name *">
</div> </div>

<div class="form-group row">
<label for="sname" class="col-sm-2 form-control-label">Surname</label>
<div class="col-sm-10"><input type="text"
	name="sname" id="sname" value="" class=" form-control"  placeholder="Surname">
</div> </div>

<div class="form-group row">
<label for="email" class="col-sm-2 form-control-label">Email</label>
<div class="col-sm-10"><input type="text"
	name="email" id="email" value="" class=" form-control"  placeholder="Email">
</div> </div>

<div class="form-group row">
<label for="tel" class="col-sm-2 form-control-label">Tel</label>
<div class="col-sm-10"><input type="text"
	name="tel" id="tel" value="" class=" form-control"  placeholder="Tel">
</div> </div>



	</fieldset>

	<fieldset class="buttons">
		<div class="text-right">
	<input type="submit"  value="Request Quote" class="btn btn-primary"></div>
	</fieldset>

</form>

EOHTML

	$htmlTmpl =~ s/CONTENT/$html/s;
	$htmlTmpl =~ s/CO_NAME/$co_name/gs;

	#	print $html;
	my $outFile = 'quote.html';

	open( FH, ">/srv/sites/$sitesid.athena.systems/www/$outFile" );
	print FH $htmlTmpl;
	close(FH);

	return;
}

sub makePwdResetPage {
	my $sitesid = shift;
	my $ownr    = shift;
	my %owner   = %{$ownr};
	my $co_name = $owner{'co_name'};

	my $htmlTmpl = '';
	open( FH, "</srv/ath/src/pub/startbootstrap/reset.php" );
	while (<FH>) {
		$htmlTmpl .= $_;
	}
	close(FH);

	#$htmlTmpl =~ s/CONTENT/$html/s;
	$htmlTmpl =~ s/CO_NAME/$co_name/gs;
	$htmlTmpl =~ s/SITESID/$sitesid/gs;
	
	#	print $html;
	my $outFile = 'reset.php';

	open( FH, ">/srv/sites/$sitesid.athena.systems/www/$outFile" );
	print FH $htmlTmpl;
	close(FH);

	return;
}


sub makeTmplPages {
	my $sitesid = shift;
	my $ownr    = shift;
	my %owner   = %{$ownr};
	my $co_name = $owner{'co_name'};

	my $htmlTmpl = '';
	open( FH, "</srv/ath/src/pub/startbootstrap/head.php" );
	while (<FH>) {
		$htmlTmpl .= $_;
	}
	close(FH);

	$htmlTmpl =~ s/CO_NAME/$co_name/gs;
	$htmlTmpl =~ s/SITESID/$sitesid/gs;
	
	open( FH, ">/srv/sites/$sitesid.athena.systems/www/head.php" );
	print FH $htmlTmpl;
	close(FH);

	$htmlTmpl = '';
	open( FH, "</srv/ath/src/pub/startbootstrap/foot.php" );
	while (<FH>) {
		$htmlTmpl .= $_;
	}
	close(FH);

	$htmlTmpl =~ s/CO_NAME/$co_name/gs;
	$htmlTmpl =~ s/SITESID/$sitesid/gs;
	
	open( FH, ">/srv/sites/$sitesid.athena.systems/www/foot.php" );
	print FH $htmlTmpl;
	close(FH);

	return;
}

sub makePwdReseterPage {
	my $sitesid = shift;
	my $ownr    = shift;
	my %owner   = %{$ownr};
	my $co_name = $owner{'co_name'};

	my $htmlTmpl = '';
	open( FH, "</srv/ath/src/pub/startbootstrap/resetpwd.php" );
	while (<FH>) {
		$htmlTmpl .= $_;
	}
	close(FH);

	#$htmlTmpl =~ s/CONTENT/$html/s;
	$htmlTmpl =~ s/CO_NAME/$co_name/gs;
	$htmlTmpl =~ s/SITESID/$sitesid/gs;
	
	#	print $html;
	my $outFile = 'r.php';

	open( FH, ">/srv/sites/$sitesid.athena.systems/www/$outFile" );
	print FH $htmlTmpl;
	close(FH);

	return;
}
sub makeDonePage {
	my $dbhsys  = shift;
	my $sitesid = shift;
	my $ownr    = shift;
	my %owner   = %{$ownr};
	my $co_name = $owner{'co_name'};

	my $htmlTmpl = '';
	open( FH, "</srv/ath/src/pub/startbootstrap/tmpl.html" );
	while (<FH>) {
		$htmlTmpl .= $_;
	}
	close(FH);

	my $html = <<EOHTML;
<h3>Request for Quote has been recieved. </h3>

<p>$co_name have recieved your request.</p>

<p>Many thanks</p>


EOHTML

	$htmlTmpl =~ s/CONTENT/$html/s;
	$htmlTmpl =~ s/CO_NAME/$co_name/gs;

	#	print $html;
	my $outFile = 'done.html';

	open( FH, ">/srv/sites/$sitesid.athena.systems/www/$outFile" );
	print FH $htmlTmpl;
	close(FH);

	return;
}

sub makeLoginPage {
	my $dbhsys  = shift;
	my $sitesid = shift;
	my $ownr    = shift;
	my %owner   = %{$ownr};
	my $co_name = $owner{'co_name'};

	my $htmlTmpl = '';
	open( FH, "</srv/ath/src/pub/startbootstrap/tmpl.html" );
	while (<FH>) {
		$htmlTmpl .= $_;
	}
	close(FH);

	my $phpHead = <<EOHTML;
	<?php
if (empty(\$_SERVER['HTTPS']) || \$_SERVER['HTTPS'] == 'off') {
	header("Location: https://$sitesid.athena.systems/login");
}
?>
EOHTML

	my $html = <<EOHTML;
	<div style="text-align:left;width:320px;margin-left:auto;margin-right:auto;">
<h3 style="margin-left: 20px;">Log In</h3><br>
<?php
if (\$_GET ['pf'] == 'y') {
	?>
<div class="alert alert-danger" role="alert">
	Ooops ... <br>That Username and Password were not accepted<br>Please
	try again
</div>
<?php
}
?>
	<form action="https://$sitesid.athena.systems/bin/pass.pl" method="post"
		class="form-group" id="login" name="login">
		<fieldset class="form-group">
			<div class="form-group row">
				<label class="col-sm-3 form-control-label" for="id_username">Username</label>
				<div class="col-sm-9">
					<input id="id_username" type="text" name="nick" maxlength="30"
						size="20" style="width: 120px;" class="form-control">
				</div>
			</div>

			<div class="form-group row">
				<label class="col-sm-3 form-control-label" for="id_password">Password</label>
				<div class="col-sm-9">
					<input type="password" name="pw" id="id_password" maxlength="30"
						size="20" style="width: 120px;" class="form-control">
				</div>			
			</div>
		</fieldset>
			
			<br>
			
		<fieldset class="form-group">				
			<input value="Login" class="btn btn-primary" type="submit">				
		</fieldset>
		
		<input type="hidden" name="sid" value="OWLDROP">
		
		<br><br><a href="/reset">Forgot Password?</a>
	</form>

</div>
<br clear="all">
EOHTML

	my $owl_drop = Athena::obscure($sitesid);
	$html =~ s/OWLDROP/$owl_drop/s;

	$htmlTmpl =~ s/CONTENT/$html/s;
	$htmlTmpl =~ s/CO_NAME/$co_name/gs;

	#	print $html;
	my $outFile = 'login.php';

	open( FH, ">/srv/sites/$sitesid.athena.systems/www/$outFile" );
	print FH $phpHead . $htmlTmpl;
	close(FH);

	return;
}

sub getMapPageContent {
	my $q = shift;
	if ( ( !defined($q) ) || ( $q eq '' ) ) { return ''; }
	my $html = <<EOHTML;
<iframe width="450" height="450" frameborder="0" style="border:0"
  src="https://www.google.com/maps/embed/v1/place?key=AIzaSyDI7Z1lIap6WeZvNTPxI0RFliGWtEmTjeU&amp;q=$q" allowfullscreen>
</iframe>
EOHTML
}

1;

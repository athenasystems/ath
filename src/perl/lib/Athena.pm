package Athena;

use strict;

use MIME::Base64;
use Crypt::MCrypt;
use CGI::Cookie;

our $domain = 'athena.systems';

#if ( Athena::isDev() ) {
#	$domain = 'dev' . $Athena::domain;
#}

sub dbrootconnect() {
	my $dbh =
	  DBI->connect( 'DBI:mysql:athcore:localhost', 'root',
		&Athena::getrootDBPass(), { RaiseError => 1 } );
	return ($dbh);

}

sub dbsysconnect {
	my $dbh =
	  DBI->connect( "DBI:mysql:athcore:localhost", 'athena',
		Athena::getDBPass(), { RaiseError => 1 } );
	return ($dbh);
}

sub dbsiteconnect {
	my $sitesid = shift;
	my $db      = 'athdb' . $sitesid;
	my $user    = 'athena' . $sitesid;
	my $pwd     = Athena::getsiteDBPass($sitesid);

	#print "$sitesid $db $user $pwd\n";exit;
	my $dbh =
	  DBI->connect( "DBI:mysql:$db:localhost", $user, $pwd,
		{ RaiseError => 1 } );
	return ($dbh);
}

sub isDev {
	my $hostname = `hostname`;
	chomp($hostname);
	if ( $hostname =~ /^server\d+/ ) {
		return 0;
	} else {
		return 1;
	}
}

sub getVAT_Rate {
	my $vat_incept        = shift;
	my $vat_rate          = 0;
	my $vat_change_date_1 = 1294099200;    # From 17.5% to 20% on 4/1/2011

	if ( $vat_incept < $vat_change_date_1 ) {
		$vat_rate = 0.175;
	} else {
		$vat_rate = 0.2;
	}
	return $vat_rate;
}

sub getVatText {
	my $vat_rate = shift;
	my $vatTxt   = ( $vat_rate * 100 );
	$vatTxt = $vatTxt . '%';
	return $vatTxt;
}

sub getCustExtName {
	my $dbh        = shift;
	my $contactsid = shift;

	if ( !defined($contactsid) ) {
		return 'Unknown';
	}
	my $sqltext =
	  "SELECT fname,sname FROM contacts WHERE contactsid=" . $contactsid;

	my $sth = $dbh->prepare($sqltext);
	$sth->execute();
	my $rItems = $sth->fetchrow_hashref;
	my %r      = %{$rItems};
	my $ret    = $r{'fname'} . ' ' . $r{'sname'};

	return $ret;
}

sub getDBPass() {
	open( FH, "</srv/ath/etc/athena.conf" );
	while (<FH>) {
		chomp;
		my ( $n, $p ) = split( /=/, $_ );
		if ( $n eq 'athenadbpwd' ) {
			return $p;
		}
	}
	close(FH);
}

sub getsiteDBPass() {
	my $sitesid = shift;
	open( FH, "</srv/ath/etc/users" );
	while (<FH>) {
		chomp;
		my ( $n, $p ) = split( /\t/, $_ );
		if ( $n eq 'athena' . $sitesid ) {
			return $p;
		}
	}
	close(FH);
}

sub getrootDBPass() {

	our $rootDBPass = `cat /etc/mysql.pw`;
	chomp($rootDBPass);

	return $rootDBPass;

}

sub getOwnerDetails {
	my $dbh     = shift;
	my $sitesid = shift;

	my $sqltext =
"SELECT * FROM athcore.sites,athdb$sitesid.adds WHERE athcore.sites.sitesid=$sitesid AND athcore.sites.addsid=athdb$sitesid.adds.addsid";

	my $sth = $dbh->prepare($sqltext);
	$sth->execute() or die "$dbh->errstr";
	my $rItems = $sth->fetchrow_hashref;
	my %r      = %{$rItems};

	return %r;
}

sub getHostName {

	#
	# Decide URL
	#
	my $webhost   = '';
	my $inthost   = '';
	my $custhost  = '';
	my $supphost  = '';
	my $admhost   = '';
	my $staffhost = '';
	my $domain    = $Athena::domain;

	#	if ( Athena::isDev() ) {
	#		$domain = 'dev' . $Athena::domain;
	#	}

	$webhost   = 'http://www.' . $domain;
	$inthost   = 'http://mng.' . $domain;
	$custhost  = 'http://customers.' . $domain;
	$supphost  = 'http://suppliers.' . $domain;
	$admhost   = 'http://adm.' . $domain;
	$staffhost = 'http://staff.' . $domain;

	return ( $webhost, $inthost, $custhost, $supphost, $admhost, $staffhost );
}

sub generatePwd {
	my $length   = shift;
	my $password = '';
	my $possible = 'abcdefghijkmnpqrstuvwxyz23456789ABCDEFGHJKLMNPQRSTUVWXYZ';
	while ( length($password) < $length ) {
		$password .=
		  substr( $possible, ( int( rand( length($possible) ) ) ), 1 );
	}
	return $password;
}

sub getDataDir {
	my $sitesid = shift;

	my $d = '/srv/ath/var/data/' . $sitesid;

	return $d;
}

sub obscure {

	my $txt = shift;

	use Crypt::CBC;
	my $cipher = Crypt::CBC->new(
		-key    => 'gg65RxmMmJjk9Io0OhR4eDtY',
		-cipher => 'Blowfish'
	);
	return $cipher->encrypt_hex($txt);

}

sub reveal {
	my $txt = shift;

	use Crypt::CBC;
	my $cipher = Crypt::CBC->new(
		-key    => 'gg65RxmMmJjk9Io0OhR4eDtY',
		-cipher => 'Blowfish'
	);

	return $cipher->decrypt_hex($txt);

}

sub cryptify {
	my $plain_text = shift;

	my $key       = "gg65RxmMmJjk9Io0OhR4eDtY";    # 24 bit Key
	my $iv        = "fYfhHeDm";                    # 8 bit IV
	my $bit_check = 8;                             # bit amount for diff algor.

	my $algorithm = "tripledes";
	my $mode      = "cbc";
	my $obj       = Crypt::MCrypt->new(
		algorithm => $algorithm,
		mode      => $mode,
		key       => $key,
		iv        => $iv,
	);
	my $hash = $obj->decrypt($plain_text);
	return $hash;
}

sub pass {

	my $sitesid = shift;
	my $usr     = shift;
	my $pwd     = shift;

	my $dbhsite = Athena::dbsiteconnect($sitesid);
	my $sql     = "SELECT pw FROM athdb$sitesid.pwd WHERE usr='$usr'";
	my ($pw)    = $dbhsite->selectrow_array($sql);

	if ( ( !defined($pw) ) || ( $pw eq '' ) ) {
		return 0;
	}

	if ( crypt( $pwd, $pw ) eq $pw ) {
		return 1;
	} else {
		return 0;
	}
}

sub chkCookie {

	my $key       = "gg65RxmMmJjk9Io0OhR4eDtY";    # 24 bit Key
	my $iv        = "fYfhHeDm";                    # 8 bit IV
	my $bit_check = 8;                             # bit amount for diff algor.

	my $algorithm = "tripledes";
	my $mode      = "cbc";
	my $obj       = Crypt::MCrypt->new(
		algorithm => $algorithm,
		mode      => $mode,
		key       => $key,
		iv        => $iv,
	);

	my %cookies     = CGI::Cookie->fetch;
	my $cipher_text = $cookies{'ATHENA'}->value;
	my $plain_text  = $obj->decrypt( decode_base64($cipher_text) );
	my ( $sitesid, $usrid, $usr, $pwd, $now ) = split( /\./, $plain_text );

	#	if ( Athena::pass( $sitesid, $usr, $pwd ) ) {
	return 1;

	#	} else {
	#		return 0;
	#	}
}

sub dropCookie {
	use CGI::Cookie;

	my $sid   = shift;
	my $usrid = shift;
	my $usr   = shift;
	my $now   = shift;

	# Create new cookie and send
	my $line  = $sid . '.' . $usrid . '.' . $usr . '.' . $now;
	my $value = AthenaTest::docrypt($line);

	my $cookie = CGI::Cookie->new( -name => 'ATHENA', -value => $value );

	print header( -cookie => [$cookie] );

}

sub makeAddress {
	my $ownr    = shift;
	my %owner   = %{$ownr};
	my $address = $owner{'co_name'} . ', ';
	if ( $owner{'add1'} ne '' ) { $address .= $owner{'add1'} . ', '; }
	if ( $owner{'add2'} ne '' ) { $address .= $owner{'add2'} . ', '; }
	if ( $owner{'city'} ne '' ) { $address .= $owner{'city'} . ', '; }
	if ( $owner{'postcode'} ne '' ) {
		$address .= $owner{'postcode'} . ', ';
	}

	# . '<br>';}
	if ( $owner{'tel'} ne '' ) { $address .= 'Tel: ' . $owner{'tel'} . ', '; }
	if ( $owner{'fax'} ne '' ) { $address .= ' Fax: ' . $owner{'fax'} . ', '; }
	if ( $owner{'co_no'} ne '' ) {
		$address .= 'Company No: ' . $owner{'co_no'} . ', ';
	}
	if ( $owner{'vat_no'} ne '' ) {
		$address .= '  VAT No: ' . $owner{'vat_no'} . ', ';
	}

	#. '<br>';
	if ( $owner{'email'} ne '' ) {
		$address .= 'Email: ' . $owner{'email'} . ', ';
	}
	if ( $owner{'web'} ne '' ) {
		$address .= '    Website: http://' . $owner{'web'};
	}
	return $address;
}

sub getSiteMods {
	my $dbsys   = shift;
	my $sitesid = shift;

	my $sqltext =
"SELECT section FROM modules,mods WHERE mods.modulesid=modules.modulesid AND sitesid='"
	  . $sitesid . "'";

	# print $sqltext;

	my $cursor = $dbsys->prepare($sqltext);
	my $rtn = $cursor->execute() or die "$dbsys->errstr";

	my %siteMods = ();

	while ( my @row = $cursor->fetchrow_array ) {
		#warn $row[0];
		$siteMods{$row[0]}=1;
	}

	return %siteMods;
}

sub getSiteIDs {
	my $dbsys   = shift;

	my $sqltext = "SELECT sitesid FROM sites";

	# print $sqltext;

	my $cursor = $dbsys->prepare($sqltext);
	my $rtn = $cursor->execute() or die "$dbsys->errstr";

	my @ids = ();

	while ( my @row = $cursor->fetchrow_array ) {
		#warn $row[0];
		push(@ids,$row[0]);
	}

	return @ids;
}

1;

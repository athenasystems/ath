package DNS;

use strict;

sub make_dbathena {

	my $dbhsys = shift;

	use Net::Address::IP::Local;

	# Get the local system's IP address that is "en route" to "the internet":
	my $ip = Net::Address::IP::Local->public;

	my $endip = $ip;
	$endip =~ s/^.*\.(\d+)$/$1/;

	my $subip = $ip;
	$subip =~ s/^(\d+)\..*$/$1/;

	my $ip2 = '213.171.197.6';

	my $conf    = '';
	my $revconf = '';

	open( FH, "</srv/ath/etc/bind/db.athena.systems" );
	while (<FH>) {
		$conf .= $_;
	}
	close(FH);
	open( FH, "</srv/ath/etc/bind/db.sub" );
	while (<FH>) {
		$revconf .= $_;
	}
	close(FH);

	my $now = time();

	$conf    =~ s/IPADD/$ip/gs;
	$conf    =~ s/IP2ADD/$ip2/gs;
	$conf    =~ s/SERIAL/$now/s;
	$revconf =~ s/sub/$endip/gs;
	$revconf =~ s/SERIAL/$now/s;

	my $sql    = "SELECT sitesid,subdom,domain FROM sites;";
	my $cursor = $dbhsys->prepare($sql);
	my $rtn    = $cursor->execute();
	while ( my $row = $cursor->fetchrow_hashref ) {
		my %r = %{$row};
		
		$conf .= "$r{'subdom'}     IN      A       $ip\n";		
		$revconf .= "$endip  IN  PTR  $r{'subdom'}.athena.systems.\n";

#		if ( ( defined( $r{'domain'} ) ) && ( $r{'domain'} ne '' ) ) {
#			$conf    .= "$r{'domain'} IN  A   $ip\n";
#			$revconf .= "$r{'domain'} IN  PTR  $r{'sitesid'}.athena.systems.\n";
#		}
	}
	
	for (my $i=100;$i<190;$i++){
		$conf .= "$i     IN      A       $ip\n";
		$revconf .= "$endip  IN  PTR  $i.athena.systems.\n";
	}
	
	

	open( FH, ">/etc/bind/db.athena.systems" );
	print FH $conf;
	close(FH);

	open( FH, ">/etc/bind/db.$subip" );
	print FH $revconf;
	close(FH);
		
	system("sudo /etc/init.d/bind9 restart >> /srv/ath/var/log/bind");
	
}

sub addToNamedLocal {

	use Net::Address::IP::Local;

	# Get the local system's IP address that is "en route" to "the internet":
	my $ip = Net::Address::IP::Local->public;

	my @ips = split( /\./, $ip );
	my $revip = $ips[2] . '.' . $ips[1] . '.' . $ips[0];

	my $subip = $ip;
	$subip =~ s/^(\d+)\..*$/$1/;

	my $ip2 = '213.171.197.6';

	my $conf = '';

	open( FH, "</srv/ath/etc/bind/named.conf.local" );
	while (<FH>) {
		$conf .= $_;
	}
	close(FH);

	$conf =~ s/SUPIP/$subip/gs;
	$conf =~ s/IP2ADD/$ip2/gs;
	$conf =~ s/REVIPADD/$revip/gs;

	open( FH, ">/etc/bind/named.conf.local" );
	print FH $conf;
	close(FH);
}


sub domainNameIsUnique {
	my $dbhsys = shift;
	my $name   = shift;

	my $sql    = "SELECT COUNT(*) FROM sites WHERE subdom='$name';";
	my $sth = $dbhsys->prepare($sql);
	my $rtn    = $sth->execute();
	my @row  = $sth->fetchrow_array;

	if ( $row[0] )  {
		return 0;
	}
	return 1;
}

sub makeDomainName {
	my $dbhsys = shift;
	my $name   = shift;
	
	$name =~ s/\W//g;
	my $sub=$name;
	my $no     = 1;
	
	while ( !domainNameIsUnique( $dbhsys, $sub ) ) {
		$sub = "$name$no";
		$no++;
	}
	return $sub;
}


1;

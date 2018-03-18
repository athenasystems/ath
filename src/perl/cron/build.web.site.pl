#!/usr/bin/perl

use strict;
use lib ('/srv/ath/src/perl/lib');
use Athena;
use DBI;
use DNS;

my $sitesid   = shift;
my $domain   = $sitesid . '.' . $Athena::domain;
my @sites    = ();
my $confText = '';
my $live     = 1;

# Get DB Handle
my $dbhsys = Athena::dbsysconnect();

my $srvrootDir = '/srv/sites/' . $domain;

my %owner = Athena::getOwnerDetails( $dbhsys, $sitesid );
my $sub = &DNS::makeDomainName( $dbhsys,lc( $owner{'co_name'} ));
#print $sub."\n";exit;

if ( -e $srvrootDir ) {
	print "Domain exists already ...\n";
	exit;
}

#$subdomain .= '.' . $Athena::domain;
my $subdomain = $sub . '.' . $Athena::domain;
#print "\n#### Making the Web Site for $domain ";

# Set the site as Active
	my $sqlUpdate = "UPDATE athcore.sites SET subdom=? WHERE sitesid=?";
	my $sthUpdate = $dbhsys->prepare($sqlUpdate);
	$sthUpdate->execute($sub,$sitesid);




&mkSiteDir($domain);

&cpSkel;

if ( $domain =~ /athena.systems$/ ) {

	print "\n#### Rebuilding DNS ";

	&DNS::make_dbathena($dbhsys);
#	&addToDNS($sitesid);
#	&addToDNS($sub);
}

&addToConf($domain);

if ( !-e "/etc/letsencrypt/live/$subdomain" ) {
	&mkApacheConf80( $domain, $subdomain );
} else {
	&mkApacheConf( $domain, $subdomain );
}

&reloadApache;

&makeWebSite($sitesid);

if ( !-e "/etc/letsencrypt/live/$subdomain" ) {
	&makeSSL($domain,$subdomain);
	&mkApacheConf( $domain, $subdomain );
	&reloadApache;
}

system("chown -R www-data $srvrootDir");
system("chmod -R 755 $srvrootDir");

exit;

sub addToConf {
	my $domain = shift;
	$confText .=
	  'Include ' . $srvrootDir . '/etc/httpd/' . $domain . '.conf' . "\n";

	#print "Adding $domain to the live sites Apache Conf at /srv/etc/httpd/live/athenasites.conf\n";
	if ($live) {
		open( FHOUT, ">>/srv/etc/httpd/live/athenasites.conf" );
		print FHOUT $confText;
		close FHOUT;
	}
}

sub mkSiteDir {
	my $domain = shift;
	&makeDirIfNot($srvrootDir);

	my @folders = ( 'etc', 'etc/httpd', 'lib', 'lib/php', 'www' );
	foreach (@folders) {
		my $siteDir = $srvrootDir . '/' . $_;
		&makeDirIfNot($siteDir);
	}
}

sub cpSkel {
	system("cp -R /srv/ath/src/pub/startbootstrap/* $srvrootDir/www/");

}

sub makeDirIfNot {
	my $f = shift;
	if ( !-e $f ) {

		#print "Making Dir:$f\n";
		if ($live) {
			system("mkdir -p $f");
		}
	}
}

sub makeSSL {

	return;

	my $domain = shift;
	my $subdomain = shift;

	if ( !Athena::isDev() ) {

		if ( !-e "/etc/letsencrypt/live/$domain" ) {

			print "Making SSL Certificate with LetsEncrypt:\n";
			my $cmd = "certbot";
			my $params =
			  "certonly  --email petelock\@gmail.com --webroot -w /srv/sites/$domain/www -d $subdomain -d $domain";
			print $cmd . "\n";
			if ($live) {
				system("$cmd $params");
			}
		}
	} else {
		print "Skipping SSL certificate as on Dev Server\n";
	}
}

sub mkApacheConf80 {
	my $domain    = shift;
	my $subdomain = shift;
	$subdomain .= '.' . $Athena::domain;

	my $apacheConf = qq|
<VirtualHost *:80>
        ServerName $subdomain
        ServerAlias www.$domain $domain
        ServerAdmin webmodulesuk\@gmail.com

        DocumentRoot $srvrootDir/www

        <Directory $srvrootDir/www/>
                AllowOverride None
                Options MultiViews Indexes
                Order allow,deny
                allow from all
                Require all granted
        </Directory>

        DirectoryIndex home


	Alias /pub/ /srv/ath/src/pub/
        <Directory /srv/ath/src/pub/>
                AllowOverride None
                Order allow,deny
                Allow from all
                Require all granted
        </Directory>

</VirtualHost>
|;
	my $confFile = $srvrootDir . '/etc/httpd/' . $domain . '.conf';
	#print "Writing out the Apache Conf to $confFile\n";
	if ($live) {
		open( FHOUT2, ">$confFile" ) || die;
		print FHOUT2 $apacheConf;
		close FHOUT2;
	}

}

sub mkApacheConf {
	my $domain    = shift;
	my $subdomain = shift;

	my $apacheConf = qq|
<VirtualHost *:80>
        ServerName $subdomain
        ServerAlias www.$domain $domain
        ServerAdmin webmodulesuk\@gmail.com
        DocumentRoot $srvrootDir/www
        <Directory $srvrootDir/www/>
                AllowOverride None
                Options MultiViews Indexes
                Order allow,deny
                allow from all
                Require all granted
                DirectoryIndex index.html
        </Directory>

        ScriptAlias /bin/ /srv/ath/src/perl/www/

        php_admin_value open_basedir /tmp:$srvrootDir:/srv/ath

		DirectoryIndex home

    <Directory /srv/ath/src/perl/www/>
                AllowOverride None
                Options +ExecCGI -MultiViews +SymLinksIfOwnerMatch
                Order allow,deny
                Allow from all
                Require all granted
    </Directory>

	Alias /pub/ /srv/ath/src/pub/
        <Directory /srv/ath/src/pub/>
                AllowOverride None
                Order allow,deny
                Allow from all
                Require all granted
        </Directory>
#        RewriteEngine On
#        RewriteCond %{HTTPS} off
#        RewriteRule (.*) https://%{SERVER_NAME}\$1 [R,L]

		ErrorLog \${APACHE_LOG_DIR}/error.log
		CustomLog \${APACHE_LOG_DIR}/access.log vhost_combined
</VirtualHost>
<VirtualHost *:443>
        ServerName $subdomain
        ServerAlias www.$domain $domain
        ServerAdmin webmodulesuk\@gmail.com
                DocumentRoot $srvrootDir/www

        <Directory $srvrootDir/www/>
                AllowOverride None
                Options MultiViews Indexes
                Order allow,deny
                allow from all
                Require all granted
                DirectoryIndex index.html
        </Directory>

        ScriptAlias /bin/ /srv/ath/src/perl/www/

        php_admin_value open_basedir /tmp:$srvrootDir:/srv/ath

		DirectoryIndex home

    <Directory /srv/ath/src/perl/www/>
                AllowOverride None
                Options +ExecCGI -MultiViews +SymLinksIfOwnerMatch
                Order allow,deny
                Allow from all
                Require all granted
    </Directory>

	Alias /pub/ /srv/ath/src/pub/
        <Directory /srv/ath/src/pub/>
                AllowOverride None
                Order allow,deny
                Allow from all
                Require all granted
        </Directory>

        SSLEngine on
        SSLCertificateFile "/etc/letsencrypt/live/$sitesid.athena.systems/cert.pem"
        SSLCertificateKeyFile "/etc/letsencrypt/live/$sitesid.athena.systems/privkey.pem"
        SSLCertificateChainFile "/etc/letsencrypt/live/$sitesid.athena.systems/chain.pem"

	ErrorLog \${APACHE_LOG_DIR}/error.log
	CustomLog \${APACHE_LOG_DIR}/access.log vhost_combined
</VirtualHost>
|;
	my $confFile = $srvrootDir . '/etc/httpd/' . $domain . '.conf';

	#print "Writing out the Apache Conf to $confFile\n";

	if ($live) {
		open( FHOUT2, ">$confFile" ) || die;
		print FHOUT2 $apacheConf;
		close FHOUT2;
	}

}

sub reloadApache {
	#print "Reloading Apache2\n";
	if ($live) {
		system("service apache2 reload >> /srv/ath/var/log/apache2");
	}
}

sub addToDNS {

	my $sitesid = shift;

	my $dig = `dig $sitesid.athena.systems|grep ^$sitesid.athena.systems`;
	if ( $dig =~ /\d+\.\d+\.\d+\.\d+/ ) {
		print "$sitesid.athena.systems already in DNS ...\n";
		return;
	}

	my $tld = 'athena.systems';
	my $ip  = '';
	if ( Athena::isDev() ) {
		$ip = '192.168.0.100';
	} else {
		$ip = getHostByName(getHostName());
	}
	my $endip = $ip;
	$endip =~ s/^.*\.(\d+)$/$1/;
	my $subip = $ip;
	$subip =~ s/^(\d+)\..*$/$1/;

	my $t = time();
	system("cp /etc/bind/db.$tld /root/$t.db.$tld");
	system("cp /etc/bind/db.$subip /root/$t.db.$subip");

	print "Adding DNS records - $subdomain\n";

	# Forward
	my $conf = '';
	open( FH, "</etc/bind/db.$tld" );
	while (<FH>) {
		if (/; Serial/) {
			$conf .= "\t\t" . time() . "\t	; Serial\n";
		} else {
			$conf .= $_;
		}
	}
	close(FH);
	$conf .= "$sitesid	IN	A   $ip\n\n";
	open( FH, ">/etc/bind/db.$tld" );
	print FH $conf;
	close(FH);

	# Reverse
	$conf = '';
	open( FH, "</etc/bind/db.$subip" );
	while (<FH>) {
		if (/; Serial/) {
			$conf .= "\t\t" . time() . "\t	; Serial\n";
		} else {
			$conf .= $_;
		}
	}
	close(FH);
	$conf .= "$endip	IN	PTR     $sitesid.$tld.\n\n";
	open( FH, ">/etc/bind/db.$subip" );
	print FH $conf;
	close(FH);

	system("sudo /etc/init.d/bind9 restart");

}

sub makeWebSite {
	my $cmd = "perl /srv/ath/src/perl/cron/build.web.pages.pl $sitesid >> /srv/ath/var/log/build.web.pages.pl";
	#print $cmd;
	system($cmd);
}

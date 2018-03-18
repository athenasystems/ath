#!/usr/bin/perl

use strict;
use CGI;
my $form = new CGI;
my %fds = map { $_ => scalar $form->param($_) } $form->param;
use DBI;
use LWP::UserAgent;

use lib qw(/srv/ath/src/perl/lib);
use Athena;

my $hostdom = $Athena::domain;

my $sitesid = $ENV{HTTP_HOST};    #Athena::reveal( $fds{'sid'} );
$sitesid =~ s/(\d+).*$/$1/;
my $passurl = ( defined( $fds{'purl'} ) ) ? $fds{'purl'} : '';

my $dbh = &Athena::dbsiteconnect($sitesid);

my $site     = '';
my $loginURL = '';
my $sql =
  "SELECT staffid,custid,suppid,usr,seclev,lastlogin FROM pwd WHERE usr=? LIMIT 1";

#print $sqltext;
my $cursor = $dbh->prepare($sql);
my $rtn    = $cursor->execute( $fds{'nick'} );

my @row = $cursor->fetchrow_array;

if (   ( defined( $row[4] ) )
	&& ( $row[4] == 1 )
	&& ( !defined( $fds{'as_staff'} ) ) )
{    # Admin log in
	$site = 'mng';
} elsif ( defined( $row[0] ) && ( $row[0] > 0 ) ) {    # Staff log in
	$site = 'staff';
} elsif ( defined( $row[1] ) && ( $row[1] > 0 ) ) {    # Customer log in
	$site = 'customers';
} elsif ( defined( $row[2] ) && ( $row[2] > 0 ) ) {    # Supplier log in
	$site = 'suppliers';
}

my $firstlogin = '';
if(!$row[5]){
	$firstlogin ='<input type="hidden" name="fl" value="1">';
}

my $JS = "document.forms[0].submit()";
#
if ( $site eq '' ) {
	print $form->redirect("https://$sitesid.$hostdom/login?pf=y&w=NoUsr");
} else {

	my $loginURL = 'https://' . $site . '.' . $hostdom . '/pass.php';

	my $str =
	  $fds{'nick'} . "\t" . $fds{'pw'} . "\t" . $sitesid . "\t" . $passurl;

	my $token = `/usr/bin/php /srv/ath/src/php/signup/mkcrypt.php "$str"`;

	print $form->header();
	print $form->start_html( -onLoad => $JS );
	print <<ENDofHTML;
<form action="$loginURL" method="post">
<input type="hidden" name="t" value="$token">
$firstlogin
</form>
ENDofHTML
	print $form->end_html();

}

exit;

#!/usr/bin/perl
use strict;
use WWW::Mechanize;
use DBI;
use lib('/srv/ath/src/perl/lib/');
use Athena;
use lib('/srv/ath/adm/t/lib/');
use AthenaTest;
use DevTest;
use DevOwner;
use DevCust;
use DevSupp;

my $user = $>;
if ($user) { print "\nGotta be root! Not " . $user . "\n"; exit; }

print "Installing apt-get stuff Athena might need ...\n";
my $string = '';
open FILE, "/srv/ath/adm/build/apt"
  or die "Couldn't open file: $!";
while (<FILE>) {
	chomp;
	$string .= $_ . ' ';
}
close FILE;

my $cmd = "apt-get -y install $string";
system($cmd);

print "Installing cpanp stuff Athena might need ...\n";
$string = '';
open FILE, "/srv/ath/adm/build/cpanp"
  or die "Couldn't open file: $!";
while (<FILE>) {
	chomp;
	$string .= $_ . ' ';
}
close FILE;
$cmd = "cpanp -i $string";

system($cmd);

print "Enable Apache Modules\n";
system('a2enmod ssl');
system('a2enmod rewrite');
system('service apache2 restart');

system(
	'cat >/etc/apache2/sites-available/athena <<EOF 
Include /srv/ath/etc/httpd/dev/*.conf 
EOF
'
);

system('a2ensite /etc/apache2/sites-available/athena');
system('service apache2 restart');

system('');

print "Enter Mysql root password";
my $mysqlpwd = <>;
chomp($mysqlpwd);

print "\nPWD is $mysqlpwd\n";
AthenaTest::setrootDBPass($mysqlpwd);

#
# Clear Sys Database
#
print "Clearing and Remaking the Sys DB ...\n";
if ( !DevTest::db_init ) {
	print "Couldn't clear and remake Sys DB\n";
}

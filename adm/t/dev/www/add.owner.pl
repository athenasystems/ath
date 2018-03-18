#!/usr/bin/perl
use strict;
use WWW::Mechanize;
use DBI;
use lib('/srv/ath/adm/t/lib/');
use AthenaTest;

my $dbh = shift;
my $co_name = shift;

print "\n#### Adding a New Athena Site;\n";
print "\n#### Adding owner;\n";

my ( $webhost, $inthost, $custhost, $supphost , $admhost ) = Athena::getHostName();
my ( $strName, $city, $county, $country, $postcode ) = AthenaTest::getAddress;

# form details
my $tel     = AthenaTest::getPhoneNumber;
my $email   = 'wmodtest@gmail.com';

my $mech    = WWW::Mechanize->new();
my $uri = $webhost . '/signup';
print "$uri ...............\n";
$mech->get($uri);

# field details

my %fields = (
	co_name   => $co_name,
	tel       => $tel,
	email     => $email
);

$mech->submit_form( with_fields => \%fields );

exit;




#my $HTML =  $mech->content();
#print $HTML;
#my $add1    = $strName;
#my $add2    = '';
#my $add3    = '';
#
#my $co_nick = $co_name;
#my $fax     = AthenaTest::getPhoneNumber;
#my $vat_no  = AthenaTest::getPhoneNumber;
#my $web     = 'www.athena.systems';

#
#my $co_no   = AthenaTest::getPhoneNumber;
#my $gmail   = 'wmoduk@gmail.com';
#my $emailpw = 'm0dpr0fit909';
#$co_nick =~ s/\s.*$//;


#	co_nick   => $co_nick,
#	add1      => $add1,
#	add2      => $add2,
#	add3      => $add3,
#	city      => $city,
#	county    => $county,
#	country   => $country,
#	postcode  => $postcode,
#	fax       => $fax,
#	gmail     => $gmail,
#	emailpw   => $emailpw,
#	vat_no    => $vat_no,
#	co_no     => $co_no,
#	web       => $web
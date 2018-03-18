#!/usr/bin/perl

use strict;
use DBI;
use WWW::Mechanize;

use lib('/srv/ath/src/perl/lib/');
use Athena;

#
# db details
#

print "Connecting to DB ...\n";

my $dbh = Athena::dbsiteconnect();

#
# Get Mechanize Handle
#
my $mech = WWW::Mechanize->new();
#my $sitesid = 100;

my ( $webhost, $inthost, $custhost, $supphost, $admhost, $staffhost ) = Athena::getHostName();

my $statement = "SELECT contactsid FROM contacts ORDER BY RAND() LIMIT 1";
my ($contactsid) = $dbh->selectrow_array($statement);

my $statement = "SELECT logon,init_pw,custid,suppid FROM contacts WHERE contactsid=$contactsid ORDER BY contactsid LIMIT 1";
my ( $nick, $pw ,$custid,$suppid) = $dbh->selectrow_array($statement);

# form details
#my $nick = 'AA100';
#my $pw   = '34f8DRPY6xkK';

my $uri = $webhost . '/login/';
print "$uri - $nick, $pw ,$custid,$suppid\n";
$mech->get($uri);

# field details
my %fields = (
	nick => $nick,
	pw   => $pw
);

$mech->submit_form( with_fields => \%fields );

print "Got to " . $mech->uri();

print "\n\n";

$mech->submit_form();

print "Got to " . $mech->uri();

$mech->content();

print "\n\n";

exit;

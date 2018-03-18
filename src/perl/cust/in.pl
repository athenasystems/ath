#!/usr/bin/perl

use strict;
use POSIX qw(strftime);
use DBI;
use CGI;
use lib qw(/srv/ath/src/perl/lib);
use Athena;
print CGI::header();

if(Athena::chkCookie){
	print "yes";
}



#
#
#
#use MIME::Base64;
#use Crypt::MCrypt;
#use CGI::Cookie;
#
#print CGI::header();
#
#my %cookies     = CGI::Cookie->fetch;
#my $cipher_text = $cookies{'ATHENA'}->value;
#
#my $key       = "gg65RxmMmJjk9Io0OhR4eDtY";    # 24 bit Key
#my $iv        = "fYfhHeDm";                    # 8 bit IV
#my $bit_check = 8;                             # bit amount for diff algor.
#
#my $algorithm = "tripledes";
#my $mode      = "cbc";
#my $obj       = Crypt::MCrypt->new(
#	algorithm => $algorithm,
#	mode      => $mode,
#	key       => $key,
#	iv        => $iv,
#);
#
#my $plain_text = $obj->decrypt( decode_base64($cipher_text) );
#my ($sitesid,$usrid,$usr,$pwd,$now) = split(/\./,$plain_text);
#
#my $dbhsite = Athena::dbsiteconnect($sitesid);
#my $sql = "SELECT staffid,custid,suppid,contactsid,pw FROM athdb$sitesid.pwd WHERE usr='$usr'";
#my ($staffid,$custid,$suppid,$contactsid,$pw) = $dbhsite->selectrow_array($sql);
#
#if (crypt($pw, $pwd) == $pwd){
#	print "1";
#}
#	
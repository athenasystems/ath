#!/usr/bin/perl

use strict;
use CGI;
my $form = new CGI;
my %fds = map { $_ => scalar $form->param($_) } $form->param;
use DBI;

use lib qw(/srv/ath/src/perl/lib);
use Athena;

my $hostdom = $Athena::domain;

my $sitesid = $ENV{HTTP_HOST};
$sitesid =~ s/(\d+).*$/$1/;

my $dbh = &Athena::dbsiteconnect($sitesid);

my $sql =
  "INSERT INTO rfq (content,fname,sname,email,tel,incept) VALUES (?,?,?,?,?,?)";
my $cursor = $dbh->prepare($sql);
my $rtn    = $cursor->execute(
	$fds{'content'}, $fds{'fname'}, $fds{'sname'},
	$fds{'email'},   $fds{'tel'},   time()
);











print $form->redirect("https://$sitesid.$hostdom/reset?quote");

exit;

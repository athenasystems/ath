#!/usr/bin/perl

use strict;


use CGI;
my $form = new CGI;
my %fds = map { $_ => scalar $form->param($_) } $form->param;

my $sitesid = $ENV{HTTP_HOST};
$sitesid =~ s/(\d+).*$/$1/;

use LWP::UserAgent;

my $ua  = LWP::UserAgent->new;


print "Content-type: text/html\n\n";

my $response= $ua->post('https://'.$sitesid.'.athena.systems/bin/pass.pl',
	[ 'nick' => $fds{'nick'}, 'pw' => $fds{'pw'} ]);
	
	if ($response->is_success) {
     print $response->decoded_content;  # or whatever
 }
 else {
     die $response->status_line;
 }
exit;

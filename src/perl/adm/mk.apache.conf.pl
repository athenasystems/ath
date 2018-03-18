#!/usr/bin/perl
use strict;

use DBI;
use lib('/srv/ath/src/perl/lib/');
use Athena;

my $domain = shift;

my $subdom = shift;


my $conf='';


open(APIN,"</srv/ath/src/php/tmpl/owner_apache2.conf");
while(<APIN>){
	$conf.= $_;
}
close(APIN);

$conf =~ s/DOMAIN/$domain/gs;

$conf =~ s/SUBDOM/$subdom/gs;


open(FH,">/srv/ath/etc/httpd/own/$subdom");
print FH $conf;
close (FH);



exit;


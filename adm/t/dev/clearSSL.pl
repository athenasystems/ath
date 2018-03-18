#!/usr/bin/perl
use strict;

for (my $i = 100; $i < 1000; $i++) {

	if (-e "/etc/letsencrypt/live/$i.athena.systems"){
		print "Clearing $i.athena.systems"
	}

}

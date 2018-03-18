#!/usr/bin/perl
use strict;

system("chown -R pl:pl /srv/ath");
system("chmod -R 755 /srv/ath");


system("chown www-data /srv/ath/etc/admins");
system("chown www-data /srv/ath/etc/custs");
system("chown www-data /srv/ath/etc/supps");
system("chown www-data /srv/ath/etc/users");

system("chown -R www-data /srv/ath/var/data");
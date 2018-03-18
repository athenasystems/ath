#!/usr/bin/perl
# perl -c /srv/ath/root/up2dev.pl
use strict;
use Expect;
system("clear");

my $srcIP = 'athena.systems';
my $pw = `cat /etc/wmpw`;
my $usr='root';
my $dryrun = shift;

my @parms = ();
if ( ( defined($dryrun) ) && ( $dryrun == 'go' ) ) {
	push( @parms, "-rltDvh" );
}
else {
	push( @parms, "-rltDvnh" );
}

push( @parms, "-e ssh" );
push( @parms, "--stats" );
push( @parms, "--include-from=/srv/ath/adm/down/include" );
push( @parms, "--exclude-from=/srv/ath/adm/down/exclude" );
push(@parms,"--delete");

push( @parms, "$usr\@$srcIP:/srv/ath" );
push( @parms, '/srv' );
my $command = "rsync";

my $prms = join " ", @parms;

print "\nDoing:\n$command $prms\n";

my $exp = Expect->spawn( $command, @parms ) or die "Cannot spawn ssh: $!\n";
#$exp->log_file( "./.log.txt", "w+" );

$exp->expect(
	undef,
	[
		qr/'s password:/ =>
		  sub { my $exp = shift; $exp->send("$pw\n"); exp_continue; }
	],
	[
		qr/want to continue connecting/ =>
		  sub { my $exp = shift; $exp->send("yes\n"); exp_continue; }
	],
);

exit;


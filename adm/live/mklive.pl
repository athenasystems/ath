#!/usr/bin/perl
use strict;
use Expect;
system("clear");
my $dryrun = shift;
my $zip = shift;
my @parms  = ();

my $destIP = 'sc21.co';
my $pw = `cat /etc/wmpw`;
my $usr='root';

if ( ( defined($dryrun) ) && ( $dryrun eq 'go' ) ) {
	push( @parms, "-rltDvh" );
}else {
	push( @parms, "-rltDvnh" );
}
push( @parms, "-e ssh" );
push( @parms, "--stats" );
push( @parms, "--include-from=/srv/ath/adm/live/r_include" );
push( @parms, "--exclude-from=/srv/ath/adm/live/r_exclude" );
push( @parms, "--delete" );
push( @parms, '/srv/ath' );
push( @parms, $usr . '@' . $destIP . ':/srv/' );
my $command = "rsync";
my $prms = join " ", @parms;

print "\nDoing:\n$command $prms\n";
my $exp = Expect->spawn( $command, @parms ) or die "Cannot spawn ssh: $!\n";

$exp->expect(
	undef,
	[ qr/'s password:/                => sub { my $exp = shift; $exp->send("$pw\n"); exp_continue; } ],
	[ qr/want to continue connecting/ => sub { my $exp = shift; $exp->send("yes\n"); exp_continue; } ],
);

if ( ( defined($zip) ) && ( $zip eq 'zip' ) ) {
	my $filename = '/home/pjl/Documents/AthenaDev.' . time() . '.tar.gz';
	system("tar -czf $filename /srv/ath");
}

exit;

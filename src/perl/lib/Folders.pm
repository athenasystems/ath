package Folders;

use strict;

sub mkJobsFolders() {

	my $id = shift;
	my $type = substr( $id, 0, 1 );
	my $prefixyr = substr( $id, 1, 2 );

	my $path = '/root/jobs/J' . $prefixyr . '/' . $id;

	&makeFolder($path);
	&makeFolder( $path . '/cnc-data' );
	&makeFolder( $path . '/models' );
	&makeFolder( $path . '/other_info' );
	&makeFolder( $path . '/quote' );
	&makeFolder( $path . '/files' );

	system("chown -R tt:tt $path");

}

sub mkQuotesFolder() {

	my $id = shift;
	my $type = substr( $id, 0, 1 );
	my $prefixyr = substr( $id, 1, 2 );
	
	my $path = '/root/quotes/Q' . $prefixyr . '/' . $id;

	&makeFolder($path);

	system("chown -R tt:tt $path");

}

sub makeFolder() {
	my $p = shift;
	unless ( -d $p ) {
		mkdir( $p, 0777 );
	}
}

1;


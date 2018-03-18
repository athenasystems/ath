#!/usr/bin/perl -w
use strict;
use POSIX qw(strftime);
use DBI;
use lib qw(/srv/ath/src/perl/lib);
use Athena;

my $dbhsys = &Athena::dbrootconnect();

my $sql = "SELECT * FROM athcore.sites WHERE status='new' LIMIT 1";
my $sth = $dbhsys->prepare($sql);
$sth->execute();
my $rows = $sth->rows;

if ($rows) {

	my $row = $sth->fetchrow_hashref;
	my %r   = %{$row};

	my $sitesid = $r{'sitesid'};
	my $subdom  = $r{'subdom'};
	my $domain  = $r{'domain'};
	my $filestr = $r{'filestr'};
	#my $filestr= substr($rndfilestr,0,1).'/'.substr($rndfilestr,1,1).'/'.$rndfilestr;
	#print "Processing SitesID:$sitesid\n";

	my $tmpSqlFile = "/tmp/$sitesid.init.athena.client.sql";
	
	# Get the generic new site SQL
	my $sqlText = '';
	open( FH, "</srv/ath/src/sql/athsite.sql" );
	while (<FH>) {
		$sqlText .= $_;
	}
	close(FH);

	my $newDBName = 'athdb' . $sitesid;
	$sqlText =~ s/ATHENADB/$newDBName/gs;

	# Write out the new sites SQL
	open( FHO, ">$tmpSqlFile" );
	print FHO $sqlText;
	close(FHO);

	# Import the new site SQL into the DB
	my $dbpwd = Athena::getrootDBPass();
	system("mysql -uroot -p$dbpwd < $tmpSqlFile");

	# Set the site as Active
	my $sqlUpdate = "UPDATE athcore.sites SET status='active' WHERE sitesid=?";
	my $sthUpdate = $dbhsys->prepare($sqlUpdate);
	$sthUpdate->execute($sitesid);

	#my @mods = (0,  1,  2,  3,  4,  5,  6,  7,  8, 9, 11,
	# 12, 13, 14, 15, 17, 18, 19, 20, 21, 22, 24 );,1,2,3,10,13
	
	my @mods = (0,3,8,10,12,13,16);

	my $sqlmods = "INSERT INTO athcore.mods (sitesid,modulesid) VALUES (?,?)";
	my $cursormods = $dbhsys->prepare($sqlmods);
	foreach my $modid (@mods) {
		  my $rtn = $cursormods->execute( $sitesid, $modid );
	}

	# Make the Data Folder
	my $dDir = "/srv/ath/var/data/$filestr";
	#system("mkdir -p $dDir/$filestr");
	system("mkdir -p $dDir/chat");
	system("mkdir -p $dDir/pdf/quotes/");
	system("mkdir $dDir/pdf/invoices/");
	system("mkdir $dDir/pdf/delivery/");
	system("chown -R www-data $dDir");
	
	open( FH, ">>$dDir/chat/chat" );
	close(FH);
	open( FH, ">>$dDir/chat/staff" );
	close(FH);
	open( FH, ">>$dDir/chat/web" );
	close(FH);
	
	open( FH, ">>$dDir/qno" );
	print FH '1';
	close(FH);
	
	open( FH, ">>$dDir/ino" );
	print FH '1';
	close(FH);
	
	system("chown -R www-data $dDir");
	
	# Do the GRANT statements in MySQL
	my $dbname  = 'athdb' . $sitesid;
	my $dbadmin = 'athena' . $sitesid;
	#print "Doing the GRANTS for $dbname\n";
	my $pw = Athena::generatePwd(12);

	my $usr = "athena$sitesid\t$pw\n";
	open( FH, ">>/srv/ath/etc/users" );
	print FH $usr;
	close(FH);

	my $sqlGrant =
	  "GRANT ALL ON $dbname.* TO `$dbadmin`@`localhost` IDENTIFIED BY '$pw';";
	#print $sqlGrant . "\n";
	my $sthGrant = $dbhsys->prepare($sqlGrant);
	$sthGrant->execute();

	my $sqlGrant2 =
	  "GRANT ALL ON athcore.* TO `$dbadmin`@`localhost` IDENTIFIED BY '$pw';";
	#print $sqlGrant2 . "\n";
	my $sthGrant2 = $dbhsys->prepare($sqlGrant2);
	$sthGrant->execute();

	my $admpw = Athena::getDBPass();
	$sqlGrant =
	  "GRANT ALL ON $dbname.* TO `athena`@`localhost` IDENTIFIED BY '$admpw';";
	#print $sqlGrant . "\n";
	$sthGrant = $dbhsys->prepare($sqlGrant);
	$sthGrant->execute();

	$sqlGrant = "FLUSH PRIVILEGES;";
	$sthGrant = $dbhsys->prepare($sqlGrant);
	$sthGrant->execute();

}

exit;


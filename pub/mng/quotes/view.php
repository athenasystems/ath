<?php
$section = "quotes";
$page = "Quotes";

include "/srv/ath/src/php/mng/common.php";

$errors = array ();

if ((isset ( $_GET ['go'] ) && ($_GET ['go'] == 'delfile')) && (isset ( $_GET ['fn'] ) && ($_GET ['fn'] != ''))) {
	unlink ( $custFileStore . '/' . base64_decode ( $_GET ['fn'] ) );
}

$pagetitle = "View Quote";
$pagescript = array ();
$pagestyle = array ();

include "/srv/ath/pub/mng/tmpl/header.php";
include "helptab.php";


if (! isset ( $siteMods ['quotes'] )) {
	?>
<h2>This Athena Module has not been activated</h2>
<?php
include "/srv/ath/pub/mng/tmpl/footer.php";
exit ();
}

$sqltext = "SELECT quotes.quotesid, quotes.staffid, quotes.custid,
quotes.contactsid, quotes.quoteno, quotes.incept, quotes.origin, quotes.agree, quotes.live, quotes.content,
quotes.notes,quotes.sent,
cust.fname, cust.sname, cust.co_name, cust.contact, cust.addsid, cust.inv_email, cust.inv_contact
FROM quotes,cust
WHERE quotes.custid=cust.custid
AND quotes.quotesid='" . addslashes ( $_GET ['id'] ) . "'
AND quotesid>0";

$res = $dbsite->query ( $sqltext ) ;#or die ( "Cant get quotes" );
if ( empty($res)) {
	header ( "Location: /quotes/" );
	exit ();
}
$r = $res[0];
$custFileStore = '/srv/ath/var/files/cust/' . $r->filestr;

$sent = $r->sent;

$r->content = preg_replace ( "/\r\n/", "<br>", $r->content );

if (isset ( $r->staffid ) && is_numeric ( $r->staffid )) {
	$int_contact = getStaffName ( $r->staffid );
}
if (isset ( $r->contactsid ) && is_numeric ( $r->contactsid )) {
	$ext_contact = getCustExtName ( $r->contactsid );
}
$qno = $r->quoteno;

$murl = base64_encode ( "/mail/quote.php?id=" . $_GET ['id'] );

$purl = base64_encode ( '/quotes/view?id=' . $r->quotesid );

if (isset ( $_GET ['nf'] ) && ($_GET ['nf'] == 'y')) {
	?>
<div style="display: block;">
	<span id=help>Your file has been uploaded and is available below.
		Athena has sent an email to <?php echo getCustName($r->custid);?> to
		let them know.
	</span>
</div>
<br>
<?php
}

?>

<span id=pageactions> <span style="font-size: 90%; color: #999;">For
		this Quote:- </span> <i class="fa fa-pencil-square-o"></i> <a
	href="/quotes/edit?id=<?php echo $r->quotesid;?>">Edit</a> | <i
	class="fa fa-file-pdf-o"></i> <a
	href="/bin/make_pdf_quote.pl?id=<?php echo $r->quotesid;?>&sitesid=<?php echo $sitesid;?>"
	title="Download PDF">Download PDF</a> <?php if(isset($siteMods['custport'])){ ?>
	| <a
	href="/loginas?cid=<?php echo $r->custid; ?>&sitesid=<?php echo $sitesid;?>&passurl=<?php echo $purl;?>"
	target="_blank" title="Log In As this Customer">Customer's View</a> <?php } ?>
	<?php
	$retHTML = '';
	if($sent>0){
		$sent = 'Sent '.date('H:i d/m/Y',$sent);
		$retHTML .= '| <i class="fa fa-envelope" title="'.$sent.'"></i>';
	}else{
		$sent = '';
		$retHTML .= '| <i class="fa fa-envelope-o" title="Not sent yet"></i>';
	}
	echo $retHTML;
	?>

	<form action="/mail/send_owl" method="post"
		enctype="multipart/form-data" style="display: inline;"
		name="emailtocust">
		<a href="javascript:void(0);" onclick="parentNode.submit();">Email
			to Customer
		</a> <input type="hidden" name=url value="<?php echo $murl; ?>">
	</form>


</span>


<h1>
	Quote No:
	<?php echo $r->quoteno; ?>
	for
	<?php echo $r->co_name; ?>

</h1>

<?php
if(isset($siteMods['custport'])){
	if ($r->live) {
		$status = '<span style="color:green">This Quote is Live</span>';
	} else {
		$status = '<span style="color:brown">This Quote is not Live</span>';
	}
	tablerow ( "Quote Status", '<a href="/quotes/status?id=' . $r->quotesid . '" title="Click to change Quote Status">' . $status . '</a>' );
}

tablerow ( "Date", date("d/m/Y",$r->incept) );
#tablerow ( "Internal Contact", $int_contact );
#tablerow ( "External Contact", $ext_contact );
#tablerow ( "Quote Description", stripslashes ( $r->content ) );
#tablerow ( "Notes", stripslashes ( $r->notes ) );
?>

<style>
#tabcell {
	padding: 9px;
	margin: 3px;
	text-align: center;
	border: 1px solid #ddd;
}
</style>
<form
	action="/invoices/add?id=<?php echo $r->custid; ?>&qid=<?php echo $_GET['id']?>"
	enctype="multipart/form-data" method="post" id=searchform>
	<table style="">

		<tr
			style="vertical-align: top; padding: 4px; margin: 3px; border: solid 1px #aaa; font-size: 80%; color: #333;">
			<td id=tabcell><strong>Description of Item</strong></td>
			<td id=tabcell><strong>Quantity</strong></td>
			<td id=tabcell><strong>Unit Price</strong></td>
			<td id=tabcell><strong>Total Price</strong></td>
			<?php
			if(isset($siteMods['jobs0'])){
				?>
			<td id=tabcell>Status</td>

			<?php
			}
			?>
			<td id=tabcell></td>
		</tr>

		<?php
		$quoteTotal = 0;

		$sqltext = "SELECT * FROM qitems WHERE quotesid='" . $r->quotesid . "'";
		$res2 = $dbsite->query ( $sqltext ) ;#or die ( "Cant get quotes" );
		if (! empty($res2)) {
			foreach($res2 as $r2) {

				?>
		<tr
			style="vertical-align: top; padding: 4px; margin: 3px; border: solid 1px #aaa;">
			<td id=tabcell style="text-align: left;"><?php echo $r2->content; ?>
			</td>

			<?php
			if((isset($r2->hours)) && ($r2->hours>0)){
				?>


			<td id=tabcell><?php echo $r2->hours; ?> Hours</td>
			<td id=tabcell>&pound;<?php echo $r2->rate; ?>
			</td>
			<?php
			$itemTotal = $r2->hours * $r2->rate;
			}else{
				?>

			<td id=tabcell><?php echo $r2->quantity; ?></td>
			<td id=tabcell>&pound;<?php echo $r2->price; ?>
			</td>

			<?php
			$itemTotal = $r2->price * $r2->quantity;
			}
			?>

			<?php

			?>
			<td id=tabcell>&pound;<?php echo $itemTotal?>
			</td>

			<?php

			if(isset($siteMods['jobs0'])){
				$sqltextJobs = "SELECT * FROM jobs WHERE itemsid='" . $r2->qitemsid . "'";
				$res3 = $dbsite->query ( $sqltextJobs );# or die ( "Cant get Jobs" );
				$r3 = $res3[0];

				if ($r3->itemsid == '') {
					?>
			<td id=tabcell nowrap><a
				href="/jobs/add.php?id=<?php echo $r2->qitemsid; ?>"
				class="btn btn-primary btn-xs">Quote Agreed</a></td>
			<?php
				} else {
					?>
			<td id=tabcell><a href="/jobs/view.php?id=<?php echo $r3->jobsid; ?>">Job
					No: <?php echo $r3->jobno; ?>
			</a><br> <br> <a
				href="/jobs/add.php?id=<?php echo $r2->qitemsid; ?>&qid=<?php echo $_GET ['id']?>"
				style="font-size: 70%;">Create another Job from this quote</a></td>
			<?php
				}
			}

			?>

			<td id=tabcell><input type="checkbox" checked=checked
				name="qitemsid[]" class="c-input c-checkbox"
				value="<?php echo $r2->qitemsid; ?>">
			</td>
		</tr>
		<?php
		$quoteTotal = $quoteTotal + $itemTotal;
			}
		}

		?>
		<tr>
			<td id=tabcell></td>
			<td id=tabcell></td>
			<td id=tabcell>Quote Total</td>
			<td id=tabcell>&pound;<?php echo $quoteTotal; ?>
			</td>
			<?php
			if(isset($siteMods['jobs0'])){
				?>
			<td id=tabcell></td>

			<?php
			}
			?>
			<td id=tabcell><input type="submit" value="Invoice selected"></td>
		</tr>

	</table>

</form>

<br clear=all>

<br>
<br>

<script>
<!--
function confirmSubmit()
{
var agree=confirm("Are you sure you wish to delete this file?");
if (agree)
	return true ;
else
	return false ;
}
// -->
</script>

<?php
include "/srv/ath/pub/mng/tmpl/footer.php";
?>

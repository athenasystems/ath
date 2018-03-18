<?php 
$siteModIDs = getSiteModIDs();
?>

<span id=pageactions> <span style="font-size: 90%; color: #999;">Contact
		Links :- </span> <?php 
		if(in_array(17, $siteModIDs)){
			?> <a href="/staff/" title="">Your Staff</a> | <?php
		}
		?> <?php
		if(in_array(13, $siteModIDs)){
			?> <a href="/customers/" title="">Your Customers</a> | <?php
		}
		?> <?php
		if(in_array(14, $siteModIDs)){
			?> <a href="/suppliers/" title="">Your Suppliers</a> | <?php
		}
		?> <?php
		if(in_array(15, $siteModIDs)){
			?> <a href="/contacts/" title="">Contacts</a><?php
		}
?>


</span>

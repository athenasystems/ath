<?php

include "/srv/ath/src/php/mng/common.php";

header("Cache-Control: no-cache");

$id = $_GET['q'];

$html = '';

	$sqltext = "SELECT * FROM items ORDER BY itemsid DESC";
	$res = $dbsite->query($sqltext); # or die("Cant get customers");
	#print $sqltext;

	if (! empty($res)) {
		foreach($res as $r) {

			$html .= <<< EOF
<div class="form-group row">

        <div class="col-md-10">
<label for="itemsid{$r->itemsid}" class="col-sm-2 form-control-label">Item No {$r->itemsid}
</label>

<input class="auto clickable" type="checkbox" name="itemsid[]"
value="{$r->itemsid}" id="itemsid{$r->itemsid}" $checked>
			{$r->content} &pound;{$r->price}

      </div>
        <div class="col-md-2">
<input name="itemsid{$r->itemsid}quantity" id="itemsid{$r->itemsid}quantity"
value="1" class=" form-control" placeholder="Quantity *" type="text" style="width:40px;">
        </div>

</div>
EOF;

		}
	}else {
		$html .= html_hidden('itemsid', $r->itemsid);
	}

print $html;

?>

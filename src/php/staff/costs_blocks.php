<?php
function getCostMiniRowHTML($r){
	global $seclevel;

	$startDate 		= date('d-m-Y',$r->incept);
	$cost_itemsid 	= $r->cost_itemsid;
	$suppName 		= getSuppName($r->suppid);
	$costsid 		= $r->costsid;
	$quantity		= $r->quantity;
	$price 			= $r->price;

	$retHTML = <<<EOF
<li>
<div >
<div style="float:left;width:390px;">
<div style="width:10px;background-color:$colour;float:left;margin-right:5px;">&nbsp;</div>
<a href="/costs/view.php?id=$cost_itemsid" title="Edit this cost">

EOF;

	if($seclevel < 2){
		$retHTML .= <<<EOF
			 <span>$suppName: for £$price </span>
EOF;
	}

	$retHTML .= <<<EOF
	<span> on $startDate</span>
	</div>
EOF;

	if($seclevel < 2){
		$retHTML .= <<<EOF
			<span id=actions>
			<a href="/costs/view.php?id=$cost_itemsid" title="View cost details">View</a> |
			<a href="/costs/edit.php?id=$cost_itemsid" title="Edit this cost">Edit</a>
			</span>
EOF;
	}

	$retHTML .= <<<EOF

<br clear=all>
</div>
</li>

EOF;

	return $retHTML;

}

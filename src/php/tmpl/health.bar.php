<?php
if(in_array($kpiid,$percentMetrics)){
	?>
	<li>
<span style="color: #333;"> <?php echo $metric; ?> - Score: <?php echo $result;?>%</span><div style="width:<?php echo $width; ?>px;height:10px;background-image: url('/img/colourbar.png');">&nbsp;</div>
</li>
<?php
}

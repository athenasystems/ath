<div style="display:<?php echo $display;?>;white-space:nowrap;border:1px solid #eee;padding:8px;padding:12px;background-color:#eee;margin:6px;"
class="" id="itemrow<?php echo $i;?>">

	<h4>
		Quote Item
		<?php echo $j;?>
	</h4>
	<div style="display: inline;" class="<?php echo $valStateContent;?>">
		<div class="form-group row">
			<label for="itemcontent<?php echo $i;?>"
				class="col-sm-2 form-control-label">Description</label>
			<div class="col-sm-10">
				<textarea name="item[<?php echo $i;?>][content]"
					id="itemcontent<?php echo $i;?>"
					class="form-control"><?php echo $itemContent;?></textarea>
			</div>
		</div>
	</div>

<div style="display: inline;" class="<?php echo $valStateQuantity;?>">
		<div class="form-group row">
			<label for="itemquantity<?php echo $i;?>"
				class="col-sm-2 form-control-label">Quantity </label>
			<div class="col-sm-10">
				<input type="text" name="item[<?php echo $i;?>][quantity]"
					id="itemquantity<?php echo $i;?>"
					value="<?php echo $itemQuantity;?>" style="width: 50px;"
					class="form-control">
			</div>
		</div>
	</div>

	<?php echo $morehtml;?>
</div>

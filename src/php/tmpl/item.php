<div style="display:<?php echo $display;?>;white-space:nowrap;border:1px solid #eee;padding:8px;padding:12px;background-color:#eee;margin:6px;"
class="" id="itemrow<?php echo $i;?>">

	<div style="display: inline;" class="<?php echo $valStateContent;?>">

			<?php echo $stockblock; ?>

		<label for="itemcontent<?php echo $i;?>" class="control-label">Item <?php echo $j;?>
			Description
		</label> <input type="text" name="item[<?php echo $i;?>][content]"
			id="itemcontent<?php echo $i;?>" value="<?php echo $itemContent;?>"
			placeholder="Item <?php echo $j;?> Description" class="form-control">
	</div>

	<div style="display: inline;" class="<?php echo $valStateRadio;?>">
		<div class="radio" id="radioBlock<?php echo $i;?>">
			<label class="radio-inline"> <input type="radio"
				name="item[<?php echo $i;?>][swapTo]"
				id="swapToPriceType<?php echo $i;?>" value="price"
				onclick="swapToPriceType(<?php echo $i;?>)" <?php echo $priceChk;?>>
				By Price
			</label> <label class="radio-inline"> <input type="radio"
				name="item[<?php echo $i;?>][swapTo]"
				id="swapToQuantityType<?php echo $i;?>" value="quantity"
				onclick="swapToQuantityType(<?php echo $i;?>)"
				<?php echo $quantityChk;?>>By Quantity
			</label> <label class="radio-inline"> <input type="radio"
				name="item[<?php echo $i;?>][swapTo]"
				id="swapToHoursType<?php echo $i;?>" value="hours"
				onclick="swapToHoursType(<?php echo $i;?>)" <?php echo $hoursChk;?>>
				By Hours
			</label>
		</div>
	</div>


	<div id="priceBlock<?php echo $i;?>" style="display:<?php echo $priceDisplay;?>;"
	class="<?php echo $valStateSinglePrice;?>">

		<label for="itemsingleprice<?php echo $i;?>" class="control-label">
			Item Price </label> <input type="text"
			name="item[<?php echo $i;?>][singleprice]"
			id="itemsingleprice<?php echo $i;?>"
			value="<?php echo $itemSinglePrice;?>" style="width: 100px;"
			onkeyup="invoiceTotal();" onblur="invoiceTotal();"
			placeholder="Price" class="form-control">
	</div>



	<div id=quantityBlock<?php echo $i;?> style="display:<?php echo $quantityDisplay;?>;">

		<div style="display: inline;" class="<?php echo $valStateQuantity;?>">

			<label for="itemquantity<?php echo $i;?>" class="control-label">
				Quantity </label> <input type="text"
				name="item[<?php echo $i;?>][quantity]"
				id="itemquantity<?php echo $i;?>"
				value="<?php echo $itemQuantity;?>" style="width: 100px;"
				onkeyup="updateQLinePrice(<?php echo $i;?>);"
				onblur="updateQLinePrice(<?php echo $i;?>);" placeholder="Quantity"
				class="form-control">
		</div>
		<div style="display: inline;" class="<?php echo $valStatePrice;?>">

			<label for="itemprice<?php echo $i;?>" class="control-label"> Unit
				Price &pound;&nbsp; </label><input type="text"
				name="item[<?php echo $i;?>][price]" id="itemprice<?php echo $i;?>"
				value="<?php echo $itemPrice;?>" style="width: 100px;"
				onkeyup="updateQLinePrice(<?php echo $i;?>);"
				onblur="updateQLinePrice(<?php echo $i;?>);"
				placeholder="Unit Price" class="form-control"> Total &pound; <span
				id="qlinetotal<?php echo $i;?>"></span>
		</div>
	</div>



	<div id=hourlyBlock<?php echo $i;?> style="display:<?php echo $hourlyDisplay;?>;">

		<div style="display: inline;" class="<?php echo $valStateHours;?>">

			<label for="itemhours<?php echo $i;?>" class="control-label"> Hours </label>
			<input type="text" name="item[<?php echo $i;?>][hours]"
				id="itemhours<?php echo $i;?>" value="<?php echo $itemHours;?>"
				style="width: 100px;" onkeyup="updateHLinePrice(<?php echo $i;?>);"
				onblur="updateHLinePrice(<?php echo $i;?>);" placeholder="Hours"
				class="form-control">

		</div>
		<div style="display: inline;" class="<?php echo $valStateRate;?>">


			<label for="itemrate<?php echo $i;?>" class="control-label"> Hourly
				Rate &pound;&nbsp; </label> <input type="text"
				name="item[<?php echo $i;?>][rate]" id="itemrate<?php echo $i;?>"
				value="<?php echo $itemRate;?>" style="width: 100px;"
				onkeyup="updateHLinePrice(<?php echo $i;?>);"
				onblur="updateHLinePrice(<?php echo $i;?>);"
				placeholder="Hourly Rate" class="form-control"> Total &pound; <span
				id="hlinetotal<?php echo $i;?>"></span>
		</div>
	</div>


	<input type="hidden" name="item[<?php echo $i;?>][qitemsid]"
		id="qitemsid<?php echo $i;?>" value="<?php echo $qitemsid;?>"> <input
		type="hidden" name="item[<?php echo $i;?>][itemsid]"
		id="itemsid<?php echo $i;?>" value="<?php echo $itemsid;?>">


	<?php echo $morehtml;?>


</div>


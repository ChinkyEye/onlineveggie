<div class="row">
	<div class="col-md-4">
		<div class="form-group">
			<input type="text" class="form-control input-sm item" id="item_id" placeholder="Item" readonly="readonly" value="{{$rest}}">
			<input type="hidden" name="item_id[]" value="{{$item_id}}">
			<input type="hidden" name="veg_id[]" value="{{$veg_id}}">
			<input type="hidden" name="convert_qty[]" value="{{$convert_qty}}">
		</div>
	</div>
	<div class="col-md-3">
		<div class="input-group">
		<input type="text" class="form-control input-sm" id="quantity_id_{{$num_x}}" name="quantity_name[]" placeholder="Quantity" readonly="readonly" value="{{$quantity}}">
		<input type="hidden" name="unit_id[]" value="{{$unit_id}}">
		<div class="input-group-append">
            <span class="input-group-text">{{$unit}}</span>
        </div>
		</div>
	</div>
	<div class="col-md-2">
		<div class="form-group">
			<input type="text" class="form-control input-sm new_rate" id="new_rate_{{$num_x}}" name="new_rate[]" placeholder="Rate" value="{{$new_rate}}">
		</div>
	</div>
	<div class="col-md-2">
		<div class="form-group">
			<input type="text" class="form-control input-sm total" id="total_id_{{$num_x}}" name="total_name[]" placeholder="Total" readonly="readonly" value="{{$total_items}}">
		</div>
	</div>
	<div class="col-md-1">
		<div class="form-group" id="delete_row">

		</div>
	</div>
</div>
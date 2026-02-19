<div class="row mt-2">
	<div class="offset-md-6 col-md-3 my-auto my-auto">
		<label>Amount: </label>
	</div>
	<div class="col-md-3">
		<input type="text"  class="form-control input-sm total_sum" id="amount" name="total" readonly="readonly" placeholder="Total" value="{{$calc_data['total']}}">
	</div>

	
	<div class="offset-md-6 col-md-3 my-auto">
		<label>Discount: </label>
	</div>
	<div class="col-md-3">
		<input type="text"  class="form-control input-sm" id="discount" name="discount" placeholder="Discount" autocomplete="off" autofocus="true">
	</div>

	<div class="offset-md-6 col-md-3 my-auto">
		<label>Paid: </label>
	</div>
	<div class="col-md-3">
		<input type="text"  class="form-control input-sm" id="paid" name="paid" placeholder="Paid" value="{{$calc_data['total']}}" readonly="true">
	</div>

<!-- 
	<div class="offset-md-6 col-md-3 my-auto">
		<label>Due: </label>
	</div>
	<div class="col-md-3">
		<input type="text"  class="form-control input-sm" id="due" name="due" placeholder="Due">
	</div>
 -->

	<div class="offset-md-6 col-md-3 my-auto">
		<label>Tender:</label>
	</div>
	<div class="col-md-3">
		<input type="text"  class="form-control input-sm" id="grand_total" name="grand_total"  placeholder="Received Amount">
	</div>
	<div class="offset-md-6 col-md-3 my-auto">
		<label>Change:</label>
	</div>
	<div class="col-md-3">
		<input type="text"  class="form-control input-sm" id="back_return" name="back_return"  placeholder="Return Amount" readonly="true">
	</div>

	<div class="offset-md-9 col-md-3 mt-2">
		<div class="text-right save_button container-ptd">
			<button type="submit" class="btn btn-warning btn-sm print" onclick="this.disabled=true;this.value='Sending, please wait...';this.form.submit();"> Save & Print Data   </button>
		</div>
	</div>
</div>
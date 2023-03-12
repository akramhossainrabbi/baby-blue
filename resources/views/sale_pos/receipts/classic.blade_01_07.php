<!-- business information here -->

<div class="row">
	<table>
		<tr>
			<td style="width: 20%;vertical-align: middle;">
				@if(!empty($receipt_details->logo))  
				<img src="{{$receipt_details->logo}}" class="img img-responsive center-block" style="height: 50px; ">
				@endif
				<br>
				
				<!-- Address -->
				<p style=" margin-left: 15px;">
					@if(!empty($receipt_details->address)) 
					{!! $receipt_details->address !!} 
					@endif


					@if(!empty($receipt_details->email))
					<i class="fa fa-envelope" aria-hidden="true"></i>
					{{ $receipt_details->email }}
					@endif 

					@if(!empty($receipt_details->business_contact))
					<i class="fa fa-mobile" aria-hidden="true"></i>
					{{ $receipt_details->business_contact }}
					@endif	 
				</p>
			</td>

			<td style="width: 55%;vertical-align: middle;">
				<center>
					<h3><big>বই</big> সফল হবার <big>মই</big></h3>
					<br>
					@if(!empty($receipt_details->website))
					{{ $receipt_details->website }}
					@endif
				</center>
			</td>
			<td style="width: 25%; vertical-align: middle;"> 
				<center> 
					@php
					$date=date("Y-M-d",strtotime($receipt_details->invoice_date));
					@endphp
					{{$date }}
				</center>
				<!-- Shop & Location Name  -->
				<img class="center-block" src="data:image/png;base64,{{DNS1D::getBarcodePNG($receipt_details->invoice_no, 'C128', 2,30,array(39, 48, 54), false)}}" style="width: 90px; height: 25px;">
				<center><b>Invoice </b> {{$receipt_details->customer_invoice_no}} </center> 
			</td>
		</tr>
	</table>
	<!-- Logo -->
	

	<!-- Header text -->
	

	<!-- business information here -->
	<div   style="background-color: #d2d6de !important;" class="col-xs-12 text-center"> 
		<!-- Invoice  number, Date  -->
		<p style="width: 100% !important;" class="word-wrap">
			<span class="pull-left text-left word-wrap">  
				<!-- customer info -->
				@if(!empty($receipt_details->customer_name))
				<b>{{ $receipt_details->customer_label }} Details </b> 
				@endif   
			</span>

			<span class="pull-right text-left">
				<b>Customer Id: </b> {{$receipt_details->customer_invoice_no}} 
			</span><br> 
		</p>
	</div>
	<!-- business information here -->
	<div class="col-xs-12 text-center"> 
		<!-- Invoice  number, Date  -->
		<p style="width: 100% !important" class="word-wrap">
			<span class="pull-left text-left word-wrap">  
				<!-- customer info -->
				@if(!empty($receipt_details->customer_name)) 
				<br/>Name:  {{ $receipt_details->customer_name }}  
				@endif

				@if(!empty($receipt_details->customer_cell_number))
				<br/>Mobile: {{ $receipt_details->customer_cell_number }} 
				@endif

				@if(!empty($receipt_details->customer_info))
				<br/>Address: {!! $receipt_details->customer_info !!}
				@endif  
			</span>

			<span class="pull-right text-left">
				<b>Order Status: </b> {{$receipt_details->additional_notes}} <br>  

			</span>
		</p><br>
		<div class="pull-right text-left">
			<table border="1">
				<tr><td style="background-color: #d2d6de !important;"><b>Payment Status </b></td></tr>
				<tr>
					<td style="color: white !important;">
					@if($receipt_details->total_due=='0')
				<center><b style="color: green !important;"> Paid</b> </center>
				@else
				<b style="color: red !important;">Not Paid</b>
				@endif

				</td>
			</tr>
			</table> 
		</div>
	</div>

</div>

<div class="row">
	@includeIf('sale_pos.receipts.partial.common_repair_invoice')
</div>

<div class="row">
	<div class="col-xs-12">
		<br/>
		<table style="background-color: red;" class="table table-responsive table-bordered" style="border: 1px solid transparent!important">
			<thead>
				<tr>
					<th   style="background-color: #d2d6de !important;">SL</th>
					<th   style="background-color: #d2d6de !important;">{{$receipt_details->table_product_label}}</th>
					<th   style="background-color: #d2d6de !important;" class="text-right">{{$receipt_details->table_qty_label}}</th>
					<th   style="background-color: #d2d6de !important;" class="text-right">{{$receipt_details->table_unit_price_label}}</th>
					<th   style="background-color: #d2d6de !important;" class="text-right">{{$receipt_details->table_discount}}</th>
					<th   style="background-color: #d2d6de !important;" class="text-right">{{$receipt_details->table_subtotal_label}}</th> 
				</tr>
			</thead>
			<tbody>
				<?php $i =0 ; $j=0;?>
				@forelse($receipt_details->lines as $line)

				<?php $i++; 
				$j += (int)$line['quantity'];

				?>
				<tr>
					<td class="text-center" style="vertical-align: middle;">{{$i}}</td>
					<td style="word-break: break-all;">
						<!-- @if(!empty($line['image']))
						<img src="{{$line['image']}}" alt="Image" style="float: left; margin-right: 8px; height: 50px;width: 50px;">
						@endif -->
						{{$line['name']}} 
					</td>
					<td class="text-center" style="vertical-align: middle;">{{(int)$line['quantity']}}</td>
					<td class="text-center" style="vertical-align: middle;">{{$line['unit_price_inc_tax']}}</td>
					<td class="text-center" style="vertical-align: middle;">{{(int)$line['discount']}}%</td>
					<td class="text-center" style="vertical-align: middle;">{{$line['line_total']}}</td>

				</tr>

				@if(!empty($line['modifiers']))
				@foreach($line['modifiers'] as $modifier)
				<tr>
					<td>
						{{$modifier['name']}} {{$modifier['variation']}} 
						@if(!empty($modifier['sub_sku'])), {{$modifier['sub_sku']}} @endif @if(!empty($modifier['cat_code'])), {{$modifier['cat_code']}}@endif
						@if(!empty($modifier['sell_line_note']))({{$modifier['sell_line_note']}}) @endif 
					</td>
					<td class="text-right">{{$modifier['quantity']}} {{$modifier['units']}} </td>
					<td class="text-right">{{$modifier['unit_price_inc_tax']}}</td>
					<td class="text-right">{{$modifier['line_total']}}</td>
				</tr>
				@endforeach
				@endif
				@empty
				<tr>
					<td colspan="4">&nbsp;</td>
				</tr>
				@endforelse
				<tr>
					<td colspan="2" style="border: 0px!important;"> 
						Powered By Durbiin.com 
						<p>Developed By Next Page Technology Ltd - 01700446868</p>
					</td>
					<td colspan="6" style="padding: 0px;">
						<table class="table table-bordered" style="margin:0px!important; border: 0px!important;">
							<tr>
								<th colspan="2" style="width: 14%;text-align: center;">{{$j}}</th>
								<th colspan="3" style="width: 48%;text-align: right;">Sub Total</th>
								<th style="width: 38%; text-align:center;">
									@if(!empty($receipt_details->subtotal)){{$receipt_details->subtotal}} 
									@else {{0}}
									@endif	
								</th>
							</tr>

							<tr>
								<th colspan="5" style="text-align: right;">Shipping Charge</th>
								<th style="text-align: center;">@if(!empty($receipt_details->shipping_charges)){{$receipt_details->shipping_charges}} @else {{0}}
								@endif	</th>

							</tr>
							<tr>
								<th colspan="5" style="text-align: right;">Total</th>
								<th style="text-align: center;">@if(!empty($receipt_details->total)){{$receipt_details->total}} @else {{0}}
								@endif</th>

							</tr>
							<tr>
								<td colspan="6" style="padding: 0px;border: 0px!important;">
									<table class="table table-bordered" style="margin:0px!important; border: 0px!important;">	
										<tr>	
											<th colspan="5"  class="text-right" style="width: 62%;background-color: #d2d6de !important;">Customer Payable	</th>
											<th colspan="5" class="text-center" style="widows: 38%;background-color: #d2d6de !important;">@if(!empty($receipt_details->total_due)){{$receipt_details->total_due}} @else {{0}}
												@endif	
											</th>
											
										</tr>
									</table>
								</td> 
							</tr>
						</table>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
 



<!-- @if(!empty($receipt_details->footer_text))
<div class="row">
	<div class="col-xs-12">
		Developed By Next Page Technology Ltd - 01300446868
	</div>
</div>
@endif -->
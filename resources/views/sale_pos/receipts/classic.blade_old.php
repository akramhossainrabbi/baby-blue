<!-- business information here -->

<div class="row">
<table style="border: 1px solid #222;">
	<tr>
		<td style="width: 25%;vertical-align: middle;">
			@if(!empty($receipt_details->logo))
		<img src="{{$receipt_details->logo}}" class="img img-responsive center-block" style="height: 50px;">
	@endif
		</td>
		<td style="width: 50%;vertical-align: middle;">
			@if(!empty($receipt_details->header_text))
		
			{!! $receipt_details->header_text !!}
		
	@endif
		</td>
		<td style="width: 25%; vertical-align: middle;">
			
			<!-- Shop & Location Name  -->
			<img class="center-block" src="data:image/png;base64,{{DNS1D::getBarcodePNG($receipt_details->invoice_no, 'C128', 2,30,array(39, 48, 54), true)}}">
		</td>
	</tr>
</table>
	<!-- Logo -->
	

	<!-- Header text -->
	

	<!-- business information here -->
	<div class="col-xs-12 text-center">
		

		<!-- Address -->
		<p>
		@if(!empty($receipt_details->address))
				<small class="text-center">
				{!! $receipt_details->address !!}
				</small>
		@endif
		@if(!empty($receipt_details->contact))
			<br/>{{ $receipt_details->contact }}
		@endif	
		@if(!empty($receipt_details->contact) && !empty($receipt_details->website))
			, 
		@endif
		@if(!empty($receipt_details->website))
			{{ $receipt_details->website }}
		@endif
		@if(!empty($receipt_details->location_custom_fields))
			<br>{{ $receipt_details->location_custom_fields }}
		@endif
		</p>
		<p>
		@if(!empty($receipt_details->sub_heading_line1))
			{{ $receipt_details->sub_heading_line1 }}
		@endif
		@if(!empty($receipt_details->sub_heading_line2))
			<br>{{ $receipt_details->sub_heading_line2 }}
		@endif
		@if(!empty($receipt_details->sub_heading_line3))
			<br>{{ $receipt_details->sub_heading_line3 }}
		@endif
		@if(!empty($receipt_details->sub_heading_line4))
			<br>{{ $receipt_details->sub_heading_line4 }}
		@endif		
		@if(!empty($receipt_details->sub_heading_line5))
			<br>{{ $receipt_details->sub_heading_line5 }}
		@endif
		</p>
		<p>
		@if(!empty($receipt_details->tax_info1))
			<b>{{ $receipt_details->tax_label1 }}</b> {{ $receipt_details->tax_info1 }}
		@endif

		@if(!empty($receipt_details->tax_info2))
			<b>{{ $receipt_details->tax_label2 }}</b> {{ $receipt_details->tax_info2 }}
		@endif
		</p>

		<!-- Title of receipt -->
		@if(!empty($receipt_details->invoice_heading))
			<h3 class="text-center">
				{!! $receipt_details->invoice_heading !!}
			</h3>
		@endif

		<!-- Invoice  number, Date  -->
		<p style="width: 100% !important" class="word-wrap">
			<span class="pull-left text-left word-wrap">
				@if(!empty($receipt_details->invoice_no_prefix))
					<b>{!! $receipt_details->invoice_no_prefix !!}</b>
				@endif
				{{$receipt_details->invoice_no}}

				@if(!empty($receipt_details->types_of_service))
					<br/>
					<span class="pull-left text-left">
						<strong>{!! $receipt_details->types_of_service_label !!}:</strong>
						{{$receipt_details->types_of_service}}
						<!-- Waiter info -->
						@if(!empty($receipt_details->types_of_service_custom_fields))
							@foreach($receipt_details->types_of_service_custom_fields as $key => $value)
								<br><strong>{{$key}}: </strong> {{$value}}
							@endforeach
						@endif
					</span>
				@endif

				<!-- Table information-->
		        @if(!empty($receipt_details->table_label) || !empty($receipt_details->table))
		        	<br/>
					<span class="pull-left text-left">
						@if(!empty($receipt_details->table_label))
							<b>{!! $receipt_details->table_label !!}</b>
						@endif
						{{$receipt_details->table}}

						<!-- Waiter info -->
					</span>
		        @endif

				<!-- customer info -->
				@if(!empty($receipt_details->customer_name))
					<br/>
					<b>{{ $receipt_details->customer_label }}</b> {{ $receipt_details->customer_name }} <br>
				@endif
				@if(!empty($receipt_details->customer_info))
					{!! $receipt_details->customer_info !!}
				@endif
				@if(!empty($receipt_details->client_id_label))
					<br/>
					<b>{{ $receipt_details->client_id_label }}</b> {{ $receipt_details->client_id }}
				@endif
				@if(!empty($receipt_details->customer_tax_label))
					<br/>
					<b>{{ $receipt_details->customer_tax_label }}</b> {{ $receipt_details->customer_tax_number }}
				@endif
				@if(!empty($receipt_details->customer_custom_fields))
					<br/>{!! $receipt_details->customer_custom_fields !!}
				@endif
				@if(!empty($receipt_details->sales_person_label))
					<br/>
					<b>{{ $receipt_details->sales_person_label }}</b> {{ $receipt_details->sales_person }}
				@endif
				@if(!empty($receipt_details->customer_rp_label))
					<br/>
					<strong>{{ $receipt_details->customer_rp_label }}</strong> {{ $receipt_details->customer_total_rp }}
				@endif
			</span>

			<span class="pull-right text-left">
				<b>{{$receipt_details->date_label}}</b> {{$receipt_details->invoice_date}}

				@if(!empty($receipt_details->due_date_label))
				<br><b>{{$receipt_details->due_date_label}}</b> {{$receipt_details->due_date ?? ''}}
				@endif

				@if(!empty($receipt_details->brand_label) || !empty($receipt_details->repair_brand))
					<br>
					@if(!empty($receipt_details->brand_label))
						<b>{!! $receipt_details->brand_label !!}</b>
					@endif
					{{$receipt_details->repair_brand}}
		        @endif


		        @if(!empty($receipt_details->device_label) || !empty($receipt_details->repair_device))
					<br>
					@if(!empty($receipt_details->device_label))
						<b>{!! $receipt_details->device_label !!}</b>
					@endif
					{{$receipt_details->repair_device}}
		        @endif

				@if(!empty($receipt_details->model_no_label) || !empty($receipt_details->repair_model_no))
					<br>
					@if(!empty($receipt_details->model_no_label))
						<b>{!! $receipt_details->model_no_label !!}</b>
					@endif
					{{$receipt_details->repair_model_no}}
		        @endif

				@if(!empty($receipt_details->serial_no_label) || !empty($receipt_details->repair_serial_no))
					<br>
					@if(!empty($receipt_details->serial_no_label))
						<b>{!! $receipt_details->serial_no_label !!}</b>
					@endif
					{{$receipt_details->repair_serial_no}}<br>
		        @endif
				@if(!empty($receipt_details->repair_status_label) || !empty($receipt_details->repair_status))
					@if(!empty($receipt_details->repair_status_label))
						<b>{!! $receipt_details->repair_status_label !!}</b>
					@endif
					{{$receipt_details->repair_status}}<br>
		        @endif
		        
		        @if(!empty($receipt_details->repair_warranty_label) || !empty($receipt_details->repair_warranty))
					@if(!empty($receipt_details->repair_warranty_label))
						<b>{!! $receipt_details->repair_warranty_label !!}</b>
					@endif
					{{$receipt_details->repair_warranty}}
					<br>
		        @endif
		        
				<!-- Waiter info -->
				@if(!empty($receipt_details->service_staff_label) || !empty($receipt_details->service_staff))
		        	<br/>
					@if(!empty($receipt_details->service_staff_label))
						<b>{!! $receipt_details->service_staff_label !!}</b>
					@endif
					{{$receipt_details->service_staff}}
		        @endif
			</span>
		</p>
	</div>
</div>

<div class="row">
	@includeIf('sale_pos.receipts.partial.common_repair_invoice')
</div>

<div class="row">
	<div class="col-xs-12">
		<br/>
		<table class="table table-responsive table-bordered" style="border: 1px solid transparent!important">
			<thead>
				<tr>
					<th>SL</th>
					<th>{{$receipt_details->table_product_label}}</th>
					<th class="text-right">{{$receipt_details->table_qty_label}}</th>
					<th class="text-right">{{$receipt_details->table_unit_price_label}}</th>\
					<th class="text-right">{{$receipt_details->table_discount}}</th>
					<th class="text-right">{{$receipt_details->table_subtotal_label}}</th>
					
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
							@if(!empty($line['image']))
								<img src="{{$line['image']}}" alt="Image" style="float: left; margin-right: 8px; height: 50px;width: 50px;">
							@endif
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
					<td colspan="2" style="border: 0px!important;"></td>
					<td colspan="6" style="padding: 0px;">
						<table class="table table-bordered" style="margin:0px!important; border: 0px!important;">
							<tr>
						<th colspan="2" style="width: 14%;text-align: center;">{{$j}}</th>
						<th colspan="3" style="width: 48%;text-align: right;">Sub Total</th>
						<th style="width: 38%; text-align:center;">@if(!empty($receipt_details->subtotal)){{$receipt_details->subtotal}} @else {{0}}
										@endif	</th>
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
						<td colspan="6" style="background: #ddd;padding: 0px;border: 0px!important;">
							<table class="table table-bordered" style="margin:0px!important; border: 0px!important;">	
									<tr>	<th colspan="5"  class="text-right" style="width: 62%">Cutomer Payable	</th>
										<th colspan="5" class="text-center" style="widows: 38%">@if(!empty($receipt_details->total_due)){{$receipt_details->total_due}} @else {{0}}
										@endif	</th>
											
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





@if(!empty($receipt_details->footer_text))
	<div class="row">
		<div class="col-xs-12">
			 Developed By Next Page Technology Ltd - 01300446868
		</div>
	</div>
@endif
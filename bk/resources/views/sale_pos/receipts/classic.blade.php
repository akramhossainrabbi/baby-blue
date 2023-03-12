<!-- business information here -->
<?php
$return_amount = 0;
$symbol = $receipt_details->currency['symbol'];

$amount = preg_replace('/[^0-9.]/','',$receipt_details->total);


$subtotal = preg_replace('/[^0-9.]/','',$receipt_details->subtotal);
$discount = preg_replace('/[^0-9.]/','',$receipt_details->discount);
$shipping_charges = preg_replace('/[^0-9.]/','',$receipt_details->shipping_charges);


$fish_cutting = $amount - ($subtotal + $shipping_charges) ;

if($fish_cutting > 0)
{
	$fish_cutting = $symbol .' '. $fish_cutting;
}
else
{
	$fish_cutting = $symbol . ' 0';
}



?>
<div class="row">

	<!-- Logo -->
	@if(!empty($receipt_details->logo))
		<img src="{{$receipt_details->logo}}" class="img img-responsive center-block">
	@endif

	<!-- Header text -->
	@if(!empty($receipt_details->header_text))
		<div class="col-xs-12">
			{!! $receipt_details->header_text !!}
		</div>
	@endif



	
			
			
	<!-- business information here -->
	<div class="col-xs-12 text-center">
		<h2 class="text-center">
			<!-- Shop & Location Name  -->
			@if(!empty($receipt_details->display_name))
				{{$receipt_details->display_name}}
			@endif
		</h2>

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
			    @if(isset($receipt_details->ecom_order_id))
			        <b>Ecommerce Order Id </b>{{ $receipt_details->ecom_order_id }}<br>
			    @endif
				@if(!empty($receipt_details->invoice_no_prefix))
					<b>{!! $receipt_details->invoice_no_prefix !!}</b>
				@endif
				{{$receipt_details->invoice_no}}

				

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
		        <br>
		        @if(isset($receipt_details->card_type))
		            <b>Card Type</b> {{$receipt_details->card_type}}<br>
		        @endif
		        @if(isset($receipt_details->transaction_id))
		            <b>Transaction id</b> {{$receipt_details->transaction_id}}<br>
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
		<table class="table table-responsive table-slim">
			<thead>
				<tr>
				    <th>SL </th>
					<th>{{$receipt_details->table_product_label}}</th>
					<th class="text-right">{{$receipt_details->table_qty_label}}</th>
					<th class="text-right">{{$receipt_details->table_unit_price_label}}</th>
					<th class="text-right">{{$receipt_details->table_subtotal_label}}</th>
				</tr>
			</thead>
			<tbody>
			    <?php $i=1;  ?>
				@forelse($receipt_details->lines as $line)
				
				
					<tr>
					    <td> {{$i}}.
					    
					    <?php $i++; ?>
					    </td>
						<td style="word-break: break-all;">
							@if(!empty($line['image']))
								<img src="{{$line['image']}}" alt="Image" width="50" style="float: left; margin-right: 8px;">
							@endif
                            {{$line['name']}} {{$line['product_variation']}} {{$line['variation']}} 
                            @if(!empty($line['sub_sku'])), {{$line['sub_sku']}} @endif @if(!empty($line['brand'])), {{$line['brand']}} @endif @if(!empty($line['cat_code'])), {{$line['cat_code']}}@endif
                            @if(!empty($line['product_custom_fields'])), {{$line['product_custom_fields']}} @endif
                            @if(!empty($line['sell_line_note']))({{$line['sell_line_note']}}) @endif 
                            @if(!empty($line['lot_number']))<br> {{$line['lot_number_label']}}:  {{$line['lot_number']}} @endif 
                            @if(!empty($line['product_expiry'])), {{$line['product_expiry_label']}}:  {{$line['product_expiry']}} @endif

                            @if(!empty($line['warranty_name'])) <br><small>{{$line['warranty_name']}} </small>@endif @if(!empty($line['warranty_exp_date'])) <small>- {{@format_date($line['warranty_exp_date'])}} </small>@endif
                            @if(!empty($line['warranty_description'])) <small> {{$line['warranty_description'] ?? ''}}</small>@endif
                        </td>
						<td class="text-right">{{$line['quantity']}} {{$line['units']}} </td>
						<td class="text-right">{{$line['unit_price_inc_tax']}}</td>
						<td class="text-right">{{$line['line_total']}}</td>
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

					
				
			</tbody>

		</table>
		
	</div>
</div>


@if(!empty($receipt_details->return_lines))
<div class="row">
	<div class="col-xs-12">
	    <span class="text-center"><b>Sales Return</b></span>
		<br/>
		<table class="table table-responsive table-slim">
			<thead>
				<tr>
				    <th>SL </th>
					<th>{{$receipt_details->table_product_label}}</th>
					<th class="text-right">{{$receipt_details->table_qty_label}}</th>
					<th class="text-right">{{$receipt_details->table_unit_price_label}}</th>
					<th class="text-right">{{$receipt_details->table_subtotal_label}}</th>
				</tr>
			</thead>
			<tbody>
			    <?php 
			    $i=1;
			    $rerutn_amount = 0;
			    ?>
				@foreach($receipt_details->return_lines as $line)

				
				    @if($line['quantity'] != "0.00")
				    
					<tr>
					    <td> {{$i}}
					    
					    <?php 
					            $i++;
					            $amount_ret = str_replace(",", "", $line['line_total']);
					            $return_amount += (float)$amount_ret;
					    
					    ?>
					    </td>
						<td style="word-break: break-all;">
							
                            {{$line['name']}} 
                            
                        </td>
						<td class="text-right">{{$line['quantity']}} {{$line['units']}} </td>
						<td class="text-right">{{$line['unit_price_inc_tax']}}</td>
						<td class="text-right">{{ $line['line_total'] }}</td>
					</tr>
				
					@endif
				@endforeach
			</tbody>
		</table>
	</div>
</div>
@endif
<div class="row">
	<div class="col-md-12"><hr/></div>
	<div class="col-xs-6">

		<table class="table table-slim">
            
			@if(!empty($receipt_details->payments))
				@foreach($receipt_details->payments as $payment)
					<tr>
						<td>{{$payment['method']}}</td>
						<td class="text-right" >{{$payment['amount']}}</td>
						<td>{{$payment['date']}}</td>
					</tr>
				@endforeach
			@endif

			<!-- Total Paid-->
			@if(!empty($receipt_details->total_paid))
				<tr>
					<th>
						{!! $receipt_details->total_paid_label !!}
					</th>
					<td class="text-right">
						{{$receipt_details->total_paid}}
					</td>
				</tr>
			@endif
            
			<!-- Total Due-->
			@if(!empty($receipt_details->total_due))
			<tr style="">
				<th>
					{!! $receipt_details->total_due_label !!}
				</th>
				<td class="text-right">
				     <?php 
				      $total_due =  explode(" ",$receipt_details->total_due);
				      
				      $total_due = str_replace(",","",$total_due[1]);
				   
				      $total_due = $total_due - $return_amount;
				      $total_due = $symbol .' '.$total_due ;
				     ?>
					{{$total_due}} 
				</td>
			</tr>
			@endif

			@if(!empty($receipt_details->all_due))
			<tr style="display:none;">
				<th>
					{!! $receipt_details->all_bal_label !!}
				</th>
				<td class="text-right">
				    
					{{$receipt_details->all_due}}
				</td>
			</tr>
			@endif
		</table>

		{{$receipt_details->additional_notes}}
	</div>

	<div class="col-xs-6">
        <div class="table-responsive">
          	<table class="table table-slim">
				<tbody>
					@if(!empty($receipt_details->total_quantity_label))
						<tr class="color-555">
							<th style="width:70%">
								{!! $receipt_details->total_quantity_label !!}
							</th>
							<td class="text-right">
								{{$receipt_details->total_quantity}}
							</td>
						</tr>
					@endif
					<tr>
						<th style="width:70%">
							{!! $receipt_details->subtotal_label !!}
						</th>
						<td class="text-right">
							{{$receipt_details->subtotal}}
						</td>
					</tr>
					
					<!-- Shipping Charges -->
					@if(!empty($receipt_details->shipping_charges))
						<tr>
							<th style="width:70%">
								{!! $receipt_details->shipping_charges_label !!}
							</th>
							<td class="text-right">
								{{$receipt_details->shipping_charges}}
							</td>
						</tr>
					@endif

					<!-- Discount -->
					@if( !empty($receipt_details->discount) )
						<tr>
							<th>
								{!! $receipt_details->discount_label !!}
							</th>

							<td class="text-right">
								(-) {{$receipt_details->discount}}
							</td>
						</tr>
					@endif

					@if( !empty($receipt_details->reward_point_label) )
						<tr>
							<th>
								{!! $receipt_details->reward_point_label !!}
							</th>

							<td class="text-right">
								(-) {{$receipt_details->reward_point_amount}}
							</td>
						</tr>
					@endif

					<!-- Tax -->
					@if( !empty($receipt_details->tax) )
						<tr>
							<th>
								{!! $receipt_details->tax_label !!}
							</th>
							<td class="text-right">
								(+) {{$receipt_details->tax}}
							</td>
						</tr>
					@endif

					@if( !empty($receipt_details->round_off_label) )
						<tr>
							<th>
								{!! $receipt_details->round_off_label !!}
							</th>
							<td class="text-right">
								{{$receipt_details->round_off}}
							</td>
						</tr>
					@endif

					<!-- Total -->
					
					
					
					
					@if( $return_amount > 0 )
					<tr>
						<th>
						    Return Amount
						</th>
						<td class="text-right">
							<?php
							$ner_ret = 	$symbol .' '.$return_amount;
							?>
							{{$ner_ret}}
						</td>
					</tr>
					@endif

					@if(!empty($receipt_details->types_of_service))
					<tr>
						<th >{!! $receipt_details->types_of_service_label !!}</th>
						
						<th class="text-right">{{$fish_cutting}}</thd>
					</tr>
					@endif
					
					<?php
					$amount = $amount -  $return_amount;
					$amount = $symbol .' '.$amount;
					?>
					<tr>
						<th>
							{!! $receipt_details->total_label !!}
						</th>
						<td class="text-right">
							{{$amount}}.00
						</td>
					</tr>
				</tbody>
        	</table>
        </div>
    </div>
</div>

@if($receipt_details->show_barcode)
	<div class="row">
		<div class="col-xs-12">
			{{-- Barcode --}}
			<img class="center-block" src="data:image/png;base64,{{DNS1D::getBarcodePNG($receipt_details->invoice_no, 'C128', 2,30,array(39, 48, 54), true)}}">
		</div>
	</div>
@endif

@if(!empty($receipt_details->footer_text))
	<div class="row">
		<div class="col-xs-12">
			{!! $receipt_details->footer_text !!}
		</div>
	</div>
@endif
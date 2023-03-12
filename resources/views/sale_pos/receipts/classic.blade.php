<!-- business information here -->
<style>
table {
        border-collapse: collapse;
    }
    
    
    .invoice-bottom-content{
        display: flex;
        align-items: end;
        justify-content: space-between;
        flex-direction: row;
        gap: 5px;
        width: 100%;
        text-align: left;
    }
    
    .invoice-bottom-content p {
        margin: 0px;
        font-size: 10px !important;
    }
    
    .invoice-address p {
        margin: 0px;
        font-size: 10px !important;
    }
    
    table thead tr th{
        border: 1px solid #000 !important;
    }
    
    table tr th {
        padding: 2px !important;
    }
    
    table tr td {
        padding: 2px !important;
    }
    
    </style>
<?php
$return_amount = 0;
$symbol = '';

$amount = preg_replace('/[^0-9.]/','',$receipt_details->total);


$subtotal = preg_replace('/[^0-9.]/','',$receipt_details->subtotal);
$discount = preg_replace('/[^0-9.]/','',$receipt_details->discount);
$shipping_charges = preg_replace('/[^0-9.]/','',$receipt_details->shipping_charges);

?>
<div class="row">

	<!-- Logo -->
	@if(!empty($receipt_details->logo))
		<img src="{{$receipt_details->logo}}" class="img img-responsive center-block" style="display:none;">
	@endif  

	<!-- Header text -->
	@if(!empty($receipt_details->header_text))
		<div class="col-xs-12" style="display:none;">
			{!! $receipt_details->header_text !!}
		</div>
	@endif



	
			
			
	<!-- business information here -->
	<div class="col-xs-12 text-center">
		<h2 class="text-center">
			 <h4 class="text-uppercase" style="color: #222;font-size: 16px;font-weight:bold; margin-bottom: 10px;">Baby Blue or Pink Bird</h4>
		</h2>

		<!-- Address -->
		<div class="invoice-address"> 
		    <p>
    		@if(!empty($receipt_details->address))
    				<small class="text-center">
    				{!! $receipt_details->address !!}
    				</small>
    		@endif
    		@if(!empty($receipt_details->contact))
    			<p> {{ $receipt_details->contact }} </p>
    		@endif	
    		@if(!empty($receipt_details->contact) && !empty($receipt_details->website))
    			, 
    		@endif
    		@if(!empty($receipt_details->website))
    			<p> {{ $receipt_details->website }} </p>
    		@endif
    		@if(!empty($receipt_details->location_custom_fields))
    			<p> {{ $receipt_details->location_custom_fields }} </p>
    		@endif
    		</p>
    		<p>
    		@if(!empty($receipt_details->sub_heading_line1))
    			<p> {{ $receipt_details->sub_heading_line1 }} </p>
    		@endif
    		@if(!empty($receipt_details->sub_heading_line2))
    			<p> {{ $receipt_details->sub_heading_line2 }} </p>
    		@endif
    		@if(!empty($receipt_details->sub_heading_line3))
    			<p> {{ $receipt_details->sub_heading_line3 }} </p>
    		@endif
    		@if(!empty($receipt_details->sub_heading_line4))
    			<p> {{ $receipt_details->sub_heading_line4 }} </p>
    		@endif		
    		@if(!empty($receipt_details->sub_heading_line5))
    			<p> {{ $receipt_details->sub_heading_line5 }} </p>
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
		</div>

		<!-- Title of receipt -->
		@if(!empty($receipt_details->invoice_heading))
			<h3 class="text-center" style="color: #222;font-size: 16px;font-weight:bold; margin-bottom: 10px;">
				<!--{!! $receipt_details->invoice_heading !!}- -->
				@if(isset($receipt_details->ecom_order_id))
			        <b>Ecommerce Order Id </b>{{ $receipt_details->ecom_order_id }}<br>
			    @endif
				@if(!empty($receipt_details->invoice_no_prefix))
					<b>{!! $receipt_details->invoice_no_prefix !!}</b>
				@endif
				{{$receipt_details->invoice_no}}
			</h3>
		@endif

		<!-- Invoice  number, Date  -->
		<div style="width: 100% !important;" class="invoice-bottom-content">
			<div class="left-content">
				<!-- Table information-->
		        @if(!empty($receipt_details->table_label) || !empty($receipt_details->table))
		        	
					<span class="pull-left text-left" style="display:none;">
						@if(!empty($receipt_details->table_label))
							<b>{!! $receipt_details->table_label !!}</b>
							{{$receipt_details->table}}
						@endif
						

						<!-- Waiter info -->
					</span>
		        @endif

				<!-- customer info -->
				@if(!empty($receipt_details->customer_name))
					<p> <b>{{ $receipt_details->customer_label }}</b> {{ $receipt_details->customer_name }} </p>
				@endif
				@if(!empty($receipt_details->customer_info))
					<p> {!! $receipt_details->customer_info !!} </P>
				@endif
				@if(!empty($receipt_details->client_id_label))
					<p> <b>{{ $receipt_details->client_id_label }}</b> {{ $receipt_details->client_id }} </p>
				@endif
				@if(!empty($receipt_details->customer_tax_label))
					<p> <b>{{ $receipt_details->customer_tax_label }}</b> {{ $receipt_details->customer_tax_number }} </p>
				@endif
				@if(!empty($receipt_details->customer_custom_fields))
					<p> {!! $receipt_details->customer_custom_fields !!} </p>
				@endif
				@if(!empty($receipt_details->sales_person_label))
					<p> <b>{{ $receipt_details->sales_person_label }}</b> {{ $receipt_details->sales_person }} </p>
				@endif
				@if(!empty($receipt_details->customer_rp_label))
					<strong>{{ $receipt_details->customer_rp_label }}</strong> {{ $receipt_details->customer_total_rp }}
				@endif
			</div>

			<div class="right-content">
				<p> <b>{{$receipt_details->date_label}}</b> {{$receipt_details->invoice_date}} </p>
				@if(!empty($receipt_details->due_date_label))
				<p> <b>{{$receipt_details->due_date_label}}</b> {{$receipt_details->due_date ?? ''}} </p>
				@endif

				@if(!empty($receipt_details->brand_label) || !empty($receipt_details->repair_brand))
					@if(!empty($receipt_details->brand_label))
						<p> <b>{!! $receipt_details->brand_label !!}</b> </p>
					@endif
					{{$receipt_details->repair_brand}}
		        @endif
		        @if(!empty($receipt_details->device_label) || !empty($receipt_details->repair_device))
					@if(!empty($receipt_details->device_label))
						<p> <b>{!! $receipt_details->device_label !!} </b> </p>
					@endif
					{{$receipt_details->repair_device}}
		        @endif

				@if(!empty($receipt_details->model_no_label) || !empty($receipt_details->repair_model_no))
					@if(!empty($receipt_details->model_no_label))
						<p> <b>{!! $receipt_details->model_no_label !!} </b> </p>
					@endif
					{{$receipt_details->repair_model_no}}
		        @endif

				@if(!empty($receipt_details->serial_no_label) || !empty($receipt_details->repair_serial_no))
					@if(!empty($receipt_details->serial_no_label))
						<p> <b>{!! $receipt_details->serial_no_label !!} </b> </p>
					@endif
					{{$receipt_details->repair_serial_no}}
		        @endif
				@if(!empty($receipt_details->repair_status_label) || !empty($receipt_details->repair_status))
					@if(!empty($receipt_details->repair_status_label))
						<p> <b>{!! $receipt_details->repair_status_label !!}</b> </p>
					@endif
					{{$receipt_details->repair_status}}
		        @endif
		        
		        @if(!empty($receipt_details->repair_warranty_label) || !empty($receipt_details->repair_warranty))
					@if(!empty($receipt_details->repair_warranty_label))
						<p> <b>{!! $receipt_details->repair_warranty_label !!} </b> </p>
					@endif
					{{$receipt_details->repair_warranty}}
		        @endif
		        
				<!-- Waiter info -->
				@if(!empty($receipt_details->service_staff_label) || !empty($receipt_details->service_staff))
					@if(!empty($receipt_details->service_staff_label))
						<p> <b>{!! $receipt_details->service_staff_label !!} </b> </p>
					@endif
					{{$receipt_details->service_staff}}
		        @endif
		        @if(isset($receipt_details->card_type))
		            <p> <b>Card Type</b> {{$receipt_details->card_type}} </p>
		        @endif
		        @if(isset($receipt_details->transaction_id))
		            <p> <b>Transaction id</b> {{$receipt_details->transaction_id}} </p>
		        @endif
			</div>
		</div>
	</div>
</div>

<div class="row">
	@includeIf('sale_pos.receipts.partial.common_repair_invoice')
</div>

<div class="row">
	<div class="col-xs-12">
		<br/>
		<table class="table table-responsive table-slim">
			<thead style="border:1px solid black !important;">
				<tr>
					<th class="text-center" style="color: #222;font-size: 10px;">{{$receipt_details->table_product_label}}</th>
					<th class="text-center" style="color: #222;font-size: 10px;">{{$receipt_details->table_qty_label}}</th>
					<th class="text-center" style="color: #222;font-size: 10px;">{{$receipt_details->table_unit_price_label}}</th>
					<th class="text-center" style="color: #222;font-size: 10px;">{{$receipt_details->line_discount_label}}</th>
					<th class="text-center" style="color: #222;font-size: 10px;">{{$receipt_details->table_subtotal_label}}</th>
				</tr>
			</thead>
			<tbody>
			    <?php $i=1;  ?>
				@forelse($receipt_details->lines as $line)
					<tr style="border-top:1px solid #000; font-size: 10px;">
						<td style="color: #222;font-size: 10px;" >
							@if(!empty($line['image']))
								<img src="{{$line['image']}}" alt="Image" width="50" style=" margin-right: 8px;">
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
						<td class="text-center">{{$line['quantity']}} </td>
						<td class="text-center">{{$line['unit_price_inc_tax']}}</td>
						<td class="text-center">{{$line['line_discount']}}</td>
						<td class="text-center">{{$line['line_total']}}</td>
					</tr>
					@if(!empty($line['modifiers']))
						@foreach($line['modifiers'] as $modifier)
							<tr style="border-top:1px solid black;">
								<td>
		                            {{$modifier['name']}} {{$modifier['variation']}} 
		                            @if(!empty($modifier['sub_sku'])), {{$modifier['sub_sku']}} @endif @if(!empty($modifier['cat_code'])), {{$modifier['cat_code']}}@endif
		                            @if(!empty($modifier['sell_line_note']))({{$modifier['sell_line_note']}}) @endif 
		                        </td>
								<td class="text-center">{{$modifier['quantity']}} {{$modifier['units']}} </td>
								<td class="text-center">{{$modifier['unit_price_inc_tax']}}</td>
								<td class="text-center">{{$modifier['line_discount']}}</td>
								<td class="text-center">{{$modifier['line_total']}}</td>
							</tr>
						@endforeach
					@endif
				@empty
					
			
				@endforelse

					
				
			</tbody>

		</table>
		
	</div>
</div>



<div class="row" style="border-top:1px solid black;">
	<div class="col-xs-12">
		<table class="table table-slim" style="display:none;">
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

	<div class="col-xs-12">
        <div class="table-responsive">
          	<table class="table table-slim">
				<tbody>
					@if(!empty($receipt_details->total_quantity_label))

						<tr class="color-555" style="text-align:left;color: #222;font-size: 10px;">
							<th style="width:70%">
								{!! $receipt_details->total_quantity_label !!}
							</th>
							<td class="text-right">
								{{$receipt_details->total_quantity}}
							</td>
						</tr>
					@endif
					<tr style="text-align:left;color: #222;font-size: 10px;">
						<th style="width:70%">
							{!! $receipt_details->subtotal_label !!}
						</th>
						<td class="text-right">
							{{$receipt_details->subtotal}}
						</td>
					</tr>
					
					<!-- Shipping Charges -->
					@if(!empty($receipt_details->shipping_charges))
						<tr style="text-align:left;color: #222;font-size: 10px;">
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
						<tr style="text-align:left;color: #222;font-size: 10px;">
							<th>
								{!! $receipt_details->discount_label !!}
							</th>

							<td class="text-right">
								(-) {{$receipt_details->discount}}
							</td>
						</tr>
					@endif
					
						<!-- Change Return  -->
                    @if( !empty($receipt_details->net_exchange_amount) )
                        <tr>
                            <td style="text-align:left;color: #222;font-size: 11px;">{!! $receipt_details->exchange_label !!}</td>
                            <td style="text-align:left;color: #222;font-size: 11px;"></td>
                            <td style="text-align:left;color: #222;font-size: 11px;"></td>
                            <td style="text-align:right;color: #222;font-size: 11px;">
                            <?php  dd($receipt_details); ?>
                            {{$receipt_details->net_exchange_amount}}</td>
                        </tr>
                    @endif
						
						
						<!--  End Change Return-->
						

					@if( !empty($receipt_details->reward_point_label) )
						<tr>
							<th style="text-align:left;color: #222;font-size: 10px;">
								{!! $receipt_details->reward_point_label !!}
							</th>

							<td class="text-right" style="text-align:left;color: #222;font-size: 10px;">
								(-) {{$receipt_details->reward_point_amount}}
							</td>
						</tr>
					@endif

					<!-- Tax -->
				
				
					<tr>
						<th style="text-align:left;color: #222;font-size: 10px;">
							VAT
						</th>
						<td class="text-right" style="text-align:left;color: #222;font-size: 10px;">
								{{$receipt_details->tax}}
						</td>
					</tr>
				
				

					@if( !empty($receipt_details->round_off_label) )
						<tr>
							<th style="text-align:left;color: #222;font-size: 10px;">
								{!! $receipt_details->round_off_label !!}
							</th>
							<td class="text-right" style="text-align:left;color: #222;font-size: 10px;">
								{{$receipt_details->round_off}}
							</td>
						</tr>
					@endif

					<!-- Total -->
					@php
						$discount = intval(str_replace(',', '', $receipt_details->subtotal))-intval(str_replace(',', '', $receipt_details->total_paid));
					@endphp
						<!-- Total Discount-->
					@if($discount > 0)
						<tr style="border:1px 0 solid black">
							<th  style="text-align:left;color: #222;font-size: 10px;">
							Discount:
							</th>
							<td class="text-right"  style="color: #222;font-size: 10px;">
								{{ number_format($discount, 2) }}
							</td>
						</tr>
					@endif
					
					<!-- Total Paid-->
					@if(!empty($receipt_details->total_paid))
						<tr style="border:1px 0 solid black">
							<th  style="text-align:left;color: #222;font-size: 10px;">
							Payable:
							</th>
							<td class="text-right"  style="color: #222;font-size: 10px;">
								{{$receipt_details->total_paid}}
							</td>
						</tr>
					@endif
            

					<!-- Change return new code -->
					@if($receipt_details->payments)
						@foreach ($receipt_details->payments as $payment)
						<tr style="border:1px 0 solid black">
							<th  style="text-align:left;color: #222;font-size: 10px;">
								{{ $payment['method'] }}:
							</th>
							<td class="text-right"  style="color: #222;font-size: 10px;">
								{{ $payment['amount'] }}
							</td>
						</tr>
						@endforeach
					@endif



			<!-- Total Due-->
			@if(!empty($receipt_details->total_due))
			<tr style="">
				<th style="text-align:left;color: #222;font-size: 10px;">
				@if($receipt_details->total_due < 0)
				Change Return:
				@else
				Due:
				@endif
				</th>
				<td class="text-right" style="text-align:left;color: #222;font-size: 10px; float: right;">
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
					
					
					@if( $return_amount > 0 )
					<tr>
						<th style="text-align:left;color: #222;font-size: 10px;">
						    Return:
						</th>
						<td class="text-right" style="text-align:left;color: #222;font-size: 10px;">
							<?php
							$ner_ret = 	$symbol .' '.$return_amount;
							?>
							{{$ner_ret}}
						</td>
					</tr>
					@endif
					<?php
					$amount = $amount -  $return_amount;
					$amount = $symbol .' '.$amount;
					?>
					<tr style=" background:#ddd;">
						<th style="widht: 50%; border-top:1px solid black !important;">
							{!! $receipt_details->total_label !!}
						</th>
						<td class="text-right" style="widht: 50%; border-top:1px solid black !important;">
							{{$amount}} Tk.
						</td>
					</tr>
				</tbody>
        	</table>
        </div>
    </div>
</div>

@if(!empty($receipt_details->footer_text))
	<div class="row">
		<div class="col-xs-12" style="text-align:center; font-size: 10px !important">
			<p>{!! $receipt_details->footer_text !!}</p>
		</div>
	</div>
@endif
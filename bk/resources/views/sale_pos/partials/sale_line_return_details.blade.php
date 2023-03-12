
    <table class="table bg-gray">
        <thead>
        <tr class="bg-green">
            <th>#</th>
            <th>{{ __('sale.product') }}</th>
            
            <th>{{ __('sale.qty') }}</th>
            <th>{{ __('sale.price_inc_tax') }}</th>
            <th>{{ __('sale.subtotal') }}</th>
        </tr>
        </thead>
    @if(!empty($return_lines))
    
    
        <tbody>
			    <?php 
			    $i=1;
			    $return_amount = 0;
			    ?>
				@foreach($return_lines as $line)
				
                        
				
				    @if($line['quantity'] != "0.00")
				    <?php 
                        $am =(int)$line['line_total'];
                        $return_amount = $return_amount + $am;
                        ?>
					<tr>
					    <td> {{$i}}
					    
					    
					    </td>
						<td >
							
                            {{$line['name']}} 
                            
                        </td>
						<td >{{$line['quantity']}} {{$line['units']}} </td>
						<td >{{$line['unit_price_inc_tax']}}</td>
						<td >{{ $line['line_total'] }}</td>
					</tr>
				
					@endif
				@endforeach
			</tbody>
		
			
   
    @endif
</table>

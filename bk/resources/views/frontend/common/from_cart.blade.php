<style type="text/css">
    .position-abs {
    height: 420px;
    overflow-x: hidden;
    overflow-y: scroll;
}

input.button-minus.dec {
    padding: 0px 7px;
    background: #429800;
    border: 1px solid #429800;
    font-weight: bold;
    color: #fff;
}
.modal-open .modal {
    overflow-x: hidden;
    /* overflow-y: auto; */
}
.quantity-field.qty-inc-dc{
    width: 80px;
    text-align: center;
    color: #222;
    border: 1px solid #429800;
}
input.button-plus.inc{
    padding: 0px 7px;
    background: #429800;
    border: 1px solid #429800;
    font-weight: bold;
    color: #fff;
}

.short-cart-info{
    padding-top: 10px;
}
.short-cart-info .form-group label{
    color: #222;
    font-size: 16px;

}
.short-cart-info .form-group .form-control{
    border-radius: 0px;

}
/*button.btn.btn-success.submit-btn-now {
    position: absolute;
    top: -15px;
    font-weight: bold;
   
    right: 15px;
}*/
.modal {
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 50%;
    transform: translate(-50%);
    z-index: 1050;
    display: none;
    overflow: hidden;
    -webkit-overflow-scrolling: touch;
    outline: 0;
}
/*@media (min-width: 768px){
    .modal-dialog {
    width: 800px;
    margin: 114px 84px;
}*/
}
@media (max-width: 768px){
   .modal {
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    transform: translate(0);
    left: 0;
    z-index: 1050;
    display: none;
    overflow: hidden;
    -webkit-overflow-scrolling: touch;
    outline: 0;
}
.position-abs {
    height: 400px;
    overflow-x: hidden;
    overflow-y: scroll;
}
.modal-dialog {
    position: relative;
    width: auto;
    margin: 10px;
    margin-top: 126px;
}
.quantity-field.qty-inc-dc{
    width: 50px;
    text-align: center;
    color: #222;
    border: 1px solid #429800;
}
}
.table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {
    padding: 8px;
    line-height: 1.42857143;
    vertical-align: middle;
    border-top: 1px solid #ddd;
}
.modal-header {
    min-height: 16.43px;
    padding: 15px;
    border-bottom: 1px solid #e5e5e5;
    background: #ff932c;
    color: #ffff;
}
.text-bling{
    animation:blinkingText 1.2s infinite;
    color: #fff;
    font-weight: bold;
    
}
@keyframes blinkingText{
    0%{     color: #fff; 
    text-shadow: 2px 2px 8px #222;   }
    49%{    color: #fff;
    text-shadow: 2px 2px 8px #222; }
    60%{    color: #222; 
        text-shadow: 2px 2px #fff;}
    99%{    color:#fff; 
   text-shadow: 2px 2px 8px #222; }
    100%{   color: #fff; 
   text-shadow: 2px 2px 8px #222;   }
}
</style>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"> </script>

<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Quick Order Page</h4>
      </div>
      <div class="modal-body">
        
        <section class="position-abs">
                <div class="text-page-blog">

                            {!! Form::open(['method'=>'post', 'url'=>'place_order_new', 'id'=>'place_order_new']) !!}

                    



                    <!-- all_product -->

                        <div style="width: 100%;overflow-x: scroll;" style="display: none;">

                            <table class="table table-bordered" style="margin-bottom: 0px;">

                            <thead>

                                <tr>

                             
                                <th>Product Name</th>
                                <th>Quantity</th>

                                <th><a type="button" class=" btn btn-success addRow"><i class="fa fa-plus"></i></a></th>
                                </tr>
                                

                            </thead>

                            <tbody id="customersDataShow">


                                            <tr>
                                                <td><input name="req_name[]" class="form-control field-validate" type="text"> </td>
                                                <td ><input name="req_qty[]" class="form-control field-validate" type="text"></td>
                                                <td><a type="button" class="btn btn-success remove_col_pro"><i class="fa fa-minus"></i></a></td>
                                            </tr>
                                         
                                     
                                           
                    </tbody>

                </table>

                </div>

                <div class="row short-cart-info">

                        <div class="form-group col-md-6">

                            <label for="firstName">Name *</label>

                            <input required type="text" placeholder="Name" class="form-control field-validate" id="firstname" name="firstname"

                                   >

                           <!--  <span class="help-block error-content" hidden>Please enter your first name</span> -->

                        </div>



                        <div class="form-group col-md-6">

                            <label for="firstName">Mobile *</label>

                            <input required type="text" placeholder="Mobile" class="form-control field-validate" id="mobile" name="mobile"

                                   >

                           <!--  <span class="help-block error-content" hidden>Please enter your mobile number</span> -->

                        </div>

                        



                        <div class="form-group col-md-12">

                            <label for="firstName">Address *</label>

                            <input required type="text" placeholder="Address" class="form-control field-validate" id="address" name="address"

                                   >

                            <!-- <span class="help-block error-content" hidden>Please enter your address</span> -->

                        </div>

                    

                    </div>
               

                

            </div>

</section>
      </div>
      <div class="modal-footer">

     
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
         <button type="submit" class="btn btn-success submit-btn-now">Submit Order</button>
      </div>
    </div>
 {!! Form::close() !!}
  </div>
</div>



</section>



<script type="text/javascript">



</script>
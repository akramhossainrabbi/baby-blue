<?php
$files = array();
$countFiles = count($files);
$smPaginationMedia = config("constant.smPaginationMedia");
?>
<div> 
    Total Media = <strong><span class="" id="media_count">{{ $countFiles }}</span></strong>
    <label for="master">
        <input type="checkbox" id="master">All Select
    </label>
        <button style="margin: 5px;" class="btn btn-danger btn-xs delete_all" data-url="">Delete All</button> 

</div>
<div class="row">
    <!-- SuperBox -->
    <div class="superbox col-sm-12 media_search_data">
        @if($countFiles>0)
            @foreach($files as $file)
                <?php
                $filename = $file->slug;
                $img = \App\SM\SM::sm_get_galary_src_data_img($filename, $file->is_private == 1 ? true : false);
                $src = $img['src'];
                $data_img = $img['data_img'];
                $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                ?>
                
                <div class="superbox-list sm_file_{{ $file->id }}">
                    <input type="checkbox" class="sub_chk" data-id="{{$file->id}}">
                    @if($file->is_private == 1)
                        <span class="private_media" title="Private File"><i class="fa fa-lock"></i></span>
                    @endif
                    <img title="{{ $file->title }}" src="{{ $src }}" data-img="{{ $data_img }}" img_id="{{ $file->id }}"
                         is_private="{{ $file->is_private }}"
                         img_slug="{{$filename}}" alt="{{ $file->alt }}"
                         ftype="{{ $extension }}"
                         caption="{{ $file->caption }}" description="{{ $file->description }}"
                         class="superbox-img">
                </div>

            @endforeach
        @else
            <div class="alert alert-warning fade in">
                <button class="close" data-dismiss="alert"><i class="fa fa-times"></i></button>
                <i class="fa-fw fa fa-warning"></i>
                <strong>{{__("media.warning")}}</strong>
                {{__("media.noMediaFileFound")}}
            </div>
        @endif
        <div class="superbox-float"></div>
    </div>
    <div class="col-sm-12 text-center" style="{{ $countFiles >= $smPaginationMedia ? '': 'display:none;' }}">
        <button class="btn btn-block btn-primary" id="sm_media_load_more"
                data-need_to_load="{{  $smPaginationMedia }}"
                data-loaded="{{ $countFiles }}"><i class="fa fa-refresh"></i> Load More
        </button>
    </div>
    <!-- /SuperBox -->
    <div class="superbox-show" style="height:300px; display: none">
    </div>
</div>
@section('footer_script') 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-confirmation/1.0.5/bootstrap-confirmation.min.js"></script> 
    <script type="text/javascript">
    $(document).ready(function () {


        $('#master').on('click', function(e) {
         if($(this).is(':checked',true))  
         {
            $(".sub_chk").prop('checked', true);  
         } else {  
            $(".sub_chk").prop('checked',false);  
         }  
        });


        $('.delete_all').on('click', function(e) {


            var allVals = [];  
            $(".sub_chk:checked").each(function() {  
                allVals.push($(this).attr('data-id'));
            });  


            if(allVals.length <=0)  
            {  
                alert("Please select row.");  
            }  else {  


                var check = confirm("Are you sure you want to delete this row?");  
                if(check == true){  


                    var join_selected_values = allVals.join(","); 


                    $.ajax({
                        url: "{{ route('deleteMultipleMedia') }}",
                        // url: $(this).data('url'),
                        type: 'get',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: 'ids='+join_selected_values,
                        success: function (data) {
                            if (data['success']) {
                                $(".sub_chk:checked").each(function() {  
                                    $(this).parents(".superbox-list").remove();
                                });
                                // alert(data['success']);
                                location.reload()
                            } else if (data['error']) {
                                alert(data['error']);
                            } else {
                                alert('Whoops Something went wrong!!');
                            }
                        },
                        error: function (data) {
                            alert(data.responseText);
                        }
                    });


                  $.each(allVals, function( index, value ) {
                      $('table tr').filter("[data-row-id='" + value + "']").remove();
                  });
                }  
            }  
        });


        $('[data-toggle=confirmation]').confirmation({
            rootSelector: '[data-toggle=confirmation]',
            onConfirm: function (event, element) {
                element.trigger('confirm');
            }
        });


        $(document).on('confirm', function (e) {
            var ele = e.target;
            e.preventDefault();


            $.ajax({
                url: ele.href,
                type: 'DELETE',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    if (data['success']) {
                        $("#" + data['tr']).slideUp("slow");
                        alert(data['success']);
                    } else if (data['error']) {
                        alert(data['error']);
                    } else {
                        alert('Whoops Something went wrong!!');
                    }
                },
                error: function (data) {
                    alert(data.responseText);
                }
            });


            return false;
        });
    });
</script>
@endsection

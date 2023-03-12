<div class="container" id="columns">
    <div class="row">
        <div class="col-sm-12">
            @if ($errors->any())
                <div class="alert alert-danger margin-top-20 s_w_message">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <i class="fa fa-warning"></i> <strong>Warning!</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
</div>
@if(Session::has("w_message"))
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="alert alert-warning margin-top-20 s_w_message" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <i class="fa fa-warning"></i> <strong>Warning!</strong> {{ Session::get("w_message") }}
                </div>
            </div>
        </div>
    </div>
    <?php
    Session::forget("w_message");
    Session::save();
    ?>
@endif
@if(Session::has("s_message"))


  
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="alert alert-success margin-top-20 s_w_message">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <i class="fa fa-check"></i> <strong>Success!</strong> {{ Session::get("s_message") }}
                </div>
            </div>
        </div>
    </div>
    <?php
    Session::forget("s_message");
    Session::save();
    ?>
@endif
@push('script')
    <script>
        window.setTimeout(function () {
            $(".s_w_message").fadeTo(500, 0).slideUp(500, function () {
                $(this).remove();
            });
        }, 5000);
    </script>
@endpush
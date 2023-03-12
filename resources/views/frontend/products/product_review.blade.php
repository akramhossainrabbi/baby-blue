@push('style')

<style>
    fieldset,
    label {
        margin: 0;
        padding: 0;
    }

    /*body {*/
    /*margin: 20px;*/
    /*}*/

    /*h1 {*/
    /*font-size: 1.5em;*/
    /*margin: 10px;*/
    /*}*/

    /****** Style Star Rating Widget *****/

    .rating {
        border: none;
        float: left;
    }

    .rating>input {
        display: none;
    }

    .rating>label:before {
        margin: 5px;
        font-size: 1.25em;
        font-family: FontAwesome;
        display: inline-block;
        content: "\f005";
    }

    .rating>.half:before {
        content: "\f089";
        position: absolute;
    }

    .rating>label {
        color: #ddd;
        float: right;
    }

    /***** CSS Magic to Highlight Stars on Hover *****/

    .rating>input:checked~label,
    /* show gold star when clicked */
    .rating:not(:checked)>label:hover,
    /* hover current star */
    .rating:not(:checked)>label:hover~label {
        color: #ff9900;
    }

    /* hover previous stars in list */

    .rating>input:checked+label:hover,
    /* hover current star when changing rating */
    .rating>input:checked~label:hover,
    .rating>label:hover~input:checked~label,
    /* lighten current selection */
    .rating>input:checked~label:hover~label {
        color: #ff9900;
    }
</style>
@endpush
<div class="container-fluid padding-area-reating">
    <div class="area-div">
        <a class="btn btn-default reating-add-btn " type="button" data-toggle="collapse" data-target="#collapseExample"
            aria-expanded="false" aria-controls="collapseExample">
            <i class="fa fa-pencil"></i> Write a Review
        </a>
        <div class="collapse" id="collapseExample">
            <div class="Review_section">
                <form class="ajaxReviewForm">
                    <div class="row">
                        <div class="col-md-12">
                           <div class="review_count">
                                {!! Form::hidden('product_id', $product->id, ['class' => 'product_id']) !!}
                                <h5 class="reating-label-ex">Select your Rating . . .</h5>
                                <div class="rating rating2">
                                    <input name="rating" id="e5" type="radio" class="product_rating" value="5">
                                    <label for="e5"></label>
                                    <input name="rating" id="e4" type="radio" class="product_rating" value="4">
                                    <label for="e4"></label>
                                    <input name="rating" id="e3" type="radio" class="product_rating" value="3">
                                    <label for="e3"></label>
                                    <input name="rating" id="e2" type="radio" class="product_rating" value="2">
                                    <label for="e2"></label>
                                    <input name="rating" id="e1" type="radio" class="product_rating" value="1">
                                    <label for="e1"></label>
                                </div>
                           </div>
                        </div>
                        <div class="col-md-12">
                            <div class="review_items">
                                <textarea required name="description" class="form-control description" id="product_review"
                                    rows="5" cols="5" style=" resize: none;"
                                    placeholder="Write Rating description..."></textarea>
                                <div class="review_submit_btn">
                                    <button class="btn btn-default submit-review ajaxReviewSubmit">Submit
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@if (Auth::check())
@else
@push('script')
<script type="text/javascript">
    $(document).ready(function () {
        $("#product_review").click(function () {
            $('.loginModal').modal('show');
        });
    });
</script>
@endpush
@endif
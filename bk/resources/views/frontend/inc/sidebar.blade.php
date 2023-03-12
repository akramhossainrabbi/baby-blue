<nav id="sidebar" style="display:none;">

    <ul>

        <h2 class="nav-head">Categories</h2>



        <?php

        $menu = array(

            'nav_wrapper' => 'ul',

            'start_class' => 'main-menu-bar',

            'link_wrapper' => 'li',

            'dropdown_class' => '',

            'subNavUlClass' => 'sub-dropdown-menu',

            'has_dropdown_wrapper_class' => 'sub-dropdown',

            'show' => TRUE

        );

        // SM::sm_get_menu($menu);

        ?>



    </ul>







</nav>





<nav id="sidebar">

    <div class="nav-header">



 <h2 class="nav-head">Categories</h2>





    </div>

    <style>

        .sub_active{

            font-weight: 700;

        }

        a.sub_active {

            background: red;

            padding: 4px;

            color: #fff;

        }

    </style>

    <ul class="list-unstyled components ">

        <!--<li class="dropdown-custom" style="margin-bottom:15px;margin-top:10px"><a href="#">NEW IN </a></li>-->



        <?php

        $subcategory_id = \App\Model\Common\Category::where('parent_id', 0)->orderby('priority', 'ASC')->get();

        foreach ($subcategory_id as $key => $item) {

            // $child_child_sub = \App\Model\Common\Category::where('parent_id', $item->id)->get();

            $child_subcategory_id = \App\Model\Common\Category::where('parent_id', $item->id)->get();

            $category_slug = Request::segment(2);


            if(!empty($child_subcategory_id) )
            {
                $all_sub = array();
                foreach($child_subcategory_id as  $cat_mamun)
                {
                    $child_child_sub = \App\Model\Common\Category::where('parent_id', $cat_mamun->id)->get();




                    if(!empty($child_child_sub)  )
                    {

                        foreach($child_child_sub as  $cat_mamun_child)
                        {

                                array_push($all_sub, $cat_mamun->id);
                                array_push($all_sub, $cat_mamun_child->id);


                        }
                    }
                    else
                    {
                        array_push($all_sub, $cat_mamun->id);
                    }


                }


                if (in_array($category_slug,$all_sub) || $category_slug == $item->id) {

                    $show = 'show';

                } else {

                    $show = '';

                }


                 if (in_array($category_slug,$all_sub) || $category_slug == $item->id) {

                        $sub_active = 'sub_active';

                    } else {

                        $sub_active = '';

                    }
            }

            else
            {
                if ($category_slug == $item->id) {

                $show = 'show';

                } else {

                    $show = '';

                }

                 if ($item->id == $category_slug) {

                        $sub_active = 'sub_active';

                    } else {

                        $sub_active = '';

                    }
            }



            ?>



            <li class="active link_wrapper">

                @if(empty($child_subcategory_id) )

                <!-- <a href="#homeSubmenu_1{{$key}}" onclick="javascript:window.location.href = '<?php echo url('category_list/' . $item->slug) ?>'; return true;"  data-toggle="collapse" aria-expanded="false" class="dropdown-toggle dropdown-custom {{ $sub_active }}">{{$item->name}}</a> -->

                <a href="#homeSubmenu_1{{$key}}" onclick="javascript:window.location.href = '<?php echo url('category_list/' . $item->id) ?>'; return true;"  data-toggle="collapse" aria-expanded="false" class="dropdown-toggle dropdown-custom {{ $show }}">{{$item->name}}</a>

                @else

                <?php

                if (Request::is('/')) {

                    $onclick = 'javascript:window.location.href = "' . url('category_list/' . $item->id) . '"; return true;';

                } else {

                    $onclick = 'javascript:window.location.href = "' . url('category_list/' . $item->id) . '"; return true;';

                }

                ?>

                <a href="#homeSubmenu_1{{$key}}" onclick="{{$onclick}}" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle dropdown-custom {{ $sub_active }}">{{$item->name}}</a>

                @endif

                <ul class="collapse list-unstyled <?php echo $show ?>" id="homeSubmenu_1{{$key}}">

                    <?php

                    foreach ($child_subcategory_id as $key => $sub_item) {


                                    $all_sub = array();

                                    $child_child_sub = \App\Model\Common\Category::where('parent_id', $sub_item->id)->get();




                                    if(!empty($child_child_sub)  )
                                    {

                                        foreach($child_child_sub as  $cat_mamun_child)
                                        {

                                                array_push($all_sub, $sub_item->id);
                                                array_push($all_sub, $cat_mamun_child->id);


                                        }
                                    }
                                    else
                                    {
                                        array_push($all_sub, $sub_item->id);
                                    }




                                if (in_array($category_slug,$all_sub) || $category_slug == $sub_item->id) {

                                    $show1 = 'show';

                                } else {

                                    $show1 = '';

                                }


                                 if (in_array($category_slug,$all_sub) || $category_slug == $sub_item->id) {

                                        $sub_active = 'sub_active';

                                    } else {

                                        $sub_active = '';

                                    }


                    



                          $child_child_subcategory_id = \App\Model\Common\Category::where('parent_id', $sub_item->id)->get();

                          if(count($child_child_subcategory_id)>0){

                              $url = url('category_list/' . $sub_item->id);

                          }else{

                               $url = url('category_list/'.$sub_item->id);

                          }


                        ?>

                        <li class=" list-style-custom {{$sub_active}}"><a class="{{$sub_active}}" href="{{ $url }}">{{$sub_item->name}}</a>

                       @if(count($child_child_subcategory_id)>0)

                           <ul class="collapse list-unstyled <?php echo $show1 ?>" id="homeSubmenu_1{{$key}}">

                                <?php

                                foreach ($child_child_subcategory_id as $key => $sub_sub_item) {

                                    if ($sub_sub_item->id == $category_slug) {

                                        $sub_active1 = 'sub_active';

                                    } else {

                                        $sub_active1 = '';

                                    }

                                      $child_child_subcategory_id = \App\Model\Common\Category::where('parent_id', $sub_sub_item->id)->get();

                                      if(count($child_child_subcategory_id)>0){

                                          $url1 = url('category_list/' . $sub_sub_item->id);

                                      }else{

                                           $url1 = url('category_list/'.$sub_sub_item->id);

                                      }

                                    ?>

                                     <li class=" list-style-custom {{$sub_active1}}"> <a class="{{$sub_active1}}" style="font-size:9px;" href="{{ $url1 }}">{{$sub_sub_item->name}}</a></li>

                                <?php } ?>

                             </ul>

                        @endif

                        </li>

                    <?php } ?>

                </ul>

            </li>

        <?php } ?>



    </ul>





</nav>

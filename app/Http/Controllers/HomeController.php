<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Subscription;
use App\Models\Product_images;
use App\Models\Category;
use App\Models\Lottery;
use App\Models\Page;
use App\Models\LotteryContestent;
use App\Models\Blog;
use App\Models\Testimonial;
use App\Models\PromotionPartner;
use App\Models\Slider;
use App\Models\ContactUs;
use DB;
class HomeController extends Controller
{

    public function __construct()
    {
        // $this->middleware('auth');
        // $this->middleware(['auth', 'verified']);
    }
    public function index()
    {
        $lotteryData = Lottery::with(['lottery_contestent'])
                            ->select('lotteries.*','lotteries.id as lotteryId','lottery_contestents.*',
                                    'lottery_contestents.id as contestentsId','lotteries.total_lots as created_lots')
                            ->selectRaw('COUNT(lottery_contestents.lottery_id) as totalClients')
                            ->leftjoin('lottery_contestents','lotteries.id','lottery_id')
                            ->groupBy('lotteries.id','lottery_contestents.lottery_id')
                            ->orderBy('totalClients','desc')
                            ->limit(3)
                            ->get();
        $sliderData = Slider::all();
        $blogData = Blog::select('id','title','short_desc','post_img','created_at','post_name')
        ->orderBy('blogs.id', 'DESC')
        ->limit('6')
        ->get();
        $testimonialData = Testimonial::orderBy('id', 'DESC')->limit('3')->get();
        return view('welcome',compact('lotteryData','blogData','testimonialData','sliderData'));
    }
    public function save_contact_us(Request $request)
    {
        $lottery_id = ContactUs::create([
            "name" => $request->get("name"),
            "email"=>$request->get("email"),
            "phone"=>$request->get('phone'),
            "betreff"=>$request->get('betreff'),
            "msg"=>$request->get('msg'),
            "created_at"=>""
        ]);
        return redirect()->back();
    }
    public function ceo()
    {
        return view('pages.comming_soon');
    }
    public function partner($page = null)
    {
        $page = Page::where('page_slug',$page)->firstOrFail();
        return view('pages.terms',compact('page'));
    }
    public function howitworks()
    {
        return view('pages.comming_soon');
    }
    public function impresum()
    {
        return view('pages.impresum');
    }
    public function pages($page,Request $request)
    {
        $promotionsResult='';
        $categories='';
        $pageName=$page;
        $page = Page::where('page_slug',$page)->firstOrFail();
        if($pageName=='promotions')
        {
            
           
            $categories = Category::where('category_for','promo_partners')->orderby('name','asc')->get();
            $promotionsResult = PromotionPartner::select('promotion_partners.*','promotion_partners.id as promotion_id',
                                                        'promotion_partners.price as p_price',
                                                        'promotion_partners.discount_amount as d_amount',
                                                        'promotion_partners.start_date as p_start',
                                                        'promotion_partners.end_date','promotion_partners.reference_website',
                                                        'promotion_partners.name as promo_name','promotion_partners.short_description')
                                                        ->where('promotion_partners.name',"!="," ");
            if($request->input('cate'))
            {
                $promotionsResult = $promotionsResult->where('promotion_partners.type',$request->input('cate'));
            }
            if ($request->has('search')) 
            {
                $keyWord = $request->input('search');
                if($keyWord!="")
                    $promotionsResult = $promotionsResult->where('promotion_partners.name','like','%'.$keyWord.'%');
            }
            // dd($request->has('category'));
            if ($request->has('category')) 
            {
                $category = $request->input('category');
                if($category!="")
                    $promotionsResult = $promotionsResult->where('category_id',$category);
            }
            
            // dd($promotionsResult->toSql());
            // $promotionsResult=$promotionsResult->leftjoin('badges','badges.id','promotion_partners.type');
            $promotionsResult = $promotionsResult->get();
            // dd($promotionsResult);
        }
            
        return view('pages.terms',compact('page','pageName','promotionsResult','categories'));
    }

    public function inventroAcadmy()
    {
        return view('pages.comming_soon');
    }
    public function aboutUs()
    {
        return view('pages.comming_soon');
    }
    public function mediaInfo()
    {
        return view('pages.comming_soon');
    }
    public function contactUs()
    {
        return view('pages.contactus');
    }
    public function lotteryThings()
    {
        DB::enableQueryLog();
        $category = Category::where('category_for','pro')->get();
        $lotteryData = Lottery::with(['lottery_contestent'])
                                ->select('lotteries.*','lotteries.id as lotteryId','lottery_contestents.*',
                                        'lottery_contestents.id as contestentsId','lotteries.total_lots as created_lots')
                                ->selectRaw('COUNT(lottery_contestents.lottery_id) as totalClients')
                                ->leftjoin('lottery_contestents','lotteries.id','lottery_id')
                                ->groupBy('lotteries.id','lottery_contestents.lottery_id')
                                ->orderBy('totalClients','desc')
                                ->limit(12)
                                ->get();
        return view('pages.lottery_things',compact('lotteryData','category'));
    }
    public function unsubscribe(Request $request)
    {
        $unsbscribe = Subscription::where('email',$request->email)->first();
        if($unsbscribe)
        {
            $unsbscribe->status = 1;
            $unsbscribe->save();
            return redirect('/')->with('success','You are unsubscribed!');
        }
        else{
            return redirect('/')->with('success','You are unsubscribed!');
        }
        
    }
}

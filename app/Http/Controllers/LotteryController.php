<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Lottery;
use App\Models\Product;
use App\Models\LotteryContestent;
use App\Models\TeamSpend;
use App\Models\UserDocument;
use App\Models\UserProfile;
use App\Models\User;
use App\Models\Vallet;
use App\Models\Category;
use App\Models\BonusTaler;
use App\Models\InvitationList;
use Session;
use Auth;
use DB;
use Carbon\Carbon;
use App\Models\Testimonial;
use function GuzzleHttp\json_encode;

class LotteryController extends Controller
{

    public function __construct()
    {

        // $this->middleware('auth');
        // $this->middleware(['auth', 'verified']);
    }
    public function index()
    {
        $lotteryData = Lottery::with(['lottery_contestent'])
                        ->select('lotteries.*','lotteries.id as lotteryId',
                                'lotteries.total_lots as created_lots')
                        ->selectRaw('COUNT(lottery_contestents.lottery_id) as totalClients')
                        ->leftjoin('lottery_contestents','lotteries.id','lottery_id')
                        ->groupBy('lotteries.id','lottery_contestents.lottery_id')
                        ->orderBy('totalClients','desc')
                        ->paginate(18);
        $category = Category::where('category_for','pro')->orderBy('name','asc')->get();
        $testimonialData = Testimonial::orderBy('id', 'DESC')->get();
        return view('lotteries.index',compact('lotteryData','testimonialData','category'));
    }
    public function detail($id)
    {
        $user = '';
        if (Auth::guard('client')->check()){
            $user = Auth::guard('client');
        }
        Session::flash('route', 'lottery/detail/'.$id);
        $lotteryData = Lottery::select('lotteries.*','lotteries.total_lots as totalLots')->where('id',$id)->firstOrFail();
        $lotteryData1 = json_decode($lotteryData);
        $lotteryData->views=$lotteryData->views+1;
        $lotteryData->save();
        return view('lotteries.detail',compact('lotteryData','user','lotteryData1'));
    }
    Public function lotterPurchaseBonus($request)
    {
        $qty = $request->get('qty');
        $bonus = $request->get('bonusTaler');
        $user_id = Auth::guard('client')->user()->id;
        $amount = $request->get('amount');

        $total_lots = $request->get('total_lots');
        $lottery_id = $request->get('lottery_id');
        
        $checkTotalCredit = BonusTaler::where('user_id',$user_id)->orderBy('id','desc')->first();
        $checkTotal = Vallet::where('user_id',$user_id)->orderBy('id','desc')->first();
        $remainingTotalBalance = $checkTotalCredit->total_available_balance-$amount;
        $balance = "-".$amount;
        $previousBalance = $checkTotalCredit->total_available_balance;

        if($checkTotalCredit && $checkTotalCredit->total_available_balance >= $amount)
        {

            $bonus_taler = array('bonus_taler'=>'yes','amount'=>$amount);

            $remainingTotalBalance = $checkTotalCredit->total_available_balance-$amount;
            $balance = "-".$amount;
            $previousBalance = $checkTotalCredit->total_available_balance;

            $previousBalance = round($previousBalance,2);
            $remainingTotalBalance = round($remainingTotalBalance,2);
            
            
            $bonus_taler_id = BonusTaler::create([
                "user_id" => $user_id,
                "credit"=>'0.00',
                "balance"=>$balance.".00",
                "pre_balance"=> $previousBalance,
                "total_available_balance"=>round($remainingTotalBalance,2),
                "created_at"=>Carbon::now(),
                "updated_at"=>Carbon::now(),
                "status"=>"approved",
                'options'=>array('bonus_taler'=>'none')
            ]);
           if($checkTotal)
           {
               $credit = $checkTotal->credit;
               $balance = $checkTotal->balance;
               $pre_balance = $checkTotal->pre_balance;
               $total_available_balance = $checkTotal->total_available_balance;
           }
           else
           {
                $credit = 0;
                $balance = 0;
                $pre_balance = 0;
                $total_available_balance = 0;
           }
            $vallet_id = Vallet::create([
                "user_id" => $user_id,
                "credit"=>$credit,
                "balance"=>$balance,
                "pre_balance"=> $pre_balance,
                "total_available_balance"=>$total_available_balance,
                "created_at"=>Carbon::now(),
                "updated_at"=>Carbon::now(),
                "status"=>"approved",
                'options'=>$bonus_taler,
                'type'=>'bonus'
            ]);

            $i=1;
            $numbers = '';
            $a = array("red");
            for($i=1;$i<=$qty;$i++)
            {
                $lot_number = (rand(10000,1000));
                $numbers.=$lot_number.",";
                LotteryContestent::create([
                    "lottery_id" =>$lottery_id,
                    "user_id"=>$user_id,
                    "lot_number"=>$lot_number,
                    "status"=> '0',
                    "vallet_id"=>$vallet_id->id,
                    "created_at"=>Carbon::now(),
                    "updated_at"=>Carbon::now()
                ]);
                $lot_number="";
            }
             //team spend logs here 
             $this->teamSpend($request);
            return $response = json_encode(array("status"=>"success","message"=>"Successfull","type"=>'Bonus Taler','numbers'=>rtrim($numbers,","),'totl_spent'=>$amount,"total_available"=>$checkTotalCredit->total_available_balance));
        }
        else
        {
            $bonusTaler = BonusTaler::where('user_id',$user_id)->orderBy('id','desc')->first();
            if($bonusTaler->total_available_balance>=$amount)
            {
                $response = json_encode(array("status"=>"error","bonus_use"=>"yes","message"=>"Insufficiant Balance!",'bonus_taler'=>"Use  your bonus talers &nbsp;".$bonusTaler->total_available_balance.' <a id="bonus" onclick="puchaseLottery(0)" href="#" class="redeem">Use Bonus Talers</a>','amount'=>$bonusTaler->total_available_balance));
            }
            else
            {
                $response = json_encode(array("status"=>"error","bonus_use"=>"no","message"=>"Insufficiant Balance!",'bonus_taler'=>"Bonus Talers ".$bonusTaler->total_available_balance));
            }
            
            return $response;
        }


    }
    public function purchaseLottery(Request $request)
    {
        $qty = $request->get('qty');
        $bonus = $request->get('bonusTaler');
        $user_id = Auth::guard('client')->user()->id;
        $amount = $request->get('amount');
        $total_lots = $request->get('total_lots');
        $type = $request->get('type');
        $lottery_id = $request->get('lottery_id');

            
        if($qty > $total_lots)
            return $response = json_encode(array("status"=>"error","message"=>"Lots must be less than".$total_lots));

        if($bonus=='yes')
            return $this->lotterPurchaseBonus($request);

        DB::enableQueryLog();
        $checkTotalCredit = Vallet::where('user_id',$user_id)->orderBy('id','desc')->first();
        
        // dd(DB::getQueryLog());
        if($checkTotalCredit && $checkTotalCredit->total_available_balance >= $amount)
        {
            
            $remainingTotalBalance = $checkTotalCredit->total_available_balance-$amount;
            $balance = "-".$amount;
            $previousBalance = $checkTotalCredit->total_available_balance;


            $vallet_id = Vallet::create([
                "user_id" => $user_id,
                "credit"=>'0.00',
                "balance"=>$balance.".00",
                "pre_balance"=> $previousBalance,
                "total_available_balance"=>$remainingTotalBalance,
                "created_at"=>Carbon::now(),
                "updated_at"=>Carbon::now(),
                "status"=>"approved",
                "type"=>'credit'
            ]);
            $i=1;
            $numbers = '';
            $a = array("red");
            for($i=1;$i<=$qty;$i++)
            {
                $lot_number = (rand(10000,1000));
                $numbers.=$lot_number.",";
                LotteryContestent::create([
                    "lottery_id" =>$lottery_id,
                    "user_id"=>$user_id,
                    "lot_number"=>$lot_number,
                    "status"=> '0',
                    "vallet_id"=>$vallet_id->id,
                    "created_at"=>Carbon::now(),
                    "updated_at"=>Carbon::now()
                ]);
                $lot_number="";
            }
            //team spend logs here 
            $this->teamSpend($request);
            $response = json_encode(array("status"=>"success","message"=>"Successfull","type"=>'Bonus Taler','numbers'=>rtrim($numbers,","),'totl_spent'=>$amount,"total_available"=>$checkTotalCredit->total_available_balance));
        }
        else
        {

            $bonusTaler = BonusTaler::where('user_id',$user_id)->orderBy('id','desc')->first();
            if($bonusTaler && $bonusTaler->total_available_balance >= $amount)
            {
                $response = json_encode(array("status"=>"error","bonus_use"=>"yes","message"=>"Insufficiant Balance!",'bonus_taler'=>"Use  your bonus talers &nbsp;".$bonusTaler->total_available_balance.' <a id="bonus" onclick="puchaseLottery(0,'."bonus".')" href="#" class="redeem">Use Bonus Talers</a>','amount'=>$bonusTaler->total_available_balance));
            }
            else
            {
                $response = json_encode(array("status"=>"error","bonus_use"=>"no","message"=>"Insufficiant Balance!",'bonus_taler'=>''));
            }
        }
        return $response;
    }
    public function teamSpend($request)
    {
        $qty = $request->get('qty');
        $bonus = $request->get('bonusTaler');
        $user_id = Auth::guard('client')->user()->id;
        $amount = $request->get('amount');
        $total_lots = $request->get('total_lots');
        $type = $request->get('type');
        $lottery_id = $request->get('lottery_id');
        
        //check for team spend 
        $invitation_link = InvitationList::where('reciver_id',$user_id)->first();
        if($invitation_link)
        {
            $percentToGet = 10;
            $percentInDecimal = $percentToGet / 100;
            $balancePercent = $percentInDecimal * $amount;

            $checkTotalCredit = BonusTaler::where('user_id',$invitation_link->sender_id)->orderBy('id','desc')->first();
            if( BonusTaler::where('user_id',$invitation_link->sender_id)->count()==0)
            {
                $remainingTotalBalance = $balancePercent;
                $balance = $balancePercent;
                $previousBalance = "";
            }
            else
            {
                $remainingTotalBalance = $checkTotalCredit->total_available_balance+$balancePercent;
                $balance = $balancePercent;
                $previousBalance = $checkTotalCredit->total_available_balance;
            }

            $vallet_id = BonusTaler::create([
                "user_id" => $invitation_link->sender_id,
                "credit"=>'0.00',
                "balance"=>round($balance,2).".00",
                "pre_balance"=> round($previousBalance,2),
                "total_available_balance"=>round($remainingTotalBalance,2),
                "created_at"=>Carbon::now(),
                "updated_at"=>Carbon::now(),
                'type'=>'bonus',
                'status'=>'approved'
            ]);
            $bonus_taler_id = TeamSpend::create([
                "sender_id" => $user_id,
                "reciver_id"=>$invitation_link->sender_id,
                "amount"=>$balance.".00"
            ]);
        }
    }
    public function userPurchasedLotteries()
    {
        $user_id = Auth::guard('client')->user()->id;
        $lotteryData = LotteryContestent::where('lottery_contestents.user_id',$user_id)
                                        ->select('lottery_contestents.*','vallets.*')
                                        ->leftjoin('vallets','vallets.id','lottery_contestents.vallet_id')
                                        ->groupBy('lottery_id')
                                        ->selectRaw('COUNT(vallets.balance) as totalBalance')
                                        ->get();
        $route='lotteries';
        $userData = User::where('users.id',$user_id)->first();
        $userDocuments = UserDocument::where('user_id',$user_id)->get();
        $userProfile = UserProfile::with("country_name","state_name")->where('user_id',$user_id)->first();
        $userInfo = array("user_data"=>$userData,"user_profile"=>$userProfile,"user_documents"=>$userDocuments);
        $userData = User::where('users.id',$user_id)->first();
        return view('wallet.lotteries',compact('lotteryData','userData','userInfo','route'));
    }
    public function search(Request $request)
    {
        $categoryID = $request->post('category');
        $searchString = $request->post('search');
        DB::enableQueryLog(); // Enable query log
        $lotteryData = Lottery::with(['lottery_contestent','product'])
                            ->select('lotteries.*','lotteries.id as lotteryId',
                                    'lotteries.total_lots as created_lots')
                            ->selectRaw('COUNT(lottery_contestents.lottery_id) as totalClients')
                            ->leftjoin('lottery_contestents','lotteries.id','lottery_id')
                            ->leftjoin('products','products.id','lotteries.pro_id')
                            ->groupBy('lotteries.id','lottery_contestents.lottery_id')
                            ->orderBy('totalClients','desc');
        if($categoryID!="")
        {
            $lotteryData = $lotteryData->where('products.cat_id',"=",$categoryID);
        }
        if($searchString!="")
        {
        
            $lotteryData = $lotteryData->where('lotteries.name',"like","%$searchString%");
        }
        $lotteryData = $lotteryData->paginate(18);
        $category = Category::where('category_for','pro')->get();
        $testimonialData = Testimonial::orderBy('id', 'DESC')->get();
        return view('lotteries.index',compact('lotteryData','testimonialData','category'));
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Order;
use App\Models\Product;
use App\Models\Transaction;

use App\Models\User;
use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    //
    public function index()
    {
        $users = User::all();
        $orsers = Order::all();
        $comments = Comment::all();
        $month = 6;
        $products = Product::all();
        $successTransactions = Transaction::getdata($month,1);
        $successTransactionsChart = $this->chart($successTransactions,$month);
        $unsuccessTransactions = Transaction::getdata($month,0);

        $unsuccessTransactionsChart = $this->chart($unsuccessTransactions,$month);

        return view('admin.dashboard',[
            'users'=>$users,
            'orders'=>$orsers,
            'comments'=>$comments,
            'products'=>$products,
            'successTransactions'=>array_values($successTransactionsChart),
            'unsuccessTransactions'=>array_values($unsuccessTransactionsChart),
            'labels'=>array_keys($successTransactionsChart),
            'transactionCount'=>[$successTransactions->count(),$unsuccessTransactions->count()]
        ]);
    }

    public function chart($transaction,$month)
    {
        $result=[];
        $monthName =  $transaction->map(function ($item){
            return verta($item->created_at)->format('%B %y');
        });
        $amount =  $transaction->map(function ($item){
            return $item->amount;
        });

        foreach ($monthName as $i=>$v){
            if (!isset($result[$v])){
                $result[$v]=0;
            }
            $result[$v]+=$amount[$i];
        }
        if (count($result)!=$month){
            for ($i=0;$i<$month;$i++){
                $monthName = verta()->subMonths($i)->format('%B %y');
                $shamsiMonths[$monthName]=0;
            }
            return array_reverse( array_merge($shamsiMonths,$result));
        }
        return $result;
    }
}

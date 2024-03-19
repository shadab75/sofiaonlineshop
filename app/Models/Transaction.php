<?php

namespace App\Models;

use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $table = "transactions";
    protected $guarded=[];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeGetData($query,$month,$status)
    {
        $v = Verta()->startMonth()->subMonths($month-1);
        $date =Verta::jalaliToGregorian($v->year,$v->month,$v->day);
        return $query->where('created_at','>',Carbon::create($date[0],$date[1],$date[2],0,0,0))->where('status','=',$status)->get();;
    }
    public function getStatusAttribute($status)
    {
        switch ($status){
            case '0';
                $status='ناموفق';
                break;
            case '1';
                $status = 'موفق';
                break;
        }
        return $status;
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}

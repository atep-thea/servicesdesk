<?php

namespace App\Helper;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\TimelineDetail;
use App\Timeline;
use App\AssignmentHistory;

class Common
{
    public static function get_time_ago($str_time)
    {
        $time = strtotime($str_time);
        $time_difference = time() - $time;

        if ($time_difference < 1) {
            return 'less than 1 second ago';
        }
        $condition = array(
            12 * 30 * 24 * 60 * 60 =>  'year',
            30 * 24 * 60 * 60       =>  'month',
            24 * 60 * 60            =>  'day',
            60 * 60                 =>  'hour',
            60                      =>  'minute',
            1                       =>  'second'
        );

        foreach ($condition as $secs => $str) {
            $d = $time_difference / $secs;

            if ($d >= 1) {
                $t = round($d);
                return 'about ' . $t . ' ' . $str . ($t > 1 ? 's' : '') . ' ago';
            }
        }
    }

    public static function change_date($str_date)
    {
        return date('j F. Y', strtotime($str_date));
    }

    public static function update_timeline($type,$description,$status,$tiket_id,$user_id)
    {
        $date = date('Y-m-d');
        $timeline = Timeline::where('tiket_id',$tiket_id)->where('timeline_date',$date)->first();
        if ($timeline === null)
        {
            $timeline = Timeline::create(['timeline_date'=>$date,'tiket_id'=>$tiket_id]);
        }

        TimelineDetail::create(['description' => $description, 
                'status' => $status, 'user_id' => $user_id,'type'=>$type,'timeline_id'=>$timeline->id]);
    }

    public static function addAssignmentHistory($pelayanan_id,$user_id)
    {
        AssignmentHistory::create(['pelayanan_kode_tiket'=>$pelayanan_id,$user_id]);
    }

}

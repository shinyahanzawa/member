<?php
/*
 * ファイルパス：C:\xampp\htdocs\member\master\initMaster.class.php
 * ファイル名：initMaster.class.php
 */
namespace member\master;
class initMaster
{
    public static function getDate()
    {
        $yearArr = [];
        $monthArr = [];
        $dayArr = [];
        $next_year = date('Y') + 1;
        // 年を作成
        for ($i = 1900; $i < $next_year; $i ++) {
            $year = sprintf("%04d", $i);
            $yearArr[$year] = $year . 'year';
        }
        // 月を作成
        for ($i = 1; $i < 13; $i ++) {
            $month = sprintf("%02d", $i);
            $monthArr[$month] = $month . 'month';
        }
        // 日を作成
        for ($i = 1; $i < 32; $i ++) {
            $day = sprintf("%02d", $i);
            $dayArr[$day] = $day . 'day';
        }

        return [$yearArr, $monthArr, $dayArr];
    }

    public static function getSex()
    {
        $sexArr = ['1' => 'male', '2' => 'female'];
        return $sexArr;
    }

    public static function getTrafficWay()
    {
        $trafficArr = ['Walking', 'Bicycle', 'Bus', 'Train', 'Cars and Bikes'];
        return $trafficArr;
    }
}

<?php
namespace App\Helpers;

Class DateFunctionHelper{
    
    public function converTimeZoneCenter ($dateTime, $timezone = 'Asia/Hong_Kong') {
        $date = new \DateTime($dateTime, new \DateTimeZone('UTC'));
        $date->format('Y-m-d H:i:sP');
        $date->setTimezone(new \DateTimeZone($timezone));
        return $date->format('Y-m-d H:i:s');
    }
    
    public function monthCount($monthFrom, $monthTo){
        $fromYear = date("Y", strtotime($monthFrom));
        $fromMonth = date("m", strtotime($monthFrom));
        $toYear = date("Y", strtotime($monthTo));
        $toMonth = date("m", strtotime($monthTo));
        if ($fromYear == $toYear) {
            return ($toMonth-$fromMonth)+1;
        } else {
            return (12-$fromMonth)+1+$toMonth;
        }
    }
}
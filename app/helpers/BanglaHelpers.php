<?php

if (!function_exists('banglaMonth')) {
    /**
     * Convert English month to Bangla month name
     */
    function banglaMonth($carbonDate)
    {
        $en = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        $bn = ['জানুয়ারি', 'ফেব্রুয়ারি', 'মার্চ', 'এপ্রিল', 'মে', 'জুন', 'জুলাই', 'আগস্ট', 'সেপ্টেম্বর', 'অক্টোবর', 'নভেম্বর', 'ডিসেম্বর'];

        $monthName = $carbonDate->format('F'); // English month
        $key = array_search($monthName, $en);

        return $bn[$key] ?? $monthName;
    }
}

if (!function_exists('bn_num')) {
    /**
     * Convert numbers to Bangla digits
     */
    function bn_num($number)
    {
        $en = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $bn = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];

        return str_replace($en, $bn, $number);
    }
}

if (!function_exists('banglaWeekDays')) {
    /**
     * Return Bangla names for weekdays
     * $short = true => return short names like ['সোম','মঙ্গল', ...]
     */
    function banglaWeekDays($short = false)
    {
        $full = ['Sunday' => 'রবিবার', 'Monday' => 'সোমবার', 'Tuesday' => 'মঙ্গলবার', 'Wednesday' => 'বুধবার', 'Thursday' => 'বৃহস্পতিবার', 'Friday' => 'শুক্রবার', 'Saturday' => 'শনিবার'];
        $shortNames = ['Sunday' => 'রবি', 'Monday' => 'সোম', 'Tuesday' => 'মঙ্গল', 'Wednesday' => 'বুধ', 'Thursday' => 'বৃহস্পতি', 'Friday' => 'শুক্র', 'Saturday' => 'শনি'];

        return $short ? $shortNames : $full;
    }
}
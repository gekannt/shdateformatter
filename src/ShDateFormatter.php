<?php

/*
 *   Created on: Sep 9, 2016   5:46:38 PM
 *   @copyright (c) Apotheke - All Rights Reserved
 *  2016, Alexander Shulzhenko,  contact@alexshulzhenko.ru
 */

namespace Gekannt;

use DateTime;

class ShDateFormatter
{

    const ONE_WEEK_NUMBER_OF_DAYS = 7;
    const EMPTY_DATE = '-';
    const EXPIRE_ENDLESS = '01.01.2099';
    const MIN_DATE_LENGTH = 3;

    public static function getPreviousYear()
    {
        static $previousYear = false;

        if (!$previousYear)
        {
            $previousYear = (new DateTime)->format('Y') - 1;
        }

        return $previousYear;
    }

    public static function getCurrentYear()
    {
        return (new DateTime)->format('Y');
    }

    public static function getCurrentMonth()
    {
        return (new DateTime)->format('m');
    }

    public static function getCurrentDay()
    {
        return (new DateTime)->format('d');
    }

    /**
     * For human , not for storing
     * @return type
     */
    public static function getCurrentDateTime()
    {
        return (new DateTime)->format('d.m.Y H:i:s');
    }

    /**
     * In format  Y-m-d
     * 
     * @return type
     */
    public static function getTodayDate()
    {
        return (new DateTime('today'))->format('Y-m-d');
    }

    public static function getDateTimeToday()
    {
        return self::getDateCurrentTimeStampForMysql();
//        return (new DateTime('today'))->format('Y-m-d H:i:s');
    }

    public static function getFirstDayOfMonth()
    {
        return (new DateTime('today'))->format('Y-m-01');
    }

    public static function getFirstDayOfMonthHuman()
    {
        return (new DateTime('today'))->format('01-m-Y');
    }

    public function getNhourAwayDate($numberOfHours, $direction = '-',
                                     $currentDate = 'now')
    {
        if (!$currentDate)
        {
            return self::EMPTY_DATE;
        }

        return (new DateTime($currentDate))->modify("$direction$numberOfHours hour")->format('Y-m-d H:i:s');
    }

    /**
     * Returns date that is distant a specifed $numberOfMonths days away current day
     * 
     * @param type $numberOfDays   - distance in day
     * @param type $direction  -   + means future, - means past time
     * @param type $currentDate  - date from which calculation should start
     * @return type
     */
    public static function getNdayAwayDate($numberOfDays, $direction = '+',
                                           $currentDate = 'now')
    {
        if (!$currentDate)
        {
            return self::EMPTY_DATE;
        }

        return (new DateTime($currentDate))->modify("$direction$numberOfDays day")->format('Y-m-d');
    }

    /**
     * Month can contain different number of days, so this function CANNOT be replaced by getNdayAwayDate
     * 
     * @param type $numberOfMonths
     * @param type $currentDate
     * @return type
     * 
     */
    public static function getNmonthAgoDate($numberOfMonths, $currentDate = 'now')
    {
        return (new DateTime($currentDate))->modify("-$numberOfMonths month")->format('Y-m-d');
    }

    /**
     * Returns yesterdays date, 
     * syntactic sugar for   getNdayAwayDate function
     * 
     * 
     * @param type $yesterday
     * @return type
     */
    public static function getYesterdayDate($yesterday = false)
    {
        if (!$yesterday)
        {
            return (new DateTime('yesterday'))->format('Y-m-d');
        }

        return (new DateTime($yesterday))->modify('-1 day')->format('Y-m-d');
    }

    /**
     * Outputs the current date and appends messages before and after
     * 
     * @param type $additionalMessageBefore
     * @param type $additionalMessageAfter
     */
    public static function showCurrentDate($additionalMessageBefore = '',
                                           $additionalMessageAfter = '')
    {
        echo $additionalMessageBefore . '  ' . date('Y-m-d H:i:s') . ' ' . $additionalMessageAfter . EOL;
    }

    /**
     * Retrieves the date
     * 
     * @return type
     */
    public static function getDateCurrentTimeStampForMysql()
    {
        return date('Y-m-d H:i:s');
    }

    public static function getDatetimeForMysqlRoundedToHour()
    {
        return (new DateTime)->format('Y-m-d H:00:00');
    }

    public static function formatDateToHumanDate($date)
    {


        if (!$date || $date == self::EMPTY_DATE)
        {

            return self::EMPTY_DATE;
        }

        return date('d.m.Y', strtotime($date));
    }

    public static function formatDateToHumanDateMini($date)
    {
        if (!$date)
        {
            return self::EMPTY_DATE;
        }

        return date('d.m.y', strtotime($date));
    }

    public static function formatDateTimeToHumanDateTime($date)
    {
        if (!$date)
        {
            return false;
        }

        return date('d.m.Y H:i:s', strtotime($date));
    }

    public static function formatDateHumanToDateInternal($date)
    {
        if (!$date)
        {
            return false;
        }

        return date('Y-m-d', strtotime($date));
    }

    public static function formatDateTimeHumanToDateTimeInternal($date)
    {
        if (!$date)
        {
            return false;
        }

        return date('Y-m-d H:i:s', strtotime($date));
    }

    public static function formatDateToAnotherFormat($date, $sourceFormat, $outputFormat)
    {
        $myDateTime = DateTime::createFromFormat($sourceFormat, $date);

        return $myDateTime->format($outputFormat);
    }

    public static function stripSeconds($dateTimeInput, $format = 'H:i d.m.Y')
    {

        if (self::validateDateTime($dateTimeInput))
        {
            return (new DateTime($dateTimeInput))->format($format);
        }


        return self::EMPTY_DATE;
        ;
    }

    /**
     * Formats datetime to date
     * @param type $dateInput
     * @return type
     */
    public static function getDateFromDatetime($dateInput)
    {
        return ( new DateTime($dateInput))->format('Y-m-d');
    }

    public static function validateDateTime($date, $format = 'Y-m-d H:i:s')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    /**
     * Returns integer
     * 
     * @return type
     */
    public static function getWeekNumber()
    {
        $date = new DateTime(self::getTodayDate());
        return $date->format("W");
    }

}

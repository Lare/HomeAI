<?php
/**
 *  \Util\Dates.php
 *
 *  @package    HomeAI
 *  @subpackage Util
 *  @category   Date&Time
 *
 *  @author  Lare
 *  @copyright  Lauri Laukkarinen
 */
namespace Util;

defined('HOMEAI_MAINFILE') OR die('No direct access allowed.');
/**
 *  Dates -class
 *
 *  @package    HomeAI
 *  @subpackage Util
 *  @category   Date&Time
 *
 *  @project
 *  @case
 *
 *  @author  Lare
 *  @copyright  Lauri Laukkarinen
 *
 *  @date       $Date: 2011-11-21 22:49:28 +0200 (Mon, 21 Nov 2011) $
 *  @version    $Rev: 6 $
 *  @author     $Author: lare $
 */
class Dates implements Interfaces\iDates
{
    /**
     *  getDaysBetween()
     *
     *  Method calculates days between given dates. Input date values is prefer
     *  to give as in SQL date format (YYYY-MM-DD).
     *
     *  @access     public static
     *
     *  @uses       \Util\Dates::isHoliday()
     *
     *  @param      string      $startDate      Start date for calculation
     *  @param      string      $stopDate       End date for calculation
     *  @param      boolean     $noWeekends     Do not include weekends
     *  @param      boolean     $noHolidays     Do not include holidays
     *
     *  @return     integer                     Days between start and end dates
     */
    public static function getDaysBetween($startDate, $stopDate, $noWeekends = false, $noHolidays = false)
    {
        $start = strtotime($startDate);
        $stop = strtotime($stopDate);

        $days = 0;

        if ($start > $stop || $start === $stop)
        {
        }

        elseif ($noWeekends || $noHolidays)
        {
            for($time = $start; $time <= $stop; $time = $time + (60 * 60 * 24))
            {
                if (($noWeekends && date('N', $time) == 6)
                    || ($noWeekends && date('N', $time) == 7)
                    || ($noHolidays && \Util\Dates::isHoliday(date('Y-m-d', $time)))
                    )
                {
                    continue;
                }

                else
                {
                    $days++;
                }
            }
        }

        else
        {
            $days = ceil(($stop - $start) / (60 * 60 * 24));
        }

        return $days;
    }


    /**
     *  isHoliday()
     *
     *  Method determines if given date is holiday or not.
     *
     *  @access     public static
     *
     *  @param      string      $date   Date to check
     *
     *  @return     boolean             Is given date holiday or not
     */
    public static function isHoliday($date)
    {
        // Todo: not yet implemented
        return false;
    }
}

?>
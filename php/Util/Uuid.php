<?php
/**
 *  \Util\Uuid.php
 *
 *  @package    HomeAI
 *  @subpackage Util
 *  @category   Uuid
 *
 *  @author  Lare
 *  @copyright  Lauri Laukkarinen
 */
namespace Util;

defined('HOMEAI_MAINFILE') OR die('No direct access allowed.');
/**
 *  Uuid -class
 *
 *  UUID generator class.
 *
 *  @package    HomeAI
 *  @subpackage Util
 *  @category   Uuid
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
class Uuid implements Interfaces\iUuid
{
    /**
     *  getRfc4122()
     *
     *  Method generates UUID string in accordance with RFC 4122.
     *
     *  @access     public static
     *
     *  @see        PHP: uniqid - manual <http://php.net/manual/function.uniqid.php#69164>
     *
     *  @return     string      Generated UUID string.
     */
    public static function getRfc4122()
    {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                     mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff),
                     mt_rand(0, 0x0fff) | 0x4000,
                     mt_rand(0, 0x3fff) | 0x8000,
                     mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff));
    }
}

?>
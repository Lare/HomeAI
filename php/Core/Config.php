<?php
/**
 *  \Core\Config.php
 *
 *  @package    HomeAI
 *  @subpackage Core
 *  @category   Config
 *
 *  @author  Lare
 *  @copyright  Lauri Laukkarinen
 */
namespace Core;

defined('HOMEAI_MAINFILE') OR die('No direct access allowed.');
/**
 *  Config -class
 *
 *  General config class.
 *
 *  @package    HomeAI
 *  @subpackage Core
 *  @category   Config
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
class Config implements Interfaces\iConfig
{
    /**
     *  readIni()
     *
     *  Method tries to read specified ini file and returs it's contents
     *  as an array.
     *
     *  @access     public static
     *
     *  @throws     \Core\Exception
     *
     *  @param      string      $ini    Name of the ini file.
     *
     *  @return     array
     */
    public static function readIni($ini)
    {
        if (!is_readable(BASEPATH ."config/". $ini))
        {
            throw new Exception("Defined ini file '". $ini ."' not found!");
        }

        return parse_ini_file(BASEPATH ."config/". $ini, true);
    }
}

?>
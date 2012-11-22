<?php
/**
 *  \Util\Interfaces\iLogger.php
 *
 *  @package    HomeAI
 *  @subpackage Util
 *  @category   Interface
 *
 *  @author  Lare
 *  @copyright  Lauri Laukkarinen
 */
namespace Util\Interfaces;

defined('HOMEAI_MAINFILE') OR die('No direct access allowed.');
/**
 *  iLogger interface
 *
 *  Interface for \Util\Logger -class.
 *
 *  @package    HomeAI
 *  @subpackage Util
 *  @category   Interface
 *
 *  @project
 *  @case
 *
 *  @author  Lare
 *  @copyright  Lauri Laukkarinen
 *
 *  @date       $Date$
 *  @version    $Rev$
 *  @author     $Author$
 */
interface iLogger
{
    public static function logErrorQuery(&$exception);
}

?>
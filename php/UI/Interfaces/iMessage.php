<?php
/**
 *  \UI\Interfaces\iMessage.php
 *
 *  @package    HomeAI
 *  @subpackage UI
 *  @category   Interface
 *
 *  @author  Lare
 *  @copyright  Lauri Laukkarinen
 */
namespace UI\Interfaces;

defined('HOMEAI_MAINFILE') OR die('No direct access allowed.');
/**
 *  iMessage interface
 *
 *  Interface for \UI\Message -class.
 *
 *  @package    HomeAI
 *  @subpackage UI
 *  @category   Interface
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
interface iMessage
{
    public static function setError($message, $title = NULL);
    public static function setOk($message, $title = NULL);
}

?>
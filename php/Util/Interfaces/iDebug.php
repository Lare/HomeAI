<?php
/**
 *  \Util\Interfaces\iDebug.php
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
 *  iDebug interface
 *
 *  Interface for \Util\Debug -class.
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
 *  @date       $Date: 2011-11-21 22:49:28 +0200 (Mon, 21 Nov 2011) $
 *  @version    $Rev: 6 $
 *  @author     $Author: lare $
 */
interface iDebug
{
    public function __construct($message);
}

?>
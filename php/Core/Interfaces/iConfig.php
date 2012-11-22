<?php
/**
 *  \Core\Interfaces\iConfig.php
 *
 *  @package    HomeAI
 *  @subpackage Core
 *  @category   Interface
 *
 *  @author  Lare
 *  @copyright  Lauri Laukkarinen
 */
namespace Core\Interfaces;

defined('HOMEAI_MAINFILE') OR die('No direct access allowed.');
/**
 *  iConfig interface
 *
 *  Interface for \Core\Config -class.
 *
 *  @package    HomeAI
 *  @subpackage Core
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
interface iConfig
{
    public static function readIni($ini);
}

?>
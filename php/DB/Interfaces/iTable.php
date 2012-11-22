<?php
/**
 *  \DB\Interfaces\iTable.php
 *
 *  @package    HomeAI
 *  @subpackage Database
 *  @category   Interface
 *
 *  @author  Lare
 *  @copyright  Lauri Laukkarinen
 */
namespace DB\Interfaces;

defined('HOMEAI_MAINFILE') OR die('No direct access allowed.');
/**
 *  iTable interface
 *
 *  Interface for \DB\Table -class.
 *
 *  @package    HomeAI
 *  @subpackage Database
 *  @category   Interface
 *
 *  @project
 *  @case
 *
 *  @author  Lare
 *  @copyright  Lauri Laukkarinen
 *
 *  @date       $Date: 2011-12-31 11:57:11 +0200 (Sat, 31 Dec 2011) $
 *  @version    $Rev: 23 $
 *  @author     $Author: lare $
 */
interface iTable
{
    public static function getInstance($table);
    public function getTableObject();
}

?>
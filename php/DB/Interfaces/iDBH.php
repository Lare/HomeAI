<?php
/**
 *  \DB\Interfaces\iDBH.php
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
 *  iDBH interface
 *
 *  Interface for \DB\DBH -class.
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
interface iDBH
{
    public static function getInstance();
    public function getSchema();
    public function getTable($table);
    public function getTableprimaryKey($table);
    public function query($query, $binds = array(), $params = array());
    public function select($table, $columns = NULL, $conds = array(), $type = DBH::SELECT_ROWS, $params = array());
    public function insert($table, $data, $params = array());
    public function update($table, $data, $conds, $params = array());
    public function delete($table, $conds, $params = array());
}

?>
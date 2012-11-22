<?php
/**
 *  \DB\Table.php
 *
 *  @package    DBH
 *  @subpackage Table
 *  @category   Database
 *
 *  @author  Lare
 *  @copyright  Lauri Laukkarinen
 */
namespace DB;

defined('HOMEAI_MAINFILE') OR die('No direct access allowed.');
/**
 *  Table -class
 *
 *  Database table class.
 *
 *  @package    DBH
 *  @subpackage Table
 *  @category   Database
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
class Table implements Interfaces\iTable
{
    /**
     *  Singleton class variable. Basicly this is contains all asked table
     *  objects.
     *
     *  @access     protected
     *  @var        array
     */
    protected static $instance = array();

    /**
     *  Used table definition
     *
     *  @access     protected
     *  @var        string
     */
    protected $table = '';


    /**
     *  __construct()
     *
     *  Construction of class.
     *
     *  @access     protected
     *
     *  @param      string  $table  Name of the table
     *
     *  @return     void
     */
    protected function __construct($table)
    {
        $this->table = $table;
    }


    /**
     *  getInstance()
     *
     *  Method return defined table object. Note that table objects are returned
     *  from cache if it's already initialized.
     *
     *  @access     public static
     *
     *  @uses       Table::__construct()
     *  @uses       Table::getTableObj()
     *
     *  @param      string      $table  Name of the table.
     *
     *  @return     object
     */
    public static function getInstance($table)
    {
        // Asked table is not in cache
        if (!isset(self::$instance[$table])
            || !self::$instance[$table] instanceof Table
            )
        {
            // Create new instance of self
            $obj = new self($table);

            // Get table object and store it to cache
            self::$instance[$table] = $obj->getTableObject();

            unset($obj);
        }

        return self::$instance[$table];
    }


    /**
     *  getTableObject()
     *
     *  Method returns actual Doctrine table object.
     *
     *  @access     public
     *
     *  @see        \Doctrine\DBAL\Schema\Table
     *
     *  @uses       Schema::getInstance()
     *
     *  @return     object  Doctrine table object
     */
    public function getTableObject()
    {
        return Schema::getInstance()->listTableDetails($this->table);
    }
}

?>
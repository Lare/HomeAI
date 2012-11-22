<?php
/**
 *  \DB\Schema.php
 *
 *  @package    DBH
 *  @subpackage Schema
 *  @category   Database
 *
 *  @author  Lare
 *  @copyright  Lauri Laukkarinen
 */
namespace DB;

defined('HOMEAI_MAINFILE') OR die('No direct access allowed.');
/**
 *  Schema -class
 *
 *  Database schema class.
 *
 *  @package    DBH
 *  @subpackage Schema
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
class Schema implements Interfaces\iSchema
{
    /**
     *  Singleton class variable. Basicly this is contains all asked table
     *  objects.
     *
     *  @access     protected
     *  @var        array
     */
    protected static $instance = NULL;


    /**
     *  __construct()
     *
     *  Construction of class.
     *
     *  @access     protected
     *
     *  @return     void
     */
    protected function __construct()
    {
    }


    /**
     *  getInstance()
     *
     *  Method returns schema object. Note that schema object is returned
     *  from cache if it's already initialized.
     *
     *  @access     public static
     *
     *  @uses       \DB\Schema::__construct()
     *  @uses       \DB\Schema::getSchemaObject()
     *
     *  @return     object      Doctrine schema object
     */
    public static function getInstance()
    {
        // Asked schema is not in cache
        if (!isset(self::$instance)
            || !self::$instance instanceof Schema
            )
        {
            // Create new instance of self
            $obj = new self();

            // Get schema object and store it to cache
            self::$instance = $obj->getSchemaObject();

            unset($obj);
        }

        return self::$instance;
    }


    /**
     *  getSchemaObject()
     *
     *  Method returns schema object. Note that schema object is returned
     *  from cache if it's already initialized.
     *
     *  @access     public static
     *
     *  @see        \Doctrine\DBAL\Schema\AbstractSchemaManager()
     *
     *  @uses       \DB\Connection::getConnection()
     *
     *  @return     object      Doctrine schema object
     */
    public function getSchemaObject()
    {
        return Connection::getConnection()->getSchemaManager();
    }
}

?>
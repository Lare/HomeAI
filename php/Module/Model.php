<?php
/**
 *  \Module\Model.php
 *
 *  @package    HomeAI
 *  @subpackage Module
 *  @category   Model
 *
 *  @author  Lare
 *  @copyright  Lauri Laukkarinen
 */
namespace Module;
use \DB\DBH as DBH;

defined('HOMEAI_MAINFILE') OR die('No direct access allowed.');
/**
 *  Model -class
 *
 *  General module model class. Basicly every module model class must extend
 *  this abstract class.
 *
 *  @package    HomeAI
 *  @subpackage Module
 *  @category   Model
 *
 *  @project
 *  @case
 *
 *  @author  Lare
 *  @copyright  Lauri Laukkarinen
 *
 *  @date       $Date: 2012-11-10 14:41:07 +0200 (Sat, 10 Nov 2012) $
 *  @version    $Rev: 38 $
 *  @author     $Author: lare $
 */
abstract class Model implements Interfaces\iModel
{
    /**
     *  Name of the current module.
     *
     *  @access     protected
     *  @var        string
     */
    protected $module = '';

    /**
     *  Name of the current module action.
     *
     *  @access     protected
     *  @var        string
     */
    protected $action = '';

    /**
     *  Database connection
     *
     *  @access     protected
     *  @var        object
     */
    protected $dbh = NULL;

    /**
     *  Request object. Note that all $_GET, $_POST and $_COOKIE values
     *  must handled via this object.
     *
     *  @access     protected
     *  @var        object
     */
    protected $request = NULL;

    /**
     *  View object of current MVC -model. Note that this is
     *  a reference to view class.
     *
     *  @access     protected
     *  @var        object
     */
    protected $view = NULL;


    /**
     *  __construct()
     *
     *  Construction of the class.
     *
     *  @access     public
     *
     *  @uses       \DB\DBH::getInstance()
     *
     *  @param      string      $module     Name of the requested module
     *  @param      string      $action     Name of the requested action
     *
     *  @return     void
     */
    public function __construct(&$module, &$action)
    {
        // Set module and action to class
        $this->module = $module;
        $this->action = $action;

        // Get database handler instance
        $this->dbh = \DB\DBH::getInstance();

        $this->initialize();
    }


    /**
     *  setRequest()
     *
     *  Setter for request object.
     *
     *  @access     public
     *
     *  @param      object  $request    Instance of request class.
     *
     *  @return     void
     */
    public function setRequest(&$request)
    {
        $this->request = $request;
    }


    /**
     *  setView()
     *
     *  Setter for view object.
     *
     *  @access     public
     *
     *  @param      object  $model  Instance of model class.
     *
     *  @return     void
     */
    public function setView(&$view)
    {
        $this->view = $view;
    }


    /**
     *  getDbh()
     *
     *  Getter for DBH object.
     *
     *  @access     public
     *
     *  @return     object  DBH object
     */
    public function getDbh()
    {
        return $this->dbh;
    }


    public function getEventData()
    {
        return $this->dbh->select('Event', 'Date', NULL, DBH::SELECT_COLUMNS);
    }

}

?>

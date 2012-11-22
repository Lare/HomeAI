<?php
/**
 *  \Module\Controller.php
 *
 *  @package    HomeAI
 *  @subpackage Module
 *  @category   Controller
 *
 *  @author  Lare
 *  @copyright  Lauri Laukkarinen
 */
namespace Module;

defined('HOMEAI_MAINFILE') OR die('No direct access allowed.');
/**
 *  Controller -class
 *
 *  General module contoller class. Basicly every module controller class must
 *  extend this abstract class.
 *
 *  @package    HomeAI
 *  @subpackage Module
 *  @category   Controller
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
abstract class Controller implements Interfaces\iController
{
    /**#@+
     *  View and model objects, these are created automaticly if corresponding
     *  classes are founded.
     *
     *  @access     protected
     *  @var        object
     */
    protected $view = NULL;
    protected $model = NULL;
    /**#@-*/

    /**
     *  Request object. Note that all $_GET, $_POST and $_COOKIE values
     *  must handled via this object.
     *
     *  @access     protected
     *  @var        object
     */
    protected $request = NULL;

    /**
     *  Global authenticate status for current module controller. If this is
     *  true, all actions require logged user.
     *
     *  @access     protected
     *  @var        boolean
     */
    protected $auth = true;

    /**
     *  Action based authenticate status for current module controller. Actions
     *  are keys and value must be boolean. If action value is false, action is
     *  "public" and do not require logged user.
     *
     *  @access     protected
     *  @var        array
     */
    protected $authActions = array();

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
     *  __construct()
     *
     *  Construction of the class. Constructor determines if requested module
     *  has View or Model -classes defined. If classes are founded they are
     *  also created and saved to class variables.
     *
     *  @access     public
     *
     *  @uses       \Module\{ModuleName}\View::
     *  @uses       \Module\{ModuleName}\View::setModel()
     *  @uses       \Module\{ModuleName}\View::setRequest()
     *  @uses       \Module\{ModuleName}\Model::
     *  @uses       \Module\{ModuleName}\Model::setView()
     *  @uses       \Module\{ModuleName}\Model::setRequest()
     *  @uses       \Module\{ModuleName}\Controller::initialize()
     *  @uses       \Util\Request::
     *
     *  @param      string      $module     Name of the requested module
     *  @param      string      $action     Name of the requested action
     *
     *  @return     void
     */
    public function __construct(&$module, &$action)
    {
        // Assign module and action
        $this->module = $module;
        $this->action = $action;

        // Define module view and model objects
        $classes = array(
                    'view'  =>  '\\Module\\'. $this->module .'\\View',
                    'model' =>  '\\Module\\'. $this->module .'\\Model',
                    );

        // Iterate classes and create objects
        foreach ($classes as $attr => $class)
        {
            $this->{$attr} = new $class($this->module, $this->action);
        }

        // Create request object
        $this->request = new \Util\Request;

        // Set model object to view
        $this->view->setModel($this->model);

        // Set request object to view
        $this->view->setRequest($this->request);

        // Set view object to model
        $this->model->setView($this->view);

        // Set request object to model
        $this->model->setRequest($this->request);

        // Initialize controller
        $this->initialize();
    }


    /**
     *  handleRequest()
     *
     *  Common module request handler. Basicly ALL module requests are routed
     *  via this method. Method will also authenticate user if necessary for
     *  requested action.
     *
     *  Note:   All requests are routed to 'handleRequest{Action}' -methods.
     *          If method doesn't exists or action is NULL user will be
     *          routed to default action.
     *
     *  @access     public
     *
     *  @uses       \Module\{ModuleName}\Controller::handleRequest{Action}()
     *  @uses       \Module\{ModuleName}\Controller::handleRequestDefault()
     *
     *  @return     void
     */
    public function handleRequest()
    {
        // Create dynamic method name.
        $method = 'handleRequest'. $this->action;

        // Handler defined and founded
        if (!is_null($this->action) && method_exists($this, $method))
        {
            call_user_func(array($this, $method));
        }

        // Otherwise fallback to default request handler.
        else
        {
            $this->handleRequestDefault();
        }
    }


    /**
     *  redirect()
     *
     *  Method redirects user to defined module and action.
     *
     *  @todo       Add extra parameter handling.
     *
     *  @access     protected
     *
     *  @param      mixed   $module     Module where to redirect. If not set
     *                                  method will use current module. If boolean
     *                                  false module definition is not used.
     *  @param      string  $action     Action where to redirect. If not set
     *                                  user is redirected to default action
     *                                  of the defined module.
     *  @param      array   $params     Used extra params
     *  @param      string  $anchor     Used anchor for destination page
     *
     *  @return     void
     */
    protected function redirect($module = NULL, $action = NULL, $params = array(), $anchor = NULL)
    {
        // Determine used module
        $module = (is_null($module)) ? $this->module : $module;

        // Reset query data
        $data = array();

        // Module is defined
        if ($module !== false)
        {
            // Initialize used data array for query string
            $data['Module'] = $module;
        }

        // Action is defined, add it to data array
        if (!empty($action))
        {
            $data['Action'] = $action;
        }

        // Extra parameters are defined, add them to data array
        if (is_array($params) && !empty($params))
        {
            $data = array_merge($data, $params);
        }

        // Create http query
        $query = !empty($data) ? "?". http_build_query($data, '', '&') : '';

        // Build URL + query string
        $url = BASEURL . $query;

        // Anchor is defined, add it to url
        if (!is_null($anchor))
        {
            $url .= "#". $anchor;
        }

        // Redirect user
        header("Location: ". $url);
        exit(0);
    }
}

?>
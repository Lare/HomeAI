<?php
/**
 *  \Module\Initializer.php
 *
 *  @package    HomeAI
 *  @subpackage Module
 *  @category   Module
 *
 *  @author  Lare
 *  @copyright  Lauri Laukkarinen
 */
namespace Module;

defined('HOMEAI_MAINFILE') OR die('No direct access allowed.');
/**
 *  Initializer -class
 *
 *  Module initializer class.
 *
 *  @package    HomeAI
 *  @subpackage Module
 *  @category   Module
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
class Initializer implements Interfaces\iInitializer
{
    /**
     *  Name of the asked module.
     *
     *  @access     private
     *  @var        string
     */
    private $module = NULL;

    /**
     *  Name of the asked module action
     *
     *  @access     private
     *  @var        string
     */
    private $action = NULL;

    /**
     *  Module controller class name.
     *
     *  @access     private
     *  @var        string
     */
    private $class = NULL;

    /**
     *  Default module definition.
     *
     *  @access     private
     *  @var        string
     */
    private $defaultModule = 'Control';

    /**
     *  Default module action definition.
     *
     *  @access     private
     *  @var        string
     */
    private $defaultAction = 'Default';


    /**
     *  __construct()
     *
     *  Construction of the class.
     *
     *  @access     public
     *
     *  @param      string      $module     Name of the requested module. This
     *                                      can also be NULL, then we fallback
     *                                      to default module.
     *  @param      string      $action     Name of the requested actio. This
     *                                      can also be NULL, then we fallback
     *                                      to default action.
     *
     *  @return     void
     */
    public function __construct(&$module, &$action)
    {
        $this->module = $module;
        $this->action = $action;
    }


    /**
     *  handleRequest()
     *
     *  Global module request handler. All request all handled via this method.
     *  Method determines used controller -class and calls its request handler.
     *
     *  @access     public
     *
     *  @return     void
     */
    public function handleRequest()
    {
        // Module not given
        if (is_null($this->module) || empty($this->module))
        {
            $this->module = $this->defaultModule;
        }

        // Action not given
        if (is_null($this->action) || empty($this->action))
        {
            $this->action = $this->defaultAction;
        }

        // Define module controller class
        $this->class = '\\Module\\'. $this->module .'\\Controller';

        // Controller class not found.
        if (!class_exists($this->class))
        {
            // Set error message.
            \UI\Message::setError("Invalid module request '". $this->module ."'.");

            // Fallback to default module
            $this->class = '\\Module\\'. $this->defaultModule .'\\Controller';

            $this->module = $this->defaultModule;
            $this->action = $this->defaultAction;
        }

        // Create module controller and handle defined request.
        $obj = new $this->class($this->module, $this->action);
        $obj->handleRequest();

        unset($obj);
    }
}

?>
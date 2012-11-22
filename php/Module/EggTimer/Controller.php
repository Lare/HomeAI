<?php
/**
 *  \Module\EggTimer\Controller.php
 *
 *  @package    Module
 *  @subpackage EggTimer
 *  @category   Controller
 *
 *  @author  Lare
 *  @copyright  Lauri Laukkarinen
 */
namespace Module\EggTimer;

defined('HOMEAI_MAINFILE') OR die('No direct access allowed.');
/**
 *  Controller -class
 *
 *  Controller class for EggTimer -module.
 *
 *  @package    Module
 *  @subpackage EggTimer
 *  @category   Controller
 *
 *  @project
 *  @case
 *
 *  @author  Lare
 *  @copyright  Lauri Laukkarinen
 *
 *  @date       $Date$
 *  @version    $Rev$
 *  @author     $Author$
 */
class Controller extends \Module\Controller implements Interfaces\iController
{
    /**
     *  initialize()
     *
     *  General initializer for Controller -class.
     *
     *  @access     public
     *
     *  @return     void
     */
    public function initialize()
    {
    }


    /**
     *  handleRequestDefault()
     *
     *  Method handles main request to 'EggTimer' module.
     *
     *  @access     public
     *
     *  @uses       \Module\EggTimer\View\makeMainView()
     *
     *  @return     void
     */
    public function handleRequestDefault()
    {
        $this->view->makeMainView();
    }
}

?>
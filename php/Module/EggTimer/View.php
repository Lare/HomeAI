<?php
/**
 *  \Module\EggTimer\View.php
 *
 *  @package    Module
 *  @subpackage EggTimer
 *  @category   View
 *
 *  @author  Lare
 *  @copyright  Lauri Laukkarinen
 */
namespace Module\EggTimer;

defined('HOMEAI_MAINFILE') OR die('No direct access allowed.');
/**
 *  View -class
 *
 *  View class for EggTimer module.
 *
 *  @package    Module
 *  @subpackage EggTimer
 *  @category   View
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
class View extends \Module\View implements Interfaces\iView
{
    protected $pageTitle = 'Munakello';

    /**
     *  initialize()
     *
     *  General initializer for View -class.
     *
     *  @access     public
     *
     *  @return     void
     */
    public function initialize()
    {
    }


    /**
     *  makeMainView()
     *
     *  Method makes graphs content and displays it to user.
     *
     *  @access     public
     *
     *  @uses       \Module\View::display()
     *
     *  @return     void
     */
    public function makeMainView()
    {
        $this->addJs('jQuery-Countdown/');
        $this->addJs('jQuery-jPlayer/');

        // Create template and assign data to it.
        $template = $this->smarty->createTemplate('timer.tpl');
        $template->assign('baseUrl', BASEURL);
        $template->assign('active', 'new');

        // Add created html to current view
        $this->smarty->assign('Content', $template->fetch());

        $this->display();
    }
}

?>
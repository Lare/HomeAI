<?php
/**
 *  \Module\GraphsTemperature\View.php
 *
 *  @package    Module
 *  @subpackage GraphsTemperature
 *  @category   View
 *
 *  @author  Lare
 *  @copyright  Lauri Laukkarinen
 */
namespace Module\GraphsTemperature;

defined('HOMEAI_MAINFILE') OR die('No direct access allowed.');
/**
 *  View -class
 *
 *  View class for GraphsTemperature module.
 *
 *  @package    Module
 *  @subpackage GraphsTemperature
 *  @category   View
 *
 *  @project
 *  @case
 *
 *  @author  Lare
 *  @copyright  Lauri Laukkarinen
 *
 *  @date       $Date: 2012-01-01 12:06:01 +0200 (Sun, 01 Jan 2012) $
 *  @version    $Rev: 32 $
 *  @author     $Author: lare $
 */
class View extends \Module\View implements Interfaces\iView
{
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
     *  @param      array   $data           Graphs page data to use in main template
     *  @param      boolean $backButton     Make back button to right top corner
     *
     *  @return     void
     */
    public function makeMainView(&$data, $backButton)
    {
        // Create template and assign data session data to it.
        $template = $this->smarty->createTemplate('main.tpl');
        $template->assign('baseUrl', BASEURL);

        foreach ($data as $key => $value)
        {
            $template->assign($key, $value);
        }

        // Add parsed data to current view
        $this->smarty->assign('Content', $template->fetch());

        unset($template);

        // Add back button to page
        if ($backButton)
        {
            $template = $this->smarty->createTemplate('header.tpl');
            $template->assign('baseUrl', BASEURL);

            $this->smarty->assign('Footer', $template->fetch());

            unset($template);
        }

        $this->display();
    }
}

?>
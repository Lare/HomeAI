<?php
/**
 *  \Module\Control\View.php
 *
 *  @package    Module
 *  @subpackage Control
 *  @category   View
 *
 *  @author  Lare
 *  @copyright  Lauri Laukkarinen
 */
namespace Module\Control;

defined('HOMEAI_MAINFILE') OR die('No direct access allowed.');
/**
 *  View -class
 *
 *  View class for board module.
 *
 *  @package    HomeAI
 *  @subpackage Control
 *  @category   View
 *
 *  @project
 *  @case
 *
 *  @author  Lare
 *  @copyright  Lauri Laukkarinen
 *
 *  @date       $Date: 2011-12-31 18:38:13 +0200 (Sat, 31 Dec 2011) $
 *  @version    $Rev: 26 $
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


    public function makeMainView(&$data, &$js)
    {
        // Add required javascript libraries
        $this->addJs('jQuery-iPhoneCheckboxes/');
        $this->addJs('jQuery-MobiScroll/');

        // Create template and assign data session data to it.
        $template = $this->smarty->createTemplate('main.tpl');
        $template->assign('baseUrl', BASEURL);

        foreach ($data as $key => $value)
        {
            $template->assign($key, $value);
        }


        foreach ($js as $key => $value)
        {
            $_js = sprintf(" var %s = '%s';",
                        $key,
                        $value
                        );

            $this->smarty->append('pageVar', $_js);
        }


        // Add form to current view
        $this->smarty->assign('Content', $template->fetch());

        $this->display();
    }


    public function makeControls(&$controls)
    {
        // Create template and assign data session data to it.
        $template = $this->smarty->createTemplate('controls.tpl');
        $template->assign('baseUrl', BASEURL);
        $template->assign('controls', $controls);

        return $template->fetch();
    }
}

?>
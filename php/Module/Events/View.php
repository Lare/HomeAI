<?php
/**
 *  \Module\Events\View.php
 *
 *  @package    Module
 *  @subpackage Events
 *  @category   View
 *
 *  @author  Lare
 *  @copyright  Lauri Laukkarinen
 */
namespace Module\Events;

defined('HOMEAI_MAINFILE') OR die('No direct access allowed.');
/**
 *  View -class
 *
 *  View class for Events module.
 *
 *  @package    Module
 *  @subpackage Events
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
    protected $pageTitle = 'Tapahtumat';
    protected $pageTitleShowOnlyPage = true;

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
    public function makeMainView(&$data, &$date, &$type)
    {
        // Make view content
        $content = ($type === 0) ? $this->makeContentAjax($data, $date) : $this->makeContentDefault($data, $date);

        // Add created html to current view
        $this->smarty->assign('Content', $content);

        if ($type === 0)
        {
            $this->display(NULL, 'dialog.tpl');
        }

        else
        {
            $this->display();
        }
    }


    public function makePastView(&$data)
    {
        $output = array();

        foreach ($data as $k => $v)
        {
            $dateString = ucfirst(strftime('%A, %e %Bta %Y', strtotime($k)));

            $output[$dateString] = $v;
        }

        // Create template and assign data to it.
        $template = $this->smarty->createTemplate('events_default.tpl');
        $template->assign('baseUrl', BASEURL);
        $template->assign('events', $output);
        $template->assign('active', 'past');

        // Add created html to current view
        $this->smarty->assign('Content', $template->fetch());

        $this->display();
    }


    public function makeAddNew()
    {
        $this->addJs('jQuery-Validate/');

        // Create template and assign data to it.
        $template = $this->smarty->createTemplate('add_new.tpl');
        $template->assign('baseUrl', BASEURL);
        $template->assign('active', 'new');

        // Add created html to current view
        $this->smarty->assign('Content', $template->fetch());

        $this->display();
    }


    protected function makeContentAjax(&$data, &$date)
    {
        $dateObj = \DateTime::createFromFormat('d.m.Y', $date);

        $this->pageTitle = ucfirst(strftime('%A, %e %Bta %Y', $dateObj->format('U')));

        // Create template and assign data to it.
        $template = $this->smarty->createTemplate('events.tpl');
        $template->assign('baseUrl', BASEURL);
        $template->assign('events', $data);
        $template->assign('date', $dateObj->format('U'));

        return $template->fetch();
    }


    protected function makeContentDefault(&$data, &$date)
    {
        $output = array();

        foreach ($data as $k => $v)
        {
            $dateString = ucfirst(strftime('%A, %e %Bta %Y', strtotime($k)));

            $output[$dateString] = $v;
        }

        // Create template and assign data to it.
        $template = $this->smarty->createTemplate('events_default.tpl');
        $template->assign('baseUrl', BASEURL);
        $template->assign('events', $output);
        $template->assign('active', 'future');

        return $template->fetch();
    }
}

?>
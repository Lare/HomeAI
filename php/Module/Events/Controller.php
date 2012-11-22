<?php
/**
 *  \Module\Events\Controller.php
 *
 *  @package    Module
 *  @subpackage Events
 *  @category   Controller
 *
 *  @author  Lare
 *  @copyright  Lauri Laukkarinen
 */
namespace Module\Events;

defined('HOMEAI_MAINFILE') OR die('No direct access allowed.');
/**
 *  Controller -class
 *
 *  Controller class for Events -module.
 *
 *  @package    Module
 *  @subpackage Events
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
     *  Method handles main request to 'Events' module.
     *
     *  @access     public
     *
     *  @uses       \Module\Events\Controller\getParameters()
     *  @uses       \Module\Events\Model\getRanges()
     *  @uses       \Module\Events\Model\getImageData()
     *  @uses       \Module\Events\View\makeMainView()
     *
     *  @return     void
     */
    public function handleRequestDefault()
    {
        if (!$this->request->isAjax() || $this->request->get('NoAjax') == 1)
        {
            $date = date('d.m.Y');
            $type = 1;
        }

        else
        {
            $date = $this->request->get('Date');
            $type = 0;
        }

        $data = $this->model->getData($date, $type);

        $this->view->makeMainView($data, $date, $type);
    }


    public function handleRequestShowPast()
    {
        $date = date('d.m.Y');
        $type = 2;

        $data = $this->model->getData($date, $type);

        $this->view->makePastView($data);
    }


    public function handleRequestAddNew()
    {
        $this->view->makeAddNew();
    }


    public function handleRequestSaveEvent()
    {
        if ($this->request->isAjax())
        {
            $this->saveEventAjax();
        }

        else
        {
            $this->saveEventNormal();
        }
    }


    public function saveEventAjax()
    {
        try
        {
            $data = array(
                        'Title'         =>  $this->request->get('Title'),
                        'Description'   =>  $this->request->get('Description'),
                        'Date'          =>  array(\DateTime::createFromFormat('U', $this->request->get('Date')), 'date'),
                        );

            $this->model->saveEvent($data);
        }

        catch (\Exception $error)
        {
            $data = array(
                        'error' => $error->getMessage(),
                        );

        }

        echo json_encode($data);
        exit(0);
    }


    public function saveEventNormal()
    {
        $required = array('Title', 'Date');

        try
        {
            foreach ($required as $input)
            {
                $_val = $this->request->get($input);

                if (empty($_val))
                {
                    throw new Exception("Et syöttänyt kaikkia vaadittuja tietoja.");
                }
            }

            $data = array(
                        'Title'         =>  $this->request->get('Title'),
                        'Description'   =>  $this->request->get('Description'),
                        'Date'          =>  array(\DateTime::createFromFormat('d.m.Y', $this->request->get('Date')), 'date'),
                        );

            $this->model->saveEvent($data);

            \UI\Message::setOk('Tapahtuma lisätty onnistuneesti.');
        }

        catch (\Exception $error)
        {
            \UI\Message::setError($error->getMessage());
        }

        $this->redirect();
    }
}

?>
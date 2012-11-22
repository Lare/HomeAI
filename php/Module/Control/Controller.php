<?php
/**
 *  \Module\Control\Controller.php
 *
 *  @package    Module
 *  @subpackage Control
 *  @category   Controller
 *
 *  @author  Lare
 *  @copyright  Lauri Laukkarinen
 */
namespace Module\Control;

defined('HOMEAI_MAINFILE') OR die('No direct access allowed.');
/**
 *  Controller -class
 *
 *  Controller class for Control -module.
 *
 *  @package    HomeAI
 *  @subpackage Board
 *  @category   Controller
 *
 *  @project
 *  @case
 *
 *  @author  Lare
 *  @copyright  Lauri Laukkarinen
 *
 *  @date       $Date: 2012-01-04 19:16:42 +0200 (Wed, 04 Jan 2012) $
 *  @version    $Rev: 36 $
 *  @author     $Author: lare $
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
     *  
     *
    public function handleRequestLauri()
    {
        $this->view->display();

        die('jee');
    }
    */

    /**
     *  handleRequestDefault()
     *
     *  Method generates Control module main view.
     *
     *  @access     public
     *
     *  @uses       \Module\Control\Model::getControlsState()
     *  @uses       \Module\Control\Model::getTemperatureHash()
     *  @uses       \Module\Control\Model::getTemperatureData()
     *  @uses       \Module\Control\Model::getActions()
     *  @uses       \Module\Control\Model::getControls()
     *  @uses       \Module\Control\View::makeControls()
     *  @uses       \Module\Control\View::makeMainView()
     *
     *  @return     void
     */
    public function handleRequestDefault()
    {
        $stateControls = $this->model->getControlsState();
        $hashTemperature = $this->model->getTemperatureHash();

        $actions = $this->model->getActions();
        $controls = $this->model->getControls();

        $data = array(
                    'actions'       =>  $actions,
                    'controls'      =>  $this->view->makeControls($controls),
                    'temperature'   =>  $this->model->getTemperatureData(),
                    );

        $js = array(
                'hashControls'      =>  sha1(serialize($stateControls)),
                'hashTemperature'   =>  $hashTemperature,
                );

        $this->view->makeMainView($data, $js);
    }


    /**
     *  handleRequestSetRelayStatus()
     *
     *  Method handles SetRelayStatus request.
     *
     *  @access     public
     *
     *  @uses       \Util\Request::get()
     *  @uses       \Util\Request::isAjax()
     *  @uses       \Module\Controller::redirect()
     *  @uses       \Module\Control\Model::setRelayStatus()
     *
     *  @return     void    Echoes output directly
     */
    public function handleRequestSetRelayStatus()
    {
        // Allow only AJAX requests
        if (!$this->request->isAjax())
        {
            $this->redirect();
        }

        // Get request data
        $relayId = $this->request->get('RelayId');
        $relayBit = $this->request->get('RelayBit');
        $status = $this->request->get('Status');

        try
        {
            $this->model->setRelayStatus($relayId, $relayBit, $status);

            $data = true;
        }

        catch (\Exception $error)
        {
            $data = array(
                        'error' =>  $error->getMessage(),
                        );
        }

        echo json_encode($data);
        exit(0);
    }


    /**
     *  handleRequestGetControls()
     *
     *  Method handles GetControls request. Basicly this method returns HTML
     *  data for controls section
     *
     *  @access     public
     *
     *  @uses       \Util\Request::isAjax()
     *  @uses       \Util\Request::get()
     *  @uses       \Module\Controller::redirect()
     *  @uses       \Module\Control\Model::getControlsState()
     *  @uses       \Module\Control\Model::fetchControls()
     *  @uses       \Module\Control\View::makeControls()
     *
     *  @return     void    Echoes output directly
     */
    public function handleRequestGetControls()
    {
        // Allow only AJAX requests
        if (!$this->request->isAjax())
        {
            $this->redirect();
        }

        // Fetch current control status values
        $stateControls = $this->model->getControlsState();

        // Fetch control data
        $controls = $this->model->getControls($stateControls);

        // Make controls HTML and echo it directly
        echo $this->view->makeControls($controls);
    }


    /**
     *  handleRequestGetControlsHash()
     *
     *  Method handles GetControlsHash request. Basicly method calculates sha1
     *  HASH from control state array which is serializes.
     *
     *  @access     public
     *
     *  @uses       \Util\Request::isAjax()
     *  @uses       \Module\Control\Model::getControlsState()
     *
     *  @return     void    Echoes output directly
     */
    public function handleRequestGetControlsHash()
    {
        // Allow only AJAX requests
        if ($this->request->isAjax())
        {
            echo sha1(serialize($this->model->getControlsState()));
        }
    }


    /**
     *  handleRequestGetTemperature()
     *
     *  Method handles GetTemperature request. Basicly this method returns HTML
     *  data for temperature section of page.
     *
     *  @access     public
     *
     *  @uses       \Util\Request::isAjax()
     *  @uses       \Module\Control\Model::getTemperatureData()
     *
     *  @return     mixed       If AJAX request output will be echoed directly,
     *                          otherwise method will return an array of data.
     */
    public function handleRequestGetTemperature()
    {
        $data = $this->model->getTemperatureData();

        // Allow only AJAX requests
        if ($this->request->isAjax())
        {
            echo $data;
            exit(0);
        }

        return $data;
    }


    /**
     *  handleRequestGetTemperatureHash()
     *
     *  Method handles GetTemperatureHash request. Basicly method returns
     *  calculated sha1 HASH from current temperature file. Actual HASH
     *  determinination is done in Model -class.
     *
     *  @access     public
     *
     *  @uses       \Util\Request::isAjax()
     *  @uses       \Module\Control\Model::getTemperatureHash()
     *
     *  @return     void    Echoes output directly
     */
    public function handleRequestGetTemperatureHash()
    {
        // Allow only AJAX requests
        if ($this->request->isAjax())
        {
            echo $this->model->getTemperatureHash();
        }
    }


    /**
     *  handleRequestGetHashes()
     *
     *  Method handles GetHashes request. Basicly method returns calculated sha1
     *  HASH from current temperature file AND controls state. Actual HASH data
     *  determinination is done in Model -class.
     *
     *  @access     public
     *
     *  @uses       \Util\Request::isAjax()
     *  @uses       \Module\Control\Model::getTemperatureHash()
     *  @uses       \Module\Control\Model::getControlsState()
     *
     *  @return     void    Echoes output directly
     */
    public function handleRequestGetHashes()
    {
        if (!$this->request->isAjax())
        {
            $this->redirect();
        }

        $data = array(
                    'Temparature'   =>  $this->model->getTemperatureHash(),
                    'Controls'      =>  sha1(serialize($this->model->getControlsState())),
                    );

        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Content-type: application/json');

        echo json_encode($data);
        exit(0);
    }
}

?>

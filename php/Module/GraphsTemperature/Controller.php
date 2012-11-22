<?php
/**
 *  \Module\GraphsTemperature\Controller.php
 *
 *  @package    Module
 *  @subpackage GraphsTemperature
 *  @category   Controller
 *
 *  @author  Lare
 *  @copyright  Lauri Laukkarinen
 */
namespace Module\GraphsTemperature;

defined('HOMEAI_MAINFILE') OR die('No direct access allowed.');
/**
 *  Controller -class
 *
 *  Controller class for GraphsTemperature -module.
 *
 *  @package    Module
 *  @subpackage GraphsTemperature
 *  @category   Controller
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
     *  Method handles main request to 'GraphsTemperature' module.
     *
     *  @access     public
     *
     *  @uses       \Module\GraphsTemperature\Controller\getParameters()
     *  @uses       \Module\GraphsTemperature\Model\getRanges()
     *  @uses       \Module\GraphsTemperature\Model\getImageData()
     *  @uses       \Module\GraphsTemperature\View\makeMainView()
     *
     *  @return     void
     */
    public function handleRequestDefault()
    {
        // determine used parameters
        list($range, $graphId) = $this->getParameters();

        // Define used view parameters
        $data = array(
                    'ranges'        =>  $this->model->getRanges(),
                    'checkedRange'  =>  $range,
                    'imageData'     =>  $this->model->getImageData($graphId, $range),
                    );

        $makeBackButton = is_null($graphId) ? false : true;

        $this->view->makeMainView($data, $makeBackButton);
    }


    /**
     *  handleRequestGetGraphs()
     *
     *  Method handles 'GetGraphs' request for module. This method is only
     *  allowed by AJAX request. Method echoes requested image data.
     *
     *  @access     public
     *
     *  @uses       \Util\Request::isAjax()
     *  @uses       \Module\Controller::request()
     *  @uses       \Module\GraphsTemperature\Controller\getParameters()
     *  @uses       \Module\GraphsTemperature\Model\getImageData()
     *
     *  @return     void
     */
    public function handleRequestGetGraphs()
    {
        // Allow only AJAX requests
        if (!$this->request->isAjax())
        {
            $this->redirect();
        }

        // determine used parameters
        list($range, $graphId) = $this->getParameters();

        // Echo
        echo $this->model->getImageData($graphId, $range);
    }


    /**
     *  getParameters()
     *
     *  Method parses used parameters and returns them as an array.
     *
     *  @access     private
     *
     *  @uses       \Util\Request::get()
     *
     *  @return     array
     */
    private function getParameters()
    {
        // Asked parameters
        $range = (int)$this->request->get('Range');
        $graphId = (int)$this->request->get('GraphId');

        // Allow only 1 - 6 range values.
        if ($range < 1 || $range > 6)
        {
            $range = 1;
        }

        // Allow only 1 - 10 graphId values.
        if ($graphId < 1 || $graphId > 10)
        {
            $graphId = NULL;
        }

        return array($range, $graphId);
    }
}

?>

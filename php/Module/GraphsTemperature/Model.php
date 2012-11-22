<?php
/**
 *  \Module\GraphsTemperature\Model.php
 *
 *  @package    Module
 *  @subpackage GraphsTemperature
 *  @category   Model
 *
 *  @author  Lare
 *  @copyright  Lauri Laukkarinen
 */
namespace Module\GraphsTemperature;

defined('HOMEAI_MAINFILE') OR die('No direct access allowed.');
/**
 *  Model -class
 *
 *  Model class for GraphsTemperature module.
 *
 *  @package    Module
 *  @subpackage GraphsTemperature
 *  @category   Model
 *
 *  @project
 *  @case
 *
 *  @author  Lare
 *  @copyright  Lauri Laukkarinen
 *
 *  @date       $Date: 2011-11-22 21:27:01 +0200 (Tue, 22 Nov 2011) $
 *  @version    $Rev: 16 $
 *  @author     $Author: lare $
 */
class Model extends \Module\Model implements Interfaces\iModel
{
    /**
     *  Used configuration file for RRD data.
     *
     *  @access     protected
     *  @var        string
     */
    protected $ini = 'rrd.ini';

    /**#@+
     *  Parameters which are read from defined ini file.
     *
     *  @access     protected
     *  @var        string
     */
    protected $rrdPath = '';
    protected $rrdImages = '';
    protected $imgUrl = '';
    /**#@-*/

    protected $labels = array(
                            Model::RANGE_1  =>  'Vuorokausi',
                            Model::RANGE_2  =>  'Viikko',
                            Model::RANGE_3  =>  'Kuukausi',
                            Model::RANGE_4  =>  'Vuosi',
                            Model::RANGE_5  =>  '3 vuotta',
                            Model::RANGE_6  =>  '5 vuotta',
                            );

    const RANGE_1 = 1;  // One day
    const RANGE_2 = 2;  // One week
    const RANGE_3 = 3;  // One month
    const RANGE_4 = 4;  // One year
    const RANGE_5 = 5;  // Three years
    const RANGE_6 = 6;  // Five years



    /**
     *  initialize()
     *
     *  Model initializer method.
     *
     *  @access     public
     *
     *  @uses       \Core\Config::readIni()
     *
     *  @return     void
     */
    public function initialize()
    {
        // Read specified ini file
        $data = \Core\Config::readIni($this->ini);

        // Store data to class attributes
        $this->rrdPath = $data['rrdPath'];
        $this->rrdImages = $data['rrdImages'];
        $this->imgUrl = $data['imgUrl'];
    }


    /**
     *  getTimeRange()
     *
     *  Method determines used range options for RRD graph images and returns
     *  them as an array.
     *
     *  @access     public
     *
     *  @param      integer $range  Used range, possible values are;
     *                                1 = One day
     *                                2 = One week
     *                                3 = One month
     *                                4 = One year
     *                                5 = Three years
     *                                4 = Five years
     *
     *  @return     array           Start and end times for RRD graph
     */
    public function getTimeRange($range)
    {
        $end = 'now';

        switch ($range)
        {
            case Model::RANGE_1:
                $start = 'end-24h';
                break;

            case Model::RANGE_2:
                $start = 'end-1w';
                break;

            case Model::RANGE_3:
                $start = 'end-1m';
                break;

            case Model::RANGE_4:
                $start = 'end-1y';
                break;

            case Model::RANGE_5:
                $start = 'end-3y';
                break;

            case Model::RANGE_6:
                $start = 'end-5y';
                break;

            default:
                $start = 'end-24h';
                break;
        }

        return array($start, $end);
    }


    /**
     *  getRanges()
     *
     *  Method returns RRD graphs range data in multidimensional array.
     *
     *  @access     public
     *
     *  @return     array   Range data
     */
    public function getRanges()
    {
        $data = array();

        foreach($this->labels as $id => $label)
        {
            $data[] = array(
                        'ID'    =>  $id,
                        'Label' =>  $label,
                        );
        }

        return $data;
    }


    /**
     *  getImageData()
     *
     *  Method fetches actual RRD graph data and returns them as HTML string.
     *  Method calls external cgi-bin -script which actual creates graph images
     *  and used HTML for displaying them.
     *
     *  @access     public
     *
     *  @uses       \Module\GraphsTemperature\Model::getTimeRange()
     *  @uses       \Util\Request::getCurrentUrl()
     *
     *  @param      integer     $graphId    GraphId
     *  @param      integer     $range      Range
     *
     *  @return     string                  RRD graphs HTML.
     */
    public function getImageData($graphId, $range)
    {
        // List start and stop parameters
        list($start, $stop) = $this->getTimeRange($range);

        // Determine used cgi-bin script
        $cgi = (is_null($graphId)) ? 'temperatures_all.cgi' : 'temperature'. $graphId .'.cgi';

        // Specify used command to generate RRD image data
        $command = sprintf("export REQUEST_METHOD=GET && export QUERY_STRING=START=%s\&END=%s\&RRD=%s\&PATH=%s\&URL=%s\&IMGURL=%s\&TIME=%d && %shtml/cgi-bin/%s",
                    $start,
                    $stop,
                    $this->rrdPath,
                    BASEPATH . $this->rrdImages,
                    $this->request->getCurrentUrl(),
                    $this->request->getCurrentUrl() . $this->imgUrl,
                    time(),
                    BASEPATH,
                    $cgi
                    );

        ob_start();
            passthru($command);
            $html = ob_get_contents();
        ob_end_clean();

        return mb_substr($html, mb_strpos($html, '-->') + 3);
    }
}

?>
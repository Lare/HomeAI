<?php
/**
 *  \Module\Control\Model.php
 *
 *  @package    Module
 *  @subpackage Control
 *  @category   Model
 *
 *  @author  Lare
 *  @copyright  Lauri Laukkarinen
 */
namespace Module\Control;

defined('HOMEAI_MAINFILE') OR die('No direct access allowed.');
/**
 *  Model -class
 *
 *  Model class for board module.
 *
 *  @package    Module
 *  @subpackage Control
 *  @category   Model
 *
 *  @project
 *  @case
 *
 *  @author  Lare
 *  @copyright  Lauri Laukkarinen
 *
 *  @date       $Date: 2012-01-01 20:59:33 +0200 (Sun, 01 Jan 2012) $
 *  @version    $Rev: 35 $
 *  @author     $Author: lare $
 */
class Model extends \Module\Model implements Interfaces\iModel
{
    /**
     *  Temperature content file, note that this file contents is directly
     *  setted to main UI Temperature -section.
     */
    private $fileTemperature = 'data/temperatures.log';

    private $fileRelayControl = '/usr/local/bin/rbctl.sh';


    /**
     *  initialize()
     *
     *  Model initializer method.
     *
     *  @access     public
     *
     *  @return     void
     */
    public function initialize()
    {
        $this->fileTemperature = BASEPATH . $this->fileTemperature;
    }


    /**
     *  setRelayStatus()
     *
     *  Method sets defined relay status bit data.
     *
     *  Note that possible Exceptions must be catched elsewhere.
     *
     *  @access     public
     *
     *  @throws     Exception
     *
     *  @param      integer     $relayId    Relay ID
     *  @param      integer     $relayBit   Relay bit
     *  @param      integer     $status     Relay status
     *
     *  @return     void
     */
    public function setRelayStatus($relayId, $relayBit, $status)
    {
        if (file_exists($this->fileRelayControl))
        {
            $command = sprintf("sudo %s %d %d",
                        $this->fileRelayControl,
                        $status,
                        $relayBit
                        );

            $result = exec($command);

            if (!empty($result))
            {
                throw new Exception($result);
            }
        }

        $table = 'Relay';
        $data = array(
                    'Status' => $status,
                    );

        $this->dbh->update($table, $data, $relayId);
    }


    /**
     *  getControlsState()
     *
     *  Method returns current controls states as an array.
     *
     *  @access     public
     *
     *  @return     array   Controls states as an array.
     */
    public function getControlsState()
    {
        $query = "SELECT
                    R.`Status`
                FROM
                    `Relay` R
                ORDER BY
                    R.`Key` ASC
                ";

        try
        {
            $stmt = $this->dbh->query($query);
            $data = $stmt->fetchAll(\PDO::FETCH_COLUMN);
            $stmt->closeCursor();
            $stmt = NULL;
        }

        catch (\Exception $error)
        {
            // Write some error log
            #echo $error->getMessage();

            $data = array_fill(0, 8, 0);
        }

        return $data;
    }


    /**
     *  getTemperatureData()
     *
     *  Method returns temperature data from specified file. If file is not
     *  readable method will return error string.
     *
     *  @access     public
     *
     *  @uses       \Module\Control\Model::checkFile()
     *
     *  @return     string      Data
     */
    public function getTemperatureData()
    {
        try
        {
            $this->checkFile($this->fileTemperature);

            $data = utf8_encode(file_get_contents($this->fileTemperature));
        }

        // Error occured in checkFile() -method
        catch (Exception $error)
        {
            $data = $error->getMessage();
        }

        return $data;
    }


    /**
     *  getTemperatureHash()
     *
     *  Method returns temperature file sha1 HASH sum from specified file. If
     *  file is not readable method will return empty string.
     *
     *  @access     public
     *
     *  @uses       \Module\Control\Model::checkFile()
     *
     *  @return     string      Data
     */
    public function getTemperatureHash()
    {
        try
        {
            $this->checkFile($this->fileTemperature);

            $data = sha1_file($this->fileTemperature);
        }

        catch (Exception $error)
        {
            // Request made via AJAX
            if (!$this->request->isAjax())
            {
                // Todo: How to handle this case?
            }

            else
            {
                \UI\Message::setError($error->getMessage());
            }

            $data = '';
        }

        return $data;
    }


    /**
     *  getActions()
     *
     *  Method return array of actions which are shown in 'Control' -module.
     *  Note that this can be easily added or removed.
     *
     *  @access     public
     *
     *  @return     array   Action data
     */
    public function getActions()
    {
        $data = array(
                    array(
                        'URL'   =>  BASEURL ."?Module=GraphsTemperature",
                        'Title' =>  'Lämpötilagraafit',
                        ),
                    array(
                        'URL'   =>  BASEURL ."?Module=Timers",
                        'Title' =>  'Ajastukset',
                        ),
                    array(
                        'URL'   =>  BASEURL ."?Module=Events",
                        'Title' =>  'Tapahtumat',
                        ),
                    array(
                        'URL'   =>  BASEURL ."?Module=EggTimer",
                        'Title' =>  'Munakello',
                        ),
                    );

        return $data;
    }


    /**
     *  getControls()
     *
     *  Method return array of controls which are shown in 'Control' -module.
     *  Note that this can be easily added or removed.
     *
     *  @access     public
     *
     *  @return     array   Action data
     */
    public function getControls()
    {
        $query = "SELECT
                    R.`ID`      AS  'ID',
                    R.`Key`     AS  'Key',
                    R.`Name`    AS  'Name',
                    R.`Status`  AS  'Status'
                FROM
                    `Relay` R
                ORDER BY
                    R.`Key` ASC
                ";

        try
        {
            $stmt = $this->dbh->query($query);
            $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            $stmt = NULL;
        }

        catch (\Exception $error)
        {
            // Write some error log
            #echo $error->getMessage();

            $data = array();
        }

        return $data;
    }


    /**
     *  checkFile()
     *
     *  Method checks if defined file is readable or not. If not method will
     *  throw an Exception.
     *
     *  @access     protected
     *
     *  @throws     \Module\Control\Exception
     *
     *  @param      string  $file   File to check
     *
     *  @return     void
     */
    protected function checkFile($file)
    {
        if (!is_readable($file))
        {
            $message = sprintf("Couldn't read specified file: '%s', please check if file exists and it's readable.", $file);

            throw new Exception($message);
        }
    }
}

?>
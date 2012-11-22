<?php
/**
 *  \Core\Session.php
 *
 *  @package    HomeAI
 *  @subpackage Core
 *  @category   Session
 *
 *  @author  Lare
 *  @copyright  Lauri Laukkarinen
 */
namespace Core;
use DB\DBH as DBH;

defined('HOMEAI_MAINFILE') OR die('No direct access allowed.');
/**
 *  Session -class
 *
 *  This class process all session handling.
 *
 *  @package    HomeAI
 *  @subpackage Core
 *  @category   Session
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
class Session implements Interfaces\iSession
{
    /**
     *  Singleton class variable.
     *
     *  @access     protected
     *  @var        object
     */
    protected static $instance = NULL;

    /**
     *  Database handling class
     *
     *  @access     protected
     *  @var        object
     */
    protected $dbh = NULL;

    /**#@+
     *  Used private class variables
     *
     *  @access     private
     */

    /**
     *  Session time as in seconds
     *
     *  @var        integer
     */
    private $time;

    /**
     *  Session path an name strings.
     *
     *  @var        string
     */
    private $path;
    private $name;
    /**#@-*/


    /**
     *  __construct()
     *
     *  Construction of the class.
     *
     *  @access     protected
     *
     *  @see        PHP: session_set_save_handler <http://php.net/manual/function.session-set-save-handler.php>
     *  @see        PHP: register_shutdown_function <http://php.net/manual/function.register-shutdown-function.php>
     *  @see        PHP: session_start <http://php.net/manual/function.session-start.php>
     *
     *  @uses       \DB\DBH::getInstance()
     *
     *  @return     boolean
     */
    protected function __construct()
    {
        // Fetch database instance.
        $this->dbh = \DB\DBH::getInstance();

        // Set default session time, this will be changed after this.
        $this->time = 3600;

        $handler = session_set_save_handler(
                                        array($this, 'open'),
                                        array($this, 'close'),
                                        array($this, 'read'),
                                        array($this, 'write'),
                                        array($this, 'destroy'),
                                        array($this, 'gc')
                                        );

        if ((bool)$handler !== true)
        {
            trigger_error('Cannot set session save handler...', E_USER_ERROR);
        }

        register_shutdown_function('session_write_close');

        session_start();

        return true;
    }


    /**
     *  __destruct()
     *
     *  Destruction of the class.
     *
     *  @access     public
     *
     *  @uses       \Core\Session::close()
     *
     *  @return     boolean
     */
    public function __destruct()
    {
        $this->close();

        return true;
    }


    /**
     *  initialize()
     *
     *  Method initialize Session -class to use.
     *
     *  @access     public
     *
     *  @uses       \Core\Session::getInstance()
     *
     *  @return     object
     */
    public static function initialize()
    {
        if (is_null(Session::$instance))
        {
            Session::$instance = new Session;
        }

        return Session::$instance;
    }


    /**
     *  open()
     *
     *  General session open method.
     *
     *  @access     public
     *
     *  @param      string      $path
     *  @param      string      $name
     *
     *  @return     boolean
     */
    public function open($path, $name)
    {
        $this->path  = $path;
        $this->name  = $name;

        return true;
    }


    /**
     *  close()
     *
     *  General session close method.
     *
     *  @access     public
     *
     *  @uses       \Core\Session::gc()
     *
     *  @return     boolean
     */
    public function close()
    {
        $this->gc();

        return true;
    }


    /**
     *  read()
     *
     *  Session read method.
     *
     *  @access     public
     *
     *  @uses       \DB\DBH::query()
     *
     *  @param      string      $sessionId
     *
     *  @return     string
     */
    public function read($sessionId)
    {
        // Specify bindings for query
        $binds = array(
                    'sessionId' =>  $sessionId,
                    'expire'    =>  array(
                                        new \DateTime('now'),
                                        'datetime',
                                        ),
                    );

        // Specify used query
        $query = sprintf("
                    SELECT
                        S.`Data` AS 'sessionData'
                    FROM
                        `Session` S
                    WHERE
                        (1 = 1)
                        AND (S.`SessionID` = :sessionId)
                        AND (S.`Expire` > :expire)
                    "
                    );

        // Make query and fetch data
        $stmt = $this->dbh->query($query, $binds);
        $data = (string)$stmt->fetchColumn();
        $stmt->closeCursor();
        $stmt = NULL;

        return $data;
    }


    /**
     *  write()
     *
     *  Session write method.
     *
     *  @access     public
     *
     *  @uses       \Core\Session::isValid()
     *  @uses       \Core\Session::update()
     *  @uses       \Core\Session::insert()
     *
     *  @param      string      $sessionId
     *  @param      string      $sessionData
     *
     *  @return     boolean
     */
    public function write($sessionId, $sessionData)
    {
        $output = false;

        if ($this->isValid($sessionId))
        {
            $output = $this->update($sessionId, $sessionData);
        }

        elseif ($this->insert($sessionId, $sessionData))
        {
            $output = true;
        }

        else
        {
        }

        return $output;
    }


    /**
     *  update()
     *
     *  Session update method.
     *
     *  @access     protected
     *
     *  @uses       \DB\DBH::update()
     *
     *  @param      string      $sessionId
     *  @param      string      $sessionData
     *
     *  @return     boolean
     */
    protected function update($sessionId, $sessionData)
    {
        // Create required datetime objects
        $dateTimeCreate = new \DateTime('now');
        $dateTimeExpire = new \DateTime('now');

        // Specify update data
        $data = array(
                    'Data'      =>  $sessionData,
                    'Expire'    =>  array(
                                        $dateTimeExpire->add(new \DateInterval('PT'. $this->time .'S')),
                                        'datetime',
                                        ),
                    );

        // Specify used update conditions
        $conds = array(
                    'SessionID' =>  $sessionId,
                    );

        // Specify extra parameters for update
        $params = array(
                    DBH::PARAM_HISTORY => false,
                    );

        // Make actual update
        $rows = $this->dbh->update('Session', $data, $conds, $params);

        return ($rows === 1) ? true : false;
    }


    /**
     *  insert()
     *
     *  Session insert method.
     *
     *  @access     protected
     *
     *  @uses       \DB\DBH::insert()
     *
     *  @param      string      $sessionId      Session id
     *  @param      string      $sessionData    Session data
     *
     *  @return     boolean
     */
    protected function insert($sessionId, $sessionData)
    {
        // Create required datetime objects
        $dateTimeCreate = new \DateTime('now');
        $dateTimeExpire = new \DateTime('now');

        // Specify data for insert
        $data = array(
                    'SessionID' =>  $sessionId,
                    'Data'      =>  $sessionData,
                    'Create'    =>  $dateTimeCreate,
                    'Expire'    =>  $dateTimeExpire->add(new \DateInterval('PT'. $this->time .'S')),
                    );

        // Specify extra parameters for insert
        $params = array(
                    DBH::PARAM_HISTORY => false,
                    );

        // Make actual insert
        $id = $this->dbh->insert('Session', $data, $params);

        return ($id > 0) ? true : false;
    }


    /**
     *  destroy()
     *
     *  Session destroy method.
     *
     *  @access     public
     *
     *  @uses       \DB\DBH::delete()
     *
     *  @param      string      $sessionId      Session id
     *
     *  @return     boolean
     */
    public function destroy($sessionId)
    {
        // Specify data for insert
        $conds = array(
                    'SessionID' =>  $sessionId,
                    );

        // Make actual update
        $rows = $this->dbh->delete('Session', $conds);

        return ($rows === 1) ? true : false;
    }


    /**
     *  gc()
     *
     *  Session cleanup method.
     *
     *  @access     public
     *
     *  @uses       \DB\DBH::query()
     *
     *  @return     boolean
     */
    public function gc()
    {
        // Specify bindings for query
        $binds = array(
                    'expire'    =>  array(
                                        new \DateTime('now'),
                                        'datetime',
                                        ),
                    );

        // Specify used query
        $query = sprintf("
                    DELETE FROM
                        `Session`
                    WHERE
                        (1 = 1)
                        AND (`Expire` < :expire)
                    "
                    );

        // Make query and fetch data
        $stmt = $this->dbh->query($query, $binds);
        $stmt->closeCursor();
        $stmt = NULL;

        return true;
    }


    /**
     *  isValid()
     *
     *  Method determines if session exists already.
     *
     *  @access     public
     *
     *  @uses       \DB\DBH::query()
     *
     *  @param      string      $sessionId      Session id
     *
     *  @return     boolean
     */
    public function isValid($sessionId)
    {
        // Used query bindings
        $binds = array(
                    'sessionId' =>  $sessionId,
                    );

        // Specify used query.
        $query = sprintf("
                    SELECT
                        S.`ID`
                    FROM
                        `Session` S
                    WHERE
                        (1 = 1)
                        AND (S.`SessionID` = :sessionId)
                    "
                    );

        $stmt = $this->dbh->query($query, $binds);
        $output = (count($stmt->fetchAll()) === 1) ? true : false;
        $stmt->closeCursor();
        $stmt = NULL;

        return $output;
    }
}

?>

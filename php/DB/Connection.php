<?php
/**
 *  \DB\Connection.php
 *
 *  @package    DBH
 *  @subpackage Connection
 *  @category   Database
 *
 *  @author  Lare
 *  @copyright  Lauri Laukkarinen
 */
namespace DB;
use \Doctrine\DBAL as DBAL;

defined('HOMEAI_MAINFILE') OR die('No direct access allowed.');
/**
 *  Connection -class
 *
 *  Database connection class. Basicly this class makes database connection.
 *
 *  @package    DBH
 *  @subpackage Connection
 *  @category   Database
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
class Connection implements Interfaces\iConnection
{
    /**
     *  Singleton class variable.
     *
     *  @access     protected
     *  @var        object
     */
    protected static $instance = NULL;


    /**
     *  Instance of Doctrine\DBAL\Connection
     *
     *  @access     protected
     *  @var        object
     */
    protected $connection = NULL;


    /**
     *  __construct()
     *
     *  Construction of class.
     *
     *  @access     protected
     *
     *  @uses       \DB\Connection::makeConnection()
     *  @uses       \Util\Logger::logErrorCore()
     *
     *  @return     void
     */
    protected function __construct()
    {
        try
        {
            $this->makeConnection();
        }

        catch (\Exception $exception)
        {
            // Write error log
            \Util\Logger::logErrorCore($exception);

		echo $exception->getMessage();
		die();
            header("Location: ". BASEURL ."maintenance.php?Type=DB");
            exit(0);
        }
    }


    /**
     *  getInstance()
     *
     *  Instance getter method.
     *
     *  @access     public static
     *
     *  @uses       \DB\Connection::__construct()
     *
     *  @return     object      Instance of connection class.
     */
    public static function getInstance()
    {
        if (!self::$instance instanceof Connection)
        {
            self::$instance = new self();
        }

        return self::$instance;
    }


    /**
     *  getConnection()
     *
     *  Instance getter method.
     *
     *  @access     public static
     *
     *  @uses       \DB\Connection::getInstance()
     *  @uses       \DB\Connection::_getConnection()
     *
     *  @return     object      Instance of Doctrine\DBAL\Connection
     */
    public static function getConnection()
    {
        return self::getInstance()->_getConnection();
    }


    /**
     *  _getConnection()
     *
     *  Instance getter method.
     *
     *  @access     public
     *
     *  @return     object      Instance of Doctrine\DBAL\Connection
     */
    public function _getConnection()
    {
        return $this->connection;
    }


    /**
     *  makeConnection()
     *
     *  Method makes actual database connection to specified database using
     *  Doctrine components.
     *
     *  @access     protected
     *
     *  @uses       \Core\Config::readIni()
     *  @uses       \Doctrine\DBAL\Configuration
     *  @uses       \Doctrine\DBAL\DriverManager::getConnection()
     *
     *  @return     void
     */
    protected function makeConnection()
    {
        // Create DBAL configuration object
        $config = new DBAL\Configuration();

        // Try to read used connection parameters
        $parameters = \Core\Config::readIni('db.ini');

        // Create actual connection to database
        $this->connection = DBAL\DriverManager::getConnection($parameters, $config);

        // UTF-8 Magic
        $query = "SET NAMES UTF8";

        $this->connection->executeQuery($query);

        // TODO: Add some connection checks here...
    }
}

?>

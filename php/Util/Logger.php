<?php
/**
 *  \Util\Logger.php
 *
 *  @package    HomeAI
 *  @subpackage Util
 *  @category   Logger
 *
 *  @author  Lare
 *  @copyright  Lauri Laukkarinen
 */
namespace Util;

defined('HOMEAI_MAINFILE') OR die('No direct access allowed.');
/**
 *  Logger -class
 *
 *  General logger class to log different types of exceptions.
 *
 *  @package    HomeAI
 *  @subpackage Util
 *  @category   Logger
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
class Logger extends Debug implements Interfaces\iLogger
{
    /**
     *  Current logger type.
     *
     *  @access     protected static
     *  @var        string
     */
    protected static $type = NULL;

    /**#@+
     *  Used logger types, these are used to specify title for debug message.
     *
     *  @access     public
     *  @type       constant
     *  @var        string
     */
    const TYPE_CORE = 'Error in CORE initialization';
    const TYPE_QUERY = 'Error in SQL query';
    /**#@-*/


    /**
     *  logErrorCore()
     *
     *  @access     public static
     *
     *  @uses       \Util\Debug::__construct()
     *
     *  @param      Exception   $exception  Exception object
     *
     *  @return     void
     */
    public static function logErrorCore(&$exception)
    {
        Logger::$type = Logger::TYPE_CORE;

        new self($exception, 'core');
    }


    /**
     *  logErrorQuery()
     *
     *  @access     public static
     *
     *  @uses       \Util\Debug::__construct()
     *
     *  @param      Exception   $exception  Exception object
     *
     *  @return     void
     */
    public static function logErrorQuery(&$exception)
    {
        Logger::$type = Logger::TYPE_QUERY;

        new self($exception, 'query');
    }


    /**
     *  format()
     *
     *  Method formats defined log message from passed exception object.
     *
     *  @access     protected
     *
     *  @uses       \UI\Message::setError()
     *  @uses       \Util\Logger::parseTrace()
     *
     *  @param      Exception   $exception  Exception object
     *
     *  @return     void
     */
    protected function format(&$exception)
    {
        // Only accept real exceptions
        if (!$exception instanceof \Exception)
        {
            throw new Exception("Input parameter for '\Util\Logger' -class weren't instance of any Exception class...");
        }

        // Set error message for UI
        \UI\Message::setError($exception->getMessage(), Logger::$type);

        // Specify actual debug message
        $this->message = sprintf("%s %s\n%s\nBacktrace:\n%s",
                            $this->getStamp(),
                            Logger::$type,
                            $exception->getMessage(),
                            $this->parseTrace($exception->getTrace())
                            );
        return;
    }


    /**
     *  parseTrace()
     *
     *  Method parses exception backtrace and returns it as string.
     *
     *  @access     protected
     *
     *  @param      array       $trace  Exception debug backtrace
     *
     *  @return     string
     */
    protected function parseTrace(&$trace)
    {
        // Reset ouput
        $output = '';

        $i = 1;

        // Iterate trace
        foreach ($trace as $v)
        {
            // We are only interest if file and line are defined
            if (!isset($v['file']) || empty($v['line']))
            {
                continue;
            }

            $output .= sprintf("%d. %s:%d\n",
                            ($i),
                            $v['file'],
                            $v['line']
                            );

            $i++;
        }

        return $output;
    }
}

?>
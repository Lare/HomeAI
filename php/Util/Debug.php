<?php
/**
 *  \Util\Debug.php
 *
 *  @package    HomeAI
 *  @subpackage Util
 *  @category   Debug
 *
 *  @author  Lare
 *  @copyright  Lauri Laukkarinen
 */
namespace Util;

defined('HOMEAI_MAINFILE') OR die('No direct access allowed.');
/**
 *  Debug -class
 *
 *  Generic debug util class which can used to debug code.
 *
 *  Example of usage:
 *
 *  new \Util\Debug('This is a debug message...');
 *
 *  @package    HomeAI
 *  @subpackage Util
 *  @category   Debug
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
class Debug implements Interfaces\iDebug
{
    /**
     *  Debug message
     *
     *  @access     private
     *  @var        string
     */
    private $message = NULL;


    /**
     *  __construct()
     *
     *  Construction of the class.
     *
     *  @access     public
     *
     *  @uses       \Util\Debug::format()
     *  @uses       \Util\Debug::write()
     *
     *  @param      mixed   $message    Debug message
     *
     *  @return     void
     */
    public function __construct($message)
    {
        $this->format($message);
        $this->write();
    }


    /**
     *  format()
     *
     *  Method formats defined debug message.
     *
     *  @access     private
     *
     *  @param      mixed   $message    Debug message
     *
     *  @return     void
     */
    private function format(&$message)
    {
        if (is_array($message))
        {
            $message = print_r($message, true);
        }

        else
        {
        }

        $this->message = date('Y-m-d H:i:s') ." ". $message ."\n";
    }


    /**
     *  write()
     *
     *  Method writes defined debug message to filesystem.
     *
     *  @access     private
     *
     *  @return     void
     */
    private function write()
    {
       $file = BASEPATH ."log/debug.log";

        error_log($this->message, 3, $file);
    }
}

?>

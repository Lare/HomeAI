<?php
/**
 *  \UI\Message.php
 *
 *  @package    HomeAI
 *  @subpackage UI
 *  @category   Message
 *
 *  @author  Lare
 *  @copyright  Lauri Laukkarinen
 */
namespace UI;

defined('HOMEAI_MAINFILE') OR die('No direct access allowed.');
/**
 *  Message -class
 *
 *  General message -class to set messages which are shown to current user.
 *
 *  @package    HomeAI
 *  @subpackage UI
 *  @category   Message
 *
 *  @project
 *  @case
 *
 *  @author  Lare
 *  @copyright  Lauri Laukkarinen
 *
 *  @date       $Date: 2011-11-21 22:49:28 +0200 (Mon, 21 Nov 2011) $
 *  @version    $Rev: 6 $
 *  @author     $Author: lare $
 */
class Message implements Interfaces\iMessage
{
    /**#@+
     *  Message type constants
     *
     *  @access     public
     *  @type       constant
     *  @var        string
     */
    const TYPE_OK       = 'Ok';
    const TYPE_ERROR    = 'Error';
    /**#@-*/


    /**
     *  setError()
     *
     *  Method sets an error message which will be displayed in current page.
     *
     *  @access     public static
     *
     *  @uses       \UI\Message::setMessage()
     *
     *  @param      string      $message    Error message
     *  @param      string      $title      Error message title, not required
     *
     *  @return     void
     */
    public static function setError($message, $title = NULL)
    {
        Message::setMessage(Message::TYPE_ERROR, $message, $title);
    }


    /**
     *  setOk()
     *
     *  Method sets an ok message which will be displayed in current page.
     *
     *  @access     public static
     *
     *  @uses       \UI\Message::setMessage()
     *
     *  @param      string      $message    Ok message
     *  @param      string      $title      Ok message title, not required
     *
     *  @return     void
     */
    public static function setOk($message, $title = NULL)
    {
        Message::setMessage(Message::TYPE_OK, $message, $title);
    }


    /**
     *  setMessage()
     *
     *  Method saves message to session.
     *
     *  @access     private static
     *
     *  @param      constant    $type       Message type, see \UI\Message::TYPE_* -constants.
     *  @param      string      $message    Message
     *  @param      string      $title      Message title
     *
     *  @return     void
     */
    private static function setMessage($type, &$message, &$title)
    {
        // Messages are not yet initialized
        if (!isset($_SESSION['Message'][$type]))
        {
            $_SESSION['Message'][$type] = array();
        }

        // Add message data to session
        $temp = array(
                    'Message'   =>  $message,
                    'Title'     =>  $title,
                    );

        $_SESSION['Message'][$type][] = $temp;

        unset($temp);
    }
}

?>
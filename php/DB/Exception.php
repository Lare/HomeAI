<?php
/**
 *  \DB\Exception.php
 *
 *  @package    HomeAI
 *  @subpackage Database
 *  @category   Exception
 *
 *  @author  Lare
 *  @copyright  Lauri Laukkarinen
 */
namespace DB;

defined('HOMEAI_MAINFILE') OR die('No direct access allowed.');
/**
 *  Exception -class
 *
 *  DB exception class.
 *
 *  @package    HomeAI
 *  @subpackage Database
 *  @category   Exception
 *
 *  @project
 *  @case
 *
 *  @author  Lare
 *  @copyright  Lauri Laukkarinen
 *
 *  @date       $Date: 2011-12-31 11:57:11 +0200 (Sat, 31 Dec 2011) $
 *  @version    $Rev: 23 $
 *  @author     $Author: lare $
 */
class Exception extends \Core\Exception
{
    public function __construct($message = null, $code = 0, Exception $previous = null)
    {
        $message = \Util\Strings::clean($message);

        parent::__construct($message, $code, $previous);
    }
}

?>
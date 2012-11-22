<?php
/**
 *  \Core\Interfaces\iSession.php
 *
 *  @package    HomeAI
 *  @subpackage Core
 *  @category   Interface
 *
 *  @author  Lare
 *  @copyright  Lauri Laukkarinen
 */
namespace Core\Interfaces;

defined('HOMEAI_MAINFILE') OR die('No direct access allowed.');
/**
 *  iSession interface
 *
 *  Interface for \Core\Session -class.
 *
 *  @package    HomeAI
 *  @subpackage Core
 *  @category   Interface
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
interface iSession
{
    public function __destruct();
    public static function initialize();
    public function open($path, $name);
    public function close();
    public function read($sessionId);
    public function write($sessionId, $sessionData);
    public function destroy($sessionId);
    public function gc();
    public function isValid($sessionId);
}

?>
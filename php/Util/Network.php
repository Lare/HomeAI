<?php
/**
 *  \Util\Network.php
 *
 *  @package    HomeAI
 *  @subpackage Util
 *  @category   Network
 *
 *  @author  Lare
 *  @copyright  Lauri Laukkarinen
 */
namespace Util;

defined('HOMEAI_MAINFILE') OR die('No direct access allowed.');
/**
 *  Network -class
 *
 *  Util class for common network functions.
 *
 *  @package    HomeAI
 *  @subpackage Util
 *  @category   Network
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
class Network implements Interfaces\iNetwork
{
    /**
     *  getIp()
     *
     *  Method returns user ip -address.
     *
     *  @access     public static
     *
     *  @return     string      User ip address
     */
    public static function getIp()
    {
        return $_SERVER["REMOTE_ADDR"];
    }


    /**
     *  getHost()
     *
     *  Method returns user ip -address hostname.
     *
     *  @access     public static
     *
     *  @return     string      User ip address hostname
     */
    public static function getHost()
    {
        return gethostbyaddr($_SERVER["REMOTE_ADDR"]);
    }


    /**
     *  getHostIp()
     *
     *  Method returns defined hostname ip -address.
     *
     *  @access     public static
     *
     *  @param      string      $host   Hostname
     *
     *  @return     string              Hostname ip -address
     */
    public static function getHostIp($host)
    {
        return gethostbyname($host);
    }


    /**
     *  getAgent()
     *
     *  Method returns user agent information.
     *
     *  @access     public static
     *
     *  @return     string      User ip address hostname
     */
    public static function getAgent()
    {
        return $_SERVER['HTTP_USER_AGENT'];
    }
}

?>
<?php
/**
 *  \Util\Interfaces\iRequest.php
 *
 *  @package    HomeAI
 *  @subpackage Util
 *  @category   Interface
 *
 *  @author  Lare
 *  @copyright  Lauri Laukkarinen
 */
namespace Util\Interfaces;

defined('HOMEAI_MAINFILE') OR die('No direct access allowed.');
/**
 *  iRequest interface
 *
 *  Interface for \Util\Request -class.
 *
 *  @package    HomeAI
 *  @subpackage Util
 *  @category   Interface
 *
 *  @project
 *  @case
 *
 *  @author  Lare
 *  @copyright  Lauri Laukkarinen
 *
 *  @date       $Date: 2011-11-22 22:40:01 +0200 (Tue, 22 Nov 2011) $
 *  @version    $Rev: 18 $
 *  @author     $Author: lare $
 */
interface iRequest
{
    public function __construct();
    public function set($key, $value);
    public function setParams(array $array);
    public function setQuery($key, $value = NULL);
    public function setPost($key, $value = NULL);
    public function setSession($key, $value = NULL);
    public function setRequestUri($requestUri = NULL);
    public function setBaseUrl($baseUrl = NULL);
    public function setBasePath($basePath = NULL);
    public function setPathInfo($pathInfo = NULL);
    public function get($key = NULL, $default = NULL);
    public function getRequestUri();
    public function getBaseUrl($raw = false);
    public function getBasePath();
    public function getPathInfo();
    public function getQuery($key = NULL, $default = NULL);
    public function getPost($key = NULL, $default = NULL);
    public function getSession($key = NULL, $default = NULL);
    public function getCookie($key = NULL, $default = NULL);
    public function getServer($key = NULL, $default = NULL);
    public function getEnv($key = NULL, $default = NULL);
    public function getMethod();
    public function getRawBody($force = false);
    public function getHeader($header);
    public function getScheme();
    public function getHttpHost();
    public function getCurrentUrl();
    public function getClientIp($checkProxy = true);
    public function isPost();
    public function isGet();
    public function isPut();
    public function isDelete();
    public function isHead();
    public function isOptions();
    public function isAjax();
    public function isSecure();
}

?>
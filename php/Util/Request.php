<?php
/**
 *  \Util\Request.php
 *
 *  @package    HomeAI
 *  @subpackage Util
 *  @category   Request
 *
 *  @author     Lare
 *  @copyright  Lauri Laukkarinen
 */
namespace Util;

defined('HOMEAI_MAINFILE') OR die('No direct access allowed.');
/**
 *  Request -class
 *
 *  Generic request helper class which encapsulate request data into the one
 *  object providing a single channel for request data access and manipulation.
 *
 *  @package    HomeAI
 *  @subpackage Util
 *  @category   Request
 *
 *  @project
 *  @case
 *
 *  @author     Lare
 *  @copyright  Lauri Laukkarinen
 *
 *  @date       $Date: 2011-11-22 22:40:01 +0200 (Tue, 22 Nov 2011) $
 *  @version    $Rev: 18 $
 *  @author     $Author: lare $
 */
class Request implements Interfaces\iRequest
{
    /**#@+
     *  Used scheme constants
     *
     *  @access     public
     *  @var        constant
     */
    const SCHEME_HTTP  = 'http';
    const SCHEME_HTTPS = 'https';
    /**#@-*/

    /**
     *  Holds collective request data
     *
     *  @access     protected
     *  @var        array
     */
    protected $_params = array();

    /**
     *  Raw request body. Can be string or boolean false. If false raw body
     *  for request is not present.
     *
     *  @access     protected
     *  @var        mixed
     */
    protected $_rawBody = NULL;

    /**
     *  REQUEST_URI
     *
     *  @access     protected
     *  @var        string;
     */
    protected $_requestUri = '';

    /**
     *  Base URL of request
     *
     *  @access     protected
     *  @var        string
     */
    protected $_baseUrl = NULL;

    /**
     *  Base path of request
     *
     *  @access     protected
     *  @var        string
     */
    protected $_basePath = NULL;

    /**
     *  PATH_INFO
     *
     *  @access     protected
     *  @var        string
     */
    protected $_pathInfo = '';


    /**
     *  __construct()
     *
     *  Construction of the class. Stores "request data" in GPC order.
     *
     *  @access     public
     *
     *  @uses       \Util\Request::setParams()
     *  @uses       \Util\Request::setRequestUri()
     *
     *  @return     void
     */
    public function __construct()
    {
        $this->setParams($_REQUEST);

        $this->setRequestUri();
    }


    /**
     *  set()
     *
     *  Sets a single parameter. A $value of null will unset the $key
     *  if it exists.
     *
     *  @access     public
     *
     *  @param      string  $key
     *  @param      mixed   $value
     *
     *  @return     void
     */
    public function set($key, $value)
    {
        $key = (string)$key;

        if (is_null($value) && isset($this->_params[$key]))
        {
            unset($this->_params[$key]);
        }

        elseif (!is_null($value))
        {
            $this->_params[$key] = $value;
        }

        return $this;
    }


    /**
     *  setParams()
     *
     *  Set action parameters en masse; does not overwrite. Null values will
     *  unset the associated key.
     *
     *  @access     public
     *
     *  @param      array   $array
     *
     *  @return     void
     */
    public function setParams(array $array)
    {
        $this->_params = $this->_params + (array)$array;

        foreach ($array as $key => $value)
        {
            if (is_null($value))
            {
                unset($this->_params[$key]);
            }
        }
    }


    /**
     *  setQuery()
     *
     *  Set GET values.
     *
     *  @access     public
     *
     *  @throws     \Util\Exception
     *
     *  @uses       \Util\Request::setQuery()
     *
     *  @param      mixed   $key
     *  @param      mixed   $value
     *
     *  @return     void
     */
    public function setQuery($key, $value = NULL)
    {
        if (is_null($value) && !is_array($key))
        {
            throw new Exception('Invalid value passed to setQuery(); must be either array of values or key/value pair');
        }

        if (is_null($value) && is_array($key))
        {
            foreach ($key as $_key => $value)
            {
                $this->setQuery($_key, $value);
            }

            return;
        }

        $_GET[(string) $key] = $value;
    }


    /**
     *  setPost()
     *
     *  Set POST values.
     *
     *  @access     public
     *
     *  @throws     \Util\Exception
     *
     *  @uses       \Util\Request::setPost()
     *
     *  @param      mixed   $key
     *  @param      mixed   $value
     *
     *  @return     void
     */
    public function setPost($key, $value = NULL)
    {
        if (is_null($value) && !is_array($key))
        {
            throw new Exception('Invalid value passed to setPost(); must be either array of values or key/value pair');
        }

        if (is_null($value) && is_array($key))
        {
            foreach ($key as $_key => $value)
            {
                $this->setPost($_key, $value);
            }

            return;
        }

        $_POST[(string) $key] = $value;
    }


    /**
     *  setSession()
     *
     *  Set SESSION values.
     *
     *  @access     public
     *
     *  @throws     \Util\Exception
     *
     *  @uses       \Util\Request::setSession()
     *
     *  @param      mixed   $key
     *  @param      mixed   $value
     *
     *  @return     void
     */
    public function setSession($key, $value = NULL)
    {
        if (is_null($value) && !is_array($key))
        {
            throw new Exception('Invalid value passed to setSession(); must be either array of values or key/value pair');
        }

        if (is_null($value) && is_array($key))
        {
            foreach ($key as $_key => $value)
            {
                $this->setSession($_key, $value);
            }

            return;
        }

        $_SESSION[(string) $key] = $value;
    }


    /**
     *  setRequestUri()
     *
     *  Set the REQUEST_URI on which the instance operates
     *
     *  If no request URI is passed, uses the value in $_SERVER['REQUEST_URI'],
     *  $_SERVER['HTTP_X_REWRITE_URL'], or $_SERVER['ORIG_PATH_INFO'] + $_SERVER['QUERY_STRING'].
     *
     *  @access     public
     *
     *  @throws     \Util\Exception
     *
     *  @uses       \Util\Request::getScheme()
     *  @uses       \Util\Request::getHttpHost()
     *  @uses       \Util\Request::setQuery()
     *
     *  @param      string      $requestUri
     *
     *  @return     void
     */
    public function setRequestUri($requestUri = NULL)
    {
        if (is_null($requestUri))
        {
            if (isset($_SERVER['REQUEST_URI']))
            {
                $requestUri = $_SERVER['REQUEST_URI'];

                // Http proxy reqs setup request uri with scheme and host [and port] + the url path, only use url path
                $schemeAndHttpHost = $this->getScheme() . '://' . $this->getHttpHost();

                if (strpos($requestUri, $schemeAndHttpHost) === 0)
                {
                    $requestUri = substr($requestUri, strlen($schemeAndHttpHost));
                }
            }

            else
            {
                throw new Exception("Couldn't determine request URI.");
            }
        }

        elseif (!is_string($requestUri))
        {
            throw new Exception("Required parameter 'requestUri' is not string.");
        }

        else
        {
            // Set GET items, if available
            if (($pos = strpos($requestUri, '?')) !== false)
            {
                // Get key => value pairs and set $_GET
                $query = substr($requestUri, $pos + 1);

                parse_str($query, $vars);

                $this->setQuery($vars);
            }
        }

        $this->_requestUri = $requestUri;
    }


    /**
     *  Set the base URL of the request; i.e., the segment leading to the script name
     *
     *  Examples:
     *   - /admin
     *   - /myapp
     *   - /subdir/index.php
     *
     *  Do not use the full URI when providing the base. The following are
     *  examples of what not to use:
     *   - http://example.com/admin (should be just /admin)
     *   - http://example.com/subdir/index.php (should be just /subdir/index.php)
     *
     *  If no $baseUrl is provided, attempts to determine the base URL from the
     *  environment, using SCRIPT_FILENAME, SCRIPT_NAME, PHP_SELF, and ORIG_SCRIPT_NAME
     *  in its determination.
     *
     *  @access     public
     *
     *  @throws     \Util\Exception
     *
     *  @uses       \Util\Request::getRequestUri()
     *
     *  @param      mixed   $baseUrl
     *
     *  @return     void
     */
    public function setBaseUrl($baseUrl = NULL)
    {
        if (!is_null($baseUrl) && !is_string($baseUrl))
        {
            throw new Exception("Required parameter 'baseUrl' is not string nor NULL.");
        }

        if (is_null($baseUrl))
        {
            $filename = (isset($_SERVER['SCRIPT_FILENAME'])) ? basename($_SERVER['SCRIPT_FILENAME']) : '';

            if (isset($_SERVER['SCRIPT_NAME']) && basename($_SERVER['SCRIPT_NAME']) === $filename)
            {
                $baseUrl = $_SERVER['SCRIPT_NAME'];
            }

            elseif (isset($_SERVER['PHP_SELF']) && basename($_SERVER['PHP_SELF']) === $filename)
            {
                $baseUrl = $_SERVER['PHP_SELF'];
            }

            elseif (isset($_SERVER['ORIG_SCRIPT_NAME']) && basename($_SERVER['ORIG_SCRIPT_NAME']) === $filename)
            {
                $baseUrl = $_SERVER['ORIG_SCRIPT_NAME']; // 1and1 shared hosting compatibility
            }

            // Backtrack up the script_filename to find the portion matching php_self
            else
            {
                $path    = isset($_SERVER['PHP_SELF']) ? $_SERVER['PHP_SELF'] : '';
                $file    = isset($_SERVER['SCRIPT_FILENAME']) ? $_SERVER['SCRIPT_FILENAME'] : '';
                $segs    = explode('/', trim($file, '/'));
                $segs    = array_reverse($segs);
                $index   = 0;
                $last    = count($segs);
                $baseUrl = '';

                do {
                    $seg     = $segs[$index];
                    $baseUrl = '/' . $seg . $baseUrl;
                    ++$index;
                } while (($last > $index) && (false !== ($pos = strpos($path, $baseUrl))) && (0 != $pos));
            }

            // Does the baseUrl have anything in common with the request_uri?
            $requestUri = $this->getRequestUri();

            // full $baseUrl matches
            if (strpos($requestUri, $baseUrl) === 0)
            {
                $this->_baseUrl = $baseUrl;

                return;
            }

            // directory portion of $baseUrl matches
            if (strpos($requestUri, dirname($baseUrl)) === 0)
            {
                $this->_baseUrl = rtrim(dirname($baseUrl), '/');

                return;
            }

            $truncatedRequestUri = $requestUri;

            if (($pos = strpos($requestUri, '?')) !== false)
            {
                $truncatedRequestUri = substr($requestUri, 0, $pos);
            }

            $basename = basename($baseUrl);

            // no match whatsoever; set it blank
            if (empty($basename) || !strpos($truncatedRequestUri, $basename))
            {
                $this->_baseUrl = '';

                return;
            }

            /**
             *  If using mod_rewrite or ISAPI_Rewrite strip the script filename
             *  out of baseUrl. $pos !== 0 makes sure it is not matching a value
             *  from PATH_INFO or QUERY_STRING
             */
            if ((strlen($requestUri) >= strlen($baseUrl))
                && ((false !== ($pos = strpos($requestUri, $baseUrl))) && ($pos !== 0)))
            {
                $baseUrl = substr($requestUri, 0, $pos + strlen($baseUrl));
            }
        }

        $this->_baseUrl = rtrim($baseUrl, '/');

        return;
    }


    /**
     *  setBasePath()
     *
     *  Set the base path for the URL
     *
     *  @access     public
     *
     *  @uses       \Util\Request::getBaseUrl()
     *
     *  @param      mixed   $basePath
     *
     *  @return     void
     */
    public function setBasePath($basePath = NULL)
    {
        if (is_null($basePath))
        {
            $filename = (isset($_SERVER['SCRIPT_FILENAME'])) ? basename($_SERVER['SCRIPT_FILENAME']) : '';

            $baseUrl = $this->getBaseUrl();

            if (empty($baseUrl))
            {
                $this->_basePath = '';

                return;
            }

            if (basename($baseUrl) === $filename)
            {
                $basePath = dirname($baseUrl);
            }

            else
            {
                $basePath = $baseUrl;
            }
        }

        if (substr(PHP_OS, 0, 3) === 'WIN')
        {
            $basePath = str_replace('\\', '/', $basePath);
        }

        $this->_basePath = rtrim($basePath, '/');

        return;
    }


    /**
     *  setPathInfo()
     *
     *  Set the PATH_INFO string
     *
     *  @access     public
     *
     *  @uses       \Util\Request::getBaseUrl
     *  @uses       \Util\Request::getRequestUri
     *
     *  @param      mixed   $pathInfo
     *
     *  @return     void
     */
    public function setPathInfo($pathInfo = NULL)
    {
        if (is_null($pathInfo))
        {
            $baseUrl = $this->getBaseUrl();
            $baseUrlRaw = $this->getBaseUrl(false);
            $baseUrlEncoded = urlencode($baseUrlRaw);

            if (is_null($requestUri = $this->getRequestUri()))
            {
                return;
            }

            // Remove the query string from REQUEST_URI
            if ($pos = strpos($requestUri, '?'))
            {
                $requestUri = substr($requestUri, 0, $pos);
            }

            if (!empty($baseUrl) || !empty($baseUrlRaw))
            {
                if (strpos($requestUri, $baseUrl) === 0)
                {
                    $pathInfo = substr($requestUri, strlen($baseUrl));
                }

                elseif (strpos($requestUri, $baseUrlRaw) === 0)
                {
                    $pathInfo = substr($requestUri, strlen($baseUrlRaw));
                }

                elseif (strpos($requestUri, $baseUrlEncoded) === 0)
                {
                    $pathInfo = substr($requestUri, strlen($baseUrlEncoded));
                }

                else
                {
                    $pathInfo = $requestUri;
                }
            }

            else
            {
                $pathInfo = $requestUri;
            }
        }

        $this->_pathInfo = (string)$pathInfo;
    }


    /**
     *  get()
     *
     *  Read stored "request data" by referencing a key.
     *
     *  @access     public
     *
     *  @uses       \Util\Request::fetchArrayValue()
     *
     *  @param      mixed   $key
     *  @param      mixed   $default    Default value to use if key not found
     *
     *  @return     mixed               Returns null if key does not exist
     */
    public function get($key = NULL, $default = NULL)
    {
        if (is_null($key))
        {
            return $this->_params;
        }

        if (is_array($key))
        {
            return $this->fetchArrayValue($this->_params, $key, $default);
        }

        return (isset($this->_params[$key])) ? $this->_params[$key] : $default;
    }


    /**
     *  getRequestUri()
     *
     *  Returns current REQUEST_URI.
     *
     *  @access     public
     *
     *  @uses       \Util\Request::setRequestUri()
     *
     *  @return     string
     */
    public function getRequestUri()
    {
        if (empty($this->_requestUri))
        {
            $this->setRequestUri();
        }

        return $this->_requestUri;
    }


    /**
     *  getBaseUrl()
     *
     *  Everything in REQUEST_URI before PATH_INFO
     *  <form action="<?=$baseUrl?>/news/submit" method="POST"/>
     *
     *  @access     public
     *
     *  @uses       \Util\Request::setBaseUrl()
     *
     *  @param      boolean     $raw
     *
     *  @return     string
     */
    public function getBaseUrl($raw = false)
    {
        if (is_null($this->_baseUrl))
        {
            $this->setBaseUrl();
        }

        return ($raw == false) ? urldecode($this->_baseUrl) : $this->_baseUrl;
    }


    /**
     *  getBasePath()
     *
     *  Everything in REQUEST_URI before PATH_INFO not including the filename.
     *
     *  @access     public
     *
     *  @uses       \Util\Request::setBasePath()
     *
     *  @return     string
     */
    public function getBasePath()
    {
        if (is_null($this->_basePath))
        {
            $this->setBasePath();
        }

        return $this->_basePath;
    }


    /**
     *  getPathInfo()
     *
     *  Returns everything between the BaseUrl and QueryString.
     *  This value is calculated instead of reading PATH_INFO
     *  directly from $_SERVER due to cross-platform differences.
     *
     *  @access     public
     *
     *  @uses       \Util\Request::setPathInfo()
     *
     *  @return     string
     */
    public function getPathInfo()
    {
        if (empty($this->_pathInfo))
        {
            $this->setPathInfo();
        }

        return $this->_pathInfo;
    }


    /**
     *  getQuery()
     *
     *  Retrieve a member of the $_GET superglobal. If no $key is passed,
     *  returns the entire $_GET array.
     *
     *  @access     public
     *
     *  @uses       \Util\Request::fetchArrayValue()
     *
     *  @param      mixed   $key
     *  @param      mixed   $default    Default value to use if key not found
     *
     *  @return     mixed               Returns null if key does not exist
     */
    public function getQuery($key = NULL, $default = NULL)
    {
        if (is_null($key))
        {
            return $_GET;
        }

        if (is_array($key))
        {
            return $this->fetchArrayValue($_GET, $key, $default);
        }

        return (isset($_GET[$key])) ? $_GET[$key] : $default;
    }


    /**
     *  getPost()
     *
     *  Retrieve a member of the $_POST superglobal. If no $key is passed,
     *  returns the entire $_POST array.
     *
     *  @access     public
     *
     *  @uses       \Util\Request::fetchArrayValue()
     *
     *  @param      mixed   $key
     *  @param      mixed   $default    Default value to use if key not found
     *
     *  @return     mixed               Returns null if key does not exist
     */
    public function getPost($key = NULL, $default = NULL)
    {
        if (is_null($key))
        {
            return $_POST;
        }

        if (is_array($key))
        {
            return $this->fetchArrayValue($_POST, $key, $default);
        }

        return (isset($_POST[$key])) ? $_POST[$key] : $default;
    }


    /**
     *  getSession()
     *
     *  Retrieve a member of the $_SESSION superglobal. If no $key is passed,
     *  returns the entire $_SESSION array.
     *
     *  @access     public
     *
     *  @uses       \Util\Request::fetchArrayValue()
     *
     *  @param      mixed   $key
     *  @param      mixed   $default    Default value to use if key not found
     *
     *  @return     mixed               Returns null if key does not exist
     */
    public function getSession($key = NULL, $default = NULL)
    {
        if (is_null($key))
        {
            return $_SESSION;
        }

        if (is_array($key))
        {
            return $this->fetchArrayValue($_SESSION, $key, $default);
        }

        return (isset($_SESSION[$key])) ? $_SESSION[$key] : $default;
    }


    /**
     *  getCookie()
     *
     *  Retrieve a member of the $_COOKIE superglobal. If no $key is passed,
     *  returns the entire $_COOKIE array.
     *
     *  @access     public
     *
     *  @uses       \Util\Request::fetchArrayValue()
     *
     *  @param      mixed   $key
     *  @param      mixed   $default    Default value to use if key not found
     *
     *  @return     mixed               Returns null if key does not exist
     */
    public function getCookie($key = NULL, $default = NULL)
    {
        if (is_null($key))
        {
            return $_COOKIE;
        }

        if (is_array($key))
        {
            return $this->fetchArrayValue($_COOKIE, $key, $default);
        }

        return (isset($_COOKIE[$key])) ? $_COOKIE[$key] : $default;
    }


    /**
     *  getServer()
     *
     *  Retrieve a member of the $_SERVER superglobal. If no $key is passed,
     *  returns the entire $_SERVER array.
     *
     *  @access     public
     *
     *  @uses       \Util\Request::fetchArrayValue()
     *
     *  @param      mixed   $key
     *  @param      mixed   $default    Default value to use if key not found
     *
     *  @return     mixed               Returns null if key does not exist
     */
    public function getServer($key = NULL, $default = NULL)
    {
        if (is_null($key))
        {
            return $_SERVER;
        }

        if (is_array($key))
        {
            return $this->fetchArrayValue($_SERVER, $key, $default);
        }

        return (isset($_SERVER[$key])) ? $_SERVER[$key] : $default;
    }


    /**
     *  getEnv()
     *
     *  Retrieve a member of the $_ENV superglobal. If no $key is passed,
     *  returns the entire $_ENV array.
     *
     *  @access     public
     *
     *  @uses       \Util\Request::fetchArrayValue()
     *
     *  @param      mixed   $key
     *  @param      mixed   $default    Default value to use if key not found
     *
     *  @return     mixed               Returns null if key does not exist
     */
    public function getEnv($key = NULL, $default = NULL)
    {
        if (is_null($key))
        {
            return $_ENV;
        }

        if (is_array($key))
        {
            return $this->fetchArrayValue($_ENV, $key, $default);
        }

        return (isset($_ENV[$key])) ? $_ENV[$key] : $default;
    }


    /**
     *  getMethod()
     *
     *  Return the method by which the request was made
     *
     *  @access     public
     *
     *  @uses       \Util\Request::getServer()
     *
     *  @return     string
     */
    public function getMethod()
    {
        return $this->getServer('REQUEST_METHOD');
    }


    /**
     *  getRawBody()
     *
     *  Return the raw body of the request if present.
     *
     *  @access     public
     *
     *  @param      boolean $force  Force to use php://input
     *
     *  @return     mixed           Raw body as string or false if not present.
     */
    public function getRawBody($force = false)
    {
        if (is_null($this->_rawBody) || $force === true)
        {
            $body = file_get_contents('php://input');

            $this->_rawBody = (strlen(trim($body)) > 0) ? $body : false;
        }

        return $this->_rawBody;
    }


    /**
     *  getHeader()
     *
     *  Return the value of the given HTTP header. Pass the header name as the
     *  plain, HTTP-specified header name. Ex.: Ask for 'Accept' to get the
     *  Accept header, 'Accept-Encoding' to get the Accept-Encoding header.
     *
     *  @access     public
     *
     *  @param      string  $header     HTTP header name
     *
     *  @return     mixed               HTTP header value, or false if not found
     */
    public function getHeader($header)
    {
        if (empty($header))
        {
            return false;
        }

        // Try to get it from the $_SERVER array first
        $temp = 'HTTP_' . mb_strtoupper(str_replace('-', '_', $header));

        if (isset($_SERVER[$temp]))
        {
            return $_SERVER[$temp];
        }

        // This seems to be the only way to get the Authorization header on Apache
        if (function_exists('apache_request_headers'))
        {
            $headers = apache_request_headers();

            if (isset($headers[$header]))
            {
                return $headers[$header];
            }

            $header = strtolower($header);

            foreach ($headers as $key => $value)
            {
                if (strtolower($key) == $header)
                {
                    return $value;
                }
            }
        }

        return false;
    }


    /**
     *  getScheme()
     *
     *  Get the request URI scheme
     *
     *  @access     public
     *
     *  @uses       \Util\Request::getServer()
     *
     *  @return     string
     */
    public function getScheme()
    {
        return ($this->getServer('HTTPS') == 'on') ? self::SCHEME_HTTPS : self::SCHEME_HTTP;
    }


    /**
     *  getHttpHost()
     *
     *  Get the HTTP host. "Host" ":" host [ ":" port ] ; Section 3.2.2
     *  Note the HTTP Host header is not the same as the URI host. It includes
     *  the port while the URI host doesn't.
     *
     *  @access     public
     *
     *  @uses       \Util\Request::getServer()
     *  @uses       \Util\Request::getScheme()
     *
     *  @return     string
     */
    public function getHttpHost()
    {
        $host = $this->getServer('HTTP_HOST');

        if (!empty($host))
        {
            return $host;
        }

        $scheme = $this->getScheme();
        $name   = $this->getServer('SERVER_NAME');
        $port   = $this->getServer('SERVER_PORT');

        if(null === $name)
        {
            return '';
        }

        elseif (($scheme == self::SCHEME_HTTP && $port == 80) || ($scheme == self::SCHEME_HTTPS && $port == 443))
        {
            return $name;
        }

        else
        {
            return $name .':'. $port;
        }
    }


    /**
     *  getCurrentUrl()
     *
     *  Get current url definition.
     *
     *  @access     public
     *
     *  @uses       \Util\Request::getScheme()
     *  @uses       \Util\Request::getHttpHost()
     *  @uses       \Util\Request::getBaseUrl()
     *
     *  @return     string
     */
    public function getCurrentUrl()
    {
        return $this->getScheme() ."://". $this->getHttpHost() . $this->getBaseUrl() ."/";
    }


    /**
     *  getClientIp()
     *
     *  Get the client's IP address
     *
     *  @access     public
     *
     *  @param      boolean     $checkProxy
     *
     *  @return     string
     */
    public function getClientIp($checkProxy = true)
    {
        if ($checkProxy && !is_null($this->getServer('HTTP_CLIENT_IP')))
        {
            $ip = $this->getServer('HTTP_CLIENT_IP');
        }

        elseif ($checkProxy && !is_null($this->getServer('HTTP_X_FORWARDED_FOR')))
        {
            $ip = $this->getServer('HTTP_X_FORWARDED_FOR');
        }

        else
        {
            $ip = $this->getServer('REMOTE_ADDR');
        }

        return $ip;
    }


    /**
     *  isPost()
     *
     *  Was the request made by POST?
     *
     *  @access     public
     *
     *  @return     boolean
     */
    public function isPost()
    {
        return ($this->getMethod() == 'POST') ? true : false;
    }


    /**
     *  isGet()
     *
     *  Was the request made by GET?
     *
     *  @access     public
     *
     *  @return     boolean
     */
    public function isGet()
    {
        return ($this->getMethod() == 'GET') ? true : false;
    }


    /**
     *  isPut()
     *
     *  Was the request made by PUT?
     *
     *  @access     public
     *
     *  @return     boolean
     */
    public function isPut()
    {
        return ($this->getMethod() == 'PUT') ? true : false;
    }


    /**
     *  isDelete()
     *
     *  Was the request made by DELETE?
     *
     *  @access     public
     *
     *  @return     boolean
     */
    public function isDelete()
    {
        return ($this->getMethod() == 'DELETE') ? true : false;
    }


    /**
     *  isHead()
     *
     *  Was the request made by HEAD?
     *
     *  @access     public
     *
     *  @return     boolean
     */
    public function isHead()
    {
        return ($this->getMethod() == 'HEAD') ? true : false;
    }


    /**
     *  isOptions()
     *
     *  Was the request made by OPTIONS?
     *
     *  @access     public
     *
     *  @return     boolean
     */
    public function isOptions()
    {
        return ($this->getMethod() == 'OPTIONS') ? true : false;
    }


    /**
     *  isAjax()
     *
     *  Is the request a Javascript XMLHttpRequest or not? Should work with
     *  Prototype/Script.aculo.us, jQuery, etc.
     *
     *  @access     public
     *
     *  @return     boolean
     */
    public function isAjax()
    {
        return ($this->getHeader('X_REQUESTED_WITH') == 'XMLHttpRequest') ? true : false;
    }


    /**
     *  isSecure()
     *
     *  Is https secure request
     *
     *  @access     public
     *
     *  @return     boolean
     */
    public function isSecure()
    {
        return ($this->getScheme() === self::SCHEME_HTTPS);
    }


    /**
     *  fetchArrayValue()
     *
     *  Method tries to find specified value from multidimensional array.
     *
     *  @access     protected
     *
     *  @uses       \Util\Request::fetchArrayValue()
     *
     *  @param      array   $haystack
     *  @param      array   $needle
     *  @param      mixed   $default
     *
     *  @return     mixed
     */
    protected function fetchArrayValue(&$haystack, &$needle, &$default)
    {
        $pointer = array_shift($needle);

        if (isset($haystack[$pointer]) && !empty($needle))
        {
            return $this->fetchArrayValue($haystack[$pointer], $needle, $default);
        }

        elseif (isset($haystack[$pointer]))
        {
            return $haystack[$pointer];
        }

        else
        {
            return $default;
        }
    }
}

?>
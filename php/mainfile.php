<?php
/**
 *  mainfile.php
 *
 *  @package    HomeAI
 *  @subpackage Core
 *  @category
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

// Define software initialize bit
define('HOMEAI_MAINFILE', true);

// Default timezone setting
date_default_timezone_set('Europe/Helsinki');
setlocale(LC_ALL, 'fi_FI.UTF8');

// We want to show all errors.
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Define used default constants
define('BASEPATH', dirname(ini_get('include_path')) ."/");
define('TITLE', 'HomeAI');
define('VERSION', '0.5alpha');

chdir(BASEPATH);

// Register taskboard class autoloader
spl_autoload_register('homeAi__autoload');

/**
 *  TaskBoard__autoload()
 *
 *  @access     public
 *
 *  @param      string      $class
 *
 *  @return     void
 */
function homeAi__autoload($class)
{
    // Namespace call
    if(mb_strpos($class, '\\') !== false)
    {
        $bits = explode('\\', $class);

        $class = array_pop($bits);
    }

    if (isset($bits) && is_array($bits) && count($bits) > 0)
    {
        while (count($bits) > 0)
        {
            $classDir = implode('/', $bits);
            $classFile = BASEPATH ."php/". $classDir ."/". $class .".php";

            if (is_readable($classFile))
            {
                require_once $classFile;

                break 1;
            }

            else
            {
                array_pop($bits);
            }
        }
    }
}

// Require database library
require_once 'db.php';

// Initialize session handling.
\Core\Session::initialize();

// Define site constants
foreach (\Core\Config::readIni('site.ini') as $const => $value)
{
    define($const, $value);
}

?>

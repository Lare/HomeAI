<?php
/**
 *  db.php
 *
 *  File initilizes Doctrine dbal -library.
 *
 *  @package    HomeAI
 *  @subpackage Database
 *  @category   Database
 *
 *  @project
 *  @case
 *
 *  @author     Lare
 *  @copyright  Lauri Laukkarinen
 *
 *  @date       $Date: 2011-11-21 22:49:28 +0200 (Mon, 21 Nov 2011) $
 *  @version    $Rev: 6 $
 *  @author     $Author: lare $
 */
defined('HOMEAI_MAINFILE') OR die('No direct access allowed.');

use Doctrine\Common\ClassLoader;

$path = BASEPATH .'libs/doctrine-dbal/';

// Require doctrine class loader
require_once($path .'Doctrine/Common/ClassLoader.php');

// Register doctrine class loader
$classLoader = new ClassLoader('Doctrine', $path);
$classLoader->register();

?>
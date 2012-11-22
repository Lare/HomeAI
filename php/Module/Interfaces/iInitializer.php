<?php
/**
 *  \Module\Interfaces\iInitializer.php
 *
 *  @package    HomeAI
 *  @subpackage Module
 *  @category   Interface
 *
 *  @author     Lare
 *  @copyright  Lauri Laukkarinen
 */
namespace Module\Interfaces;

defined('HOMEAI_MAINFILE') OR die('No direct access allowed.');
/**
 *  iInitializer interface
 *
 *  Interface for module initializer class.
 *
 *  @package    HomeAI
 *  @subpackage Module
 *  @category   Interface
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
interface iInitializer
{
    public function __construct(&$module, &$action);
    public function handleRequest();
}

?>
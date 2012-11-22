<?php
/**
 *  \Module\Interfaces\iModel.php
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
 *  iModel interface
 *
 *  Interface for module model class.
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
 *  @date       $Date: 2011-12-31 18:38:13 +0200 (Sat, 31 Dec 2011) $
 *  @version    $Rev: 26 $
 *  @author     $Author: lare $
 */
interface iModel
{
    // Basic methods
    public function __construct(&$module, &$action);
    public function setRequest(&$request);
    public function setView(&$view);
    public function getDbh();

    // Methods that must be implemented in child classes
    public function initialize();
}

?>
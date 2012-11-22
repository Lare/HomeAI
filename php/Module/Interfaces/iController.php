<?php
/**
 *  \Module\Interfaces\iController.php
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
 *  iController interface
 *
 *  Interface for module controller class.
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
interface iController
{
    // Basic methods
    public function __construct(&$module, &$action);
    public function handleRequest();

    // Methods that must be implemented in child classes
    public function handleRequestDefault();
    public function initialize();
}

?>

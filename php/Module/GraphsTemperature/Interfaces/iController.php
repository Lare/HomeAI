<?php
/**
 *  \Module\GraphsTemperature\Interfaces\iController.php
 *
 *  @package    Module
 *  @subpackage GraphsTemperature
 *  @category   Interface
 *
 *  @author     Lare
 *  @copyright  Lauri Laukkarinen
 */
namespace Module\GraphsTemperature\Interfaces;

defined('HOMEAI_MAINFILE') OR die('No direct access allowed.');
/**
 *  Controller interface
 *
 *  Interface for GraphsTemperature module controller class.
 *
 *  @package    Module
 *  @subpackage GraphsTemperature
 *  @category   Interface
 *
 *  @project
 *  @case
 *
 *  @author     Lare
 *  @copyright  Lauri Laukkarinen
 *
 *  @date       $Date: 2011-11-22 21:27:01 +0200 (Tue, 22 Nov 2011) $
 *  @version    $Rev: 16 $
 *  @author     $Author: lare $
 */
interface iController
{
    public function handleRequestGetGraphs();
}

?>
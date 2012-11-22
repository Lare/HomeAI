<?php
/**
 *  \Module\Interfaces\iView.php
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
 *  iView interface
 *
 *  Interface for module view class.
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
interface iView
{
    // Basic methods
    public function __construct(&$module, &$action);
    public function setModel(&$model);
    public function setRequest(&$request);
    public function getSmarty();
    public function addJs($js, $append = true);
    public function addCss($css, $media = 'screen, projection', $append = true);
    public function display($content = NULL, $template = 'index.tpl');

    // Methods that must be implemented in child classes
}

?>
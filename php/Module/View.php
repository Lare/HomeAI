<?php
/**
 *  \Module\View.php
 *
 *  @package    HomeAI
 *  @subpackage Module
 *  @category   View
 *
 *  @author  Lare
 *  @copyright  Lauri Laukkarinen
 */
namespace Module;

defined('HOMEAI_MAINFILE') OR die('No direct access allowed.');
/**
 *  View -class
 *
 *  General module view class. Basicly every module view class must extend
 *  this abstract class.
 *
 *  @package    HomeAI
 *  @subpackage Module
 *  @category   View
 *
 *  @project
 *  @case
 *
 *  @author  Lare
 *  @copyright  Lauri Laukkarinen
 *
 *  @date       $Date: 2012-01-01 12:21:16 +0200 (Sun, 01 Jan 2012) $
 *  @version    $Rev: 33 $
 *  @author     $Author: lare $
 */
abstract class View implements Interfaces\iView
{
    /**
     *  Name of the current module.
     *
     *  @access     protected
     *  @var        string
     */
    protected $module = '';

    /**
     *  Name of the current module action.
     *
     *  @access     protected
     *  @var        string
     */
    protected $action = '';

    /**
     *  Smarty object
     *
     *  @access     protected
     *  @var        object
     */
    protected $smarty = NULL;

    /**
     *  Smarty caching.
     *
     *  @access     protected
     *  @var        boolean
     */
    protected $noCache = true;

    /**
     *  Title of the current page.
     *
     *  @access     protected
     *  @var        string
     */
    protected $pageTitle = '';

    /**
     *  Show only setted page title.
     *
     *  @access     protected
     *  @var        string
     */
    protected $pageTitleShowOnlyPage = false;

    /**
     *  Used css definitions.
     *
     *  @access     protected
     *  @var        array
     */
    protected $pageCss = array(
                            'screen.css'    =>  'screen, projection',
                            'print.css'     =>  'print',
                            );

    /**
     *  Used css definitions.
     *
     *  @access     protected
     *  @var        array
     */
    protected $pageJs = array(
                            'jQuery/',
                            'jQuery-ctNotify/',
                            'jQuery-Mobile/',
                            'jQuery-Mobile-DateBox/',
                            'homeAi.js',
                            );

    /**
     *  Model object of current MVC -model. Note that this is
     *  a reference to model class.
     *
     *  @access     protected
     *  @var        object
     */
    protected $model = NULL;

    /**
     *  Request object. Note that all $_GET, $_POST and $_COOKIE values
     *  must handled via this object.
     *
     *  @access     protected
     *  @var        object
     */
    protected $request = NULL;


    /**
     *  __construct()
     *
     *  Construction of the class.
     *
     *  @access     public
     *
     *  @uses       \Module\View::initializeSmarty()
     *  @uses       \Module\View::assignDefaultVariables()
     *
     *  @param      string      $module     Name of the requested module
     *  @param      string      $action     Name of the requested action
     *
     *  @return     void
     */
    public function __construct(&$module, &$action)
    {
        // Set module and action
        $this->module = $module;
        $this->action = $action;

        // Initialize smarty
        $this->initializeSmarty();

        // Assign default template variables
        $this->assignDefaultVariables();

        $this->initialize();
    }


    /**
     *  setModel()
     *
     *  Setter for model.
     *
     *  @access     public
     *
     *  @param      object  $model  Instance of model class.
     *
     *  @return     void
     */
    public function setModel(&$model)
    {
        $this->model = $model;
    }


    /**
     *  setRequest()
     *
     *  Setter for request object.
     *
     *  @access     public
     *
     *  @param      object  $request    Instance of request class.
     *
     *  @return     void
     */
    public function setRequest(&$request)
    {
        $this->request = $request;
    }


    /**
     *  getSmarty()
     *
     *  Getter for smarty object.
     *
     *  @access     public
     *
     *  @return     object  Smarty object
     */
    public function getSmarty()
    {
        return $this->smarty;
    }


    /**
     *  addJs()
     *
     *  Javascript library add method.
     *
     *  @access     public
     *
     *  @param      string      $js         Javascript library name.
     *  @param      boolean     $append     Add type.
     *
     *  @return     void
     */
    public function addJs($js, $append = true)
    {
        ($append === true) ? $this->pageJs[] = $js : $this->pageJs = array($js);
    }


    /**
     *  addCss()
     *
     *  CSS file add method.
     *
     *  @access     public
     *
     *  @param      string      $csss       CSS filename.
     *  @param      string      $media      Used media type for CSS.
     *  @param      boolean     $append     Add type.
     *
     *  @return     void
     */
    public function addCss($css, $media = 'screen, projection', $append = true, $first = false)
    {
        if ($append === false)
        {
            $this->pageCss = array($css => $media);
        }

        elseif ($first === true)
        {
            $this->pageCss = array_merge(array($css => $media), $this->pageCss);
        }

        else
        {
            $this->pageCss[$css] = $media;
        }
    }


    /**
     *  display()
     *
     *  Method displays defined page.
     *
     *  @access     public
     *
     *  @uses       \Module\View::initializePage()
     *  @uses       \Util\Request::isAjax()
     *  @uses       \Smarty::assign()
     *  @uses       \Smarty::display()
     *
     *  @param      string  $content    HTML content to overwrite everything else
     *  @param      string  $template   Used main template file.
     *
     *  @return     void
     */
    public function display($content = NULL, $template = 'index.tpl')
    {
        // Initialize current page
        $this->initializePage();

        // Content is set, so owerwrite everything else
        if (!is_null($content))
        {
            $this->smarty->assign('Content', $content);
        }

        // Display page.
        $this->smarty->display($template);

        exit(0);
    }


    /**
     *  initializePage()
     *
     *  Method initialized displayed page.
     *
     *  @access     protected
     *
     *  @uses       \Module\View::checkModuleJs()
     *  @uses       \Module\View::checkModuleCss()
     *  @uses       \Module\{Module}\View::initializeModule()
     *  @uses       \Module\View::makeCss()
     *  @uses       \Module\View::makeJs()
     *  @uses       \Module\View::makeMessage()
     *  @uses       \Module\View::makeTitle()
     *  @uses       \Module\View::makeUser()
     *  @uses       \Module\View::makeSiteNavigation()
     *
     *  @return     void
     */
    protected function initializePage()
    {
        // Check module specified javascripts
        $this->checkModuleJs();

        // Check module specified css
        $this->checkModuleCss();

        // Module specified initializing.
        if (method_exists($this, 'initializeModule'))
        {
            $this->initializeModule();
        }

        // Create page JS section
        $this->makeJs();

        // Create page CSS section
        $this->makeCss();

        // Create page messages
        $this->makeMessage();

        // Create page title
        $this->makeTitle();

        $this->smarty->assign('Events', $this->model->getEventData());
    }


    /**
     *  checkModuleJs()
     *
     *  Method checks if module has defined javascript files and adds them
     *  to current view if founded.
     *
     *  @access     private
     *
     *  @uses       \Module\View::addJs()
     *
     *  @return     void
     */
    private function checkModuleJs()
    {
        // Define module javascript dir
        $jsDirectory = BASEPATH ."html/js/Module/". $this->module ."/";

        // Directory doesn't exists so do not continue
        if (!is_dir($jsDirectory))
        {
            return;
        }

        // Define searched js files
        $files = array(
                    $this->module,
                    $this->action,
                    );

        // Iterate module specified javascripts
        foreach ($files as $file)
        {
            // js file is readable, so add it to current js array
            if (is_readable($jsDirectory . $file .".js"))
            {
                // Add module specified javascripts
                $this->addJs("Module/". $this->module ."/". $file .".js");
            }
        }
    }


    /**
     *  checkModuleCss()
     *
     *  Method checks if module has defined css files and adds them
     *  to current view if founded.
     *
     *  @access     private
     *
     *  @uses       \Module\View::addCss()
     *
     *  @return     void
     */
    private function checkModuleCss()
    {
        // Define module javascript dir
        $cssDirectory = BASEPATH ."html/css/Module/". $this->module ."/";

        // Directory doesn't exists so do not continue
        if (!is_dir($cssDirectory))
        {
            return;
        }

        // Define searched css files
        $files = array(
                    $this->module,
                    $this->action,
                    );

        // Iterate module specified javascripts
        foreach ($files as $file)
        {
            // css file is readable, so add it to current js array
            if (is_readable($cssDirectory . $file .".css"))
            {
                // Add module specified css file
                $this->addCss("Module/". $this->module ."/". $file .".css");
            }
        }
    }


    /**
     *  makeCss()
     *
     *  Method creates page CSS section to head.
     *
     *  @access     private
     *
     *  @uses       \Smarty::createTemplate()
     *  @uses       \Smarty::assign()
     *  @uses       \Smarty::fetch()
     *
     *  @return     void
     */
    private function makeCss()
    {
        $css = array();

        foreach($this->pageCss as $_css => $_media)
        {
            $lib = BASEPATH ."html/css/". $_css;

            if (is_dir($lib))
            {
                foreach (glob($lib ."*.css") as $_file)
                {
                    $css[str_replace(BASEPATH ."html/css/", "", $_file)] = $_media;
                }
            }

            elseif (is_readable($lib))
            {
                $css[str_replace(BASEPATH ."html/css/", "", $lib)] = $_media;
            }
        }

        // Create css template and assign css data to it.
        $template = $this->smarty->createTemplate('page_css.tpl');
        $template->assign('data', $css);
        $template->assign('baseUrl', BASEURL);

        // Fetch parsed css template and append it to current page.
        $this->smarty->assign('pageCSS', $template->fetch());

        unset($template);
    }


    /**
     *  makeJs()
     *
     *  Method creates page JS section to head.
     *
     *  @access     private
     *
     *  @uses       \Module\View::addCss()
     *  @uses       \Smarty::createTemplate()
     *  @uses       \Smarty::assign()
     *  @uses       \Smarty::fetch()
     *
     *  @return     void
     */
    private function makeJs()
    {
        $js = array();

        foreach($this->pageJs as $k => $_js)
        {
            $lib = BASEPATH ."html/js/". $_js;

            if (is_dir($lib))
            {
                foreach (glob($lib ."*.js") as $_file)
                {
                    $js[] = str_replace(BASEPATH ."html/js/", "", $_file);
                }

                $this->addCss($_js, 'screen, projection', true, true);
            }

            elseif (is_readable($lib))
            {
                $js[] = str_replace(BASEPATH ."html/js/", "", $lib);
            }
        }

        // Create javascript template and assign javascript data to it.
        $template = $this->smarty->createTemplate('page_js.tpl');
        $template->assign('data', $js);
        $template->assign('baseUrl', BASEURL);

        // Fetch parsed javascript template and append it to current page.
        $this->smarty->assign('pageJS', $template->fetch());

        unset($template);
    }


    /**
     *  makeMessage()
     *
     *  Method makes message boxes to page if any UI messages are present.
     *
     *  @access     private
     *
     *  @uses       \Smarty::createTemplate()
     *  @uses       \Smarty::assign()
     *  @uses       \Smarty::append()
     *  @uses       \Smarty::fetch()
     *
     *  @return     void
     */
    private function makeMessage()
    {
        // No messages
        if (!isset($_SESSION['Message']) || !is_array($_SESSION['Message']))
        {
            return;
        }

        new \Util\Debug($_SESSION['Message']);

        // Iterate messages.
        foreach ($_SESSION['Message'] as $type => $data)
        {
            if (empty($data))
            {
                continue;
            }

            // Create message template and assign message data to it.
            $message = $this->smarty->createTemplate('js_notify_message.tpl');
            $message->assign('data', $data);
            $message->assign('type', $type);

            // Fetch parsed message template and append it to current page.
            $this->smarty->append('pageScript', $message->fetch());

            unset($message);
        }

        // Reset messages
        unset($_SESSION['Message']);
    }


    /**
     *  makeTitle()
     *
     *  Method makes page title and assign it to smarty.
     *
     *  @access     private
     *
     *  @uses       \Smarty::assign()
     *
     *  @return     void
     */
    private function makeTitle()
    {
        $title = '';

        if (isset($this->pageTitle) && !empty($this->pageTitle))
        {
            $title .= is_array($this->pageTitle) ? implode(' - ', $this->pageTitle) : $this->pageTitle;
        }

        if ($this->pageTitleShowOnlyPage === true)
        {
        }

        elseif (!empty($title))
        {
            $title = TITLE .' - '. $title;
        }

        else
        {
            $title = TITLE;
        }

        $this->smarty->assign('pageTitle', $title);
    }


    /**
     *  initializeSmarty()
     *
     *  Method initializes smarty library to class use.
     *
     *  @access     private
     *
     *  @uses       \Smarty::clearAllCache()
     *
     *  @return     void
     */
    private function initializeSmarty()
    {
        // Require smarty base class
        require_once BASEPATH ."libs/smarty/Smarty.class.php";

        // Create smarty object
        $this->smarty = new \Smarty;

        // Define smarty variables
        $this->smarty->template_dir = array(
                                        BASEPATH .'templates/'. $this->module .'/',
                                        BASEPATH .'templates/',
                                        );
        $this->smarty->compile_dir  = BASEPATH .'templates_c/';
        $this->smarty->config_dir   = BASEPATH .'config/';
        $this->smarty->cache_dir    = BASEPATH .'cache/';

        if ($this->noCache === true)
        {
            $this->smarty->clearAllCache();
        }
    }


    /**
     *  assignDefaultVariables()
     *
     *  Method assign used default smarty variables.
     *
     *  @access     private
     *
     *  @uses       \Smarty::assign()
     *
     *  @return     void
     */
    private function assignDefaultVariables()
    {
        // Assign global template vars.
        $this->smarty->assign('BaseHref', BASEURL);
        $this->smarty->assign('Version', VERSION);
        $this->smarty->assign('SystemName', TITLE);
        $this->smarty->assign('Module', $this->module);
        $this->smarty->assign('date', ucfirst(strftime('%a %d.%m.%Y %H:%M')));

        // Reset used page variables
        $this->smarty->assign('pageTitle', '');
        $this->smarty->assign('pageCSS', '');
        $this->smarty->assign('pageJS', '');
        $this->smarty->assign('pageVar', '');
        $this->smarty->assign('pageScript', '');
        $this->smarty->assign('pageHead', '');

        // Reset used content variables.
        $this->smarty->assign('Header', '');
        $this->smarty->assign('Footer', '');
        $this->smarty->assign('Content', '');
        $this->smarty->assign('Messages', '');
    }
}

?>
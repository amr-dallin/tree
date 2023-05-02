<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 */

/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
	Router::connect('/', array('controller' => 'pages', 'action' => 'display'));
    Router::connect('/about', array('controller' => 'pages', 'action' => 'about'));
    Router::connect('/idea', array('controller' => 'pages', 'action' => 'idea'));
    Router::connect('/func', array('controller' => 'pages', 'action' => 'func'));
    Router::connect('/tech', array('controller' => 'pages', 'action' => 'tech'));

    Router::connect('/marks/:person_id',
        array('controller' => 'marks', 'action' => 'index'),
        array(
            'pass' => array('person_id'),
            'person_id' => '[0-9]{0,}'
        )
    );

    Router::connect('/profile', array('controller' => 'people', 'action' => 'edit'));
    Router::connect('/person/*', array('controller' => 'people', 'action' => 'view'));
    Router::connect('/family/*', array('controller' => 'people', 'action' => 'family'));

    Router::connect('/direct/*', array('controller' => 'users', 'action' => 'direct'));
    Router::connect('/settings', array('controller' => 'users', 'action' => 'edit'));
    Router::connect('/login', array('controller' => 'users', 'action' => 'login'));
    Router::connect('/logout', array('controller' => 'users', 'action' => 'logout'));

    Router::connect(
        '/item/*',
        array('controller' => 'items', 'action' => 'view', 'admin' => false)
    );
    Router::connect('/uploads', array('controller' => 'items', 'action' => 'uploads'));

    Router::connect(
        '/admin/dashboard',
        array('controller' => 'pages', 'action' => 'dashboard', 'admin' => true)
    );

    Router::connect(
        '/admin/settings',
        array('controller' => 'pages', 'action' => 'settings', 'admin' => true)
    );

    Router::parseExtensions();
    Router::setExtensions(array('json', 'xml', 'rss', 'pdf'));
/**
 * ...and connect the rest of 'Pages' controller's URLs.
 */
	Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));

/**
 * Load all plugin routes. See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 */
	CakePlugin::routes();

/**
 * Load the CakePHP default routes. Only remove this if you do not want to use
 * the built-in default routes.
 */
	require CAKE . 'Config' . DS . 'routes.php';

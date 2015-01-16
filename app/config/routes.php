<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app.config
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/views/pages/home.ctp)...
 */

    Router::parseExtensions('rss');

    Router::connect('/', array('controller' => 'home', 'action' => 'welcome'));

	Router::connect('/entries/category/:id', array('controller' => 'entry_categories', 'action' => 'view'),
                                    array('pass' => array('id'),
                                          'id' => '[0-9]+'));

	Router::connect('/entries/:id', array('controller' => 'entries', 'action' => 'view'),
                                    array('pass' => array('id'),
                                          'id' => '[0-9]+'));

	Router::connect('/ads/:id', array('controller' => 'ads', 'action' => 'view'),
                                    array('pass' => array('id'),
                                          'id' => '[0-9]+'));

	Router::connect('/announcements/:id', array('controller' => 'announcements', 'action' => 'view'),
                                    array('pass' => array('id'),
                                          'id' => '[0-9]+'));

	Router::connect('/news/archive/:year', array('controller' => 'news', 'action' => 'archive'),
                                    array('pass' => array('year'),
                                          'year' => '[0-9]+'));

	Router::connect('/news/:id', array('controller' => 'news', 'action' => 'view'),
                                    array('pass' => array('id'),
                                          'id' => '[0-9]+'));


/**
 * ...and connect the rest of 'Pages' controller's urls.
 */
	Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));

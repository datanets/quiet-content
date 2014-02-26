<?php
/**
 * This file is loaded automatically by the app/webroot/index.php file after the core bootstrap.php
 *
 * This is an application wide file to load any function that is not used within a class
 * define. You can also use this to include or require any files in your application.
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
 * @since         CakePHP(tm) v 0.10.8.2117
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * The settings below can be used to set additional paths to models, views and controllers.
 * This is related to Ticket #470 (https://trac.cakephp.org/ticket/470)
 *
 * App::build(array(
 *     'plugins' => array('/full/path/to/plugins/', '/next/full/path/to/plugins/'),
 *     'models' =>  array('/full/path/to/models/', '/next/full/path/to/models/'),
 *     'views' => array('/full/path/to/views/', '/next/full/path/to/views/'),
 *     'controllers' => array('/full/path/to/controllers/', '/next/full/path/to/controllers/'),
 *     'datasources' => array('/full/path/to/datasources/', '/next/full/path/to/datasources/'),
 *     'behaviors' => array('/full/path/to/behaviors/', '/next/full/path/to/behaviors/'),
 *     'components' => array('/full/path/to/components/', '/next/full/path/to/components/'),
 *     'helpers' => array('/full/path/to/helpers/', '/next/full/path/to/helpers/'),
 *     'vendors' => array('/full/path/to/vendors/', '/next/full/path/to/vendors/'),
 *     'shells' => array('/full/path/to/shells/', '/next/full/path/to/shells/'),
 *     'locales' => array('/full/path/to/locale/', '/next/full/path/to/locale/')
 * ));
 *
 */

/**
 * As of 1.3, additional rules for the inflector are added below
 *
 * Inflector::rules('singular', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 * Inflector::rules('plural', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 *
 */

function fix_google_calendar_feed($feed_data) {

    $feed = htmlspecialchars($feed_data);

    //days
    $feed = str_replace('&amp;#994;&amp;#333;&amp;#324;','Mon',$feed); // Monday fix
    $feed = str_replace('&amp;#354;&amp;#367;&amp;#277;','Tue',$feed); // Tuesday fix
    $feed = str_replace('&amp;#372;&amp;#277;&amp;#271;','Wed',$feed); // Wednesday fix
    $feed = str_replace('&amp;#354;&amp;#293;&amp;#367;','Thu',$feed); // Thursday fix
    $feed = str_replace('F&amp;#345;&amp;#297;','Fri',$feed); // Friday fix
    $feed = str_replace('&amp;#346;&amp;#257;&amp;#359;','Sat',$feed); // Saturday fix
    $feed = str_replace('&amp;#346;&amp;#367;&amp;#324;','Sun',$feed); // Sunday fix

    //months
    $feed = str_replace('&amp;#308;&amp;#257;&amp;#324;','Jan',$feed); //January
    $feed = str_replace('F&amp;#277;b','Feb',$feed); //Feb
    $feed = str_replace('&amp;#994;&amp;#257;&amp;#345;','Mar',$feed); // March fix
    $feed = str_replace('&amp;#256;p&amp;#345;','Apr',$feed); // April fix
    $feed = str_replace('&amp;#994;&amp;#257;&amp;#375;','May',$feed); // May fix
    $feed = str_replace('&amp;#308;&amp;#367;&amp;#324;','Jun',$feed); //June
    $feed = str_replace('&amp;#308;&amp;#367;&amp;#316;','Jul',$feed); //July
    $feed = str_replace('&amp;#256;&amp;#367;&amp;#289;','Aug',$feed); //Aug
    $feed = str_replace('&amp;#346;&amp;#277;p','Sep',$feed); //Sept
    $feed = str_replace('&amp;#332;&amp;#263;&amp;#359;','Oct',$feed); //Oct
    $feed = str_replace('&amp;#325;&amp;#333;v','Nov',$feed);  //November
    $feed = str_replace('&amp;#270;&amp;#277;&amp;#263;','Dec',$feed); //December

    //am/pm
    $feed = str_replace('p&amp;#412;','pm',$feed); // PM fix
    $feed = str_replace('&amp;#257;&amp;#412;','am',$feed); // AM fix

    $feed = str_replace('&amp;nbsp;', ' ', $feed);  // spaces

    return $feed;
}

function isPicture($item) {
    return preg_match("/\.(jpg|jpeg|png|gif)$/i", $item);
}

?>

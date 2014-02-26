<?php
/* EntryImage Test cases generated on: 2010-07-05 18:07:03 : 1278379743*/
App::import('Model', 'EntryImage');

class EntryImageTestCase extends CakeTestCase {
	var $fixtures = array('app.entry_image', 'app.entry');

	function startTest() {
		$this->EntryImage =& ClassRegistry::init('EntryImage');
	}

	function endTest() {
		unset($this->EntryImage);
		ClassRegistry::flush();
	}

}
?>
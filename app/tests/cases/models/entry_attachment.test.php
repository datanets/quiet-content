<?php
/* EntryAttachment Test cases generated on: 2010-07-05 18:07:16 : 1278379756*/
App::import('Model', 'EntryAttachment');

class EntryAttachmentTestCase extends CakeTestCase {
	var $fixtures = array('app.entry_attachment', 'app.entry');

	function startTest() {
		$this->EntryAttachment =& ClassRegistry::init('EntryAttachment');
	}

	function endTest() {
		unset($this->EntryAttachment);
		ClassRegistry::flush();
	}

}
?>
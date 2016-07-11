<?php

class PagesController extends AppController {
	var $name = 'Pages';
	var $helpers = array('Html');
	var $components = array('RrgString');
	
	var $uses = array();
	var $layout = 'default_dw';	
	
	function display() {
		$path = func_get_args();

		$count = count($path);
		if (!$count) {
			$this->redirect('/');
		}
		$page = $subpage = $title = null;

		if (!empty($path[0])) {
			$page = $path[0];
		}
		if (!empty($path[1])) {
			$subpage = $path[1];
		}
		if (!empty($path[$count - 1])) {
			$title = Inflector::humanize($path[$count - 1]);
		}
		if ($page=='testsite') { // keep a reference to the original Dreamweaver page
			$this->layout = 'default_dw_orig';
		}
		$page = $this->RrgString->strtocamel($page);
		$webroot = $this->webroot;
		$this->set(compact('page', 'subpage', 'title','webroot'));
		$this->render(join('/', $path));
	}
}
?>
<?php
# redundantly declared here for shells
App::import('Core', 'Controller');
App::import('Helper','Papp'); 
class AppController extends Controller {
	var $helpers = array(
			'Html',
            'Form',
            'Xml',
            'Javascript',
			'Crumb',
			'Rapp',
			#'Client',
			'Fck',
			'Fpdf',
			'Invoice',
			'DwMenu',
            'Papp',
            'Mobile',
	);
	// AutoLogin must preceed Auth	
    //'Security',
	var $components = array(
			'AutoLogin', 
			'Auth',	
			'DateFunction', 
			'InvoiceFunction',
			'Email',
			'Security',
			'Search',
			'PasswordHelper',
	        'Session',
            'RequestHandler',
            'HashUtils',
            'Json',
            'Xml',
            'FixtureDirectories',
            'Statements',
            'Datasources',
            'FixtureDirectories',
            'HashUtils',
            'Commissions'
	);
		
	var $layout = 'default_jqmenu';	
	var $siteInfo = '<img src="" width="44" height="22" /> <a href="#">About Us</a> | <a href="#">Site Map</a> | <a href="#">Privacy Policy</a> | <a href="#">Contact Us</a> | &copy;2009, 2010, 2011, 2012, 2013, 2014 Rockets Redglare';

	var $siteSmallLogo = "professor_eureka_hwk.gif"	;
	/**
	* The AuthComponent provides the needed functionality
	* for login, so you can leave this function blank.
	*/
	function login() {
	}

	function logout() {
		$this->redirect($this->Auth->logout());
	}
	function beforeRender(){
		$papp = new PappHelper();
		
		$this->set('mainMenu', $papp->main_menu);
		$this->set('favico', $this->webroot.'/img/favico_RRG_LOGO_WEB.jpg');
		$user = $this->Auth->user();
		$utility_menu = array('url'=>'/chat_rooms','title'=>'Chat');
		
		#switch between login/logout in top menu
		if(isset($auth['User'])){
			$utility_menutmp = array($utility_menu, array('url'=>'/users/logout','title'=>'Logout'),);
		}else {
			$utility_menutmp = array($utility_menu, array('url'=>'/m/users/login','title'=>'Login'),);
		}
		$utility_menu = $utility_menutmp; 
		$this->set('utilityMenu', $utility_menu);

		$this->set('currentUser', $user['User']['id']); 
		$this->set('activeOptions',array('0'=>'Inactive', '1'=>'Active'));
		$this->set('i9Options',array('0'=>'not set', '1'=>'US Citizen', '2'=>'Non US Citizen', '3'=>'Lawful Permanent Resident', '4'=>'Alien Authorized to Work'));
		$this->set('addendumOptions',array('0'=>'Pending', '1'=>'In Place'));
		$this->set('trueFalseOptions',array('0'=>'False', '1'=>'True'));
        if (isset($this->page_title) && $this->page_title!=null)
		    $this->set('page_title',Configure::read('site_title'));
		$this->set('siteSmallLogo', $this->siteSmallLogo) 	;
	;
		$this->set('siteInfo', $this->siteInfo);
		//for smarty support
		$this->set('root','/');
	} 
	function beforeFilter() {
       	    $this->Auth->loginAction = array('prefix'=>'','controller' => 'users', 'action' => 'login');
      	    $this->Auth->loginRedirect = array('prefix'=>'','controller' => 'reminders', 'action' => 'index');
       	    $this->Auth->allow('login', 'display', 'new_user_session');
       	    $this->Auth->logoutRedirect = array('controller' => 'pages', 'action' => 'home');
	    $this->Auth->loginError = 'No username and password was found with that combination.';
            // fixme: this stopped working, remove, test
	    $this->AutoLogin->cookieName = Configure::read('cookie_name'); 
            $this->xml_home = Configure::read('xml_home');
	}
	function forceSSL() {
		$this->redirect('https://' . $_SERVER['SERVER_NAME'] . $this->here);
	}	
	
}
?>

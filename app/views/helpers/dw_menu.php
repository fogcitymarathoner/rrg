<?php
class DwMenuHelper extends AppHelper {
	/**
	 * @see http://www.anyexample.com/programming/php/php_convert_rgb_from_to_html_hex_color.xml
	 */
	function mainMenu($mainMenu){
	    $count = 0; $out = '';
	    foreach ($mainMenu as $menu_item):
	    	$count++;
	      $out .= '<a href="';
	      $out .= $this->base.$menu_item['url'];
	      $out .= '" id="gl'.$count;
	      $out .= '" class="glink" onmouseover="ehandler(event,menuitem';
	      $out .= $count.');">'.$menu_item['title'].'</a>'; 
		endforeach;    
		return $out;
	}
	function utilityMenu($utilityMenu){
	    $count = 0; $out = ''; //debug($utilityMenu); exit;
	    foreach ($utilityMenu as $menu_item):
	    	$count++;
	      $out .= '<a href="';
	      $out .= $this->base.$menu_item['url'];
	      $out .= '" >'.$menu_item['title'].'</a> | '; 
		endforeach;    
		return $out;
	}
	function subMenu($mainMenu){
	    $out = '';
	    $count = 0; 
	    foreach ($mainMenu as $menu_item):
			$count++;
			$out .= '<div id="subglobal'.$count.'" class="subglobalNav"> ';
	    	foreach ($menu_item['submenu'] as $submenu_item):
	      		$out .= ' | ';
				$out .= $this->subMenuLine($submenu_item);
	      		$out .= ' | ';
			endforeach;    
			$out .= '</div>'; 
		endforeach;    
		return $out;
	}
	
	function subMenuLine($submenu_item){ 
	    	$out = '';//
	      $out .= '<a href="'.$this->webroot.$submenu_item['link'].'">'.$submenu_item['title'].'</a>';
		return $out;
	}
	
	
	function buildJavaMenu($mainMenu){ 
	    $out = '';
	    $count = 0; $out = '';
	    foreach ($mainMenu as $menu_item):
	    	$count++;
	    	$out .= 'var menuitem'.$count.' = new menu(';
	    	$out .= count($mainMenu).','.$count;
	    	$out .= ',"hidden");';
		endforeach;    
	    return $out;
	}
	
}
?>
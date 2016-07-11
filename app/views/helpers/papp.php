<?php
class PappHelper extends AppHelper {
	var $main_menu = array(
		array('url'=>'/','title'=>'Home','submenu'=>array(
		array('title'=>'Home','link'=>''),
				array('title'=>'Charts','link'=>'pages/charts'),
				array('title'=>'Links','link'=>'pages/links'),
				array('title'=>'TestSite','link'=>'pages/testsite'),
				array('title'=>'Accordion','link'=>'pages/accordion'),
				array('title'=>'Bread Crumb Test','link'=>'wizards'),
				array('title'=>'Google Maps Test','link'=>'points'),
				array('title'=>'Chat','link'=>'chat_rooms'),
				)),
		array('url'=>'/movies/index','title'=>'Movies','submenu'=>array(
				array('title'=>'List','link'=>'movies/'),
				array('title'=>'Add Movie','link'=>'movies/add'),
				array('title'=>'Calendar','link'=>'movies/calendar'),
				)),
		array('url'=>'/public_events/calendar','title'=>'Calendar','submenu'=>array(
				array('title'=>'Calendar','link'=>'public_events/calendar'),
				array('title'=>'Add Event','link'=>'public_events/add'),
				array('title'=>'List','link'=>'public_events/index'),
				)),
		array('url'=>'/contacts/search','title'=>'Contact Us','submenu'=>array(
				array('title'=>'Add Contact','link'=>'contacts/add'),
				array('title'=>'Search Contacts','link'=>'contacts/search'),
				)),
		array('url'=>'/public_posts/music','title'=>'Music','submenu'=>array(
				array('title'=>'Record Home IP','link'=>'pages/recordip'),
				array('title'=>'Music Search','link'=>'songs'),
				array('title'=>'Home Music','link'=>'/public_posts/music'),
				)),
		array('url'=>'/vendors/search','title'=>'Vendors','submenu'=>array(
				array('title'=>'Add Vendor','link'=>'vendors/add'),
				array('title'=>'Search Vendors','link'=>'vendors/search/tab:search'),
				array('title'=>'All Vendors','link'=>'vendors/'),
				)),
		array('url'=>'/posts','title'=>'Memos','submenu'=>array(
				array('title'=>'Tags','link'=>'/tags'),
				array('title'=>'Add','link'=>'/posts/add'),
				)),
		array('url'=>'/sbrn_posts/index','title'=>'Sports','submenu'=>array(
				array('title'=>'Charts','link'=>'sbrn_posts/charts'),
				)),
		);
	
	
	function topmenu($webroot)
	{
		$this->webroot = $webroot;//debug($this->webroot);exit;
		$html = new HtmlHelper;
		$topmenu = '';
		$topmenu .= '<div style="border: 1px solid blue; ">';
		$topmenu .= '	<ul class="jd_menu" id="nav">';

		$topmenu .= "		<li><a href='{$this->webroot}calls' >LINKS</a>";
		$topmenu .= '					<ul>';
		
		$topmenu .= '						<li>MOBI';
		$topmenu .= '							<ul>';
		$topmenu .= '								<li>Calls';
		$topmenu .= '									<ul>';
		$topmenu .= '										<li><a href="'.''.'calls"  >Pending</a></li>';
		$topmenu .= '										<li><a href="'.$this->webroot.'calls/add"  >Add</a></li>';
		$topmenu .= '									</ul>';
		$topmenu .= '								</li>';
		$topmenu .= '								<li>Calendar';
		$topmenu .= '									<ul>';
		$topmenu .= '										<li><a href="'.$this->webroot.'events/calendar"  >Calendar</a></li>';
		$topmenu .= '										<li><a href="'.$this->webroot.'events/add"  >Add</a></li>';
		$topmenu .= '									</ul>';
		$topmenu .= '								</li>';
		$topmenu .= '								<li><a href="'.$this->webroot.'vendors"  >Vendors</a></li>';
		$topmenu .= '								<li><a href="'.$this->webroot.'contacts/search"  >Contact search</a></li>';
		$topmenu .= '								<li><a href="'.$this->webroot.'posts/search"  >Post search</a></li>';
		$topmenu .= '								<li>Movies';
		$topmenu .= '									<ul>';
		$topmenu .= '										<li><a href="'.$this->webroot.'movies/add"  >Add</a></li>';
		$topmenu .= '										<li><a href="'.$this->webroot.'movies"  >List</a></li>';
		$topmenu .= '									</ul>';
		$topmenu .= '								</li>';
		$topmenu .= '								<li>Sports';
		$topmenu .= '									<ul>';
		$topmenu .= '										<li><a href="'.$this->webroot.'sbrn_posts/add"  >Add</a></li>';
		$topmenu .= '										<li><a href="'.$this->webroot.'sbrn_posts"  >List</a></li>';
		$topmenu .= '									</ul>';
		$topmenu .= '								</li>';
		$topmenu .= '								<li><a href="'.$this->webroot.'tags"  >Tags</a></li>';
		
		$topmenu .= '							</ul>';
		$topmenu .= '						</li>';
		$topmenu .= '						<li>RRG';
		$topmenu .= '							<ul>';
		$topmenu .= '								<li><a href="https://www.sfgeek.org/cakerrg/"   TARGET="_blank" >Cake</a></li>';
		$topmenu .= '								<li><a href="http://www.rocketsredglare.com"  >Joomla</a></li>';
		$topmenu .= '								<li><a href="https://www.wellsfargo.com"  >Wells Fargo</a></li>';
		$topmenu .= '								<li><a href="https://www.paycycle.com"  >Paycycle</a></li>';
		$topmenu .= '							</ul>';
		$topmenu .= '						</li>';

		$topmenu .= '						<li>Links';
		$topmenu .= '							<ul>';
		$topmenu .= '								<li><a href="http://www.superbrainhosting.com:2082/"  >SF Geek Control Panel</a></li>';
		$topmenu .= '							</ul>';
		$topmenu .= '						</li>';
		
		$topmenu .= '								<li><a href="'.$this->webroot.'radio" target="_blank" >Radio</a></li>';
		$topmenu .= '						<li><a href="https://fogtest.com/todo/"  TARGET="_blank"  >Todo</a></li>';
		$topmenu .= '						<li><a href="https://fogtest.com/schedule/calendar/month/personal/"  TARGET="_blank"  >Calender</a></li>';
		$topmenu .= '						<li><a href="http://www.paypal.com"  >PayPal</a></li>';
		

		
		$topmenu .= '					</ul>';
		
		$topmenu .= '		</li>';
		
		$topmenu .= '		<li>'.$html->link(__('Calls', true), array('controller'=>'calls','action'=>'index'));
		$topmenu .= '					<ul>';
		$topmenu .= '						<li>'.$html->link(__('Pending', true), array('controller'=>'calls','action'=>'index')).'</li>';
		$topmenu .= '						<li><a href="'.$this->webroot.'calls/calendar"  >Calendar</a></li>';
		$topmenu .= '						<li><a href="'.$this->webroot.'calls/add"  >Add Call</a></li>';
		$topmenu .= '					</ul>';
		$topmenu .= "		</li>";
		$topmenu .= "		<li><a href='{$this->webroot}movies' >Media</a>";
		$topmenu .= '					<ul>';
		$topmenu .= '						<li><a href="'.$this->webroot.'movies/"  >List</a></li>';
		$topmenu .= '						<li><a href="'.$this->webroot.'movies/add"  >Add Movie</a></li>';
		$topmenu .= '						<li><a href="'.$this->webroot.'songs"  >Songs</a></li>';
		$topmenu .= '						<li><a href="'.$this->webroot.'public_posts/music"  >Music Collection</a></li>';
		$topmenu .= '					</ul>';
		$topmenu .= "		</li>";
		$topmenu .= "		<li><a href='{$this->webroot}events/calendar' >Events</a>";
		$topmenu .= '					<ul>';
		$topmenu .= '						<li><a href="'.$this->webroot.'events/calendar" target="_blank" >Calendar</a></li>';
		$topmenu .= '						<li><a href="'.$this->webroot.'events/add" target="_blank" >Add Event</a></li>';
		$topmenu .= '						<li><a href="'.$this->webroot.'events" target="_blank" >Events List</a></li>';
		$topmenu .= '					</ul>';
		$topmenu .= "		</li>";
		$topmenu .= "		<li><a href='{$this->webroot}contacts/search' >Contacts</a>";
		$topmenu .= '					<ul>';
		$topmenu .= '						<li><a href="'.$this->webroot.'contacts/"  >List</a></li>';
		$topmenu .= '						<li><a href="'.$this->webroot.'contacts/add"  >Add Contact</a></li>';
		$topmenu .= '						<li><a href="'.$this->webroot.'contacts/search"  >Search Contacts</a></li>';
		$topmenu .= '					</ul>';
		$topmenu .= "		</li>";
		$topmenu .= "		<li><a href='{$this->webroot}vendors/search_s' >Vendors</a>";
		$topmenu .= '					<ul>';
		$topmenu .= '						<li><a href="'.$this->webroot.'vendors/"  >List</a></li>';
		$topmenu .= '						<li><a href="'.$this->webroot.'vendors/add"  >Add Vendor</a></li>';
		$topmenu .= '						<li><a href="'.$this->webroot.'vendors/search"  >Search Vendors</a></li>';
		$topmenu .= '					</ul>';
		$topmenu .= "		</li>";


		$topmenu .= "		<li><a href='{$this->webroot}tags' >Tags</a></li>";
		$topmenu .= "		<li>Memos";
		$topmenu .= '					<ul>';
		$topmenu .= '						<li><a href="'.$this->webroot.'posts/"  >List</a></li>';
		$topmenu .= '						<li><a href="'.$this->webroot.'posts/add"  >Add Post</a></li>';
		$topmenu .= '						<li><a href="'.$this->webroot.'posts/search"  >Search Posts</a></li>';
		$topmenu .= '						<li><a href="http://wiki.personal.sfgeek.org/index.php" TARGET="_blank">Wiki</a></li>';
		$topmenu .= '					</ul>';
		$topmenu .= "		</li>";
		$topmenu .= "		<li>Sports";
		$topmenu .= '					<ul>';
		$topmenu .= '						<li><a href="'.$this->webroot.'sbrn_posts/"  >List</a></li>';
		$topmenu .= '						<li><a href="'.$this->webroot.'sbrn_posts/add"  >Add Post</a></li>';
		$topmenu .= '					</ul>';
		$topmenu .= "		</li>";
		$topmenu .= "		<li><a href='{$this->webroot}users' >Settings</a>";
		$topmenu .= '					<ul>';
		$topmenu .= '						<li><a href="'.$this->webroot.'users/"  >Users</a></li>';
		$topmenu .= '						<li><a href="'.$this->webroot.'groups"  >Groups</a></li>';
		$topmenu .= '						<li><a href="'.$this->webroot.'users/logout"  >Logout</a></li>';
		
		$topmenu .= '					</ul>';
		$topmenu .= "		</li>";
		$topmenu .= '	</ul>';
		$topmenu .= '</div>';
		return $topmenu;
	}	
	function public_topmenu()
	{
		$topmenu = '';
		$topmenu .= '<div style="border: 1px solid blue; ">';
		$topmenu .= '	<ul class="jd_menu">';

		$topmenu .= "		<li><a href='{$this->webroot}events/calendar' >Events</a>";
		$topmenu .= '					<ul>';
		$topmenu .= '						<li><a href="'.$this->webroot.'public_events/calendar" target="_blank" >Calendar</a></li>';
		$topmenu .= '						<li><a href="'.$this->webroot.'public_events/add" target="_blank" >Add Event</a></li>';
		$topmenu .= '						<li><a href="'.$this->webroot.'public_events" target="_blank" >Events List</a></li>';
		$topmenu .= '					</ul>';
		$topmenu .= "		</li>";
		$topmenu .= "		<li><a href='{$this->webroot}sample_pages' >Sample Pages</a>";
		$topmenu .= '					<ul>';
		$topmenu .= '						<li><a href="'.$this->webroot.'sample_pages/jquery_tabs"  >Jquery Ui Tabs</a></li>';
		$topmenu .= '					</ul>';
		$topmenu .= "		</li>";
		/*$topmenu .= "		<li><a href='{$this->webroot}public_tags' >Tags</a></li>";
		$topmenu .= "		<li>Memos";
		$topmenu .= '					<ul>';
		$topmenu .= '						<li><a href="'.$this->webroot.'public_posts/"  >List</a></li>';
		$topmenu .= '						<li><a href="'.$this->webroot.'public_posts/add"  >Add Post</a></li>';
		$topmenu .= '						<li><a href="'.$this->webroot.'public_posts/search"  >Search Posts</a></li>';
		$topmenu .= '					</ul>';
		$topmenu .= "		</li>"; */
		$topmenu .= '	</ul>';
		$topmenu .= '</div>';
		return $topmenu;
	}	
	function printinirow($elementName = 'X-PAYPAL-REQUEST-DATA-FORMAT',$elementValue='NV', $mode ='edit', $ad='HEADERS')
	{
		$readonlystyle = ' STYLE="color: #ffffff; font-family: Verdana; font-weight: bold; font-size: 12px; background-color: #e37469;"';
		$editstyle = ' STYLE="color: #ffffff; font-family: Verdana; font-weight: bold; font-size: 12px; background-color: #69ff69;"';
		$leftcolwidth = 150;
		$rtcolwidth = 200;
		$inputsize = 63;
		$inputmaxlength = 200;
		$return = "
		<tr>
		<td WIDTH={$leftcolwidth}>{$elementName}</td>
		<td WIDTH={$rtcolwidth}>";
		$return .="<label for=\"{$ad}_{$elementName}\"></label>
<input name=\"data[{$ad}][{$elementName}]\" 
type=\"text\" value=\"{$elementValue}\"";
		if ($mode == 'ro')
			$return .= ' '.$readonlystyle;
		else
			$return .= ' '.$editstyle;
		
		$return .= "size=\"{$inputsize}\" maxlength=\"{$inputmaxlength}\" id=\"APCO{$elementName}\" />";
		$return .= '</td></tr>';
		return $return;
	}	
	function index($contacts)
	{
		$res = '
<h2>
		';
$res = '
<table cellpadding="0" cellspacing="0" >
<tr>
	<th>First</th>
	<th>Last</th>
	<th>Phone</th>
	<th>Problem, Company, Scheduled Time</th>
	<th class="actions">Actions</th>
</tr>
';
$i = 0;
$bgcolorName="gray";
foreach ($contacts as $contact):
		if ($bgcolorName=="gray") // Alternate background in records
		{
			$bgcolor="efefef";
			$bgcolorName="white";
		} else {
			$bgcolor="ffffff";
			$bgcolorName="gray";
		} 
		echo "";
	
	$res .= '
		<TR  bgcolor="#'.$bgcolor.'" id="td">
		<td ><FONT COLOR="#7c0965">
			'.$contact['Contact']['first'].'
		</FONT></td>
		<td ><FONT COLOR="#7c0965">
			'.$contact['Contact']['last'].'
		</FONT></td>
		<td ><FONT COLOR="#7c0965">
			'.$contact['Contact']['phone1'].'
		</FONT></td>
		<td ><FONT COLOR="#7c0965">
			'.$contact['Contact']['description_triage'].'
		</FONT></td>';

		$res .= '<td class="actions">';
$res .= '<a href="'.$this->webroot.'calls/edit/'.$contact['Contact']['id'].'">
<img src="'.$this->webroot.'img/icons/pencil.png" title="edit" alt="" /></a>';
$res .= '<a href="'.$this->webroot.'calls/view/'.$contact['Contact']['id'].'">
<img src="'.$this->webroot.'img/icons/magglass.png" title="view" alt="" /></a>';
$res .= '<a href="'.$this->webroot.'calls/unpend/'.$contact['Contact']['id'].'">
<img src="'.$this->webroot.'img/icons/redcirclecrossedout.png" title="unpend" alt="" /></a>';
$res .= '<a href="'.$this->webroot.'calls/delete/'.$contact['Contact']['id'].'" onclick="return confirm(&#039;Are you sure you want to delete # '.$contact['Contact']['id'].
'?&#039;);"><img src="'.$this->webroot.'img/icons/redx.png" title="Delete" alt="" /></a>	';	
$res .= '<a href="'.$this->webroot.'calls/directions/'.$contact['Contact']['id'].'" target="_blank">|Directions</a>';
$res .= '<a href="'.$this->webroot.'calls/directionsmap/'.$contact['Contact']['id'].'" target="_blank">|Directions Map</a>';
$res .= '<a href="'.$this->webroot.'calls/detailsmap/'.$contact['Contact']['id'].'" target="_blank">|Details Map</a>';
$res .= '<a href="'.$this->webroot.'calls/removefromcalls/'.$contact['Contact']['id'].'" >|remove from calls</a>';
$res .= '<a href="'.$this->webroot.'calls/repend/'.$contact['Contact']['id'].'" >|repend</a>';
$res .= '<a href="http://maps.google.com/?q='.
urlencode($contact['Contact']['street1']).
urlencode($contact['Contact']['city']).
urlencode($contact['Contact']['state']).
urlencode($contact['Contact']['zip']).
'" class="button" target="_blank">|MAP</a>';


	$res .='	</td>	</tr>';
		endforeach;
	$res .='</table>';
	return $res;
	}
function calendar($json )
	{
$res ="<style type='text/css'>


	#calendar {
		width: 900px;
		margin: 0 auto;
		}


</style>


<script type='text/javascript'>

$(document).ready(function() {

$('#calendar').fullCalendar({

	header: {
		left: 'prev,next today',
		center: 'title',
		right: 'month,agendaWeek,agendaDay'
		},
	events: ".$json." // this is where we call the php variable

});
});
</script>

<div id='calendar' style='width: 900px; margin: 0 auto;'></div>
";
		return $res;
	}
}
?>

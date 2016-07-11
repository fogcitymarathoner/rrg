<?php

class RappHelper extends Helper {

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
	
	function regularDateDisplay($sqldate)
	{
		$dateexplode = explode('-',$sqldate);
		return $dateexplode[1].'/'.$dateexplode[2].'/'.$dateexplode[0];
	}
}
?>

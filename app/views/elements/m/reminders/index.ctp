<?php
	function reminders($reminders,$webroot)
	{
		$html = new HtmlHelper;
        $res = '<ul data-role="listview">';
if (!empty($reminders))
{
foreach($reminders as $invoice):

$res .= '<li>';
    $res .= $invoice['ClientsContract']['Client']['name'];

    if ($invoice['ClientsContract']['employee_id'])
    {
    $res .=  '<b><a href="'.$webroot.'m/employees/view_paychecks_due/'.
        $invoice['ClientsContract']['Employee']['id'].
'">'.$invoice['ClientsContract']['Employee']['firstname'].' '.$invoice['ClientsContract']['Employee']['lastname'].'</a>';

        }

        $res .= '<br>';
        if($invoice['Invoice']['period_start'])
        {
        $res .= '<br ><b>';
            $res .=  date('m/d/Y', strtotime($invoice['Invoice']['period_start'])).'-'.date('m/d/Y', strtotime($invoice['Invoice']['period_end']));
            $res .= '</b><br>';
        } else {
        $res .= '<br> ';
        }
        $res .= '<a href="'.$webroot.'m/reminders/edit_notes/'.$invoice['Invoice']['id'].'/index">edit notes</a>   ';
        $res .= $invoice['Invoice']['notes'];

        endforeach;
        } else {

        $res .= '</li>';
}
$res .= '</ul>';
return $res;

}

?>
<?php echo reminders($reminders,$webroot) ?>
<?php
App::import('Helper', 'Html');
$html = new HtmlHelper;
$out = '<div id="navigation">
        <ul id="menu">
            <li>'.$html->link(__('General Info', true), array('action'=>'view',$client['id'])).'</li>';

$out .= '<li>'.$html->link(__('Checks', true), array('action'=>'view_checks',$client['id'])).'</li>';

$out .= '<li>'.$html->link(__('Active Contracts', true), array('action'=>'view_active_contracts',$client['id'])).'</li>';
$out .= '<li>'.$html->link(__('Inactive Contracts', true), array('action'=>'view_inactive_contracts',$client['id'])).'</li>';
$out .= '<li>'.$html->link(__('Managers', true), array('action'=>'view_managers',$client['id'])).'</li>';
$out .= '<li>'.$html->link(__('Memos', true), array('action'=>'view_memos',$client['id'])).'</li>';
$out .= '<li>'.$html->link(__('Active Searches', true), array('action'=>'view_active_searches',$client['id'])).'</li>';
$out .= '<li>'.$html->link(__('Inactive Searches', true), array('action'=>'view_inactive_searches',$client['id'])).'</li>';
$out .= '<li>'.$html->link(__('Invoices', true), array('action'=>'view_invoices',$client['id'])).'</li>';
$out .= '<li>'.$html->link(__('Past Due Invoices', true), array('action'=>'view_invoices_pastdue',$client['id'])).'</li>';
$out .= '<li>'.$html->link(__('Pending Invoices', true), array('action'=>'view_invoices_pending',$client['id'])).'</li>';
$out .= '<li>'.$html->link(__('Statement', true), array('action'=>'view_statement',$client['id'])).'</li>';
$out .= '<li>'.$html->link(__('Payment History', true), array('action'=>'view_payment_history',$client['id'])).'</li>';

if(isset($client['hq']) &&$client['hq'])
{
    $out .= '<li>'.$html->link(__('Opening Commissions Invoices', true), array('action'=>'view_openinginvoices',$client['id'])).'</li>';
}
$out .=  '</ul>
    </div> 	';
echo $out;
?>
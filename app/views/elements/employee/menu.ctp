<?php
        function employee_menu($employee)
       	{
            $id = $employee['id'];
       		App::import('Helper', 'Html');
       		$html = new HtmlHelper;
       		$out = '<div id="navigation">
       				<ul id="menu">
       					<li>'.$html->link(__('General Info', true), array('action'=>'view',$id)).'</li>';
       		$out .= '<li>'.$html->link(__('Contracts', true), array('action'=>'view_contracts',$id)).'</li>';
       		$out .= '<li>'.$html->link(__('Memos', true), array('action'=>'view_memos',$id)).'</li>';
       		$out .=  '<li>'.$html->link(__('Paychecks Due', true), array('action'=>'view_paychecks_due',$id)).'</li>';
       		$out .=  '<li>'.$html->link(__('Payments', true), array('action'=>'view_payments',$id)).'</li>';
       		$out .=  '<li>'.$html->link(__('Skipped Timecards', true), array('action'=>'view_skipped_timecards',$id)).'</li>';
            if($employee['salesforce'])
            {
                $out .=  '<li>'.$html->link(__('Expenses', true), array('action'=>'view_expenses',$id)).'</li>';
                $out .=  '<li>'.$html->link(__('Notes', true), array('action'=>'view_notes',$id)).'</li>';
                $out .=  '<li>'.$html->link(__('Commissions Reports', true), array('action'=>'view_commissions_reports',$id)).'</li>';
                $out .=  '<li>'.$html->link(__('Notes Reports', true), array('action'=>'view_notes_reports',$id)).'</li>';
            }
       		$out .=  '</ul>			</div> 	';
       		return $out;
       	}
        function employee_menu_row2($employee)
        {
            $id = $employee['id'];
            App::import('Helper', 'Html');
            $html = new HtmlHelper;
            $out = '<div id="navigation">
            <ul id="menu">
            <li>'.$html->link(__('Letters', true), array('action'=>'view_letters',$id)).'</li>';
            $out .=  '</ul>			</div> 	';
            return $out;
        }

        function employee_payment_menu($employee)
        {
            $id = $employee['id'];
            App::import('Helper', 'Html');
            $html = new HtmlHelper;
            $out = '';

            if($employee['salesforce'])
            {
            $out .= '<div id="navigation">
            <ul id="menu">';
            $out .= '<li>'.$html->link(__('Commissions Payments', true), array('action'=>'view_commissions_payments',$id)).'</li>';
            $out .= '</li><li>'.$html->link(__('Notes Payments', true), array('action'=>'view_notes_payments',$id)).'</li>';
            $out .=  '</ul>			</div> 	';
            }
            return $out;

        }


        echo employee_menu($employee);
        echo '<br>';
        echo employee_menu_row2($employee);
        echo '<br>';
        echo employee_payment_menu($employee);
?>
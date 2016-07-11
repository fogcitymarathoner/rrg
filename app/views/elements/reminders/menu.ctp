<?php

        function reminders_menu()
        {
        App::import('Helper', 'Html');
        $html = new HtmlHelper;
        $out = '<div class="simple_menu_navigation">
        <ul id="menu">
        <li>'.$html->link(__('Reminders', true), array('action'=>'index')).'</li><li>';
        $out .= $html->link(__('Timecards', true), array('action'=>'timecards'));
        $out .= '</li><li>'.$html->link(__('Open Invoices', true), array('action'=>'opens')).'</li>';
        $out .= '</li><li>'.$html->link(__('Timecard Receipts Pending', true), array('action'=>'timecard_receipts_pending')).'</li>';
        $out .= '</li><li>'.$html->link(__('Timecard Receipts Sent', true), array('action'=>'timecard_receipts_sent')).'</li>';
        $out .=  '</ul>
        </div> 	';
        return $out;
        }

        echo reminders_menu();
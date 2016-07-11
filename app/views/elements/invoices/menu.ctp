<?php
function invoice_menu()
        {
        App::import('Helper', 'Html');
        $html = new HtmlHelper;
        $out = '<div class="simple_menu_navigation">
    <ul id="menu">
        <li>'.$html->link(__('All', true), array('action'=>'index')).'</li><li>';
        $out .= $html->link(__('Past Due', true), array('action'=>'index_pastdue'));
        $out .= '</li><li>'.$html->link(__('Open', true), array('action'=>'index_open')).'</li>';
        $out .=  '<li>'.$html->link(__('Cleared', true), array('action'=>'index_cleared')).'</li>';
        $out .=  '<li>'.$html->link(__('Voided', true), array('action'=>'index_voided')).'</li>';
        $out .=  '<li>'.$html->link(__('Search Invoices', true), array('action'=>'search')).'</li>';
        $out .=  '<li>'.$html->link(__('Search by Number', true), array('action'=>'search_bynum')).'</li>	</ul>
</div> 	';
        return $out;
        }

echo invoice_menu();
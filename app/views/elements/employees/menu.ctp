<?php
        function employees_menu()
        {
        App::import('Helper', 'Html');
        $html = new HtmlHelper;
        $out = '<div id="navigation">
        <ul id="menu">


        <li>'.$html->link(__("Active Employees", true), array("controller"=> "employees", "action"=>"index")).'</li>
        <li>'.$html->link(__("Incomplete Employees", true), array("controller"=> "employees", "action"=>"incomplete")).'</li>
        <li>'.$html->link(__("Active Document Managment", true), array("controller"=> "employees", "action"=>"active_document_management")).'</li>
        <li>'.$html->link(__("Inactive Employees", true), array("controller"=> "employees", "action"=>"inactive")).'</li>
        <li>'.$html->link(__("Search Employees", true), array("controller"=> "employees", "action"=>"search")).'</li>
        <li>'.$html->link(__("Labels", true), array("controller"=> "employees", "action"=>"select_labels")).'</li>
        <li>'.$html->link(__("New Employee", true), array("action"=>"add")).'</li>
        <li>'.$html->link(__("Timecard Receipts", true), array("action"=>"timecard_receipts")).'</li>'.
        '<li>'.$html->link(__("Sync w/ Sphene", true), array("action"=>"sync_sphene")).'</li>';
        $out .=  '</ul>			</div> 	';
        return $out;
        }

        echo employees_menu();
<?php
    $id = $payroll['id'];
    App::import('Helper', 'Html');
    $html = new HtmlHelper;
?>

    <ul class="demo_ul">
        <li><?php echo $html->link(__('General Info', true), array('action'=>'view',$id))?></li><li><?php echo $html->link(__('Labels', true), array('action'=>'labels','id'=>$id))?></li>
    </ul>
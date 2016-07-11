<dl><?php $i = 0; $class = ' class="altrow"';?>
    <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Number'); ?></dt>
<dd<?php if ($i++ % 2 == 0) echo $class;?>>
        <?php echo $html->link($data['Invoice']['id'], array('controller'=> 'clients', 'action'=>'edit_invoice', $data['Invoice']['id'], 'next'=>'view_invoice')); ?>
        &nbsp;
        </dd>
<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('date'); ?></dt>
<dd<?php if ($i++ % 2 == 0) echo $class;?>>
        <?php echo date('m/d/Y',strtotime($data['Invoice']['date'])); ?>
        &nbsp;
        </dd>
<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Period'); ?></dt>
<dd<?php if ($i++ % 2 == 0) echo $class;?>>
        <?php
                echo date('m/d/Y',strtotime($data['Invoice']['period_start'])).'-'.
                date('m/d/Y',strtotime($data['Invoice']['period_end'])); ?>
        &nbsp;
        </dd>
<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Amount'); ?></dt>
<dd<?php if ($i++ % 2 == 0) echo $class;?>>
        <?php echo sprintf('%8.2f',round($data['Invoice']['amount'],2)); ?>
        &nbsp;
        </dd>
<dt<?php if ($i % 2 == 0) echo $class;?>><?php __("term's"); ?></dt>
<dd<?php if ($i++ % 2 == 0) echo $class;?>>
        <?php echo $data['Invoice']['terms']; ?>
        &nbsp;
        </dd>
<dt<?php

        $datearray = getdate(strtotime($data['Invoice']['date']));
        $duedate  = mktime(0, 0, 0, date('m',strtotime($datearray['month']))  , $datearray['mday']+$data['Invoice']['terms'], $datearray['year']);

        if ($i % 2 == 0) echo $class;?>><?php __('Due date'); ?></dt>
<dd<?php if ($i++ % 2 == 0) echo $class;?>>
        <?php echo date('m/d/Y',strtotime(date('Y-m-d',$duedate))); ?>
        &nbsp;
        </dd>
<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Client'); ?></dt>
<dd<?php if ($i++ % 2 == 0) echo $class;?>>
        <?php echo $data['Client']['Client']['name']; ?>
        &nbsp;
        </dd>
<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Title'); ?></dt>
<dd<?php if ($i++ % 2 == 0) echo $class;?>>
        <?php echo $data['ClientsContract']['title']; ?>
        &nbsp;
        </dd>
        </dl>
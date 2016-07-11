<style>

    table tr.altrow td {
        background: #f4f4f4;
        color: #000000;
    }

    /*  Actions  */
    table tr.altrow td  a{
        color: #000000;
    }
</style>

<div class="clients index">
    <h2><?php __('Clients');?></h2>
    <p>
    <div class="actions">
        <ul>
            <li><?php echo $html->link(__('Search', true), array('action'=>'search')); ?> </li>

            <li><?php echo $html->link(__('New Client', true), array('action'=>'add')); ?></li>

        </ul>
    </div>
    <script type="text/javascript">
    <!--
    $(document).ready(function(){
        $( ".client-tabs" ).tabs();
    });
    //-->
    </script>
    <div class="client-tabs">
      <ul>
        <li><a href="#clients-tabs-1">Active</a></li>
        <li><a href="#clients-tabs-2">Inactive</a></li>
      </ul>
      <div id="clients-tabs-1">
        <?php echo $this->element('clients/index',array('clients'=>$clients,'active'=>1, 'webroot'=>$this->webroot)); ?>  </div>
      <div id="clients-tabs-2">
        <?php echo $this->element('clients/index',array('clients'=>$clients,'active'=>0, 'webroot'=>$this->webroot)); ?>
      </div>
    </div>
</div>
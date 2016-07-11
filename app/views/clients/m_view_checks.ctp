
<h3><?php echo $this->data['Client']['name']; ?>'s Checks</h3>
        <?php echo $client->view($this->data['Client'],$this->data['State']['name']); ?>
        <!-- Checks -->
        <?php echo $html->link(__('New Check For Client', true), array('action'=>'add_check/')); ?>
        <?php echo $this->element('client/list_checks', array(
                'checks'=>$this->data['ClientsCheck'],
                'next'=>$next,
                'webroot'=>$this->webroot,
                ));
                ?>
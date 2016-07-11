
<?php
//echo $javascript->link('commissions_reports_view'); //debug($commissionsReport);exit;
?>
<?php echo $html->link(__('Return to CommissionsReports', true), array('action' => 'index'));?>

<div class="commissionsReports view">
<h2><?php  __('CommissionsReport');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Period'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $commissionsReport; ?>
			&nbsp;
		</dd>
	</dl>
</div>

<?php if(!empty($tags))
{                         //if report tags not empty ?>


<?php echo $this->element('waiting_area',array('webroot'=>$this->webroot));?>

<div id="release_waiting_area">
</div>
<table cellpadding="1" cellspacing="1">
<tr>
	<th><?php echo 'name';?></th>
	<th class="actions"><?php __('Actions');?></th>
	<th class="actions">Cleared</th>
	<th class="actions">Release</th>
</tr>
<?php
$i = 0;
foreach ($tags as $commissionsReportsTag):
//debug($commissionsReportsTag);
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
	if(isset($commissionsReportsTag['Employee']['id']))
	{
	if($commissionsReportsTag['Employee']['salesforce'])
	{
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $commissionsReportsTag['Employee']['firstname'].' '.$commissionsReportsTag['Employee']['lastname']; ?>
		</td>

		<td class="actions">
            <span id="nav-button-<?php echo $commissionsReportsTag['CommissionsReportsTag']['id']?>">
                <?php if(!$commissionsReportsTag['CommissionsReportsTag']['release'])
                { ?>
                <?php echo $html->link(__('View', true), array('action' => 'view_report_tag', $commissionsReportsTag['CommissionsReportsTag']['id'])); ?>
                <?php } else { ?>
                View
                <?php } ?>
                <?php if($commissionsReportsTag['CommissionsReportsTag']['release'])
                { ?>
                <?php echo $html->link(__('Fixture View', true), array('action' => 'view_report_tag_fixture', $commissionsReportsTag['CommissionsReportsTag']['id'])); ?>
                <?php } else { ?>
                Fixture View
                <?php } ?>
            </span>
		</td>

        <td>
            <?php echo $commissionsReportsTag['CommissionsReportsTag']['cleared']; ?>
        </td>
		<td class="actions">
        <span id="release-button-<?php echo $commissionsReportsTag['CommissionsReportsTag']['id']?>">
            <?php
                    if(!$commissionsReportsTag['CommissionsReportsTag']['release'])
                         echo $form->input('Release', array(
                                                'type' => 'radio',
                                                'id' => 'release-radio-'.$commissionsReportsTag['CommissionsReportsTag']['id'],
                                                'value' => $commissionsReportsTag['CommissionsReportsTag']['release'],
                                                'name' =>$commissionsReportsTag['CommissionsReportsTag']['id'].'_'.$commissionsReportsTag['CommissionsReportsTag']['release'],
                                                'options' => array('no','yes'),
                                            ));
            ?>
        </span>
		</td>
	</tr>
<?php }
}
endforeach; ?>
</table>

<style type="text/css">
div#releasereporturl {
    display: none;
}
</style>
	 <div id='releasereporturl' ><?php echo     $this->webroot;?>commissions_reports/release_report</div>
<script type="text/javascript">
  $(document).ready(function () {
      $("input:radio").click(function()
      {

        $report_tag_id = parseInt(this.name.split('_')[0]);
        $val = $("input:radio:checked").val();
        $args =new Array();

        $args = {

            tag: $report_tag_id,
            value: $val
        };

        $url = $('#releasereporturl').html();
        $data =$.param($args);
        //alert($url);
        //alert($data);

        $('#reminders-waiting-area').addClass( 'waiting div400x100' );
        $.post($url, $data,
            function(data) {
                $('#reminders-waiting-area').removeClass( 'waiting div400x100' );
                $('#release-button-'+$report_tag_id).hide();
                $('#nav-button-'+$report_tag_id).html('View<a href="/commissions_reports/view_report_tag_fixture/'+$report_tag_id+'">Fixture View</a>');
            },
        'json'
        );

        $('#reminders-waiting-area').removeClass( 'waiting div400x100' );
    }
  )
  // hide "waiting" spinner
  $('#reminders-waiting-area').removeClass('waiting div400x100' );
  $('#modal-overlay').hide();
  });

</script>
<?php }; //if report tags not empty ?>

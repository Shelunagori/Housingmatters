<?php
if(sizeof($result_alerts)==0) { echo '<div align="center"><h4>No alerts for you.</h4></div>'; }
foreach($result_alerts as $data)
{
$alert_id=$data['alert']['alert_id'];
$text=$data['alert']['text'];
$url=$data['alert']['url'];
$icon=$data['alert']['icon'];
?>
<a href="<?php echo $url; ?>" rel='tab' style="text-decoration:none;"><div class="ntfction_list"><?php echo $icon; ?> <?php echo $text; ?></div></a>
<?php } ?>
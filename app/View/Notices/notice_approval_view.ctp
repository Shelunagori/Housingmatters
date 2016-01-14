<br>
<?php
foreach($result_view as $data)
{
$notice_id=$data['notice']['notice_id'];
$n_draft_id=$data['notice']['n_draft_id'];
$n_subject=$data['notice']['n_subject'];
$n_message=$data['notice']['n_message'];
$n_date=$data['notice']['n_date']; 
$n_time=$data['notice']['n_time'];
}
?>
<div id="show_data"></div>
<div style="background-color:#F3F3F3; border:solid 2px #fcb322; padding:10px; width:90%; margin:auto;">
<div align="center" style="background-color:#CCC;"><h3><b><?php echo $n_subject; ?></b></h3></div>
<div align="right"><span ><?php echo $n_date; ?>&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $n_time; ?></span></div>
<div align="justify"><p style='font-size:15px;'><?php echo $n_message; ?></p></div>


<br>
<a href='#' class='btn green app' role='button' ap_id='<?php echo $notice_id ; ?>'> Approved </a>

<a href='#' class='btn red rej' role='button' ap_id='<?php echo $notice_id ; ?>'> Reject </a>



</div>
<script>
$(document).ready(function(){
$(".app").live("click",function(){
var n_id=$(this).attr("ap_id");
$('#show_data').html('<div id="pp"><div class="modal-backdrop fade in"></div><div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true"><div class="modal-body" style="font-size:14px;"> Notices are Published. </div><div class="modal-footer"><a href="<?php echo $this->webroot; ?>Notices/notice_approval_ajax/'+n_id+'" class="btn blue" id="yes">Ok</a></div></div></div>');


});

$(".rej").live("click",function(){
var n_id=$(this).attr("ap_id");
$('#show_data').html('<div id="pp"><div class="modal-backdrop fade in"></div><div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true"><div class="modal-body" style="font-size:14px;"><i class="icon-warning-sign" style="color:#d84a38;"></i> Are you sure you want to reject notices ? </div><div class="modal-footer"><a href="<?php echo $this->webroot; ?>Notices/notice_approval_reject/'+n_id+'" class="btn blue" id="yes">Yes</a><a href="#"  role="button" id="can" class="btn">No</a></div></div></div>');
$("#can").live("click",function(){
$("#pp").hide();
});

});
});

</script>
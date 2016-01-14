<?php
echo $this->requestAction(array('controller' => 'hms', 'action' => 'submenu'), array('pass' => array()));
?>
<script>
$(document).ready(function() {
$("#fix<?php echo $id_current_page; ?>").removeClass("blue");
$("#fix<?php echo $id_current_page; ?>").addClass("red");
});
</script>

<?php 
function substrwords($text, $maxchar, $end='...') {
    if (strlen($text) > $maxchar || $text == '') {
        $words = preg_split('/\s/', $text);      
        $output = '';
        $i      = 0;
        while (1) {
            @$length = strlen($output)+strlen($words[$i]);
            if ($length > $maxchar) {
                break;
            } 
            else {
                @$output .= " " . $words[$i];
                ++$i;
            }
        }
        $output .= $end;
    } 
    else {
        $output = $text;
    }
    return $output;
}
?>
<div style='text-align:center;'>
<a href='classified_buy' class="btn blue " role="button" rel='tab' >Buy</a> 
<a href='classified_sel' class="btn  red" rel='tab' role="button" >Sell</a></div>
<?php
$c=0;
foreach ($result_classifieds as $classified){
	$c++;
	if ($c % 2 != 0) {
		echo '<div class="row-fluid">';
	}
	$classified_id=(int)$classified['classified']['classified_id'];
	$title=$classified['classified']['title'];
	$title_cut=strtoupper(substrwords($title,35,'...'));
	$file=$classified['classified']['file'];
	$price=$classified['classified']['price'];
	$price_type=$classified['classified']['price_type'];
	if($price_type==1){
		$price_type_text="Negotiable";
	}elseif($price_type==2){
		$price_type_text="Fixed";
	}
	$ad_type=$classified['classified']['ad_type'];
	$condition=$classified['classified']['condition'];
	if($condition==1){
		$condition_text="Used";
	}elseif($condition==2){
		$condition_text="New";
	}
	$offer=(int)$classified['classified']['offer'];
	$created=date('Y-m-d',$classified['classified']['created']->sec);
	$now = time();
	$your_date = strtotime($created);
	$datediff = $now - $your_date;
	$days=floor($datediff/(60*60*24));
	$offer_for=$offer-$days;
	
	$description=$classified['classified']['description'];
	$description_cut=substrwords($description,100,'...');
	$category=$classified['classified']['category'];
	$category_name=$this->requestAction(array('controller' => 'Hms', 'action' => 'classified_category_name'), array('pass' => array($category)));
	$sub_category=$classified['classified']['sub_category'];
	$sub_category_name=$this->requestAction(array('controller' => 'Hms', 'action' => 'classified_subcategory_name'), array('pass' => array($sub_category))); ?>
	
	<div class="span6" >
	<?php if($ad_type==1){
		echo '<span class="badge badge-success" style="position: relative; top: 20px;">Sell</span>';
	}elseif($ad_type==2){
		echo '<span class="badge badge-important" style="position: relative; top: 20px;">Buy</span>';
	}?>
	
		<div class="white_<?php echo $ad_type; ?>" onclick="view_classified(<?php echo $classified_id; ?>)">
			<!--Ad content start-->
			<table width="100%">
				<tr>
					<td width="30%" align="center" style=" background-color: #F1F3FA; ">
						<?php if(!empty($file)) { ?>
						<img src="<?php echo $webroot_path; ?>Classifieds/<?php echo $file; ?>" style="height:120px;" />
						<?php }else{ ?>
						<img src="<?php echo $webroot_path; ?>as/AAAAAA&text=no+image.gif" style="height:120px;" />
						<?php } ?>
						
					</td>
					<td width="70%" valign="top">
						<table width="100%">
							<tr>
								<td colspan="2" width="100%">
									<div class="title pull-left"><?php echo $title_cut; ?><br/><span class="category"><?php echo $category_name; ?> -> <?php echo $sub_category_name; ?></span></div>
									<div class="price pull-right">&#8377; <?php echo $price; ?><br/><span class="category"><?php echo $price_type_text; ?></span></div>
								</td>
							</tr>
							<tr>
								<td width="20%" class="tag">Condition:</td>
								<td class="tag_val"><?php echo $condition_text; ?></td>
							</tr>
							<tr>
								<td width="20%" class="tag">Offer for:</td>
								<td class="tag_val"><?php echo $offer_for.'<span style="color:red;">*</span> Days'; ?></td>
							</tr>
							<tr>
								<td width="20%" class="tag" valign="top">Description:</td>
								<td class="tag_des"><?php echo $description_cut; ?></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			<!--Ad content end-->
		</div>
	</div>
<?php if ($c % 2 == 0) {
			echo '</div>';
		}
		if (sizeof($result_classifieds)%2 != 0 and sizeof($result_classifieds)==$c) {
			echo '</div>';
		}
	} ?>



<div class="view_div"  style="display:none;">
	<div class="modal-backdrop fade in"></div>
	<div id="myModal_ad123" class="modal fade in" style="width: 80%; margin: auto; left: 10%;">
		<span class="label" style="position: absolute;right: 0px;">close</span>
		<div class="modal-body"><div align="center"><img src="<?php echo $webroot_path; ?>as/fb_loading.gif" /> <br/> Please Wait...</div></div>
	</div>
	
</div>

<style>
.white_1{
background-color: white;
padding:2px;
border: 1px solid #DDDDDD;
margin-bottom: 5px;
}
.white_2{
background-color: white;
padding:2px;
border: 1px solid #DDDDDD;
margin-bottom: 5px;
}
.white_1:hover{
border: 1px solid rgba(60, 192, 81, 1);
background-color: rgba(60, 192, 81, 0.1);
cursor: pointer;
}
.white_2:hover{
border: 1px solid rgba(237, 78, 42, 1);
background-color: rgba(237, 78, 42, 0.06);
cursor: pointer;
}
.white_1:active{
border: 2px solid rgba(60, 192, 81, 1);
}
.white_2:active{
border: 2px solid rgba(237, 78, 42, 1);
}
.title{
font-size: 15px;
color: #4B77BE;
}
.title_v{
font-size: 16px;
color: #4B77BE;
}
.price{
font-size: 15px;
}
.price_v{
font-size: 18px;
color:#e84d1c;
}
.category{
color: rgb(142, 142, 142);
font-size: 12px;
}
.category_v{
color: rgb(142, 142, 142);
font-size: 13px;
}
body.modal-open {
    overflow: hidden;
}
.tag{
color: #8C8C8C;
}
.tag_val{
color: rgb(55, 55, 55);
}
.tag_des{
color: rgb(55, 55, 55));
font-size: 12px;
}
</style>
<script>
function view_classified(id){
	$(document).ready(function() {
		$("#myModal_ad123").html('<div class="modal-body"><div align="center"><img src="<?php echo $webroot_path; ?>as/fb_loading.gif" /> <br/> Please Wait...</div></div>')
		$(".view_div").show();
		$("body").addClass("modal-open");
		$.ajax({
			url: "<?php echo $webroot_path; ?>Classifieds/view_ad_sel/"+id,
			}).done(function(response) {
			$("#myModal_ad123").html(response);
			});
	});
}



function intrested_in_classified(id){
	$(document).ready(function() {
		$("#myModal_ad123").html('<div class="modal-body"><div align="center"><img src="<?php echo $webroot_path; ?>as/fb_loading.gif" /> <br/> Please Wait...</div></div>')
		$(".view_div").show();
		$("body").addClass("modal-open");
		$.ajax({
			url: "<?php echo $webroot_path; ?>Classifieds/intrested_in_classified_ajax/"+id,
			}).done(function(response) {
			$("#myModal_ad123").html(response);
			});
	});
}

$(document).ready(function() {
	$(".model_close").live('click',function(){
		$(".view_div").hide();
		$("body").removeClass("modal-open");
	});
});

$(document).ready(function() {
	$("#send_message").live('click',function(){
		var m=$(".type_message").val();
		m=encodeURIComponent(m);
		var id=$(this).attr("c_id");
		$.ajax({
			url: "<?php echo $webroot_path; ?>Classifieds/send_message_ajax?con="+id +"&con1="+m
			}).done(function(response) {
			$("#myModal_ad123").html(response);
			});
	});
});

</script>
<?php if(!empty($id)){ ?>
	<script>view_classified(<?php echo $id; ?>);</script>
<?php } ?>


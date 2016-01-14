<?php foreach ($result_classified as $classified){
	$classified_id=(int)$classified['classified']['classified_id'];
	$title=strtoupper($classified['classified']['title']);
	$file=$classified['classified']['file'];
	$price=$classified['classified']['price'];
	$society_id=$classified['classified']['society_id'];
	$society_result=$this->requestAction(array('controller' => 'Hms', 'action' => 'society_name'), array('pass' => array((int)$society_id)));
	$society_name=$society_result[0]["society"]["society_name"];
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
	$category=$classified['classified']['category'];
	$category_name=$this->requestAction(array('controller' => 'Hms', 'action' => 'classified_category_name'), array('pass' => array($category)));
	$sub_category=$classified['classified']['sub_category'];
	$sub_category_name=$this->requestAction(array('controller' => 'Hms', 'action' => 'classified_subcategory_name'), array('pass' => array($sub_category)));
}
?>
<div class="modal-body">
		<?php if($ad_type==1){
			echo '<span class="badge badge-success" style="position: absolute; top: 15px;">Sell</span>';
		}elseif($ad_type==2){
			echo '<span class="badge badge-important" style="position: absolute; top: 15px;">Buy</span>';
		}?>
	<div class="row-fluid">
		<div class="span7" align="center" style="background-color: #F1F3FA;min-height: 400px;line-height: 390px;">
		<?php if(!empty($file)) { ?>
		<img src="<?php echo $webroot_path; ?>Classifieds/<?php echo $file; ?>" style="height:400px;" />
		<?php }else{ ?>
		<img src="<?php echo $webroot_path; ?>as/AAAAAA&text=no+image.gif" style="height:200px;" />
		<?php } ?>
		</div>
		<div class="span5" >
		<!--Ad content start-->
		<table width="100%">
			<tr>
				<td colspan="2" width="100%">
					<div class="title_v pull-left"><?php echo $title; ?><br/><span class="category_v"><?php echo $category_name; ?> -> <?php echo $sub_category_name; ?></span></div>
				</td>
			</tr>
			<tr>
				<td width="20%" class="tag">Condition:</td>
				<td class="tag_val"><?php echo $condition_text; ?></td>
			</tr>
			<tr>
				<td width="20%" class="tag">Price: </td>
				<td class="tag_val"><div class="price_v">&#8377; <?php echo $price; ?>&nbsp;&nbsp;<span class="category"><?php echo $price_type_text; ?></span></div></td>
			</tr>
			<tr>
				<td width="20%" class="tag">Offer for:</td>
				<td class="tag_val"><?php echo $offer_for.'<span style="color:red;">*</span> Days'; ?></td>
			</tr>
			<tr>
				<td width="20%" class="tag" valign="top">Society Name:</td>
				<td class="tag_des"><?php echo $society_name; ?></td>
			</tr>
			<tr>
				<td width="20%" class="tag" valign="top">Description:</td>
				<td class="tag_des"><?php echo $description; ?></td>
			</tr>
			<tr>
				<td width="20%" class="tag" valign="top"><a href="#" role="button" class="btn blue" onclick="intrested_in_classified(<?php echo $classified_id; ?>)">Interested</a></td>
				<td></td>
			</tr>
		</table>
			<!--Ad content end-->
		</div>
	</div>
</div>
<div class="modal-footer">
	<a href="#" role="button" class="btn purple pull-left" onclick="view_classified(<?php echo $result_prv; ?>)"><i class="icon-circle-arrow-left"></i> Previous</a>
	<a href="#" role="button" class="btn model_close"><i class="icon-remove-sign"></i> Close</a>
	<a href="#" role="button" class="btn purple" onclick="view_classified(<?php echo $result_next; ?>)">Next <i class="icon-circle-arrow-right"></i> </a>
</div>
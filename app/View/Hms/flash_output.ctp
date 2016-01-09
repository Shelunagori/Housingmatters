<?php
$flash=$result_cursor1[0]["flash"]["active"];
if($flash==1){
	$title=$result_cursor1[0]["flash"]["title"];
	$description=$result_cursor1[0]["flash"]["description"];
	$theme=$result_cursor1[0]["flash"]["theme"];
	?>
	<div class="<?php echo $theme; ?>" id="flash_div"><button type="button" class="close remove_flash" ></button><span class="title"><?php echo $title; ?></span><br><span class="description"><?php echo $description; ?></span></div>
	<?php
}
?>
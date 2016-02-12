

<?php //if(sizeof($result_import_record)==0){ ?>
<div class="portlet box green" style="width: 50%; margin: auto;">
	<div class="portlet-title">
		<h4><i class="icon-cogs"></i> Import Receipts</h4>
	</div>
	<div class="portlet-body" align="">
		<form method="post" id="form1" style="margin: 0px;">
			<h5>Upload CSV file in given format to import Receipts.</h5>
			<input name="file" class="default" id="image-file" type="file">
			<a href="open_excel" download="" target="_blank">Download sample format</a><br/><br/>
			<h5 id="submit_element" >
			<button type="submit" class="btn blue">IMPORT RECEIPTS</button>
			</h5>
		</form>
	</div>
</div>
<?php //} ?>
<?php echo $this->fetch('content'); ?>
<script>
var test = $("input[type=checkbox]:not(.toggle), input[type=radio]:not(.toggle)");
if (test) {
	test.uniform();
}
$('.date-picker').datepicker().on('changeDate', function(){
 $(this).blur();
}); 
 $('.timepicker-default').timepicker();
$(".chosen").chosen(); 
 $('#sample_1').dataTable({
            "sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
            "sPaginationType": "bootstrap",
            "oLanguage": {
                "sLengthMenu": "_MENU_ records per page",
                "oPaginate": {
                    "sPrevious": "Prev",
                    "sNext": "Next"
                }
            },
            "aoColumnDefs": [{
                'bSortable': false,
                'aTargets': [0]
            }]
        });
$('.text-toggle-button').toggleButtons({
	width: 200,
	label: {
		enabled: "Active",
		disabled: "Deactive"
	}
});
$('.basic-toggle-button').toggleButtons();
if (App.isTouchDevice()) { // if touch device, some tooltips can be skipped in order to not conflict with click events
	jQuery('.tooltips:not(.no-tooltip-on-touch-device)').tooltip();
} else {
	jQuery('.tooltips').tooltip();
}
$('.wysihtml5').wysihtml5();
$('.scroller').each(function () {
	$(this).slimScroll({
		//start: $('.blah:eq(1)'),
		size: '7px',
		color: '#a1b2bd',
		height: $(this).attr("data-height"),
		alwaysVisible: ($(this).attr("data-always-visible") == "1" ? true : false),
		railVisible: ($(this).attr("data-rail-visible") == "1" ? true : false),
		disableFadeOut: true
	});
});
jQuery('.popovers').popover();
</script>

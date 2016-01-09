var Appajax = function () {

    var isIE8 = false; // IE8 mode
    var currentPage = ''; // current page
	
	var handleUniform = function () {
        if (!jQuery().uniform) {
            return;
        }
        var test = $("input[type=checkbox]:not(.toggle), input[type=radio]:not(.toggle)");
        if (test) {
            test.uniform();
        }
    }
	var handleDateTimePickers = function () {

        if (!jQuery().daterangepicker) {
            return;
        }

        $('.date-range').daterangepicker();

        $('#dashboard-report-range').daterangepicker({
            ranges: {
                'Today': ['today', 'today'],
                'Yesterday': ['yesterday', 'yesterday'],
                'Last 7 Days': [Date.today().add({
                    days: -6
                }), 'today'],
                'Last 30 Days': [Date.today().add({
                    days: -29
                }), 'today'],
                'This Month': [Date.today().moveToFirstDayOfMonth(), Date.today().moveToLastDayOfMonth()],
                'Last Month': [Date.today().moveToFirstDayOfMonth().add({
                    months: -1
                }), Date.today().moveToFirstDayOfMonth().add({
                    days: -1
                })]
            },
            opens: 'left',
            format: 'MM/dd/yyyy',
            separator: ' to ',
            startDate: Date.today().add({
                days: -29
            }),
            endDate: Date.today(),
            minDate: '01/01/2012',
            maxDate: '12/31/2014',
            locale: {
                applyLabel: 'Submit',
                fromLabel: 'From',
                toLabel: 'To',
                customRangeLabel: 'Custom Range',
                daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                firstDay: 1
            },
            showWeekNumbers: true,
            buttonClasses: ['btn-danger']
        },

        function (start, end) {
            App.blockUI(jQuery("#dashboard"));
            setTimeout(function () {
                App.unblockUI(jQuery("#dashboard"));
                $.gritter.add({
                    title: 'Dashboard',
                    text: 'Dashboard date range updated.'
                });
                App.scrollTo();
            }, 1000);
            $('#dashboard-report-range span').html(start.toString('MMMM d, yyyy') + ' - ' + end.toString('MMMM d, yyyy'));

        });

        $('#dashboard-report-range').show();

        $('#dashboard-report-range span').html(Date.today().add({
            days: -29
        }).toString('MMMM d, yyyy') + ' - ' + Date.today().toString('MMMM d, yyyy'));

        $('#form-date-range').daterangepicker({
            ranges: {
                'Today': ['today', 'today'],
                'Yesterday': ['yesterday', 'yesterday'],
                'Last 7 Days': [Date.today().add({
                    days: -6
                }), 'today'],
                'Last 30 Days': [Date.today().add({
                    days: -29
                }), 'today'],
                'This Month': [Date.today().moveToFirstDayOfMonth(), Date.today().moveToLastDayOfMonth()],
                'Last Month': [Date.today().moveToFirstDayOfMonth().add({
                    months: -1
                }), Date.today().moveToFirstDayOfMonth().add({
                    days: -1
                })]
            },
            opens: 'right',
            format: 'MM/dd/yyyy',
            separator: ' to ',
            startDate: Date.today().add({
                days: -29
            }),
            endDate: Date.today(),
            minDate: '01/01/2012',
            maxDate: '12/31/2014',
            locale: {
                applyLabel: 'Submit',
                fromLabel: 'From',
                toLabel: 'To',
                customRangeLabel: 'Custom Range',
                daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                firstDay: 1
            },
            showWeekNumbers: true,
            buttonClasses: ['btn-danger']
        },

        function (start, end) {
            $('#form-date-range span').html(start.toString('MMMM d, yyyy') + ' - ' + end.toString('MMMM d, yyyy'));
        });

        $('#form-date-range span').html(Date.today().add({
            days: -29
        }).toString('MMMM d, yyyy') + ' - ' + Date.today().toString('MMMM d, yyyy'));


        if (!jQuery().datepicker || !jQuery().timepicker) {
            return;
        }

        //$('.date-picker').datepicker();
		//Date datePickerDate = new Date(year - 1900, month, day); // get the value here;
		//Date currentDate = new Date();
		
		$('.date-picker').datepicker().on('changeDate', function(){
			
			
         $(this).blur();
		// var d=$(this).val();
		 
		 //var dd = new Date(d);
		 //alert(d);
		// date1 = new Date().setHours('','','','');
		//alert(date1);
		
        }); 
		

        $('.timepicker-default').timepicker();

        $('.timepicker-24').timepicker({
            minuteStep: 1,
            showSeconds: true,
            showMeridian: false
        });
    }
	 handleUniform(); // handles uniform elements
	 handleDateTimePickers(); //handles form timepickers
}();	
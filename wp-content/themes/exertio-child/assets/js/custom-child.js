(function($) {
    "use strict";
    var ajax_url = $("input#freelance_ajax_url").val();
    var ajax_url = ajax_url;

    var localize_vars;
	if(typeof localize_vars_frontend != 'undefined')
	{
		localize_vars = localize_vars_frontend;
	}
	else
	{
		localize_vars = '';
	}



     $(document).ready(function () {
        if ($('.for_specific_page').is('.timepicker')) {
            $('.timepicker').timeselect({'step': 15, autocompleteSettings: {autoFocus: true}});
        }
		 
		 $('.close').click(function() {
    $(this).closest('.modal').hide();
  });
		 
    });


  $(document).on('change', '.frontend_hours input[type="radio"]', function () {
        var valzz = $(this).val();
         console.log(valzz);
        $('input[name=hours_type]').val(valzz);
        if (valzz == 2) {
            $("#timezone").show();
            $(".time_slot").show();
            $("#business-hours-fields").show();
            $("input#timezones").prop('required', true);
        } else {
            $("#timezone").hide();
            $(".time_slot").hide();
            $("#business-hours-fields").hide();
            $("input#timezones").prop('required', false);
        }
    });


    // console.log("testingggg");
    if ($('.frontend_hours input[type="radio"]').is(':checked')) {
        var selected_valz = $('#hours_type').val();

        //console.log(selected_valz);
        if (selected_valz == 2) {
            $("#timezone").show();
            $(".time_slot").show();
            $("#business-hours-fields").show();
            $("input#timezones").prop('required', true);
     }else{
            $("#timezone").hide();
            $(".time_slot").hide();
            $("#business-hours-fields").hide();
            $("input#timezones").prop('required', false);
        }
    }



//adding ajax for days schedule
$('#fl_bussiness_hours_submit').on('click', function(e) {
    // if (e.isDefaultPrevented()) {
    //     return false;
    // } else {
        $('#fl_bussiness_hours_submit i').show();

        var this_value = $(this);
        this_value.find('span.bubbles').addClass('view');
       
        var meeting_url = $('#meeting_url').val();
        $.post(ajax_url, {
            action: 'days_and_breaks_selection',
            meeting_url :meeting_url,
            collect_data: $("form#fl_bussiness_hours").serialize(),

         }) .done(function (response)
            {

                this_value.find('span.bubbles').removeClass('view');
            if (response.success == true) {
                toastr.success(response.data.message, '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
            } else {
                toastr.error(response.data.message, '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
            }   

        });
   // }
});


if ($('#calender-booking').length > 0) {
        var bookedDays = $('#booked_days').val();
        var bookedDaysArr = bookedDays.split(',');
        var enabledDays = bookedDaysArr;
        $('#calender-booking').datepicker({
            timepicker: false,
            language: 'en',
            dateFormat: 'yyyy-mm-dd',
            minDate: new Date(),
            language: {
                days: [localize_vars.Sunday, localize_vars.Monday, localize_vars.Tuesday, localize_vars.Wednesday, localize_vars.Thursday, localize_vars.Friday, localize_vars.Saturday],
                daysShort: [localize_vars.Sun, localize_vars.Mon, localize_vars.Tue, localize_vars.Wed, localize_vars.Thu, localize_vars.Fri, localize_vars.Sat],
                daysMin: [localize_vars.Su, localize_vars.Mo, localize_vars.Tu, localize_vars.We, localize_vars.Th, localize_vars.Fr, localize_vars.Sa],
                months: [localize_vars.January, localize_vars.February, localize_vars.March, localize_vars.April, localize_vars.May, localize_vars.June, localize_vars.July, localize_vars.August, localize_vars.September, localize_vars.October, localize_vars.November, localize_vars.December],
                monthsShort: [localize_vars.Jan, localize_vars.Feb, localize_vars.Mar, localize_vars.Apr, localize_vars.May, localize_vars.Jun, localize_vars.Jul, localize_vars.Aug, localize_vars.Sep, localize_vars.Oct, localize_vars.Nov, localize_vars.Dec],
                today: localize_vars.Today,
                clear: localize_vars.Clear,
                dateFormat: 'mm/dd/yyyy',
            },
            
            onRenderCell: function onRenderCell(date, cellType) {
                if (cellType == 'day') {
                    var day = (date.getFullYear() + '-' + (('0' + (date.getMonth() + 1)).slice(-2)) + '-' + (('0' + date.getDate()).slice(-2)));
                    var isDisabled = enabledDays.indexOf(day) != -1;
                    return {
                        disabled: isDisabled
                    }
                }
            },
            onSelect: function (date, obj) {

                var ad_id = $('#calender-booking').data('ad-id');
                $('.panel-dropdown-scrollable').html('');

                $('.booking-spin-loader').show();
                $.post(ajax_url, {
                    action: 'sb_get_calender_time',
                    date: date,
                    ad_id: ad_id,
                }).done(function (response) {
                    $('.booking-spin-loader').hide();
                    if (response.success == true) {
                        $('.panel-dropdown-scrollable').html(response.data.timing_html);
                        var date_obj = response.data.date_data;

                        $('.selectd_booking_day').html(date_obj.day_name);
                        $('.selectd_booking_date').html(date_obj.date);
                        $('.selectd_booking_month').html(date_obj.month_name);
                        $('.selectd_booking_year').html(date_obj.year);

                        $('.form_booking_day').val(date_obj.day_name);
                        $('.form_booking_date').val(date_obj.date);
                        $('.form_booking_month').val(date_obj.month);
                        $('.form_booking_month_name').val(date_obj.month_name);
                        $('.form_booking_year').val(date_obj.year);

                        console.log(response);
                    }

                });
            }
        });
    }


    if ($('.create-booking-form').length > 0) {
        $('.creat-booking-submit i').hide();
        $('.create-booking-form').on('submit', function (e) {
            e.preventDefault();
            $('.creat-booking-submit i').show();
            $('.creat-booking-submit').prop("disabled", true);
            $.post(ajax_url, {action: 'sb_pro_create_booking', data: $('.create-booking-form').serialize()})
                    .done(function (response)
                    {
                        if (response.success == true) {
                            $('.booking-form-container').hide();
                            $('.booking-confirmed').show();
                            $('.calender-container').hide();
                            $('.current-selected-date').hide();


                            toastr.success(response.data.message, '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                        } else {
                            toastr.error(response.data.message, '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                        }

                        $('.creat-booking-submit i').hide();
                        $('.creat-booking-submit').prop("disabled", false);

                    });
        });
    }

        $(document).on('click', '.show_book_form', function () {

        $('.calender-container').toggle('slow');
        $('.booking-form-container').toggle('slow');

        if (jQuery(this).closest('li').hasClass("lp-booking-disable")) {
            return false;
        } else {
            var $this = jQuery(this),
                    timeslot = $this.closest('li').attr('data-booking-slot'),
                    stratSlot = $this.find('.start_time').text();
           var endSlot = $this.find('.end_time').text();
          var  bookingDay = $('.selectd_booking_day').text();
          var  bookingDate = $('.selectd_booking_date').text();
          var  bookingMonth = $('.selectd_booking_month').text();

            /*form list values*/
            $('.slot_start').html(stratSlot);
            $('.slot_end').html(endSlot);

         var   timeSlot = stratSlot + "   " +endSlot;
            $('#selectd_booking_time').html(timeSlot);

            $('.booking_day').html(bookingDay);
            $('.booking_date').html(bookingDate);
            $('.booking_month').html(bookingMonth);
            /*hidden input values*/
            $('.form_slot_start').val(stratSlot);
            $('.form_slot_end').val(endSlot);
            $('.creat-booking-submit').prop("disabled", false);
        }
    });


    $('.booking-confirmation-close i').on('click', function () {
        $('.booking-form-container').hide();
        $('.booking-confirmed').hide();
        $('.calender-container').show();
        $('#selectd_booking_time').html('');
        $('.current-selected-date').show();
    });

    $('.booking-confirmation-close-form i').on('click', function () {
        $('.booking-form-container').hide();
        $('.booking-confirmed').hide();
        $('.calender-container').show();
        $('#selectd_booking_time').html('');
        $('.current-selected-date').show();
    });




        $('#order_booking').on('change', function () {
        $(this).closest('form').submit();
    });


    $('.booking_status').on('change', function () {
        var val = $(this).val();
        var bookingID = $(this).data('id');
        var status = '';
        if(val == 2){
        var status = '<input type="text" class="link-field form-control" placeholder="Enter the place of meeting link">';
         }
        var  confirm_btn  = 'Confirm';
        var  cancel_btn  = 'Cancel';
        $.confirm({
            title: $('#prompt_heading').val(),
            content: '' +
                    '<form action="" class="formName">' +
                    '<div class="form-group">' + 
                    status +
                    '<textarea  placeholder="' + $('#prompt_heading').val() + '" class="name form-control" rows="8"></textarea>' +
                    '</div>' +
                    '</form>',
            buttons: {
                formSubmit: {
                    text: confirm_btn,

                    btnClass: 'btn-blue',
                    action: function () {
                        var name = this.$content.find('.name').val();
                        var linkfield = this.$content.find('.link-field').val();
                        if (!name) {
                            $.alert($('#no-detail-notify').val());
                            return false;
                        } else {
                            $('#sb_loading').show();
                            $.post(ajax_url, {action: 'sb_booking_status', val: val, booking_id: bookingID, extra_detail: name ,link : linkfield}).done(function (response)
                            {
                                $('#sb_loading').hide();
                                if (response.success == true)
                                {
                                    toastr.success(response.data.message, '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                                } else
                                {
                                    toastr.error(response.data.message, '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                                }
                            });
                        }
                    }
                },
                cancel: {
                    text: cancel_btn,
                    function() {
                    },
                }
            },
        });
    });


     
      $(document).on('click', '.cancel_apoint', function () {
        var val = $(this).val();
        var bookingID = $(this).data('id');
        var cancel_status = '4';
        var  confirm_btn  = 'Confirm';
        var  cancel_btn  = 'Cancel';
        $.confirm({
            title: $('#prompt_heading').val(),
            content: '' +
                    '<form action="" class="formName">' +
                    '<div class="form-group">' +
                    '<textarea  placeholder="' + $('#prompt_heading').val() + '" class="name form-control" rows="8"></textarea>' +
                    '</div>' +
                    '</form>',
            buttons: {
                formSubmit: {
                    text: confirm_btn,

                    btnClass: 'btn-blue',
                    action: function () {
                        var name = this.$content.find('.name').val();
                        if (!name) {
                            $.alert($('#no-detail-notify').val());
                            return false;
                        } else {
                            $('#sb_loading').show();
                            $.post(ajax_url, {action: 'sb_cancel_status',cancel_status :cancel_status, booking_id: bookingID, extra_detail: name}).done(function (response)
                            {
                                $('#sb_loading').hide();
                                if (response.success == true)
                                {
                                    toastr.success(response.data.message, '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                                } else
                                {
                                    toastr.error(response.data.message, '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                                }
                            });
                        }
                    }
                },
                cancel: {
                    text: cancel_btn,
                    function() {
                    },
                }
            },
        });
    });


        $(document).on('submit', '#update-booking-listing', function (e) {

        e.preventDefault();

        $.post(ajax_url, {action: 'sb_allow_booking', sb_data: $("#update-booking-listing").serialize(), }).done(function (response)
        {
            if (response.success == true) {
                $('#sb_loading').hide();
                toastr.success(response.data.message, '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
            } else {
                $('#sb_loading').hide();
                toastr.error(response.data.message, '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
            }
        }).fail(function () {
            $('#sb_loading').hide();
            toastr.error($('#_nonce_error').val(), '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
        });
    });


 $(document).on('click', '.view_booking_details', function ()
    {
        var bookingID = $(this).data('id');
        $('#sb_loading').show();
        $.post(ajax_url, {action: 'sb_get_booking_details', booking_id: bookingID, }).done(function (response)
        {
            if (response.success)
            {
                $('#booking-detail-content').html(response.data.detail)
                $('#booking-detail-modal').modal('show');
                $('#sb_loading').hide();
            } else
            {
                $('#sb_loading').hide();
            }
        });
    });


    if ($('#already_booked_day').length > 0) {
        var cal = $('#already_booked_day').datepicker({
            timepicker: false,
            language: 'en',
            dateFormat: 'yyyy-mm-dd',
            multipleDates: true,

            //minDate: new Date(),
              language: {
                days: [localize_vars.Sunday, localize_vars.Monday, localize_vars.Tuesday, localize_vars.Wednesday, localize_vars.Thursday, localize_vars.Friday, localize_vars.Saturday],
                daysShort: [localize_vars.Sun, localize_vars.Mon, localize_vars.Tue, localize_vars.Wed, localize_vars.Thu, localize_vars.Fri, localize_vars.Sat],
                daysMin: [localize_vars.Su, localize_vars.Mo, localize_vars.Tu, localize_vars.We, localize_vars.Th, localize_vars.Fr, localize_vars.Sa],
                months: [localize_vars.January, localize_vars.February, localize_vars.March, localize_vars.April, localize_vars.May, localize_vars.June, localize_vars.July, localize_vars.August, localize_vars.September, localize_vars.October, localize_vars.November, localize_vars.December],
                monthsShort: [localize_vars.Jan, localize_vars.Feb, localize_vars.Mar, localize_vars.Apr, localize_vars.May, localize_vars.Jun, localize_vars.Jul, localize_vars.Aug, localize_vars.Sep, localize_vars.Oct, localize_vars.Nov, localize_vars.Dec],
                today: localize_vars.Today,
                clear: localize_vars.Clear,
                dateFormat: 'mm/dd/yyyy',
            },
        });
    }




        /*Directory   listing start code  hours*/
    // if ($('#timezones').length >0) {
    //     var tzones = document.getElementById('theme_path').value + "/assests/js/zones.json";
    //     $.get(tzones, function (data) {

    //         typeof $.typeahead === 'function' && $.typeahead({
    //             input: ".myzones-t",
    //             minLength: 0,
    //             //   emptyTemplate: get_strings.no_r_for + "{{query}}",
    //             searchOnFocus: true,
    //             blurOnTab: true,
    //             order: "asc",
    //             hint: true,
    //             source: data,
    //             debug: false,
    //         });
    //     }, 'json');
    // }



if($("#calendar-custom") .length > 0){


var event_data = custom_data_obj.availbilty_data;
var availbilty_str = custom_data_obj.availbilty_str;
var events_arr = [];

$.each(event_data, function(date, times) {
  var date = date ;
  var start_time = times.start_time;
  var endTime = times.end_time; 
  var event_obj = {
    date: new Date(date),
    eventName: "Available",
    className: "my-class",
    onclick(e, data) {
    },
    dateColor: "red"
  };

  events_arr.push(event_obj);
});

$("#calendar-custom").calendarGC({
    events: events_arr,  
  onclickDate: function (e, data) {
    //console.log(e);
    var date = data.datejs;
    var day = date.getFullYear() + '-' + ('0' + (date.getMonth() + 1)).slice(-2) + '-' + ('0' + date.getDate()).slice(-2);
    $("#date_calendar").val(day);       
    var modal = $("#myModal");
    var calendarCustom = $("#calendar-custom");
    var span = $(".close").eq(0);
    calendarCustom.on("click", function() {
      modal.css("display", "block");
    });
    span.on("click", function() {
      modal.css("display", "none");
    });
    $(window).on("click", function(event) {
      if (event.target == modal[0]) {
        modal.css("display", "none");
      }
    });
  } 
});

}

  $('#fl_select_hours_submit').on('click', function(e) {
        $('#fl_select_hours_submit').show();
            const value = $("#date_calendar").val();
            $.post(ajax_url, {action: 'select_hour_selection', date:value, collect_data: $("form#fl_select_hours").serialize(), })
          .done(function (response)
            {
            if (response.success == true) {
                toastr.success(response.data.message, '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                if(response.data.url)
                    {
                  location.replace(response.data.url);
                    }
            } else {
                toastr.error(response.data.message, '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
            }   

        });
   // }
});


if($("#calendar-custom-frant") .length > 0){
var event_data = custom_data_obj.availbilty_data;
var availbilty_str = custom_data_obj.availbilty_str;
console.log(availbilty_str);
var events_arr = [];

$.each(event_data, function(date, times) {
  var date = date ;
  var start_time = times.start_time;
  var endTime = times.end_time; 
  var event_obj = {
    date: new Date(date),
    eventName: "Avail",
    className: "my-class",
    onclick(e, data) {
         
        $('.booking-spin-loader').show();
          $.post(ajax_url, {
            action: 'exertio_sb_get_hour_details', 
            date:date,
            freelancer_id : $('#service_author_id').val(),
            start_time  :  times.start_time,
            end_time  :   times.end_time
        
        })
          .done(function (response)
            {
                $('.booking-spin-loader').hide();
                 if(response.success ==  true){
                $('.booking-spin-loader').hide();
                $('.panel-dropdown-scrollable').html(response.data.timing_html); 
                var date_obj = response.data.date_data;
                 console.log(date_obj);
                $('.selectd_booking_day').html(date_obj.day_name);
                $('.selectd_booking_date').html(date_obj.date);
                $('.selectd_booking_month').html(date_obj.month_name);
                $('.selectd_booking_year').html(date_obj.year);
                $('#selected_booking_date').val(date);
                $('.all-booking-timing .dropdown-toggle').click();
                $('html, body').animate({
                    scrollTop: $('.all-booking-timing .dropdown-toggle').offset().top
                  }, 1000);

                  toastr.success(response.data.message , '', { timeOut: 1000, "closeButton": true, "positionClass": "toast-top-right" });
                }

                else {

                    toastr.error(response.data.message  , '', { timeOut: 1000, "closeButton": true, "positionClass": "toast-top-right" });
                }
       
                });
    },
    dateColor: "red"
  };

  events_arr.push(event_obj);
});


var calendar = $("#calendar-custom-frant").calendarGC({
  events: events_arr,
  onclickDate: function(e, data){

  }
});

}





$(document).ready(function(){
    if($("#timezones") .length > 0){
        var selectedOption = $('#my_selected_timezone').val();
        $("#timezones").select2().val(selectedOption).trigger("change");
    }
  });



})(jQuery);
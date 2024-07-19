(function ($) {
    var ajax_url = $('input#freelance_ajax_url').val();
     var localize_vars;
    if(typeof localize_vars_frontend != 'undefined')
    {
        localize_vars = localize_vars_frontend;
    }
    else
    {
        localize_vars = '';
    }
    var inputShortText = $('#select2-tooshort').val();
    var noResultsText = $('#select2-noresutls').val();
    var searchingText = $('#select2-searching').val();
    var confirm_btn = $('#confirm_btn').val();
    var cancel_btn = $('#cancel_btn').val();
    var confirm_text = $('#confirm_text').val();
    var freelance_ajax_url = ajax_url;
   // var sb_options = localize_vars;
    //var ajax_url = localize_vars.ajax_url;
    //var freelance_ajax_url = ajax_url;
    //var autoplay = parseInt(localize_vars.auto_slide_time);
    var is_rtl_check = localize_vars.is_rtl;
 //var ajax_url = $("input#freelance_ajax_url").val();

   
 
    /*Destroy select */
    if ($('.custom-select').length > 0) {
        $('.custom-select').select2('destroy');
    }
    if ($('#event_start').length > 0) {
        $('#event_start').datepicker({
            timepicker: true,
            dateFormat: 'yyyy-mm-dd',
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
            minDate: new Date()
        });
    }
    if ($('#event_end').length > 0) {
        $('#event_end').datepicker({
            timepicker: true,
            dateFormat: 'yyyy-mm-dd',
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
            minDate: new Date()
        });
    }


    if ($('#already_booked_day').length > 0) {
        var cal = $('#already_booked_day').datepicker({
            timepicker: false,
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
            },
        });
    }





 






    $(document).ready(function () {
       // if ($('.for_specific_page').is('.timepicker')) {
            $('.timepicker').timeselect({'step': 15, autocompleteSettings: {autoFocus: true}});
       // }
    });



    // if ($('#calender-booking').length > 0) {
    //     var bookedDays = $('#booked_days').val();
    //     var bookedDaysArr = bookedDays.split(',');
    //     enabledDays = bookedDaysArr;
    //     $('#calender-booking').datepicker({
    //         timepicker: false,
    //         dateFormat: 'yyyy-mm-dd',
    //         minDate: new Date(),
    //         language: {
    //             days: [localize_vars.Sunday, localize_vars.Monday, localize_vars.Tuesday, localize_vars.Wednesday, localize_vars.Thursday, localize_vars.Friday, localize_vars.Saturday],
    //             daysShort: [localize_vars.Sun, localize_vars.Mon, localize_vars.Tue, localize_vars.Wed, localize_vars.Thu, localize_vars.Fri, localize_vars.Sat],
    //             daysMin: [localize_vars.Su, localize_vars.Mo, localize_vars.Tu, localize_vars.We, localize_vars.Th, localize_vars.Fr, localize_vars.Sa],
    //             months: [localize_vars.January, localize_vars.February, localize_vars.March, localize_vars.April, localize_vars.May, localize_vars.June, localize_vars.July, localize_vars.August, localize_vars.September, localize_vars.October, localize_vars.November, localize_vars.December],
    //             monthsShort: [localize_vars.Jan, localize_vars.Feb, localize_vars.Mar, localize_vars.Apr, localize_vars.May, localize_vars.Jun, localize_vars.Jul, localize_vars.Aug, localize_vars.Sep, localize_vars.Oct, localize_vars.Nov, localize_vars.Dec],
    //             today: localize_vars.Today,
    //             clear: localize_vars.Clear,
    //             dateFormat: 'mm/dd/yyyy',
    //         },
    //         selectedDates: ['2022-03-06'],
    //         onRenderCell: function onRenderCell(date, cellType) {
    //             if (cellType == 'day') {
    //                 var day = (date.getFullYear() + '-' + (('0' + (date.getMonth() + 1)).slice(-2)) + '-' + (('0' + date.getDate()).slice(-2)));
    //                 var isDisabled = enabledDays.indexOf(day) != -1;
    //                 return {
    //                     disabled: isDisabled
    //                 }
    //             }
    //         },
    //         onSelect: function (date, obj) {

    //             var ad_id = $('#calender-booking').data('ad-id');
    //             $('.panel-dropdown-scrollable').html('');

    //             $('.booking-spin-loader').show();
    //             $.post(ajax_url, {
    //                 action: 'sb_get_calender_time',
    //                 date: date,
    //                 ad_id: ad_id,
    //             }).done(function (response) {
    //                 $('.booking-spin-loader').hide();
    //                 if (response.success == true) {
    //                     $('.panel-dropdown-scrollable').html(response.data.timing_html);
    //                     var date_obj = response.data.date_data;

    //                     $('.selectd_booking_day').html(date_obj.day_name);
    //                     $('.selectd_booking_date').html(date_obj.date);
    //                     $('.selectd_booking_month').html(date_obj.month_name);
    //                     $('.selectd_booking_year').html(date_obj.year);

    //                     $('.form_booking_day').val(date_obj.day_name);
    //                     $('.form_booking_date').val(date_obj.date);
    //                     $('.form_booking_month').val(date_obj.month);
    //                     $('.form_booking_month_name').val(date_obj.month_name);
    //                     $('.form_booking_year').val(date_obj.year);

    //                     console.log(response);
    //                 }

    //             });
    //         }
    //     });
    // }
    /*Directory listing end code*/

    /*   directory listing code   */

    // if ($('#my-events').length > 0)
    // {
    //     $('#my-events').parsley().on('field:validated', function () {
    //         var ok = $('.parsley-error').length === 0;
    //     })
    //             .on('form:submit', function () {
    //                 $('#sb_loading').show();
    //                 $.post(freelance_ajax_url, {action: 'my_new_event', sb_data: $("#my-events").serialize(), }).done(function (response)
    //                 {
    //                     if (response.success == true) {
    //                         $('#sb_loading').hide();

    //                         $.confirm({
    //                             title: confirm_text,
    //                             content: $('#visit_text').val(),
    //                             theme: 'Material',
    //                             closeIcon: true,
    //                             animation: 'scale',
    //                             type: 'blue',
    //                             buttons: {
    //                                 confirm: {
    //                                     text: confirm_btn,
    //                                     action: function () {
    //                                         window.location = response.data.url;
    //                                     }, },
    //                                 cancel: {
    //                                     text: cancel_btn,
    //                                     function() {
    //                                        window.location.reload;
    //                                     },
    //                                 }
    //                             }
    //                         });
    //                         toastr.success(response.data.message, '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
    //                     } else {
    //                           $('#sb_loading').hide();
    //                         toastr.error(response.data.message, '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
    //                     }
    //                 }).fail(function () {
    //                     $('#sb_loading').hide();
    //                     toastr.error($('#_nonce_error').val(), '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
    //                 });
    //                 return false;
    //             });
    // }

//     var inputShortText = $('#select2-tooshort').val();
//     var noResultsText = $('#select2-noresutls').val();
//     var searchingText = $('#select2-searching').val();
//     jQuery('.sb-select2-ajax').select({
//         ajax: {
//             url: freelance_ajax_url,
//             dataType: 'json',
//             type: 'GET',
//             data: function (params) {
//                 return {
//                     q: params.term, // search query
//                     action: 'select2_ajax_ads' // AJAX action for admin-ajax.php
//                 };
//             },
//             processResults: function (data) {
//                 var options = [];
//                 var disabled_opts = false;
//                 if (data) {

//                     // data is the array of arrays, and each of them contains ID and the Label of the option
//                     jQuery.each(data, function (index, text) { // do not forget that "index" is just auto incremented value
//                         var disabled_opts = false;
//                         if (text[2] == 'yes')
//                         {
//                             disabled_opts = true;
//                         }
//                         options.push({id: text[0], text: text[1], disabled: disabled_opts});
//                     });
//                 }
//                 return {
//                     results: options
//                 };
//             },
//             cache: true
//         },
//         minimumInputLength: 3,
//         language: {
//             inputTooShort: function () {
//                 return inputShortText;
//             },
//             noResults: function () {
//                 return noResultsText;
//             },
//             searching: function () {
//                 return searchingText;
//             }
//         }
//     });


//     if ($('#my-bookings-listing').length > 0) {
//         $('#my-bookings-listing').parsley().on('field:validated', function () {
//             var ok = $('.parsley-error').length === 0;
//         })
//                 .on('form:submit', function () {
//                     $('#sb_loading').show();
//                     var booked_days = $('#already_booked_day').datepicker().val();
//                     $('#booked_days').val(booked_days);

//                     $.post(freelance_ajax_url, {action: 'sb_allow_booking', sb_data: $("#my-bookings-listing").serialize(), }).done(function (response)
//                     {
//                         if (response.success == true) {
//                             $('#sb_loading').hide();
//                             toastr.success(response.data.message, '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});

//                             //  window.location.reload();
//                         } else {
//                             $('#sb_loading').hide();
//                             toastr.error(response.data.message, '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
//                         }
//                     }).fail(function () {
//                         $('#sb_loading').hide();
//                         toastr.error($('#_nonce_error').val(), '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
//                     });
//                     return false;
//                 });
//     }


//     $(document).on('submit', '#update-booking-listing', function (e) {

//         e.preventDefault();

//         $.post(freelance_ajax_url, {action: 'sb_allow_booking', sb_data: $("#update-booking-listing").serialize(), }).done(function (response)
//         {
//             if (response.success == true) {
//                 $('#sb_loading').hide();
//                 toastr.success(response.data.message, '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
//             } else {
//                 $('#sb_loading').hide();
//                 toastr.error(response.data.message, '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
//             }
//         }).fail(function () {
//             $('#sb_loading').hide();
//             toastr.error($('#_nonce_error').val(), '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
//         });
//     });
//     $('.booking_status').on('change', function () {
//         var val = $(this).val();
//         var bookingID = $(this).data('id');
//         $.confirm({
//             title: $('#prompt_heading').val(),
//             content: '' +
//                     '<form action="" class="formName">' +
//                     '<div class="form-group">' +
//                     '<textarea  placeholder="' + $('#prompt_heading').val() + '" class="name form-control" rows="8"></textarea>' +
//                     '</div>' +
//                     '</form>',
//             buttons: {
//                 formSubmit: {
//                     text: confirm_btn,
//                     btnClass: 'btn-blue',
//                     action: function () {
//                         var name = this.$content.find('.name').val();
//                         if (!name) {
//                             $.alert($('#no-detail-notify').val());
//                             return false;
//                         } else {
//                             $('#sb_loading').show();
//                             $.post(freelance_ajax_url, {action: 'sb_booking_status', val: val, booking_id: bookingID, extra_detail: name}).done(function (response)
//                             {
//                                 $('#sb_loading').hide();
//                                 if (response.success == true)
//                                 {
//                                     toastr.success(response.data.message, '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
//                                 } else
//                                 {
//                                     toastr.error(response.data.message, '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
//                                 }
//                             });
//                         }
//                     }
//                 },
//                 cancel: {
//                     text: cancel_btn,
//                     function() {
//                     },
//                 }
//             },
//         });
//     });
    
    
    
    
//     $(document).on('click', '.view_booking_details', function ()
//     {
//         var bookingID = $(this).data('id');
//         $('#sb_loading').show();
//         $.post(freelance_ajax_url, {action: 'sb_get_booking_details', booking_id: bookingID, }).done(function (response)
//         {
//             if (response.success)
//             {
//                 $('#booking-detail-content').html(response.data.detail)
//                 $('#booking-detail-modal').modal('show');
//                 $('#sb_loading').hide();
//             } else
//             {
//                 $('#sb_loading').hide();
//             }
//         });
//     });


//     $('#order_booking').on('change', function () {
//         $(this).closest('form').submit();
//     });


//     $('.sb_remove_booking').on('click', function () {
//         adID = $(this).attr('data-aaa-id');
//         elem = $(this);
//         $.confirm({
//             title: confirm_text,
//             content: '',
//             theme: 'Material',
//             closeIcon: true,
//             animation: 'scale',
//             type: 'blue',
//             buttons: {
//                 confirm: {
//                     text: confirm_btn,
//                     action: function () {
//                         $('#sb_loading').show();
//                         $.post(freelance_ajax_url, {action: 'sb_remove_booking', ad_id: adID, }).done(function (response)
//                         {
//                             $('#sb_loading').hide();
//                             if (response.success == true)
//                             {
//                                 toastr.success(response.data.message, '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
//                                 console.log(elem);
//                                 elem.parents('.col-lg-6').remove();
//                             } else
//                             {
//                                 toastr.success(response.data.message, '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
//                             }
//                         });
//                     }, },
//                 cancel: {
//                     text: cancel_btn,
//                     function() {
//                     },
//                 }
//             }
//         });
//     });


//     $('.edit_booking_option').on('click', function () {
//         adID = $(this).attr('data-aaa-id');
//         $('#sb_loading').show();
//         $.post(freelance_ajax_url, {action: 'sb_get_booking_options', ad_id: adID, }).done(function (response)
//         {
//             $('#sb_loading').hide();
//             $('#ad-booking-content').html(response);
//             if ($('#already_booked_day').length > 0) {
//                 var bookedDays = $('#booked_days').val();
//                 var bookedDaysArr = bookedDays.split(', ');
//                 enabledDays = bookedDaysArr;
//                 var cal = $('#already_booked_day').datepicker({
//                     timepicker: false,
//                     dateFormat: 'yyyy-mm-dd',
//                     language: {
//                         days: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
//                         daysShort: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
//                         daysMin: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
//                         months: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
//                         monthsShort: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
//                         today: 'Today',
//                         clear: 'Clear',
//                         dateFormat: 'mm/dd/yyyy',
//                     },
//                     multipleDates: true,
//                     selectedDates: ['2022-06-03', '2022-03-06'],
//                 });
//                 $('#already_booked_day').datepicker().val('2022-06-03', '2022-03-06');
//             }
//             ;
//             $('#ad-booking-modal').modal('show');
//         });
//     });

//     if ($('.event_desc').length > 0) {

//         $('.event_desc').jqte({color: false});
//     }

//     is_rtl = false;

//     if (is_rtl_check == "1") {
//         is_rtl = true;
//         var navTextAngle = ["<i class='fa fa-angle-right'></i>", "<i class='fa fa-angle-left'></i>"];
//     }

// //    if ($('.event-carousel').length > 0) {
// //        $('.event-carousel').owlCarousel({
// //            autoplay: 3500,
// //            autoplayHoverPause: true,
// //            autoplayTimeout: autoplay,
// //            items: 4,
// //            loop: true,
// //            margin: 15,
// //            nav: true,
// //            dots: false,
// //            navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
// //            rt: is_rtl,
// //            responsive: {
// //                0: {
// //                    items: 1
// //                },
// //                600: {
// //                    items: 1
// //                },
// //                1000: {
// //                    items: 1
// //                }
// //            }
// //        });
// //
// //    }

//     /* Ad Location */
//     if ($('#event_latt').length > 0)
//     {
//         var lat = $('#event_latt').val();
//         var lon = $('#event_long').val();
//         var map_type = sb_options.adforest_map_type;
//         if (map_type == 'leafletjs_map')
//         {
//             /*For leafletjs map*/
//             var map = L.map('event_detail_map').setView([lat, lon], 7);
//             L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {attribution: ''}).addTo(map);
//             L.marker([lat, lon]).addTo(map);
//         } else if (map_type == 'google_map')
//         {
//             /*For Google Map*/
//             var map = "";
//             var latlng = new google.maps.LatLng(lat, lon);
//             var myOptions = {zoom: 13, center: latlng, scrollwheel: false, mapTypeId: google.maps.MapTypeId.ROADMAP, size: new google.maps.Size(480, 240)}
//             map = new google.maps.Map(document.getElementById("event_detail_map"), myOptions);
//             var marker = new google.maps.Marker({
//                 map: map,
//                 position: latlng
//             });
//         }
//     }



//     /* event  rating Logic */
//     if ($('#event_rating_form').length > 0)
//     {
//         $('#event_rating_form').parsley().on('field:validated', function () {
//         }).on('form:submit', function () {
//             $('#sb_loading').show();
//             $.post(ajax_url, {action: 'sb_event_rating', security: $('#sb-review-token').val(), sb_data: $("form#event_rating_form").serialize(), }).done(function (response)
//             {
//                 $('#sb_loading').hide();
//                 var get_r = response.split('|');
//                 if ($.trim(get_r[0]) == '1')
//                 {
//                     toastr.success(get_r[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
//                     location.reload();
//                 } else
//                 {
//                     toastr.error(get_r[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
//                 }
//             }).fail(function () {
//                 $('#sb_loading').hide();
//                 toastr.error($('#_nonce_error').val(), '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
//             });
//             return false;
//         });
//     }
//     $('.reply_event_rating').on('click', function ()
//     {
//         var p_comment_id = $(this).attr('data-comment_id');
//         $('#reply_to_rating').html($(this).attr('data-commenter-name'));
//         $('#parent_comment_id').val(p_comment_id);
//     });
//     /*Send message to ad owner*/
//     if ($('#event_rating_reply_form').length > 0)
//     {
//         $('#event_rating_reply_form').parsley().on('field:validated', function () {
//         }).on('form:submit', function () {
//             $('#sb_loading').show();
//             $.post(ajax_url, {action: 'sb_event_rating_reply', security: $('#sb-review-reply-token').val(), sb_data: $("form#event_rating_reply_form").serialize(), }).done(function (response)
//             {
//                 $('#sb_loading').hide();
//                 var get_r = response.split('|');
//                 if ($.trim(get_r[0]) == '1')
//                 {
//                     toastr.success(get_r[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
//                     location.reload();
//                 } else
//                 {
//                     toastr.error(get_r[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
//                 }
//             }).fail(function () {

//                 $('#sb_loading').hide();
//                 toastr.error($('#_nonce_error').val(), '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
//             });
//             return false;
//         });
//     }

//     $('#ad-to-fav-event').on('click', function ()
//     {
//         var $this = $(this);
//         var id = $(this).attr('data-id');
//         $('#sb_loading').show();
//         $.post(ajax_url, {action: 'sb_fav_event', event_id: id, }).done(function (response)
//         {
//             $('#sb_loading').hide();

//             if (response.success == true)
//             {
//                 $this.toggleClass("ad-favourited");
//                 toastr.success(response.data.message, '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
//             } else
//             {
//                 toastr.error(response.data.message, '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
//             }
//         });
//     });
//     var addClick = 0;
//     $('#add_event_btn').on('click', function () {
//         addClick += 1;
//         var randNum = Math.floor((Math.random() * 1000000000) + 1);
//         var my_Divs = randNum;
//         var room = my_Divs + 1;
//         var end_date_class = my_Divs + 2;
//         var objTo = document.getElementById('event_question_continer');
//         var divtest = document.createElement("div");
//         divtest.setAttribute("class", "form-group remove-que removeclass_question" + room);
//         var rdiv = 'removeclass_edu' + (room);
//         var inst_html = '<div class="row group" ><div class="col-md-12 col-sm-12 col-12"><div class="form-group"><label>Question</label><input type="text"  placeholder="Question" name="event_question[\'question\'][]" class="form-control"></div>\n\
// <div class="form-group"><label>Answer</label><input type="text"  placeholder="Answer" name="event_question[\'answer\'][]" class="form-control"></div><div class= "form-group"><button type="button" class="btn btn-danger btnRemoveQuestion" data-id ="removeclass_question' + randNum + '" >Remove</button></div></div>';

//         divtest.innerHTML = inst_html;
//         objTo.appendChild(divtest);
//     });

//     $(document).on('click', '.btnRemoveQuestion', function () {
//         $(this).closest('.remove-que').remove();
//     });
//     /*event schedules*/
//     if ($('.event_day_schedule').length > 0) {
//         $('.event_day_schedule').jqte({color: false});
//     }
//     var addDay = 0;
//     $('#add_event_schedule').on('click', function () {
//         addDay += 1;
//         var randNum = Math.floor((Math.random() * 1000000000) + 1);
//         var my_Divs = randNum;
//         var room = my_Divs + 1;
//         var end_date_class = my_Divs + 2;
//         var objTo = document.getElementById('event_schedule_continer');
//         var divtest = document.createElement("div");

//         var randClass = "schedule_editor" + room;
//         divtest.setAttribute("class", "form-group remove-schedule removeclass_question" + room);
//         var rdiv = 'removeclass_edu' + (room);
//         var inst_html = '<div class="row group" ><div class="col-md-12 col-sm-12 col-12"><div class="form-group"><label>Day</label><input type="text"  placeholder="Day" name="event_schedules[\'day\'][]" class="form-control"></div>\n\
// <div class="form-group"><label>Answer</label><textarea   placeholder="Schedule" name="event_schedules[\'day_val\'][]" class="form-control event_day_schedule ' + randClass + '"></textarea></div><div class= "form-group"><button type="button" class="btn btn-danger btnRemoveDay" data-id ="removeclass_schedule ' + randNum + '" >Remove</button></div></div>';

//         divtest.innerHTML = inst_html;
//         objTo.appendChild(divtest);

//         $('.' + randClass).jqte({color: false});
//     });




//     $(document).on('click', '.btnRemoveDay', function () {
//         $(this).closest('.remove-schedule').remove();
//     });



//     /* event search page queryy **/

//     /*For Title & Location*/
//     $('#get_title,#get_locz,#get_start_date_filter,#get_end_date_filter').on('click', function () {
//         sb_search_events_content('');
//     });

//     $('#event_cat,#event_custom_loc,.event_orer_by').on('change', function () {
//         sb_search_events_content('');
//     });

//     function add_event_skeletons(append_class, view) {
//         append_class.addClass('content-loading-skeleton-grid');
//     }
//     function remoove_event_skeletons(append_class, view) {
//         append_class.removeClass('content-loading-skeleton-grid');
//     }

//     function sb_search_events_content(page_num) {
//          document.getElementById('event-content').scrollIntoView({
//         });
//         $('.event-content').html('');
//         $('.event-pagination').html('');
//         add_event_skeletons($('.event-search-content'), 'grid');
//         $.post(freelance_ajax_url,
//                 {
//                     action: 'sb_ajax_search_events',
//                     form_data: $('#d_events_filters').serialize(),
//                     page_no: page_num,
//                     pagination: 'yes',
//                     grid_type: $('#layout_type').val(),
//                     sort_by: $('.event_orer_by').val(),
//                 }).done(function (response)
//         {
//             remoove_event_skeletons($('.event-search-content'), 'grid');
//             adforest_timerCounter_function();
//             $('.event-content').html(response.data.data);
//             if (response.data.pagination) {
//                 $('.event-pagination').html(response.data.pagination);
//                 $('.event-pagination li').removeClass('active');

//             }
//             $('#event-count').html(response.data.total);
//         });
//     }

//     $(document).on('click', '.event-pagination a', function (e) {
//         e.preventDefault();
//         document.getElementById('event-content').scrollIntoView({
//         });
//         sb_search_events_content($(this).text());
        
//     });


//     if ($('#distance-slider').length > 0) {
//         /*getting current current lat long */
//         getCurLocation();
//         function getCurLocation() {
//             if (navigator.geolocation) {
//                 navigator.geolocation.getCurrentPosition(setCurrentLatLong, errorMsg);
//             } else {
//                 x.innerHTML = "Geolocation is not supported by this browser.";
//             }
//         }
//         function setCurrentLatLong(position) {
            
//             console.log(position);
            
//             $('#event-lat').val(position.coords.latitude);
//             $('#event-long').val(position.coords.longitude);
//         }
//         function errorMsg(error) {
//             alert('Enable Location to work with distance search');
//         }
//         /*  slider  */
//         $('#distance-slider').noUiSlider({
//             start: 0,
//             connect: 'lower',
//             range: {
//                 'min': 0,
//                 'max': 100
//             }
//         });
//         $('#distance-slider').Link('lower').to($('#min_dis'), null, wNumb({decimals: 0}));
//         $('.submit-distance').on('click', function () {
//             sb_search_events_content();
//         })
//     }
//     // Ad-category-carousel
//     if ($('.ad-category-carousel').length > 0) {
//         $('.ad-category-carousel').owlCarousel({
//             loop: true,
//             margin: 0,
//             dots: false,
//             nav: true,
//             navText: ["<span class='iconify'; data-icon='bi:chevron-left'></span>", "<span class='iconify' data-icon='bi:chevron-right'></span>"],
//             responsive: {
//                 0: {
//                     items: 1
//                 },
//                 576: {
//                     items: 3
//                 },
//                 768: {
//                     items: 4
//                 },
//                 992: {
//                     items: 4
//                 },
//                 1200: {
//                     items: 5
//                 },
//             }
//         });
//     }


//     function regenerate_masnory()
//     {
//         // init Isotope
//         var $item = $('.posts-masonry');
//         $item.isotope('destroy');
//         $item.imagesLoaded(function () {
//             $item.isotope({
//                 itemSelector: '.masonery_item',
//                 percentPosition: true,
//                 originLeft: 'is_rtlz',
//                 layoutMode: 'fitRows',
//                 transitionDuration: '0.7s',
//                 masonry: {
//                     columnWidth: '.masonery_item'
//                 }
//             });
//         });
//     }

//     $('.filter-date-event').on('click', function () {
//         $container = $(this).closest('.event-grids').find('.posts-masonry').html('');
//         $this = $(this);
//         var date_val = $(this).attr('data-id');
//         add_event_skeletons($container, 'grid');
//         $.post(freelance_ajax_url,
//                 {
//                     action: 'sb_ajax_search_events',
//                     form_data: $('#d_events_filters').serialize(),
//                     page_no: 1,
//                     grid_type: 3,
//                     data_date: date_val,
//                     grid_col : $('#grid_col').val(),
//                 }).done(function (response)
//         {
//             remoove_event_skeletons($container, 'grid');
//             adforest_timerCounter_function();
//             $container.html(response.data.data);
//             console.log(response.data.no_result);
//             $('#event-count').html(response.data.total);
//             if (response.data.no_result == true) {
//                 $this.parents('.ads-grid-selector').find('.posts-masonry').height('auto');
//                 $('.ads-grid-selector .btn-theme').hide();
                
//             } else {
//                 regenerate_masnory();
//                  $('.ads-grid-selector .btn-theme').show();
//             }

//         });
//     });

//     if ($('#tags').length !== 'undefined' && $('#tags').length > 0) {
//         $('#tags').tagsInput({
//             'width': '100%',
//             'height': '5px;',
//             'defaultText': '',
//             onAddTag: function (elem, elem_tags) {
//                 total_tags = parseInt(total_tags) + 1;
//                 if (total_tags > sb_options.adforest_tags_limit_val) {
//                     alert(sb_options.adforest_tags_limit);
//                     $(this).removeTag(elem);
//                 }
//                 if ($.sanitize(elem) == '') {
//                     $(this).removeTag(elem);
//                 }
//             },
//             onRemoveTag: function () {
//                 total_tags = parseInt(total_tags) - 1;
//             }
//         });
//     }
//     /* end event search page*/
//     $('#going_to_event').on('click', function () {
//         eventID = $(this).attr('data-id');
//         going = $(this).attr('data-going');
//         notgoing = $(this).attr('data-notgoing');
//         staus = $(this).attr('data-status');
//         $('#sb_loading').show();
//         $.post(freelance_ajax_url,
//                 {
//                     action: 'sb_going_to_event',
//                     event_id: eventID,
//                     staus: staus,
//                 }).done(function (response)
//         {
//             if (response.success == true) {
//                 toastr.success(response.data.message, '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
//                window.location.reload();
//             } else {
//                 toastr.error(response.data.message, '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
//               window.location.reload();
//             }
//             $('#sb_loading').hide();
//         });

//     });

//     if ($('#my-events').length > 0) {
//         $('#event_country_sub_div').hide();
//         $('#event_country_sub_sub_div').hide();
//         $('#event_country_sub_sub_sub_div').hide();
//         if ($('#is_update').val() != "")
//         {
//             var country_level = $('#country_level').val();
//             if (country_level >= 2) {
//                 $('#event_country_sub_div').show();
//             }
//             if (country_level >= 3) {
//                 $('#event_country_sub_sub_div').show();
//             }
//             if (country_level >= 4) {
//                 $('#event_country_sub_sub_sub_div').show();
//             }
//         }
//         $('#event_country').on('change', function ()
//         {
//             $('#sb_loading').show();
//             $.post(freelance_ajax_url, {action: 'event_get_sub_states', country_id: $("#event_country").val(), }).done(function (response)
//             {
//                 $('#sb_loading').hide();
//                 $("#event_country_states").val('');
//                 $("#event_country_cities").val('');
//                 $("#event_country_towns").val('');
//                 if ($.trim(response) != "")
//                 {
//                     $('#event_country_id').val($("#ad_cat").val());
//                     $('#event_country_sub_div').show();
//                     $('#event_country_states').html(response);
//                     $('#event_country_sub_sub_sub_div').hide();
//                     $('#event_country_sub_sub_div').hide();
//                 } else
//                 {
//                     $('#event_country_sub_div').hide();
//                     $('#ad_cat_sub_sub_div').hide();
//                     $('#event_country_sub_sub_div').hide();
//                     $('#event_country_sub_sub_sub_div').hide();
//                 }
//             });
//         });

//         /* Level 2 */
//         $('#event_country_states').on('change', function ()
//         {
//             $('#sb_loading').show();
//             $.post(freelance_ajax_url, {action: 'event_get_sub_states', country_id: $("#event_country_states").val(), }).done(function (response)
//             {
//                 $('#sb_loading').hide();
//                 $("#event_country_cities").val('');
//                 $("#event_country_towns").val('');
//                 if ($.trim(response) != "")
//                 {
//                     $('#event_country_id').val($("#event_country_states").val());
//                     $('#event_country_sub_sub_div').show();
//                     $('#event_country_cities').html(response);
//                     $('#event_country_sub_sub_sub_div').hide();
//                 } else
//                 {
//                     $('#event_country_sub_sub_div').hide();
//                     $('#event_country_sub_sub_sub_div').hide();
//                 }
//             });
//         });
//         /* Level 3 */
//         $('#event_country_cities').on('change', function ()
//         {
//             $('#sb_loading').show();
//             $.post(freelance_ajax_url, {action: 'event_get_sub_states', country_id: $("#event_country_cities").val(), }).done(function (response)
//             {
//                 $('#sb_loading').hide();
//                 $("#event_country_towns").val('');
//                 if ($.trim(response) != "")
//                 {
//                     $('#event_country_id').val($("#event_country_cities").val());
//                     $('#event_country_sub_sub_sub_div').show();
//                     $('#event_country_towns').html(response);
//                 } else
//                 {
//                     $('#event_country_sub_sub_sub_div').hide();
//                 }
//             });
//         });
//     }
    
    
    //    $('#sb_sort_event_images').on('click', function ()
    // {
    //     $('#sb_loading').show();
    //     $.post(freelance_ajax_url, {action: 'sb_sort_event_images', ids: $('#post_img_ids').val(), ad_id: $('#current_pid').val(), }).done(function (response)
    //     {
    //         toastr.success($('#re-arrange-msg').val(), '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
    //         location.reload();
    //         $('#sb_loading').hide();
    //     });
    // });
    
    // $('.adv-srch').on('click', function ()
    // {
    //     $(this).hide();
    //     $('.hide_adv_search').show();
    // });
}(jQuery));
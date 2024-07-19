<?php

use function Sodium\compare;



add_action( 'wp_enqueue_scripts', 'my_plugin_assets' );
function my_plugin_assets() { 
    
//global $localize;
   wp_enqueue_style('jquery-timepicker-style-child', get_stylesheet_directory_uri().'/assets/css/datepicker.min.css');
   wp_enqueue_style('theme-override',  get_stylesheet_directory_uri().'/assets/css/jquery.typeahead.min.css', array(), '0.1.0', 'all');
   wp_enqueue_script( 'typeahead-adv', get_stylesheet_directory_uri().'/assets/js/typeahead.adv.js', array('jquery'), '3.3.5', true );
   wp_enqueue_script( 'typeahead', get_stylesheet_directory_uri().'/assets/js/typeahead.min.js', array('jquery'), '3.3.5', true );
   wp_enqueue_script( 'timeselect', get_stylesheet_directory_uri() . "/assets/js/timeselect.js", array("jquery"), false, false);
   // wp_enqueue_script( 'Jquery-date-en', trailingslashit(get_stylesheet_directory_uri()) . '/assets/js/date-en-US.js', false, false, true);
   wp_enqueue_script( 'jqueryui', get_stylesheet_directory_uri() . "/assets/js/jquery/jquery.ui.min.js", false, false, false);
   wp_enqueue_script( 'jquery-datetimepicker-child',get_stylesheet_directory_uri() . '/assets/js/jquery/datepicker.min.js', array('jquery'), true, true );

       // Register Font Awesome stylesheet
    wp_register_style( 'font-awesome', 'https://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css' );

    // Enqueue Font Awesome stylesheet
    wp_enqueue_style( 'font-awesome' );

    // Register Bootstrap stylesheet
    wp_register_style( 'bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css' );

    // Enqueue Bootstrap stylesheet
    wp_enqueue_style( 'bootstrap' );


   wp_enqueue_script( 'calendar-gc-script', get_stylesheet_directory_uri() . '/assets/js/calendar-gc.js', array("jquery"), false, true );
   wp_enqueue_script( 'custom-child', get_stylesheet_directory_uri().'/assets/js/custom-child.js', array('jquery'), false , true );
   wp_enqueue_style( 'calendar-gc-style', get_stylesheet_directory_uri() . '/assets/css/calendar-gc.css' );
   wp_enqueue_style( 'child-theme-css', get_stylesheet_uri());

   $freelancer_id   = "";
      $post_meta  =  array();
      if ( is_singular( 'services' ) ) {
          $freelancer_id = get_post_field( 'post_author', get_the_ID());
       }
       else if(isset($_GET['ext']) && $_GET['ext'] == 'define-availlibity'){
          $freelancer_id = get_current_user_id();
        }
        if( $freelancer_id != ""){
            $fid = get_user_meta( $freelancer_id, 'freelancer_id', true );
           $post_meta = get_post_meta($fid, 'freelancer_availabilty_hours' , true );
         }

       $data_obj   =   array(
          'availbilty_data'=> $post_meta,
          'availbilty_str'=> esc_html__("Available",'exertio'),
       );
     
    wp_localize_script( 'custom-child', 'custom_data_obj', $data_obj );
}

require_once get_stylesheet_directory() . '/inc/my_included_file.php'; 
 

/* ====================================== */
/* Getting Weekdays and Breaks ajax */
/* ====================================== */

add_action('wp_ajax_days_and_breaks_selection', 'exertio_days_and_breaks_selection');
add_action('wp_ajax_nopriv_exertio_days_and_breaks_selection', 'exertio_days_and_breaks_selection');
if (!function_exists('exertio_days_and_breaks_selection')) {
    
    function exertio_days_and_breaks_selection() {

        $params = array();
        parse_str($_POST['collect_data'], $params);
        $meeting_url  =   isset($_POST['meeting_url']) ?  $_POST['meeting_url'] : " "; 
        $user_id   =   get_current_user_id();
        $fre_id = get_user_meta( $user_id, 'freelancer_id' , true );
        $pid   =  $fre_id;


        if ($meeting_url != '') {
          
            update_post_meta($pid, 'sb_pro_meeting_ling', $meeting_url);
            wp_send_json_success(array('message' => __('Availability Status changed Successfully', 'exertio')));
      
        } else {

            update_post_meta($pid, 'sb_pro_meeting_ling', $meeting_url);
            wp_send_json_error(array('message' => __('Availability Status change failed', 'exertio')));


        }

    }
}





/* ====================================== */
/* Getting select section hours ajax */
/* ====================================== */

add_action('wp_ajax_select_hour_selection', 'exertio_select_hour_selection');
add_action('wp_ajax_nopriv_exertio_select_hour_selection', 'exertio_select_hour_selection');
if (!function_exists('exertio_select_hour_selection')) {
    
    function exertio_select_hour_selection() {
        $params = array();
        parse_str($_POST['collect_data'], $params);
        $user_id   =   get_current_user_id();
        $fre_id = get_user_meta( $user_id, 'freelancer_id' , true );
        $fid   =  $fre_id;
        $cld_date = isset($_POST['date']) ? $_POST['date'] : "";

   

         $start_time = isset($params['start_time']) ? ($params['start_time']) : "";
         $end_time = isset($params['end_time']) ? ($params['end_time']) : "";

        $saved_availbilty   =       get_post_meta($fid, 'freelancer_availabilty_hours' , true);

        //print_r($saved_availbilty);

        $saved_arr  =  array();
        if($saved_availbilty != "" ){
        $saved_arr   = $saved_availbilty;
        }
        $saved_arr[$cld_date]    =    array(
           'start_time' =>  $start_time, 
            'end_time' => $end_time
         );
        update_post_meta($fid ,  'freelancer_availabilty_hours' ,   $saved_arr);
        $url =  esc_url(home_url()) . '/dashboard/?ext=define-availlibity';
        wp_send_json_success(array('url' => $url, 'message' => __('Availability Created Successfully', 'exertio')));
 
    }
}

/* ====================================== */
/* Getting select section hours ajax */
/* ====================================== */

add_action('wp_ajax_exertio_sb_get_hour_details', 'exertio_sb_get_hour_details');
add_action('wp_ajax_nopriv_exertio_sb_get_hour_details', 'exertio_sb_get_hour_details');
if (!function_exists('exertio_sb_get_hour_details')) {
    function exertio_sb_get_hour_details() {
        $fre_id    =  $_POST['freelancer_id'];
        $fid       =  $fre_id;

        $freelancer_id = get_post_field( 'post_author', $fid );
        if(get_current_user_id()   ==  $freelancer_id){
           wp_send_json_error(array('message' => esc_html__('Service Author not allowed', 'exertio'))); 
        }
      if(get_current_user_id()  == ""  ||  get_current_user_id() == 0){

        wp_send_json_error(array('message' => esc_html__('Please login first', 'exertio'))); 
      }  

        $selected_my_date = ($_POST['date']);
        if($selected_my_date == ""){
            wp_send_json_error(array('message' => esc_html__('Please select date first', 'exertio'))); 
        }
        $timestamp = strtotime($selected_my_date);
        $selected_day = date('l', $timestamp);
        $selected_month = date('m', $timestamp);
        $selected_month_name = date('F', $timestamp);
        $selected_date = date('d', $timestamp);
        $selected_year = date('Y', $timestamp);
        $date_data = array('date' => $selected_date, 'month' => $selected_month, 'month_name' => $selected_month_name, 'year' => $selected_year, 'day_name' => $selected_day);
        $saved_availbilty   = get_post_meta($fid, 'freelancer_availabilty_hours' , true);
        $saved_availbilty = $saved_availbilty[$selected_my_date];

            $startTime = $saved_availbilty['start_time'];
            $endTime = $saved_availbilty['end_time'];

            if($startTime == "" ||  $endTime == ""){
                wp_send_json_error(array('message' => esc_html__('No Slot available', 'exertio')));
            }

            $startTime = strtotime($startTime);
            $endTime = strtotime($endTime);

            $interval = get_post_meta($fre_id, 'listing_time_slot', true);
            if( $interval != ""){
                $interval = $interval . " mins";
            }
            else {
                $interval = '30 mins'; 
            }
            $current = time();
            $addTime = strtotime('+' . $interval, $current);
            $diff = $addTime - $current;
            $intervalEnd = $startTime + $diff;
            $count = 1;
            /*get booked slots against this data */
             $freelancer_id = get_post_field( 'post_author', $fid );
             $booked_slots  = get_booked_hours($selected_my_date , $freelancer_id);

            if ($endTime > $startTime) {

                while ($startTime < $endTime) {
                    $appt_start = date(get_option('time_format'), (int) $startTime,);
                   
                    $appt_end = date(get_option('time_format'), (int) $intervalEnd);
                
                     if(is_array($booked_slots) && !empty($booked_slots) && in_array($appt_start,$booked_slots)){
                       
                     }
                     else {
                        $timing_html .= '<div class="show_book_form">   
                        <label class="time-slot">
                         <span>'.$count.'</span> : 
                          <span class="start_time">' . $appt_start . '</span>
                         <span class="end_time">' . $appt_end . '</span>                             
                         </label>
                     </div>';
                     }              
                    $startTime += $diff;
                    $intervalEnd += $diff;
                    $count++;
               ///     / will prevent from infinite loop /
                    if ($count == 97) {
                        return;
                    }
                }
               } else {
                $timing_html = '<div class="show_book_form_close">  
                             <label class="time-slot">
                              <span>' . esc_html__('None', 'exertio') . '</span>                               
                          </label>
                      </div>';
            }
            wp_send_json_success(array('date_data' => $date_data, 'timing_html' => $timing_html, 'status' =>'' , 'message'=>esc_html__('Select time slot'))); 
            
            wp_die();
      }   
  }

/* ====================================== */
/* Getting weekdays & breaks ajx end here */
/* ====================================== */

   add_filter('sb_get_business_hous_post','sb_get_business_hous_post_callback',10,2);
   function sb_get_business_hous_post_callback($ad_id) {
      
        $my_class = "";


        $days = array();
        $listing_timezone = get_post_meta($ad_id, 'sb_pro_user_timezone', true);

        $meeting_url  =  get_post_meta($ad_id, 'sb_pro_meeting_ling', true);
        $meeting_url = isset($meeting_url) ? $meeting_url : "";
        $listing_time_slot  =  get_post_meta($ad_id, 'listing_time_slot', true);
        if (!empty(sb_pro_fetch_business_hours($ad_id))) {
            $days = sb_pro_fetch_business_hours($ad_id);
        } else {
            $dayss = sb_pro_week_days();
            foreach ($dayss as $key => $val) {
                $days[] = array("day_name" => $val, "start_time" => '', "end_time" => '', "closed" => '');
            }
        }
        $days_name = "";
        foreach ($days as $key => $day) {
            $active = ( $key == 0 ) ? "active" : "";
            $days_name .= '<li class="nav-item ">
             <a class="nav-link ' . $active . '"href="#tab1' . esc_attr($key) . '" data-toggle="tab">' . esc_attr($day['day_name']) . '</a>
            </li>';
        }
        $tabs = "";
        foreach ($days as $key => $day) {
        ////get and set the start break and end break////
            $break_from = isset($day['break_from']) && $day['break_from'] != "" ? trim(date("g:i A", strtotime($day['break_from']))) : "";
            $break_to = isset($day['break_too']) && $day['break_too'] != "" ? trim(date("g:i A", strtotime($day['break_too']))) : "";
            $on_off_break = isset($day['break']) ? $day['break'] : "";
            $show = $key == 0 ? 'in active show' : "";
            $closed_checked = ( $day['closed'] == 1 ) ? 'checked = checked' : '';
            $break_checked = ($on_off_break) ? 'checked = checked' : '' .
                    $tabs .= '<div class="tab-pane fade  ' . $show . '" id="tab1' . esc_attr($key) . '">
            <div class="row">
                <div class="col-md-5 col-xs-12 col-sm-6">
                    <div class="form-group">
                        <label class="control-label"> ' . esc_html__('From', 'exertio') . ' </label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="ti-time"></i></span>
                            <input type="text" class="for_specific_page form-control timepicker" name="from[]" id="from-' . esc_attr($key) . '" placeholder="' . esc_html__('Select your business hours', 'exertio') . '" value="' . trim(date("g:i A", strtotime($day['start_time']))) . '">
                        </div>
                        
                    </div>
                </div>
                <div class="col-md-5 col-xs-12 col-sm-6">
                    <div class="form-group">
                        <label class="control-label">' . esc_html__('To', 'exertio') . '</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="ti-time"></i></span>
                            <input type="text" class="for_specific_page form-control timepicker"
                                   id="to-' . esc_attr($key) . '" name="to[]"
                                   placeholder="' . esc_html__('Select your business hours', 'exertio') . '"
                                   value="' . trim(date("g:i A", strtotime($day['end_time']))) . '">
                        </div>

                    </div>
                </div>

                <div class="col-md-2 col-xs-12 col-sm-2">
                    <div class="form-group is_closed">
                        <label class="control-label">' . esc_html__('None', 'exertio') . ' </label>
                        <input name="is_closed[]" id="is_closed-' . esc_attr($key) . '" value="' . esc_attr($key) . '"  type="checkbox" ' . $closed_checked . ' class="custom-checkbox is_closed"></span>
                    </div>
         
                </div>
            </div>
        </div>';
        }
        $selected_val = 0;
        $tzlist = DateTimeZone::listIdentifiers(DateTimeZone::ALL);
foreach($tzlist as $value)
{
  $option  = "<option value=". $value .">". $value ."</option>";
}

       
        if (get_post_meta($ad_id, 'sb_pro_is_hours_allow', true) == 1) {
            if (get_post_meta($ad_id, 'sb_pro_business_hours', true) == '1') {
                $selected_val = 1;
            } else {
                $selected_val = 2;
            }
        }
        return ' <div  class="business_hours_container" > 
        <div class="row">  <div class="col-md-12 col-xs-12 col-sm-12">
        <div class="form-group has-feedback">
                    <label class="control-label"><strong> ' . esc_html__('Meeting Link', 'exertio') . '</strong> </label>

                </div>
                </div>
                </div>
              
    <div class="form-group"><input type="text" class="form-control" id="meeting_url" name="meeting_url" placeholder="Enter meeting url" value="'.$meeting_url.'"></div><p></p><div class="icon"><i class="far fa-info-circle"></i></div><div class="info">Your information.</div>

                <div class="pull-right pull-right-submit">
                <button type="button" class="btn btn-theme btn-loading" id="fl_bussiness_hours_submit">
                  Save
                <span class="bubbles"> <i class="fa fa-circle" aria-hidden="true"></i> <i class="fa fa-circle" aria-hidden="true"></i> <i class="fa fa-circle" aria-hidden="true"></i> </span>
                </button>
               
             </div>

             </div>
            
              
              </div> 
               </div> 
                  
                  ';
    }


    if (!function_exists('sb_pro_fetch_business_hours')) {
    function sb_pro_fetch_business_hours($listing_id) {
        global $sb_pro_options;
        $days_name = sb_pro_week_days();
        $days = '';
        /* check option is yes or not */
        if (get_post_meta($listing_id, 'sb_pro_business_hours', true) != "") {
            $listing_is_opened = get_post_meta($listing_id, 'sb_pro_business_hours', true);
            $days = array();
            $custom_days = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
            for ($a = 0; $a <= 6; $a++) {
                $week_days = lcfirst($custom_days[$a]);

                if (get_post_meta($listing_id, '_timingz_' . $week_days . '_open', true) == 1) {
//days which are opened
                    $is_break_on = get_post_meta($listing_id, '_timingz_break_' . $week_days . '_open', true);
                    $breeak_from1 = get_post_meta($listing_id, '_timingz_break_' . $week_days . '_breakfrom', true);
                    $breeak_tooo1 = get_post_meta($listing_id, '_timingz_break_' . $week_days . '_breakto', true);

                    $time_from = date('H:i:s', strtotime(get_post_meta($listing_id, '_timingz_' . $week_days . '_from', true)));
                    $time_to = date('H:i:s', strtotime(get_post_meta($listing_id, '_timingz_' . $week_days . '_to', true)));
                    $breeak_from = isset($breeak_from1) && $breeak_from1 != "" ? date('H:i:s', strtotime($breeak_from1)) : "";
                    $breeak_tooo = isset($breeak_tooo1) && $breeak_tooo1 != "" ? date('H:i:s', strtotime($breeak_tooo1)) : "";

                    $days[] = array("day_name" => $days_name[$a], "start_time" => $time_from, "end_time" => $time_to, "break_from" => $breeak_from, "break_too" => $breeak_tooo, "closed" => '', "break" => $is_break_on);
                } else {
//days which are closed
                    $time_from = date('g:i A', strtotime(get_post_meta($listing_id, '_timingz_' . $week_days . '_from', true)));
                    $time_to = date('g:i A', strtotime(get_post_meta($listing_id, '_timingz_' . $week_days . '_to', true)));
                    $days[] = array("day_name" => $days_name[$a], "start_time" => $time_from, "end_time" => $time_to, "closed" => 1, "break" => '');
                }
            }
            return $days;
        }
    }

}
if (!function_exists('sb_pro_show_business_hours')) {

    function sb_pro_show_business_hours($listing_id) {
        global $sb_pro_options;
        $days_name = sb_pro_week_days();
        $custom_days = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
        $days = '';
        $listing_is_opened = 0;
//check option is yes or not
        $listing_is_opened = get_post_meta($listing_id, 'sb_pro_business_hours', true);

        if ($listing_is_opened == 0) {
            $days = array();
            for ($a = 0; $a <= 6; $a++) {
                $week_days = lcfirst($custom_days[$a]);
                $user_id = get_post_field('post_author', $listing_id);
//current day
                $current_day = lcfirst(date("l"));
                if ($current_day == $week_days) {
                    $current_day = $current_day;
                } else {
                    $current_day = '';
                }
                if (get_post_meta($listing_id, '_timingz_' . $week_days . '_open', true) == 1) {

//days which are opened
                    if (get_user_meta($user_id, 'sb_pro_user_hours_type', true) != "" && get_user_meta($user_id, 'sb_pro_user_hours_type', true) == "24") {
                        $time_from = date('H:i:s', strtotime(get_post_meta($listing_id, '_timingz_' . $week_days . '_from', true)));
                        $time_to = date('H:i:s', strtotime(get_post_meta($listing_id, '_timingz_' . $week_days . '_to', true)));
                    } else {
                        $time_from = date('g:i a', strtotime(get_post_meta($listing_id, '_timingz_' . $week_days . '_from', true)));
                        $time_to = date('g:i a', strtotime(get_post_meta($listing_id, '_timingz_' . $week_days . '_to', true)));
                    }

                    $break_click_on = "";
                    $breeak_on = get_post_meta($listing_id, '_timingz_break_' . $week_days . '_open', true);
                    $break_click_on = isset($breeak_on) && $breeak_on != "" ? $breeak_on : "";
                    if ($break_click_on == 1) {
                        $breakk_from = date('H:i:s', strtotime(get_post_meta($listing_id, '_timingz_break_' . $week_days . '_breakfrom', true)));
                        $breakk_to = date('H:i:s', strtotime(get_post_meta($listing_id, '_timingz_break_' . $week_days . '_breakto', true)));
                    } else {
                        $breakk_from = "";
                        $breakk_to = "";
                    }
                    $days[] = array("day_name" => $days_name[$a], "start_time" => $time_from, "end_time" => $time_to, "break_from" => $breakk_from, "break_too" => $breakk_to, "closed" => '', "current_day" => $current_day, 'break' => $break_click_on);

                    if (get_user_meta($user_id, 'sb_pro_user_hours_type', true) != "" && get_user_meta($user_id, 'sb_pro_user_hours_type', true) == "24") {
                        
                    }
                } else {
//days which are closed
                    $days[] = array("day_name" => $days_name[$a], "closed" => '1', "current_day" => $current_day);
                }
            }
            return $days;
        }
    }

}



 add_filter('sb_show_business_hours', 'sb_show_business_hours_callback' , 10, 2);
    function sb_show_business_hours_callback($listing_id) {
    //if busines hours allowed
 
        if (get_post_meta($listing_id, 'sb_pro_is_hours_allow', true) == '1') {
//now check if its 24/7 or selective timimgz
            if (get_post_meta($listing_id, 'sb_pro_business_hours', true) == '1') {
                ?>
                <div class = 'widget-opening-hours widget'>
                    <div class = 'opening-hours-title tool-tip' title = "<?php echo esc_html__('Business Hours', 'exertio'); ?>">
                        <img src = "<?php echo esc_url(trailingslashit(get_stylesheet_directory_uri()) . 'assets/images/clock.png'); ?>" alt = "<?php echo esc_html__('not found', 'exertio'); ?>">
                        <span><?php echo esc_html__('Always Open', 'exertio');
                ?></span>
                    </div>
                </div>
                <?php
            } else {
                $get_hours = sb_pro_show_business_hours($listing_id);
                $status_type = sb_pro_business_hours_status($listing_id);
                if ($status_type == 0 || $status_type == "") {
                    $business_hours_status = esc_html__('Closed', 'exertio');
                    $listing_timezone_for_break = get_post_meta($listing_id, 'sb_pro_user_timezone', true);
                    if (sb_pro_checktimezone($listing_timezone_for_break) == true) {
                        if ($listing_timezone_for_break != "") {
                            /* $status = esc_html__('Closed','exertio'); */
                            /* current day */
                            $current_day_today = lcfirst(date("l"));
                            /* current time */
                            $date_for_break = new \DateTime("now", new \DateTimeZone($listing_timezone_for_break));
                            $current_time_now = $date_for_break->format('h:i:s');
// numaric values of open time
                            $current_time_num = strtotime($current_time_now);
// start day time
                            $time_from1111 = date('H:i:s', strtotime(get_post_meta($listing_id, '_timingz_' . $current_day_today . '_from', true)));
// start day numaric value
                            $start_time_numaric = strtotime($time_from1111);
//numaric values of opening soon
                            $startTime11 = date('H:i:s', strtotime("-30 minutes", strtotime($time_from1111)));
                            $startTime11_num = strtotime($startTime11);
                            if ($current_time_num > $startTime11_num && $startTime11_num < $start_time_numaric) {
                                $business_hours_status = esc_html__('Opening Soon', 'exertio');
                            }
                        }
                    }
                } else {
                    /* timezone of selected business hours */
                    $listing_timezone_for_break = get_post_meta($listing_id, 'sb_pro_user_timezone', true);

                    if (sb_pro_checktimezone($listing_timezone_for_break) == true) {
                        if ($listing_timezone_for_break != "") {
                            /* $status = esc_html__('Closed','exertio'); */
                            /* current day */
                            $current_day_for_break = lcfirst(date("l"));

                            /* current time */
                            $date_for_break = new \DateTime("now", new \DateTimeZone($listing_timezone_for_break));
                            $current_time_now = $date_for_break->format('H:i:s');
//current day
                            $current_day = strtolower(date('l'));
//check if current day is open or not
                            $is_break_on = get_post_meta($listing_id, '_timingz_break_' . $current_day . '_open', true);
// get start and end time of break of current time
                            $breeak_from1 = get_post_meta($listing_id, '_timingz_break_' . $current_day . '_breakfrom', true);
                            $breeak_tooo1 = get_post_meta($listing_id, '_timingz_break_' . $current_day . '_breakto', true);
// numaric values of current day start and end break
                            $current_time_num = strtotime($current_time_now);
                            $break_from_num = strtotime($breeak_from1);
                            $break_too_num = strtotime($breeak_tooo1);
//get start and end time of current day
                            $time_to_end = date('H:i:s', strtotime(get_post_meta($listing_id, '_timingz_' . $current_day . '_to', true)));

// numaric values of current day
                            $end_time_numaric = strtotime($time_to_end);

// numaric value of closed soon
                            $endTime11 = date('H:i:s', strtotime("-30 minutes", strtotime($time_to_end)));
                            $endTime11_num = strtotime($endTime11);

                            if ($is_break_on == '1' && $current_time_num > $break_from_num && $current_time_num < $break_too_num) {
                                $business_hours_status = esc_html__('Break', 'exertio');
                            } elseif ($endTime11_num < $end_time_numaric && $current_time_num > $endTime11_num) {
                                $business_hours_status = esc_html__('Closing Soon', 'exertio');
                            } else {
                                $business_hours_status = $break_check_button = esc_html__('Open Now', 'exertio');
                            }
                        }
                    }
                }


                $class = '';
                if (is_rtl()) {
                    $class = 'flip';
                }
                ?>
                <div class = 'widget-opening-hours widget'>
                    <div class = 'opening-hours-title tool-tip' title = "<?php echo esc_html__('Business Hours', 'exertio'); ?>"
                         data-bs-toggle = 'collapse' data-bs-target = '#opening-hours'>
                        <img src = "<?php echo esc_url(trailingslashit(get_stylesheet_directory_uri()) . '/assets/images/clock.png'); ?>" alt = "<?php echo esc_html__('not found', 'exertio'); ?>"><span>
                            <?php echo esc_attr($business_hours_status);
                            ?></span>
                        <i class = "fa fa-angle-right <?php echo esc_attr($class); ?>"></i>
                    </div>
                    <div id = 'opening-hours' class = 'collapse in show'>
                        <?php
                        if (get_post_meta($listing_id, 'sb_pro_user_timezone', true) != '') {

                            echo '<div class="s-timezone"> ' . esc_html__('Business hours', 'exertio'
                                    . '') . ' : <strong>' . get_post_meta($listing_id, 'sb_pro_user_timezone', true) . '</strong></div>';
                        }
                        ?>
                        <ul>
                            <?php
                            if (is_array($get_hours) && count($get_hours) > 0) {


                                foreach ($get_hours as $key => $val) {
                                    $bk_f = isset($val['break_from']) && $val['break_from'] != "" ? trim(date("g:i A", strtotime($val['break_from']))) : "";
                                    $bk_to = isset($val['break_too']) && $val['break_too'] != "" ? trim(date("g:i A", strtotime($val['break_too']))) : "";
                                    $break_status = '';
                                    if ($bk_f != '' && $bk_to != '') {
                                        $break_status = esc_attr($bk_f) . '&nbsp - &nbsp' . esc_attr($bk_to);
                                    } else {
                                        $break_status = "";
                                    }
                                    if ($break_status != "") {
                                        $break_keyword = 'break' . ':';
                                    } else {
                                        $break_keyword = "";
                                    }
                                    $class = '';
                                    if ($val['current_day'] != '') {
                                        $class = 'current_day';
                                    }
                                    if ($val['closed'] == 1) {
                                        $class = 'closed';
                                        echo '' . $htm_return = '<li class="' . esc_html($class) . '"> 
                                 <span class="day-name"> ' . $val['day_name'] . ':</span>
                                 <span class="day-timing"> ' . esc_html__('Closed', 'exertio') . ' </span> </li>';
                                    } else {
                                        echo '' . $htm_return = ' <li class="' . esc_html($class) . '">
                                <span class="day-name"> ' . $val['day_name'] . ':</span>
                                
                                <span class="day-name"> ' . '<br>' . $break_keyword . '</span>
                                
                                <span class="day-timing"> ' . esc_attr($val['start_time']) . '  -  ' . esc_attr($val['end_time']) . ' </span> 
                                <span class="day-timing"> ' . $break_status . ' </span> </li>';
                                    }
                                }
                            }
                            ?>
                        </ul>
                    </div>
                </div>
                <?php
            }
        }
    }

if (!function_exists('sb_pro_week_days')) {

    function sb_pro_week_days() {
        return array(0 => esc_html__('Monday', 'exertio'), 1 => esc_html__('Tuesday', 'exertio'), 2 => esc_html__('Wednesday', 'exertio'), 3 => esc_html__('Thursday', 'exertio'), 4 => esc_html__('Friday', 'exertio'), 5 => esc_html__('Saturday', 'exertio'), 6 => esc_html__('Sunday', 'exertio'));
    }

}
if (!function_exists('sb_pro_business_hours_status')) {

    function sb_pro_business_hours_status($listing_id) {
        /* if listing open 24/7 */
        if (get_post_meta($listing_id, 'sb_pro_business_hours', true) == '1') {
            /* return esc_html__('Always Open','dwt-listing'); */
            return '2';
        } else if (get_post_meta($listing_id, 'sb_pro_business_hours', true) == '') {
            return '';
        } else {
            /* timezone of selected business hours */
            $listing_timezone = get_post_meta($listing_id, 'sb_pro_user_timezone', true);
            if (sb_pro_checktimezone($listing_timezone) == true) {
                if ($listing_timezone != "") {
                    /* $status = esc_html__('Closed','dwt-listing'); */
                    /* current day */
                    $current_day = lcfirst(date("l"));
                    /* current time */
                    $date = new \DateTime("now", new \DateTimeZone($listing_timezone));
                    $currentTime = $date->format('Y-m-d H:i:s');

                    $custom_days = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
                    /* get all weak days */
                    $times = array();
                    for ($a = 0; $a <= 6; $a++) {
                        $week_days = lcfirst($custom_days[$a]);
                      
                        $startTime = date('g:i a', strtotime(get_post_meta($listing_id, '_timingz_' . $week_days . '_from', true)));
                        $endTime = date('g:i a', strtotime(get_post_meta($listing_id, '_timingz_' . $week_days . '_to', true)));
                        $times[substr($week_days, 0, 3)] = $startTime . ' - ' . $endTime;
                        /* } */
                    }
                    $currentTime = strtotime($currentTime);

                    return isOpen($currentTime, $times);
                }
            }
        }
    }

}

function isOpen($now, $times) {
    $open = "0"; // time until closing in seconds or 0 if closed
// merge opening hours of today and the day before
    $hours = array_merge(compileHours($times, strtotime('yesterday', $now)), compileHours($times, $now));
    foreach ($hours as $h) {
        if ($now >= $h[0] and $now < $h[1]) {
            $open = $h[1] - $now;
            return $open;
        }
    }
    return $open;
}

function compileHours($times, $timestamp) {
    $times = $times[strtolower(date('D', $timestamp))];
    if (!strpos($times, '-'))
        return array();
    $hours = explode(",", $times);
    $hours = array_map('explode', array_pad(array(), count($hours), '-'), $hours);
    $hours = array_map('array_map', array_pad(array(), count($hours), 'strtotime'), $hours, array_pad(array(), count($hours), array_pad(array(), 2, $timestamp)));
    end($hours);
    if ($hours[key($hours)][0] > $hours[key($hours)][1])
        $hours[key($hours)][1] = strtotime('+1 day', $hours[key($hours)][1]);
    return $hours;
}

if (!function_exists('sb_pro_checktimezone')) {

    function sb_pro_checktimezone($timezone) {
        $zoneList = timezone_identifiers_list(); # list of (all) valid timezones
        if (in_array($timezone, $zoneList)) {
            return true;
        } else {
            return false;
        }
    }

}



add_filter('sb_show_booking_option', 'sb_show_booking_option_callback', 10, 2);
  function sb_show_booking_option_callback($user_id) {
      
        $post_id  =   get_the_ID(); 
        $post_author = get_post_field( 'post_author', $post_id ); 
        $pid = get_user_meta( $post_author, 'freelancer_id' , true );
        $is_ad_booking_allow = true ;// get_post_meta($pid, 'is_ad_booking_allow', true);
        $widget_code = get_post_meta($pid, 'timekit_widget_code', true);
        $booked_days = get_post_meta($pid, 'booked_days', true);

        $listing_timezone = get_post_meta($pid, 'sb_pro_user_timezone', true);

        if (isset($is_ad_booking_allow) && $is_ad_booking_allow != "") {
            ?>
            <?php if (isset($exertio_theme_options['allow_timekit_booking']) && $exertio_theme_options['allow_timekit_booking']) { ?>
                <div class="main-section-bid">        
                    <div id="bookingjs"></div>
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js" defer></script>
                    <script src="https://cdn.timekit.io/booking-js/v2/booking.min.js" defer></script>
                    <script>
                <?php echo $widget_code ?>
                    </script>
                </div>     
            <?php } else {
                $listing_is_open = get_post_meta($pid, 'sb_pro_business_hours_tab', true);
              ?>  
         <div class="schedule_button">
          <?php
              $meeting_url = get_post_meta($pid, 'sb_pro_meeting_ling', true);

                if (!empty($meeting_url)) {
                    echo '<a href="' . esc_url($meeting_url) . '" class="btn btn-theme btn-block" target="_blank">Join Meeting</a>';
                }
                               
                  ?>
        </div> 
              
                <?php
            }
        }
    }



add_action('wp_ajax_sb_get_calender_time', 'sb_get_calender_time_callback');
  function sb_get_calender_time_callback() {
        $post = $_POST;
        $date = isset($post['date']) ? $post['date'] : "";
        $ad_id = isset($post['ad_id']) ? $post['ad_id'] : "";
        $timestamp = strtotime($date);
        $selected_day = date('l', $timestamp);
        $selected_month = date('m', $timestamp);
        $selected_month_name = date('F', $timestamp);
        $selected_date = date('d', $timestamp);
        $selected_year = date('Y', $timestamp);
        $date_data = array('date' => $selected_date, 'month' => $selected_month, 'month_name' => $selected_month_name, 'year' => $selected_year, 'day_name' => $selected_day);
        $current_day_today = strtolower(date('l', $timestamp));
        $is_open = get_post_meta($ad_id, '_timingz_' . $current_day_today . '_open', true);
        $listing_time_slot = get_post_meta($ad_id, 'listing_time_slot', true);
        $timing_html = "";
        $status = 'None';

        $always_open = 0;

        if (get_post_meta($ad_id, 'sb_pro_business_hours', true) == '1') {
            $always_open = 1;
        } else {
            $always_open = 2;
        }

        if ($is_open == 1 || $always_open = 1) {
            if ($always_open == 1) {
                $startTime = date('00:00:00');
                $endTime = date('24:00:00');
            } else {
                $startTime = date('H:i', strtotime(get_post_meta($ad_id, '_timingz_' . $current_day_today . '_from', true)));
                $endTime = date('H:i', strtotime(get_post_meta($ad_id, '_timingz_' . $current_day_today . '_to', true)));       
            }
            
      
            $startTime = strtotime($startTime);
            $endTime = strtotime($endTime);
            if($listing_time_slot != ""){
             $interval = $listing_time_slot.' mins';
             }else{
             $interval = '15 mins';   
             }
            $current = time();
            $addTime = strtotime('+' . $interval, $current);
            $diff = $addTime - $current;
            $intervalEnd = $startTime + $diff;
            $count = 1;
            if ($endTime > $startTime) {
                $status = 'open';
                while ($startTime < $endTime) {
                    $appt_start = date(get_option('time_format'), (int) $startTime,);
                    $appt_end = date(get_option('time_format'), (int) $intervalEnd);
                    $timing_html .= '<div class="show_book_form">   
                         <label class="time-slot">
                          <span>'.$count.'</span> : 
                           <span class="start_time">' . $appt_start . '</span>
                          <span class="start_time">' . $appt_end . '</span>                             
                          </label>
                      </div>';
                    $startTime += $diff;
                    $intervalEnd += $diff;
                    $count++;
                    /* will prevent from infinite loop */
                    if ($count == 97) {
                        return;
                    }
                }
            } else {
                $timing_html = '<div class="show_book_form_close">  
                             <label class="time-slot">
                              <span>' . esc_html__('None', 'exertio') . '</span>                               
                          </label>
                      </div>';
            }
        } else {
            $timing_html = '<div class="show_book_form_close">  
                             <label class="time-slot">
                              <span>' . esc_html__('None', 'exertio') . '</span>                               
                          </label>
                      </div>';
        }

        wp_send_json_success(array('date_data' => $date_data, 'timing_html' => $timing_html, 'status' => $status));
        die();
    }

     $args = array(
                'public' => true,
                'menu_icon' => 'dashicons-calendar',
                'label' => __('Appointments', 'exertio'),
                'supports' => array('title', 'editor', 'comments'),
                'show_ui' => true,
                'capability_type' => 'post',
                'hierarchical' => false,
                'has_archive' => true,
                'rewrite' => array('with_front' => false, 'slug' => 'sb_bookings')
            );
            register_post_type('sb_bookings', $args);






    add_filter('manage_sb_bookings_posts_columns','sb_bookings_posts_columns_callback', 10, 2);
   function sb_bookings_posts_columns_callback($col) {
        $col['booker_email'] = esc_html__('Email', 'exertio');
        $col['booker_phone'] = esc_html__('Phone', 'exertio');
        $col['booking_date'] = esc_html__('Booking Date', 'exertio');
        $col['booking_start_time'] = esc_html__('Booking Start tiime', 'exertio');
        $col['booking_end_time'] = esc_html__('Booking End Time', 'exertio');
        $col['booking_status'] = esc_html__('Booking Status', 'exertio');
        return $col;
    }

     add_action('manage_sb_bookings_posts_custom_column','sb_bookings_posts_custom_column_content_callback', 10, 2);
     function sb_bookings_posts_custom_column_content_callback($column, $booking_id) {
        $booking_details = get_post_meta($booking_id, 'booking_details', true);

        $booking_details = $booking_details != "" ? json_decode($booking_details, true) : array();
        $formated_date = $booker_name = $booker_email = $booker_phone = $booking_slot_start = $booking_slot_end = $booking_date = $booking_month = $booking_day = $booking_ad_id = "";
        if (!empty($booking_details)) {
            $booker_name = $booking_details['booker_name'];
            $booker_email = $booking_details['booker_email'];
            $booker_phone = $booking_details['booker_phone'];
            $booking_slot_start = $booking_details['booking_slot_start'];
            $booking_slot_end = $booking_details['booking_slot_end'];
            $booking_date = $booking_details['booking_date'];
            $booking_month = $booking_details['booking_month'];
            $booking_day = $booking_details['booking_day'];
            $booking_ad_id = isset($booking_details['booking_ad_id']) ? $booking_details['booking_ad_id'] : "";

            $booking_org_date = get_post_meta($booking_id, 'booking_org_date', true);     /* extra date saved for direct get date */
            $formated_date = "";
            if ($booking_org_date != "") {

                $formated_date = date(get_option('date_format'), $booking_org_date);
            }


            $status_string = array(__('Pending', 'exertio'), __('Pending', 'exertio'), __('Approved', 'exertio'), __('Rejected', 'exertio'));
            $booking_status = get_post_meta($booking_id, 'booking_status', true);
            $booking_status = isset($status_string[$booking_status]) ? $status_string[$booking_status] : "";
        }
        switch ($column) {
            case 'booker_email':
                echo $booker_email;
                break;
            case 'booker_phone':
                echo $booker_phone;
                break;
            case 'booking_date':
                echo $formated_date;
                break;
            case 'booking_start_time':
                echo $booking_slot_start;
                break;
            case 'booking_end_time':
                echo $booking_slot_end;
                break;
            case 'booking_status':
                echo $booking_status;
                break;
            default:
                break;
        }
    }

    add_action('wp_ajax_sb_pro_create_booking', 'sb_create_booking_callback');
    add_action('wp_ajax_nopriv_sb_pro_create_booking', 'sb_create_booking_callback');
     function sb_create_booking_callback() {
        global $exertio_theme_options;
        $user_id = get_current_user_id();


       if($user_id == "" || $user_id == 0){
     
        wp_send_json_error(array('message' => __('Please Login first', 'exertio')));
       }

        $data = isset($_POST['data']) ? $_POST['data'] : "";

        $params = array();
        parse_str($data, $params);
        $booker_first_name = isset($params['booker_first_name']) ? sanitize_text_field($params['booker_first_name']) : "";
        $booker_last_name = isset($params['booker_last_name']) ? sanitize_text_field($params['booker_last_name']) : "";
        $booker_email = isset($params['booker_email']) ? sanitize_email($params['booker_email']) : "";
        $booker_phone = isset($params['booker_phone']) ? sanitize_text_field($params['booker_phone']) : "";
        $booker_comment = isset($params['booker_comment']) ? sanitize_text_field($params['booker_comment']) : "";
        $booker_name = $booker_first_name . ' ' . $booker_last_name ;
        $booking_ad_id = isset($params['booking_ad_id']) ? sanitize_text_field($params['booking_ad_id']) : "";
        $form_booking_day = isset($params['form_booking_day']) ? sanitize_text_field($params['form_booking_day']) : "";
        $form_booking_date = isset($params['form_booking_date']) ? sanitize_text_field($params['form_booking_date']) : "";
        $form_booking_month = isset($params['form_booking_month']) ? sanitize_text_field($params['form_booking_month']) : "";
        $form_booking_month_name = isset($params['form_booking_month_name']) ? sanitize_text_field($params['form_booking_month_name']) : "";
        $form_booking_year = isset($params['form_booking_year']) ? sanitize_text_field($params['form_booking_year']) : "";
        $form_slot_start = isset($params['form_slot_start']) ? sanitize_text_field($params['form_slot_start']) : "";
        $form_slot_end = isset($params['form_slot_end']) ? sanitize_text_field($params['form_slot_end']) : "";
        $booking_ad_id = isset($params['booking_ad_id']) ? sanitize_text_field($params['booking_ad_id']) : "";
        $selected_booking_date   = isset($params['selected_booking_date']) ? sanitize_text_field($params['selected_booking_date']) : "";
        $author_id = get_post_field('post_author', $booking_ad_id);
        $fid = get_user_meta( $post_author, 'freelancer_id', true );
        $author_email = get_the_author_meta('user_email', $author_id);

        $booking_time = $form_slot_start . "-" . $form_slot_end;
        $ad_title = get_the_title($booking_ad_id);
        $ad_link = get_the_permalink($booking_ad_id);

    

        $formated_date = "";
        if ($form_booking_day != "" && $form_booking_date != "" && $form_booking_month != "") {
            $formated_date = strtotime($form_booking_day . $form_booking_date . $form_booking_month);
            $formated_date = date(get_option('date_format'), $formated_date);
        }

        $author_id = get_post_field ('post_author', $booking_ad_id);
        $author_data = get_userdata($author_id);
        $author_name = $author_data->display_name;
        $author_email = $author_data->user_email;

        $args = array(
            'post_content' => $booker_comment,
            'post_status' => 'publish',
            'post_title' => $booker_first_name . ' ' . $booker_last_name . ' ' . '(' . get_the_title($booking_ad_id) . ')',
            'post_type' => 'sb_bookings',
            'post_author' => $user_id
        );
        $booking_id = wp_insert_post($args);


        if (!is_wp_error($booking_id)) {
            $booking_details = array();
            $booking_details['booker_name'] = $booker_first_name . "  " . $booker_last_name;
            $booking_details['booker_email'] = $booker_email;
            $booking_details['booker_phone'] = $booker_phone;
            $booking_details['booking_slot_start'] = $form_slot_start;
            $booking_details['booking_slot_end'] = $form_slot_end;
            $booking_details['booking_date'] = $form_booking_date;
            $booking_details['booking_month'] = $form_booking_month;
            $booking_details['booking_month_name'] = $form_booking_month_name;
            $booking_details['booking_day'] = $form_booking_day;
            $booking_details['booking_year'] = $form_booking_year;
            $booking_details['booking_ad_id'] = $booking_ad_id;
            
            update_post_meta($booking_id, 'booking_details', json_encode($booking_details));
            update_post_meta($booking_id, 'booking_org_date', strtotime($form_booking_year . "-" . $form_booking_month . "-" . $form_booking_date));
            update_post_meta($booking_id, 'booking_ad_owner', $author_id);
            update_post_meta($booking_id, 'booking_status', 1);
            update_post_meta($booking_id, 'booking_status_comment', $booker_comment);
            update_post_meta($booking_id, 'selected_booking_date', $selected_booking_date);
            update_post_meta($booking_id, 'booking_service_id', $booking_ad_id);

            $is_booking_on = isset($exertio_theme_options['send_booking_create_email']) ? $exertio_theme_options['send_booking_create_email'] : "0";
            if($is_booking_on == 1){
            $msg_keywords = array('%customer%', '%booking_date%', '%booking_time%', '%ad_title%', '%ad_link%', '%extra_details%');
            $msg_replaces = array($booker_name, $formated_date, $booking_time, $ad_title, $ad_link, $extra_details);
            $body = str_replace($msg_keywords, $msg_replaces, $exertio_theme_options['sb_booking_status_create_message']);
            $subject = isset($exertio_theme_options['send_booking_create_subject']) ? $exertio_theme_options['send_booking_create_subject'] : "Booking info";
            $from = isset($exertio_theme_options['send_booking_create_from']) ? $exertio_theme_options['send_booking_create_from'] : "Booking info";
            $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from"); 
            wp_mail($author_email, $subject, $body, $headers);
            }

            wp_send_json_success(array('message' => __('Booking Created succesfully', 'exertio')));
        } else {
            wp_send_json_error(array('message' => __('something went wrong', 'exertio')));
        }
    }


if (!function_exists('adforest_search_params')) {

    function adforest_search_params($index, $second = '', $third = '', $search_url = false) {
        global $exertio_theme_options;
        $param = $_SERVER['QUERY_STRING'];
        $res = '';
        //if (isset($param) && $index != 'cat_id' && $index != 'country_id') {
        if (isset($param)) {
            parse_str($_SERVER['QUERY_STRING'], $vars);
            foreach ($vars as $key => $val) {
                if ($key == $index) {
                    continue;
                }

                if ($second != "") {
                    if ($key == $second) {
                        continue;
                    }
                }
                if ($third != "") {
                    if ($key == $third) {
                        continue;
                    }
                }

                if (isset($vars['custom']) && count($vars['custom']) > 0 && 'custom' == $key) {


                    if (is_array($val)) {
                        if (isset($val) && count($val) > 0) {
                            foreach ($val as $ckey => $cval) {
                                $name = "custom[$ckey]";
                                if ($name == $index) {
                                    continue;
                                }
                                if (isset($cval) && is_array($cval)) {
                                    foreach ($cval as $v) {
                                        $res .= '<input type="hidden" name="' . esc_attr($name) . '[]" value="' . esc_attr($v) . '" />';
                                    }
                                } else {
                                    $res .= '<input type="hidden" name="' . esc_attr($name) . '" value="' . esc_attr($cval) . '" />';
                                }
                            }
                        }
                    } else {

                        foreach ($vars['custom'] as $ckey => $cval) {
                            $name = "custom[$ckey]";
                            if ($name == $index) {
                                continue;
                            }
                            $res .= '<input type="hidden" name="' . esc_attr($name) . '" value="' . esc_attr($cval) . '" />';
                        }
                    }
                } else if (isset($vars['min_custom']) && count((array) $vars['min_custom']) > 0 && 'min_custom' == $key) {
                    foreach ($vars['min_custom'] as $ckey => $cval) {
                        $name = "min_custom[$ckey]";
                        if ($name == "min_" . $index) {
                            continue;
                        }
                        if ($name == $index) {
                            continue;
                        }
                        $res .= '<input type="hidden" name="' . esc_attr($name) . '" value="' . esc_attr($cval) . '" />';
                    }
                } else if (isset($vars['max_custom']) && count((array) $vars['max_custom']) > 0 && 'max_custom' == $key) {
                    foreach ($vars['max_custom'] as $ckey => $cval) {
                        $name = "max_custom[$ckey]";
                        if ($name == "max_" . $index) {
                            continue;
                        }
                        if ($name == $second) {
                            continue;
                        }
                        $res .= '<input type="hidden" name="' . esc_attr($name) . '" value="' . esc_attr($cval) . '" />';
                    }
                } else {
                    $res .= '<input type="hidden" name="' . esc_attr($key) . '" value="' . esc_attr($val) . '" />';
                }
            }
        } else if ($search_url) {
            $sb_search_page = apply_filters('adforest_language_page_id', $exertio_theme_options['sb_search_page']);
            $res = get_the_permalink($sb_search_page);
        }
        return $res;
    }

}
add_filter('sb_get_booking_list', 'sb_get_booking_list_callback', 10, 2);
function sb_get_booking_list_callback($type) {
        $user_id = get_current_user_id();
        $paged = get_query_var('paged', 1);
        $args = array(
            'post_type' => 'sb_bookings',
            'post_status' => 'publish',
            'posts_per_page' => get_option('posts_per_page'),
            'paged' => $paged,
            'meta_query' => array(
                array(
                    'key' => 'booking_ad_owner',
                    'value' => $user_id,
                    'compare' => '=',
                )
            )
        );
        $args = apply_filters('adforest_wpml_show_all_posts', $args);
        $query = new \WP_Query($args);
        

        $html = "";
        $count = 0;
        if ($query->have_posts()) {
            $number = 0;
            $remove = '';
            /* Modal : booking detail model html */

            $html .= '
           <div>
           </div>     
           <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">s
                <div class="panel  event-container  frelancer">          
                <div class="panel-body">
                <div class="table-responsive">
                <table class="table sb-admin-tabelz-panel table-hover ">
                              <thead>
                                    <tr>
                                        <th> ' . esc_html('User', 'exertio') . '</th>
                                        <th> ' . esc_html('Services', 'exertio') . '</th>
                                        <th> ' . esc_html('Time Slot', 'exertio') . '</th>
                                        <th> ' . esc_html('Date', 'exertio') . '</th>
                                        <th> ' . esc_html('Status', 'exertio') . ' </th>
                                        <th> ' . esc_html('Details', 'exertio') . ' </th>
                                      
                                    </tr>
                               </thead>
                            <tbody> ';

            $order = isset($_GET['order_booking']) ? $_GET['order_booking'] : "";

            while ($query->have_posts()) {
                $query->the_post();
                $booking_id = get_the_ID();
                $booking_status = get_post_meta($booking_id, 'booking_status', true);
                if (isset($order) && $order != "5" && $order != "") {
                    if ($booking_status != $order) {
                        continue;
                    }
                }
                $booking_details = get_post_meta($booking_id, 'booking_details', true);
                $booking_details = json_decode($booking_details, true);


                $booker_name = isset($booking_details['booker_name']) ? $booking_details['booker_name'] : "";
                $booker_email = isset($booking_details['booker_email']) ? $booking_details['booker_email'] : "";
                $booker_phone = isset($booking_details['booker_phone']) ? $booking_details['booker_phone'] : "";
                $booking_slot_start = isset($booking_details['booking_slot_start']) ? $booking_details['booking_slot_start'] : "";
                $booking_slot_end = isset($booking_details['booking_slot_end']) ? $booking_details['booking_slot_end'] : "";

                $booking_date = isset($booking_details['booking_date']) ? $booking_details['booking_date'] : "";
                $booking_month = isset($booking_details['booking_month']) ? $booking_details['booking_month'] : "";
                $booking_day = isset($booking_details['booking_day']) ? $booking_details['booking_day'] : "";
                $booking_ad = isset($booking_details['booking_ad_id']) ? $booking_details['booking_ad_id'] : "";
                $selectd_booking_date = get_post_meta($booking_id, 'selected_booking_date', true); 
                $booking_org_date = get_post_meta($booking_id, 'booking_org_date', true);
            
                $formated_date = "";               
                if ($selectd_booking_date != "") {

                    $formated_date = date(get_option('date_format'), strtotime($selectd_booking_date));
                }
                if($booking_status != 4){
                $status = '<select class="booking_status custom-select" data-id = "' . $booking_id . '">
                         <option value="1"  ' . (($booking_status == 1) ? 'selected' : '') . '>' . esc_html__('Pending', 'exertio') . '</option>
                         <option value="2" ' . (($booking_status == 2) ? 'selected' : '') . '>' . esc_html__('Accepted', 'exertio') . '</option>
                         <option value = "3" ' . (($booking_status == 3) ? 'selected' : '') . '>' . esc_html__('Rejected', 'exertio') . '</option>
                         </select>';
                     }else{
                       $status = esc_html__('Cancelled' , 'exertio');
                     }

                $html .= '<tr>
                     <td><span class="admin-listing-img">' . $booker_name . '</span>
                     </td>
                     <td><a href="' . get_the_permalink($booking_ad) . '"><span class="admin-listing-img">' . get_the_title($booking_ad) . '</span></a>
                     </td>
                  
                     <td><span class="admin-listing-img">' . $booking_slot_start . '  ' . $booking_slot_end . '</span>
                     </td>      
                     <td><span class="admin-listing-img">' . $formated_date . '</span>
                     </td>
                     
                     <td><span class="admin-listing-img">' . $status . '</span>
                        </td>               
                     <td><a href="javascript:void(0)" class="view_booking_details" data-id ="' . $booking_id . '"><span class="admin-listing-img">' . esc_html__('View Detail', 'exertio') . '</span>
                        </td>            
                    </tr>';
                $count++;
            }
            wp_reset_postdata();
            $html .= '</tbody></table></div></div></div></div>';
            $html .= '<div  class="col-12"><div class="pagination-item">' . adforest_pagination_ads($query) . '</div></div>';
        }

        if ($count == 0) {
            $no_found = get_template_directory_uri() . '/images/nothing-found.png';
            $html .= '<div class="col-lg-12 col-md-12 col-xs-12  col-12"><div class="nothing-found recent-events dash-events">
                        <img src="' . $no_found . '" alt="">
                    <span>' . esc_html__('No Result Found', 'exertio') . '</span>
                  </div></div>';
        }

        $html .= '<div class="modal fade" id="booking-detail-modal" tabindex="-1" aria-labelledby="booking-detail-modal" aria-hidden="true">
                       <div class="modal-dialog">   
                       <div class="modal-content"  id = "booking-detail-content" >

                      </div>
                    </div>
                  </div>
                  <input type="hidden" id="prompt_heading" value = "' . esc_html__('Enter extra details here', 'exertio') . '">
                  <input type="hidden" id="no-detail-notify" value = "' . esc_html__('Enter details first', 'exertio') . '">
                   
                   ';

        return $html;
    }

    if (!function_exists('adforest_pagination_ads')) {

    function adforest_pagination_ads($wp_query) {
        if (is_singular())
        //return;

        /** Stop execution if there's only 1 page */
            if ($wp_query->max_num_pages <= 1)
                return;

        if (get_query_var('paged')) {
            $paged = get_query_var('paged');
        } elseif (get_query_var('page')) {
            $paged = get_query_var('page');
        } else {
            $paged = 1;
        }

        $max = intval($wp_query->max_num_pages);
        /**     Add current page to the array */
        if ($paged >= 1)
            $links[] = $paged;

        /**     Add the pages around the current page to the array */
        if ($paged >= 3) {
            $links[] = $paged - 1;
            $links[] = $paged - 2;
        }

        if (( $paged + 2 ) <= $max) {
            $links[] = $paged + 2;
            $links[] = $paged + 1;
        }
        
        $pagination   =  "";

        $pagination  .= '<ul class="pagination pagination-lg">' . "\n";

        if (get_previous_posts_link())
        $pagination  .=     '<li>'.get_previous_posts_link().'</li>' . "\n";

        /**     Link to first page, plus ellipses if necessary */
        if (!in_array(1, $links)) {
            $class = 1 == $paged ? ' class="active"' : '';

            $pagination .= '<li  '.$class.'><a href="'.esc_url(get_pagenum_link(1)).'">1</a></li>' . "\n";

            if (!in_array(2, $links))
                $pagination  .=  '<li><a href="javascript:void(0);">...</a></li>';
        }
        /**     Link to current page, plus 2 pages in either direction if necessary */
        sort($links);
        foreach ((array) $links as $link) {

            $class = $paged == $link ? ' class="active"' : '';
       $pagination  .=  '<li '.$class.'><a href="'.esc_url(get_pagenum_link($link)).'">'.$link.'</a></li>' . "\n" ;
        }
        /**     Link to last page, plus ellipses if necessary */
        if (!in_array($max, $links)) {
            if (!in_array($max - 1, $links))
                $pagination  .=  '<li><a href="javascript:void(0);">...</a></li>' . "\n";
            $class = $paged == $max ? ' class="active"' : '';
     $pagination  .=      '<li '.$class.'><a href="'.esc_url(get_pagenum_link($max)).'">'.$max.'</a></li>' . "\n";
        }

        if (get_next_posts_link_custom($wp_query))
         $pagination  .=    '<li>'.get_next_posts_link_custom($wp_query).'</li>' . "\n"  ;

   return      $pagination  .=  '</ul>' . "\n";
    }
}



      add_action('wp_ajax_sb_booking_status','sb_booking_status_callback');
      function sb_booking_status_callback() {
       global $exertio_theme_options;
       //$current_user_id =  get_current_user_id();
        $extra_details = isset($_POST['extra_detail']) ? $_POST['extra_detail'] : "";
        $val = isset($_POST['val']) ? $_POST['val'] : "";
        $booking_id = isset($_POST['booking_id']) ? $_POST['booking_id'] : "";
        $video_link = isset($_POST['link']) ? $_POST['link'] : "";
        $current_user = wp_get_current_user();
        //ads auther info
        if ( $current_user instanceof WP_User && $current_user->ID !== 0 ) {
            $user_id = $current_user->ID;
            $user_login = $current_user->user_login;
            $user_email = $current_user->user_email;
            $user_display_name = $current_user->display_name;
        }
        
        //booker Info
        $booking_details = get_post_meta($booking_id, 'booking_details', true);
        $data = json_decode($booking_details, true);
        $booker_email = isset($data['booker_email']) ? $data['booker_email'] : '';
        $booker_name = isset($data['booker_name']) ? $data['booker_name'] : '';
        $booking_ad_id = isset($data['booking_ad_id']) ? $data['booking_ad_id'] : '';
   

        if ($val == "" || $val == "") {
            wp_send_json_error(array('message' => esc_html__('Something went wrong', 'exertio')));
        } else {
            
            if ($val == "2" || $val == "3") {
                
                do_action('sb_send_booking_status_change_email', $booking_id, $val, $extra_details , $video_link);
               

            }
            update_post_meta($booking_id, 'zoom_video_link', $video_link);
            update_post_meta($booking_id, 'booking_status', $val);
            update_post_meta($booking_id, 'booking_status_details', $extra_details);
            wp_send_json_success(array('message' => esc_html__('Status updated succesfully', 'exertio')));
        }
    }

  add_action('wp_ajax_sb_cancel_status','sb_cancel_status_callback');
  
      function sb_cancel_status_callback() {
        global $exertio_theme_options;
        $current_user =  get_current_user_id();
        $extra_details = isset($_POST['extra_detail']) ? $_POST['extra_detail'] : "";

        $val = isset($_POST['cancel_status']) ? $_POST['cancel_status'] : "";
        $booking_id = isset($_POST['booking_id']) ? $_POST['booking_id'] : "";
        //booker Info
        $booking_details = get_post_meta($booking_id, 'booking_details', true);
        $data = json_decode($booking_details, true);
        $booker_email = isset($data['booker_email']) ? $data['booker_email'] : '';
        $booker_name = isset($data['booker_name']) ? $data['booker_name'] : '';
        $booking_ad_id = isset($data['booking_ad_id']) ? $data['booking_ad_id'] : '';
        $form_slot_start = isset($params['form_slot_start']) ? sanitize_text_field($params['form_slot_start']) : "";
        $form_slot_end = isset($params['form_slot_end']) ? sanitize_text_field($params['form_slot_end']) : "";
        $form_booking_day = isset($params['form_booking_day']) ? sanitize_text_field($params['form_booking_day']) : "";
        $form_booking_date = isset($params['form_booking_date']) ? sanitize_text_field($params['form_booking_date']) : "";
        $form_booking_month = isset($params['form_booking_month']) ? sanitize_text_field($params['form_booking_month']) : "";
        $booking_time = $form_slot_start . "-" . $form_slot_end;
        $ad_title = get_the_title($booking_ad_id);
        $ad_link = get_the_permalink($booking_ad_id);

        
        $formated_date = "";
        if ($form_booking_day != "" && $form_booking_date != "" && $form_booking_month != "") {
            $formated_date = strtotime($form_booking_day . $form_booking_date . $form_booking_month);
            $formated_date = date(get_option('date_format'), $formated_date);
        }

        $author_id = get_post_field ('post_author', $booking_ad_id);
        $author_data = get_userdata($author_id);
        $author_name = $author_data->display_name;
        $author_email = $author_data->user_email;
        
 
            update_post_meta($booking_id, 'booking_status', $val);
            update_post_meta($booking_id, 'booking_cancel_msg', $extra_details);

            $cancle_email_is_set = $exertio_theme_options('send_booking_cancle_email');
     if($cancle_email_is_set !== "0"){ 
        
            $msg_keywords = array('%customer%', '%booking_date%', '%booking_time%', '%ad_title%', '%ad_link%', '%extra_details%');
            $msg_replaces = array($booker_name, $formated_date, $booking_time, $ad_title, $ad_link, $extra_details);
            $body = str_replace($msg_keywords, $msg_replaces, $exertio_theme_options['sb_booking_status_cancle_message']);
            $subject = isset($exertio_theme_options['send_booking_cancle_subject']) ? $exertio_theme_options['send_booking_cancle_subject'] : "Booking info";
            $from = isset($exertio_theme_options['send_booking_cancle_from']) ? $exertio_theme_options['send_booking_cancle_from'] : "Booking info";
            $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from"); 

            wp_mail($author_email, $subject, $body, $headers);
            }

            wp_send_json_success(array('message' => esc_html__('Status updated succesfully', 'exertio')));
        }
   

     add_action('wp_ajax_sb_get_booking_details', 'sb_get_booking_details_callback');
     function sb_get_booking_details_callback() {
        // $is_demo = sb_is_demo();

        $booking_id = isset($_POST['booking_id']) ? $_POST['booking_id'] : "";
        $resonse = get_post_meta($booking_id, 'booking_cancel_msg', true);

         if($resonse != ""){
          $resonse  =    '<div class="col-6">
                                  <div class= "form-group">
                                     <label> ' . esc_html__('Reason Cancel', 'exertio') . '</label>
                                    <p>   '  .$resonse. '   </p>
                                   </div>      
                              </div>';
           }
           if($resonse == ""){
           $meeting_link = get_post_meta($booking_id, 'zoom_video_link', true);
         if($meeting_link != "" ){
          $meeting_link  =    '<div class="col-6">
                                  <div class= "form-group">
                                     <label> ' . esc_html__('Meeting Link', 'exertio') . '</label>
                                    <a href="'.$meeting_link.'">   ' . esc_html__('click here').'   </a>
                                   </div>      
                              </div>';
           }
        }
            $booking_status =  get_post_meta($booking_id, 'booking_status', true);
             $book_meeting = get_post_meta($booking_id, 'booking_status_comment', true);
            if($book_meeting != ""  && $booking_status == 1){
                $book_meting  =    '<div class="col-6">
                                  <div class= "form-group">
                                     <label> ' . esc_html__('Comments', 'exertio') . '</label>
                                    <p>   '  .$book_meeting. '   </p>
                                   </div>      
                              </div>';
           }
       

        if ($booking_id == "") {
            wp_send_json_error(array('message' => esc_html__('Something went wrong', 'exertio')));
        } else {
            $booking_details = get_post_meta($booking_id, 'booking_details', true);
            $booking_details = $booking_details != "" ? json_decode($booking_details, true) : array();
            if (!empty($booking_details)) {
                $booker_name = $booking_details['booker_name'];
                $booker_email = $booking_details['booker_email'];
                $booker_phone = $booking_details['booker_phone'];
                $booking_slot_start = $booking_details['booking_slot_start'];
                $booking_slot_end = $booking_details['booking_slot_end'];

                $booking_date = $booking_details['booking_date'];
                $booking_month = $booking_details['booking_month'];
                $booking_day = $booking_details['booking_day'];
                $booking_ad_id = $booking_details['booking_ad_id'];
                $booking_note = get_post_meta($booking_id, 'booking_status_details', true); 
                
                 if($booking_note != ""){

                    $booking_note  =   '<div class="col-6">
                                  <div class= "form-group">
                                     <label> ' . esc_html__('Booking note', 'exertio') . '</label>
                                    <p>   '  .$booking_note. '   </p>
                                   </div>      
                              </div>';
                 }


                 $booking_slot   =   $booking_slot_start . "  "   .  $booking_slot_end ;

               
                $html = '<div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                   <span type="button" class="btn-close" data-dismiss="modal" aria-label="Close">X</span>
                          </div>
                          <div class="modal-body">
                          <div class="row">
                              <div class="col-6">
                                  <div class= "form-group">
                                     <label> ' . esc_html__('Customer name', 'exertio') . '</label>
                               <p> ' . $booker_name . '  </p>
                                   </div>      
                              </div>
                              <div class="col-6">
                                  <div class= "form-group">
                                     <label> ' . esc_html__('Customer email', 'exertio') . '</label>
                                   <p>    ' . $booker_email . ' </p>
                                   </div>      
                              </div>
                              <div class="col-6">
                                  <div class= "form-group">
                                     <label> ' . esc_html__('Customer phone', 'exertio') . '</label>
                                 <p>      ' . $booker_phone . '   </p>
                                   </div>      
                              </div>
                              <div class="col-6">
                                  <div class= "form-group">
                                     <label> ' . esc_html__('Time slot', 'exertio') . '</label>
                                    <p>   '.$booking_slot.'  </p>
                                   </div>      
                              </div>

                              '. $resonse.'
                               '.$booking_note.'
                               '.$meeting_link.'
                              '. $book_meting.'

                          </div>
                         </div>
                         <div class="modal-footer">
                         <button type="button" class="btn btn-theme" value="canceled" data-dismiss="modal">Close</button>
                      </div>';
            }
            wp_send_json_success(array('message' => '', 'detail' => $html));
        }
    }
 add_filter('sb_get_sent_booking_list', 'sb_get_sent_booking_list_callback', 10, 2);
     function sb_get_sent_booking_list_callback($type) {
        $user_id = get_current_user_id();
        $paged = get_query_var('paged', 1);

        $args = array(
            'post_type' => 'sb_bookings',
            'post_status' => 'publish',
            'posts_per_page' => get_option('posts_per_page'),
            'paged' => $paged,
            'author' => $user_id
        );
        $args = apply_filters('adforest_wpml_show_all_posts', $args);
        $query = new \WP_Query($args);

        $html = "";
        $count = 0;
        if ($query->have_posts()) {
            $number = 0;
            $remove = '';
            /* Modal : booking detail model html */

            $html .= '
           <div>
           </div>     
           <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                <div class="panel  event-container Employer">          
                <div class="panel-body">
                <div class="table-responsive">
                <table class="table sb-admin-tabelz-panel table-hover ">
                              <thead>
                                    <tr>
                                        <th> ' . esc_html('User', 'exertio') . '</th>
                                        <th> ' . esc_html('Listing', 'exertio') . '</th>
                                        <th> ' . esc_html('Time Slot', 'exertio') . '</th>
                                        <th> ' . esc_html('Date', 'exertio') . '</th>
                                        <th> ' . esc_html('Status', 'exertio') . ' </th>
                                        <th> ' . esc_html('Details', 'exertio') . ' </th>
                                        <th> ' . esc_html('Actions', 'exertio') . ' </th>
                                    </tr>
                               </thead>
                            <tbody> ';

            $order = isset($_GET['order_booking']) ? $_GET['order_booking'] : "";
            while ($query->have_posts()) {
                $query->the_post();
                $booking_id = get_the_ID();
                $booking_status = get_post_meta($booking_id, 'booking_status', true);
                if (isset($order) && $order != "5" && $order != "") {
                    if ($booking_status != $order) {
                        continue;
                    }
                }
                $booking_details = get_post_meta($booking_id, 'booking_details', true);
                $booking_details = json_decode($booking_details, true);
                $booker_name = isset($booking_details['booker_name']) ? $booking_details['booker_name'] : "";
                $booker_email = isset($booking_details['booker_email']) ? $booking_details['booker_email'] : "";
                $booker_phone = isset($booking_details['booker_phone']) ? $booking_details['booker_phone'] : "";
                $booking_slot_start = isset($booking_details['booking_slot_start']) ? $booking_details['booking_slot_start'] : "";
                $booking_slot_end = isset($booking_details['booking_slot_end']) ? $booking_details['booking_slot_end'] : "";
                $booking_date = isset($booking_details['booking_date']) ? $booking_details['booking_date'] : "";
                $booking_month = isset($booking_details['booking_month']) ? $booking_details['booking_month'] : "";
                $booking_day = isset($booking_details['booking_day']) ? $booking_details['booking_day'] : "";
                $booking_ad = isset($booking_details['booking_ad_id']) ? $booking_details['booking_ad_id'] : "";
                 $selectd_booking_date = get_post_meta($booking_id, 'selected_booking_date', true); 
                 //print_r($selectd_booking_date);
                $formated_date = "";
                $booking_org_date = get_post_meta($booking_id, 'booking_org_date', true);
                if ($booking_org_date != "") {
                    $selectd_booking_date_unix = strtotime($selectd_booking_date);
                    $formated_date = date_i18n(get_option('date_format'), $selectd_booking_date_unix);
                }

                $status = $booking_status;
                $disbabled  = "";

                if ($status == 2) {
                    $status = esc_html__('Accepted', 'exertio');
                     $disabled  = "";
                } else if($status == 3) {
                    $status = esc_html__('Rejected', 'exertio');
                    $disabled  = "disabled";
                }else if($status == 4) {
                    $status = esc_html__('Cancelled', 'exertio');
                    $disabled  = "disabled";

                }else {
                    $status = esc_html__('Pending', 'exertio');
                     $disabled  = "";
                }
                $html .= '<tr>
                     <td><span class="admin-listing-img">' . $booker_name . '</span>
                     </td>
                     <td><a href="' . get_the_permalink($booking_ad) . '"><span class="admin-listing-img">' . get_the_title($booking_ad) . '</span></a>
                     </td>
                  
                     <td><span class="admin-listing-img">' . $booking_slot_start . '      ' . $booking_slot_end . '</span>
                     </td>      
                     <td><span class="admin-listing-img">' . $formated_date . '</span>
                     </td>
                     
                     <td><span class="admin-listing-img">' . $status . '</span>
                        </td>               
                     <td><a href="javascript:void(0)" class="view_booking_details" data-id ="' . $booking_id . '"><span class="admin-listing-img">' . esc_html__('View Detail', 'exertio') . '</span>
                        </td>
                        <td><button  class="cancel_apoint btn btn-theme-secondary" data-id ="' . $booking_id . '" '.$disabled.'>Cancel</button>
                        </td>

                    </tr>';
                $count++;
            }
            wp_reset_postdata();
            $html .= '</tbody></table></div></div></div></div>';
            $html .= '<div  class="col-12"><div class="pagination-item">' . adforest_pagination_ads($query) . '</div></div>';
        }
        if ($count == 0) {
            $no_found = get_template_directory_uri() . '/images/nothing-found.png';
            $html .= '<div class="col-lg-12 col-md-12 col-xs-12  col-12"><div class="nothing-found recent-events dash-events">
                        <img src="' . $no_found . '" alt="">
                    <span>' . esc_html__('No Result Found', 'exertio') . '</span>
                  </div></div>';
        }

        $html .= '<div class="modal fade" id="booking-detail-modal" tabindex="-1" aria-labelledby="booking-detail-modal" aria-hidden="true">
                       <div class="modal-dialog">   
                       <div class="modal-content"  id = "booking-detail-content" >

                      </div>
                    </div>
                  </div>
                  <input type="hidden" id="prompt_heading" value = "' . esc_html__('Enter extra details here', 'exertio') . '">
                  <input type="hidden" id="no-detail-notify" value = "' . esc_html__('Enter details first', 'exertio') . '">
                   
                   ';

        return $html;
    }

add_filter('sb_get_booking_creat_form', 'sb_get_booking_creat_form_fun', 10);
       function sb_get_booking_creat_form_fun($param) {
        //global $exertio_theme_options;
        $user_id = get_current_user_id();
        // $allow_booking = $exertio_theme_options['allow_booking_listing'] ? $exertio_theme_options['allow_booking_listing'] : false;
        // if (!$allow_booking) {
        //     return;
        // }
        $event_title = '';
        $userID = get_current_user_id();
        $widget_area = "";


        $calender_booking  = ' <div class="form-group has-feedback">
                                <label class="control-label">' . esc_html__('Select days to avoid booking', 'exertio') . '<span>*</span></label>
                                <div class="input-group">
                                   <div  id="already_booked_day"></div>
                                </div>
                            </div>';

        return '
                    <div class="col-lg-8 col-xl-8">                     
                <div class="card card-default">
                    <div class="card-header card-header-border-bottom">
                        <h2>' . esc_html__('Booking Calenter', 'exertio') . '</h2>
                    </div>
                    <div class="card-body">
                        <form  id="my-bookings-listing">          
                              '.$calender_booking.'
                            <div class="form-group has-feedback">                        
                                <div class="input-group">
                                   <button  type="submit" class="ladda-button btn btn-primary btn-square btn-ladda btn-block" data-style="expand-left">
                                    ' . esc_html__('Submit', 'exertio') . '</button>
                                 </div>
                            </div>                            
                                 <input type = "hidden"  id="booked_days"  name = "booked_days" >
                            </form>
                    </div>
                </div></div>
                        ';
    }

   
function createSelectOptions() {
  $times = array();
  for ($hour = 0; $hour < 24; $hour++) {
    for ($minute = 0; $minute < 60; $minute += 30) {
      $time = sprintf('%02d:%02d', $hour, $minute);
      $formattedTime = date('g:i A', strtotime($time));
      $times[] = array(
        'label' => $formattedTime,
        'value' => $formattedTime
      );
    }
  }

  $options = '';
  foreach ($times as $time) {
    $options .= '<option value="' . $time['value'] . '">' . $time['label'] . '</option>';
  }

  return $options;
}



function get_booked_hours($selected_date , $freelancer_id ){

    $args = array(
        'post_type' => 'sb_bookings',
        'meta_query' => array(
            'relation' => 'AND',
            array(
                'key' => 'selected_booking_date',
                'value' => $selected_date,
                'compare' => '=',
            ),
            array(
                'key' => 'booking_ad_owner',
                'value' => $freelancer_id,
                'compare' => '=',
            )
        ),
        'posts_per_page' => -1, // to retrieve all posts
    );
    
    $query = new WP_Query( $args );
    
     $arr  =   array();

    if ( $query->have_posts() ) {
        while ( $query->have_posts() ) {
            $query->the_post();
            $booking_id   =   get_the_ID();

            $booking_status = get_post_meta($booking_id, 'booking_status', true);

            $booking_details = get_post_meta($booking_id, 'booking_details', true);
            $booking_details = json_decode($booking_details, true);
            $booking_slot_start = isset($booking_details['booking_slot_start']) ? $booking_details['booking_slot_start'] : "";
            $booking_slot_end = isset($booking_details['booking_slot_end']) ? $booking_details['booking_slot_end'] : "";

              $is_allowed   =  false;
            if($booking_status  == 1 || $booking_status  == 2){

                $is_allowed  =  true;
            }
            
            if($booking_slot_start != ""  && $is_allowed){
                $arr[]  =  $booking_slot_start;
            }
        }
        wp_reset_postdata();
    } 

   return  $arr;
}





add_action('sb_send_booking_status_change_email', 'sb_send_booking_status_change_email_callback', 10, 4);
function sb_send_booking_status_change_email_callback($booking_id = "", $status = "", $extra_details = "" , $video_link = "") {
 
   global $exertio_theme_options;

    $is_email_allowed =  isset($exertio_theme_options['send_booking_status_email']) ? $exertio_theme_options['send_booking_status_email'] : "";
    if ($is_email_allowed && $booking_id != "") { /* either email allowed from theme option and booking id not empty */
        $booking_details = get_post_meta($booking_id, 'booking_details', true);

        $booking_details = json_decode($booking_details, true);

        $booker_name = isset($booking_details['booker_name']) ? $booking_details['booker_name'] : "";
        $booker_email = isset($booking_details['booker_email']) ? $booking_details['booker_email'] : "";
        $booker_phone = isset($booking_details['booker_phone']) ? $booking_details['booker_phone'] : "";
        $booking_slot_start = isset($booking_details['booking_slot_start']) ? $booking_details['booking_slot_start'] : "";
        $booking_slot_end = isset($booking_details['booking_slot_end']) ? $booking_details['booking_slot_end'] : "";
        $booking_date = isset($booking_details['booking_date']) ? $booking_details['booking_date'] : "";
        $booking_month = isset($booking_details['booking_month']) ? $booking_details['booking_month'] : "";
        $booking_day = isset($booking_details['booking_day']) ? $booking_details['booking_day'] : "";
        $booking_ad = isset($booking_details['booking_ad_id']) ? $booking_details['booking_ad_id'] : "";

        $formated_date = "";
        if ($booking_day != "" && $booking_date != "" && $booking_month != "") {
            $formated_date = strtotime($booking_day . $booking_date . $booking_month);
            $formated_date = date(get_option('date_format'), $formated_date);
        }

        $booking_time = $booking_slot_start . "-" . $booking_slot_end;

        $ad_title = get_the_title($booking_ad);
        $ad_link = get_the_permalink($booking_ad);

       

        if ($booker_email != "" && $status == "2") { /* if status is accepted */
            $msg_keywords = array('%customer%', '%booking_date%', '%booking_time%', '%ad_title%', '%ad_link%', '%extra_details%',);
            $msg_replaces = array($booker_name, $formated_date, $booking_time, $ad_title, $ad_link, $extra_details);
            $body = str_replace($msg_keywords, $msg_replaces, $exertio_theme_options['sb_booking_status_approved_message']);
            $subject = isset($exertio_theme_options['send_booking_status_subject']) ? $exertio_theme_options['send_booking_status_subject'] : "Booking info";
            $from = isset($exertio_theme_options['send_booking_status_from']) ? $exertio_theme_options['send_booking_status_from'] : "Booking info";
            $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");         
            wp_mail($booker_email, $subject, $body, $headers);
        } else if ($booker_email != "" && $status == "3") { /* if status is rejected */
            $msg_keywords = array('%customer%', '%booking_date%', '%booking_time%', '%ad_title%', '%ad_link%', '%extra_details%');
            $msg_replaces = array($booker_name, $formated_date, $booking_time, $ad_title, $ad_link, $extra_details);
            $body = str_replace($msg_keywords, $msg_replaces, $exertio_theme_options['sb_booking_status_decline_message']);
            $subject = isset($exertio_theme_options['send_booking_status_subject']) ? $exertio_theme_options['send_booking_status_subject'] : "Booking info";
            $from = isset($exertio_theme_options['send_booking_status_from']) ? $exertio_theme_options['send_booking_status_from'] : "Booking info";
            $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from"); 
            wp_mail($booker_email, $subject, $body, $headers);
        }
    }
}


function init_child_theme_options( $sections ) {
    // Add a new section

     

    $sections[] = array(
        'title' => __('Booking Email Template', 'exertio'),
        'id' => 'sb_listings_settings',
        'desc' => '',
        'icon' => 'el el-adjust-alt',
        'fields' => array(
          
            array(
                'id' => 'send_booking_status_email',
                'type' => 'switch',
                'title' => __('Send email to customer', 'exertio'),
                'desc' => __('Send email to customer when status of booking is changed', 'exertio'),
                'default' => false
            ),
            array(
                'id' => 'send_booking_status_from',
                'type' => 'text',
                'title' => esc_html__('Booking Status change Email FROM', 'exertio'),
                'desc' => esc_html__('FROM: NAME valid@email.com is compulsory as we gave in default.', 'exertio'),
                'default' => 'From: ' . get_bloginfo('name') . ' <' . get_option('admin_email') . '>',
                'required' => array('send_booking_status_email', '=', array('1')),
            ),
            array(
                'id' => 'send_booking_status_subject',
                'type' => 'text',
                'title' => esc_html__('Booking Status subject', 'exertio'),
                'default' => 'Booking Staus info',
                'required' => array('send_booking_status_email', '=', array('1')),
            ),
            array(
                'id' => 'sb_booking_status_approved_message',
                'type' => 'editor',
                'required' => array('send_booking_status_email', '=', array('1')),
                'title' => esc_html__('Booking approved email template', 'exertio'),
                'args' => array(
                    'teeny' => true,
                    'textarea_rows' => 10,
                    'wpautop' => false,
                ),
                'desc' => esc_html__('%customer% , %booking_date% , %booking_time% , %extra_details%  , %ad_title%  ,   %ad_link%  will be translated accordingly.', 'exertio'),
                'default' => '<table class="body" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #f6f6f6; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;"> </td>
<td class="container" style="font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; max-width: 580px; padding: 10px; width: 580px; margin: 0 auto !important;">
<div class="content" style="box-sizing: border-box; display: block; margin: 0 auto; max-width: 580px; padding: 10px;">
<table class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background: #fff; border-radius: 3px; width: 100%;">
<tbody>
<tr>
<td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;">
<table style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
<td class="alert" style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 16px; vertical-align: top; color: #000; font-weight: 500; text-align: center; border-radius: 3px 3px 0 0; background-color: #fff; margin: 0; padding: 20px;" align="center" valign="top" bgcolor="#fff">A Designing and development company</td>
</tr>
<tr>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><span style="font-family: sans-serif; font-weight: normal;">Hello</span><span style="font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;"> <b>%customer%,</b></span></p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">It’s confirmed, we’ll see you on <span style="font-family: "Helvetica Neue"", Helvetica, Arial, sans-serif;"><b>%booking_date%</b></span>  at  <span style="font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;"><b>%booking_time%</b></span>  Thank you for booking. <span style="font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;"> <b>%extra_details%,</b></span></p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">Ad Title: %ad_title%</p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">Ad Link: <a href="%ad_link%">%ad_title%</a></p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><strong>Thanks!</strong></p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">ScriptsBundle</p>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<div class="footer" style="clear: both; padding-top: 10px; text-align: center; width: 100%;">
<table style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td class="content-block powered-by" style="font-family: sans-serif; font-size: 12px; vertical-align: top; color: #999999; text-align: center;"><a style="color: #999999; text-decoration: underline; font-size: 12px; text-align: center;" href="https://themeforest.net/user/scriptsbundle">Scripts Bundle</a>.</td>
</tr>
</tbody>
</table>
</div>
 </div>
</td>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;"> </td>
</tr>
</tbody>
</table>
<p>&nbsp;</p>
&nbsp;',
            ),


            array(
                'id' => 'sb_booking_status_decline_message',
                'type' => 'editor',
                'title' => esc_html__('Booking rejected template', 'exertio'),
                'required' => array('send_booking_status_email', '=', array('1')),
                'args' => array(
                    'teeny' => true,
                    'textarea_rows' => 10,
                    'wpautop' => false,
                ),
                'desc' => esc_html__('%customer% , %booking_date% , %booking_time% , %extra_details%  , %ad_title%  ,   %ad_link%  will be translated accordingly.', 'exertio'),
                                    'default' => '<table class="body" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #f6f6f6; width: 100%;" border="0" cellspacing="0" cellpadding="0">
                    <tbody>
                    <tr>
                    <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;"> </td>
                    <td class="container" style="font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; max-width: 580px; padding: 10px; width: 580px; margin: 0 auto !important;">
                    <div class="content" style="box-sizing: border-box; display: block; margin: 0 auto; max-width: 580px; padding: 10px;">
                    <table class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background: #fff; border-radius: 3px; width: 100%;">
                    <tbody>
                    <tr>
                    <td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;">
                    <table style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" border="0" cellspacing="0" cellpadding="0">
                    <tbody>
                    <tr style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                    <td class="alert" style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 16px; vertical-align: top; color: #000; font-weight: 500; text-align: center; border-radius: 3px 3px 0 0; background-color: #fff; margin: 0; padding: 20px;" align="center" valign="top" bgcolor="#fff">A Designing and development company</td>
                    </tr>
                    <tr>
                    <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">
                    <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><span style="font-family: sans-serif; font-weight: normal;">Hello</span><span style="font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;"> <b>%customer%,</b></span></p>
                    <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">Thank you for asking about  <span style="font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;"><b>%ad_title%</b></span> . We regret to inform you that we cannot be of service to you .  <b>%extra_details%,</b></p>
                    <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"> Ad title : %<span style="font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;"><b>ad_title</b></span>%</p>
                    <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">Ad link  : <a href="%ad_link%">%ad_title%</a></p>
                    <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">For further information contact .</p>
                    <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><strong>Thanks!</strong></p>
                    <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">ScriptsBundle</p>
                    </td>
                    </tr>
                    </tbody>
                    </table>
                    </td>
                    </tr>
                    </tbody>
                    </table>
                    <div class="footer" style="clear: both; padding-top: 10px; text-align: center; width: 100%;">
                    <table style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" border="0" cellspacing="0" cellpadding="0">
                    <tbody>
                    <tr>
                    <td class="content-block powered-by" style="font-family: sans-serif; font-size: 12px; vertical-align: top; color: #999999; text-align: center;"><a style="color: #999999; text-decoration: underline; font-size: 12px; text-align: center;" href="https://themeforest.net/user/scriptsbundle">Scripts Bundle</a>.</td>
                    </tr>
                    </tbody>
                    </table>
                    </div>
                     </div>
                    </td>
                    <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;"> </td>
                    </tr>
                    </tbody>
                    </table>
                    <p>&nbsp;</p>
                    &nbsp;',
            ),



            array(
                'id' => 'send_booking_create_email',
                'type' => 'switch',
                'title' => __('Send Email to Freelancer When Appointment is created', 'exertio'),
                // 'desc' => __('Send email to customer when status of booking is changed', 'exertio'),
                'default' => false
            ),
            array(
                'id' => 'send_booking_create_from',
                'type' => 'text',
                'title' => esc_html__('Booking Create Email FROM', 'exertio'),
                'desc' => esc_html__('FROM: NAME valid@email.com is compulsory as we gave in default.', 'exertio'),
                'default' => 'From: ' . get_bloginfo('name') . ' <' . get_option('admin_email') . '>',
                'required' => array('send_booking_create_email', '=', array('1')),
            ),
            array(
                'id' => 'send_booking_create_subject',
                'type' => 'text',
                'title' => esc_html__('Booking Create subject', 'exertio'),
                'default' => 'Booking Staus info',
                'required' => array('send_booking_create_email', '=', array('1')),
            ),
            array(
                'id' => 'sb_booking_status_create_message',
                'type' => 'editor',
                'required' => array('send_booking_create_email', '=', array('1')),
                'title' => esc_html__('Booking Create email template', 'exertio'),
                'args' => array(
                    'teeny' => true,
                    'textarea_rows' => 10,
                    'wpautop' => false,
                ),
                'desc' => esc_html__('%customer% , %booking_date% , %booking_time% , %extra_details%  , %ad_title%  ,   %ad_link%  will be translated accordingly.', 'exertio'),
                'default' => '<table class="body" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #f6f6f6; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;"> </td>
<td class="container" style="font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; max-width: 580px; padding: 10px; width: 580px; margin: 0 auto !important;">
<div class="content" style="box-sizing: border-box; display: block; margin: 0 auto; max-width: 580px; padding: 10px;">
<table class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background: #fff; border-radius: 3px; width: 100%;">
<tbody>
<tr>
<td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;">
<table style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
<td class="alert" style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 16px; vertical-align: top; color: #000; font-weight: 500; text-align: center; border-radius: 3px 3px 0 0; background-color: #fff; margin: 0; padding: 20px;" align="center" valign="top" bgcolor="#fff">A Designing and development company</td>
</tr>
<tr>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><span style="font-family: sans-serif; font-weight: normal;">Hello</span><span style="font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;"> <b>%customer%,</b></span></p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">It’s confirmed, we’ll see you on <span style="font-family: "Helvetica Neue"", Helvetica, Arial, sans-serif;"><b>%booking_date%</b></span>  at  <span style="font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;"><b>%booking_time%</b></span>  Thank you for booking. <span style="font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;"> <b>%extra_details%,</b></span></p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">Ad Title: %ad_title%</p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">Ad Link: <a href="%ad_link%">%ad_title%</a></p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><strong>Thanks!</strong></p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">ScriptsBundle</p>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<div class="footer" style="clear: both; padding-top: 10px; text-align: center; width: 100%;">
<table style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td class="content-block powered-by" style="font-family: sans-serif; font-size: 12px; vertical-align: top; color: #999999; text-align: center;"><a style="color: #999999; text-decoration: underline; font-size: 12px; text-align: center;" href="https://themeforest.net/user/scriptsbundle">Scripts Bundle</a>.</td>
</tr>
</tbody>
</table>
</div>
 </div>
</td>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;"> </td>
</tr>
</tbody>
</table>
<p>&nbsp;</p>
&nbsp;',
            ),


            array(
                'id' => 'send_booking_cancle_email',
                'type' => 'switch',
                'title' => __('Send email to freelancer when booking is canceled', 'exertio'),
                'desc' => __('Send email to freelancer when status of booking cancle', 'exertio'),
                'default' => false
            ),
            array(
                'id' => 'send_booking_cancle_from',
                'type' => 'text',
                'title' => esc_html__('Booking Cancle FROM', 'exertio'),
                'desc' => esc_html__('FROM: NAME valid@email.com is compulsory as we gave in default.', 'exertio'),
                'default' => 'From: ' . get_bloginfo('name') . ' <' . get_option('admin_email') . '>',
                'required' => array('send_booking_cancle_email', '=', array('1')),
            ),
            array(  
                'id' => 'send_booking_cancle_subject',
                'type' => 'text',
                'title' => esc_html__('Booking Cancle subject', 'exertio'),
                'desc' => esc_html__('Send email to freelancer when appoint is canceled.', 'exertio'),
                'default' => 'Booking Staus info',
                'required' => array('send_booking_cancle_email', '=', array('1')),
            ),

            array(
                'id' => 'sb_booking_status_cancle_message',
                'type' => 'editor',
                'title' => esc_html__('Booking rejected template', 'exertio'),
                'required' => array('send_booking_cancle_email', '=', array('1')),
                'args' => array(
                    'teeny' => true,
                    'textarea_rows' => 10,
                    'wpautop' => false,
                ),
                'desc' => esc_html__('%customer% , %booking_date% , %booking_time% , %extra_details%  , %ad_title%  ,   %ad_link%  will be translated accordingly.', 'exertio'),
                                    'default' => '<table class="body" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #f6f6f6; width: 100%;" border="0" cellspacing="0" cellpadding="0">
                    <tbody>
                    <tr>
                    <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;"> </td>
                    <td class="container" style="font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; max-width: 580px; padding: 10px; width: 580px; margin: 0 auto !important;">
                    <div class="content" style="box-sizing: border-box; display: block; margin: 0 auto; max-width: 580px; padding: 10px;">
                    <table class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background: #fff; border-radius: 3px; width: 100%;">
                    <tbody>
                    <tr>
                    <td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;">
                    <table style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" border="0" cellspacing="0" cellpadding="0">
                    <tbody>
                    <tr style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                    <td class="alert" style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 16px; vertical-align: top; color: #000; font-weight: 500; text-align: center; border-radius: 3px 3px 0 0; background-color: #fff; margin: 0; padding: 20px;" align="center" valign="top" bgcolor="#fff">A Designing and development company</td>
                    </tr>
                    <tr>
                    <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">
                    <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><span style="font-family: sans-serif; font-weight: normal;">Hello</span><span style="font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;"> <b>%customer%,</b></span></p>
                    <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">Thank you for asking about  <span style="font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;"><b>%ad_title%</b></span> . We regret to inform you that we cannot be of service to you .  <b>%extra_details%,</b></p>
                    <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"> Ad title : %<span style="font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;"><b>ad_title</b></span>%</p>
                    <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">Ad link  : <a href="%ad_link%">%ad_title%</a></p>
                    <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">For further information contact .</p>
                    <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><strong>Thanks!</strong></p>
                    <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">ScriptsBundle</p>
                    </td>
                    </tr>
                    </tbody>
                    </table>
                    </td>
                    </tr>
                    </tbody>
                    </table>
                    <div class="footer" style="clear: both; padding-top: 10px; text-align: center; width: 100%;">
                    <table style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" border="0" cellspacing="0" cellpadding="0">
                    <tbody>
                    <tr>
                    <td class="content-block powered-by" style="font-family: sans-serif; font-size: 12px; vertical-align: top; color: #999999; text-align: center;"><a style="color: #999999; text-decoration: underline; font-size: 12px; text-align: center;" href="https://themeforest.net/user/scriptsbundle">Scripts Bundle</a>.</td>
                    </tr>
                    </tbody>
                    </table>
                    </div>
                     </div>
                    </td>
                    <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;"> </td>
                    </tr>
                    </tbody>
                    </table>
                    <p>&nbsp;</p>
                    &nbsp;',
            ),




        )
        );
    return $sections;
}
add_filter('redux/options/exertio_theme_options/sections', 'init_child_theme_options');


if (!function_exists('get_next_posts_link_custom')) {
    function get_next_posts_link_custom($wp_query, $label = null, $max_page = 0) {
        global $paged;

        if (!$max_page)
            $max_page = $wp_query->max_num_pages;

        if (!$paged)
            $paged = 1;

        $nextpage = intval($paged) + 1;

        if (null === $label)
            $label = __('Next Page &raquo;', 'adforest');

        if ($nextpage <= $max_page) {
            /**
             * Filters the anchor tag attributes for the next posts page link.
             *
             * @since 2.7.0
             *
             * @param string $attributes Attributes for the anchor tag.
             */
            $attr = apply_filters('next_posts_link_attributes', '');

            return '<a href="' . next_posts($max_page, false) . "\" $attr>" . preg_replace('/&([^#])(?![a-z]{1,8};)/i', '&#038;$1', $label) . '</a>';
        }
    }

}


<?php
// global $adforest_theme ;
// $allow_events  =  $adforest_theme['allow_event_create']   ?   $adforest_theme['allow_event_create']   : false; 
//   if(!$allow_events){
//       return ;
//   }
  
$order   =   isset($_GET['order_booking'])  ?    $_GET['order_booking']  : "";
$options  =  '<option value ="4"  '.($order == '4' ?  "selected" : "" ).'>'.esc_html__('All Appoinments','adforest') .'</option> 
               <option value ="1" '.($order == '1' ?  "selected" : "" ).'>'.esc_html__('Pending','adforest') .'</option> 
               <option value ="2"  '.($order == '2' ?  "selected" : "" ).'>'.esc_html__('Accepted','adforest') .'</option> 
               <option value ="3" '.($order == '3' ?  "selected" : "" ).'>'.esc_html__('Rejected','adforest') .'</option>
               <option value ="5" '.($order == '5' ?  "selected" : "" ).'>'.esc_html__('Cancelled','adforest') .'</option> ';
                      
?>
<div class="content-wrapper">
    <div class="content">
        <div class="row">
            <div class="content">
                <div class="sb-dash-heading">
                    <h2>
                        <?php echo esc_html__('All Appoinments', 'adforest'); ?>
                    </h2>  
                 
                    <form action="<?php echo get_the_permalink() ."?page_type=all_bookings&"; ?>">  
                   <select name='order_booking'  id ="order_booking">
                               <?php echo $options; ?>
                    </select>
                        <?php echo adforest_search_params('order_booking');?>
                   </form>                
                   
                </div>
                <div class="row">
                    <?php
                    echo apply_filters('sb_get_sent_booking_list', 'publish');
                    ?> 
                </div>
            </div>
        </div>
    </div>
</div>
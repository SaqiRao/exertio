<?php
// global $adforest_theme;
// $allow_events = $adforest_theme['allow_booking_listing'] ? $adforest_theme['allow_booking_listing'] : false;
// if (!$allow_events) {
//     return;
// }

$order = isset($_GET['order_booking']) ? $_GET['order_booking'] : "";
$options = '<option value ="5"  ' . ($order == '5' ? "selected" : "" ) . '>' . esc_html__('All Appoinments', 'adforest') . '</option> 
               <option value ="1" ' . ($order == '1' ? "selected" : "" ) . '>' . esc_html__('Pending', 'adforest') . '</option> 
                    <option value ="2"  ' . ($order == '2' ? "selected" : "" ) . '>' . esc_html__('Accepted', 'adforest') . '</option> 
                        <option value ="3" ' . ($order == '3' ? "selected" : "" ) . '>' . esc_html__('Rejected', 'adforest') . '</option>
                        <option value ="4" ' . ($order == '4' ? "selected" : "" ) . '>' . esc_html__('Cancelled', 'adforest') . '</option> ';
?>
<div class="content-wrapper">
    <div class="card">
         <div class="card-body">
    <div class="content">
        <div class="row">
        <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
            <div class="content">
                <div class="sb-dash-heading">
                    <h2>
                        <?php echo esc_html__('All Appoinments', 'adforest'); ?>
                    </h2>  
                   
                    <form action="<?php echo get_the_permalink() . "?page_type=all_bookings&"; ?>">  
                       
                        <select name='order_booking'  id ="order_booking" class="custom-select2">
                            <?php echo $options; ?>
                        </select>
                        <?php echo adforest_search_params('order_booking'); ?>
                        <!-- <a href="<?php echo get_the_permalink() . "?page_type=bookings_received&makeCsv=yes"; ?>" class="btn btn-theme" >  <?php echo esc_html__('Genrate csv', 'adforest') ?> </a> -->
                            <input type="hidden" value="<?php echo esc_html__('Confirm', 'adforest'); ?>"  id="confirm_btn">
                            <input type="hidden" value="<?php echo esc_html__('Cancel', 'adforest'); ?>" id="cancel_btn">
                            <input type="hidden" value="<?php echo esc_html__('Are you sure ?', 'adforest'); ?>" id="confirm_text">
                    </form>                
                </div>
                <div class="row">
                    <?php
                    echo apply_filters('sb_get_booking_list', 'publish');
                    ?> 
                </div>
            </div>
        </div>
        </div>
    </div>
</div>
</div>
</div>

<?php
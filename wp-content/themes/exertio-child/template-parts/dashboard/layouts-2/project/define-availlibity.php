  <div class="content-wrapper">
       <div class="row">
            <div class="col-md-12 grid-margin">
              <div class="d-flex justify-content-between flex-wrap">
                <div class="d-flex align-items-end flex-wrap">
                  <div class="mr-md-3 mr-xl-5">
                    <h2><?php echo esc_html__('Define your availability', 'exertio_theme'); ?></h2>
                    <div class="d-flex"> <i class="fas fa-home text-muted d-flex align-items-center"></i>
            <p class="text-muted mb-0 hover-cursor">&nbsp;/&nbsp;<?php echo esc_html__('Dashboard', 'exertio_theme'); ?>&nbsp;</p>
            <?php echo exertio_dashboard_extention_return(); ?>
          </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
<form id="fl_bussiness_hours">
  <div class="card">
    <div class="card-body">

<?php
$user_id = get_current_user_id();
$fre_id = get_user_meta($user_id, 'freelancer_id', true);
echo apply_filters('sb_get_business_hous_post', $fre_id);
?>
  <input type="hidden" id="theme_path" value="<?php echo esc_attr(get_stylesheet_directory_uri()); ?>" />
</div>
</div>
</form>
</div>

<!-- Modal HTML -->

<div id="myModal" class="modal">
<div class="modal-content">
<span class="close" data-dismiss="modal" aria-label="Close">&times;</span>
<p>Set Your availability hours</p>
<form id="fl_select_hours">


  </form>
   </div>

  </div>






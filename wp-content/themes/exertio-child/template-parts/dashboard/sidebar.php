<?php
$current_user_id = get_current_user_id();
$pid = get_user_meta( $current_user_id, 'employer_id' , true );
global $exertio_theme_options;

$user_info = get_userdata($current_user_id);
$page_name ='';
if(isset($_GET['ext']) && $_GET['ext'] !="")
{
	$page_name = $_GET['ext'];	
}
$alt_id ='';
?>
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
    <li class="profile ff">
    	<div>
            <span class="pro-img">
            <?php
                $pro_img_id = get_post_meta( $pid, '_profile_pic_attachment_id', true );
                $pro_img = wp_get_attachment_image_src( $pro_img_id, 'thumbnail' );
                

				if(wp_attachment_is_image($pro_img_id))
                {
                    ?>
                    <img src="<?php echo esc_url($pro_img[0]); ?>" alt="<?php echo esc_attr(get_post_meta($pro_img_id, '_wp_attachment_image_alt', TRUE)); ?>" class="img-fluid" loading="lazy">
                    <?php
                }
                else
                {
                    ?>
                    <img src="<?php echo esc_url($exertio_theme_options['employer_df_img']['url']); ?>" alt="<?php echo esc_attr(get_post_meta($alt_id, '_wp_attachment_image_alt', TRUE)); ?>" class="img-fluid" loading="lazy">
                    <?php	
                }
            ?>
            </span>
        </div>
        <h4 class="mt-4"><?php echo exertio_get_username('employer', $pid, 'badge', 'right'); ?></h4>
        <p><?php echo esc_html($user_info->user_email); ?></p>
      </li>
	<?php
       
		 $menu_options_array   =  $exertio_theme_options['employer_dashboard_sidebar_sortable'];

$splitIndex = 6;
$menu_options_array_new = array_merge(
        array_slice($menu_options_array, 0, $splitIndex), 
        array('MeetingCalender' => 'Meetings Calender'), 
        array_slice($menu_options_array, $splitIndex)
);



	    //print_r($exertio_theme_options['employer_dashboard_sidebar_sortable']);
		foreach($menu_options_array_new as $key => $val)
		{
			if($key == 'Dashboard' && $val != "")
			{
			?>
				<li class="nav-item <?php if($page_name == 'dashboard') { echo 'active';} ?>">
					<a class="nav-link" href="<?php echo get_the_permalink();?>">
						<i class="fas fa-home menu-icon"></i>
						<span class="menu-title"><?php echo esc_html($val); ?></span>
					</a>
				</li>
			<?php
			}
			if($key == 'Profile' && $val != "")
			{
			?>
				<li class="nav-item <?php if($page_name == 'edit-profile') { echo 'active';} ?>">
					<a class="nav-link" data-toggle="collapse" aria-expanded="false"  href="#profile" aria-controls="profile">
					  <i class="fas fa-user menu-icon"></i>
					  <span class="menu-title"><?php echo esc_html($val); ?></span>
					  <i class="fas fa-chevron-down menu-arrow"></i>
					</a>
					<div class="collapse <?php if($page_name == 'edit-profile' ){ echo 'show';} ?>" id="profile">
					  <ul class="nav flex-column sub-menu">
						<li class="nav-item <?php if($page_name == 'edit-profile') { echo 'active';} ?>"> <a class="nav-link" href="<?php  echo esc_url(get_permalink($pid)); ?>"> <?php echo esc_html__( 'View Profile', 'exertio_theme' ); ?> </a></li>
						<li class="nav-item"> <a class="nav-link" href="<?php echo esc_url(get_the_permalink());?>?ext=edit-profile"> <?php echo esc_html__( 'Edit Profile', 'exertio_theme' ); ?> </a></li>
					  </ul>
					</div>
				</li>
			<?php
			}
			if($key == 'Projects' && $val != "")
			{
			?>
				<li class="nav-item <?php if($page_name == 'create-project' || $page_name == 'projects' || $page_name == 'ongoing-projects' || $page_name == 'expired-project' || $page_name == 'completed-projects' || $page_name == 'completed-project-detail' || $page_name == 'canceled-projects' || $page_name == 'pending-projects' || $page_name == 'project-propsals' || $page_name == 'ongoing-project' || $page_name == 'ongoing-project-detail' || $page_name == 'ongoing-project-proposals') { echo 'active';} ?>">
					<a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
					  <i class="fas fa-briefcase menu-icon"></i>
					  <span class="menu-title"><?php echo esc_html($val); ?></span>
					  <i class="fas fa-chevron-down menu-arrow"></i>
					</a>
					<div class="collapse <?php if($page_name == 'create-project' || $page_name == 'projects' || $page_name == 'expired-project' || $page_name == 'ongoing-projects' || $page_name == 'completed-projects' ||  $page_name == 'completed-project-detail' ||  $page_name == 'canceled-projects' || $page_name == 'pending-projects' || $page_name == 'project-propsals' || $page_name == 'ongoing-project' || $page_name == 'ongoing-project-detail' || $page_name == 'ongoing-project-proposals') { echo 'show';} ?>" id="ui-basic">
					  <ul class="nav flex-column sub-menu">
						<li class="nav-item <?php if($page_name == 'create-project') { echo 'active';} ?>"> <a class="nav-link" href="<?php echo esc_url(get_the_permalink());?>?ext=create-project"><?php echo esc_html__( 'Create Project', 'exertio_theme' ); ?></a></li>
						<li class="nav-item <?php if($page_name == 'projects') { echo 'active';} ?>"> <a class="nav-link" href="<?php echo esc_url(get_the_permalink());?>?ext=projects"><?php echo esc_html__( 'Posted Projects', 'exertio_theme' ); ?></a></li>
						<li class="nav-item <?php if($page_name == 'pending-projects') { echo 'active';} ?>"> <a class="nav-link" href="<?php echo esc_url(get_the_permalink());?>?ext=pending-projects"><?php echo esc_html__( 'Pending Projects', 'exertio_theme' ); ?></a></li>
						<li class="nav-item <?php if($page_name == 'ongoing-project') { echo 'active';} ?>"> <a class="nav-link" href="<?php echo esc_url(get_the_permalink());?>?ext=ongoing-project"><?php echo esc_html__( 'Ongoing Project', 'exertio_theme' ); ?></a></li>
                        <li class="nav-item <?php if($page_name == 'expired-project') { echo 'active';} ?>"> <a class="nav-link" href="<?php echo esc_url(get_the_permalink());?>?ext=expired-project"><?php echo esc_html__( 'Expired Project', 'exertio_theme' ); ?></a></li>
                        <li class="nav-item <?php if($page_name == 'completed-projects') { echo 'active';} ?>"> <a class="nav-link" href="<?php echo esc_url(get_the_permalink());?>?ext=completed-projects"><?php echo esc_html__( 'Completed Projects', 'exertio_theme' ); ?></a></li>
						<li class="nav-item <?php if($page_name == 'canceled-projects') { echo 'active';} ?>"> <a class="nav-link" href="<?php echo esc_url(get_the_permalink());?>?ext=canceled-projects"><?php echo esc_html__( 'canceled Projects', 'exertio_theme' ); ?></a></li>
                      </ul>
					</div>
				</li>
			<?php
			}	
			if($key == 'MeetingCalender' && $val != "")
			{
				?>
				<li class="nav-item <?php if($page_name == 'emp-meeting-manage' ) { echo 'active';} ?>">
					<a class="nav-link" data-toggle="collapse" href="#meetings-calender" aria-expanded="false" aria-controls="meetings-calender">
					  <i class="fas fa-user menu-icon"></i>
					  <span class="menu-title"><?php echo esc_html($val); ?></span>
					  <i class="fas fa-chevron-down menu-arrow"></i>
					</a>
				<div class="collapse <?php if($page_name == 'emp-meeting-manage'  ){ echo 'show';} ?>" id="meetings-calender">
					  <ul class="nav flex-column sub-menu">
					  	<!-- <li class="nav-item  <?php if($page_name == 'booking-colander') { echo 'active';} ?>"> <a class="nav-link" href="<?php echo esc_url(get_the_permalink());?>?ext=booking-colander"> <?php echo esc_html__( 'Booking Calender', 'exertio_theme' ); ?> 
					</a></li> -->
						<li class="nav-item  <?php if($page_name == 'emp-meeting-manage') { echo 'active';} ?>"> <a class="nav-link" href="<?php echo esc_url(get_the_permalink());?>?ext=emp-meeting-manage"> <?php echo esc_html__( 'Manage Existing Meeting', 'exertio_theme' ); ?> 
					</a></li>
					
					  </ul>
					</div>
				
				</li>
				<?php
			}
			if($key == 'Services' && $val != "")
			{
			?>
				<li class="nav-item <?php if($page_name == 'ongoing-services' || $page_name == 'ongoing-service-detail' || $page_name == 'completed-services' || $page_name == 'completed-service-detail' || $page_name == 'canceled-services' || $page_name == 'canceled-service-detail') { echo 'active'; }?>">
					<a class="nav-link" data-toggle="collapse" href="#services" aria-expanded="false" aria-controls="services">
					  <i class="fas fa-user-cog menu-icon"></i>
					  <span class="menu-title"><?php echo esc_html($val); ?></span>
					  <i class="fas fa-chevron-down menu-arrow"></i>
					</a>
					<div class="collapse <?php if($page_name == 'ongoing-services' || $page_name == 'ongoing-service-detail' || $page_name == 'completed-services' || $page_name == 'completed-service-detail' || $page_name == 'canceled-services' || $page_name == 'canceled-service-detail') { echo 'show';}?>" id="services">
					  <ul class="nav flex-column sub-menu">
						<li class="nav-item <?php if($page_name == 'ongoing-services') { echo 'active';} ?>"> <a class="nav-link" href="<?php echo esc_url(get_the_permalink());?>?ext=ongoing-services"><?php echo esc_html__( 'Ongoing Services', 'exertio_theme' ); ?> </a></li>
						<li class="nav-item <?php if($page_name == 'completed-services') { echo 'active';} ?>"> <a class="nav-link" href="<?php echo esc_url(get_the_permalink());?>?ext=completed-services"><?php echo esc_html__( 'Completed Services', 'exertio_theme' ); ?> </a></li>
						<li class="nav-item <?php if($page_name == 'canceled-services') { echo 'active';} ?>"> <a class="nav-link" href="<?php echo esc_url(get_the_permalink());?>?ext=canceled-services"><?php echo esc_html__( 'Canceled Services', 'exertio_theme' ); ?> </a></li>
					  </ul>
					</div>
				</li>
			<?php
			}

			
			if($key == 'ChatDashboard' && $val != "")
			{
				if(in_array('whizz-chat/whizz-chat.php', apply_filters('active_plugins', get_option('active_plugins'))))
				{
					global $whizzChat_options;
					$dashboard_page = isset($whizzChat_options['whizzChat-dashboard-page']) && $whizzChat_options['whizzChat-dashboard-page'] != '' ? $whizzChat_options['whizzChat-dashboard-page'] : 'javascript:void(0)';
					if ($dashboard_page != '')
					{
						?>
						<li class="nav-item">
							<a class="nav-link" href="<?php echo esc_url(get_permalink($dashboard_page));?>" target="_blank">
							  <i class="fas fa-comments menu-icon"></i>
							  <span class="menu-title"><?php echo esc_html($val); ?></span>
							</a>
						</li>
						<?php
					}
				}
			}
			if($key == 'SavedServices' && $val != "")
			{
			?>
				<li class="nav-item <?php if($page_name == 'saved-services') { echo 'active';} ?>">
					<a class="nav-link" href="<?php echo esc_url(get_the_permalink());?>?ext=saved-services">
					  <i class="far fa-bookmark menu-icon"></i>
					  <span class="menu-title"><?php echo esc_html($val); ?></span>
					</a>
				</li>
			<?php
			}
			if($key == 'FollowedFreelancers' && $val != "")
			{
			?>
			<li class="nav-item <?php if($page_name == 'followed-freelancers') { echo 'active';} ?>">
				<a class="nav-link" href="<?php echo esc_url(get_the_permalink());?>?ext=followed-freelancers">
				  <i class="fas fa-share menu-icon"></i>
				  <span class="menu-title"><?php echo esc_html($val); ?></span>
				</a>
			</li>
			<?php
			}
			if($key == 'FundDepositInvoices' && $val != "")
			{
			?>
				<li class="nav-item <?php if($page_name == 'invoices') { echo 'active';} ?>">
					<a class="nav-link" href="<?php echo esc_url(get_the_permalink());?>?ext=invoices">
					  <i class="fas fa-receipt menu-icon"></i>
					  <span class="menu-title"><?php echo esc_html($val); ?></span>
					</a>
				</li>
			<?php
			}

			if($key == 'MeetingSettings' && $val != "")
			{
			?>
				<li class="nav-item <?php if($page_name == 'meetings-settings') { echo 'active';} ?>">
					<a class="nav-link" data-toggle="collapse" aria-expanded="false"  href="#meeting" aria-controls="meeting">
					  <i class="fas fa-user menu-icon"></i>
					  <span class="menu-title"><?php echo esc_html($val); ?></span>
					  <i class="fas fa-chevron-down menu-arrow"></i>
					</a>
					<div class="collapse <?php if($page_name == 'meetings-settings' ){ echo 'show';} ?>" id="meeting">
					  <ul class="nav flex-column sub-menu">
						<li class="nav-item <?php if($page_name == 'all-meetings') { echo 'active';} ?>"> <a class="nav-link" href="<?php echo esc_url(get_the_permalink());?>?ext=meetings-settings"> <?php echo esc_html__( 'Meetings Settings', 'exertio_theme' ); ?> </a></li>
						<li class="nav-item"> <a class="nav-link" href="<?php echo esc_url(get_the_permalink());?>?ext=all-meetings"> <?php echo esc_html__( 'All Meetings', 'exertio_theme' ); ?> </a></li>
					  </ul>
					</div>
				</li>
			<?php
			}
			if($key == 'Disputes' && $val != "")
			{
			?>
				<li class="nav-item <?php if($page_name == 'disputes') { echo 'active';} ?>">
					<a class="nav-link" href="<?php echo esc_url(get_the_permalink());?>?ext=disputes">
					  <i class="fas fa-shield-alt menu-icon"></i>
					  <span class="menu-title"><?php echo esc_html($val); ?></span>
					</a>
				</li>
			<?php
			}
			if($key == 'VerifyIdentity' && $val != "")
			{
			?>
			<li class="nav-item <?php if($page_name == 'identity-verification') { echo 'active';} ?>">
				<a class="nav-link" href="<?php echo esc_url(get_the_permalink());?>?ext=identity-verification">
					<i class="fas fa-user-shield menu-icon"></i>
					<span class="menu-title"><?php echo esc_html($val); ?></span>
				</a>
			</li>
			<?php
			}
			if($key == 'Statements' && $val != "")
			{
			?>
			<li class="nav-item <?php if($page_name == 'statements') { echo 'active';} ?>">
				<a class="nav-link" href="<?php echo esc_url(get_the_permalink());?>?ext=statements">
					<i class="far fa-list-alt menu-icon"></i>
					<span class="menu-title"><?php echo esc_html($val); ?></span>
				</a>
			</li>
			<?php
			}
			if($key == 'Logout' && $val != "")
			{
			?>
				<li class="nav-item">
					<a class="nav-link" href="<?php echo wp_logout_url( get_the_permalink( $exertio_theme_options['login_page'] ) ); ?>">
					  <i class="fas fa-sign-out-alt menu-icon"></i>
					  <span class="menu-title"><?php echo esc_html($val); ?></span>
					</a>
				</li>
			<?php
			}
		}
		?>
    </ul>
</nav>
          
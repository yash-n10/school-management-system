<?php
$login_type = $this->session->userdata('login_type');
        $user_id = $this->session->userdata($login_type.'_id');
	if(isset($results) && !empty($results)) :
            
?>
	<div id="body_msg">
<?php
		foreach($results as $result) :
			if($result->user_id == $user_id) :

				$class  = 'outbox';
				$user   = 'Me';
				$photo  = base_url().'/template/images/parent.png';;
				$arrow  = 'right_arrow_msg';
				$silver = 'silver';

			else :

				$class  = 'inbox';
				$user   = $result->tname;
				$photo  = base_url().'/template/images/teacher.png';
				$arrow  = 'left_arrow_msg';
				$silver = '';

			endif;
?>
			<div class="<?php echo $class; ?> msg clearfix">
				<a class="msgbox-user-img">
					<img src="<?php echo $photo;?>" class="user-list-image" style="position: static;">
				</a>
				<div id="<?php echo $arrow; ?>"></div>
				<div class="msg_area">
					<h2 class="user_name <?php echo $silver; ?>"><?php echo $user; ?></h2>
					<span class="msg_body pull-left <?php echo $silver; ?>"><?php echo  $result->enquiry ; ?></span> 
					<span class="time_msg <?php echo $silver; ?>"><?php echo $result->tine ? date('M d, Y', $result->time).' at '. date('h:i A', $result->time): ''?></span>
					<div class="clearfix"></div>
				</div>
			</div>
<?php
		endforeach;
?>
		</div>
<?php
	endif;
?>

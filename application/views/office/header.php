<style>
  @import url(http://fonts.googleapis.com/css?family=Black+Ops+One);
  #time {
			color:#fa6800;
			font-family: 'Black Ops One', cursive;
			font-size: 25px;
			letter-spacing:2px;
			//padding:10px 0 0 10px;
		}
  </style>
<div id="custom-tam-overlay">
	<img src="<?php echo base_url();?>template/images/ajax-loader.gif" alt="" />
</div>  
<div class="navbar navbar-top navbar-inverse">
	<div class="navbar-inner" id="tam-custom-navbar-top">
		<div class="container-fluid">
			<a class="brand" href="<?php echo base_url();?>"><?php echo $system_name;?>
			</a>
            <ul class="nav">
                <li id="time"></li>
			</ul>
			<!-- the new toggle buttons -->
			<ul class="nav pull-right">
				<li class="toggle-primary-sidebar hidden-desktop" data-toggle="collapse" data-target=".nav-collapse-primary"><button type="button" class="btn btn-navbar"><i class="icon-th-list"></i></button></li>
				<li class="hidden-desktop" data-toggle="collapse" data-target=".nav-collapse-top"><button type="button" class="btn btn-navbar"><i class="icon-align-justify"></i></button></li>
			</ul>
			<div class="nav-collapse nav-collapse-top collapse" id="custom-tam-profile-menu">
            	<ul class="nav pull-right">
					<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-user"></i> Hi, <?php echo get_phrase($this->session->userdata('login_type'));?> <?php //echo get_phrase('account');?> <b class="caret"></b></a>
					<!-- Account Selector -->
                    <ul class="dropdown-menu">
                    	<!--<li class="with-image">
                            <div class="avatar">
                                <img src="<?php // echo base_url();?>template/images/icons_big/<?php // echo $this->session->userdata('login_type');?>.png" class="avatar-medium"/>
                            </div>
                            <span><?php //echo $this->session->userdata('name');?></span>
                        </li>
                    	<li class="divider"></li>-->
                        
                        <?php
							if ($this->session->userdata('login_type')	==	'parent')
								$account_type	=	'parents';
							else
								$account_type	=	$this->session->userdata('login_type');
						?>
						<li><a href="<?php echo base_url();?><?php echo $account_type;?>/manage_profile">
                        		<i class="icon-user"></i><span><?php echo get_phrase('profile');?></span></a></li>
                        <li><a href="<?php echo base_url();?><?php echo $account_type;?>/manage_profile">
                        		<i class="icon-lock"></i><span><?php echo get_phrase('change_password');?></span></a></li>
						<li><a href="<?php echo base_url();?>login/logout">
                        		<i class="icon-off"></i><span><?php echo get_phrase('logout');?></span></a></li>
					</ul>
                	<!-- Account Selector -->
					</li>
				</ul>
				
				<ul class="nav pull-right">
					<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">Select Language <b class="caret"></b></a>
					<!-- Language Selector -->
                        <ul class="dropdown-menu">
                            <?php
                            $fields = $this->db->list_fields('language');
                            foreach ($fields as $field)
                            {
                                if($field == 'phrase_id' || $field == 'phrase')continue;
                                ?>
                                    <li>
                                        <a href="<?php echo base_url();?>multilanguage/select_language/<?php echo $field;?>">
                                            <?php  echo $field;?>
                                            <?php //selecting current language
                                                if($this->session->userdata('current_language') == $field):?>
                                                    <i class="icon-ok"></i>
                                            <?php endif;?>
                                        </a>
                                    </li>
                                <?php
                            }
                            ?>
                        </ul>
                	<!-- Language Selector -->
					</li>
				</ul>
                         
                    <?php if(get_phrase($this->session->userdata('login_type')) == 'Admin'):?>        
                  <ul class="nav pull-right">
					<li class="dropdown">
					<a href="<?php echo base_url();?><?php echo $account_type;?>/email" ><i class="icon-envelope"></i><span class="badge badge-important">
                                <span id="ctl00_lbl_unread"><?php echo isset($admin_message)?$admin_message:'0';?></span>
                            </span><?php //echo 'Email' ;?> </a>
					</li>
                </ul>
                <ul class="nav pull-right">
                            <li class="dropdown">
                            <a href="<?php echo base_url();?><?php echo $account_type;?>/tasks" ><i class="icon-bell"></i><span class="badge badge-important">
                                <span id="ctl00_lbl_unread"><?php $tcount = gettaskscount(); echo isset($tcount)?$tcount:'0';?></span>
                            </span><?php //echo gettaskscount() ;?> </a>
                            </li>
                     </ul>  
                <?php elseif(get_phrase($this->session->userdata('login_type')) == 'Parent'): ?>
                    <ul class="nav pull-right">
                            <li class="dropdown">
                            <a href="<?php echo base_url();?><?php echo $account_type;?>/email" ><i class="icon-envelope"></i><span class="badge badge-important">
                                <span id="ctl00_lbl_unread"><?php echo isset($parent_message)?$parent_message:'0';?></span>
                            </span><?php //echo 'Email' ;?> </a>
                            </li>
                     </ul>
              <?php elseif(get_phrase($this->session->userdata('login_type')) == 'Student'):?>
                     <ul class="nav pull-right">
                            <li class="dropdown">
                            <a href="<?php echo base_url();?><?php echo $account_type;?>/email" ><i class="icon-envelope"></i><span class="badge badge-important">
                                <span id="ctl00_lbl_unread"><?php echo isset($student_message)?$student_message:'0';?></span>
                            </span><?php //echo 'Email' ;?> </a>
                            </li>
                     </ul>  
                     <ul class="nav pull-right">
                            <li class="dropdown">
                            <a href="<?php echo base_url();?><?php echo $account_type;?>/tasks" ><i class="icon-bell"></i><span class="badge badge-important">
                                <span id="ctl00_lbl_unread"><?php $tcount = gettaskscount(); echo isset($tcount)?$tcount:'0';?></span>
                            </span><?php //echo gettaskscount() ;?> </a>
                            </li>
                     </ul>  
                            
              <?php elseif(get_phrase($this->session->userdata('login_type')) == 'Teacher'):?>
                     <ul class="nav pull-right">
                            <li class="dropdown">
                            <a href="<?php echo base_url();?><?php echo $account_type;?>/email" ><i class="icon-envelope"></i><span class="badge badge-important">
                                <span id="ctl00_lbl_unread"><?php echo isset($teacher_message)?$teacher_message:'0' ?></span>
                            </span><?php //echo 'Email' ;?> </a>
                            </li>
                     </ul>
              <?php  endif; ?>
                 <ul class="nav pull-right">
					<!--<li class="dropdown">
					<a href="#" ><i class="icon-user"></i><?php echo get_phrase($this->session->userdata('login_type')).' '.get_phrase('panel');?> </a>
					</li>-->
                </ul>
                 
			</div>
		</div>
	</div>
</div>
 <?php if(get_phrase($this->session->userdata('login_type')) == 'Admin'):?> 
<div id="custom-tam-suport-bck">
<i class="icon-question-sign"></i> Submit Ticket
</div>
<?php  endif; ?>
<script>
$('#custom-tam-suport-bck').on('click',function(e){
	 e.preventDefault();
	 
	 $('#custom-tam-model-ticket').modal('show');
	
});

	startTime();
        function startTime()
        {
            var today=new Date();
            var h=today.getHours();
            var m=today.getMinutes();
            var s=today.getSeconds();
            // add a zero in front of numbers<10
            m=checkTime(m);
            s=checkTime(s);
            document.getElementById('time').innerHTML=h+":"+m+":"+s;
            t=setTimeout(function(){startTime()},500);
        }

        function checkTime(i)
        {
            if (i<10)
            {
                i="0" + i;
            }
            return i;
        }
    </script>
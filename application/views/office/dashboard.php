	<div id="custom-tam-office-dashboard">
    
    	<!--<div class="row-fulid">
        
        	<div class="span2">
            	
                	<div class="custom-tam-widjet custom-odd">
                    
                    	<div><i class="icon-user"></i></div>
                        <div>2323</div>
                    	<div>Students</div>
                        
                    </div>
            
            </div>
            <div class="span2">
            	
                	<div class="custom-tam-widjet custom-even">
                    	
                        <div><i class="icon-user"></i></div>
                        <div>0123</div>
                    	<div>Teachers</div>
                    
                    </div>
            
            </div>
            <div class="span2">
            	
                	<div class="custom-tam-widjet custom-odd">
                    	
                        <div><i class="icon-user"></i></div>
                        <div>4567</div>
                    	<div>Daily Attendence</div>
                    
                    </div>
            
            </div>
            <div class="span2">
            	
                	<div class="custom-tam-widjet custom-even">
                    
                    	<div><i class="icon-user"></i></div>
                        <div>9999</div>
                    	<div>Classes</div>
                    
                    </div>
            
            </div>
            <div class="span2">
            	
                	<div class="custom-tam-widjet custom-odd">
                    
                    	<div><i class="icon-user"></i></div>
                        <div>4747</div>
                    	<div>Books</div>
                    
                    </div>
            
            </div>
        
        </div>-->
    		<div class="row-fluid">
			<div class="span30">
				<!-- find me in partials/action_nav_normal -->
				<!--big normal buttons-->
				<div class="action-nav-normal">
                	<div id="cstm-dboard-main-blk">
					<a href="<?php echo base_url();?>office/student">
                                <div class="cstm-dboard-blck bg-deep-green">                               
                                	<div><i class="fa fa-user fa-4x"></i></div>
                                	<div><?php echo get_phrase('student_admission');?></div>
                                </div>
                                </a>
					<a href="<?php echo base_url();?>office/teacher">
                                <div class="cstm-dboard-blck bg-deep-terques">
                                	<div><i class="fa fa-users fa-4x"></i></div>
                                	<div><?php echo get_phrase('teaching_staff');?></div>
                                </div>
                                </a>
                                
                            		<a href="<?php echo base_url();?>office/staff">
                            	<div class="cstm-dboard-blck bg-light-purple">
                                	<div><i class="fa fa-users fa-4x"></i></div>
                                	<div><?php echo get_phrase('non_teaching_staff');?></div>
                                </div>
                                </a>
                           
					
						
						<!--<div class="span2 ">
							<a href="<?php echo base_url();?>office/class_routine">
							<img src="http://www.schoolbookpro.com/tamimages/adminimages/routine.png" height="80px" width="80px"/><br />
							<span><?php echo get_phrase('class_routine');?></span>
							</a>
						</div>-->
						<a href="<?php echo base_url();?>office/feecollect">
                            	<div class="cstm-dboard-blck bg-deep-thistle">
                                	<div><i class="fa fa-money fa-4x"></i></div>
                                	<div><?php echo get_phrase('payment');?></div>
                                </div>
                           		</a>
			
						<!--<div class="span2 ">
							<a href="<?php echo base_url();?>office/book">
							<img src="http://www.schoolbookpro.com/tamimages/adminimages/book.png" height="80px" width="80px"/><br />
							<span><?php echo get_phrase('library');?></span>
							</a>
						</div>-->
                    
                    <div class="row-fluid">
						<!---<div class="span2 ">
							<a href="<?php echo base_url();?>office/dormitory">
							<img src="http://www.schoolbookpro.com/tamimages/adminimages/dormitory.png" height="80px" width="80px"/><br />
							<span><?php echo get_phrase('dormitory');?></span>
							</a>
						</div>
						<div class="span2 ">
							<a href="<?php echo base_url();?>office/transport">
							<img src="http://www.schoolbookpro.com/tamimages/adminimages/transport.png" height="80px" width="80px"/><br />
							<span><?php echo get_phrase('transport');?></span>
							</a>
						</div>
						<div class="span2 ">
							<a href="<?php echo base_url();?>office/marks">
							<img src="http://www.schoolbookpro.com/tamimages/adminimages/marks.png" height="80px" width="80px"/><br />
							<span><?php echo get_phrase('Marks');?></span>
							</a>
						</div>-->
						<!--<div class="span2 ">
							<a href="<?php echo base_url();?>office/system_settings">
							<img src="<?php echo base_url();?>template/images/icons/settings.png" height="80px" width="80px"/><br />
							<span><?php echo get_phrase('settings');?></span>
							</a>
						</div>
						<div class="span2 ">
							<a href="<?php echo base_url();?>office/manage_language">
							<img src="<?php echo base_url();?>template/images/icons/language.png" height="80px" width="80px"/><br />
							<span><?php echo get_phrase('language');?></span>
							</a>
						</div>
						<div class="span2 ">
							<a href="<?php echo base_url();?>office/backup_restore">
							<img src="<?php echo base_url();?>template/images/icons/backup.png" height="80px" width="80px"/><br />
							<span><?php echo get_phrase('backup');?></span>
							</a>
						</div>-->
                        
						<!--<div class="span2 ">
							<a href="<?php //echo base_url();?>office/parent">
							<img src="<?php //echo base_url();?>template/images/icons/parent.png" height="80px" width="80px"/><br />
							<span><?php //echo get_phrase('Parent');?></span>
							</a>
						</div>
						<div class="span2 ">
							<a href="<?php echo base_url();?>office/sms_view">
							<img src="http://www.schoolbookpro.com/tamimages/adminimages/sms.png" height="80px" width="80px"/><br />
							<span><?php echo get_phrase('SMS');?></span>
							</a>
						</div>

						
                                                <div class="span2 ">
							<a href="<?php echo base_url();?>office/email">
							<img src="http://www.schoolbookpro.com/tamimages/adminimages/mail.png" height="80px" width="80px"/><br />
							<span><?php echo get_phrase('email');?></span>
							</a>
						</div>-->
						
						<!--<div class="span2">
							<a href="<?php echo base_url();?>office/frontdeskenquiry">
                            <img src="http://www.schoolbookpro.com/tamimages/adminimages/frontdesk.png" height="80px" width="80px"/><br />
							<span><?php echo get_phrase('frontdesk_help');?></span>
                            
							</a>
						</div>
						<div class="span2">
							<a href="<?php echo base_url();?>office/tasks">
                            <img src="http://www.schoolbookpro.com/tamimages/adminimages/things-icon.png" height="80px" width="80px"/><br />
							<span><?php echo get_phrase('things_todo');?></span>
                            
							</a>
						</div>-->
                                                
						
					</div><br />
					
					<div class="row-fluid">
						
						
						
						<!--<div class="span2 ">
							<a href="<?php echo base_url();?>office/ebooks">
							<img src="<?php echo base_url();?>template/images/icons/ebooks.png" height="80px" width="80px"/><br />
							<span><?php echo get_phrase('E-Books Online');?></span>
							</a>
						</div>-->
						<!--<div class="span2 ">
							<a href="<?php echo base_url();?>office/previousquestionpapers">
							<img src="http://www.schoolbookpro.com/tamimages/adminimages/Help-icon.png" height="80px" width="80px"/><br />
							<span><?php echo get_phrase('Previous Question Papers');?></span>
							</a>
						</div>
						
						<div class="span2 ">
                            <a href="<?php echo base_url();?>office/onlinetest">
                            <img src="http://www.schoolbookpro.com/tamimages/adminimages/EC_Candidate.png" height="80px" width="80px"/><br />
                            <span><?php echo get_phrase('Online Test');?></span>
							</a>
						</div>
						<div class="span2 ">
							<a href="<?php echo base_url();?>office/daily_attendence">
							<img src="http://www.schoolbookpro.com/tamimages/adminimages/attendence.png" height="80px" width="80px"/><br />
							<span><?php echo get_phrase('student_daily attendence');?></span>
							</a>
						</div>-->
						<!--<div class="span2 ">
							<a href="<?php echo base_url();?>office/attendence">
							<img src="http://www.schoolbookpro.com/tamimages/adminimages/attendence.png" height="80px" width="80px"/><br />
							<span><?php echo get_phrase('monthly attendance');?></span>
							</a>
						</div>-->
						
						<!--<div class="span2 ">
							<a href="<?php echo base_url();?>office/staffattendence">
							<img src="http://www.schoolbookpro.com/tamimages/adminimages/attendence.png" height="80px" width="80px"/><br />
							<span><?php echo get_phrase('staff_daily_attendence ');?></span>
							</a>
						</div>
                        
                        
						<div class="span2 ">
							<a href="<?php echo base_url();?>office/placements">
							<img src="http://www.schoolbookpro.com/tamimages/student/placements.png" height="80px" width="80px"/><br />
							<span><?php echo get_phrase('placements ');?></span>
							</a>
						</div>
						<div class="span2 ">
							<a href="<?php echo base_url();?>office/mailsms">
							<img src="http://www.schoolbookpro.com/tamimages/adminimages/send-sms.png" height="80px" width="80px"/><br />
							<span><?php echo get_phrase('SMS');?></span>
							</a>
						</div>-->
						
					
                   
              
                   
				</div>
			</div>
            <!---DASHBOARD MENU BAR ENDS HERE-->
       </div>
       
       <br><br><br><br><br>
       
       
		<div class="row-fluid">
            <!--<div class="span6">
				<div class="box" style="border-style: solid;border-width: 3px;border-color:#1E2529">
					<div class="box-header">
						<div class="title">
                        	<i class="icon-calendar"></i>
							<?php //echo get_phrase('calendar_schedule');?>
						</div>
					</div>
					<div class="box-content">
						<div id="calendar2">
						</div>
					</div>
				</div>
			</div>-->
            <!---CALENDAR ENDS-->
            
            <!---TO DO LIST STARTS-->
			<div class="span6">
				<div class="box tam-custom-noticeboard">
					<div class="box-header">
						<span class="title">
                        	<!--<i class="icon-reorder"></i>-->
                            <?php echo get_phrase('noticeboard');?>
                        </span>
					</div>
					<div class="box-content scrollable" style="max-height: 500px; overflow-y: auto">
                    
                    	<?php 
						$this->db->order_by('create_timestamp',desc);
						$this->db->limit('5');
						$notices	=	$this->db->get('noticeboard')->result_array();
						foreach($notices as $row):
						?>
						<div class="box-section news with-icons">
							<div class="avatar">
								<!--<img src="<?php echo base_url();?>template/images/icons/notification.png" height="25px" width="25px" alt="" />-->
                                <i class="icon-bullhorn"></i>
                                
							</div>
							<div class="news-time">
								<span><?php echo date('d',$row['create_timestamp']);?></span> <?php echo date('M',$row['create_timestamp']);?>
							</div>
							<div class="news-content">
								<div class="news-title">
									<?php echo $row['notice_title'];?>
								</div>
								<div class="news-text">
									 <?php echo $row['notice'];?>
								</div>
							</div>
						</div>
						<?php endforeach;?>
					</div>
				</div>
			</div>
            <!---TO DO LIST ENDS-->
			
			<!---TO DO LIST STARTS-->
			<div class="span6">
				<div class="box tam-custom-noticeboard">
					<div class="box-header">
						<span class="title">
                        	<!--<i class="icon-reorder"></i>-->
                            <?php echo get_phrase('class wise student notices/staff notices');?>
                        </span>
					</div>
					<div class="box-content scrollable" style="max-height: 500px; overflow-y: auto">
                    
                    	<?php 
						$this->db->order_by('create_timestamp',desc);
						$this->db->limit('5');
						$notices	=	$this->db->get('noticeboard')->result_array();
						foreach($notices as $row):
						?>
						<div class="box-section news with-icons">
							<div class="avatar">
								<!--<img src="<?php echo base_url();?>template/images/icons/notification.png" height="25px" width="25px" alt="" />-->
                                <i class="icon-bullhorn"></i>
                                
							</div>
							<div class="news-time">
								<span><?php echo date('d',$row['create_timestamp']);?></span> <?php echo date('M',$row['create_timestamp']);?>
							</div>
							<div class="news-content">
								<div class="news-title">
									<?php echo $row['notice_title'];?>
								</div>
								<div class="news-text">
									 <?php echo $row['notice'];?>
								</div>
							</div>
						</div>
						<?php endforeach;?>
					</div>
				</div>
			</div>
       </div>
   </div>
   
  
  <script>
  $(document).ready(function() {

    // page is now ready, initialize the calendar...

    $("#calendar2").fullCalendar({
            header: {
                left: "prev,next",
                center: "title",
                right: "month,agendaWeek,agendaDay"
            },
            editable: 0,
            droppable: 0,
            /*drop: function (e, t) {
                var n, r;
                r = $(this).data("eventObject"), n = $.extend({}, r), n.start = e, n.allDay = t, $("#calendar").fullCalendar("renderEvent", n, !0);
                if ($("#drop-remove").is(":checked")) return $(this).remove()
            },
			
			nulled by Vokey*/
            events: [
			<?php 
			$notices	=	$this->db->get('noticeboard')->result_array();
			foreach($notices as $row):
			?>
			{
                title: "<?php echo $row['notice_title'];?>",
                start: new Date(<?php echo date('Y',$row['create_timestamp']);?>, <?php echo date('m',$row['create_timestamp'])-1;?>, <?php echo date('d',$row['create_timestamp']);?>),
				end:	new Date(<?php echo date('Y',$row['create_timestamp']);?>, <?php echo date('m',$row['create_timestamp'])-1;?>, <?php echo date('d',$row['create_timestamp']);?>) 
            },
			<?php 
			endforeach
			?>
			]
        })

});
  </script>
<div class="row-fluid">
			<div class="span30">
				<!-- find me in partials/action_nav_normal -->
				<!--big normal buttons-->
				<div class="action-nav-normal">
            					<div id="cstm-dboard-main-blk">
						<a href="<?php echo base_url();?>teacher/student">
                                <div class="cstm-dboard-blck bg-deep-green">
                                
                                	<div><i class="fa fa-user fa-4x"></i></div>
                                	<div><?php echo get_phrase('manage_student');?></div>
                                </div>
                                </a>
					<!--<div class="span2">
							<a href="<?php //echo base_url();?>teacher/teacher_list">
							<img src="<?php //echo base_url();?>template/images/icons/teacher.png" height="80px" width="80px"/><br />
							<span><?php //echo get_phrase('manage_teacher');?></span>
                            
							</a>
						</div>-->
						<a href="<?php echo base_url();?>teacher/assignments">
                                <div class="cstm-dboard-blck bg-block-yellow">
                                	<div><i class="fa fa-file-text-o fa-4x"></i></div>
                                	<div><?php echo get_phrase('assignments');?></div>
                                </div>
                          		</a>
										<!--<div class="span2">
							<a href="<?php //echo base_url();?>teacher/parent_enquiry">
							<img src="<?php //echo base_url();?>template/images/icons/teacher_contact.png" height="80px" width="80px"/><br />
							<span><?php //echo get_phrase('parent_enquiry');?>
                                                        <span class="badge badge-important parent-enquiry-badge">
                                                           <span id="ctl00_lbl_unread"><?php //echo isset($count_unread_message)?$count_unread_message:'0';?></span>
                                                        </span>
                                                        </span>
							</a>
						</div>-->
						<a href="<?php echo base_url();?>teacher/subject">
							<div class="cstm-dboard-blck bg-light-purple">
                                	<div><i class="fa fa-pencil-square-o fa-4x"></i></div>
                                	<div><?php echo get_phrase('subject');?></div>
                                </div>
                            	
                           		</a>
						
						<!--<div class="span2">
							<a href="<?php echo base_url();?>teacher/attendence">
							<img src="http://www.schoolbookpro.com/tamimages/teacher/attendence.png" height="80px" width="80px"/><br />
							<span><?php echo get_phrase('attendance');?></span>
							</a>
						</div>-->
						<a href="<?php echo base_url();?>teacher/daily_staffattendence">
                            	<div class="cstm-dboard-blck bg-block-purple">
                                	<div><i class="fa fa-check-square-o fa-4x"></i></div>
                                	<div><?php echo get_phrase('staff_daily_attendence');?></div>
                                </div>
                           		</a>
						<!--<div class="span2">
							<a href="<?php echo base_url();?>teacher/mymonthlyattendence">
							<img src="http://www.schoolbookpro.com/tamimages/teacher/placements.png" height="80px" width="80px"/><br />
							<span><?php echo get_phrase('staff_monthly_attendence');?></span>
							</a>
						</div>-->
						<a href="<?php echo base_url();?>teacher/marks">
                                <div class="cstm-dboard-blck bg-block-yellow">
                                	<div><i class="fa fa-file-text-o fa-4x"></i></div>
                                	<div><?php echo get_phrase('enter_student_marks');?></div>
                                </div>
                          		</a>
                                
						<a href="<?php echo base_url();?>teacher/book">
                            	<div class="cstm-dboard-blck bg-deep-red">
                                	<div><i class="fa fa-book fa-4x"></i></div>
                                	<div><?php echo get_phrase('library');?></div>
                                </div>
                                </a>
                                         					    
						<a href="<?php echo base_url();?>teacher/class_routine">
                                <div class="cstm-dboard-blck bg-block-yellow">
                                	<div><i class="fa fa-calendar fa-4x"></i></div>
                                	<div><?php echo get_phrase('class_routine');?></div>
                                </div>
                            	</a>
                  					<a href="<?php echo base_url();?>teacher/timetables">
                                <div class="cstm-dboard-blck bg-deep-terques">
                                	<div><i class="fa fa-building-o fa-4x"></i></div>
                                	<div><?php echo get_phrase('timetables');?></div>
                                </div>
                                </a>
                        
						 <a href="<?php echo base_url();?>teacher/transport">
                                <div class="cstm-dboard-blck bg-block-orange">
                                	<div><i class="fa fa-bus fa-4x"></i></div>
                                	<div><?php echo get_phrase('transport');?></div>
                                </div>
                                </a>
						
						 <a href="<?php echo base_url();?>teacher/noticeboard">
                            	<div class="cstm-dboard-blck bg-deep-red">
                                	<div><i class="fa fa-clipboard fa-4x"></i></div>
                                	<div><?php echo get_phrase('noticeboard');?></div>
                                </div>
                                </a>
							
						<a href="<?php echo base_url();?>teacher/placements">
                            	<div class="cstm-dboard-blck bg-deep-red">
                                	<div><i class="fa fa-clipboard fa-4x"></i></div>
                                	<div><?php echo get_phrase('placements');?></div>
                                </div>
                                </a>
								
					        <a href="<?php echo base_url();?>teacher/feecollect">
                            	<div class="cstm-dboard-blck bg-deep-thistle">
                                	<div><i class="fa fa-money fa-4x"></i></div>
                                	<div><?php echo get_phrase('student_fee_details');?></div>
                                </div>
                           		</a>              
						
                    </div>
				</div>
			</div>
            <!---DASHBOARD MENU BAR ENDS HERE-->
       </div><br><br />
       
		<div class="row-fluid">
            <div class="span6">
				<div class="box tam-custom-assignments">
					<div class="box-header">
						<span class="title">
                        	<!--<i class="icon-reorder"></i>-->
                            <?php echo get_phrase('Assignments');?>
                        </span>
					</div>
					<div class="box-content scrollable" style="max-height: 500px; overflow-y: auto">
                    
                    	<?php
						$this->db->where('teacher_id',$this->session->userdata('teacher_id'));
						$assignments	=	$this->db->get('assignments')->result_array();
						if(!empty($assignments))
						{
						foreach($assignments as $row):
						?>
						<div class="box-section news with-icons">
							<div class="avatar">
								<!--<img src="<?php echo base_url();?>template/images/icons/notification.png" height="25px" width="25px" alt="" />-->
                                <i class="icon-list-alt"></i>
							</div>
							<div class="news-time">
								<span><?php echo date('d',$row['create_timestamp']);?></span> <?php echo date('M',$row['create_timestamp']);?>
							</div>
							<div class="news-content">
								<div class="news-title">
									<?php echo $row['assignment_title'];?>
								</div>
								<div class="news-text">
									 <?php echo $row['assignment'];?>
									<?php if(!empty($row['assignment_attachment'])) : ?>Attachment : <a href="<?php echo 'uploads/assignment_attachment/'.$row['assignment_attachment'] ?>">Download Attachment</a><?php endif; ?>
								</div>
							</div>
						</div>
						<?php
						endforeach;
						}
						else
						{
							echo '<center><div class="box-section news with-icons">No Assignments.</div></center>';
						}?>
					</div>
				</div>
			</div>
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
       </div>
       
       <div class="row-fluid">
            
           
            
            <!---TO DO LIST STARTS-->
			<div class="span6">
				<div class="box tam-custom-noticeboard">
					<div class="box-header">
						<span class="title">
                        	<!--<i class="icon-reorder"></i>-->
                            <?php echo get_phrase('staff_noticeboard');?>
                        </span>
					</div>
					<div class="box-content scrollable" style="max-height: 500px; overflow-y: auto">
                    
                    	<?php 
						$login_type = $this->session->userdata('login_type');
                        $user_id = $this->session->userdata($login_type.'_id');
						$dep_id = $this->db->get_where('teacher', array('teacher_id' => $user_id))->row()->employee_department_id;
						$this->db->where('notice_department',$dep_id);
						$this->db->order_by('create_timestamp');
						$notices	=	$this->db->get('staffnotice')->result_array();
						if(!empty($notices)) {
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
						<?php endforeach; } else { 
						
						echo '<center><div class="box-section news with-icons">No Notices Found.</div></center>';
						
						 }?>
					</div>
				</div>
			</div>
            <!---TO DO LIST ENDS-->
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
            },*/
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
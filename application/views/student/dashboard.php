	<div class="container-fluid padded">
		<div class="row-fluid">
			<div class="span30">
				<!-- find me in partials/action_nav_normal -->
				<!--big normal buttons-->
				<div class="action-nav-normal">
					<div id="cstm-dboard-main-blk">
					<a href="<?php echo base_url();?>student/marks">
                                <div class="cstm-dboard-blck bg-block-yellow">
                                	<div><i class="fa fa-file-text-o fa-4x"></i></div>
                                	<div><?php echo get_phrase('student_marks');?></div>
                                </div>
                          		</a>
					<a href="<?php echo base_url();?>student/dailyattendence">
                            	<div class="cstm-dboard-blck bg-light-blue">
                                	<div><i class="fa fa-check-square-o fa-4x"></i></div>
                                	<div><?php echo get_phrase('daily_attendence');?></div>
                                </div>
                           		</a>
												<!--<div class="span2">
							<a href="<?php echo base_url();?>student/attendence">
							<img src="http://www.schoolbookpro.com/tamimages/student/attendence.png" height="80px" width="80px"/><br />
							<span><?php echo get_phrase('monthly_attendance');?></span>
							</a>
						</div>-->	
						<a href="<?php echo base_url();?>student/view_mark_chart">
                                <div class="cstm-dboard-blck bg-block-yellow">
                                	<div><i class="fa fa-file-text-o fa-4x"></i></div>
                                	<div><?php echo get_phrase('marks_graph');?></div>
                                </div>
                          		</a>						

						<!--<div class="span2">
							<a href="<?php echo base_url();?>student/view_attendance_chart">
							<img src="http://www.schoolbookpro.com/tamimages/student/attendance_chart.png" height="80px" width="80px"/><br />
							<span><?php echo get_phrase('attendance_graph');?></span>
							</a>
						</div>-->
							<a href="<?php echo base_url();?>student/assignments">
                                <div class="cstm-dboard-blck bg-block-yellow">
                                	<div><i class="fa fa-file-text-o fa-4x"></i></div>
                                	<div><?php echo get_phrase('assignments');?></div>
                                </div>
                          		</a>				
				       <a href="<?php echo base_url();?>student/class_routine">
                                <div class="cstm-dboard-blck bg-block-yellow">
                                	<div><i class="fa fa-calendar fa-4x"></i></div>
                                	<div><?php echo get_phrase('class_routine');?></div>
                                </div>
                            	</a>
					  <a href="<?php echo base_url();?>student/timetables">
                                <div class="cstm-dboard-blck bg-deep-terques">
                                	<div><i class="fa fa-building-o fa-4x"></i></div>
                                	<div><?php echo get_phrase('timetables');?></div>
                                </div>
                                </a>	
					
                     <a href="<?php echo base_url();?>student/book">
                            	<div class="cstm-dboard-blck bg-deep-red">
                                	<div><i class="fa fa-book fa-4x"></i></div>
                                	<div><?php echo get_phrase('library');?></div>
                                </div>
                                </a>
						<a href="<?php echo base_url();?>student/placements">
                            	<div class="cstm-dboard-blck bg-deep-red">
                                	<div><i class="fa fa-clipboard fa-4x"></i></div>
                                	<div><?php echo get_phrase('placements');?></div>
                                </div>
                                </a>
						  <a href="<?php echo base_url();?>student/subject">
							<div class="cstm-dboard-blck bg-light-purple">
                                	<div><i class="fa fa-pencil-square-o fa-4x"></i></div>
                                	<div><?php echo get_phrase('subjects');?></div>
                                </div>  
							</a>
						<a href="<?php echo base_url();?>student/noticeboard">
                            	<div class="cstm-dboard-blck bg-deep-red">
                                	<div><i class="fa fa-clipboard fa-4x"></i></div>
                                	<div><?php echo get_phrase('noticeboard');?></div>
                                </div>	
						</a>								
						<a href="<?php echo base_url();?>student/questionpaper">
                            	<div class="cstm-dboard-blck bg-block-purple">
                                	<div><i class="fa fa-question-circle fa-4x"></i></div>
                                	<div><?php echo get_phrase('previous_question_papers');?></div>
                                </div>
                                </a>
                        <a href="<?php echo base_url();?>student/onlinetest">
                            	<div class="cstm-dboard-blck bg-light-blue">
                                	<div><i class="fa fa-globe fa-4x"></i></div>
                                	<div><?php echo get_phrase('online_test');?></div>
                                </div>
                           		</a>
					<a href="<?php echo base_url();?>student/tasks">
                            	<div class="cstm-dboard-blck bg-deep-red">
                                	<div><i class="fa fa-flag-o fa-4x"></i></div>
                                	<div><?php echo get_phrase('things_do_to');?></div>
                                </div>
                                </a>                 		
						<a href="<?php echo base_url();?>student/feecollect">
                            	<div class="cstm-dboard-blck bg-deep-thistle">
                                	<div><i class="fa fa-money fa-4x"></i></div>
                                	<div><?php echo get_phrase('payment');?></div>
                                </div>
                           		</a>
						<a href="<?php echo base_url();?>student/dormitory">
                                <div class="cstm-dboard-blck bg-deep-terques">
                                	<div><i class="fa fa-building-o fa-4x"></i></div>
                                	<div><?php echo get_phrase('dormitory');?></div>
                                </div>
                                </a>
                             <a href="<?php echo base_url();?>student/transport">
                                <div class="cstm-dboard-blck bg-block-orange">
                                	<div><i class="fa fa-bus fa-4x"></i></div>
                                	<div><?php echo get_phrase('transport');?></div>
                                </div>
                                </a>
                       <a href="<?php echo base_url();?>student/googlenews">
                            	<div class="cstm-dboard-blck bg-deep-red">
                                	<div><i class="fa fa-clipboard fa-4x"></i></div>
                                	<div><?php echo get_phrase('google_news');?></div>
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
						$this->db->where('class_id',$this->session->userdata('student_class'));
						$this->db->order_by('create_timestamp',desc);						
						$assignments	=	$this->db->get('assignments')->result_array();	
						$i=0;
						if(!empty($assignments))
						{
						
						foreach($assignments as $row):
						
						if($i!=0)
						echo '<hr>';
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
								<div class="news-title" style="color:#FA6800;">
									<stronng>Teacher Name :</stronng> <?php echo $row['assignment_title']; ?>
								</div>
								<div class="news-title" style="color:#FA6800;">
									<stronng>Subject :</stronng> <?php
									$this->db->where('subject_id',$row['subject_id']);
									$total_subjects = $this->db->get('subject')->result_array();
									foreach($total_subjects as $mysubjects)
										echo $mysubjects['name'];
									?>
								</div>
								<div class="news-text">
									<h4 style="color:#666;padding:0px;margin:0px;font-size:14px;"><stronng>Assignment Title :</stronng> <?php echo $row['assignment_title'];?>	</h4>								
								</div>
								<div class="news-text">
									<h4 style="color:#666;padding:0px;margin:0px;font-size:14px;"><stronng>Assignment Data :</stronng> <?php echo $row['assignment'];?>	</h4>								
								</div>
								<div class="news-text">
								<?php if(!empty($row['assignment_attachment'])) : ?>Attachment : <a href="<?php echo 'uploads/assignment_attachment/'.$row['assignment_attachment'] ?>">Download Attachment</a><?php endif; ?>
								</div>
							</div>						
						</div>
						
						<?php
						$i++;
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
            <!---TO DO Pollings -->
			<?php //if(!empty($this->session->userdata('standard'))):?>
			 <!--<div class="span6">
				<div class="box tam-custom-assignments">
					<div class="box-header">
						<span class="title">
                        	
                            <?php //echo get_phrase('Polling');?>
                        </span>
					</div>
					<div class="box-content scrollable" style="max-height: 500px; overflow-y: auto">
                    
                    <div  class="news-title" style="margin-bottom:15px;">Question</div>
					<div><div style="float:left;width:50%;" class="news-text" >sdfaasf</div><div style="float:left;width:50%;" class="news-text" >sdfaasf</div></div>
					</div>
				</div>
			</div>-->
			<?php //endif; ?>
			<!---TO DO Pollings ENDS-->
			
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
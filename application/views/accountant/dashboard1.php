	<div class="container-fluid padded">
		<div class="row-fluid">
			<div class="span30">
				<!-- find me in partials/action_nav_normal -->
				<!--big normal buttons-->
				<div class="action-nav-normal">
					<div class="row-fluid">
						<div class="span2">
							<a href="<?php echo base_url();?>teacher/student">
                            <img src="<?php echo base_url();?>template/images/icons/user.png" height="80px" width="80px"/><br />
							<span><?php echo get_phrase('manage_student');?></span>
                            
							</a>
						</div>
						<div class="span2">
							<a href="<?php echo base_url();?>teacher/teacher_list">
							<img src="<?php echo base_url();?>template/images/icons/teacher.png" height="80px" width="80px"/><br />
							<span><?php echo get_phrase('manage_teacher');?></span>
                            
							</a>
						</div>
						<div class="span2">
							<a href="<?php echo base_url();?>teacher/subject">
							<img src="<?php echo base_url();?>template/images/icons/subject.png" height="80px" width="80px"/><br />
							<span><?php echo get_phrase('subject');?></span>
							</a>
						</div>
						<div class="span2">
							<a href="<?php echo base_url();?>teacher/attendence">
							<img src="<?php echo base_url();?>template/images/icons/attendence.png" height="80px" width="80px"/><br />
							<span><?php echo get_phrase('attendance');?></span>
							</a>
						</div>
						<div class="span2">
							<a href="<?php echo base_url();?>teacher/class_routine">
							<img src="<?php echo base_url();?>template/images/icons/routine.png" height="80px" width="80px"/><br />
							<span><?php echo get_phrase('class_routine');?></span>
							</a>
						</div>
						<div class="span2">
							<a href="<?php echo base_url();?>teacher/book">
							<img src="<?php echo base_url();?>template/images/icons/book.png" height="80px" width="80px"/><br />
							<span><?php echo get_phrase('library');?></span>
							</a>
						</div>
                    </div><br />
                    <div class="row-fluid">
					    <div class="span2">
							<a href="<?php echo base_url();?>teacher/marks">
							<img src="<?php echo base_url();?>template/images/icons/marks.png" height="80px" width="80px"/><br />
							<span><?php echo get_phrase('marks');?></span>
							</a>
						</div>
						<div class="span2">
							<a href="<?php echo base_url();?>teacher/transport">
							<img src="<?php echo base_url();?>template/images/icons/transport.png" height="80px" width="80px"/><br />
							<span><?php echo get_phrase('transport');?></span>
							</a>
						</div>
						<div class="span2">
							<a href="<?php echo base_url();?>teacher/noticeboard">
							<img src="<?php echo base_url();?>template/images/icons/noticeboard.png" height="80px" width="80px"/><br />
							<span><?php echo get_phrase('noticeboard');?></span>
							</a>
						</div>
						<div class="span2">
							<a href="<?php echo base_url();?>teacher/backup_restore">
							<img src="<?php echo base_url();?>template/images/icons/backup.png" height="80px" width="80px"/><br />
							<span><?php echo get_phrase('backup');?></span>
							</a>
						</div>
						
					</div>
				</div>
			</div>
            <!---DASHBOARD MENU BAR ENDS HERE-->
       </div><br><br />
       
		<div class="row-fluid">
            <div class="span6">
				<div class="box" style="border-style: solid;border-width: 3px;border-color:#1E2529">
					<div class="box-header">
						<div class="title">
                        	<i class="icon-calendar"></i>
							<?php echo get_phrase('calendar_schedule');?>
						</div>
					</div>
					<div class="box-content">
						<div id="calendar2">
						</div>
					</div>
				</div>
			</div>
            <!---CALENDAR ENDS-->
            
            <!---TO DO LIST STARTS-->
			<div class="span6">
				<div class="box" style="border-style: solid;border-width: 3px;border-color:#1E2529">
					<div class="box-header">
						<span class="title">
                        	<i class="icon-reorder"></i>
                            <?php echo get_phrase('noticeboard');?>
                        </span>
					</div>
					<div class="box-content scrollable" style="max-height: 500px; overflow-y: auto">
                    
                    	<?php 
						$notices	=	$this->db->get('noticeboard')->result_array();
						foreach($notices as $row):
						?>
						<div class="box-section news with-icons">
							<div class="avatar">
								<img src="<?php echo base_url();?>template/images/icons/notification.png" height="25px" width="25px" alt="" />
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
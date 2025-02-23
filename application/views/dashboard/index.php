<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if ($this->session->userdata('user_group_id') != 1 ) {
	include('school.php');
} else {
?>
    <!-- Main content -->
    <section class="content">
      <!-- Info boxes -->
      <div class="row">

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-building"></i></span>
            
            <div class="info-box-content">
              <span class="info-box-text">Total Schools</span>
              <span class="info-box-number"><?php echo $total_school; ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
         
        <!-- /.col -->
        
        
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-users"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Total Students</span>
              <span class="info-box-number"><?php echo $total_students;?></span>
            </div>
          
          </div>
          
        </div>
        <!-- /.col -->

        
        
        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-folder-open"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Total Students Registered</span>
              <span class="info-box-number"><?php echo $total_registered;?></span>
            </div>
             
          </div>
          
        </div>
        
        <div class="clearfix visible-sm-block"></div>
      </div>

<?php } ?>

        <!-- /.col -->
        <div class="col-md-3">
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo get_phrase('noticeboard');?></h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
		<ul class="timeline">
<?php
			$this->db->order_by('create_timestamp', 'desc');
			$this->db->limit('15');
			$notices	=	$this->db->get('noticeboard')->result_array();

			$lastdate = '';

			foreach($notices as $row):
				$rowdate = date('Y-m-d', $row['create_timestamp']);
				$rowdatedisp = date('l, jS F Y', $row['create_timestamp']);
				$rowtimedisp = date('H:i:s', $row['create_timestamp']);
				if ($rowdate != $lastdate) {
					$lastdate = $rowdate;
?>
				    <!-- timeline time label -->
				    <li class="time-label">
					<span class="bg-red">
					    <?=$rowdatedisp?>
					</span>
				    </li>
				    <!-- /.timeline-label -->

<?php
				}
?>
			    <!-- timeline item -->
			    <li>
				<!-- timeline icon -->
				<i class="fa fa-envelope bg-blue"></i>
				<div class="timeline-item">
				    <span class="time"><i class="fa fa-clock-o"></i> <?=$rowtimedisp?></span>

				    <h3 class="timeline-header"><?php echo $row['notice_title'];?></h3>

				    <div class="timeline-body">
					<?php echo $row['notice'];?>
				    </div>
				</div>
			    </li>
			    <!-- END timeline item -->
			<?php endforeach;?>
		</ul>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3">
          <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo get_phrase('calendar');?></h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
		Calendar goes here
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
    
            
    </section>

<!-- Main content -->
    <section class="content">
      <!-- Info boxes -->
      <div class="row">
        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-users"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Total Students</span>
              <span class="info-box-number"><?php echo $total_students; ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
           <?php // if($this->session->userdata('school_id')!=1) { ?>    
        <div class="col-md-4 col-sm-6 col-xs-12">
            
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-folder-open"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Total Students Registered</span>
              <span class="info-box-number"><?php echo $total_registered; ?></span>
            </div>
            
           
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
         <?php // } ?>
       
        <!-- /.col -->
      
        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

        
        
        
     </div>
     <div class="row">
        
         
         <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
              <span class="info-box-icon bg-green"><i class="fa fa-dollar"></i></span>
            <div class="info-box-content">
                

                <span class="info-box-text">Annual Fees Paid Students </span>
              <span class="info-box-number"><small>Count : </small><?php echo $school['total_paid_annual']?>  </span>
              <span class="info-box-number"><small>Total Amount : </small><small>INR </small><?php echo $school['total_paid_annual_amount']?>  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
         
         
         
        <!-- /.col -->
        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-money"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Annual Fees Paid by Admin <br><?php // echo date('F'); ?></span>
              <span class="info-box-number"><small>Count : </small><?php echo $school['total_paid_admin_annual']?>  </span>
              <span class="info-box-number"><small>Total Amount : </small><small>INR </small><?php echo $school['total_amount_admin_ann']?>  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        
        
        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-credit-card"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Annual Fees Paid using <br>CC/ DC/ NEFT<?php // echo date('F'); ?></span>
              <span class="info-box-number"><small>Count : </small><?php echo $school['total_paid_cc_annual']?> </span>
              <span class="info-box-number"><small>Total Amount : </small> <small>INR </small><?php echo $school['total_amount_cc_ann']?> </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        </div>    
    <div class="row">
        
        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-dollar"></i></span>

            <div class="info-box-content">
                <span class="info-box-text"><?php echo date('F'); ?> Fees Paid Students  </span>
              <span class="info-box-number"><small>Count : </small><?php echo $school['total_paid']?>  </span>
              <span class="info-box-number"><small>Total Amount : </small><small>INR </small><?php echo $school['total_paid_monthly_amount']?>  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        
        
        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-money"></i></span>

            <div class="info-box-content">
              <span class="info-box-text"><?php echo date('F'); ?> Fees Paid by Admin </span>
              <span class="info-box-number"><small>Count : </small><?php echo $school['total_paid_admin']?>  </span>
              <span class="info-box-number"><small>Total Amount : </small><small>INR </small><?php echo $school['total_amount_admin']?>  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>

        <div class="clearfix visible-sm-block"></div>

        
     
        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-credit-card"></i></span>

            <div class="info-box-content">
                <span class="info-box-text"><?php echo date('F'); ?> Fees Paid using <br>CC/ DC/ NEFT  </span>
              <span class="info-box-number"><small>Count : </small><?php echo $school['total_paid_cc']?> </span>
              <span class="info-box-number"><small>Total Amount : </small><small>INR </small><?php echo $school['total_amount_cc']?> </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>


    <!-- Class Details -->
    <section class="col-lg-12">
      <h4 style="color:green">Class Information</h4>
  
    <?php
      $ctr =1;
      
      foreach($school['class'] as $name=>$details){
      
      ?>
            <!-- Class -->
            <section class="col-lg-6 connectedSortable">

              <div class="box box-solid bg-green-gradient">
                <div class="box-header">
                  <i class="fa fa-calendar"></i>

                  <h3 class="box-title"><?php echo $name;?></h3>
                  <!-- tools box -->
                  <div class="pull-right box-tools">
                    <button type="button" class="btn btn-success btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-success btn-sm" data-widget="remove"><i class="fa fa-times"></i>
                    </button>
                  </div>
                  <!-- /. tools -->
                </div>
                <!-- /.box-header -->
                <!-- /.box-body -->
                <div class="box-footer text-black">
                  <div class="row">
                    
                    <!-- /.col -->
                    <div class="item col-sm-3">
                      <p class="message">
                        <!--<a href="#" class="name text-center">-->
                          Total Students
                        <!--</a>-->
                        <div>&nbsp;</div>
                        <div class="text-center">
                        <?php echo isset($details['total_class_student']) ? $details['total_class_student'] : '0';?>
                        </div>
                      </p>

                    </div>

                    <!-- for chinmaya no used  --->
                    <div class="col-sm-3">
                      <p class="message">
                        <!--<a href="#" class="name text-center">-->
                          Total Registered
                        <!--</a>-->
                        <div>&nbsp;</div>
                        <div class="text-center">
                        <?php echo isset($details['registered']) ? $details['registered'] : '0';?>
                        </div>
                      </p>
                    </div>

                    <div class="col-sm-3">
                      <p class="message">
                        <!--<a href="#" class="name text-center">-->
                          Paid By Admin (Current Month)
                        <!--</a>-->
                        <div class="text-center">
                        <?php echo isset($details['admin']) ? $details['admin'] : '0';?>
                        </div>
                      </p>
                    </div>

                    <div class="col-sm-3">
                      <p class="message">
                        <!--<a href="#" class="name text-center">-->
                          Paid By CC (Current Month)
                        <!--</a>-->
                        <div class="text-center">
                        <?php echo isset($details['cc']) ? $details['cc'] : '0';?>
                        </div>
                      </p>
                    </div>
                    <!-- /.col -->
                  </div>
                  <!-- /.row -->
                </div>
              </div>
              <!-- /.box -->
            </section>
      <?php }   //end of foreach?>  
  </section>



<div class="form-group has-feedback">
<?php if($this->session->userdata('login_type')=='teacher'){}else{?>
  <div class="box">               
    <div class="box-body">
      <div class="col-lg-12">       
        <div class="row">
          <div class="col-md-4 form-group">
            <label for="exampleInputEmail1">Select Teacher</label>
         
            <select class="form-control" id="teachere">
               <option>--Select Teacher--</option>
              <?php foreach($teacher as $data){?>
                <option value="<?php echo $data->id;?>"><?php echo $data->name;?></option>
              <?php }?>
            </select>
          </div>
          <br/>
          <a type="submit" class="btn btn-primary" style="margin-top:5px;" onclick="getdata()">Go</a>
        </div>      
      </div>
    </div>
  </div>
<?php }?>

<?php if($this->session->userdata('login_type')=='teacher'){
?>
  
  <div class="box" id="routinetoday">   
    <div class="panel-heading"><h4>Today Routine</h4></div> 
      <div class="box-body">
        <button class="btn btn-info" data-toggle="dropdown">Regular</button>  
        <button class="btn btn-success" data-toggle="dropdown">Assigned</button><hr/>
      </div> 
      <div class="box-body" id="todayroutine">
        <table class="table table-striped table-bordered table-hover" cellspacing="0" cellpadding="0" border="2">
          <thead>
            <tr>
              <th>Time<br/>Day</th>
              <?php foreach($period as $per_value){?>
                  <th><?php echo $per_value->name;?><br/>(<?php echo $per_value->time_start;?>:<?php echo $per_value->time_start_min;?> - <?php echo $per_value->time_end;?>:<?php echo $per_value->time_end_min;?>)</th>
              <?php }?>
            </tr> 
          </thead>
          <tbody>
            <?php 
              $d = date('w'); 
              if ($d == 0)
              $day = 'sunday';
              else if ($d == 1)
                  $day = 'monday';
              else if ($d == 2)
                  $day = 'tuesday';
              else if ($d == 3)
                  $day = 'wednesday';
              else if ($d == 4)
                  $day = 'thursday';
              else if ($d == 5)
                  $day = 'friday';
              else if ($d == 6)
                $day = 'saturday';

              $todaydate = date('Y-m-d');
            ?>         
            <tr class="gradeA">
              <td width="100"><?php echo strtoupper($day); ?></td>
              
              <?php foreach($period as $per_valu){?>
              <td>
                <?php 
                  if($day=='sunday')
                  {
                    echo 'Holiday';
                  }
                  else
                  {
                    $pid = $per_valu->id;
                    $tid = $this->session->userdata('school_id');
                    $todaydate = date('Y-m-d');
                  
                    $subteac = $this->dbconnection->GetSubsti($todaydate,$day,$tid);
                    $cc = count($subteac);
                    if($cc>0)
                    {
                      $periodid = $subteac->period_id;
                      if($periodid == $pid)
                      {
                        ?>
                        <button class="btn btn-success" data-toggle="dropdown" style="width:100%;">
                          <p><b>Class : </b><span><?php echo $subteac->class_name;?></span></p> 
                          <p><b>Section : </b><span><?php echo $subteac->sec_name;?></span></p> 
                          <p><b>Subject : </b><span><?php echo $subteac->name;?></span></p> 
                          <p><b>* </b><span>Assigned</span></p> 
                          <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" style="border:3px solid #ccc;">
                        <li>
                          <a data-toggle="modal" href="#modal-form" onclick="remarks();">
                              <i class="icon-cog"></i> Remarks
                          </a>
                        </li>
                        <li>
                          <a data-toggle="modal" href="#modal-delete" onclick="homework();">   <i class="icon-trash"></i> Homework
                          </a>
                        </li>
                    </ul>
                      <?php }
                      
                    }

                    $data = $this->dbconnection->GetTeacherData($pid,$day,$tid);
                    $countper = count($data);
                    if($countper>0)
                    {
                      $data->id;
                    ?>
                    <button class="btn btn-info" data-toggle="dropdown" style="width:100%;">
                      <p><b>Class : </b><span><?php echo $data->class_name;?></span></p> 
                      <p><b>Section : </b><span><?php echo $data->sec_name;?></span></p> 
                      <p><b>Subject : </b><span><?php echo $data->name;?></span></p> 
                      <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" style="border:3px solid #ccc;">
                        <li>
                          <a data-toggle="modal" href="#modal-form" onclick="remarks();">
                              <i class="icon-cog"></i> Remarks
                          </a>
                        </li>
                        <li>
                          <a data-toggle="modal" href="#modal-delete" onclick="homework();">   <i class="icon-trash"></i> Homework
                          </a>
                        </li>
                    </ul>
                    <?php 
                    }
                    
                }
                ?>
              </td>

            <?php }?>
            </tr>
          </tbody>
        </table>
      </div>
  </div>

  <div class="box" id="routinetable">  
    <div class="panel-heading"><h4>Overall Routine</h4></div>               
      <div class="box-body" id="box-body">
        <table cellpadding="0" cellspacing="0" border="2"  class="table table-striped table-bordered table-hover">
          <thead>
              <tr>
                <th>Time<br/>Day</th>
                <?php foreach($period as $per_value){?>
                    <th><?php echo $per_value->name;?><br/>(<?php echo $per_value->time_start;?>:<?php echo $per_value->time_start_min;?> - <?php echo $per_value->time_end;?>:<?php echo $per_value->time_end_min;?>)</th>
                <?php }?>
              </tr>
          </thead>
          <tbody>
               <?php
                for ($d = 1; $d <= 7; $d++){

                if ($d == 1)
                    $day = 'sunday';
                else if ($d == 2)
                    $day = 'monday';
                else if ($d == 3)
                    $day = 'tuesday';
                else if ($d == 4)
                    $day = 'wednesday';
                else if ($d == 5)
                    $day = 'thursday';
                else if ($d == 6)
                    $day = 'friday';
                else if ($d == 7)
                    $day = 'saturday';
                ?>

                <tr class="gradeA">
                  <td width="100"><?php echo strtoupper($day); ?></td>
                   <?php foreach($period as $per_valu){?>
                     <td>  
                      <?php if($day=='sunday'){echo 'Holiday';}else
                        {
                      ?>  

                        <?php 
                          $pid = $per_valu->id;
                          $tid = $this->session->userdata('school_id');
                          $data = $this->dbconnection->GetTeacherData($pid,$day,$tid);
                          $countper = count($data);
                          if($countper>0)
                          {
                        ?>
                          <button class="btn btn-info" data-toggle="dropdown" style="width:100%;">
                          
                      <p><b>Class : </b><span><?php echo $data->class_name;?></span></p> 
                      <p><b>Section : </b><span><?php echo $data->sec_name;?></span></p> 
                      <p><b>Subject : </b><span><?php echo $data->name;?></span></p>
                      </button> 
                        <?php 
                          }
                          else
                          {
                            echo '--';
                          }
                        }
                      ?>
                    </td>
                  <?php } ?>
                </tr>
                <?php } ?>
          </tbody>
        </table>
      </div>
  </div>

<?php  } else{ ?>

  <div class="box" id="routinetoday" style="display: none;">   
    <div class="panel-heading"><h4>Today Routine</h4></div> 
      <div class="box-body">
        <button class="btn btn-info" data-toggle="dropdown">Regular</button>  
        <button class="btn btn-success" data-toggle="dropdown">Assigned</button><hr/>
      </div> 
      <div class="box-body" id="todayroutine">

      </div>
  </div>

  <div class="box" id="routinetable" style="display: none;">  
    <div class="panel-heading"><h4>Overall Routine</h4></div>               
      <div class="box-body" id="box-body">
        
      </div>
  </div>


<?php }?>
</div>

<script>
  function getdata()
  {
    var tid    = $('#teachere').find('option:selected').attr('value');
    $('#routinetoday').show();
    $('#routinetable').show();
   
    $.ajax({
        url: "<?php echo site_url('academics/teacher_routines/view') ?>",
        type: "POST",
        data: {tid: tid},
        success: function (data)
        {
            $('#box-body').html(data);
        },
        error: function (data, status)
        {
            alert('e' + data + status);
        }
      });

    $.ajax({
        url: "<?php echo site_url('academics/teacher_routines/todayroutine') ?>",
        type: "POST",
        data: {tid: tid},
        success: function (data)
        {
            $('#todayroutine').html(data);
        },
        error: function (data, status)
        {
            alert('e' + data + status);
        }
      });
  }
</script>
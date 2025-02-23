    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">To Do Assignments</h3>
            <div class="box-tools pull-right">
                <span class="label label-primary"><?php echo $assig[0]->total;?></span>
            </div>
        </div>
        <div class="box-body">
            <div class="col-lg-12">
                <div class="table-responsive">
                <table cellpadding="0" cellspacing="0" border="2"  class="table table-striped table-bordered" id="todo">
                  <thead style="border-bottom: 1px solid black;">
                    <tr>
                        <th>S.No.</th>
                        <th>Description</th>
                        <th>Subject</th>
                        <th>Date Of Assigned</th>
                        <th>Date Of Submission</th> 
                        <th>Question</th>
                        <th>Upload</th>       
                    </tr>
                    </thead>
                    <tbody>
                    <?php 
                    $i=1;
                    foreach($todo as $value){?>
                    <tr>
                        <td><?php echo $i;?></td>
                        <td><?php echo $value->description;?></td>
                        <td><?php echo $value->subject;?></td>
                        <td><?php echo $value->date_created;?></td>
                        <td><?php echo $value->dos;?></td>
                        
                        <td><span><a class="btn" data-toggle="modal" data-target="#myModalTodo_<?php echo $value->id;?>"><i class="fa fa-eye"></i> View Question</a></span></td>
                       
                        <td><span><a class="btn" data-toggle="modal" data-target="#myModalHomeTodo_<?php echo $value->id;?>"><i class="fa fa-upload"></i> Upload Answer</a></span></td>
                    
                    </tr>

                    <div id="myModalTodo_<?php echo $value->id;?>" class="modal fade" role="dialog">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Assignment Questions</h4>
                          </div>
                          <div class="modal-body">
                            <p><?php echo $value->description;?></p>
                            <?php if ($value->attachment !='') { ?>
                               <a href="<?php echo base_url()?>homework/<?php echo $value->attachment; ?>">Click here to view</a>
                            <?php } ?>
                           
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div>

                     <div id="myModalHomeTodo_<?php echo $value->id;?>" class="modal fade" role="dialog">
                      <div class="modal-dialog">
                        <form method="POST" enctype="multipart/form-data" id="homework_form" action="<?php echo base_url()?>Student/upload_homework">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Upload Homework</h4>
                          </div>
                          <div class="modal-body">
                            <label>Choose file to upload :</label>
                            <input type="file" name="home_upload" id="home_upload">
                            <input type="hidden" name="home_id" id="home_id" value="<?php echo $value->id; ?>">
                          </div>
                          <div class="modal-footer">
                            <input type="submit" name="submit" value="Submit" class="btn btn-primary">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                    </form>
                      </div>
                    </div>

                    <?php $i++;}?>                  
                    </tbody>
                </table>
                </div>
            </div>
        </div> 
    </div>
   
    
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title col-md-6">Assignment</h3>
            <div class="col-md-6 notes"><span class="pull-right">NOTES:  <i class="fa fa-check-square fa-1x" aria-hidden="true" style="color:red;">&nbsp;&nbsp;Completed&nbsp;</i>&nbsp;&nbsp;|&nbsp;&nbsp;<i class="fa fa-window-close fa-1x" aria-hidden="true" style="color:darkgreen;">&nbsp;&nbsp;Not Completed&nbsp;</i></span></div>
        </div>
        <div class="box-body">

            <div class="col-lg-12">

                  <div class="table-responsive">
                 <table cellpadding="0" cellspacing="0" border="2"  class="table table-striped table-bordered" id="complet">
              <thead> 
                <tr>
                    <th>S.No.</th>
                    <th>Description</th>
                    <th>Subject</th>
                    <th>Date Of Assigned</th>
                    <th>Last Date Of Submission</th> 
                    <th>Action</th> 
                    <th>Upload</th> 
                    <th>Work Status</th> 
                    <th>Report By Teacher</th> 
                </tr>
                </thead>

                <tbody>
                    <?php 
                    $i=1;
                    foreach($complete as $values){
                        $as_id = $values->id;
                        $st_id = $student_id;
                        $dts = $this->dbconnection->select('assignment_report','*','assignment_id='.$as_id.' AND student_id = '.$st_id.'');
                        $remarks = $dts[0]->remarks;
                        $statuss = $dts[0]->assignment_status;
                        ?>
                    <tr>
                        <td><?php echo $i;?></td>
                        <td><?php echo $values->description;?></td>
                        <td><?php echo $values->subject;?></td>
                        <td><?php echo $values->date_created;?></td>
                        <td><?php echo $values->dos;?></td>
                        <td><span><a class="btn" data-toggle="modal" data-target="#Modal_<?php echo $values->id;?>" ><i class="fa fa-eye"></i> View Homework</a></span></td>
                        <?php if($statuss=='N'){?>
                          <td><span><a class="btn" data-toggle="modal" data-target="#ModalHome_<?php echo $values->id;?>" ><i class="fa fa-upload"></i> Upload Answer</a></span></td>
                        <?php } else if($statuss=='C')  { ?>
                         <td><button class="btn btn-success">SUBMITTED</button></td>
                        <?php } else{ ?>
                          <td><span><a class="btn" data-toggle="modal" data-target="#ModalHome_<?php echo $values->id;?>" ><i class="fa fa-upload"></i> Upload Answer</a></span></td>
                        <?php } ?>
                      
                        <td><?php if($statuss=='N'){?>
                                 <i class="fa fa-window-close fa-lg" aria-hidden="true" style="color:darkgreen;"></i>
                            <?php }else if($statuss=='C'){?>
                                 <i class="fa fa-check-square fa-lg" aria-hidden="true" style="color:red;"></i>
                            <?php }?>
                        </td>
                        <td style="background: #ccc;font-weight: bold;font-size: 15px;"><?php echo $remarks;?></td>
                    </tr>
                    <div id="Modal_<?php echo $values->id;?>" class="modal fade" role="dialog">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Assignment Questions</h4>
                          </div>
                          <div class="modal-body">
                            <p><?php echo $values->description;?></p>
                            <?php if($values->attachment !='') { ?>
                              <a href="<?php echo base_url()?>homework/<?php echo $values->attachment; ?>">Click here to view</a>
                            <?php } ?>
                            
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div id="ModalHome_<?php echo $values->id;?>" class="modal fade" role="dialog">
                      <div class="modal-dialog">
                        <form method="POST" enctype="multipart/form-data" id="homework_form" action="<?php echo base_url()?>Student/upload_homework">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Upload Homework</h4>
                          </div>
                          <div class="modal-body">
                            <label>Choose file to upload :</label>
                            <input type="file" name="home_upload" id="home_upload">
                            <input type="hidden" name="home_id" id="home_id" value="<?php echo $values->id; ?>">
                          </div>
                          <div class="modal-footer">
                           <input type="submit" name="submit" value="Submit" class="btn btn-primary">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                    </form>
                      </div>
                    </div>
                    <?php $i++;}?>
                    </tbody>
            </table>
        </div>
            </div>
        </div> 
    </div>



<script>
$(function ()
{
    $('#todo').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true
    });

    $('#complet').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true
    });
});

</script>
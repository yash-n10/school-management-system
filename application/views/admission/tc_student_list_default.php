<div class="form-group has-feedback">
    <div class="box">
        <div class="box-body">
            <form id="export-form" action="<?php echo base_url("feepayment/Report/exportpaymentlog"); ?>" method="POST">
                <div class="col-lg-2">
<!--                    <label>Class </label>
                    <select name="annuallstClass" id="annuallstClass" class="form-control">
                        <option value="all">All Class</option>
                        <?php
                        foreach ($aclass as $class) {
                            ?>
                            <option value="<?php echo $class->id; ?>"><?php echo $class->class_name; ?></option>
                            <?php
                        }
                        ?>
                    </select>-->
                </div>
                <div class="col-lg-2">
<!--                    <label>Section </label>
                    <select name="annuallstSection" id="annuallstSection" class="form-control">
                        <option value="all">All Section</option>
                        <?php
                        foreach ($asection as $sec) {
                            ?>
                            <option value="<?php echo $sec->id; ?>"><?php echo $sec->sec_name; ?></option>
                            <?php
                        }
                        ?>
                    </select>-->
                </div>
                <div class="col-lg-2">
<!--                    <label>Status </label>
                    <select class="form-control" name="status" id="status">
                        <option value="all">All</option>
                        <option value="TC">TC</option>
                        <option value="PASS">PASSOUT</option>
                        <option value="LEFTWITHOUT">Left Without Information</option>
                    </select>-->
                </div>
                <div class="col-lg-2">
<!--                    <label>Date</label>
                    
                        <input type="date" id="inputdate1" name="st_date" class="form-control" style="padding: 6px 4px;" value="<?php echo date('Y-m-d'); ?>" min="<?php echo $school_date_created;?>">
                    -->
                </div>

            </form>
            <div class="col-lg-4" style="text-align:right;">
                <?php // if(substr($right_access,0,1)=='C'){?>
                    <button class="btn btn-add" id="add_record" data-toggle="tooltip" data-placement="bottom" title="Add <?=e($rec_type)?>">
                            <i class="fa fa-plus-circle fa-lg"></i>&nbsp;
                        </button>

                    <?php // }?>
                  <!--   <a class="btn btn-export" id="studexport" href='<?= base_url() . uri_string() ?>/exportcsv/All/All' download data-toggle="tooltip" data-placement="bottom" title="Export Inactive Student">
                        <i class="fa fa-cloud-download fa-lg"></i>&nbsp;
                    </a> -->
                    <a class="btn btn-export" id="studexport" href='' download data-toggle="tooltip" data-placement="bottom" title="Export Inactive Student">
                        <i class="fa fa-cloud-download fa-lg"></i>&nbsp;
                    </a>
            </div>
        </div>
    </div>
    <div class="box">            

        <?php if ($this->session->flashdata('successmsg')) { ?>
        <div class="box-body">
            <div class="col-md-5 col-md-offset-3" style="height:40px">
                
                    <div class="col-md-12">
                        <div class="alert alert-success alert-dismissible"  id="success-alert">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong>Success!</strong><?php echo $this->session->flashdata('successmsg'); ?>
                        </div>
                    </div>
            </div>
        </div>
         <?php } else if($this->session->flashdata('errormsg')){ ?>
        <?php // if ($this->session->flashdata('errormsg')) { ?>
        <div class="box-body">
            <div class="col-md-5 col-md-offset-3" style="height:40px">
                
                    <div class="col-md-12">
                        <div class="alert alert-danger alert-dismissible"  id="success-alert">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong>Error !</strong><?php echo $this->session->flashdata('errormsg'); ?>
                        </div>
                    </div>
            </div>
        </div>
         <?php } else {  ?>
         <?php } ?>

        <div class="box-body">
            <form id='frmemployee' role="form" method="POST">
                <div class="table-responsive">
                    <table id="employeelist" class="table table-bordered table-striped">
                        <thead style="background:#99ceff;">
                            <tr> 

                                <th style="border-bottom:0px">#</th>
                                <th style="border-bottom:0px">Admission No.</th>
                                <th style="border-bottom:0px">Student Name</th>
                                <th style="border-bottom:0px">Date</th>
                                <th style="border-bottom:0px">Academic Session</th>
                                <th style="border-bottom:0px">Reason</th>
                                <th style="border-bottom:0px">Remark</th>
                                <th style="border-bottom:0px">Status</th> 
                                
                                <th style="border-bottom:0px">Action</th>
                            </tr>
                        </thead>
                        <thead style="background: #cce6ff">
                            <tr id="searchhead">
                                <th style="border-bottom:2px solid darkcyan;border-top:0px">
                                    <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="0"/>
                                </th>
                                <th style="border-bottom:2px solid darkcyan;border-top:0px">
                                    <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="1"/>
                                </th>
                                <th style="border-bottom:2px solid darkcyan;border-top:0px">
                                    <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="2"/>
                                </th>
                                <th style="border-bottom:2px solid darkcyan;border-top:0px">
                                    <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="3"/>
                                </th>
                                <th style="border-bottom:2px solid darkcyan;border-top:0px">
                                    <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="4"/>
                                </th>
                                <th style="border-bottom:2px solid darkcyan;border-top:0px">
                                    <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="5"/>
                                </th>
                                <th style="border-bottom:2px solid darkcyan;border-top:0px">
                                    <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="6"/>
                                </th>
                                <th style="border-bottom:2px solid darkcyan;border-top:0px">
                                    <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="7"/>
                                </th>
                                <th style="border-bottom:2px solid darkcyan;border-top:0px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            foreach ($tcstudent as $key=> $row):

                                ?>

                                <tr>
                                    <td><?php echo $count; ?></td>                                         
                                    <td><?php echo $row->admission_no; ?></td>                                         
                                    <td><?php echo $row->first_name.' '.$row->middle_name.' '.$row->last_name; ?></td>                                         
                                    <td><?php echo $row->date; ?></td>                                         
                                    <td><?php //echo $row->academic_year_id; ?></td>                                         
                                    <td><?php echo $row->reason; ?></td>                                         
                                    <td><?php echo $row->remarks; ?></td>                                         
                                    <td><?php echo $row->status; ?></td>           
                                                                      
                                    <td>
                                    <div class="form-group row">

                                    <?php // if(substr($right_access,2,1)=='U'){ ?>
                                    <div class="col-sm-2">
                                        <a class="btn a-edit" id="<?php echo $row->tc_id; ?>" href="<?php echo base_url(); ?>admission/TcStudent/EditTcStudentPage/<?php echo $row->tc_id; ?>" style="padding: 0px 8px;    display: table-cell;">
                                            <i class="fa fa-edit"></i> 
                                        </a>
                                        <a class="btn a-delete" id="<?php echo $row->tc_id; ?>" href="<?php echo base_url(); ?>admission/TcStudent/deleteTCstudent/<?php echo $row->tc_id; ?>" style="padding: 0px 8px;    display: table-cell;">
                                            <i class="fa fa-trash"></i> 
                                        </a>
                                    </div>
                                    <?php // } ?>
                                  <!--   <div class="col-sm-2">
                                        <a class="btn a-invoice" href="<?php echo base_url(); ?>certificate/certificate/direct_tc_certificate_pdf/<?php echo $row->student_id; ?>" id="tc_gen" value="" style="padding-left: 0px;" title="Generate TC" target="_blank">
                                            <i class="fa fa-print"></i> 
                                        </a>
                                    </div> -->
                                    </div>
                                    </td>
                                </tr>
                            <?php $count++;
                            endforeach; ?>
                        </tbody>
                        <tfoot></tfoot>
                    </table>
                </div>
            </form>
        </div>
        <!-- /.box-body -->
    </div>

    <!-- /.box -->
</div>
</div>

<script>
    var globalid = '';
    var school_temp = '';
    var newtxt = 1000;

 $(document).ready(function() {
    $('#add_record').click(function() {
            <?php if (!$modal_form['status']) { ?>
                window.location.href = '<?php echo base_url(); ?>' + '<?= uri_string() . '/add_form' ?>';

<?php } else { ?>
        save_method = 'add';
        $('#form')[0].reset(); // reset form on modals
                $('#errmodal').empty();
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
                $('select').trigger('change');
        $('#modal_form').modal('show'); // show bootstrap modal
        $('.modal-title').text('Add <?=$rec_type?>'); // Set Title to Bootstrap modal title
    <?php } ?>
     });
     });

    $(function ()
    {
        var table = $('#employeelist').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true
        });
        $('#searchhead th input').on('keyup change', function () {

            var i = $(this).attr('data-column');
            var v = $(this).val();
            table.columns(i).search(v).draw();
        });

    });

</script>





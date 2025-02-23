<div class="form-group has-feedback" id='loaddiv'>
    <div class="box">
        <div class="box-body">
            <div class="col-lg-2">
                <label>Class </label>
                <select class="form-control" name="class_list" id="class_list">
                    <option>All</option>
                    <?php foreach($class as $c){?>
                        <option value="<?php echo $c->id?>"><?php echo $c->class_name?></option>
                    <?php }?>
                </select>
            </div>
            <div class="col-lg-2">
                <label>Section </label>
                <select class="form-control" name="section_list" id="section_list">
                    <option>All</option>
                    <?php foreach($sectionj as $d){?>
                        <option value="<?php echo $d->id;?>"><?php echo $d->sec_name;?></option>
                    <?php }?>
                </select>
            </div>
<!--            <div class="col-lg-2">
                <label>Status </label>
                <select class="form-control" name="stud_status" id="stud_status">
                    <option>All</option>
                    <option value="Y">Y</option>
                    <option value="P">P</option>
                    <option value="N">N</option>

                </select>
            </div>-->
            <div class="col-lg-2">
                
            </div>
        </div>
    </div>
    <div class="box">
        <!--			<div class="box-body">
        <div class="col-lg-12">
        
        </div>
        </div>-->

        <div class="box-body">
            <form id='frmclass' role="form" method="POST">
                <div class="table-responsive">
                    <table id="datalist" class="table table-bordered table-striped">
                        <thead style="background:#99ceff;">
                            <tr>
                                <?php
                                $colcnt = 0;
                                $hiddencols = array();
                                foreach ($display_columns as $field => $disp) {

                                    echo "\t\t\t\t\t\t\t\t<th style='border-bottom:0px;width:900px;'>$disp</th>\n";
                                    $colcnt++;
                                }
                                ?>
                                <th style="border-bottom:0px">Actions</th>
                            </tr>
                        </thead>
                        <thead style="background: #cce6ff">
                            <tr id="searchhead">
                                <?php
                                $colcnt1 = 0;
                                foreach ($display_columns as $field => $disp) {
                                    ?>
                                    <th style="border-bottom:2px solid darkcyan;border-top:0px">
                                        <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="<?php echo $colcnt1; ?>"/>
                                    </th>

                                    <?php
                                    $colcnt1++;
                                }
                                ?>
                                <th style="border-bottom:2px solid darkcyan;border-top:0px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <!--<tr>-->
                            <?php
//                            if (isset($data) && count($data) > 0) {
//                                foreach ($data as $rec) {
//                                    echo "\t\t\t\t\t\t\t<tr>\n";
                                    foreach ($stud_report as $disp) { 
//                                        print_r($disp); ?>
                                
                            <tr>
                                        <td width="5%"><?php echo $disp->id; ?></td>
                                        <td width="5%"><?php echo $disp->admission_no; ?></td>
                                        <td width="15%"><?php echo $disp->stud_name; ?></td>
                                        <td width="20%"><?php echo $disp->father_name; ?></td>
                                        <td width="12%"><?php echo $disp->dob; ?></td>
                                        <td width="8%"><?php echo $disp->stud_category_disp; ?></td>
                                        <!--<td width="30%"><?php // echo $disp->email_address; ?></td>-->
                                        <td width="8%"><?php echo $disp->phone; ?></td>
                                        <td width="5%"><?php echo $disp->class_id_disp; ?></td>
                                        <td width="5%"><?php echo $disp->section_id_disp; ?></td>
                                        <!--<td width="10%"><?php echo $disp->acedemic_id_disp; ?></td>-->
                                        <td width="17%"><a class="btn-xs btn btn-success" data-toggle="modal" onclick="approve(<?php echo $disp->id; ?>);" style="font-size: 12px;"><i class="fa fa-check"></i>Approve</a>
                                        <a class="btn-xs btn btn-danger" data-toggle="modal" onclick="reject(<?php echo $disp->id; ?>);" style="font-size: 12px;"><i class="fa fa-close"></i>Reject</a></td>
                            </tr>
                                <?php }?>
<!--                                                                                                                                                                                               -->
                                <!--</tr>-->
                        </tbody>
                        <tfoot>
                        </tfoot>
                    </table>
                </div>
            </form>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
</div>

<script>
                                            
                                            function approve(id) {
                                            alert(id);
                                                var r = confirm('Are you sure you want to approve this Student?');
                                                if (r == true) {
                                                    var dataval = {'id': id};
                                                    $.ajax({
                                                        url: "<?php echo base_url('admission/student/approve/'); ?>" + id,
                                                        type: "POST",
                                                        data: dataval,
                                                        dataType: "text",
                                                        success: function (data) {
                                                            window.location.reload();
                                                        },
                                                        error: function (data, status) {
                                                            alert('Error Approving <?= $rec_type ?>.');
                                                        }
                                                    });
                                                } else {
                                                    return false;
                                                }
                                            }
                                            
                                            function reject(id) {
                                            alert(id);
                                                var r = confirm('Are you sure you want to reject this Student?');
                                                if (r == true) {
                                                    var dataval = {'id': id};
                                                    $.ajax({
                                                        url: "<?php echo base_url('admission/student/reject/'); ?>" + id,
                                                        type: "POST",
                                                        data: dataval,
                                                        dataType: "text",
                                                        success: function (data) {
                                                            alert("Rejected Successfully");
                                                            window.location.reload();
                                                            
                                                        },
                                                        error: function (data, status) {
                                                            alert('Error Rejecting <?= $rec_type ?>.');
                                                        }
                                                    });
                                                } else {
                                                    return false;
                                                }
                                            }




</script>


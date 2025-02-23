<div class="form-group has-feedback" id='loaddiv'>
    <div class="box">
        <div class="box-body">
        	  <div class="col-lg-2">
                <label>Academic Session</label>
                <select class="form-control" name="session_list" id="session_list">
                    <option>All</option>
                    <?php foreach($asession as $ses){?>
                        <option value="<?php echo $ses->id?>"><?php echo $ses->session?></option>
                    <?php }?>
                </select>
            </div>
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
            <?php if($this->school[0]->school_group =='ARMY') { ?>
            <div class="col-lg-2">
                <label>Status </label>
                <select class="form-control" name="stud_status" id="stud_status">
                    <option value="Y">APPROVED</option>
                    <option value="P">PENDING</option>
                    <option value="N">REJECTED</option>
                </select>
            </div>
            
            <?php }else{ ?>
            <div class="col-lg-2" style="display: none">
            <select class="form-control" name="stud_status" id="stud_status">
                <option value="Y" selected>APPROVED</option>
            </select>
                </div>
            <?php }?>
            <div class="col-lg-2"></div>
            <div class="col-lg-6" style="text-align:right;">
			<div id="bulkbuttonshow" style="display:none;margin: 22px 0px -34px 256px;width:30px">
             <a class="btn btn-success" onclick="bulkapprove()"><i class="fa fa-check"></i>Bulk Approve</a>
            </div>
                <?php
//if (!$read_only) {
                if (substr($right_access, 0, 1) == 'C') {
                    ?>
                    <button class="btn btn-add" id="add_record" data-toggle="tooltip" data-placement="bottom" title="Add <?=e($rec_type)?>">
                        <i class="fa fa-plus-circle fa-lg"></i>&nbsp;
                    </button>
                    <?php
                }
                ?>
                <?php //if(($this->session->userdata('school_id')==5) || ($this->session->userdata('school_id')==37)) { ?>
<!--                 <a class="btn btn-export" id="studexport" href='<?= base_url() . uri_string() ?>/exportcsv/All/All/Y' download data-toggle="tooltip" data-placement="bottom" title="Export <?=e($rec_type)?>">
                    <i class="fa fa-cloud-download fa-lg"></i>&nbsp;
                </a> -->
            <?php //} else{ ?>

                 <!-- <a class="btn btn-export" id="studexport" href='#' data-toggle="tooltip" data-placement="bottom" title="Export <?=e($rec_type)?>">
                    <i class="fa fa-cloud-download fa-lg"></i>&nbsp;
                </a> -->
            <?php //} ?>

             <a class="btn btn-export" id="studexport" href='<?= base_url() . uri_string() ?>/exportcsv/All/All/All/Y' download data-toggle="tooltip" data-placement="bottom" title="Export <?=e($rec_type)?>">
                    <i class="fa fa-cloud-download fa-lg"></i>&nbsp;
                </a>
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
                                    echo "\t\t\t\t\t\t\t\t<th style='border-bottom:0px'>$disp</th>\n";
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
                            <?php
                            if (isset($data) && count($data) > 0) {
                                foreach ($data as $rec) {
                                    echo "\t\t\t\t\t\t\t<tr>\n";
                                    foreach ($display_columns as $field => $disp) {
                                        echo "\t\t\t\t\t\t\t\t<td id='{$field}-{$rec->$rec_key}'>{$rec->$field}</td>\n";
                                    }
                                    ?>
                                <td>
                                    <?php
//if (!$read_only) {
                                    ?>      
                                    <?php if (substr($right_access, 2, 1) == 'U') { ?>
                                        <a class="btn a-edit" onclick="edit_rec('<?= $rec->$rec_key ?>');"><i class="fa fa-edit"></i>Edit</a>
                                    <?php } ?>
                                    <?php if (substr($right_access, 3, 1) == 'D') { ?>
                                        <a class="btn a-delete" data-toggle="modal" onclick="delete_rec('<?= $rec->$rec_key ?>');"><i class="fa fa-trash"></i>Delete</a>
                                    <?php } ?>
                                    <?php
//}
                                    ?>
                                    <?php if (isset($edit_columns['lat']) && isset($edit_columns['long'])) { ?>
                                        <a class="btn" target='_blank' href='https://www.google.com/maps/place/<?= $rec->location_description ?>/@<?= $rec->lat ?>,<?= $rec->long ?>,8z'><i class="fa fa-map"></i>Map</a>
        <?php } ?>
                                </td>                                                                                                                                                                     
                                </tr>
                                <?php
                            }
                        }
                        ?>
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
    var globalid = '';
    var url = "<?php echo base_url(); ?>";
    var newtxt = 1000;
   var table;
    $(document).ready(function () {
        datatable();
        $('#add_record').click(function () {
<?php if (!$modal_form['status']) { ?>
                window.location.href = '<?php echo base_url(); ?>' + '<?= uri_string() . '/add_form' ?>';

<?php } else { ?>
                save_method = 'add';
                $('#form')[0].reset(); // reset form on modals
                $('#errmodal').empty();
                $('.form-group').removeClass('has-error'); // clear error class
                $('.help-block').empty(); // clear error string
                $('#modal_form').modal('show'); // show bootstrap modal
                $('.modal-title').text('Add <?= $rec_type ?>'); // Set Title to Bootstrap modal title
<?php } ?>
        });
        
        $('#session_list' + ',#class_list' + ',#section_list' + ',#stud_status').change(function (){
            datatable();
            $('#studexport').attr('href', '<?= base_url() . uri_string() ?>/exportcsv' + '/' + $('#session_list').val() +  '/' + $('#class_list').val() + '/' + $('#section_list').val() + '/' + $('#stud_status').val());
        });
     
        function datatable()
        {
            table = $('#datalist').DataTable({
                "destroy": true,
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "columnDefs": [
    <?php
    foreach ($hiddencols as $col) {
        echo "\t\t{\n";
        echo "\t\t\t\"targets\": [ $col ],\n";
        echo "\t\t\t\"visible\": false,\n";
        echo "\t\t},\n";
    }
    ?>
                ],
                serverSide: true,
                ajax: {
                    url: '<?php echo base_url(); ?>' + '<?= uri_string() . '/paged_data' ?>',
                    type: 'POST',
                    data: {session_id: $('#session_list').val(),
                    class_id: $('#class_list').val(),
                            section_id: $('#section_list').val(),
                            status: $('#stud_status').val()

                        }
                },
            });
        }
        
    });
    
    $('#searchhead th input').on('keyup change', function () {
//            if ( this.search() !== this.value ) {
//                this
//                    .search( this.value )
//                    .draw();
//            }
            var i = $(this).attr('data-column');
            var v = $(this).val();
            table.columns(i).search(v).draw();
        });

<?php
if (!$read_only) {
    ?>

        function edit_rec(id) {

    <?php if (!$modal_form['status']) { ?>
                window.location.href = '<?php echo base_url(); ?>' + '<?= uri_string() . '/edit_form/' ?>' + id;

    <?php } else { ?>

                $('#errmodal').empty();
                $('#form')[0].reset();
                $('.form-group').removeClass('has-error'); // clear error class
                $('.help-block').empty(); // clear error string
                $.ajax({
                    url: "<?php echo base_url(); ?>/<?= uri_string() . '/getrec/' ?>" + id,
                                type: "POST",
                                dataType: "json",
                            })
                                    .done(function (msg) {
                                        console.log(msg);
        <?php
        foreach ($edit_columns as $col => $colparams) {
            if ($colparams['type'] == 'select') {
                echo "\t\t\t\tvar idx=msg[\"0\"].$col;\n";
                echo "\t\t\t\t$('#$col option').filter(function(){\n";
                echo "\t\t\t\t\treturn this.id === idx\n";
                echo "\t\t\t\t}).prop('selected', true);\n";
            } else {
                echo "\t\t\t\t$('#$col').val(msg[\"0\"].$col);\n";
            }
        }
        ?>
                                    })
                                    .fail(function (msg) {
                                        console.log(msg);
                                    });
                            globalid = id;
                            save_method = 'update';
                            $('#modal_form').modal('show'); // show bootstrap modal
                            $('.modal-title').text('Update <?= $rec_type ?>'); // Set Title to Bootstrap modal title
                            return false;
    <?php } ?>
                    }





                                            function delete_rec(id) {
                                                var r = confirm('Are you sure you want to delete this record?');
                                                if (r == true) {
                                                    var dataval = {'id': id};
                                                    $.ajax({
                                                        url: url + "/<?= uri_string() . '/delete/' ?>" + id,
                                                        type: "POST",
                                                        data: dataval,
                                                        dataType: "text",
                                                        success: function (data) {
                                                            window.location.reload();
                                                        },
                                                        error: function (data, status) {
                                                            alert('Error deleting <?= $rec_type ?>.');
                                                        }
                                                    });
                                                } else {
                                                    return false;
                                                }
                                            }

                                            function approve(id) {
//                                            alert(id);
                                                var r = confirm('Are you sure you want to approve this Student?');
                                                if (r == true) {
                                                    var dataval = {'id': id};
                                                    $.ajax({
                                                        url: url + "/<?= uri_string() . '/approve/' ?>" + id,
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
//                                            alert(id);
                                                var r = confirm('Are you sure you want to reject this Student?');
                                                if (r == true) {
                                                    var dataval = {'id': id};
                                                    $.ajax({
                                                        url: url + "/<?= uri_string() . '/reject/' ?>" + id,
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




    <?php
}
?>
function bulkapprove()
  {
	  
                var r = confirm("Are you sure you want to Approve this record?");
//                var id='1';
                if(r == true)
                 {
                      var student_id_string =[];
                      var i=0;
                      $("input:checked").each(function () 
                      {
                            student_id_string[i]= $(this).attr("id");
                            alert(student_id_string);
                            i++;
                      });

                    $.ajax({
                          url : "<?php echo site_url('admission/Student/bulkapprove');?>",
                          type: "POST",
                          data: {student_id_string:student_id_string},
                          dataType: "text",
                          success: function(data)
                          {
                              alert("Approve Successfully");
                              window.location.reload();
//                               window.location.href = "<?php echo base_url('admission/Student');?>";                       
                          },
                          error : function(data,status)
                          {
                                alert('e'+data+status);
                      }});
//
                  }
  }
     $('#stud_status').change(function () {
        if (this.value == 'P') {
            $('#bulkbuttonshow').css('display', 'block');
        } else
        {
            $('#bulkbuttonshow').css('display', 'none');
        }
    });
</script>


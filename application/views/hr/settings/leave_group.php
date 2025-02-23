

<div class="form-group has-feedback">
    <div class="box">            
        <div class="box-body">
            <?php if (substr($right_access, 0, 1) == 'C') { ?>
                <div class="col-lg-12">
                    <div class="col-lg-12" style="text-align:right;"><button  class="btn btn-add" id="add_leave_group" title="Add Leave Group"> <i class="fa fa-plus-circle fa-lg"></i> </button></div>

                </div>
            <?php } ?>
        </div>





        <div class="box-body">


            <form id='frmtemplate' role="form" method="POST">
                <div class="table-responsive">
                    <table id="leavgrouplist" class="table table-bordered table-striped">
                        <thead style="background:#99ceff;">
                            <tr>
                                <th style="border-bottom:0px">#</th>
                                <th style="border-bottom:0px">Leave Group Description</th>                                                                         
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

                                <th style="border-bottom:2px solid darkcyan;border-top:0px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            foreach ($fetch_leave as $row):
                                ?>

                                <tr>
                                    <td><?php echo $row->id; ?> </td>
                                    <td><?php echo $row->leave_group_name; ?></td>                                                                                                    
                                    <td>
                                        <div class="form-group row">
    <?php if (substr($right_access, 3, 1) == 'D') { ?>
                                                <div class="col-sm-1" >
                                                    <input type="checkbox" class="btn"  id="<?php echo $row->id; ?>">
                                                </div>
    <?php } if (substr($right_access, 2, 1) == 'U') { ?>
                                                <div class="col-sm-2">
                                                    <a class="btn a-edit" id="<?php echo $row->id; ?>">
                                                        <i class="fa fa-edit"></i> 
                                                    </a>
                                                </div>
    <?php } ?>
                                        </div>
                                    </td>

                                </tr>
<?php endforeach; ?>
                        </tbody>

                    </table>
                </div>
                    <?php if (substr($right_access, 3, 1) == 'D') { ?>
                    <div class="box-body" style="text-align:right">
                        <?php if (count($fetch_leave) > 0) { ?>              
                            <input type="button" class="btn btn-danger" id="emp_cats" value="Delete" onclick="deleteLeavegroup();">
    <?php } ?>

                    </div>
<?php } ?>

            </form>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
</div>



<script>

    $(document).ready(function ()
    {
        $('#add_leave_group').click(function ()
        {


            window.location.href = "<?php echo base_url('hr/settings/leave_group/add'); ?>";

        });


    });


    $(function ()
    {
        var table = $('#leavgrouplist').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true
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

    });

//----------------------Edit operation-----------------------------
    $('#leavgrouplist a').click(function ()
    {

        var id = $(this).attr('id');


        window.location.href = "<?php echo base_url('hr/settings/leave_group/edit'); ?>" + '/' + id;

    });
//--------------------------------------------------------------------

//    $('#btn_save').click(function()
//    {
//            var formdata=$('#frmleavetype').serialize();
//            var action_url=$('#frmleavetype').attr('action');
////             alert(formdata);
//
//
//        $.ajax
//        ({
//            type:'POST',
//            data:formdata,
//            url: action_url,
//            datatype:"text",
//            success: function(data)
//            {
//                window.location.href = '<?php echo base_url('hr/settings/leave_type'); ?>';
//
//            },
//            error: function(data)
//            {
//                alert('error occured while saving'+data);
//            }
//
//        });
//
//    });










    function deleteLeavegroup()
    {
        var r = confirm("Are you sure you want to delete this record?");
//                var id='1';
        if (r == true)
        {
            var leave_group_id_string = [];
            var i = 0;
            $("input:checked").each(function ()
            {
                leave_group_id_string[i] = $(this).attr("id");
                i++;
            });

//
            $.ajax({
                url: "<?php echo site_url('hr/settings/leave_group/delete') ?>",
                type: "POST",
                data: {leave_group_id_string: leave_group_id_string},
                dataType: "text",
                success: function (data)
                {
                    window.location.href = "<?php echo base_url('hr/settings/leave_group'); ?>";
//                         
                },
                error: function (data, status)
                {
                    alert('e' + data + status);
                }});

        }
    }

</script>





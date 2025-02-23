
<div class="form-group has-feedback" id="load">
    <div class="box">


        <div class="box-body">
            <div class="col-lg-12">
                <div class="col-lg-12" style="text-align:right;"><button class="btn btn-add" id="add_class_fee" title="Add Instant Fee"> <i class="fa fa-plus-circle fa-lg"></i> </button></div>

            </div>
        </div>

        <div class="box-body">


            <form id='frmtemplate' role="form" method="POST">
                <div class="table-responsive">
                    <table id="templatelist" class="table table-bordered table-striped ">
                        <thead style="background:#99ceff;">
                            <tr>
                                <th style="border-bottom:0px">#</th>
                                <!--<th style="border-bottom:0px">Student Id</th>-->
                                <th style="border-bottom:0px">Admission No</th>
                                <th style="border-bottom:0px">Fee Name</th>

                                <th style="border-bottom:0px">Amount</th>
                                <th style="border-bottom:0px">Allocation Date</th>
                                <th style="border-bottom:0px">Remarks</th>
                                <th style="border-bottom:0px">Paid Status</th>
                                <th style="border-bottom:0px"> Action </th>

                            </tr>
                        </thead>
                        <thead style="background: #cce6ff">
                            <tr id="searchhead">
                                <th style="border-bottom:2px solid darkcyan;border-top:0px"></th>
                                <!--<th style="border-bottom:2px solid darkcyan;border-top:0px"></th>-->
                                <th style="border-bottom:2px solid darkcyan;border-top:0px"></th>
                                <th style="border-bottom:2px solid darkcyan;border-top:0px"></th>
                                <th style="border-bottom:2px solid darkcyan;border-top:0px"></th>
                                <th style="border-bottom:2px solid darkcyan;border-top:0px"></th>
                                <th style="border-bottom:2px solid darkcyan;border-top:0px"></th>
                                <th style="border-bottom:2px solid darkcyan;border-top:0px"></th>
                                <th style="border-bottom:2px solid darkcyan;border-top:0px"></th>

                            </tr>
                        </thead>
                        <tbody>

                            <?php foreach ($instant_fee as $obj_fee) {
                                ?>
                                <tr>
                                    <td> <?php echo $obj_fee->id; ?></td>
                                    <!--<td> <?php // echo $obj_fee->student_id; ?></td>-->
                                    <td><?php echo "$obj_fee->admission"; ?></td>
                                    <td><?php echo "$obj_fee->fee_name"; ?></td>

                                    <td><?php echo $obj_fee->amount; ?></td>
                                    <td><?php echo date('d-m-Y',strtotime($obj_fee->date_created)); ?></td>
                                    <td><?php echo $obj_fee->remarks; ?></td>
                                    <td><?php if($obj_fee->paid_status==1) {$c='btn btn-success';$s= 'Paid';}else{$c='btn-danger'; $s= 'UnPaid';}  ?>
                                        <button type="button" class="btn <?php echo $c;?>"><?php echo $s;?></button>
                                    </td>
                                    <td>

                                        <?php if($obj_fee->paid_status!=1) {?>
                                        <a class="btn a-delete" data-toggle="modal" onclick="deleteinstant('<?php echo $obj_fee->id; ?>');">
                                            <i class="fa fa-trash"></i>  Unallocate
                                          </a>
                                        <?php }?>
                                    </td>
                                </tr>

                            <?php } ?>     
                        </tbody>
                    </table>
                </div>
                <div class="box-body" style="text-align:right">

<!-- <div class="col-lg-2"><input type="button" class="btn btn-success" id="add_template" value="Add Template"></div> -->
                    <?php // if (count($instant_fee) > 0) { ?>
    <!--                    <input type="button" class="btn btn-success" id="save_fee_type" value="Save">-->
                        <!--<input type="button" class="btn btn-danger" id="delete_template" value="Delete" onclick="deleteClassFee();">-->
                    <?php // } ?>

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

    $(document).ready(function ()
    {
//        $(function () {

            $('#templatelist').DataTable({
                "paging": true,
//                "lengthChange": true,
//                "searching": true,
//                "ordering": true,
                "info": true,
                "autoWidth": true,
//                "order": [[1, "desc"]]
                dom: 'Bfrtip',
                buttons: [
                {
                    extend: 'collection',
                    text: 'Export',
                    buttons: [

                        'excel',
                        'csv',
                        'print'

                    ]
                }
        ]

            });

//        });


        $('#add_class_fee').click(function ()
        {


            window.location.href = "<?php echo base_url('feepayment/instant_fee/add_form'); ?>";

        });


    });

//    function deleteClassFee()
//    {
////       alert('hello');
//        var fee_id = '';
//        $("#templatelist :checkbox").each(function () {
//            if (this.checked)
//            {
//
//                if (fee_id == '') {
//                    fee_id = this.id;
//                } else {
//                    fee_id += '|' + this.id;
//                }
//            }
//
//        });
//
//        var r = confirm('Are you sure you want to delete this record?');
//        if (r == true) {
//
//            $.ajax({
//                url: "<?php // echo site_url('feepayment/class_fee/delete_class_fee') ?>",
//                type: "POST",
//                data: {fee_id: fee_id},
//                dataType: "text",
//                success: function (data)
//                {
//                    window.location.reload();
//                },
//                error: function (data)
//                {
//                    alert('Error deleting class.');
//
//                }
//            });
//        } else {
//            return false;
//        }
//    }

//    function updateClassFee(id, year, from_class, to_class, stud_cat)
//    {
////    alert('hi');
////    window.location.href = "<?php // echo base_url('Fee/editClassFee'); ?>";
//        window.location.href = "<?php // echo site_url('feepayment/class_fee/editClassFee') ?>" + '/' + id;
//      $.ajax({
//            url : "<?php // echo site_url('feepayment/class_fee/editClassFee') ?>",
////            type: "POST",
////            data: {
////                id:id,
////                year:year,
////                from:from_class,
////                to:to_class,
////                cat:stud_cat
////            },
////            dataType: "text",
////            success: function(data)
////            {
//////                alert(data);
////               $('#load').html(data);
////            },
////            error: function (data)
////            {
////                alert('Error');
////
////            }
////        });
//    }

function deleteinstant(id)
{

  var r = confirm('Are you sure you want to unallocate Instant Fee for this Student?');
  if(r == true){
    var dataval = { 'ida' : id } ;
    $.ajax({
          url : "<?php echo site_url('feepayment/instant_fee/deleteinstant')?>",
          type: "POST",
          data: dataval,
          dataType: "text",
          success: function(data)
          {
              alert("Successfully Unallocated");
             window.location.reload();
          },
          error: function (data, status)
          {
              alert('Error deleting instant.');

          }
      });
  }else{
    return false;
  }
}
</script>







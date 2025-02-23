<div class="form-group has-feedback">
    <div class="box panel panel-default"> 
<!--        <div class="panel-heading">
            <i class="fa   fa-hourglass-3"> </i> <label>Student Data Migration</label>
        </div>-->
        <div class="box-body">
            <div class="col-sm-4" style="height: 90px;width: 90px;border-radius: 50px;background: beige;border: 2px solid gold;text-align: center;display: flex;align-items: center;justify-content: center;"><?php echo $previousSession; ?></div>
            <div class="col-sm-2" style="height: 90px;text-align: center;display: flex;align-items: center;justify-content: center;color: #00cc66"><i class="fa fa-long-arrow-right fa-lg" style="font-size: 7.333333em;" aria-hidden="true"></i></div>
            <div class="col-sm-4" style="height: 90px;width: 90px;border-radius: 50px;background: beige;border: 2px solid gold;text-align: center;display: flex;align-items: center;justify-content: center;"><?php echo $nextSession; ?></div>
            <?php if(date('m')<$appliedmonth && date('m')>$appliedmonth+3) {?>
            <div class="col-sm-4" style="height: 90px;text-align: center;display: flex;align-items: center;justify-content: center;"><button class="btn btn-danger" style="width:100%;white-space: normal;word-wrap: break-word;">Its Not a Time for PROMOTION/PASSOUT ! </button></div>
            <?php }?>
        </div>
    </div>

    <div class="box panel panel-default"> 
        <div class="panel-heading">
            <i class="fa   fa-hourglass-3"> </i> <label>Class Promotion</label>
        </div>
        <div class="box-body">
            <form id="transfer" name="transfer" method="POST">
                <div class="row" style="margin-bottom: 10px;">  
                    <div class="col-md-2" style="text-align: center">From Class</div>
                    <div class="col-md-2">
                        <select name="from_class" id="from_class" class="form-control">
                            <option value="">Select Class</option>
                            <?php foreach ($aclass as $cls) { ?>
                                <option value="<?php echo $cls->id; ?>"> <?php echo $cls->class_name; ?></option>
                            <?php } ?>
                        </select>
                    </div>


                    <div class="col-md-1">To Class</div>
                    <div class="col-md-2">
                        <select name="to_class" id="to_class" class="form-control">
                            <option value="">Select Class</option>
                            <option value="same">Same Class</option>
                            <?php foreach ($aclass as $cls) { ?>
                                <option value="<?php echo $cls->id; ?>"> <?php echo $cls->class_name; ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-md-5"> 
                        <!--<input type="button" class="btn btn-danger" id="promote" value="NotPromote">-->
                        <input type="button" class="btn btn-warning" id="promote" value="Promote" <?php if($nextSessionID==0 || (date('m')<$appliedmonth && date('m')>$appliedmonth+3)) echo 'disabled=true';?>>
                        <input type="button" class="btn btn-success" id="passout" value="PassOut ( Alumini )" <?php if($nextSessionID==0 || (date('m')<$appliedmonth && date('m')>$appliedmonth+3)) echo 'disabled=true';?>>
                        <!--<input type="button" class="btn btn-info" id="tc" value="TC" <?php // if($nextSessionID==0 || $appliedmonth!=date('m')) echo 'disabled=true';?>>-->
                    </div>
                </div>
                <div id="div_transfer_student" class="row">
                    <div class="overlay" id="preloader" style="display:none;">
                            <i class="fa fa-refresh fa-spin" style="top: 13%;color:#f39c12"></i>
                        </div>
                    <div class="col-md-12">
                        
                        
                            <table id="student_promote" class="table table-bordered table-striped table-fixed" style="margin-top: 25px; width:100%;">
                                <thead style="background: #99ceff">
                                    <tr>
                                        <th style="border-bottom:0px">  </th>
                                        <th style="border-bottom:0px">Admission No</th>
                                        <th style="border-bottom:0px"> Student Name </th>
                                        <th style="border-bottom:0px"> Section </th>
                                        <th style="border-bottom:0px"> Course( If Any) </th>
                                    </tr>
                                </thead>
                                <thead style="background: #cce6ff">
                                    <tr id="searchhead">
                                        <th style="border-top:0px">  </th>
                                        <th style="border-top:0px"></th>
                                        <th style="border-top:0px"></th>
                                        <th style="border-top:0px"></th>
                                        <th style="border-top:0px"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="5" id="loading" style="text-align: center;font-weight:bold"></td>
                                    </tr>
                                </tbody>
                            </table>
                       
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $('#from_class').change(function()
    {
        var clas=this.value;
        
        $('#div_transfer_student #preloader').css('display','inline-block');
//        $("#div_transfer_student #preloader").fadeOut("slow");
        
        $.ajax({
           type:'POST',
           url:'<?php echo base_url('admission/Promotion_passout/load_bulk_promote')?>',
           data:
           {
               class:clas,
           },
           success:function(data)
           {
               $('#div_transfer_student').html(data);
               $('#div_transfer_student #preloader').css('display','none');
           },
           error:function(req,status)
           {
               alert('error while loading');
           }

        });
    });
    
    
    
    $('#promote').click(function()
    {  
         var to_cls=$('#to_class').val();
         var val=0;
         $('input:checked[name="chk_row[]"]').each(function() 
          {

                var $this = $(this);
                if($this.is(":checked"))
                {
                    val=1;
                    return;

                }

          });
         // alert($('#transfer').serialize());
           if(to_cls=='' || val==0) 
           {
               alert('please select class and student to be promoted');
           }

           else
           {
               
               var r = confirm("Are You Sure Want to Promote these Students? ");

               if(r==true){
                    $.ajax({
                       type:'POST',
                       url:"<?php echo base_url('admission/Promotion_passout/promote_class')?>",
                       data:$('#transfer').serialize(),
                       datatype:'text',
                       success:function(data)
                      {
                         alert('Selected Student Successfully Promoted!!!!');
                         $.ajax({
                             type:'POST',
                             url:'<?php echo base_url('admission/Promotion_passout/load_bulk_promote')?>',
                             data:
                             {
                                 class:$('#from_class').val(),
                             },
                             success:function(data)
                             {
                                 $('#div_transfer_student').html(data);
                             },
                             error:function(req,status)
                             {
                                 alert('error while loading');
                             }

                          });
                      },
                      error:function(req,status)
                      {
                          alert('Error while promoting');
                      }
                    });
               }
           }

    });
    
    
    
    $('#passout').click(function(){
    
        var from_cls=$('#from_class').val();
        var val=0;
        $('input:checked[name="chk_row[]"]').each(function() 
        {

                var $this = $(this);
                if($this.is(":checked"))
                {
                    val=1;
                    return;

                }

        });
        if(from_cls==''|| val==0) 
        {
           alert('please select class and student to be promoted');
        }
        else{
            
            var r = confirm("Are You Sure Want to PassOut these Students From School? ");

               if(r==true){
                        $.ajax({
                              type:'POST',
                              url:"<?php echo base_url('admission/Promotion_passout/passout_class')?>",
                              data:$('#transfer').serialize(),
                              datatype:'text',
                              success:function(data)
                             {
                                alert('Selected Student Successfully PassOut from the School!!!!');
                                $.ajax({
                                    type:'POST',
                                    url:'<?php echo base_url('admission/Promotion_passout/load_bulk_promote')?>',
                                    data:
                                    {
                                        class:$('#from_class').val(),
                                    },
                                    success:function(data)
                                    {
                                        $('#div_transfer_student').html(data);
                                    },
                                    error:function(req,status)
                                    {
                                        alert('error while loading');
                                    }

                                 });
                             },
                             error:function(req,status)
                             {
                                 alert('Error while promoting');
                             }
                           });
               }
        }
        
    });
    
    
//    $('#tc').click(function(){
//    
//        var from_cls=$('#from_class').val();
//        var val=0;
//        $('input:checked[name="chk_row[]"]').each(function() 
//        {
//
//                var $this = $(this);
//                if($this.is(":checked"))
//                {
//                    val=1;
//                    return;
//
//                }
//
//        });
//        if(from_cls==''|| val==0) 
//        {
//           alert('please select class and student to be promoted');
//        }
//        else{
//            
//            var r = confirm("Are You Sure Want to TC these Students From School? ");
//
//               if(r==true){
//                        $.ajax({
//                              type:'POST',
//                              url:"<?php echo base_url('admission/Promotion_passout/tc_class')?>",
//                              data:$('#transfer').serialize(),
//                              datatype:'text',
//                              success:function(data)
//                             {
//                                alert('Selected Student Successfully Leave the School!!!!');
//                                $.ajax({
//                                    type:'POST',
//                                    url:'<?php echo base_url('admission/Promotion_passout/load_bulk_promote')?>',
//                                    data:
//                                    {
//                                        class:$('#from_class').val(),
//                                    },
//                                    success:function(data)
//                                    {
//                                        $('#div_transfer_student').html(data);
//                                    },
//                                    error:function(req,status)
//                                    {
//                                        alert('error while loading');
//                                    }
//
//                                 });
//                             },
//                             error:function(req,status)
//                             {
//                                 alert('Error while promoting');
//                             }
//                           });
//               }
//        }
//        
//    });
</script>
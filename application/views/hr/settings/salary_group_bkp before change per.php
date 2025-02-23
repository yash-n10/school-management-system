
<div class="form-group has-feedback">
    <div class="box box-primary">            
        <div class="box-body">
            <?php //if(substr($right_access,0,1)=='C'){?>
            <div class="col-lg-12">
                <div class="col-lg-12" style="text-align:right;"><button data-toggle="modal" class="btn btn-add" id="add_salary_group"> <i class="fa fa-plus-circle fa-lg"></i> </button></div>
              
            </div>
            <?php //}?>  
        </div>


            
            <div class="box-body">
            

              <form id='frmtemplate' role="form" method="POST">
                  <div class="table-responsive">
                <table id="salary_structure_list" class="table table-bordered table-striped">
                      <thead style="background:#99ceff;">
                          <tr>
                              <th style="border-bottom:0px">#</th>
                              <th style="border-bottom:0px">Salary Group Description</th>                                                                     
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
                  foreach($salary_group as $row):?>
               
                        <tr>
                          <td><?php echo $row->id;?> </td>
                          <td><?php echo $row->salary_group_name;?></td>          
     					  
                          <td>
                              <div class="form-group row">
                                    <div class="col-sm-1" style="line-height: 2;">
                                        <input type="checkbox" class="btn"  id="<?php echo $row->id; ?>">
                                    </div>
                                    <div class="col-sm-2">
                                     <a class="btn a-edit" id="<?php echo $row->id;?>">
                                      <i class="fa fa-edit"></i>
                                    </a>
                                    </div>
                              </div>
                          </td>     
                        </tr>
                 <?php endforeach;?>
                  </tbody>
                 
                </table>
              </div>
                <?php //if(substr($right_access,3,1)=='D'){?>
                  <div class="box-body" style="text-align:right">
                    <?php if(count($salary_group) > 0){?>              
                    <input type="button" class="btn btn-danger" id="emp_cats" value="Delete" onclick="deleteClass();">
                    <?php// }   ?>
                    
                  </div>
               <?php }?>

                 </form>
            </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
</div>

<div id="div_salary_structure" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <form action="<?php // echo base_url('Payroll/salary_structure/save') ?>" method="post" id="frm_salary_structure">
                <div class="modal-header" id="modal_header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3 class="modal-title">Add Salary Type</h3>
                </div>
                <div class="modal-body" id="modal-body">
                    <div class="form-group">
                        <label class="col-md-4">Salary Code</label>
                        <div class="col-md-8" style='padding-bottom:1%'>
                            <input type="text" class="form-control" id="scode" name="scode" placeholder="Salary Code" value=''>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4">Salary Name</label>
                        <div class="col-md-8" style='padding-bottom:1%'>
                            <input type="text" class="form-control" id="sname" name="sname" placeholder="Salary Name" value=''>
                        </div>
                    </div>

                </div>
                <!--<div class="modal-footer" id="modal-footer">-->
                <div class="row" id="modal-footer">
                    <button type="button" class="btn btn-success" id="btn_save">Save</button>
                </div>
            </form>
            <!--</div>-->
        </div>

    </div>
</div>


<div id="mySalaryView" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3 class="modal-title" style="color:darkgreen">Salary Structure</h3>
      </div>
      <div class="modal-body">
          <table class="table table-bordered table-striped" >
              <thead class="table-header">
                  <tr>
                      <th>Employee Code</th><td id="sal_ecode"></td><th>Aadhar No</th><td id="sal_aadhar"></td>
                  </tr>
                  <tr>
                      <th>Employee Name</th><td id="sal_ename"></td><th>PF No.</th><td id="sal_pf"></td>
                  </tr>
                  <tr>
                      <th>Employee Category</th><td id="sal_ecat"></td><th>ESI No</th><td id="sal_esic"></td>
                  </tr>
                  <tr>
                      <th>Employee Designation</th><td id="sal_edesg"></td><th>Bank Account</th><td id="sal_bnkaccnt"></td>
                  </tr>
                  <tr>
                      <th>Start Date</th><td id="sal_startdate"></td><th>End Date</th><td id="sal_enddate"></td>
                  </tr>
				
              </thead>
              <tbody>
                  <tr id="heading" style="background: black;color: white;">
                      <th colspan="2">S A L A R Y &nbsp;&nbsp;  H E A D S</th><th colspan="2">A M O U N T S</th>
                  </tr>
<!--                  <tr>
                      <td colspan="2"></td><td colspan="2"></td>
                  </tr>-->
                  <tr id="grosssal">
                      <th colspan="2">Gross Salary</th><th colspan="2" id="sal_grosssal"></th>
                  </tr>
<!--                  <tr>
                      <td colspan="2"></td><td colspan="2"></td>
                  </tr>-->
                  <tr id="netsal">
                      <th colspan="2">Net Salary Payable</th><th colspan="2" id="sal_netsal"></th>
                  </tr>
                  <tr>
                      <td colspan="2">PF Employer</td><td colspan="2" id="sal_pfemployer"></td>
                  </tr>
                  <tr>
                      <td colspan="2">ESIC Employer</td><td colspan="2" id="sal_esicemployer"></td>
                  </tr>
                  <tr>
                      <th colspan="2">CTC/month</th><th colspan="2" id="sal_ctcm"></th>
                  </tr>
                  <tr>
                      <th colspan="2">CTC/year</th><th colspan="2" id="sal_ctcy"></th>
                  </tr>
				 
				  
              </tbody>
          </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<script>


    $(function ()
    {
        var table=$('#salary_structure_list').DataTable({
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

<?php //if(substr($right_access,0,1)=='C'){?>
    $('#add_salary_group').click(function ()
    {
        window.location.href = "<?php echo base_url('hr/settings/salary_groups/add_sal'); ?>";

    });
<?php //}?>

<?php //if(substr($right_access,2,1)=='U'){?>
    
    $('#salary_structure_list a').click(function ()
    {
        var id = $(this).attr('id');
        window.location.href = "<?php echo base_url('hr/settings/salary_groups/edit_sal'); ?>" + '/' + id; 
    });
    
<?php //}?>

<?php //if(substr($right_access,3,1)=='D'){?>
    function deleteClass()
    {
        var r = confirm("Are you sure you want to delete this record?");
//                var id='1';
        if (r == true)
        {
            var class_id_string = [];
            var i = 0;
            $("input:checked").each(function ()
            {
                class_id_string[i] = $(this).attr("id");
                i++;
            });

//
            $.ajax({
                url: "<?php echo site_url('hr/settings/salary_groups/delete') ?>",
                type: "POST",
                data: {
                    class_id_string: class_id_string},
                dataType: "text",
                success: function (data)
                {
                    window.location.href = "<?php echo base_url('hr/payroll/salary_structure'); ?>";
//                         
                },
                error: function (data, status)
                {
                    alert('e' + data + status);
                }});

        }
    }
    
<?php //}?>

<?php if(substr($right_access,4,1)=='V'){?>
    
        function view_salary(me,ecode,ename){
         
            $.ajax({
                    url: "<?php echo site_url('hr/payroll/my_salary/viewSalary') ?>",
                    type: "POST",
                    data: {id: me.id},
                    dataType: "JSON",
                    success: function (data)
                    {
//                        alert(data);
                        $('#sal_ecode').text(data['emp_code']);
                        $('#sal_ename').text(data['emp_name']);
                        $('#sal_ecat').text(data['emp_cat']);
                        $('#sal_edesg').text(data['emp_desg']);  
                        $('#sal_aadhar').text(data['emp_desg']);  
                        $('#sal_pf').text(data['pfaccnt']);  
                        $('#sal_esic').text(data['esicaccnt']);  
                        $('#sal_bnkaccnt').text(data['bnkaccnt']);  
                        $('#sal_startdate').text(data['startdate']);  
                        $('#sal_enddate').text(data['enddate']);  
                        $('.earning').remove();
                        $('#heading').after(data['earning']);  
                        $('#sal_grosssal').text(data['gross']);
                        $('.deduction').remove();
                        $('#grosssal').after(data['deduction']);  
                        $('#sal_netsal').text(data['net']);  
                        $('#sal_pfemployer').text(data['pfemployer']);  
                        $('#sal_esicemployer').text(data['esicemployer']);  
                        $('#sal_ctcm').text(data['ctcm']);  
                        $('#sal_ctcy').text(data['ctcm']*12);  
                        $('#mySalaryView').modal('show');
                    },
                    error: function (data, status)
                    {
                        alert('e' + data + status);
                    }
            });
            
//            var id=me.id;
//            $('#sal_ecode').text(ecode);
//            $('#sal_ename').text(ename);
//            $('#sal_ecat').text(ename);
//            $('#sal_edesg').text(ename);
//            var start_date=$('#'+id).closest('tr').find("td:nth-child(1)").text();
//            alert(start_date);
//            $('#mySalaryView').modal('show');
        }
        
<?php }?>
</script>

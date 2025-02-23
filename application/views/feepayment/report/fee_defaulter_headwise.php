<style>
.modal-dialog{position:absolute;top:40%;left:50%;transform:translate(-50%,-50%)!important}
.modal-header .close{margin-top:-27px!important}input[type="date"].form-control{line-height:17px}</style>
<div class="form-group">
    <div class='box box-primary panel'>
        <div class="panel-heading" style="padding: 0px 8px;border-bottom: 0px;background-color: #dff0d8;">
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#tillnow" style="font-weight:bold;">Till Now Defaulters</a></li>
            </ul>
        </div>
        <div class='box-body'>
            <div class="col-lg-8 col-lg-offset-2" id="successMessage" <?php if ($this->session->flashdata('Success')) { ?> style="padding: 10px 20px;background: #CCF5CC;text-align:center" <?php } ?>> <?php echo $this->session->flashdata('Success'); ?></div> 
            <div class="tab-content">
                <div class="tab-pane fade active in" id="tillnow">
                    <div class="col-sm-12 col-md-12">
                        <label class="control-label col-md-2">Select Session</label>
                        <div class="col-sm-2 col-md-2">
                            <select name="aca_session" id="aca_session" class="form-control">
                                <?php foreach ($asession as $ses) { ?>
                                    <option value="<?php echo $ses->id; ?>"><?php echo $ses->session; ?></option>
                                    <?php } ?>
                            </select>
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12">
                        <label class="control-label col-md-2">Class Name</label>
                        <div class="col-sm-2 col-md-2">
                            <select name="annuallstClass" id="annuallstClass" class="form-control">
                                <option value="all">All Class</option>
                                <?php foreach ($aclass as $class) { ?>
                                <option value="<?php echo $class->id; ?>"><?php echo $class->class_name; ?></option>
                                <?php } ?>
                            </select>
                            <span class="help-block"></span>
                        </div>
                        <label class="control-label col-md-2">Section Name</label>
                        <div class="col-sm-2 col-md-2">
                            <select name="annualsection" id="annuallstSection" class="form-control">
                                <option value="all">All Section</option>
                                <?php foreach ($asection as $sec) { ?>
                                <option value="<?php echo $sec->id; ?>"><?php echo $sec->sec_name; ?></option>
                                    <?php } ?>
                            </select>
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12">
                        <label class="control-label col-md-2">Choose Term:</label>
                        <div class="col-sm-2 col-md-2">
                                <select name="term" id="term" class="form-control">
                                    <option value="all">Both</option>
                                    <option value="1">Annual</option>
                                    <option value="2">Monthly</option>
                                </select>
                                <span class="help-block"></span>
                        </div>
                        <label class="control-label col-md-2">Choose Till Month:</label>

							 <div class="col-sm-2 col-md-2">
                            <?php $m=date('m');?>
                            <select name="choosetillmonth" id="choosetillmonth" class="form-control">
                                <option value="0">Select</option>
                                <option value="04" <?php if($m==4) echo 'selected=selected';?>>April</option>
                                <option value="05" <?php if($m==5) echo 'selected=selected';?>>May</option>
                                <option value="06" <?php if($m==6) echo 'selected=selected';?>>June</option>
                                <option value="07" <?php if($m==7) echo 'selected=selected';?>>July</option>
                                <option value="08" <?php if($m==8) echo 'selected=selected';?>>August</option>
                                <option value="09" <?php if($m==9) echo 'selected=selected';?>>September</option>
                                <option value="10" <?php if($m==10) echo 'selected=selected';?>>October</option>
                                <option value="11" <?php if($m==11) echo 'selected=selected';?>>November</option>
                                <option value="12" <?php if($m==12) echo 'selected=selected';?>>December</option>
                                <option value="01" <?php if($m==1) echo 'selected=selected';?>>January</option>
                                <option value="02" <?php if($m==2) echo 'selected=selected';?>>February</option>
                                <option value="03" <?php if($m==3) echo 'selected=selected';?>>March</option>

                            </select>
                            <span class="help-block"></span>
                        </div>
						 
						
                    </div>
                </div>

            </div>


        </div>
    </div>
</div>
 
<div class="box" id="box_tillnow">
    <div class="box-body">

        <div class="col-sm-12 col-md-12" id="annual_load">
            <form id='frmtemplate' role="form" method="POST">
                <table id="studentlist" class="table table-bordered table-striped"  style="margin-top: 25px;">
                    <thead>
                        <tr>
                            <th> S No. </th>
                            <th> Admission No </th>
                            <th> Student Name </th>
                            <th> Class </th>
                            <th> Section </th>
                            <th> Fees Category </th>
                            <th> Mobile No. </th>
                            <th> Annual</th>
                            <th> Monthly ( <?php
                                if (date('Y-m-d') > $session_end_date) {
                                    echo 'Till March';
                                } else {
                                    echo 'Including Current Month-' . date('M');
                                }
                                ?>) </th>
                                <?php if($this->session->userdata('school_id')!=35){ ?>
                            <th> Transport</th>
                        <?php } ?>
                            <th> Total Unpaid Amount</th>
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
                                    <th style="border-bottom:2px solid darkcyan;border-top:0px">
                                        <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="8"/>
                                    </th>
                                    <th style="border-bottom:2px solid darkcyan;border-top:0px">
                                        <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="9"/>
                                    </th>
                                <th style="border-bottom:2px solid darkcyan;border-top:0px"></th>
                            </tr>
                        </thead>
                    <tbody id="annual_load_td">
                          <?php
                        if (isset($data) && count($data) > 0) {
                            foreach ($data as $student) {
                                ?>
                        <tr>

                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                  <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>

<!-- /.box-body -->
</div>

<script>
    $(document).ready(function(){
    var $remaining = $('#remaining'),
        $messageses = $remaining.next();

    $('#message').keyup(function(){
        var chars = this.value.length,
            messageses = Math.ceil(chars / 160),
            remaining = messageses * 160 - (chars % (messageses * 160) || messageses * 160);

        $remaining.text(remaining + ' characters remaining');
        $messageses.text(messageses + ' message(s)');
    });
});

    $(document).ready(function ()
    {
        datatable();

        $('#aca_session' + ',#annuallstClass' + ',#annuallstSection' + ',#term' +',#choosetillmonth').change(function ()
        {
            datatable();
            var aca_session = $('#aca_session').val();
            var class_id = $('#annuallstClass').val();
            var section_id = $('#annuallstSection').val();
            var term = $('#term').val();
            var choosetillmonth = $('#choosetillmonth').val();

        });
        $('#lstClass' + ',#lstSection' + ',#term1' +',#month').change(function ()
        { 
            var class_id = $('#lstClass').val();
            var section_id = $('#lstSection').val();
            var term = $('#term1').val();
            var month = $('#month').val();   

            datatable1();
            $('#defaulter_export1').attr('href', '<?php echo base_url('feepayment/report/exportdefaulters'); ?>' + '/' + class_id + '/' + section_id + '/'+term+'/' + month+'/'+'monthwise');

            
        });

        
        
        $('#box_monthwise').hide();
    });
    
     $('#searchhead th input').on('keyup change', function () {

                var i = $(this).attr('data-column');
                var v = $(this).val();
                table.columns(i).search(v).draw();
            }); 
    
    function showhide(m,n){
    
        $('#box_'+m).show();
        $('#box_'+n).hide();
    }
    function printPageArea(areaID){
    var printContent = document.getElementById(areaID);
    var WinPrint = window.open('', '', 'width=900,height=650');
    WinPrint.document.write(printContent.innerHTML);
    WinPrint.document.close();
    WinPrint.focus();
    WinPrint.print();
    WinPrint.close();
}

function datatable()
        {
            var aca_session = $('#aca_session').val();
            var class_id = $('#annuallstClass').val();
            var section_id = $('#annuallstSection').val();
            var term = $('#term').val();
            var choosetillmonth = $('#choosetillmonth').val();
            var table =  $('#studentlist').DataTable({

                "lengthMenu": [[10, 50, 100,1000, 3000], [10, 50, 100,1000, 3000]],
                "destroy": true,
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "processing": true,
                serverSide: true,
                dom: 'lfBrtip',
            
                 buttons: [
                                {
                                    extend: 'collection',
                                    text: 'Export',
                                    className: 'red',
                                    buttons: [
                                        'excel',
                                        'csv',
                                        {
                                            extend: 'pdf',
                                            orientation: 'portrait',
                                            pageSize: 'A4'
                                        },
                                        {
                                            extend: 'print',
                                            orientation: 'portrait',
                                            pageSize: 'A4'
                                        },
                                    ]
                                }
                            ],
                            
                            
                ajax: {
                    url: '<?php echo base_url('feepayment/report/defaulter_report'); ?>',
                    type: 'POST',
                    data: {aca_session:aca_session,
                        class_id: class_id,
                        section_id: section_id,
                        term: term,
                        choosetillmonth: choosetillmonth,
                        indication:'tillmonth'
                    }
                }
               
            });
            }


             function datatable1()
        {
            var class_id = $('#lstClass').val();
            var section_id = $('#lstSection').val();
            var choosetillmonth = $('#month').val();
            var term = $('#term1').val();
            table=$('#studentlist1').DataTable({
                "destroy": true,
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "processing": true,
                serverSide: true,
                ajax: {
                    url: '<?php echo base_url('feepayment/report/defaulter_report'); ?>',
                    type: 'POST',
                    data: {class_id: class_id,
                        section_id: section_id,
                        choosetillmonth: choosetillmonth,
                        term:term,
                        indication:'monthwise'
                    }
                }

            });
        }
     setTimeout(function () {
        $('#successMessage').fadeOut("fast");
    }, 5000);


     $('#Send_Sms_Manual').click(function()
{
  if ($('#sms_class').val()==0 || $('#sms_section').val()==0 || $('#date_sms')=='')
  {
    alert('Please select Class and Section and Date'); 
  }
  else
  {
   $.ajax({
    type:'POST',
    url:"<?php echo base_url('feepayment/report/sendsmsdefaulters_manaul');?>",
    data:$('#manual_sms_form').serialize(),
    datatype:'text',
    success:function(data)
    {

        alert('SMS Send successfully');
        window.location.reload();
    },
    error:function(req,status)
    {
      alert('error while saving');
    }
  });
 }
});
            
</script>
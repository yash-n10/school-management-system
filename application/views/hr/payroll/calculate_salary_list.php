
<div class="form-group">

    <div class="box">            
        <div class="box-body">
            <?php if (substr($right_access, 0, 1) == 'C') { ?>
                <div class="col-lg-12">
                    <div class="col-lg-12" style="text-align:right;">
                        <button data-toggle="modal" class="btn btn-add" id="calc_sal" title="Salary Calculation"> <i class="fa fa-plus-circle fa-lg"></i></button>
                    </div>

                </div>
            <?php } ?>  
        </div>
        <div class="box-body">
            <div class="panel ">
                <div class="panel-body">

                    <div class="row">
                        <div class="col-md-1" style="text-align: right">
                            <label for=""> YEAR </label> 
                        </div>
                        <div class="col-md-2">
                            <select id="year" name="year" class="form-control" required>
                                <option value="all">Select</option>
                                <option value="<?php echo $fin_yr_start; ?>" <?php if ($year_view == $fin_yr_start) {
                                    echo 'selected=selected';
                                } ?>><?php echo $fin_yr_start; ?></option>
                                <option value="<?php echo $fin_yr_end; ?>" <?php if ($year_view == $fin_yr_end) {
                                    echo 'selected=selected';
                                } ?>><?php echo $fin_yr_end; ?></option>
                            </select>
                        </div>
                        <div class="col-md-2" style="text-align: right">
                            <label for="" > MONTH </label> 
                        </div>
                        <div class="col-md-2">
                            <select class="form-control" id="mnth" name="mnth">
                                <option value="all">Select Month</option>  
                                <!--<option value="0" id="0">Select Month</option>-->  
                                <option value="04" data-year="<?php echo $fin_yr_start; ?>" <?php if ($month_view == 4) {
                                    echo 'selected=selected';
                                } ?>>April</option>
                                <option value="05" data-year="<?php echo $fin_yr_start; ?>" <?php if ($month_view == 5) {
                                    echo 'selected=selected';
                                } ?>>May</option>
                                <option value="06" data-year="<?php echo $fin_yr_start; ?>" <?php if ($month_view == 6) {
                                    echo 'selected=selected';
                                } ?>>June</option>
                                <option value="07" data-year="<?php echo $fin_yr_start; ?>" <?php if ($month_view == 7) {
                                    echo 'selected=selected';
                                } ?>>July</option>
                                <option value="08" data-year="<?php echo $fin_yr_start; ?>" <?php if ($month_view == 8) {
                                    echo 'selected=selected';
                                } ?>>August</option>
                                <option value="09" data-year="<?php echo $fin_yr_start; ?>" <?php if ($month_view == 9) {
                                    echo 'selected=selected';
                                } ?>>September</option>
                                <option value="10" data-year="<?php echo $fin_yr_start; ?>" <?php if ($month_view == 10) {
                                    echo 'selected=selected';
                                } ?>>October</option>
                                <option value="11" data-year="<?php echo $fin_yr_start; ?>" <?php if ($month_view == 11) {
                                    echo 'selected=selected';
                                } ?>>November</option>
                                <option value="12" data-year="<?php echo $fin_yr_start; ?>" <?php if ($month_view == 12) {
                                    echo 'selected=selected';
                                } ?>>December</option>
                                <option value="01" data-year="<?php echo $fin_yr_end; ?>" <?php if ($month_view == 1) {
                                    echo 'selected=selected';
                                } ?>>January</option>
                                <option value="02" data-year="<?php echo $fin_yr_end; ?>" <?php if ($month_view == 2) {
                                    echo 'selected=selected';
                                } ?>>February</option>
                                <option value="03" data-year="<?php echo $fin_yr_end; ?>" <?php if ($month_view == 3) {
                                    echo 'selected=selected';
                                } ?>>March</option>
                            </select>
                        </div>

                    </div>

                </div>
            </div>
        </div>



        <form id='frmtemplate' role="form" method="POST">
            <div class="box-body"> 
                <div class="table-responsive">
                    <table id="salary_calculation_list" class="table table-bordered table-striped">
                        <thead style="background:#99ceff;">
                            <tr>
                            <!--<th>Emp Id</th>-->
                                    <?php if ($this->uri->segment(3) != 'my_payslip') { ?>
                                    <th style="border-bottom:0px">Employee Code</th>
                                    <th style="border-bottom:0px">Employee Name</th>  
<?php } ?>
                                <th style="border-bottom:0px">Month & year</th>  
                                <th style="border-bottom:0px">Working Days</th>  
                                <th style="border-bottom:0px">Paid Days</th>  
                                <th style="border-bottom:0px">Net Payable Amount</th>  
                                <th style="border-bottom:0px">Actions</th>  
                            </tr>
                        </thead>
                        <thead style="background: #cce6ff">
                            <tr id="searchhead">
                                <?php $colcnt1=0;if ($this->uri->segment(3) != 'my_payslip') { ?>
                                <th style="border-bottom:2px solid darkcyan;border-top:0px">
                                    <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="<?php echo $colcnt1; $colcnt1++;?>"/>
                                </th>
                                <th style="border-bottom:2px solid darkcyan;border-top:0px">
                                    <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="<?php echo $colcnt1; $colcnt1++; ?>"/>
                                </th>
                                <?php } ?>
                                <th style="border-bottom:2px solid darkcyan;border-top:0px">
                                    <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="<?php echo $colcnt1; $colcnt1++; ?>"/>
                                </th>
                                <th style="border-bottom:2px solid darkcyan;border-top:0px">
                                    <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="<?php echo $colcnt1; $colcnt1++; ?>"/>
                                </th>
                                <th style="border-bottom:2px solid darkcyan;border-top:0px">
                                    <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="<?php echo $colcnt1; $colcnt1++; ?>"/>
                                </th>
                                <th style="border-bottom:2px solid darkcyan;border-top:0px">
                                    <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="<?php echo $colcnt1; ?>"/>
                                </th>
                                
                                

                                <th style="border-bottom:2px solid darkcyan;border-top:0px"></th>
                            </tr>
                        </thead>
                        <tbody>  
                                    <?php
                                    $count = 1;
                                    foreach ($fetch_employee_salary as $row):
                                        ?>

                                <tr>
                                <!--<td><?php // echo $row->emp_id;?> </td>-->
                                        <?php if ($this->uri->segment(3) != 'my_payslip') { ?>
                                        <td><?php echo $row->emp_code; ?> </td>
                                        <td><?php echo $row->emp_name; ?></td>   
    <?php } ?>
                                    <td><?php echo $row->month . '/' . $row->year; ?></td>                                                                               
                                    <td><?php echo $row->working_days; ?></td>                                                                               
                                    <td><?php echo $row->paid_days; ?></td>                                                                               
                                    <td><?php echo $row->amount_paid; ?></td>                                                                               
                                    <td>
                                                <?php 
                                                if ($row->paid_status == 0) 
                                                { 
                                                    if (substr($right_access, 3, 1) == 'D') 
                                                    { 
                                                ?>
                                                    <input type="checkbox" class="btn"  id="<?php echo $row->id; ?>">
                                                <?php 
                                                    } 
                                                    if (substr($right_access, 2, 1) == 'U') 
                                                    { 
                                                ?>  
                                                    <a data-toggle="tooltip" data-placement="top" title="Edit" class="btn a-edit" id="<?php echo $row->id; ?>" onclick="edit(this)">
                                                        <i class="fa fa-edit"></i>  
                                                    </a>
                                                    <a data-toggle="tooltip" data-placement="top" title="View Salary Slip" id="<?php echo $row->id; ?>" onclick="paySlip(this, 'payslip');">
                                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                                    </a>
                                                    <a data-toggle="tooltip" data-placement="top" title="Download Salary Slip" id="<?php echo $row->id; ?>" href="<?php echo base_url();?>hr/payroll/salary_calculator/download_receipt/<?php echo $row->id;?>">
                                                        <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                                                    </a>
                                                    
                                                    <!-- <button type="button" class="btn" id="<?php echo $row->id; ?>" style="border-color: darkgray" onclick="paySlip(this, 'payslip');">
                                                        <i class="fa fa-download"></i> Pay Slip 
                                                    </button> -->
                                                <?php 
                                                    } 
                                                    if (substr($right_access, 5, 1) == 'P') 
                                                    { 
                                                ?>
                                                    <a class="btn" id="<?php echo $row->id; ?>" onclick="paySlip(this, 'payment');">
                                                        <i class="fa fa fa-credit-card"></i> Pay
                                                    </a>
                                                <?php 
                                                    }
                                                } 
                                                else 
                                                {
                                                    if (substr($right_access, 4, 1) == 'V') 
                                                    {
                                                ?>
                                                        <button type="button" class="btn" id="<?php echo $row->id; ?>" style="border-color: darkgray" onclick="paySlip(this, 'payslip');">
                                                            <i class="fa fa-download"></i> Pay Slip 
                                                        </button>
                                                <?php 
                                                    }
                                                } 
                                                ?>
                                    </td>

                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                        </tfoot>
                    </table>

                </div>
            </div>
<?php if (substr($right_access, 3, 1) == 'D') { ?>
                <div class="box-body" style="text-align:right">
    <?php if (count($fetch_employee_salary) > 0) { ?>              
                        <input type="button" class="btn btn-danger" id="sal_head" value="Delete" onclick="delete_salary_calc();">
    <?php } ?>

                </div>
<?php } ?>
        </form>

        <!-- /.box-body -->
    </div>
    <!-- /.box -->
</div>

<div id="div_salary_structure" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <form action="<?php // echo base_url('Payroll/salary_structure/save') ?>" method="post" id="frm_salary_structure">
               
                <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h3 class="modal-title">Add Salary Type</h3>
                </div>
                <div class="modal-body form">
                    <div class="form-group">
                        <label class="control-label col-md-4">Salary Code</label>
                        <div class="col-md-8" style='padding-bottom:1%'>
                            <input type="text" class="form-control" id="scode" name="scode" placeholder="Salary Code" value=''>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4">Salary Name</label>
                        <div class="col-md-8" style='padding-bottom:1%'>
                            <input type="text" class="form-control" id="sname" name="sname" placeholder="Salary Name" value=''>
                        </div>
                    </div>

                </div>
                <!--<div class="modal-footer" id="modal-footer">-->
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="btn_save">Save</button>
                </div>
            </form>
            <!--</div>-->
        </div>

    </div>
</div>
<style>
    #mySalaryView .table {
        width: 100%;
        max-width: 100%;
        margin-bottom: 0px; 
    }
    .col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-xs-1, .col-xs-10, .col-xs-11, .col-xs-12, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6, .col-xs-7, .col-xs-8, .col-xs-9 {
        position: relative;
        min-height: 1px;
        padding-right: 0px;
        padding-left: 0px;
    }
    #mySalaryView>tr {
        line-height: 15px;
        min-height: 15px;
        height: 15px;
    }
    #mySalaryView .table>tbody>tr>td, #mySalaryView .table>tbody>tr>th, #mySalaryView .table>tfoot>tr>td, #mySalaryView .table>tfoot>tr>th, #mySalaryView .table>thead>tr>td, #mySalaryView .table>thead>tr>th {
        padding: 8px;
        line-height: 0.498571;
        vertical-align: top;
        border-top: 1px solid #ddd;
    }
    #mySalaryView .table-bordered {
        border: 1px solid #002147;
    }
    #mySalaryView .table-bordered>tbody>tr>td, #mySalaryView .table-bordered>tbody>tr>th, #mySalaryView .table-bordered>tfoot>tr>td, #mySalaryView .table-bordered>tfoot>tr>th, #mySalaryView .table-bordered>thead>tr>td, #mySalaryView .table-bordered>thead>tr>th {
        border: 1px solid #002147;
    }
</style>

<div id="mySalaryView" class="modal fade" role="dialog">

    <div class="modal-dialog modal-lg">
        
        <div class="modal-content" id="printtable">
            <div class="modal-header" style="background-color: antiquewhite;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <input type="hidden" value="" id="sal_cal_id" name="sal_cal_id">
                <!-- <div class="row" style="border-bottom:1px solid gray;">
                    <div class="col-md-12">
                        <h3 class="modal-title" id="school_name"></h3>
                        <p style="margin:0px 0px 0px" id="vision"></p>
                        <p style="margin:0px 0px 0px" id="school_address"></p>
                        <p style="margin:0px 0px 0px" id="phone"></p>
                        <p style="margin:0px 0px 0px" id="email"></p>       
                   </div>
                </div>
                <div class="row">
                    <h3><center>Pay Slip for the Month of <b id="mnthhead"></b></center></h3>
                </div> -->
            </div>
            
            <div class="modal-body form" id="html-2-pdfwrapper">
                <div class="row" style="padding:20px;">
                    <div class="col-xs-12"> 
                      <div class="row p-5">
                            <div class="col-md-4" style="padding-left: 18px;">                           
                                <p class="font-weight-bold mb-1"><h3 id="school_name"></h3></p>
                                <p class="font-weight-bold" style="margin: 0 0 1px;" id="vision"></p>
                                <p class="font-weight-bold" style="margin: 0 0 1px;" id="school_address"></p>
                            </div>

                            <div class="col-md-4">
                               <!-- <center><img src="E:\vivek vidyalya\logo_vivek.png" style="width: 116px;height: 132px;margin-top: -26px;"></center> -->
                            </div>
                            <div class="col-md-4 text-right" style="padding-right:26px;">
                                 <p class="font-weight-bold mb-1"><h4>Pay Slip</h4></p> 
                                <p class="text-muted" style="margin: 0 0 1px;"><span>Contact No - </span><span id="phone"></span></p>
                                <p class="text-muted"><span>Email Id - </span><span id="email"></span></p>
                            </div>
                        </div>              
                        <table class="table table-bordered">                        
                            <thead>
                                <tr>
                                    <td colspan="4" style="padding: 19px;text-align:center"><strong>Pay Slip for the Month of NOVEMBER'19</strong></td>                             
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Employee Code</td>
                                    <td><span id="sal_ecode"></span></td>                               
                                    <td>Aadhar No</td>                              
                                    <td><span id="sal_aadhar"></span></td>                               
                                </tr>
                                <tr>
                                    <td>Employee Name</td>
                                    <td id="sal_ename"></td>
                                    <td>PF No.</td>
                                    <td id="sal_pf"></td>                                
                                </tr>
                                <tr>
                                    <td>Employee Category</td>
                                    <td id="sal_ecat"></td>
                                    <td>ESI No</td>
                                    <td id="sal_esic"></td>                               
                                </tr>
                                <tr>
                                    <td>Employee Designation</td>
                                    <td id="sal_edesg"></td>
                                    <td>Bank Account</td>
                                    <td id="sal_bnkaccnt"></td>                                
                                </tr>                           
                            </tbody>
                        </table>
                    </div>  
                    <div class="col-xs-12" style="margin-bottom: 10px;">    </div>          
                    <div class="col-xs-12">                 
                        <div class="col-xs-6 col-md-6">
                            <table class="table table-bordered" style="width:99%;">                      
                                <thead>
                                    <tr>
                                        <th colspan="3" style="text-align:center;background-color:#002147;color:#fff;">Earnings</th>
                                    </tr>
                                </thead>
                                <tbody id="heading">
                                   
                                                                                            
                                </tbody>
                                <tbody style="border: 1px solid black;">
                                     <tr>
                                        <td colspan="2"><b>Total Earning </b></td>                                  
                                        <td style="text-align:left;" id="tot_earning"></td>
                                    </tr>  
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="col-xs-6 col-md-6">
                            <table class="table table-bordered">                        
                                <thead>
                                    <tr>                        
                                        <th colspan="3" style="text-align:center;background-color:#002147;color:#fff;">Deduction</th>
                                    </tr>
                                </thead>
                                <tbody id="heading1">
                                    
                                </tbody>
                                <tbody style="border: 1px solid black;">
                                    <tr>
                                        <td  colspan="2"><b>Total Deduction </b></td>                                   
                                        <td style="text-align:left;" id="tot_deduction"></td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>                   
                    </div>
                    <div class="col-xs-12" style="margin-bottom: 10px;">    </div>
                    <div class="col-xs-12">                 
                        <div class="col-xs-8 col-md-8">
                            <table class="table table-bordered" style="width:99%">                      
                                <thead>
                                    <tr>
                                        <th colspan="4" style="text-align:center;background-color:#002147;color:#fff;">COST TO COMPANY</th>
                                    </tr>
                                </thead>
                            </table>
                            <div class="col-xs-6 col-md-6">
                                <table class="table table-bordered" style="width:99%">  
                                    <tbody id="ctchead">                                                                                    
                                    </tbody>
                                    <tbody style="border: 1px solid black;">
                                        <tr>
                                            <td colspan=""><b>CTC/month</b> </td>           
                                            <td colspan=""><b id="sal_ctcm"></b> </td>         
                                        </tr>                                                                                    
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-xs-6 col-md-6">
                                <table class="table table-bordered" style="width: 99.5%;margin: 0px 0px 0px -4px !important;">  
                                    <tbody id="ctchead2">

                                    </tbody>
                                    <tbody style="border: 1px solid black;">
                                        <tr>
                                            <td colspan='2'>&nbsp;</td>
                                        </tr>
                                        <tr>   
                                            <td colspan="">Gross Salary</td>           
                                            <td colspan=""><span id="grosss"></span> </td>                    
                                        </tr>
                                        <tr>           
                                            <td style="border-left:0px solid;"><b>CTC/year</b></td>                                         
                                            <td id="sal_ctcy"></td>                                 
                                        </tr>                                                                                    
                                    </tbody>
                                </table>
                            </div>                            
                        </div>
                        
                        <div class="col-xs-4 col-md-4">
                            <table class="table table-bordered">                        
                                <thead>
                                    <tr style="text-align:center;background-color:#002147;color:#fff;">                     
                                        <th colspan="2">Header</th>                             
                                        <th colspan=""></th>                                
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>                            
                                        <td colspan="2">Total Working Days</td>     
                                        <td id="sal_workingdays"></td>                             
                                    </tr>
                                    <tr>                            
                                        <td colspan="2">Absent Days</td>        
                                        <td id="sal_absent"></td>                              
                                    </tr>
                                    <tr>                            
                                        <td colspan="2">No. Leaves Approved</td>        
                                        <td id="sal_leaveapprove"></td>                              
                                    </tr>
                                    <tr>                            
                                        <td colspan="2">No. of Paid Days</td>       
                                        <td id="sal_present"></td>                             
                                    </tr>
                                    <tr>                            
                                        <td colspan="2">Reimbursement Amount</td>       
                                        <td id="sal_rem"></td>                              
                                    </tr>
                                    <tr>                            
                                        <td colspan="2"><strong>Net Salary Payable</strong></td>        
                                        <td><strong id="sal_netsal"></strong></td>                             
                                    </tr>   
                                </tbody>
                            </table>
                        </div>                   
                    </div>
                    <div class="col-xs-12" style="margin-top:20px;padding:8px;margin-bottom:5px;font-size:12px"><p><span>*</span> Please feel free to contact us at : school accounts office for any query/complaint regarding your salary. Verbal conversation will not be entertained.</p>
                        <p style="margin-top:-5px;"><span>*</span> This is system generated slip, signature not required.</p>
                    </div>
                </div>
                <!-- <table class="table table-bordered table-striped" >
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
                    </thead>
                    <thead style="border:1px solid gray">
                        <tr style="background: black;color: white;">
                            <th colspan="4"><center>Attendance &  Leave Details</center></th>
                        </tr>
                        <tr>
                            <th>Total Working Days</th><td id="sal_workingdays"></td><th>No. Leaves Approved</th><td id="sal_leaveapprove"></td>
                        </tr>
                        <tr>
                            <th>Absent Days</th><td id="sal_absent"></td><th>No. of Paid Days</th><td id="sal_present"></td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr id="heading" style="background: black;color: white;">
                            <th colspan="2">S A L A R Y &nbsp;&nbsp;  H E A D S</th><th colspan="2">A M O U N T S</th>
                        </tr>
                        <hr>
                        <tr id="grosssal">
                            <th colspan="2">Total Earning</th><th colspan="2" id="tot_earning"></th>
                        </tr>
                        <tr id="grosssal2">
                            <th colspan="2">Total Deduction</th><th colspan="2" id="tot_deduction"></th>
                        </tr>
                        <tr id="rem">
                            <th colspan="2">Reimbursement Amount</th><th colspan="2" id="sal_rem"></th>
                        </tr>   
                        <tr id="netsal">
                            <th colspan="2">Net Salary Payable</th><th colspan="2" id="sal_netsal"></th>
                        </tr>
                        <tr id="heading1" style="background: black;color: white;">
                            <th colspan="2">C T C &nbsp;&nbsp;  H E A D S</th><th colspan="2">A M O U N T S</th>
                        </tr>
                        <tr>
                            <td colspan="2">PF Employer</td><td colspan="2" id="sal_pfemployer"></td>
                        </tr>
                        <tr>
                            <td colspan="2">ESIC Employer</td><td colspan="2" id="sal_esicemployer"></td>
                        </tr>
                        <tr>
                            <td colspan="2">Gross Salary</td><td colspan="2" id="sal_grosssal1"></td>
                        </tr>
                        <tr>
                            <th colspan="2">CTC/month</th><th colspan="2" id="sal_ctcm"></th>
                        </tr>
                        <tr>
                            <th colspan="2">CTC/year</th><th colspan="2" id="sal_ctcy"></th>
                        </tr>
                    </tbody>
                </table>      -->       
            </div>    
        </div>
        
        <div class="modal-footer" style="background: #fff;">
            <button type="button" class="btn btn-info" id="printPage"><i class="fa fa-download"></i> Download</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>

</div>

<script src="<?php echo base_url(); ?>/assets/jspdf/jspdf.min.js"></script>
<script>


    $(function ()
    {
        var table = $('#salary_calculation_list').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            dom: 'lfBrtip',
            
                 buttons: [
//                           'excel', 'pdf', 'csv' 
                                {
                                    extend: 'collection',
                                    text: 'Export',
                                    className: 'red',
                                    buttons: [
                              
//                                      '<i class="fa fa-file-excel-o"></i>copy',
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
        

            $('#printPage').click(function(){
            var data = '<input type="button" value="Print" onClick="window.print()">';           
            // var data = '<input type="button" value="Print this page" onClick="window.print()">';           
            data += '<html><body>';
            data += '<div id="div_print">';
            data += $('#printtable').html();
            data += '</div></body></html>';

            myWindow=window.open('','','width=700,height=800');
            myWindow.innerWidth = screen.width;
            myWindow.innerHeight = screen.height;
            myWindow.screenX = 0;
            myWindow.screenY = 0;
            myWindow.document.write(data);
            myWindow.focus();
        });

    });

    $('#calc_sal').click(function ()
    {
        window.location.href = "<?php echo base_url('hr/payroll/salary_calculator/add_sal_calc'); ?>";

    });

    function edit(me)
    {
        var id = me.id;
        window.location.href = "<?php echo base_url('hr/payroll/salary_calculator/edit_sal_calc'); ?>" + '/' + id;
    }


    function paySlip(me, status) {

        $.ajax({
            url: "<?php echo site_url('hr/payroll/my_payslip/viewSalary') ?>",
            type: "POST",
            data: {id: me.id},
            dataType: "JSON",
            success: function (data)
            {
//                        alert(data);
                var pf_employer= data['pfemployer'];
                var esicemployer= data['esicemployer'];
                var gross= data['gross'];
                var totalctctamt= data['totalctctamt'];
                var earning= data['totalerntamt'];
                var totaldedamt= data['totaldedamt'];
                // alert(totaldedamt);
                var ctc_amt_actual=(Number(pf_employer) + Number(gross) + Number(totalctctamt) +Number(esicemployer));
                $('#school_name').text(data['school_name']);
                $('#school_address').text(data['school_address']);
                $('#vision').text(data['vision']);
                $('#phone').text(data['phone']);
                $('#email').text(data['email']);

                $('#sal_cal_id').val(me.id);
                $('#sal_cal_id').val(me.id);
                $('#sal_ecode').text(data['emp_code']);
                $('#sal_ename').text(data['emp_name']);
                $('#sal_ecat').text(data['emp_cat']);
                $('#sal_edesg').text(data['emp_desg']);
                $('#sal_aadhar').text(data['aadhar']);
                $('#sal_pf').text(data['pfaccnt']);
                $('#sal_esic').text(data['esicaccnt']);
                $('#sal_bnkaccnt').text(data['bnkaccnt']);
                $('#sal_workingdays').text(data['workingdays']);
                $('#sal_leaveapprove').text(data['leaveapprove']);
                $('#sal_absent').text(data['absent']);
                $('#sal_present').text(data['present']);
                $('#sal_payslipno').text(data['payslipno']);
                $('#sal_month').text(data['sal_monthyr']);
                $('#mnthhead').text(data['sal_monthyr']);
                $('.earning').remove();
                $('#heading').html(data['earning']);
                $('.ctc').remove();
                $('#heading1').html(data['deduction']);

                $('#sal_grosssal').text(data['gross']);
                $('#tot_earning').text(earning);
                $('#grosss').text(earning);
                $('#tot_deduction').text(totaldedamt);
                $('#sal_grosssal1').text(data['gross']);
                $('.deduction').remove();
                $('#ctchead').html(data['ctccal']);
                $('#ctchead2').html(data['ctccals']);

                $('#grosssal1').after(data['deduction']);
                

                $('#sal_netsal').text(data['net']);
                $('#sal_rem').text(data['remburse_amt']);
                $('#sal_pfemployer').text(data['pfemployer']);
                $('#sal_esicemployer').text(data['esicemployer']);
               
                $('#sal_ctcm').text(ctc_amt_actual);
                $('#sal_ctcy').text(ctc_amt_actual * 12) ;
                if (status == 'payment') {
                    $('#salary_payment').show();
                    $('#payslip_dwnld').show();
                    $('#pay-title').text('Salary Payment');
                } 
                else {
                    $('#salary_payment').hide();
                    $('#payslip_dwnld').show();
                    $('#pay-title').text('Pay Slip')
                }
                $('#mySalaryView').modal('show');
            },
            error: function (data, status)
            {
                alert('e' + data + status);
            }
        });
    }


    $('#salary_payment').click(function ()
    {
        var con = confirm('Are you sure want to proceed further ?');

        if (con == true) {
            $.ajax({
                type: 'POST',
                url: "<?php echo base_url('hr/payroll/salary_calculator/pay') ?>",
                data: {
                    sal_calc_id: $('#sal_cal_id').val(),
                    sal_month: $('#sal_month').text(),
                    sal_ecode: $('#sal_ecode').text(),
                },
                datatype: 'text',
                success: function (data)
                {
                    alert('Salary Paid');
                    window.location.href = "<?php echo base_url('hr/payroll/salary_calculator'); ?>";
                },
                error: function (req, status)
                {
                    alert('Error while paying');
                }
            });
        }

    });



    function delete_salary_calc()
    {
        var r = confirm("Are you sure you want to delete this record?");
        if (r == true)
        {
//                      var emp_id_string =$(this).attr('id');
            var emp_id_string = [];
            var i = 0;
            $("input:checked").each(function ()
            {
                emp_id_string[i] = $(this).attr("id");
                i++;
            });
//                        alert(emp_id_string.length);
            if (emp_id_string.length == 0) {
                alert('Please choose any checkbox first');
                return false;
            }

            $.ajax({
                url: "<?php echo site_url('hr/payroll/salary_calculator/delete') ?>",
                type: "POST",
                data: {employee_id_string: emp_id_string},
                dataType: "text",
                success: function (data)
                {
                    window.location.href = "<?php echo base_url('hr/payroll/salary_calculator'); ?>";
//                         
                },
                error: function (data, status)
                {
                    alert('e' + data + status);
                }});

        }
    }


    $('#mnth,' + '#year').change(function ()
    {
        var mon = $('#mnth').val();
        var yr = $('#year').val();
        window.location.href = "<?php echo base_url('hr/payroll/salary_calculator/index'); ?>" + '/' + yr + '/' + mon;
    });


</script>





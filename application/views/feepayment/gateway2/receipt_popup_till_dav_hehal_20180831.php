             <form class="form-horizontal" id="change_initial_password" method="POST" role="form" action="<?php // echo base_url("student/change_password") ?>">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <div class="container col-md-12" style="margin:5px; border:1px solid gray;">
            <div class="row" style="border-bottom:1px solid gray;">
               <div class="col-md-3" style="margin-top:10px;"> 
                <img src="<?php echo base_url()?>/assets/img/<?php echo $school_id.'.JPG';?>" style="height:100px;width:100%">
                </div>
             
                <div class="col-md-9">

                <h3> <b> <?php echo $school_name;?></b> </h3>
                <?php echo $school_address;?><br>
                <?php echo $phone;?><br>
                <?php echo $email;?><br>        

               </div>
            </div>     

                   
            <div class="row"  style="border-bottom:1px solid gray; padding:5px;">
                <b> PAYMENT DETAILS </b>
            </div>
            
             <div class="row" >
                 
                 <div class="col-sm-4"> Transaction ID </div> <div class="col-sm-2"> :<?php echo $transaction_id;?> </div><div class="col-sm-2" style="    text-align: right;
            padding-right: 0px;">Date</div>
             
                    <div class="col-sm-3"> :<?php echo $date;?> </div> 
                </div>
                <div class="row" >
                    <div class="col-sm-4"> Receipt No  </div> <div class="col-sm-2"> :<?php echo $receipt_no ;?> </div> 
                </div>
                <div class="row" >
                    <div class="col-sm-4"> Admission No </div> <div class="col-sm-2">  :<?php echo $admission_no;?> </div> 
                </div>
                <div class="row" >
                    <div class="col-sm-4">Name </div> <div class="col-sm-6"> :<?php echo $name;?> </div> 
                </div>
                <div class="row" >
                    <div class="col-sm-4">Class </div> <div class="col-sm-6"> :<?php echo $class;?> </div>  
                </div>
                <div class="row" >
                 <div class="col-sm-4">Section </div> <div class="col-sm-6">:<?php echo  $secname;?></div>  
                </div>
                 <div class="row" >
                     <div class="col-sm-4">Category </div> <div class="col-sm-6">:<?php echo  $cat;?> </div>  
                 </div>
            <div class="row" style="border-bottom:1px solid gray; padding-bottom:10px;">
                 <div class="col-sm-4"><?php echo $fee_type_name;?> </div> <div class="col-sm-6"> :<?php echo $month_session;?> </div>
            </div>
            
            <div class="row" style="border-bottom:1px solid gray;">
                <div class="col-sm-6" style="text-align:center; border-right:1px solid grey"> FEES NAME </div>
                <div class="col-sm-6" style="text-align:center; border-right:1px solid grey"> AMOUNT  </div>
            </div>
                <?php $total_amt_pdf=0;
                foreach($monthly_fee as $obj_pdf)
                {
                    $total_amt_pdf=$total_amt_pdf+$obj_pdf->fee_amount;?>               
                    <div class="row" style="">
                        <div class="col-sm-6" style="text-align:center; border-right:1px solid grey"> <?php echo $obj_pdf->fee_name;?></div>
                        <div class="col-sm-6" style="text-align:center; border-right:1px solid grey"> <?php echo $obj_pdf->fee_amount;?> </div>
                    </div>
                <?php }
                if($transport_fee>0)
                {
                    $total_amt_pdf=$total_amt_pdf+$transport_fee;?>
                    <div class="row" style="">
                        <div class="col-sm-6" style="text-align:center; border-right:1px solid grey">Transport Fees</div>
                        <div class="col-sm-6" style="text-align:center; border-right:1px solid grey"> <?php echo $transport_fee;?> </div>
                    </div>
                <?php }
                foreach($annual_fee as $obj_pdf)              
                {
                    $total_amt_pdf=$total_amt_pdf+$obj_pdf->fee_amount;?>               
                    <div class="row" style="">
                        <div class="col-sm-6" style="text-align:center; border-right:1px solid grey"> <?php echo $obj_pdf->fee_name;?></div>
                        <div class="col-sm-6" style="text-align:center; border-right:1px solid grey"> <?php echo $obj_pdf->fee_amount;?> </div>
                    </div>
                <?php }
                foreach($other_fee as $obj_pdf)              
                {
                    $total_amt_pdf=$total_amt_pdf+$obj_pdf->fee_amount;?>  
                <div class="row" style="">
                        <div class="col-sm-6" style="text-align:center; border-right:1px solid grey"> <?php echo $obj_pdf->fee_name;?></div>
                        <div class="col-sm-6" style="text-align:center; border-right:1px solid grey"> <?php echo $obj_pdf->fee_amount;?> </div>
                    </div>
                <?php }
                foreach($fine_fee as $obj_pdf)              
                {
                    $total_amt_pdf=$total_amt_pdf+$obj_pdf->fee_amount;?>  
                <div class="row" style="">
                        <div class="col-sm-6" style="text-align:center; border-right:1px solid grey"> <?php echo $obj_pdf->fee_name;?></div>
                        <div class="col-sm-6" style="text-align:center; border-right:1px solid grey"> <?php echo $obj_pdf->fee_amount;?> </div>
                    </div>
                <?php }?>
                <div class="row" style="border-bottom:1px solid gray;">
                    
                </div>
                <div class="row" style="border-bottom:1px solid gray;">
                      <div class="col-sm-6" style="text-align:center; border-right:1px solid grey"> TOTAL </div>
                        <div class="col-sm-6" style="text-align:center; border-right:1px solid grey"><?php echo $total_amt_pdf.' INR';?> </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-3" style="padding-right:0px !important;width: 26%;"><span style="padding:5px;margin-right:10px"> Rs(in words):</span></div>
                    <div class="col-sm-9" style="padding-left:0px !important;width: 74%;border-bottom: 1px dotted;"> <span> <?php echo strtoupper($total_amt_words.' only');?></span></div>
                  </div>
                
                <div class="row" style="border-bottom:1px double brown; border-bottom-style: double; margin:5px; margin-top:10px;">
                    
                </div>
                <div class="row" style="padding:10px; margin:5px; text-align:center;">
                    <p style="color:blue; display:inline"> Powered By : </p>
                    <p style="display:inline;"> MildTrix Business Solution Pvt Ltd</p>
                </div>
            </div>
          </div>
        
          <div class="modal-footer">
              <a  class="btn btn-info" id="download1" href="<?php echo base_url("payment/btn_download_pop_load/dwld_yes/$fee_transaction_id");?>" style="background:#46b8da;">
                            <span class="glyphicon glyphicon-download"></span>Download
              </a>
            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
           
          </div>
          </form>
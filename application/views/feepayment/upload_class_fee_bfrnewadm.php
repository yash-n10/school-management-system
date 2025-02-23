<style>
    .col-md-2 {
    width: 15.667% !important;
}
</style>
<div class="form-group has-feedback">
    <div class="panel  panel-default" style="background: floralwhite;"> 



        <div class="panel-body" id="msg">
            <?php // echo $message;?>
        

        <?php
        if ($upload == 1) {
            $style1 = 'display:none';
            $style = 'display:block;';
        } else {
            $style1 = 'display:block';
            $style = 'display:none;';
        }
        ?>


        <form id='frmaddsection' action="<?php // echo base_url('fee/save_class_fee') ?>" role="form" method="POST">
            <?php // if($this->session->userdata('user_group_id') == 1 || $this->session->userdata('user_group_id') == 2){ ?>
            <?php if ($this->session->userdata('user_group_id') == 1) { ?>
                <div class="box-body" style="<?php echo $style1; ?>">
                    <div class="col-lg-3">School</div>
                    <div class="col-lg-3">
                        <select id="school" name="school" class="form-control">
                            <option value="0">- Select School -</option>
                            <?php foreach ($schools as $school) { ?>
                                <option value="<?php echo $school->id ?>"><?php echo $school->description; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            <?php } ?>
            <div class="box-body" style="<?php echo $style1; ?>">

                <div class="row" style="margin-bottom:30px;">                                      
                            <div class="col-md-2" style="padding:0px;text-align:right"> <b> Year (now onwards): </b> </div>
                            <div class="col-md-2"><input type="number" maxlength="4" min="1999" max="2999" id="year" required="" value="<?php if($task=='edit'){echo $year;} ?>" step="0" name="year" class="form-control" placeholder="year"></div>
                            <div class="col-md-3" style="width:17.6%"></div>
                           <div class="col-md-1" style="padding:0px;text-align:right;"> </div>
                            <div class="col-md-3"> 

                            </div>
                           <div class="col-md-1"></div>
                   
                   
                </div>
                
                
                
                
                
                
                
                <div class="row" style="margin-bottom:30px;">
                    
                    
                    <div class="col-md-2" style="text-align:right;padding:0px"> <b> Class-range :</b></div>
                    <div class="col-md-2">                       
                        <select name="from_class_id" class="form-control" id="from_class_id" required>
                            <option value="">Select Class</option>
                            <?php foreach ($class as $name) {
                                ?>
                                <option <?php if($task=='edit'){if($from==$name->id){echo 'selected="selected"';}} ?>  value="<?php echo $name->id; ?>"><?php echo $name->class_name; ?></option>
                            <?php } ?>
                        </select>
                    </div> 
                    <div class="col-md-1" style="width:1%;padding:0px">To</div>
                    <div class="col-md-2"> 
                        <select name="to_class_id" class="form-control" id="to_class_id">
                            <option>Select Class</option>
                            <?php foreach ($class as $name) {
                                ?>
                                <option <?php if($task=='edit'){if($to==$name->id){echo 'selected="selected"';}} ?>  value="<?php echo $name->id; ?>"><?php echo $name->class_name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                 
                    <div class="col-md-1" style="padding:0px;text-align:right"> <b>Course:</b> </div>
                    <div class="col-md-2">
                    
                        <select name="student_course" class="form-control" id="student_course" style="padding-right:0px">
                            <option value="0"> Select course</option>
                            <?php foreach ($course as $obj_course) {
                                ?>
                                <option <?php if($task=='edit'){if($obj_course->id==$course_id) {echo 'selected=selected' ;} }?> value="<?php echo $obj_course->id; ?>"><?php echo $obj_course->course_name; ?></option>
                            <?php } ?>
                        </select>
                    
                    </div>
                    <div class="col-md-2" style="padding:0px"> <b>Especially For class(11-12)</b> </div>
                 
                </div>
                
                
                <div class="row" style="margin-bottom:30px;">
                
                </div>
                
                <?php //if($this->school_desc[0]->school_group=='ARMY'){ ?>
                                <!-------------------------------   Onetime Fee  -------------------------------------->        
            
                    <?php if ($onetime == 'YES') {
                        ?>
                    <div class="row">
                        <div class="col-md-12" id="onetime_fee" style="margin-bottom: 10px;">
                            <div class="col-lg-12" style="border: 1px solid grey;"> 
                                <div class="row" style="background-color:#104e8b; text-align:center; color:white;"><b> Onetime Fee </b></div>
                                <div class="row" style="border-bottom: 1px solid grey;background-color: white;font-family: serif;font-weight: bold;">
                                    <div class="col-md-1" style="width: 2.333333%;"></div> <div class="col-md-2"> Fee Name </div>
                                        <?php $total_onetime_amt=array(); foreach ($stud_cat as $obj_cat) {if($task=='edit'){ $total_onetime_amt[$obj_cat->id]=0;}
                                                ?>                                                 
                                                <div class="col-md-2" style="text-align: center;"> <?php echo $obj_cat->cat_code ?></div>
                                        <?php } ?>
                                </div>
                                <?php foreach ($onetime_fee as $obj_onetime) {$status='unchecked';

                                    ?>
                                    <div class="row" style="background-color:#e0eee0;padding-top:5px;"> 
                                        
                                        <div class="col-md-1" style="width: 2.333333%;"><input type="checkbox"  <?php if($task=='edit') {foreach($qry_class_fee_one_det_chk as $obj_fee_id){if($obj_fee_id->fee_id==$obj_onetime->id){ echo "checked";$status="checked";}}}?> id="chk_onetime_<?php echo $obj_onetime->id; ?>" name="chkfee9[]" value="<?php echo $obj_onetime->id; ?>"></div>
                                        <div class="col-md-2">
                                            <?php echo $obj_onetime->fee_name; ?>
                                            <input type="hidden" name="onetime_fee_id[<?php echo $obj_onetime->id ?>]" value="<?php echo $obj_onetime->fee_cat_id; ?>" id="onetime_fee_id_<?php echo $obj_onetime->id.'_'.$obj_onetime->id; ?>">
                                        </div> 
                                                <?php foreach ($stud_cat as $obj_cat) {
                                                ?>
                                                        <div class="col-md-2">
                                                            <input type="number" step="0" style="width: 100%" <?php if($task=='edit'){ if($status !='checked'){echo 'disabled="true"';};}else { echo 'disabled="true"';} ?> name="onetime_fee_amount[<?php echo $obj_onetime->id ?>][<?php echo $obj_cat->id ?>]" value="<?php if($task=='edit'){foreach($qry_class_fee_one_det_amt as $obj_fee_id){if($obj_fee_id->fee_id==$obj_onetime->id && $obj_fee_id->stud_cat==$obj_cat->id){$total_onetime_amt[$obj_cat->id]=$total_onetime_amt[$obj_cat->id]+$obj_fee_id->fee_amount; echo $obj_fee_id->fee_amount;}}}?>" id="onetime_fee_amount_<?php echo $obj_onetime->id.'_'.$obj_cat->id; ?>">
                                                        </div>  
                                                <?php } ?>
                                    </div> 
                                <?php } ?>
                                <div class="row" style="background-color:#e0eee0;height:10px;border-bottom: 1px solid grey;">                         

                                </div>
                                <div class="row" style="background-color:#e0eee0;padding-top:5px;padding-bottom: 10px;"> 
                                    <div class="col-md-1" style="width: 2.333333%;"></div>
                                    <div class="col-md-2"> Total </div>
                                    <?php foreach ($stud_cat as $obj_cat) { ?>     
                                    <div class="col-md-2"><input type="text" style="background:cornsilk;width: 100%" readonly="true" name="total_onetime[<?=$obj_cat->id;?>]" value="<?php  if($task=='edit'){ echo  $total_onetime_amt[$obj_cat->id];} ?>" id="total_onetime_<?=$obj_cat->id;?>"></div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                </div>

                <?php } ?>
             <?php //} ?>

                
                <!-------------------------------   Onetime Fee  -------------------------------------->     
                
                
                <!-------------------------------   Annual and Monthly Fee  -------------------------------------->        
            
                    <?php if ($fee_type2 == 4) {
                        ?>
                    <div class="row">
                        <div class="col-md-12" id="annual_fee" style="margin-bottom: 10px;">
                            <div class="col-lg-12" style="border: 1px solid grey;"> 
                                <div class="row" style="background-color:#104e8b; text-align:center; color:white;"><b> Annual Fee </b></div>
                                <div class="row" style="border-bottom: 1px solid grey;background-color: white;font-family: serif;font-weight: bold;">
                                    <div class="col-md-1" style="width: 2.333333%;"></div> <div class="col-md-2"> Fee Name </div>
                                        <?php $total_annual_amt=array(); foreach ($stud_cat as $obj_cat) {if($task=='edit'){ $total_annual_amt[$obj_cat->id]=0;}
                                                ?>                                                 
                                                <div class="col-md-2" style="text-align: center;"> <?php echo $obj_cat->cat_code ?></div>
                                        <?php } ?>
                                </div>
                                <?php foreach ($annual_fee as $obj_annual) {$status='unchecked';
                                    ?>
                                    <div class="row" style="background-color:#e0eee0;padding-top:5px;"> 
                                        <div class="col-md-1" style="width: 2.333333%;"><input type="checkbox"  <?php if($task=='edit') {foreach($qry_class_fee_ann_det_chk as $obj_fee_id){if($obj_fee_id->fee_id==$obj_annual->id){ echo "checked";$status="checked";}}}?> id="chk_ann_<?php echo $obj_annual->id; ?>" name="chkfee1[]" value="<?php echo $obj_annual->id; ?>"></div>
                                        <div class="col-md-2">
                                            <?php echo $obj_annual->fee_name; ?>
                                            <input type="hidden" name="annual_fee_id[<?php echo $obj_annual->id ?>]" value="<?php echo $obj_annual->id; ?>" id="annual_fee_id_<?php echo $obj_annual->id.'_'.$obj_annual->id; ?>">
                                        </div> 
                                                <?php foreach ($stud_cat as $obj_cat) {
                                                ?>
                                                        <div class="col-md-2">
                                                            <input type="number" step="0" style="width: 100%" <?php if($task=='edit'){ if($status !='checked'){echo 'disabled="true"';};}else { echo 'disabled="true"';} ?> name="annual_fee_amount[<?php echo $obj_annual->id ?>][<?php echo $obj_cat->id ?>]" value="<?php if($task=='edit'){foreach($qry_class_fee_ann_det_amt as $obj_fee_id){if($obj_fee_id->fee_id==$obj_annual->id && $obj_fee_id->stud_cat==$obj_cat->id){$total_annual_amt[$obj_cat->id]=$total_annual_amt[$obj_cat->id]+$obj_fee_id->fee_amount; echo $obj_fee_id->fee_amount;}}}?>" id="annual_fee_amount_<?php echo $obj_annual->id.'_'.$obj_cat->id; ?>">
                                                        </div>  
                                                <?php } ?>
                                    </div> 
                                <?php } ?>
                                <div class="row" style="background-color:#e0eee0;height:10px;border-bottom: 1px solid grey;">                         

                                </div>
                                <div class="row" style="background-color:#e0eee0;padding-top:5px;padding-bottom: 10px;"> 
                                    <div class="col-md-1" style="width: 2.333333%;"></div>
                                    <div class="col-md-2"> Total </div>
                                    <?php foreach ($stud_cat as $obj_cat) {
                                                ?>
                                    
                                                <div class="col-md-2"><input type="text" style="background:cornsilk;width: 100%" readonly="true" name="total_annual[<?=$obj_cat->id;?>]" value="<?php  if($task=='edit'){ echo  $total_annual_amt[$obj_cat->id];} ?>" id="total_annual_<?=$obj_cat->id;?>"></div>
                                        <?php } ?>
                                </div>
                            </div>
                        </div>
                </div>

                    <?php } else { ?>
                    <div class="row">
                        <div class="col-md-12" id="half_yearly_fee" style="    margin-bottom: 10px;">
                            <div class="col-lg-10" style="border: 1px solid grey;width: 100%;"> 
                                <div class="row" style="background-color:#104e8b; text-align:center; color:white;"><b> Half-yearly Fee </b></div>
                                <div class="row" style="border-bottom: 1px solid grey;background-color: white;font-family: serif;font-weight: bold;">
                                    <div class="col-md-1" style="width: 2.333333%;"></div> <div class="col-md-2"> Fee Name </div>
                                     <?php $total_half_amt=array(); foreach ($stud_cat as $obj_cat1) { if($task=='edit'){ $total_half_amt[$obj_cat1->id]=0;}
                                                ?>                                                 
                                                <div class="col-md-2" style="text-align: center;"><?php echo $obj_cat1->cat_code;?> </div>
                                        <?php } ?>
                                </div>   

                                <?php foreach ($half_yearly_fee as $obj_half) {$status='unchecked';
                                    ?>
                                <div class="row" style="background-color:#e0eee0;padding-top:5px;">                         
                                <div class="col-md-1" style="width: 2.333333%;"><input type="checkbox" id="chk_ann_<?php echo $obj_half->id; ?>" name="chkfee3[]"  <?php if($task=='edit') {foreach($qry_class_fee_sem_det_chk as $obj_fee_id){if($obj_fee_id->fee_id==$obj_half->id){ echo "checked";$status="checked";}}}?> value="<?php echo $obj_half->id; ?>"></div>

                                        <div class="col-md-2" >
                                            <?php echo $obj_half->fee_name; ?>
                                            <input type="hidden" name="half_yearly_fee_id[<?php echo $obj_half->id; ?>]" value="<?php echo $obj_half->id; ?>" id="half_yearly_fee_id_<?php echo $obj_half->id; ?>">
                                        </div> 
                                        
                                               <?php foreach ($student_cat as $obj_cat) { 
                                                ?>  
                                                            <div class="col-md-2" style="text-align: center;">

                                                            <input type="number" step="0" style="width: 100%" <?php if($task=='edit'){ if($status !='checked'){echo 'disabled="true"';};}else { echo 'disabled="true"';} ?>  name="half_yearly_fee_amount[<?php echo $obj_half->id; ?>][<?php echo $obj_cat->id; ?>]" value="<?php if($task=='edit'){foreach($qry_class_fee_sem_det_amt as $obj_fee_id){if($obj_fee_id->fee_id==$obj_half->id && $obj_fee_id->stud_cat==$obj_cat->id){$total_half_amt[$obj_cat->id]=$total_half_amt[$obj_cat->id]+$obj_fee_id->fee_amount; echo $obj_fee_id->fee_amount;}}}?>" id="half_yearly_fee_amoun_<?php echo $obj_half->id.'_'.$obj_cat->id; ?>">
                                                             </div> 
                                                <?php  } ?>
                                        
                                                             
                                    </div> 
                                <?php } ?>
                                <div class="row" style="background-color:#e0eee0;height:10px;border-bottom: 1px solid grey;">                         

                                </div>
                                <div class="row" style="background-color:#e0eee0;padding-top:5px;padding-bottom: 10px;">                         
                                    <div class="col-md-1" style="width: 2.333333%;">  </div>
                                    <div class="col-md-2" > Total </div>
                                       <?php foreach ($stud_cat as $obj_cat) {
                                                ?>  
                                                <div class="col-md-2" style="text-align: center;"><input type="text" style="width: 100%" style="background:cornsilk;" readonly="true" name="total_half[<?php echo $obj_cat->id; ?>]" value="<?php  if($task=='edit'){ echo  $total_half_amt[$obj_cat->id];} ?>" id="total_half_<?php echo $obj_cat->id; ?>"></div>
                                       <?php } ?>
                                
                                </div>
                            </div>
                        </div>  
                     </div> 
                    <?php } ?>  


                    <?php if ($fee_type1 == 1) {
                        ?>
                    <div class="row">
                        <div class="col-md-12" id="monthly_fee">
                            <div class="col-lg-12" style="border: 1px solid grey;"> 
                                <div class="row" style="background-color:#104e8b; text-align:center; color:white;"><b> Monthly Fee </b></div>
                                <div class="row" style="border-bottom: 1px solid grey;background-color: white;font-family: serif;font-weight: bold;">
                                    <div class="col-md-1" style="width: 2.333333%;"></div>  
                                    <div class="col-md-2"> Fee Name </div>
                                       <?php $total_month_amt=array();foreach ($stud_cat as $obj_cat1) {if($task=='edit'){ $total_month_amt[$obj_cat1->id]=0;}
                                                ?>                                                 
                                                <div class="col-md-2" style="text-align: center;"><?php echo $obj_cat1->cat_code;?> </div>
                                        <?php } ?>
                                </div>
                                <?php foreach ($monthly_fee as $obj_annual) {$status1='unchecked';
                                    ?>
                                    <div class="row" style="background-color:#e0eee0;padding-top:5px;">
                                        <div class="col-md-1" style="width: 2.333333%;"><input type="checkbox" id="chk_mon_<?php echo $obj_annual->id; ?>" <?php if($task=='edit') {foreach($qry_class_fee_mon_det_chk as $obj_fee_id){if($obj_fee_id->fee_id==$obj_annual->id){ echo "checked";$status1="checked";}}}?> name="chkfee2[]" value="<?php echo $obj_annual->id; ?>"></div>
                                        <div class="col-md-2">
                                            <?php echo $obj_annual->fee_name; ?>
                                            <input type="hidden" name="monthly_fee_id[<?php echo $obj_annual->id ?>]" value="<?php echo $obj_annual->id; ?>" id="monthly_fee_id_<?php echo $obj_annual->id; ?>">
                                        </div> 
                                           <?php foreach ($student_cat as $obj_cat) {
                                                ?> 
                                                    <div class="col-md-2" style="text-align: center;">
                                                        <input type="number" step="0" style="width: 100%" <?php if($task=='edit'){ if($status1 !='checked'){echo 'disabled="true"';};}else { echo 'disabled="true"';} ?> name="monthly_fee_amount[<?php echo $obj_annual->id ?>][<?= $obj_cat->id ?>]" value="<?php if($task=='edit'){foreach($qry_class_fee_mon_det_amt as $obj_fee_id){if($obj_fee_id->fee_id==$obj_annual->id && $obj_fee_id->stud_cat==$obj_cat->id){$total_month_amt[$obj_cat->id]=$total_month_amt[$obj_cat->id]+$obj_fee_id->fee_amount; echo $obj_fee_id->fee_amount;}}}?>" id="monthly_fee_amount_<?php echo $obj_annual->id.'_'.$obj_cat->id; ?>" >
                                                    </div> 
                                            <?php } ?>
                                    </div> 
                                <?php } ?>
                                <div class="row" style="background-color:#e0eee0;height:10px;border-bottom: 1px solid grey;">                         

                                </div>
                                <div class="row" style="background-color:#e0eee0;padding-top:5px;    padding-bottom: 10px;">   
                                    <div class="col-md-1" style="width: 2.333333%;"></div>
                                    <div class="col-md-2"> Total </div>
                                     <?php foreach ($stud_cat as $obj_cat) {
                                                ?>  
                                    <div class="col-md-2" style="text-align: center;"><input type="text" style="width: 100%" readonly="true" style="background:cornsilk;" name="total_monthly[<?= $obj_cat->id ?>]" value="<?php  if($task=='edit'){ echo  $total_month_amt[$obj_cat->id];} ?>" id="total_monthly_<?= $obj_cat->id ?>"></div>
                                            <?php } ?>
                                
                                </div>
                            </div>
                        </div>
                     </div>
                    <?php } else { ?>
                        
                         <div class="row">
                        <div class="col-md-12" id="quarterly_fee">
                            <div class="col-lg-12" style="border: 1px solid grey;"> 
                                <div class="row" style="background-color:#104e8b; text-align:center; color:white;"><b> Quarterly Fee </b></div>
                                <div class="row" style="border-bottom: 1px solid grey;background-color: white;font-family: serif;font-weight: bold;">
                                    <div class="col-md-1" style="width: 2.333333%;"></div>  
                                    <div class="col-md-2"> Fee Name </div>
                                       <?php $total_qtr_amt=array();foreach ($stud_cat as $obj_cat1) {if($task=='edit'){ $total_qtr_amt[$obj_cat1->id]=0;}
                                                ?>                                                 
                                                <div class="col-md-2" style="text-align: center;"><?php echo $obj_cat1->cat_code;?> </div>
                                        <?php } ?>
                                </div>
                                <?php foreach ($quarterly_fee as $obj_quarterly) {$status1='unchecked';
                                    ?>
                                    <div class="row" style="background-color:#e0eee0;padding-top:5px;">
                                        <div class="col-md-1" style="width: 2.333333%;"><input type="checkbox" id="chk_qtr_<?php echo $obj_quarterly->id; ?>" <?php if($task=='edit') {foreach($qry_class_fee_qtr_det_chk as $obj_fee_id){if($obj_fee_id->fee_id==$obj_quarterly->id){ echo "checked";$status1="checked";}}}?> name="chkfee5[]" value="<?php echo $obj_quarterly->id; ?>"></div>
                                        <div class="col-md-2">
                                            <?php echo $obj_quarterly->fee_name; ?>
                                            <input type="hidden" name="quarterly_fee_id[<?php echo $obj_quarterly->id ?>]" value="<?php echo $obj_quarterly->id; ?>" id="quarterly_fee_id_<?php echo $obj_quarterly->id; ?>">
                                        </div> 
                                           <?php foreach ($student_cat as $obj_cat) {
                                                ?> 
                                                    <div class="col-md-2" style="text-align: center;">
                                                        <input type="number" step="0" style="width: 100%" <?php if($task=='edit'){ if($status1 !='checked'){echo 'disabled="true"';};}else { echo 'disabled="true"';} ?> name="quarterly_fee_amount[<?php echo $obj_quarterly->id ?>][<?= $obj_cat->id ?>]" value="<?php if($task=='edit'){foreach($qry_class_fee_qtr_det_amt as $obj_fee_id){if($obj_fee_id->fee_id==$obj_quarterly->id && $obj_fee_id->stud_cat==$obj_cat->id){$total_qtr_amt[$obj_cat->id]=$total_qtr_amt[$obj_cat->id]+$obj_fee_id->fee_amount; echo $obj_fee_id->fee_amount;}}}?>" id="quarterly_fee_amount_<?php echo $obj_quarterly->id.'_'.$obj_cat->id; ?>" >
                                                    </div> 
                                            <?php } ?>
                                    </div> 
                                <?php } ?>
                                <div class="row" style="background-color:#e0eee0;height:10px;border-bottom: 1px solid grey;">                         

                                </div>
                                <div class="row" style="background-color:#e0eee0;padding-top:5px;    padding-bottom: 10px;">   
                                    <div class="col-md-1" style="width: 2.333333%;"></div>
                                    <div class="col-md-2"> Total </div>
                                     <?php foreach ($stud_cat as $obj_cat) {
                                                ?>  
                                    <div class="col-md-2" style="text-align: center;"><input type="text" style="width: 100%" readonly="true" style="background:cornsilk;" name="total_quarterly[<?= $obj_cat->id ?>]" value="<?php  if($task=='edit'){ echo  $total_qtr_amt[$obj_cat->id];} ?>" id="total_quarterly_<?= $obj_cat->id ?>"></div>
                                            <?php } ?>
                                
                                </div>
                            </div>
                        </div>
                     </div>

                    <?php } ?> 

               


                <!-------------------------------   Other And Late Fee  -------------------------------------->   
                <div class="row" style="margin-top:10px;">
                    <div class="col-md-5">
                        <div class="col-lg-12" style="border: 1px solid grey;"> 
                            <div class="row" style="background-color:#104e8b; text-align:center; color:white;"><b>Other/Additional Fees </b></div>
                            <div class="row" style="border-bottom: 1px solid grey;background-color: white;font-family: serif;font-weight: bold;">
                                    <div class="col-md-6"> Fee Name </div><div class="col-md-6"> Amount </div>
                            </div>
                            <?php foreach ($other_fee as $obj_annual) {
                                ?>
                                <div class="row" style="background-color:#e0eee0;padding-top:5px;">                         
                                    <div class="col-md-6">
                                        <?php echo $obj_annual->fee_name; ?>
                                        <input type="hidden" name="other_fee_id[]" value="<?php echo $obj_annual->id; ?>" id="other_fee_id_<?php echo $obj_annual->id; ?>">
                                    </div> 
                                    <div class="col-md-6">
                                        <input type="number" step="0" name="other_fee_amount[]" value="<?php if($task=='edit'){foreach($qry_class_fee_other_det as $obj_fee_id){if($obj_fee_id->fee_id==$obj_annual->id){ echo $obj_fee_id->fee_amount;}}}?>" id="other_fee_amount_<?php echo $obj_annual->id; ?>">
                                    </div>                        
                                </div> 
                            <?php } ?>
                            <div class="row" style="background-color:#e0eee0;height:10px;border-bottom: 1px solid grey;">                         

                            </div>

                        </div>
                    </div>

                    <?php if($this->school_desc[0]->school_group=='ARMY'){ ?>

                    <div class="col-md-7">
                        <div class="col-lg-12" style="border: 1px solid grey;"> 
                           
                            <div class="row" style="background-color:#104e8b; text-align:center; color:white;"><b>Late fine </b></div>
                            
                            <div class="row" style="border-bottom: 1px solid grey;background-color: white;font-family: serif;font-weight: bold;">
                                     <div class="col-md-2"> </div>
                                     <div class="col-md-3" style="text-align: center">From Day </div>
                                     <div class='col-md-1'></div>
                                     <div class="col-md-1"> </div>
                                     <div class="col-md-2" style="text-align: center">To Day </div>
                                     <div class="col-md-2"> Amount </div>
                                     <div class='col-md-1'></div>
                                     <!--<div class="col-md-1"> Month </div>-->
<!--                                     <div class="col-md-4">
                                         <input type="button" class="btn btn-success" style="padding: 0px 12px;font-size: 12px;" id="add_fine" value="Add">
                                     </div>-->
                            </div>

                            
                             <?php foreach ($fine_rule as $fine) { ?>
                                <div class="row" id="fine_div" style="background-color:#e0eee0;border-bottom: 1px solid grey;">     
                                    <div class="col-md-1">
                                        <input type='text' name='fine_condn_from[]' value='>=' disabled>
                                        <input type='hidden' name='no_of_months[]' value='<?php echo $fine->max_day;?>' >
                                        <input type='hidden' name='fine_rule_id[]' value='<?php echo $fine->id;?>' >
                                    </div>
                                   
                                    <div class="col-md-2"><input type="text"  name="from_day[]" value='<?php echo $fine->from_day; ?>' readonly=""></div>
                                        <div class='col-md-1'></div>
                                        
                                    <div class="col-md-2">
                                        <select  name="fine_condn_to[]" class='form-control' style="pointer-events: none;" >
                                            <option value="5" <?php if($fine->remain=='<='){echo 'selected=selected';};?>> <= </option>
                                            <option value="3" <?php if($fine->remain=='>='){echo 'selected=selected';};?>> >= </option>
                                        </select> 
                                        <!--<input type='text' name='fine_condn_from[]' value='>=' disabled>-->
                                    </div>
                                        <!--<div class='col-md-1'></div>-->
                                        <div class="col-md-2"><input type="text"  name="to_day[]" value='<?php echo $fine->to_day; ?>' readonly=""></div>
                                    
                                    <div class="col-md-2"> <input type="number"  name="fine_amount[]" value="<?php if($task=='edit') echo $fine->fee_amount;?>"> </div>
                                    
                                    <div class='col-md-1'></div>
                                </div>
                            <?php } ?>
                           <?php // } ?>
                            <div class="row" style="border-bottom: 1px solid grey;background-color: #e1edf9;font-family: serif;font-weight: bold;">
                                     <div class="col-md-2"> Re Admission Fine</div>
                                     <div class="col-md-4" style="text-align: center"> After Due month :<br><input type="number"  name="re_admission_fine_month" value="<?php if(!empty($readmsnfine_fee)) echo $readmsnfine_fee[0]->no_of_months;?>"> </div>
                                     <div class="col-md-4" style="text-align: center"> Amount: <br><input type="number"  name="re_admission_fine_amount" value="<?php if(!empty($readmsnfine_fee)) echo $readmsnfine_fee[0]->fee_amount;?>">  </div>
                                     <div class="col-md-2">
                                         
                                     </div>
                            </div>
                        </div>
                       
                    </div>


                    <?php }else {?>

                    <div class="col-md-7">
                        <div class="col-lg-12" style="border: 1px solid grey;"> 
                            <div class="row" style="background-color:#104e8b; text-align:center; color:white;"><b>Late fine </b></div>
                            
                            <div class="row" style="border-bottom: 1px solid grey;background-color: white;font-family: serif;font-weight: bold;">
                                     <div class="col-md-2"> </div>
                                     <div class="col-md-4" style="text-align: center">No of Months </div>
                                     <div class="col-md-4"> Amount </div>
                                     <div class="col-md-2">
                                         <input type="button" class="btn btn-success" style="padding: 0px 12px;font-size: 12px;" id="add_fine" value="Add">
                                     </div>
                            </div>
                           <?php if($task=='edit'){?>
                                <div class="row" id="fine_div" style="background-color:#e0eee0;border-bottom: 1px solid grey;"> 
                                    
                            <?php   foreach($fine_fee as $obj_annual)
                            {?>
                                  <div class="col-md-12" >
                                    <div class="col-md-2">
                                        <select  name="fine_condn[]" style="width:100%;border-radius: 1px;">
                                            <option value="1" <?php if($obj_annual->fine_condition==1){echo 'selected=selected';};?>> = </option>
                                            <option value="2" <?php if($obj_annual->fine_condition==2){echo 'selected=selected';};?>> > </option>
                                            <option value="3" <?php if($obj_annual->fine_condition==3){echo 'selected=selected';};?>> >= </option>
                                            <option value="4" <?php if($obj_annual->fine_condition==4){echo 'selected=selected';};?>> < </option>
                                            <option value="5" <?php if($obj_annual->fine_condition==5){echo 'selected=selected';};?>> <= </option>
                                        </select> 
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text"  name="no_of_months[]" value="<?php echo $obj_annual->no_of_months;?>">
                                    </div>
                                    <div class="col-md-6"> 
                                        <input type="text"  name="fine_amount[]" value="<?php echo $obj_annual->fee_amount;?>"> 
                                    </div>
                               </div>
                           <?php }?>
                                
                                </div>
                                        <?php    } else { ?>
                       
                                <div class="row" id="fine_div" style="background-color:#e0eee0;border-bottom: 1px solid grey;">     
                                    <div class="col-md-12" >
                                    <div class="col-md-2">
                                        <select  name="fine_condn[]" style="width:100%;border-radius: 1px;">
                                            <option value="1"> = </option>
                                            <option value="2"> > </option>
                                            <option value="3"> >= </option>
                                            <option value="4"> < </option>
                                            <option value="5"> <= </option>
                                        </select> 
                                    </div>
                                    <div class="col-md-4"><input type="text"  name="no_of_months[]"></div>
                                    <div class="col-md-6"> <input type="text"  name="fine_amount[]"> </div>
                                </div>
                                </div>
                           <?php } ?>
                            <div class="row" style="border-bottom: 1px solid grey;background-color: #e1edf9;font-family: serif;font-weight: bold;">
                                     <div class="col-md-2"> Re Admission Fine</div>
                                     <div class="col-md-4" style="text-align: center"> After Due month :<br><input type="number"  name="re_admission_fine_month" value="<?php if(!empty($readmsnfine_fee)) echo $readmsnfine_fee[0]->no_of_months;?>"> </div>
                                     <div class="col-md-4" style="text-align: center"> Amount: <br><input type="number"  name="re_admission_fine_amount" value="<?php if(!empty($readmsnfine_fee)) echo $readmsnfine_fee[0]->fee_amount;?>">  </div>
                                     <div class="col-md-2">
                                         
                                     </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>

            </div>

            
        </form>

        </div>
        <div class="panel-footer">
            <div class="row" style="<?php echo $style1; ?>">
                <div class="col-lg-12" style="text-align:center">
                    <button type="button" class="btn btn-primary" style="width: 120px;font-family: sans-serif;float:left" id="back" ><i class="fa fa-arrow-left"> </i> Back</button>
                    <?php if($task=='edit'){
//                       if($year>$session_start_yr || ($year==$session_start_yr && $session_start_month==date('m'))  || $this->session->userdata('school_id')==29){
                       if($year>$session_start_yr || ($year==$session_start_yr && $session_start_month==date('m')) || $this->session->userdata('school_id')==8){?>
                            <input type="button" class="btn btn-success" name="savefee" id="btn_save" value="Update">
                    <?php } }elseif ($task=='add') { ?>
                        <input type="button" class="btn btn-success" name="savefee" id="btn_save" value="Save">        
                        <?php    }?>
                </div>
            </div>
        </div>


        <!-- /.box-body -->
    </div>
    <!-- /.box -->

    <script>

  
//--------------------------------------------------------------------------------------------------------------    
$('#annual_fee input[type=checkbox]').change(function() { 
//    alert();
      var id=$(this).val();
      var cat_id_array,cat_id,total,redued_tot,tot_val;
      var isChecked = $(this).is(':checked');          
       $('input[id^=annual_fee_amount_'+id).each(function() {      
             $(this).prop("disabled",!isChecked);
             if(!isChecked)
             {                 
                 cat_id_array=($(this).attr('id')).split('_');
                 cat_id=cat_id_array[4];
                 total=$('#total_annual_'+cat_id).val();
                 redued_tot=Number(total)-Number($('#annual_fee_amount_'+id+'_'+cat_id).val());
                 tot_val=redued_tot>0?redued_tot:'';
                 $('#total_annual_'+cat_id).val(tot_val);
                 $(this).val('');
             }
//        
            });

});

$('#annual_fee input[type=number]').keyup(function() { 
           var sum=0;
           var cat_id_array,cat_id,total,redued_tot,tot_val,fee_id;
           cat_id_array=($(this).attr('id')).split('_');
           cat_id=cat_id_array[4];
         
           $('#annual_fee input[type=checkbox]').each(function() {
               fee_id=$(this).val();               
               sum=Number(sum)+Number($('#annual_fee_amount_'+fee_id+'_'+cat_id).val());
            });
          $('#total_annual_'+cat_id).val(sum);              
});
//-----------------------------------------------------------------------------------------------------------------------







//-------------------------------------------ONETIME-------------------------------------------------------------------    
$('#onetime_fee input[type=checkbox]').change(function() { 
//    alert();
      var id=$(this).val();
      var cat_id_array,cat_id,total,redued_tot,tot_val;
      var isChecked = $(this).is(':checked');     
//      alert(isChecked);
       $('input[id^=onetime_fee_amount_'+id).each(function() {      
             $(this).prop("disabled",!isChecked);
             if(!isChecked)
             {                 
                 cat_id_array=($(this).attr('id')).split('_');
                 cat_id=cat_id_array[4];
                 total=$('#total_onetime_'+cat_id).val();
                 redued_tot=Number(total)-Number($('#onetime_fee_amount_'+id+'_'+cat_id).val());
                 tot_val=redued_tot>0?redued_tot:'';
                 $('#total_onetime_'+cat_id).val(tot_val);
                 $(this).val('');
             }
//        
            });

});

$('#onetime_fee input[type=number]').keyup(function() { 
           var sum=0;
           var cat_id_array,cat_id,total,redued_tot,tot_val,fee_id;
           cat_id_array=($(this).attr('id')).split('_');
           cat_id=cat_id_array[4];
         
           $('#onetime_fee input[type=checkbox]').each(function() {
               fee_id=$(this).val();               
               sum=Number(sum)+Number($('#onetime_fee_amount_'+fee_id+'_'+cat_id).val());
            });
          $('#total_onetime_'+cat_id).val(sum);              
});
//--------------------------------------------------------ONETIME---------------------------------------------------------------



//----------------------------------------------------QUARTERLY----------------------------------------------------------    
$('#quarterly_fee input[type=checkbox]').change(function() { 
      var id=$(this).val();
      var cat_id_array,cat_id,total,redued_tot,tot_val;
      var isChecked = $(this).is(':checked');          
       $('input[id^=quarterly_fee_amount_'+id).each(function() {      
             $(this).prop("disabled",!isChecked);
             if(!isChecked)
             {                 
                 cat_id_array=($(this).attr('id')).split('_');
                 cat_id=cat_id_array[4];
                 total=$('#total_monthly_'+cat_id).val();
                 redued_tot=Number(total)-Number($('#quarterly_fee_amount_'+id+'_'+cat_id).val());
                 tot_val=redued_tot>0?redued_tot:'';
                 $('#total_quarterly_'+cat_id).val(tot_val);
                 $(this).val('');
             }
//        
            });

});

$('#quarterly_fee input[type=number]').keyup(function() { 
           var sum=0;
           var cat_id_array,cat_id,total,redued_tot,tot_val,fee_id;
           cat_id_array=($(this).attr('id')).split('_');
           cat_id=cat_id_array[4];
         
           $('#quarterly_fee input[type=checkbox]').each(function() {
               fee_id=$(this).val();               
               sum=Number(sum)+Number($('#quarterly_fee_amount_'+fee_id+'_'+cat_id).val());
            });
          $('#total_quarterly_'+cat_id).val(sum);              
});
//--------------------------------------------------------QUARTERLY---------------------------------------------------------------

//--------------------------------------------------------------------------------------------------------------    
$('#monthly_fee input[type=checkbox]').change(function() { 
      var id=$(this).val();
      var cat_id_array,cat_id,total,redued_tot,tot_val;
      var isChecked = $(this).is(':checked');          
       $('input[id^=monthly_fee_amount_'+id).each(function() {      
             $(this).prop("disabled",!isChecked);
             if(!isChecked)
             {                 
                 cat_id_array=($(this).attr('id')).split('_');
                 cat_id=cat_id_array[4];
                 total=$('#total_monthly_'+cat_id).val();
                 redued_tot=Number(total)-Number($('#monthly_fee_amount_'+id+'_'+cat_id).val());
                 tot_val=redued_tot>0?redued_tot:'';
                 $('#total_monthly_'+cat_id).val(tot_val);
                 $(this).val('');
             }
//        
            });

});

$('#monthly_fee input[type=number]').keyup(function() { 
           var sum=0;
           var cat_id_array,cat_id,total,redued_tot,tot_val,fee_id;
           cat_id_array=($(this).attr('id')).split('_');
           cat_id=cat_id_array[4];
         
           $('#monthly_fee input[type=checkbox]').each(function() {
               fee_id=$(this).val();               
               sum=Number(sum)+Number($('#monthly_fee_amount_'+fee_id+'_'+cat_id).val());
            });
          $('#total_monthly_'+cat_id).val(sum);              
});
//-----------------------------------------------------------------------------------------------------------------------







//--------------------------------------------------------------------------------------------------------------    
$('#half_yearly_fee input[type=checkbox]').change(function() { 
      var id=$(this).val();
      var cat_id_array,cat_id,total,redued_tot,tot_val;
      var isChecked = $(this).is(':checked');          
       $('input[id^=half_yearly_fee_amoun_'+id).each(function() {      
             $(this).prop("disabled",!isChecked);
             if(!isChecked)
             {                 
                 cat_id_array=($(this).attr('id')).split('_');
                 cat_id=cat_id_array[5];
                 total=$('#total_half_'+cat_id).val();
//                 alert(total);
                 redued_tot=Number(total)-Number($('#half_yearly_fee_amoun_'+id+'_'+cat_id).val());
                 tot_val=redued_tot>0?redued_tot:'';
                 $('#total_half_'+cat_id).val(redued_tot);
                 $(this).val('');
             }
//        
            });

});

$('#half_yearly_fee input[type=number]').keyup(function() { 
           var sum=0;
           var cat_id_array,cat_id,total,redued_tot,tot_val,fee_id;
           cat_id_array=($(this).attr('id')).split('_');
           cat_id=cat_id_array[5];
           
           $('#half_yearly_fee input[type=checkbox]').each(function() {
               fee_id=$(this).val(); 
            
               sum=Number(sum)+Number($('#half_yearly_fee_amoun_'+fee_id+'_'+cat_id).val());
            });
          $('#total_half_'+cat_id).val(sum);              
});
//-----------------------------------------------------------------------------------------------------------------------

      var ctr = 0;
      var task='<?php echo $task;?>';
      var class_fee_head_id='<?php echo $id;?>';
      var action;
      if(task=='edit')
      {
          action='<?php echo base_url('feepayment/class_fee/update_class_fee') ?>'+'/'+class_fee_head_id;
      }
      else 
      {
          action='<?php echo base_url('feepayment/class_fee/save_class_fee') ?>';
      }

        $("#btn_save").click(function (event)
        {
            var required_feild = '';
            
            
                if (!$('form')[0].checkValidity())
                {
    //                                                alert($('#add_stud_frm')[0].validationMessage);
                    $(this).show();
                    $('form')[0].reportValidity();
                    return false;
                } else {
                        $.ajax({
                            url:action,
                            type: "POST",
                            data: $("form").serialize(),
                            dataType: "text",
                            success: function (data)
                            {
                                alert('Data Saved Successfully');
                                window.location.href = '<?php echo base_url('feepayment/class_fee') ?>';
                            },
                            error: function (data)
                            {
                                alert('e' + data);
                            }

                        });
                    }
          



        });

       
        
         <?php if($this->session->userdata('school_id')==60) { ?>
      
            $("#add_fine").click(function () 
        {
            //alert('hello');
            $("#fine_div").append('<div class="col-md-12" ><div class="col-md-1">\n\
                        <select  name="fine_condn_from[]" style="width:100%;border-radius: 1px;" disabled><option value="3"> >= </option></select> \n\
                        </div><div class="col-md-1"></div><div class="col-md-2"><input type="text"  name="from_day[]"></div><div class="col-md-1">\n\
                        <select  name="fine_condn_to[]" style="width:100%;border-radius: 1px;"><option value="5"> <= </option><option value="3"> >= </option></select> \n\
                        </div> <div class="col-md-1"></div><div class="col-md-2"><input type="text"  name="to_day[]"></div><div class="col-md-4"> <input type="text"  name="fine_amount[]"> </div><div class="col-md-2" id="size35"></div></div>');
                            $('select').select2({width:'100%',theme: "classic"});
                                     
                            
        });
        <?php } else { ?>
            
             $("#add_fine").click(function () 
        {
            //alert('hello');
            $("#fine_div").append('<div class="col-md-12"><div class="col-md-2">\n\
                        <select  name="fine_condn[]" style="width:100%;border-radius: 1px;"><option value="1"> = </option><option value="2"> > </option><option value="3"> >= </option><option value="4"> < </option><option value="5"> <= </option></select>\n\
                        </div><div class="col-md-4"><input type="text" name="no_of_months[]"></div> <div class="col-md-6"> <input type="text" name="fine_amount[]"> </div></div> ');
                            $('select').select2({width:'100%',theme: "classic"});
        });
        <?php } ?>
        
        
        
        
        $('#back').click(function(){
//                alert('hi');
                window.location.href = '<?php echo base_url('feepayment/class_fee');?>';
            });
    </script>


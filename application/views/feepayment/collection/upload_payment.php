 <div class="form-group">

        <div class="box"> 
        <div class="box-body">



            <!---------------------    UPLOAD  FEE COLLECTION    ----------------------------------------->  




            <div class="col-lg-12" style="text-align:right;">
                <!--<a type='button' class="btn btn-info" name='dwnld' id='dwnld' value='Download Format'></a>-->

                <a  class="btn btn-warning" id="download" href="<?php echo base_url('feepayment/collection/Upload_payment/download_format'); ?>">
                    <span class="glyphicon glyphicon-download"> </span> Download format
                </a>

            </div>
            <?php if(substr($right_access, 0,1)=='C') {?>
            <div class="col-sm-12 col-md-12">


                <form enctype='multipart/form-data' id='form' class="form-horizontal" action="<?php echo base_url($action) ?>"  method='post'>
                    <input type="hidden" id="tokencoin" name="tokencoin" value="<?php echo $token; ?>" >
                  
                    <?php if($this->session->userdata('user_group_id') == 1){ ?>
                    <div class="row">
                        <div class="col-lg-3">School Name</div>
                        <div class="col-lg-3">
                            <select name="school_name" id="school_name" class="form-control" onchange="select_class()">
                                <option value=''>- Select School -</option>
                                <?php
                                                                      foreach ($schools as $school) {
                                ?>
                                <option value='<?php echo $school->id ?>'><?php echo $school->description; ?></option>
                                <?php
                                                                      }
                                ?>
                            </select>
                        </div>
                    </div>

                 

                    <?php } ?>
                    <div class="row" style="padding-bottom:5px">
                        <div class="col-lg-3">Academic Session</div>
                        <div class="col-lg-3">
                            <select name="academic_session" id="academic_session" class="form-control" >
                                <option value=''>- Select academic session -</option>
                                <?php
                                       foreach ($session as $school) {
                                ?>
                                <option value='<?php echo $school->id ?>' <?php if($activesess==$school->id) echo 'selected=selected';?>><?php echo $school->session; ?></option>
                                <?php
                                        }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-3">Select CSV File to upload</div>
                        <div class="col-lg-3">
                            <input class="form-control" size='50' type='file' name='offln_payment_upload' style="height: auto;">

                        </div>
                        <div class="col-lg-6"><input type='submit' class="btn btn-success" name='submit' id='submit' value='Upload'></div>
                    </div>
                    <div class='row'>
                        <div class="col-sm-12 col-md-12" style="padding-top:2%;color:red;font-weight: bold">

                                <?php echo $message;?>
                        </div>
                    </div>
                </form>
            </div>
            <?php } else{?>

                <div class="col-lg-12"><b>NOTE:</b>   You Don't Have Permission To Upload</div>

                <?php }?>
        </div>
        </div>
            <?php
        if (isset($errors) && count($errors) > 0) {
            ?>
            <div class="box">
                <div class="box-body">                    
                    <legend style='color:red'><u>Errors</u></legend>
                    <pre>
<?php
foreach ($errors as $error => $v) {
    echo "$v\n";
}
?>
                    </pre>
                </div>	
            </div>
            <?php
        }
        ?>
        <div class="box">
		<div class="box-body ">
			<legend><u>Instructions</u></legend>
                        <ol>
				<li>First <b>Download the Format</b> (File Should be in CSV( Comma Separated Delimited) Format).</li>
                                <li>For <b>FEE HEAD</b> , Enter <?php if($fee_cat1==2) {?> 'MON' for Monthly <?php }else {?> 'QTR' for Quaterly and 'ONE' for Onetime <?php }?> and 'ANN' for Annual.</li>
                                <li>For <b>MODE</b> ,Put CASH or CHEQUE or DRAFT or DC or CC etc.</li>
				<li>For <b>Collection Centre</b> , Put Collection center code as per created in Collection Center Link.</li>
				<li>For <b>Bank Code</b>, Put shortform of Bank e.g:
                                    <ul>
                                        <li>RBI : Reserve Bank Of India</li>
                                    </ul>
                                </li>
			</ol>
                        <div class="table-responsive ">
                         <table class="table table-striped table-bordered ">
                            <tr class="success">
                                <th>Admission Number</th>
                                <th>Fee head</th>
                                <th>No.of <?php if ($fee_cat1 == 2) {?> Month <?php }else{?> Quarter (how many qtr?)<?php }?></th>
                                <!--<th>Fees Amount</th>-->
                                <th>Transport Fee Amount(YES if any)</th>
                                <th>Late Fine Amount(if any)</th>
                                <th>No. of Late Month(if Late fine)</th>
                                <th>Mode</th>
                                <th>Bank code</th>
                                <th>Collection centre</th>
                                <th>payment date</th>
                                <th>Remarks</th>
                                <th>Instant Fee Name(if Instant fee in Fee Head)</th>
                            </tr>
                            <tr class="danger">
                                <td>Admission No.</td>
                                <td><?php if ($fee_cat1 == 2) {?>MON<?php }else{?>QTR/ONE/ <?php }?>/ANN (choose one option)</td>
                                <td>Total no. - Any number (from 1 to <?php if ($fee_cat1 == 2) {?>12<?php }else{?>4<?php }?>) <br>(only if Fee Head is <?php if ($fee_cat1 == 2) {?>MON<?php }else{?>Qtr<?php }?>) .<br> Let it be blank for ANN.</td>
                                <!--<td>Amount in round figure</td>-->
                                <td>Transport Amount(YES) if any , Otherwise let it be Blank</td>
                                <td>Late fine Amount if any , Otherwise let it be Blank</td>
                                <td>No of late Month(from 1 to 12) if any , Otherwise let it be Blank</td>
                                <td>CASH/CHALLAN/DRAFT/POS (choose one option)</td>
                                <td>Bank short Name (if collection centre is BANK)</td>
                                <td><?php $str='';foreach($acollectioncentre as $ac){$str.=$ac->collection_code.' / ';} rtrim($str); echo $str;?> (choose one option)</td>
                                <td>(dd-mm-YYYY or dd/mm/YYYY) should be in number</td>
                                <td>Put Remarks (If Any)</td>
                                <td>Instant Fee Name(if Instant fee in Fee Head)</td>
                            </tr>
                        </table>   
                        </div>
                        
			
		</div>	
	</div>



</div>



<script>

//    function ChangeUrl(page, url) {
//        if (typeof (history.pushState) != "undefined") {
//            var obj = { Page: page, Url: url };
//            history.pushState(obj, obj.Page, obj.Url);
//        } else {
//            alert("Browser does not support HTML5.");
//        }
//    }
//   ChangeUrl('new', base_url('feepayment/collection/Offline_payment'));
    $(document).ready(function ()
    {
//            ChangeUrl('new', base_url('feepayment/collection/Offline_payment'));
        $('#submit').click(function () {
            
            var r = confirm("Are you sure you want to upload this Fee Collection?");
            if (r == true)
            {

                $('#submit').val('Uploading');
//                    ChangeUrl('new', base_url('Offline_payment'));
                return true;
            } else {
                return false;
            }
        });



    });



</script>
<style>
    .form-group{margin-bottom: 10px;} 
    fieldset { 
        border: solid 1px #a6a6a6 !important;
        padding: 0 10px 10px 10px;
        border-bottom: none;
        border-top-left-radius: 25px;
        border-bottom-left-radius: 25px;
        border-top: 2px solid #29a3a3 !important;
    }
    legend{
        width: auto !important;
        padding:0 10px;
        border: none;
        font-size: 14px;
        font-variant: small-caps;
        letter-spacing: 1px;
        text-decoration: underline;
    }
    .form-control{
        padding: 6px 5px !important;
        color:darkblue
    }
    .error-block {
        font-size: 12px;
        color: red;
    }
    .error-block >p {
        margin: 3px;
    }
</style>
<link href="<?php echo e(base_url("assets/AdminLTE/plugins/bootstrap-fileinput/bootstrap-fileinput.css")); ?>" rel="stylesheet" type="text/css" />

<script>
    function chkadmissio()
    {
        var adm=$('#admission_no').val();  
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url('admission/Tcstudent_main/loadfeedata'); ?>',
                    data:{ adm: adm,},
                    dataType:'JSON',
                    success: function (res)
                    {
                        console.log(res);
                        $('#dob_adm').val(res['dob']);
                        $('#last_class').val(res['class']);
                        $('#first_adm_date').val(res['admission_date']);
                        var dat=res['date_words'];
                        var mon=res['month_name'];
                        var yr=res['year_words'];
                        var dob_word = dat.concat('-',mon,'-',yr);
                        $('#dob_word').val(dob_word);
                        $('#stud_name').val(res['student_name']);
                        $('#father_name').val(res['father_name']);
                        $('#mother_name').val(res['mother_name']);
                        $('#fee_due').val(res['paid_month_name']);
                        $('#general_conduct').val('GOOD');
                        $('#remarks').val('NIL');
                        $('#curricular').val('USUAL GAMES');
                        $('#first_class').val(res['first_class']).prop('selected', true).trigger('change');
                        // $('#feedueModal').modal('show');
                        // $('select').select2({width:'100%',theme: "classic"});

                    },
                    error: function (req, status)
                    {
                        alert('No data Found');
                        return false;
                    }
                });
                
                
    }
</script>
<div class="panel  panel-default"> 
    <div class="panel-body">
        <form enctype="multipart/form-data" id="studentdetails" action="" method="post">
            <div class="col-sm-12 col-md-12">
                <div class="row">
                    <div class="col-sm-12">
                        <fieldset class="">
                            <legend class="" style="font-size:18px;color:green"> Official Details <span class="required"></span></legend>
                            <div class="row">
                                <div class="form-group col-sm-3">
                                    <label  style="font-weight: 600">Admission No.</label>
                                    <select class="form-control chosen-select" id="admission_no" name="admission_no" required onchange='chkadmissio()'>
                                        <option value="">Select Admission No.</option>       
                                        <?php foreach ($student as $opt) { ?>
                                            <option value="<?php echo $opt->admission_no; ?>"><?php echo $opt->admission_no; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="form-group col-sm-3">
                                    <label style="font-weight: 600">Inactive Type</label>
                                    <select class="form-control chosen-select" id="inactive_type" name="inactive_type" required>
                                        <option value="">Select </option>       
                                        <option value="TC">TC </option>       
                                        <option value="PASSOUT">Passout </option>       
                                        <option value="LEFTWITHOUT">Left Without Information </option>       
                                    </select>
                                </div>
                            <div class="form-group col-sm-3">

                                <label style="font-weight: 600">Session</label>
		                            <select class="form-control" name="session_name" id="session_name">
		                                <option value="">Select</option>
                                     
                                  <?php
                                        $session_list=$this->db->query("SELECT * FROM accedemic_session");
                                        $session_list=$session_list->result();
                                        foreach ($session_list as $key) {
                                           ?>
                                           <option value="<?php echo $key->session;?>"><?php echo $key->session;?></option>
                                        <?php
                                        }
                                        ?>
<!-- 		                                <option value="2018-2019">2018-2019</option>
		                                <option value="2019-2020">2019-2020</option> 
		                                <option value="2020-2021">2020-2021</option>
 -->		                            </select>
                        	</div>
                                <div class="form-group col-sm-3">
                                    <label  style="font-weight: 600">Date of Application</label><span style='color:red;font-weight:bold'>*</span>
                                    <input class="form-control" name="date" id="date" type="date" value="<?php echo date('Y-m-d'); ?>" required>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>

                <div class="row" id="tc_data_all" style="display: none">
                    <div class="col-sm-12">
                        <fieldset class="">
                            <legend class="" style="font-size:18px;color:green"> TC Details <span class="required"></span></legend>
                            <div class="row">
                            	<div class="form-group col-sm-4">
		                            <label style="font-weight: 600">Board Roll No:</label>
		                            <input class="form-control" name="board_roll" id="board_roll" type="text">
		                        </div>
		                        <div class="form-group col-sm-4">
		                            <label style="font-weight: 600">Registration No:</label>
		                            <input class="form-control" name="registration_no" id="registration_no" type="text" >
		                        </div>
		                        <?php 
		                        $fetchmaxadm=$this->db->query("SELECT max(tc_number) as tc_no FROM tc_passout WHERE (session_name='2020-2021' or session_name='2021-2022')  and date > '2021-03-30'")->result();
                                    		 $new_tc=$fetchmaxadm[0]->tc_no +1; 
                                    		 // $finaltc='DAVBAR/21-22/'.$new_tc;?>
		                         <div class="form-group col-sm-4">
		                            <label style="font-weight: 600">TC No:</label>
		                            <input class="form-control" name="tc_number" id="tc_number" type="text" value="<?php echo $new_tc;?>" readonly>
		                        </div>
                            </div>
                            <div class="row">
                                 <div class="form-group col-sm-2">
                            <label style="font-weight: 600">1. Name of the Pupil:</label>
                            <input class="form-control" name="stud_name" id="stud_name" type="text" readonly="">
                        </div>
                        <div class="form-group col-sm-2">
                            <label style="font-weight: 600">2.Mother's Name:</label>
                            <input class="form-control" name="mother_name" id="mother_name" type="text" >
                        </div>
                        <div class="form-group col-sm-2">
                            <label style="font-weight: 600">3.Father's Name:</label>
                            <input class="form-control" name="father_name" id="father_name" type="text">
                        </div>
                        <div class="form-group col-sm-2">
                            <label style="font-weight: 600">4.Nationality:</label>
                            <input class="form-control" name="nationality" id="nationality" type="text" value="INDIAN">
                        </div>
                        <div class="form-group col-sm-2">
                            <label style="font-weight: 600">5.Caste Category:</label>
                            <select name="caste_category" id="caste_category" class="form-control" required="">
                                <option value="">Select</option>
                                <option value="SC">SC</option>
                                <option value="ST">ST</option>
                                <option value="GENERAL">GENERAL</option>
                                <option value="OBC">OBC</option>
                                <option value="PHY-H">PHY-H</option>
                            </select>
                        </div>
                        <div class="form-group col-sm-2">
                            <label style="font-weight: 600">6.Date of Adm in school is:</label>
                            <input class="form-control" name="first_adm_date" id="first_adm_date" type="date" required>
                        </div>
                            </div>
                       
                       <div class="row">
                             <div class="form-group col-sm-2">
                            <label style="font-weight: 600">In Class</label>
                            <select name="first_class" id="first_class" class="form-control" required="">
                                <option value="">Select</option>
                                <option value="LKG">LKG</option>
                                <option value="UKG">UKG</option>
                                <option value="I">I</option>
                                <option value="II">II</option>
                                <option value="III">III</option>
                                <option value="IV">IV</option>
                                <option value="V">V</option>
                                <option value="VI">VI</option>
                                <option value="VII">VII</option>
                                <option value="VIII">VIII</option>
                                <option value="IX">IX</option>
                                <option value="X">X</option>
                                <option value="XI">XI</option>
                                <option value="XII">XII</option>
                            </select>
                        </div>
                        <div class="form-group col-sm-3">
                            <label style="font-weight: 600">7.Date of Birth Acc. to Admission Register</label>
                            <input class="form-control" name="dob_adm" id="dob_adm" type="date">
                        </div>
                        <div class="form-group col-sm-4">
                            <label style="font-weight: 600">DOB(in word)</label>
                            <input class="form-control" name="dob_word" id="dob_word" type="text" >
                        </div>
                        <div class="form-group col-sm-3">
                            <label style="font-weight: 600">8.Whether failed in same class</label>
                            <select name="failed_in_class" id="failed_in_class" class="form-control">
                                <option value="NO">NO</option>
                                <option value="YES">YES</option>
                            </select>
                        </div>
                       </div>
                      <div class="row">
                           <div class="form-group col-sm-4">
                            <label style="font-weight: 600">9.Class in which pupil studied last</label>
                            <input class="form-control" name="last_class" id="last_class" type="text" >
                        </div>
                        <div class="form-group col-sm-4">
                            <label style="font-weight: 600">10.School/Board Annual Examination Last taken with result</label>
                            
                            <select class="form-control chosen-select" id="schl_borad" name="schl_borad" required>
                                        <option value="">Select </option>       
                                        <option value="AISSCE-2020 PASS">AISSCE-2020 PASS </option>
                                        <option value="AISSCE-2021 PASS">AISSCE-2021 PASS </option>       
                                        <option value="AISSE-2021 PASS">AISSE-2021 PASS</option>       
                                        <option value="DAVPS BARIATU-2021 PASS">DAV PS BARIATU-2021 PASS</option>   
                                        <option value="AISSCE-2021 FAIL">AISSCE-2021 FAIL </option>       
                                        <option value="DAVPS BARIATU-2021 FAIL">DAV PS BARIATU-2021 FAIL</option>       
                                        <option value="AISSE-2021 FAIL">AISSE-2021 FAIL</option>   
                                        <option value="DAVPS BARIATU">DAVPS BARIATU</option>       
                                    </select>
                        </div>
                        <div class="form-group col-sm-4">
                            <label style="font-weight: 600">11.Whether qualified for promotion to higher class</label>
                            <select name="promotion_clas" id="promotion_clas" class="form-control">
                                <option value="NO">NO</option>
                                <option value="YES">YES</option>
                            </select>
                        </div>
                      </div>

                      <div class="row">
                            <div class="form-group col-sm-3">
                            <label style="font-weight: 600">If so.to which class (in figure)</label>
                            <input class="form-control" name="prom_cls_yes" id="prom_cls_yes" type="text" value="" pattern="[a-zA-Z ]+" required>
                        </div>
                        <div class="form-group col-sm-3">
                            <label style="font-weight: 600">Month upto which pupil has paid school due</label>
                            <input class="form-control" name="fee_due" id="fee_due" type="text" >
                        </div>
                        <div class="form-group col-sm-3">
                            <label style="font-weight: 600">Any fee concession availed of</label>
                            <select name="fee_consession" id="fee_consession" class="form-control">
                                <option value="NO">NO</option>
                                <option value="YES">YES</option>
                            </select>
                        </div>
                        <div class="form-group col-sm-3">
                            <label style="font-weight: 600">If so the nature of such concession</label>
                            <input class="form-control" name="fee_consession_nature" id="fee_consession_nature" type="text">
                        </div>
                      </div>
                       
                       <div class="row">
                             <div class="form-group col-sm-2">
                            <label style="font-weight: 600">Total no. of Working Days</label>
                            <input class="form-control" name="working_days" id="working_days" type="text" required="">
                        </div>
                        <div class="form-group col-sm-2">
                            <label style="font-weight: 600">Total No. of Days Present</label>
                            <input class="form-control" name="days_present" id="days_present" type="text" required="">
                        </div>
                        <div class="form-group col-sm-3">
                            <label style="font-weight: 600">Whether NCC Caded/Boy/Girl Guide</label>
                            <select name="ncc_caded" id="ncc_caded" class="form-control">
                                <option value="NO">NO</option>
                                <option value="YES">YES</option>
                            </select>
                        </div>
                        <div class="form-group col-sm-5">
                            <label style="font-weight: 600">Games Played/Extra activities in which the people took part(mention)</label>
                            <input class="form-control" name="curricular" id="curricular" type="text" >
                        </div>
                       </div>
                      
                      <div class="row">
                          <div class="form-group col-sm-4">
                            <label style="font-weight: 600">General Conduct</label>
                            <input class="form-control" name="general_conduct" id="general_conduct" type="text">
                        </div>
                         <div class="form-group col-sm-4">
                            <label style="font-weight: 600">Reason</label><span style='color:red;font-weight:bold'>*</span>
                            <select class="form-control chosen-select" id="reason" name="reason" required>
                                <option value="">Select </option>       
                                <option value="COMPLETION OF SCHOOLING">COMPLETION OF SCHOOLING</option>       
                                <option value="PARENT'S REQUEST">PARENT'S REQUEST</option>       
                                <option value="HIGHER EDUCATION">HIGHER EDUCATION</option>       
                                <option value="LEFT WITHOUT INFO">Left Without Information</option>       
                                <option value="TRANSFER">TRANSFER</option>       
                                <option value="PAYMENT DUE">PAYMENT DUE</option>       
                            </select>
                        </div>
                        <div class="form-group col-sm-4">
                            <label style="font-weight: 600">Any Other Remarks</label>
                            <input class="form-control" name="remarks" id="remarks" type="text" pattern="[a-zA-Z ]+" required>
                        </div>

                      </div>
                        
                        <div class="row">
                        
                        <div class="form-group col-sm-2">
                            <label style="font-weight: 600">Subject 1</label>
                            <select class="form-control" name="sub1" id="sub1">
                                <option value="">Select</option>
                                <option value="ENGLISH">ENGLISH</option>
                                <option value="HINDI">HINDI</option>
                                <option value="MATHS">MATHS</option>
                                <option value="SCIENCE">SCIENCE</option>
                                <option value="S.ST.">S.ST.</option>
                                <option value="SANSKRIT">SANSKRIT</option>
                                <option value="PHYSICS">PHYSICS</option>
                                <option value="CHEMISTRY">CHEMISTRY</option>
                                <option value="BIOLOGY">BIOLOGY</option>
                                <option value="COMPUTER">COMPUTER</option>
                                <option value="INF.PRAC.">INF.PRAC.</option>
                                <option value="INF.TECH.">INF.TECH</option>
                                <option value="PHYSICAL EDU">PHYSICAL EDU</option>
                                <option value="ECONOMICS">ECONOMICS</option>
                                <option value="B.ST">B.ST</option>
                                <option value="ACCOUNTANCY">ACCOUNTANCY</option>
                                <option value="DRAWING">DRAWING</option>
                                <option value="G.K">G.K</option>
                                <option value="HISTORY">HISTORY</option>
                                <option value="POL SCIENCE">POL SCIENCE</option>
                                <option value="GEOGRAPHY">GEOGRAPHY</option>
                                <option value="PAINTING">PAINTING</option>
                                <option value="COST ACCOUNTANCY">COST ACCOUNTANCY</option>
                                <option value= 'AUTOMOTIVE'>AUTOMOVTIVE</option>
                                <option value="NUTRITION & DIETETICS">NUTRITION & DIETETICS</option>
                                <option value="WEB APPLICATION">WEB APPLICATION</option>
                                <option value="ARTIFICIAL INTELLIGENCE">ARTIFICIAL INTELLIGENCE</option>
                            </select>
                        </div>
                        <div class="form-group col-sm-2">
                            <label style="font-weight: 600">Subject 2</label>
                            <select class="form-control" name="sub2" id="sub2">
                                <option value="">Select</option>
                                <option value="ENGLISH">ENGLISH</option>
                                <option value="HINDI">HINDI</option>
                                <option value="MATHS">MATHS</option>
                                <option value="SCIENCE">SCIENCE</option>
                                <option value="S.ST.">S.ST.</option>
                                <option value="SANSKRIT">SANSKRIT</option>
                                <option value="PHYSICS">PHYSICS</option>
                                <option value="CHEMISTRY">CHEMISTRY</option>
                                <option value="BIOLOGY">BIOLOGY</option>
                                <option value="COMPUTER">COMPUTER</option>
                                <option value="INF.PRAC.">INF.PRAC.</option>
                                <option value="INF.TECH.">INF.TECH</option>
                                <option value="PHYSICAL EDU">PHYSICAL EDU</option>
                                <option value="ECONOMICS">ECONOMICS</option>
                                <option value="B.ST">B.ST</option>
                                <option value="ACCOUNTANCY">ACCOUNTANCY</option>
                                <option value="DRAWING">DRAWING</option>
                                <option value="G.K">G.K</option>
                                <option value="HISTORY">HISTORY</option>
                                <option value="POL SCIENCE">POL SCIENCE</option>
                                <option value="GEOGRAPHY">GEOGRAPHY</option>
                                <option value="PAINTING">PAINTING</option>
                                <option value="COST ACCOUNTANCY">COST ACCOUNTANCY</option>
                                <option value= 'AUTOMOTIVE'>AUTOMOVTIVE</option>
                                <option value="NUTRITION & DIETETICS">NUTRITION & DIETETICS</option>
                                <option value="WEB APPLICATION">WEB APPLICATION</option>
                                <option value="ARTIFICIAL INTELLIGENCE">ARTIFICIAL INTELLIGENCE</option>
                            </select>
                        </div>
                        <div class="form-group col-sm-2">
                            <label style="font-weight: 600">Subject 3</label>
                            <select class="form-control" name="sub3" id="sub3">
                                <option value="">Select</option>
                                <option value="ENGLISH">ENGLISH</option>
                                <option value="HINDI">HINDI</option>
                                <option value="MATHS">MATHS</option>
                                <option value="SCIENCE">SCIENCE</option>
                                <option value="S.ST.">S.ST.</option>
                                <option value="SANSKRIT">SANSKRIT</option>
                                <option value="PHYSICS">PHYSICS</option>
                                <option value="CHEMISTRY">CHEMISTRY</option>
                                <option value="BIOLOGY">BIOLOGY</option>
                                <option value="COMPUTER">COMPUTER</option>
                                <option value="INF.PRAC.">INF.PRAC.</option>
                                <option value="INF.TECH.">INF.TECH</option>
                                <option value="PHYSICAL EDU">PHYSICAL EDU</option>
                                <option value="ECONOMICS">ECONOMICS</option>
                                <option value="B.ST">B.ST</option>
                                <option value="ACCOUNTANCY">ACCOUNTANCY</option>
                                <option value="DRAWING">DRAWING</option>
                                <option value="G.K">G.K</option>
                                <option value="HISTORY">HISTORY</option>
                                <option value="POL SCIENCE">POL SCIENCE</option>
                                <option value="GEOGRAPHY">GEOGRAPHY</option>
                                <option value="PAINTING">PAINTING</option>
                                <option value="COST ACCOUNTANCY">COST ACCOUNTANCY</option>
                                <option value= 'AUTOMOTIVE'>AUTOMOVTIVE</option>
                                <option value="NUTRITION & DIETETICS">NUTRITION & DIETETICS</option>
                                <option value="WEB APPLICATION">WEB APPLICATION</option>
                                <option value="ARTIFICIAL INTELLIGENCE">ARTIFICIAL INTELLIGENCE</option>
                            </select>
                        </div>
                        <div class="form-group col-sm-2">
                            <label style="font-weight: 600">Subject 4</label>
                            <select class="form-control" name="sub4" id="sub4">
                                <option value="">Select</option>
                                <option value="ENGLISH">ENGLISH</option>
                                <option value="HINDI">HINDI</option>
                                <option value="MATHS">MATHS</option>
                                <option value="SCIENCE">SCIENCE</option>
                                <option value="S.ST.">S.ST.</option>
                                <option value="SANSKRIT">SANSKRIT</option>
                                <option value="PHYSICS">PHYSICS</option>
                                <option value="CHEMISTRY">CHEMISTRY</option>
                                <option value="BIOLOGY">BIOLOGY</option>
                                <option value="COMPUTER">COMPUTER</option>
                                <option value="INF.PRAC.">INF.PRAC.</option>
                                <option value="INF.TECH.">INF.TECH</option>
                                <option value="PHYSICAL EDU">PHYSICAL EDU</option>
                                <option value="ECONOMICS">ECONOMICS</option>
                                <option value="B.ST">B.ST</option>
                                <option value="ACCOUNTANCY">ACCOUNTANCY</option>
                                <option value="DRAWING">DRAWING</option>
                                <option value="G.K">G.K</option>
                                <option value="HISTORY">HISTORY</option>
                                <option value="POL SCIENCE">POL SCIENCE</option>
                                <option value="GEOGRAPHY">GEOGRAPHY</option>
                                <option value="PAINTING">PAINTING</option>
                                <option value="COST ACCOUNTANCY">COST ACCOUNTANCY</option>
                                <option value= 'AUTOMOTIVE'>AUTOMOVTIVE</option>
                                <option value="NUTRITION & DIETETICS">NUTRITION & DIETETICS</option>
                                <option value="WEB APPLICATION">WEB APPLICATION</option>
                                <option value="ARTIFICIAL INTELLIGENCE">ARTIFICIAL INTELLIGENCE</option>
                            </select>
                        </div>
                        <div class="form-group col-sm-2">
                            <label style="font-weight: 600">Subject 5</label>
                            <select class="form-control" name="sub5" id="sub5">
                                <option value="">Select</option>
                                <option value="ENGLISH">ENGLISH</option>
                                <option value="HINDI">HINDI</option>
                                <option value="MATHS">MATHS</option>
                                <option value="SCIENCE">SCIENCE</option>
                                <option value="S.ST.">S.ST.</option>
                                <option value="SANSKRIT">SANSKRIT</option>
                                <option value="PHYSICS">PHYSICS</option>
                                <option value="CHEMISTRY">CHEMISTRY</option>
                                <option value="BIOLOGY">BIOLOGY</option>
                                <option value="COMPUTER">COMPUTER</option>
                                <option value="INF.PRAC.">INF.PRAC.</option>
                                <option value="INF.TECH.">INF.TECH</option>
                                <option value="PHYSICAL EDU">PHYSICAL EDU</option>
                                <option value="ECONOMICS">ECONOMICS</option>
                                <option value="B.ST">B.ST</option>
                                <option value="ACCOUNTANCY">ACCOUNTANCY</option>
                                <option value="DRAWING">DRAWING</option>
                                <option value="G.K">G.K</option>
                                <option value="HISTORY">HISTORY</option>
                                <option value="POL SCIENCE">POL SCIENCE</option>
                                <option value="GEOGRAPHY">GEOGRAPHY</option>
                                <option value="PAINTING">PAINTING</option>
                                <option value="COST ACCOUNTANCY">COST ACCOUNTANCY</option>
                                <option value= 'AUTOMOTIVE'>AUTOMOVTIVE</option>
                                <option value="NUTRITION & DIETETICS">NUTRITION & DIETETICS</option>
                                <option value="WEB APPLICATION">WEB APPLICATION</option>
                                <option value="ARTIFICIAL INTELLIGENCE">ARTIFICIAL INTELLIGENCE</option>
                            </select>
                        </div>
                        <div class="form-group col-sm-2">
                            <label style="font-weight: 600">Subject 6</label>
                            <select class="form-control" name="sub6" id="sub6">
                                <option value="">Select</option>
                                <option value="ENGLISH">ENGLISH</option>
                                <option value="HINDI">HINDI</option>
                                <option value="MATHS">MATHS</option>
                                <option value="SCIENCE">SCIENCE</option>
                                <option value="S.ST.">S.ST.</option>
                                <option value="SANSKRIT">SANSKRIT</option>
                                <option value="PHYSICS">PHYSICS</option>
                                <option value="CHEMISTRY">CHEMISTRY</option>
                                <option value="BIOLOGY">BIOLOGY</option>
                                <option value="COMPUTER">COMPUTER</option>
                                <option value="INF.PRAC.">INF.PRAC.</option>
                                <option value="INF.TECH.">INF.TECH</option>
                                <option value="PHYSICAL EDU">PHYSICAL EDU</option>
                                <option value="ECONOMICS">ECONOMICS</option>
                                <option value="B.ST">B.ST</option>
                                <option value="ACCOUNTANCY">ACCOUNTANCY</option>
                                <option value="DRAWING">DRAWING</option>
                                <option value="G.K">G.K</option>
                                <option value="HISTORY">HISTORY</option>
                                <option value="POL SCIENCE">POL SCIENCE</option>
                                <option value="GEOGRAPHY">GEOGRAPHY</option>
                                <option value="PAINTING">PAINTING</option>
                                <option value="COST ACCOUNTANCY">COST ACCOUNTANCY</option>
                                <option value= 'AUTOMOTIVE'>AUTOMOVTIVE</option>
                                <option value="NUTRITION & DIETETICS">NUTRITION & DIETETICS</option>
                                <option value="WEB APPLICATION">WEB APPLICATION</option>
                                <option value="ARTIFICIAL INTELLIGENCE">ARTIFICIAL INTELLIGENCE</option>
                            </select>
                        </div>
                    </div>
                    </fieldset>
                    </div>
                </div>

            <!--     <div class="row" style="padding-top:2%">
                    <div class="col-sm-12" id="fee_collect_div">
                        <div class="panel  panel-success">
                            <div class="panel-heading" style="padding: 5px 15px;"><i class="glyphicon glyphicon-th-list"></i><b> <span style="color:black">Student Information</span></b></div>
                            <div class="panel-body" style="padding:0px"></div>
                        </div>
                        <div class="panel  panel-info">
                            <div class="panel-heading" style="padding: 5px 15px;"><i class="glyphicon glyphicon-folder-open">  </i> <b> <span style="color:black"> Fees Collection</span></b></div>
                            <div class="panel-body" style="padding:0px;"></div>
                        </div>
                    </div>
                </div>    -->
                
                 <div class="row" style="padding-top:2%">
                    <div class="col-lg-12" style="text-align:center"> 
                        <a href ="<?php echo base_url('admission/TcStudent'); ?>" type="button" class="btn btn-primary" style="width: 120px;font-family: sans-serif;float:left" id="back" ><i class="fa fa-arrow-left"> </i> Back</a>
                        <input type="button" class="btn btn-success" style="width: 120px;font-family: sans-serif;" name="savetc" id="save_tc_student" value="SAVE">
                    </div>
                </div>
                
            </div>
        </form>
    </div>

</div>
<div class="modal fade" id="feedueModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Fee Status</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
                    <div class="box " style="border: 1px solid lightgrey;">
                        <div class="box-header" style="background: aliceblue;padding:5px">
                            <h4 class="box-title" >Monthly Fees</h4>
                        </div>
                        <div class="box-body">
                            <div class='row'>
                                <div class="col-lg-12 tab-content">
                                    <div id="month">
                                        <form name="frmfee" id="frmfee" role="form" method="POST">
                                            <input type="hidden" value="" id="month_val" name="month_val">

                                            <div class="col-lg-12">
                                                <table id="studentlist" class="table table-bordered table-striped">

                                                    <thead>
                                                        <tr>
                                                            <th class='col-lg-6'>Fee Description</th>
                                                            <th class='col-lg-6'>Fee Amount</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                        <?php
                                                        $total_monthly_amount = 0;
                                                        foreach ($fees1 as $mon_fee) {
                                                            $total_monthly_amount = $total_monthly_amount + $mon_fee->fee_amount;
                                                            ?>
                                                            <tr id="row<?php echo $mon_fee->fee_id ?>">
                                                                <td><?php echo $mon_fee->fee_desc; ?></td>
                                                                <td><?php echo $mon_fee->fee_amount; ?></td>

                                                            </tr>
                                                            <?php
                                                        }
                                                        if ($transport_fee_amt != 0) {
                                                            $total_monthly_amount = $total_monthly_amount + $transport_fee_amt;
                                                            ?>
                                                            <tr>                 
                                                                <td>Transport Fee</td>
                                                                <td><input type="text" readonly="true" style="border: 0px;width:65px;background:inherit" name="trans_fee_amt" value="<?php echo $transport_fee_amt; ?>"></td>              
                                                            </tr>
                                                        <?php } ?>
                                                        <tr>
                                                            <th>Total Amount</th>
                                                            <th id="amountpaidquarterly"><?php echo $total_monthly_amount; ?></th>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>


                                        </form>
                                    </div>
                                </div>
                            </div> 
                            <div class="row">
                                <div class="col-lg-12" id="">
                                    <fieldset>
                                        <legend>Months Status</legend>
                                        <?php for ($pm = 1; $pm <= 12; $pm++) { ?> 
                                            <div class="btn col-sm-2 col-md-2 col-xs-3" style="padding: 6px 6px;width:42px ;font-weight: bold;<?php
                                            if($pm<$start_fee_month){
                                                echo 'border:1px solid black;';
                                            }else if ($pm>=$start_fee_month && $pm <= $paid_month) {
                                                echo 'background-color:#85e085;color: green;';
                                            }elseif ($pm>$paid_month && $pm<=$paid_month+$chqpaid_month) {
            
                                                echo 'background-color:#fbd222;color: black;';
                                            }  else {
                                                echo 'background-color:#ff6161;color: white;';
                                            }
                                            ?>;margin: 1px"><?php echo $month[$pm]; ?></div>
                                             <?php } ?>
                                    </fieldset>

                                </div>
                            </div>
                        </div>         
                    </div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
<script src="<?php echo base_url("assets/AdminLTE/plugins/bootstrap-fileinput/bootstrap-fileinput.js"); ?>" type="text/javascript"></script>
<script>
    var globalid = '';
    var save_method = '<?php // echo $task; ?>';

    $('#back1').click(function () {
//        window.location.href = "<?php // echo base_url('admission/TcStudent/TcStudentPage'); ?>";
    });
    
        
$('#save_tc_student').click(function ()
    {
            var r = confirm("Are you sure you want to Generate TC?");
            if(r==true){

                 $.ajax
                    ({
                        url: "<?php echo base_url('admission/Tcstudent_main/saveTcStudent') ?>",
                        type: "POST",
                        data: $('#studentdetails').serialize(),
                        dataType: "json",
                        success: function (data) {
                            window.location.href = "<?php echo base_url('admission/TcStudent') ?>";

                        },
                        error: function (errdata) {
                        }
                    });
           
                    }
                    else
            {
                return false;
            }
    });
    
    $('#inactive_type').change(function () {
        if (this.value == 'TC') {
            $('#tc_data_all').css('display', 'block');
        }
        else if (this.value == 'PASSOUT') {
            $('#tc_data_all').css('display', 'block');
        }
        else
        {
            $('#tc_data_all').css('display', 'none');
        }
    });
</script>

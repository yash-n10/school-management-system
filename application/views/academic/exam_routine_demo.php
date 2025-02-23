<!DOCTYPE html>
<html>
<head>
    <title></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        .table {
            width: 100%;
            max-width: 100%;
            margin-bottom: 0px; 
        }
        tr 
        {
            line-height: 15px;
            min-height: 15px;
            height: 15px;
        }
        .table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>td, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>thead>tr>th 
        {
            border: 1px solid black;
        }
        .p-5
        {
            height: 130px;
            width:100%; 
        }
        .earning
        {
            width:100%; 
        }
        .col-xs-12
        {
            width: 100%;
        }
        .col-md-6
        {
            width: 50%;
        }
        .col-md-8
        {
            width: 60%;
        }
        .col-md-4
        {
            width: 40%;
        }
        .earning .col-md-6
        {
            height: 250px;
        }

    
    </style>
</head>
<body>
    <div class="">
        <div class="row p-5" style="background-color:#2780E3;">
            <div class="" style="width: 100%;position: absolute;">
                <p class="font-weight-bold mb-1"><h3><?php echo $school_data[0]->description;?></h3></p>
                <p class="font-weight-bold" style="margin: 0 0 1px;"><?php echo $school_data[0]->address;?></p>
                <p class="font-weight-bold" style="margin: 0 0 1px;"><?php echo $school_data[0]->vision;?></p>
                <p class="font-weight-bold" style="margin: 0 0 1px;"><span>Contact No - </span><?php echo $school_data[0]->phone;?></p>
                <p class="font-weight-bold" style="margin: 0 0 1px;"><span>Email Id - </span><?php echo $school_data[0]->email;?></p><!-- 
                <p class="font-weight-bold">Jharkhand,831015</p> -->
            </div>
            <?php  $school_id=$school_data[0]->id; ?>
            <div class="" style="text-align: right;background-color:#2780E3;">
                <img src="assets/img/<?php echo $school_id.'.JPG';?>" style="height:100px">
                
            </div>
        </div>
    </div>
    <strong><p class="font-weight-bold" style="padding: 19px;text-align:center;text-transform: uppercase;">EXAMINATION :<u><?php echo $exam_details[0]->name; ?></u></p></strong>
    
    	<?php  $classid=$examhead[0]->class_id; 
    		 $secid=$examhead[0]->section_id; 
    	?>
    	<p>Class : <?php echo $this->dbconnection->Get_namme('class', 'id', $classid,"class_name") ?> Section :<?php echo $this->dbconnection->Get_namme('section', 'id', $secid,"sec_name") ?></p>
<div class="panel-body table-responsive" style="width:100%">
    <table class="table table-bordered " style="width:100%" id="examtbl">
        <thead>
            <tr>

                <th style="width:14%" align="left">Date</th>
                <th style="width:14%" align="left">Subject</th>
                <th style="width:14%" align="left">Start Time</th>
                <th style="width:14%" align="left">End Time</th>
            </tr>
        </thead>
        <tbody id="tbody_data">
            <?php foreach ($examdet as $ed) { ?>
            <tr>
                <?php  $sub_id=$ed->subject_id; ?>
                <td><?php echo $ed->date; ?></td>
                <td><?php echo $this->dbconnection->Get_namme('subject', 'id', $sub_id,"name") ?></td>
                <td><?php echo $ed->start_timing; ?></td>
                <td><?php echo $ed->end_timing; ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
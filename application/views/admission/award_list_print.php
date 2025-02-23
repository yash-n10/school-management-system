<!DOCTYPE html>
<html>
<head>
<title>Award List</title>
<style>
	table{
		border: 1px solid black ;
		text-align: center;
	}
	table tr{
		border: 1px solid black;
		text-align: center;
	}
	table tr th{
		border: 1px solid black;
		text-align: center;
	}
	table tr td{
		border: 1px solid black;
		text-align: center;
	}
</style>
</head>
<body>
	<?php foreach ($data as $value) {
		
	} ?>
	<div class="row" style="">
            
            <table style="width:100%;border:0px !important">
                <tbody>
                    <tr style="border:0px !important">
                        <th align="left" width="20%" style="border:0px !important"><img src="<?php echo $_SERVER['DOCUMENT_ROOT'];?>/<?php echo $logo;?>" height="95px;"></th>
                        <th align="center" width="70%" style="border:0px !important"><h2 style="text-transform: uppercase;"><b><?php echo $school_desc[0]->description; ?></b></h2><
                            <h3><b> <?php echo $school_desc[0]->address; ?></b>     </h3>  
                                        <br>
                                    <span>MAIL : <?php echo $school_desc[0]->email; ?> &nbsp;&nbsp;&nbsp; | &nbsp;&nbsp;&nbsp; TEL : <?php echo $school_desc[0]->phone; ?>
                                    </span>
                        </th><br>                                
                        <th align="right" width="10%" style="border:0px !important"></th>
                    </tr>
                </tbody>
            </table>
            <hr>
        </div>
        <table style="width:100%;border: 0px !important">
			<tr style="border: 0px !important;font-weight: bold;"><td colspan="5">Award List of Student of Class:<?php echo $value->class_name.'-'.$value->section_name;?></td></tr>
			
        </table><br>
<table style="width:100%">
	<thead>
		<tr>
			<th>Sl.No.</th>
			<th>Adm. No.</th>
			<th>Student Name</th>
			<th>Roll No.</th>
			<th>Remarks</th>
		</tr>
	</thead>
	<tbody>
		<?php $i=1;foreach($data as $stu) { ?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $stu->admission_no; ?></td>
			<td><?php echo $stu->first_name.' '.$stu->middle_name.' '.$stu->last_name; ?></td>
			<td><?php echo $stu->roll; ?></td>
			<td></td>
		</tr>
	<?php $i++;} ?>
	</tbody>
</table>
 <?php 
          if(function_exists('date_default_timezone_set')) {
            date_default_timezone_set("Asia/Kolkata");
          }

            $date = date("d/m/Y");
            $date1 =  date("H:i a");?>
          <p style="font-size: 10px;">Printed on Date : <?php echo $date; ?> at <?php echo $date1; ?></p>
</body>
</html>
<script type="text/php">
    if ( isset($pdf) ) {
        $text = 'Page: {PAGE_NUM} of {PAGE_COUNT}';
        $font = Font_Metrics::get_font("Times New Roman", "regular");

        $pdf->page_text(200, 30, $text, $font, 12);
    }
</script>
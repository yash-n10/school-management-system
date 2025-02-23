<form method="post" action="<?php echo base_url();?>store/Billapprove/update">
Bill Id:<input type="number" name="bill_id" id="bill_id" value="<?php echo $bill_id;?>" readonly>
<br><br>
Admission No:<input type="number" name="adm_no" id="adm_no" value="<?php echo $admission_no;?>" readonly>
<br><br>
Bill Date:<input type="text" name="date" id="date" value="<?php echo $bill_date;?>" readonly>
<br><br>
Bill Amount:<input type="number" name="amount" value="<?php echo $bill_amt;?>" readonly>
<br><br>APPROVER 1:<br><br>
Date Approved <input type="date" name="date1" id="date1" value="<?php echo $date_approved1;?>">
<br>Approved By <input type="text" name="approver1" id="approver1" value="<?php echo $approved1_by;?>">
<br><br>Comment <input type="text" name="comment1" id="comment1" value="<?php echo $approve1_comment;?>">
<br><br>APPROVER 2:<br><br>
Date Approved <input type="date" name="date2" id="date2" value="<?php echo $approved2_by;?>">
<br><br>Approved By <input type="text" name="approver2" id="approver2" value="<?php echo $date_approved2;?>">
<br><br>Comment <input type="text" name="comment2" id="comment2" value="<?php echo $approve2_comment;?>">
<br><br>APPROVER 3:<br><br>
Date Approved <input type="date" name="date3" id="date3" value="<?php echo $date_approved3;?>">
<br><br>Approved By <input type="text" name="approver3" id="approver3" value="<?php echo $approved3_by;?>">
<br><br>Comment <input type="text" name="comment3" id="comment3" value="<?php echo $approve3_comment;?>">
<br><br>Final Status<input type="text" name="final_status" id="final_status" value="<?php echo $final_status;?>">
<br><br>Final Comment<input type="text" name="final_comment" id="final_comment" value="<?php echo $final_comment;?>">
<input type="submit" name="submit">
</form>
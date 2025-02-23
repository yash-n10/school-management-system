<?php
//echo $current_staff_id;
$staff_info	=	$this->crud_model->get_staff_info($current_staff_id);
foreach($staff_info as $row):?>

	<div style="background-color: #2A3542;text-align: left;color: #fff;font-size: 21px;font-weight: 100;padding-left:20px;margin-top:60px;">
    	<img src="<?php echo base_url();?>uploads/logo.png"  
        	style="max-height:60px; max-width:100px; vertical-align:text-bottom;"/>
				<?php echo $system_name;?>
    </div>
<style>
.idcard_text
{
	padding: 6px;
	font-weight: 100;
	font-size: 13px;
}
</style>
	<table width="100%" border="0" style="background-color:#fff; font-size:13px;">
      <tr>
        <td rowspan="5" width="170" valign="top">
        	<img src="<?php echo $this->crud_model->get_image_url('staff' , $row['staff_id']);?>" 
                 style="max-height:130px;max-width:130px;border-radius: 10%;margin:20px;" />
        </td>
        <td class="idcard_text" width="100" style="padding-top:16px;"><?php echo get_phrase('name');?></td>
        <td class="idcard_text" style="padding-top:16px;"><?php echo $row['name'];?></td>
      </tr>
      <tr>
        <td class="idcard_text"><?php echo get_phrase('department');?></td>
        <td class="idcard_text"><?php echo $this->crud_model->get_dept_name($row['employee_department_id']);?></td>
      </tr>
      <tr>
        <td class="idcard_text"><?php echo get_phrase('employee_code');?></td>
        <td class="idcard_text"><?php echo $row['employee_code'];?></td>
      </tr>
      <tr>
        <td class="idcard_text"><?php echo get_phrase('birthday');?></td>
        <td class="idcard_text"><?php echo $row['birthday'];?></td>
      </tr>
      <tr>
        <td class="idcard_text"><?php echo get_phrase('gender');?></td>
        <td class="idcard_text"><?php echo $row['sex'];?></td>
      </tr>
      <tr>
        <td colspan="3" style="background-color:#D9E6E9;font-size:10px; text-align:right;padding:8px;">&copy; 2013</td>
      </tr>
    </table>

<?php endforeach;?>
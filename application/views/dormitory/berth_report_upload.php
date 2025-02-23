<?php // echo $count;?>
        <table id="berth_list" class="table table-bordered table-striped">
            <thead style="background: beige">
                <tr> 

                    <th style="border-bottom:1px solid black;"> Id </th>
                    <th style="border-bottom:1px solid black;"> Dormitory No </th>
                    <th style="border-bottom:1px solid black;"> Dormitory Name </th>
                    
                    <th style="border-bottom:1px solid black;">Room No</th>
                    <th style="border-bottom:1px solid black;">Berth No</th>
                    <th style="border-bottom:1px solid black;">Status</th>
                </tr> 
         
             </thead>
             <tbody id="berth_wise_report"> 
               <?php for($j=0; $j<$count; $j++){?>
                 <tr>
                     <td><?php echo $id[$j];?></td> 
                     <td><?php echo $dorm_num[$j];?></td>
                     <td><?php echo $dorm_name[$j];?></td>
                     <td><?php echo $room_no[$j];?></td>
                     <td><?php echo $berth_no[$j];?></td>

                     
                     <td>
                        <span style='margin-right:10px;'> <input type='radio' id='full' name='status[<?php echo $id[$j];?>]'  value='' <?php if($berth_no[$j]!=0) { echo 'checked=checked';} ?>>Occupied </span>
                        <span style='margin-right:10px;'> <input type='radio' id='empty' name='status[<?php echo $id[$j];?>]' value='' <?php if($berth_no[$j]==0) { echo 'checked=checked';} ?>> Vacant</span>
                     </td>
                 </tr>
               <?php } ?>
             </tbody>
        </table>
        
<script>
 $('#berth_list').DataTable({
             "paging": true,
             "lengthChange": true,
             "searching": true,
             "ordering": true,
             "info": true,
             "autoWidth": true
           });
    </script>
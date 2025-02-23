
<table id="dorm_list" class="table table-bordered table-striped">
            <thead style="background: beige">
                <tr> 

                    <th style="border-bottom:1px solid black;"> Id </th>
                    <th style="border-bottom:1px solid black;"> Dormitory No </th>
                    <th style="border-bottom:1px solid black;"> Dormitory Name </th>
                    <th style="border-bottom:1px solid black;"> No of Rooms </th>
                    <th style="border-bottom:1px solid black;"> Total Allocated</th>
                    <th style="border-bottom:1px solid black;"> Total Available</th>
                    <th style="border-bottom:1px solid black;">Status</th>
                </tr>  
             </thead>
             <tbody id="dorm_wise_report">
               <?php for($j=0; $j<$count; $j++) { ?>
                 <tr>
                     <td><?php echo $dorm_id[$j] ?></td>
                     <td><?php echo $dorm_num[$j]?></td>
                     <td><?php echo $dorm_name[$j]?></td>
                     <td><?php echo $room_num[$j]?></td>
                     <td><?php echo $allocated[$j]?></td>
                     <td><?php echo $vacant[$j]?></td>
                     <td>
                         <?php // echo $vacant[$j].' '.$allocated[$j].'<br>';?>
                        <span style='margin-right:10px;'> <input type='radio' id='full' name='status[<?php echo $dorm_id[$j]; ?>]'  value='' <?php if($vacant[$j]==0) { echo 'checked=checked';} ?>>Occupied </span>
                        <span style='margin-right:10px;'> <input type='radio' id='half' name='status[<?php echo $dorm_id[$j]; ?>]'  value='' <?php if($vacant[$j]!=0 && $allocated[$j]!=0) { echo 'checked=checked';} ?>> Partially Occupied</span>
                        <span style='margin-right:10px;'> <input type='radio' id='empty' name='status[<?php echo $dorm_id[$j]; ?>]' value='' <?php if($allocated[$j]==0) { echo 'checked=checked';} ?>> Vacant</span>
                     </td>
                 </tr>
                  <?php } ?>
             </tbody>
        </table>
        
<script>
 $('#dorm_list').DataTable({
             "paging": true,
             "lengthChange": true,
             "searching": true,
             "ordering": true,
             "info": true,
             "autoWidth": true
           });
    </script>
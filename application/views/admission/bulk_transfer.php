<style>
/*    td.highlight {
    background-color: lightskyblue !important;
} */
tr.highlight {
    background-color: antiquewhite !important;
}    
</style>
<div class="overlay" id="preloader" style="display:none;">
                            <i class="fa fa-refresh fa-spin" style="top: 23%;color:#f39c12"></i>
                        </div>
<div class="col-md-12">
        
 
               
           <table id="student_promote" class="table table-bordered table-striped header-fixed"  style="margin-top: 25px; width:100%;">
               <thead style="background: #99ceff">
                   <tr>
                       <th style="border-bottom:0px"> <input type="checkbox" id="chk_all"> Check All</th>
                       <th style="border-bottom:0px">Admission No</th>
                       <th style="border-bottom:0px"> Student Name </th>
                       <th style="border-bottom:0px"> Section </th>
                       <th style="border-bottom:0px"> Course( If Any) </th>
                   </tr>
               </thead>
               <thead style="background: #cce6ff">
                    <tr id="searchhead">
                        <th style="border-top:0px">  </th>
                        <th style="border-top:0px"></th>
                        <th style="border-top:0px"></th>
                        <th style="border-top:0px"></th>
                        <th style="border-top:0px"></th>
                    </tr>
                </thead>
               <tbody style="height:200px; width:60%">
                   <?php foreach($fetch_qry as $stud) { ?>
                   <tr> 
                       <td><input type="checkbox" value="<?php echo $stud->id?>" id="<?php echo $stud->id?>" name="chk_row[]" class="chkbox"></td>
                       <td><?php echo $stud->admission_no;?> </td>
                       <td><?php echo $stud->name;?> </td>
                       <td>
                           <select name="section[<?php echo $stud->id?>]" id="section_<?php echo $stud->id?>" class="form-control" style="width:50%">
                            <option value="0">Select Section</option>
                            <?php foreach ($asec as $sec) { ?>
                                <option value="<?php echo $sec->id; ?>" <?php if($stud->section_id==$sec->id){ echo 'selected=selected';}?>> <?php echo $sec->sec_name; ?></option>
                            <?php } ?>
                            </select>
                       </td>
                       <td>
                           <select name="course[<?php echo $stud->id?>]" id="course_<?php echo $stud->id?>" class="form-control" style="width:50%;padding-right: 2px;">
                            <option value="0">Select Course(If Any)</option>
                            <?php foreach ($acourse as $c) { ?>
                                <option value="<?php echo $c->id; ?>" <?php if($stud->course_id==$c->id){ echo 'selected=selected';}?>> <?php echo $c->course_code; ?></option>
                            <?php } ?>
                            </select>
                       </td>
                   </tr>
                   <?php }?>
               </tbody>
            </table>
         
</div>



<script>
$('#chk_all').on('click',function()
{
   if(this.checked==true)
       $('#student_promote').find('input[name="chk_row[]"]').prop('checked',true);
//       $('.chkbox').prop('checked',true);
   else
       $('#student_promote').find('input[name="chk_row[]"]').prop('checked',false);
//    $('.chkbox').prop('checked',false);
}) ; 
 var table =$('#student_promote').DataTable( {
//                                
                                "scrollY": "300px",
                                "scrollX": true,
                                "scrollCollapse": true,
                                "paging":         false,
                                "autoWidth": true,
                                dom: 'Bfrtip',
                 buttons: [
                                {
                                    extend: 'collection',
                                    text: 'Export',
                                    buttons: [
                                        
                                        'excel'

                                    ]
                                }
                            ]

} );
$('#student_promote tbody')
        .on( 'click', 'td', function () {
            var colIdx = table.cell(this).index().row;
//            alert(colIdx);
            $('.highlight').removeClass( 'highlight' );
            $( table.row( colIdx ).nodes() ).addClass( 'highlight' );
        } );

</script>
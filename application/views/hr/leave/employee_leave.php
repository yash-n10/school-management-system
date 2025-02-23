
<style>
/*    td.highlight {
    background-color: lightskyblue !important;
} */
tr.highlight {
    background-color: antiquewhite !important;
}    
</style>
<div class="box">
    <div class="box-body">


            <form id='frmleave' role="form" method="POST">
               
                    <div class="table-responsive">
                    <table id="empleave_list" class="table table-bordered table-striped">
                        <thead style="">
                            <tr>
                                <th rowspan="3">Employee Code</th>
                                <th rowspan="3">Employee Name</th>
                                <th rowspan="3">Designation</th>
                                <th rowspan="3">Leave Group</th>
                                <th colspan="<?php echo 3*count($leave_type);?>">Leave Types</th>
                            </tr>
                            <tr>
                                 <?php foreach($leave_type as $rl){?>
                                    <th colspan="3"><?php echo $rl->leave_type_code;?></th>
                                <?php }?>
                                   
                            </tr>
                            <tr>
                                <?php for($i=1;$i<=count($leave_type);$i++){?>
                                    <th style="color:darkorange;">OPENING</th>
                                    <th style="color:darkgreen;">AVAIL </th>
                                    <th style="color:red;">BALANCE</th> 
                                <?php }?>
                            </tr>
                        </thead>
                        <tbody>
                             <?php foreach($employee as $e){?>
                            <tr>
                                <td><?php echo $e->employee_code;?></td>
                                <td><?php echo $e->name;?></td>
                                <td><?php echo $e->desg;?></td>
                                <td><?php echo $e->leave_grp_name;?></td>
                          
                                <?php foreach($leave_type as $ltyp){?>
                                    <td style="color:darkorange;font-weight:bold;font-size: medium;"><?php echo $opening[$e->id][$ltyp->id];?></td>
                                    <td style="color:darkgreen;font-weight:bold;font-size: medium;"><?php echo $avail[$e->id][$ltyp->id];?></td>
                                    <td style="color:red;font-weight:bold;font-size: medium;"><?php echo $bal[$e->id][$ltyp->id];?></td>
                                <?php }?>
                            </tr>
                             <?php }?>
                        </tbody>
                        <tfoot>
                        </tfoot>
                    </table>
                  
                </div>
                  

            </form>
        </div>
</div>
<script>
    $(document).ready(function() {
         var selected = [];
        var table =$('#empleave_list').DataTable( {
            "scrollX": true,
            "scrollY": "300px",
            "scrollCollapse": true,
            "paging":         false,
            
        } );
        $('#empleave_list tbody')
        .on( 'click', 'td', function () {
            var colIdx = table.cell(this).index().row;
//            alert(colIdx);
            $('.highlight').removeClass( 'highlight' );
            $( table.row( colIdx ).nodes() ).addClass( 'highlight' );
        } );
        
        
//         var table = $('#example').DataTable();
//     
//            $('#example tbody')
//        .on( 'mouseenter', 'td', function () {
//            var colIdx = table.cell(this).index().column;
// 
//            $( table.cells().nodes() ).removeClass( 'highlight' );
//            $( table.column( colIdx ).nodes() ).addClass( 'highlight' );
//        } );
        
        
//        $('#empleave_list tbody').on('click', 'tr', function () {
//        var id = this.id;
//        var index = $.inArray(id, selected);
// 
//        if ( index === -1 ) {
//            selected.push( id );
//        } else {
//            selected.splice( index, 1 );
//        }
// 
//            $(this).toggleClass('selected');
//    } );
} );
    </script>
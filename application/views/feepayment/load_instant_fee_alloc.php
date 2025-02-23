<style>
    /*    td.highlight {
    background-color: lightskyblue !important;
    } */
    tr.highlight {
        background-color: antiquewhite !important;
    }    
</style>


<div class="col-sm-12">
    <div class="overlay" id="preloader" style="display:none;">
        <i class="fa fa-refresh fa-spin" style="top: 23%;color:#f39c12"></i>
    </div>
    <table name="allocate_stud_tbl" id="allocate_stud_tbl" class="table table-responsive" style=" width:100%;">
        <thead>
            <tr>
                <th><input type="checkbox" name="chk_all" id="chk_all" checked></th>
                <th>Admission No</th>
                <th>Student's Name</th>
                <th>Class - Sec</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($fetch_qry as $stud) { ?>
                <tr>
                    <td><input type="checkbox" value="<?php echo $stud->id ?>" id="<?php echo $stud->id ?>" name="chk_row[]" class="chkbox" checked ></td>
                    <td><?php echo $stud->admission_no; ?></td>
                    <td><?php echo $stud->name; ?></td>
                    <td></td>
                    <td><input type="number" name="instant_amt[<?php echo $stud->id ?>]" class="form-control" value="<?php echo $common_amt?>" required=""></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<script>
    $('#chk_all').on('click', function ()
    {
            $('#allocate_stud_tbl').find('input[name="chk_row[]"]').prop('checked', this.checked);

    });
    $('input[name="chk_row[]"]').on('click',function() {
        
            $('#chk_all').prop('checked', $('input[name="chk_row[]"]').not(':checked').length==0);
        
    });
    
    var table = $('#allocate_stud_tbl').DataTable({
//                                
        "scrollY": "300px",
        "scrollX": true,
        "scrollCollapse": true,
        "paging": false,
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

    });
    $('#allocate_stud_tbl tbody')
            .on('click', 'td', function () {
                var colIdx = table.cell(this).index().row;
//            alert(colIdx);
                $('.highlight').removeClass('highlight');
                $(table.row(colIdx).nodes()).addClass('highlight');
            });

</script>




<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>template/css/dataTables.tableTools.css">

<?php //print_r($rdata); ?>
<table id="route_dtable" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>S.No</th>
                <th>Student Name</th>
                <th>Blood Group</th>
                <th>Parent Name</th>
                <th>Parent Phone No</th>
                <th>Pickup Point</th>
                <th>Landmark / Time</th>
            </tr>
        </thead>
 
        
 
        <tbody>
        	<?php $sn=1; foreach($rdata as $rdata_view) { ?>
            <tr>
                <td><?php echo $sn; ?></td>
                <td><?php echo $rdata_view->name ?></td>
                <td><?php echo $rdata_view->blood_group ?></td>
                <td><?php echo $rdata_view->father_name ?></td>
                <td><?php echo $rdata_view->parent_phone1 ?></td>
                <td><?php echo $rdata_view->ppoint ?></td>
                <td><?php echo $rdata_view->plmark.' / '.$rdata_view->ptime ?></td>
            </tr>
            
            <?php $sn++; } ?>
            
        </tbody>
    </table>
    
<script src="<?php echo base_url(); ?>template/js/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>template/js/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>template/js/dataTables.tableTools.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>template/js/dataTables.bootstrap.js"></script>
<script>var $j = jQuery.noConflict(true);</script>
<script>
$(document).ready(function() {
    $j('#route_dtable').DataTable( {
		dom: 'T<"clear">lfrtip',
		 tableTools: {
            "sSwfPath": "<?php echo base_url(); ?>template/swf/copy_csv_xls_pdf.swf",
			"aButtons": [
            {
                "sExtends": "copy",
                "mColumns": [0, 1, 2, 3, 4, 5, 6]
            },
            {
                "sExtends": "csv",
                 "mColumns": [0, 1, 2, 3, 4, 5, 6]
            },
            {
                "sExtends": "pdf",
                 "mColumns": [0, 1, 2, 3, 4, 5, 6]
            },
            {
                "sExtends": "print",
                 "mColumns": [0, 1, 2, 3, 4, 5, 6]
            },
        ]
        }
	});
});
</script>
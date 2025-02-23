<div class="form-group has-feedback">
    <div class="box">
        <div class="box-header"><h4> My Group's Leaves</h4></div>
        <div class="box-body">
            <?php if(count($query_grp)==0) {?>
            <label class="form-control-label" style="color:red"> No Group Assigned !</label>
            <?php } else {?>
            <table class="table table-bordered table-striped" id="toapply_leave_details_tbl">
                <thead>
<!--                    <tr>
                        <td colspan="4" style="text-align:center;font-size: 18px;border-bottom:1px solid grey">Leave Details</td>
                    </tr>-->
                    <tr>
                        <th>Leave Type</th>
                        <th>Total Allowed</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($query_grp as $row) {?>
                    <tr>
                        <td><?php echo $row->leave_type_name;?></td>
                        <td><?php echo $row->total_allowed;?></td>
                        
                    </tr>
                    <?php }?>
                </tbody>
            </table>
            <?php }?>
        </div>
    </div>
    <div class="box">
        <div class="box-header"><h4> My Leaves</h4></div>
        <div class="box-body">
            <?php if(count($query)==0) {?>
            <label class="form-control-label" style="color:red"> No Leaves Assigned !</label>
            <?php } else {?>
            <table class="table table-bordered table-striped" id="toapply_leave_details_tbl">
                <thead>
<!--                    <tr>
                        <td colspan="4" style="text-align:center;font-size: 18px;border-bottom:1px solid grey">Leave Details</td>
                    </tr>-->
                    <tr>
                        <th>Leave Type</th>
                        <th>Opening Leave</th>
                        <th>Taken Leave</th>
                        <th>Available Leave</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($query as $row) {?>
                    <tr>
                        <td><?php echo $row->leave_type_name;?></td>
                        <td><?php echo $row->opening_leave;?></td>
                        <td><?php echo $row->taken_leave;?></td>
                        <td><?php echo $row->balance_leave;?></td>
                    </tr>
                    <?php }?>
                </tbody>
            </table>
            <?php }?>
        </div>
    </div>
    
</div>
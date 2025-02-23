<div class="form-group">
	<div class="box">
    	<div class="panel">
            <div class="panel-body">
                <div class="row">
					<form class="form-inline" action="">
						<div class="col-md-1">
							<label for="year">Year:</label>
						</div>
						<div class="col-md-2">
                            <select id="year" name="year" class="form-control" required>                            	
                                <option value="all">Select</option>
                                <option value="2019">2019</option>
                                <option value="2020">2020</option>
                            </select>
						</div>
						<div class="col-md-1">
							<label for="month">Month:</label>
						</div>
						
						<div class="col-md-2">
                            <select id="month" name="month" class="form-control" required>
                                <option value="all">Select Month</option>  
                                <option value="04">April</option>
                                <option value="05">May</option>
                                <option value="06">June</option>
                                <option value="07">July</option>
                                <option value="08">August</option>
                                <option value="09">September</option>
                                <option value="10">October</option>
                                <option value="11">November</option>
                                <option value="12">December</option>
                                <option value="01">January</option>
                                <option value="02">February</option>
                                <option value="03">March</option>
						  	</select>
						</div>
						<div class="col-md-1">
							<label for="email">Category:</label>
						</div>
						
						<div class="col-md-2">
                            <select id="category" name="category" class="form-control" required>
                                <option value="all">Select Category</option>  
                                <?php foreach($category as $cat_val){?>
                                <option value="<?php echo $cat_val->id;?>"><?php echo $cat_val->category_desc;?></option>
                            	<?php }?>
						  	</select>
						</div>
						<a class="btn btn-primary" onclick="submit()">Submit</a>
					</form> 
    			</div>
    		</div>
    	</div>
    </div>
    <div id="tab">
    </div>
          			
					
</div>

<script type="text/javascript">
	function submit()
	{
		var month = $('#month').val();
		var year = $('#year').val();
		var category = $('#category').val();
		
		$.ajax({
	        url : "<?php echo base_url('hr/payroll/salary_create/get') ?>",
	        type: "POST",
	        data: {month:month,year:year,category:category},
	        success: function (data)
	        {
	           console.log(data);	 
	           $('#tab').html(data);          
	        },
	    });  
	}
</script>
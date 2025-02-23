<div class="form-group has-feedback">
	<div class="box box-primary">
		<div class="box-body">    
			
		  	<div class="row top">
				<div class="col-md-12">
					<div class="col-md-4">
						<h5>REPORT TYPE:</h5>
						<div class="lists" style="height: 180px;border: 1px solid #ccc;overflow: scroll;">
							<ul>
								<li><a style="cursor: pointer;" onclick="reports('AR')">BY ALMIRAH & RACK</a></li>
								<li><a style="cursor: pointer;" onclick="reports('CA')">BY CATEGORY</a></li>
								<li><a style="cursor: pointer;" onclick="reports('PU')">BY PUBLISHER</a></li>
								<li><a style="cursor: pointer;" onclick="reports('VE')">BY VENDOR</a></li>
								<li><a style="cursor: pointer;" onclick="reports('AU')">BY AUTHOR</a></li>
								<li><a style="cursor: pointer;" onclick="reports('AN')">BY ACCESSION NO.</a></li>
								<li><a style="cursor: pointer;" onclick="reports('BN')">BY BOOK NAME</a></li>	
							</ul>	
						</div>
					</div>
					<div class="col-md-8">
						<div class="datass" id="right_data" style="border: 1px solid #ccc;height: 216px;">
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div><div class="box box-primary">
		<div class="box-body">    
			<div class="row top">
				<div class="col-md-12">
					<div class="result" id="result" style="height: 400px;">
						
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<script>
	function reports(m)
	{
		$.ajax({
            url : "<?php echo base_url('library/report/reports/get_data');?>",
            type: "POST",
            data: {type:m},
            dataType: 'json',
            success: function (data)
            {
            	$('#right_data').html('');
            	$('#right_data').html(data.datas);
            },
        });
	}

	function gets()
	{
		var almirah = $('#almirah').val();
		var rack 	= $('#rack').val();
		var location 	= $('#location').val();
		$.ajax({
            url : "<?php echo base_url('library/report/reports/get_div_data');?>",
            type: "POST",
            data: {almirah:almirah,rack:rack,location:location},
            dataType: 'json',
            success: function (data)
            {
            	console.log(data);
            	$('#result').html('');
            	$('#result').html(data.datas);
            	$('#book_detail').DataTable({ 
                  "destroy": true, 
               });
            },
        });
	}

	function get_ca()
	{
		var category 	= $('#category').val();
		var location 	= $('#location').val();
		$.ajax({
            url : "<?php echo base_url('library/report/reports/get_ca_data');?>",
            type: "POST",
            data: {category:category,location:location},
            dataType: 'json',
            success: function (data)
            {
            	$('#result').html('');
            	$('#result').html(data.datas);
            	$('#book_detail').DataTable({ 
                  "destroy": true, 
               });
            },
        });
	}

	function gets_pub()
	{
		var publisher 	= $('#publisher').val();
		var location 	= $('#location').val();
		$.ajax({
            url : "<?php echo base_url('library/report/reports/get_pub_data');?>",
            type: "POST",
            data: {publisher:publisher,location:location},
            dataType: 'json',
            success: function (data)
            {
            	$('#result').html('');
            	$('#result').html(data.datas);
            	$('#book_detail').DataTable({ 
                  "destroy": true, 
               });
            },
        });
	}

	function gets_ven()
	{
		var vendor 		= $('#vendor').val();
		var location 	= $('#location').val();
		$.ajax({
            url : "<?php echo base_url('library/report/reports/get_ven_data');?>",
            type: "POST",
            data: {vendor:vendor,location:location},
            dataType: 'json',
            success: function (data)
            {
            	$('#result').html('');
            	$('#result').html(data.datas);
            	$('#book_detail').DataTable({ 
                  "destroy": true, 
               });
            },
        });
	}

	function gets_aut()
	{
		var author 		= $('#author').val();
		var location 	= $('#location').val();
		$.ajax({
            url : "<?php echo base_url('library/report/reports/get_aut_data');?>",
            type: "POST",
            data: {author:author,location:location},
            dataType: 'json',
            success: function (data)
            {
            	$('#result').html('');
            	$('#result').html(data.datas);
            	$('#book_detail').DataTable({ 
                  "destroy": true, 
               });
            },
        });
	}

	function gets_acc()
	{
		var accession 		= $('#accession').val();		
		$.ajax({
            url : "<?php echo base_url('library/report/reports/get_accession');?>",
            type: "POST",
            data: {accession:accession},
            dataType: 'json',
            success: function (data)
            {
            	console.log(data);
            	$('#result').html('');
            	$('#result').html(data.datas);
            	$('#book_detail').DataTable({ 
                  "destroy": true, 
               });
            },
        });
	}
	function gets_book()
	{
		var accession 	= $('#acc').val();		
		$.ajax({
            url : "<?php echo base_url('library/report/reports/get_accession_by_book');?>",
            type: "POST",
            data: {accession:accession},
            dataType: 'json',
            success: function (data)
            {
            	console.log(data);
            	$('#result').html('');
            	$('#result').html(data.datas);
            	$('#book_detail').DataTable({ 
                  "destroy": true, 
               });
            },
        });
	}

	function getBook(m)
	{
		var book_id = m.value;
		$.ajax({
            url : "<?php echo base_url('library/report/reports/get_accession_bybook');?>",
            type: "POST",
            data: {book_id:book_id},
            dataType: 'json',
            success: function (data)
            {
            	$('#acc').html('');         	
            	$('#acc').html(data.datas);         	
            },
        });
	}
</script>
<div class="form-group has-feedback">
  <div class="box box-primary">
  <div class="box-body">
    <div class="col-sm-2"></div>
  <div class="col-sm-8">
     <div class="box-body">
	   <form action="<?php echo base_url('library/Books/save'); ?>" method="post">
		   <table class='table'>
		     <tr>
			   <th>ISBN NO.</th>
			   <td><input type="text" name="isbn" class="form-control"></td>
			   <th>Publisher</th>
			   <td><input type="text" name="publisher" class="form-control"></td>
		     </tr>
			 
			 <tr>
			   <th>Title</th>
			   <td><input type="text" name="title" class="form-control"></td>
			   <th>Cost</th>
			   <td><input type="number" name="cost" class="form-control"></td>
		     </tr>
			 
			 <tr>
			   <th>Sub Title</th>
			   <td><input type="text" name="subtitle" class="form-control"></td>
			   <th>Binding</th>
			   <td><input type="text" name="binding" class="form-control"></td>
		     </tr>
			 
			 <tr>
			   <th>Description</th>
			   <td><input type="text" name="desc" class="form-control"></td>
			   <th>Location</th>
			   <td><input type="text" name="location" class="form-control"></td>
		     </tr>
			 
			 <tr>
			   <th>Author</th>
			   <td><input type="text" name="author" class="form-control"></td>
			   <th>For Class</th>
			   <td>
			     <select class="form-control" name="for_class">
				   <option value="">Select</option>
				   <option value="NUR">GENERAL</option>
				   <option value="NUR">NUR</option>
				   <option value="LKG">LKG</option>
				   <option value="UKG">UKG</option>
				   <option value="1">1</option>
				   <option value="2">2</option>
				   <option value="3">3</option>
				   <option value="4">4</option>
				   <option value="5">5</option>
				   <option value="6">6</option>
				   <option value="7">7</option>
				   <option value="8">8</option>
				   <option value="9">9</option>
				   <option value="10">10</option>
				   <option value="11">11</option>
				   <option value="12">12</option>
				 </select>
			   </td>
		     </tr>
			 
			 <tr>
			   <th>Edition</th>
			   <td><input type="text" name="edition" class="form-control"></td>
			   <th>Quantity</th>
			   <td><input type="number" name="qty" class="form-control"></td>
		     </tr>
			 
			 <tr>
			   <td colspan='4' align='center'><input type="submit" name="save" class='btn btn-success'></td>
		     </tr>
		   </table>
	   </form>
    </div>
  </div>
  <div class="col-sm-2"></div>  
  </div>
  </div>
</div>

<script>
$(function ()
{
    var table=$('#period').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true
    });
            $('#searchhead th input').on('keyup change', function () {
            var i = $(this).attr('data-column');
            var v = $(this).val();
            table.columns(i).search(v).draw();
        });
});
</script>
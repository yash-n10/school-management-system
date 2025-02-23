<div class="form-group has-feedback">
  <div class="box box-primary">
  <div class="box-body">
    <div class="col-sm-2"></div>
  <div class="col-sm-8">
     <div class="box-body">
	 <?php
	   if(!empty($library_book_edit)){
		   $isbn = $library_book_edit[0]->isbn;
		   $publisher = $library_book_edit[0]->publisher;
		   $title = $library_book_edit[0]->title;
		   $cost = $library_book_edit[0]->cost;
		   $subtitle = $library_book_edit[0]->subtitle;
		   $binding_type = $library_book_edit[0]->binding_type;
		   $description = $library_book_edit[0]->description;
		   $location = $library_book_edit[0]->location;
		   $author = $library_book_edit[0]->author;
		   $for_class = $library_book_edit[0]->for_class;
		   $edition = $library_book_edit[0]->edition;
		   $actual_qty = $library_book_edit[0]->actual_qty;
		   $id = $library_book_edit[0]->id;
	   }
	 ?>
	   <form action="<?php echo base_url('library/Books/update'); ?>" method="post">
		   <table class='table'>
		     <tr>
			   <th>ISBN NO.</th>
			   <td><input type="text" name="isbn" value="<?php echo $isbn; ?>" class="form-control"></td>
			   <th>Publisher</th>
			   <td><input type="text" name="publisher" value="<?php echo $publisher; ?>" class="form-control"></td>
		     </tr>
			 
			 <tr>
			   <th>Title</th>
			   <td><input type="text" name="title" value="<?php echo $title; ?>" class="form-control"></td>
			   <th>Cost</th>
			   <td><input type="number" name="cost" value="<?php echo $cost; ?>" class="form-control"></td>
		     </tr>
			 
			 <tr>
			   <th>Sub Title</th>
			   <td><input type="text" name="subtitle" value="<?php echo $subtitle; ?>" class="form-control"></td>
			   <th>Binding</th>
			   <td><input type="text" name="binding" value="<?php echo $binding_type; ?>" class="form-control"></td>
		     </tr>
			 
			 <tr>
			   <th>Description</th>
			   <td><input type="text" name="desc" value="<?php echo $description; ?>" class="form-control"></td>
			   <th>Location</th>
			   <td><input type="text" name="location" value="<?php echo $location; ?>" class="form-control"></td>
		     </tr>
			 
			 <tr>
			   <th>Author</th>
			   <td><input type="text" name="author" value="<?php echo $author; ?>" class="form-control"></td>
			   <th>For Class</th>
			   <td>
			     <select class="form-control" name="for_class">
				   <option value="">Select</option>
				   <option value="GEN" <?php if('GEN' == $for_class){echo "selected";}?>>GENERAL</option>
				   <option value="NUR" <?php if('NUR' == $for_class){echo "selected";}?>>NUR</option>
				   <option value="LKG" <?php if('LKG' == $for_class){echo "selected";}?>>LKG</option>
				   <option value="UKG" <?php if('UKG' == $for_class){echo "selected";}?>>UKG</option>
				   <option value="1" <?php if('1' == $for_class){echo "selected";}?>>1</option>
				   <option value="2" <?php if('2' == $for_class){echo "selected";}?>>2</option>
				   <option value="3" <?php if('3' == $for_class){echo "selected";}?>>3</option>
				   <option value="4" <?php if('4' == $for_class){echo "selected";}?>>4</option>
				   <option value="5" <?php if('5' == $for_class){echo "selected";}?>>5</option>
				   <option value="6" <?php if('6' == $for_class){echo "selected";}?>>6</option>
				   <option value="7" <?php if('7' == $for_class){echo "selected";}?>>7</option>
				   <option value="8" <?php if('8' == $for_class){echo "selected";}?>>8</option>
				   <option value="9" <?php if('9' == $for_class){echo "selected";}?>>9</option>
				   <option value="10" <?php if('10' == $for_class){echo "selected";}?>>10</option>
				   <option value="11" <?php if('11' == $for_class){echo "selected";}?>>11</option>
				   <option value="12" <?php if('12' == $for_class){echo "selected";}?>>12</option>
				 </select>
			   </td>
		     </tr>
			 
			 <tr>
			   <th>Edition</th>
			   <td colspan='4'><input type="text" name="edition" value="<?php echo $edition; ?>" class="form-control"></td>
		     </tr>
			 
			 <tr>
			   <th>Quantity</th>
			   <td><input type="number" name="qty" value="<?php echo $actual_qty; ?>" class="form-control" readonly></td>
			   <th style='text-align:center'><button type="button" class='btn btn-danger'><b>+</b></button></th>
			   <td><input type="number" value="0" name="add_qty" class="form-control"></td>
			 </tr>
			 
			 <tr>
			   <td colspan='4' align='center'><input type="submit" value="update"name="save" class='btn btn-success'></td>
		     </tr>
			 <input type="hidden" name='upd_id' value="<?php echo $id; ?>">
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
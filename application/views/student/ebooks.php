<?php if ($ebooks_category_id != ""): ?>

    <div class="box">

        <div class="box-header">



            <!------CONTROL TABS START------->

            <ul class="nav nav-tabs nav-tabs-left">
               
                <li <?php if(!isset($upload)){ ?> class="active" <?php } ?>>

                    <a href="#list" data-toggle="tab"><i class="icon-align-justify"></i> 

                        <?php echo get_phrase('View E-Books'); ?>

                    </a></li>


            </ul>

            <!------CONTROL TABS END------->



        </div>

        <div class="box-content">

            <div class="tab-content">

                <!----TABLE LISTING STARTS--->

                <div class="tab-pane <?php if(!isset($upload)) { echo 'active' ;}  ?>" id="list">
 
                    <center>

                        <br />

                        <select name="class_id" onchange="window.location='<?php echo base_url(); ?>student/ebooks/'+this.value">

                            <option value=""><?php echo get_phrase('Selece a Category'); ?></option>

                            <?php
                            $ebooks_cat = $this->db->get('ebooks_cat')->result_array();

                            foreach ($ebooks_cat as $row):
                                ?>

                                <option value="<?php echo $row['ebooks_category_id']; ?>"

        <?php if ($ebooks_category_id == $row['ebooks_category_id']) echo 'selected'; ?>>

                                    <?php echo $row['ebooks_category_name']; ?></option>

        <?php
    endforeach;
    ?>

                        </select>

                        <br /><br />

    <?php if ($ebooks_category_id == ''): ?>

                            <div id="ask_class" class="  alert alert-info  " style="width:300px;">

                                <i class="icon-info-sign"></i> Please select a Ebook to manage.

                            </div>

                            <script>

                                $(document).ready(function() {

        						  	

                                    function shake()

                                    {

                                        $( "#ask_class" ).effect( "shake" );

                                    }

                                    setTimeout(shake, 500);

                                });

                            </script>

                            <br /><br />

    <?php endif; ?>

    <?php if ($ebooks_category_id != ''): ?>



                            <div class="action-nav-normal">

                                <div class=" action-nav-button" style="width:300px;">

                                    <a href="#" title="Users">

                                        <img src="<?php echo base_url(); ?>template/images/icons/ebooks.png" />

                                        <span>Total <?php echo count($ebooks); ?> E-Books</span>

                                    </a>

                                </div>

                            </div>

                        </center>

                        <div class="box">

                            <div class="box-content">

                                <div id="dataTables">

                                    <table cellpadding="0" cellspacing="0" border="0" class="dTable responsive ">

                	<thead>
                		<tr>
                    		<th><div>#</div></th>                   		
                    		<th><div><?php echo get_phrase('Thumbnail');?></div></th>
                    		<th><div><?php echo get_phrase('book_name');?></div></th>
                    		<th><div><?php echo get_phrase('options');?></div></th>

						</tr>
					</thead>
                                        <tbody>

                    	<?php $count = 1;
                    	
                    	foreach($ebooks as $row):?>
                        <tr>
                            <td><?php echo $count++;?></td>
                            <td><img src="<?php echo $this->crud_model->get_image_url('ebook', $row['ebooks_id']); ?>" class="avatar-medium" /><div class="avatar"></div></td>
							<td><?php echo $row['ebooks_name'];?></td>
                            <td><a href="<?php echo $this->crud_model->get_pdf_url('pdf', $row['ebooks_id']); ?>">View Book</a></td>
                        </tr>
                        <?php endforeach;?>

                                        </tbody>

                                    </table>

                                </div>

                            </div>

                        </div>

    <?php endif; ?>

                </div>

                <!----TABLE LISTING ENDS--->

            </div>

        </div>

    </div>

<?php endif; ?>

<?php if ($ebooks_category_id == ""): ?>

    <center>

        <div class="span4" style="float:none !important;">

            <div class="box">

                <div class="box-header">

                    <span class="title"> <i class="icon-info-sign"></i> Please select a category of E- Book.</span>

                </div>

                <div class="box-content padded tam-custom-border1">

                    <br />

                    <select name="class_id" onchange="window.location='<?php echo base_url(); ?>student/ebooks/'+this.value">

                        <option value=""><?php echo get_phrase('Select an E-Book'); ?></option>

    <?php
    $ebooks_cat = $this->db->get('ebooks_cat')->result_array();

    foreach ($ebooks_cat as $row):
        ?>

                            <option value="<?php echo $row['ebooks_category_id']; ?>"

                            <?php if ($ebooks_category_id == $row['ebooks_category_id']) echo 'selected'; ?>>

                                 <?php echo $row['ebooks_category_name']; ?></option>

                            <?php
                        endforeach;
                        ?>

                    </select>

                    <!--<hr />-->

                    <script>

                        $(document).ready(function() {

                            function ask()

                            {

                                Growl.info({title:"Select a E-Book to manage",text:" "});

                            }

                            setTimeout(ask, 500);

                        });

                    </script>

                </div>

            </div>

        </div>

    </center>

<?php endif; ?>

<script>

    function readURL(input) {

        if (input.files && input.files[0]) {

            var reader = new FileReader();

            

            reader.onload = function (e) {

                $('#blah').attr('src', e.target.result);

            }

            

            reader.readAsDataURL(input.files[0]);

        }

    }

    

    $("#imgInp").change(function(){

        readURL(this);

    });

</script>
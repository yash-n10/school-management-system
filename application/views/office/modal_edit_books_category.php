<div class="tab-pane box active" id="edit" style="padding: 5px">
    <div class="box-content">
        <?php foreach($edit_data as $row):?>
        <?php echo form_open('admin/book_cat/do_update/'.$row['books_category_id'] , array('class' => 'form-horizontal validatable','target'=>'_top'));?>
            <div class="padded">
                <div class="control-group">
                    <label class="control-label"><?php echo get_phrase('books_category_id');?></label>
                    <div class="controls">
                        <input type="text" class="validate[required]" name="catname" value="<?php echo $row['books_category_name'];?>"/>
                    </div>
                </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-gray"><?php echo get_phrase('edit_book_category');?></button>
            </div>
        </form>
        <?php endforeach;?>
    </div>
</div>

<div class="box">
    <div class="box-body"> 
        <?php
        foreach ($settings as $row):
            ?>
            <?php echo form_open('settings/system_settings/update/' . $row['type'], array('class' => 'validatable', 'target' => '_top')); ?>
            <div class="form-group">
                <label><?php echo get_phrase($row['type']); ?></label>
                <div class="controls">

                    <!-- RTL , LTR SETTINGS -->
                    <?php if ($row['type'] == 'text_direction'): ?>

                        <select name="description">

                            <option value="left_to_right" <?php if ($row['description'] == 'left_to_right') echo 'selected'; ?> >
                                <?php echo get_phrase('left_to_right'); ?></option>

                            <option value="right_to_left" <?php if ($row['description'] == 'right_to_left') echo 'selected'; ?> >
                                <?php echo get_phrase('right_to_left'); ?></option>

                        </select>
                        <button type="submit" class="btn btn-blue"><?php echo get_phrase('save'); ?></button>
                        <?php continue;
                    endif; ?>
                    <!-- RTL , LTR SETTINGS -->
                    <input type="text" class="" name="description" value="<?php echo $row['description']; ?>"/>
                    <button type="submit" class="btn btn-blue"><?php echo get_phrase('save'); ?></button>
                </div>
            </div>
            </form>
            <?php
        endforeach;
        ?>
        <?php echo form_open_multipart('settings/system_settings/upload_logo'); ?>
        <div class='form-group'>
            <label>Logo</label>
            <input type="file" name="userfile" size="20" /></br>
            <input type="submit" value="upload" />
        </div>
        </form>


    </div>
</div>

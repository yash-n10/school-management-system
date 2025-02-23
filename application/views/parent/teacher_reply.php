<div class="box">
    <div class="box-header">
        <!------CONTROL TABS START------->

        <ul class="nav nav-tabs nav-tabs-left">
            <li class="active">
                <a href="#list" data-toggle="tab"><i class="icon-align-justify"></i> 
                    <?php echo get_phrase('teacher_reply'); ?>
                </a>
            </li>
        </ul>

        <!------CONTROL TABS END------->
    </div>
    <div class="box-content padded">
        <div class="tab-content">       

            <div class="container center-container" style="width:1080px !">
                <!----TABLE LISTING STARTS--->
                <div class="tab-pane  active" id="list">
                    <div class="col-md-12">
                        <div class="row clearfix">
                            <input type="hidden" class="page" value="message">
                            <input type="hidden" class="page_info" value="message">
                            <div class="col-sm-12">
                                <div class="col-sm-4 message-list">
                                    <ul id="dialogs_list">
                                        <?php
                                        if (isset($messages) && !empty($messages)) :
                                            foreach ($messages as $message) :
                                                if ($message->status == 1) :
                                                    $class = 'unread connections_container_left';
                                                else :
                                                    $class = 'connections_container_left';
                                                endif;
                                                ?>
                                                <li id="connection_<?php echo $message->user_id; ?>" class="round <?php echo $class; ?>" style="cursor:pointer;height:65px">
                                                    <div class="img-container">
                                                        <a class="img-link" href="javascript:void(0);" rel="">
                                                            <img src="<?php echo base_url().'template/images/teacher.png' ?>" width="45px" height="51px"/>
                                                        </a>
                                                    </div>
                                                    <div class="data-container">
                                                        <h2 class="silver"><?php echo $message->tname; ?></h2>
                                                        <p class="type silver">Sent You a Message</p>

                                                        <div class="btn-container">
                                                            <a class="delete" href="javascript:void(0);" rel="tooltip" title="Delete">
                                                                <?php /* <span style="background: url('img/cross.png') no-repeat; display: inline-block; width: 8px; height: 8px; padding: 0 5px;"></span> */ ?>
                                                                <i class="glyphicon glyphicon-remove-circle" style="padding: 0 2px;"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </li>
                                                <?php
                                            endforeach;
                                        endif;
                                        ?>
                                    </ul>
                                </div>
                                <div class="col-sm-8">
                                    <?php if (isset($messages) && !empty($messages)) : ?>
                                        <div id="dialog_box">
                                            <div>		
                                                <div class="round" id="message_list">
                                                    <div class='alert alert-info'>Please select a user.</div>
                                                </div>
                                                <div id="reply_area_msg">
                                                    <input type="hidden" name="chat_user_id" value="<?php echo $message->user_id; ?>">
                                                    <textarea id="message" onfocus="if (this.value == 'Write a reply...') {this.value=''}" onblur="if(this.value == '') { this.value='Write a reply...'}" onclick="if (this.value == '' || this.value == 'Write a reply...') { this.value = ''; };">Write a reply...</textarea>
                                                    <input type="submit" id="comment_button" name="comment_button" value="Respond" class="btn btn-theme">
                                                    <div class="clearfix"></div>
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>	

                </div>
                <!----TABLE LISTING ENDS--->
            </div>
        </div>
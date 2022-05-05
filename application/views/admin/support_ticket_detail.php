 <?php
    $path = base_url();
    $this->load->helper('comman_helper');
    //print_r($ticket);  
?>
  <style>
		.page-content {
			background: #eef1f5 none repeat scroll 0 0;
		}
		</style>
  <!-- BEGIN CONTENT -->
        <div class="page-content-wrapper">
            <!-- BEGIN CONTENT BODY -->
            <div class="page-content">
                <!-- BEGIN PAGE HEADER-->
				<!-- BEGIN PAGE BAR -->
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <a href="<?=base_url('apcompundpower/dashboard')?>">Home</a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>    
                                <a href="<?=base_url('apcompundpower/Support')?>">Support</a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                <span>Ticket</span>
                            </li>
                        </ul>
                    </div>
                    <!-- END PAGE BAR -->
                        <!-- BEGIN PAGE TITLE-->
                        <h1 class="page-title"> Support Tickets
                        </h1>
                        <!-- END PAGE TITLE-->
                        <!-- END PAGE HEADER-->
                        <div class="row">
                            <div class="col-md-12">
                                <!-- BEGIN TICKET DETAILS CONTENT -->
                                <div class="app-ticket app-ticket-details">
                                    <div class="portlet ">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="portlet-title tabbable-line">
                                                    <div class="caption caption-md">
                                                        <i class="icon-globe theme-font hide"></i>
                                                        <span class="caption-subject font-blue-madison bold uppercase">Subject: <?=$ticket->subject?></span>
                                                        <span class="pull-right">
                                                        <?php
                                                            if($ticket->status!=2){
                                                     ?>
                                                        <button id="close_ticket" data-ref="<?=$ticket->id?>" class="btn uppercase  bluue-btn" type="button">Mark as resolve</button>
                                                        <?php }?>
                                                        &nbsp;&nbsp;<a class="btn uppercase  bluue-btn" href="<?=base_url('apcompundpower/support')?>">Back</a></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="portlet ">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="portlet-body blue-box-heading">
                                                    <ul>
                                                        <li>Status: <span class="left-content">
                                                            <?php
                                                                switch ($ticket->status) {
                                                                case 0:
                                                                    echo ' Pending ';
                                                                    break;
                                                                case 1:
                                                                    echo ' Replied ';
                                                                    break;
                                                                case 2:
                                                                    echo ' Resolved ';
                                                                    break;
                                                                case 3:
                                                                    echo ' On Hold ';
                                                                    break;
                                                                }
                                                            ?>
                                                        </span></li>
                                                        <li>Ticket No: <span class="left-content"> #<?=$ticket->ticket_no?></span></li>
                                                        
                                                        <li>Date | Time: <span class="left-content"><?=change_date_format($ticket->created_date,'d-M-Y, h:i A')?></span></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- old one -->
                                    <div class="row">
                                        <div class="col-md-12">

                                            <?php 
                                            foreach ($conversation as $conv) {
                                                $class = '';
                                                    if($conv['usertype']==0)
                                                    {
                                                        $class = 'admindiv';
                                                    }
                                                    else
                                                    {
                                                        $class = 'userdiv';
                                                    }
                                                    echo '
                                                    <div class="portlet light '.$class.'" style="padding:0;">
                                                        <div class="portlet-body ticket-msgs">
                                                            <p class="date-class">'.change_date_format($conv['created_date'],'d-M-Y | h:i A').'</p>
                                                            <div class="portlet-body ticket-msgs">
                                                                <br>
                                                                <p>
                                                                    '.$conv['body'].'
                                                                </p>
                                                                <br>';
                                                                $data = explode(',', $conv['attachment']);
                                                                if($conv['attachment']){
                                                                    for($i=0; $i<count($data); $i++)
                                                                    {
                                                                        $image = explode('/', $data[$i]);
                                                                        echo '<strong><a download="'.$data[$i].'" href="'.base_url().$data[$i].'" style="text-decoration:none;color:#007bb3;">
                                                                        <i class="fa fa-paperclip" aria-hidden="true" style="font-size:20px;"></i>&nbsp;&nbsp;'.$image[2].'</a></strong>&nbsp;&nbsp;&nbsp;';
                                                                    }
                                                                }
                                                            echo '</div>
                                                        </div>
                                                    </div>
                                                
                                                        ';
                                                    }
                                                ?>
                                            
                                                    <div class="ticket-line"></div>
                                                    <?php
                                                            if($ticket->status!=2){
                                                     ?>
                                                    <form class="form-group" method="POST" action="<?=base_url('Process/TicketReply')?>" enctype="multipart/form-data">
                                                        <div class="row">
                                                            <div class="col-xs-12">
                                                                <input type="hidden" name="ref_id" value="<?=$ticket->id?>">
                                                                <textarea required="required" name="body" placeholder="Type here to reply" class="ticket-reply-msg1 form-control" row="10" col="10"></textarea>
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <span class="btn green fileinput-button">
                                                                    <i class="fa fa-plus"></i>
                                                                    <span> Attach </span>
                                                                    <input type="hidden" value="<?=time()?>" name="ticket_no">
                                                                    <input type="file" name="image_id[]" multiple="" accept=".jpeg,.jpg,.png,.pdf">
                                                                </span>
                                                                <button class="btn btn-square uppercase bold orange" type="submit">Reply</button>
                                                            </div>
                                                            <div class="col-md-2 hidden">
                                                                <h3 class="ticket-margin">
                                                                    <i class="icon-calendar"></i> Due Date</h3>
                                                                <input class="form-control form-control-inline input-small date-picker" size="16" type="text" value="" /> 
                                                            </div>
                                                        </div> 
                                                    </form>
                                                    <?php }?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- END PROFILE CONTENT -->
                            </div>
                        </div>
                    </div>
                    <!-- END CONTENT BODY -->
                </div>
                <!-- END CONTENT -->
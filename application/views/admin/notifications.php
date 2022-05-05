
<style>
    .textarea-error .error {
      top: 115px !important;
      left: 8px;
    }
</style>
<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <!-- BEGIN PAGE BAR -->
        <div class="page-bar">
            <ul class="breadcrumb">
                <li>
                    <a href="#">Home</a>
                </li>
                <li class="active">Manage Push Notification</li>
            </ul>
            <style>
                .file-input-wrapper {
                    overflow: visible !important;
                    position: relative;
                    cursor: pointer;
                    z-index: 1;
                }
                </style>
            <div class="page-content-wrap">
                <div class="row">
                    <div class="col-md-12">
                       <form id="send_notifiactionfm" class="form-horizontal" id="notificationform" enctype='multipart/form-data' action="
                            <?=base_url('apcompundpower/sendnotification')?>" method="POST">

                        
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">
                                        <strong>Send</strong> Notification
                                    </h3>
                                    <div class="pull-right" style="margin-top: -25px;">
                                        <a class="btn btn-info btn-condensed btn-sm" href="
                                            <?php echo base_url();?>apcompundpower/notificationlist">
                                            <i class="fa fa-arrow-left"></i>&nbsp Back
                                        </a>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="form-group" style="margin-bottom:25px;">
                                       
                                    </div>
                                    <div class="form-group" style="margin-bottom:25px;">
                                        <label class="col-md-3 control-label">Subject</label>
                                        <div class="col-md-6 col-xs-12">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                        <span class="fa fa-edit"></span>
                                                </span>
                                                <input type="text" class="form-control" name="subject" value="" required />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group" style="margin-bottom:25px;">
                                        <label class="col-md-3 control-label"></label>
                                        <div class="col-md-6 col-xs-12">
                                            <div class="input-group">
                                                <input type="radio" name="user" value="single" onclick="show1();" checked="checked" />All&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <input type="radio" name="user" value="multiple" onclick="show2();" />Multiple
                                            </div>
                                        </div>
                                    </div>
                                    <div id="multiple" style="display: none">
                                        <div class="form-group" style="margin-bottom:25px;">
                                            <label class="col-md-3 control-label">Multiple Users</label>
                                            <div class="col-md-6 col-xs-12">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <span class="fa fa-edit"></span>
                                                    </span>
                                                    <!--div id="ms1" class="form-control"-->
                                                    <select class="form-control" id="ms1" name="select_user" placeholder="Please Enter username or phone number">
                                                        <?php foreach ($members_data as $data) { 
                                                             ?>
                                                            <option value="<?php echo $data['id']?>" ><?php echo $data['username'].' ('.$data['full_name'].')'; ?></option><?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group" style="margin-bottom:25px;">
                                        <label class="col-md-3 col-xs-12 control-label">Message</label>
                                        <div class="col-md-6 col-xs-12 textarea-error">
                                            <textarea class="emptyarea" name="nmessage" style="width:100%; height:110px;" maxlength="250"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group" style="margin-bottom:25px;">
                                        <label class="col-md-3 col-xs-12 control-label">File</label>
                                        <div class="col-md-6 col-xs-12">
                                            <a class="file-input-wrapper btn btn-default  fileinput btn-primary">
                                                <span>Browse file</span>
                                                <input type="file" class="fileinput btn-primary" name="filename" id="filename" title="Browse file" accept=".png, .jpg, .jpeg" />
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-footer">
                                    <button class="btn btn-default btn-sm clearForm" type="button">Clear Form
                                        <span class="fa fa-refresh fa-right"></span>
                                    </button>
                                    <button class="btn btn-primary btn-sm submitbttn" disabled="disabled" type="submit">Send Notification
                                        <span class="fa fa-send fa-right"></span>
                                    </button>
                                </div>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    function show1() {
        
        $("#multiple").hide();
       
    }

    function show2() {
       
        $("#multiple").show();
       
    }
</script>


<script type="text/javascript">
    (function() {
        var ga = document.createElement('script');
        ga.type = 'text/javascript';
        ga.async = true;
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(ga, s);
    })();
</script>

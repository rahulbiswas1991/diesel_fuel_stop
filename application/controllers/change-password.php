<?php
$path = base_url();
$this->load->helper('comman_helper');
?>

<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <!-- BEGIN PAGE TITLE-->
        <h1 class="page-title">Change Password</h1>
        <!-- END PAGE TITLE-->
        <!-- BEGIN PAGE BAR -->
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <a href="<?= base_url() ?>">Home</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <span>Change Password</span>
                </li>
            </ul>
        </div>
        <!-- END PAGE BAR -->
        <!-- END PAGE HEADER-->
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PROFILE CONTENT -->
                <div class="user-content request-payment-content">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="portlet clearfix">
                                <div class="portlet-title">
                                    <div class="caption">Change Password</div>
                                </div>

                                <div class="col-md-9 col-lg-8">
                                    <div class="portlet-body clearfix">
                                        <div class="col-md-12 row">
                                            <form class="form-horizontal" id="changepwd">
                                                <div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="id-number">Old Password</label>
                                                            <input id="old_pass" class="form-control required" type="password" value="" name="old_password" required>
                                                        </div>
                                                        <!--label class="showError oldpw_error" style="display:none;">
                                                            <font color="red">* Old Password does not match!</font>
                                                        </label-->
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="request-amount">New Password</label>
                                                            <input id="new_password" class="form-control required" type="password" value="" name="new_password" required>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="request-amount">Confirm Password</label>
                                                        <input id="conf_pwd" class="form-control required" type="password" value="" name="confirm_new_password" required>
                                                    </div>
                                                </div>

                                                <div class="btn-group" style="margin-top: 31px; margin-left:30%;">
                                                    <!--img class="wait" src="../assets/img/loaders/default.gif" style="display: none;"/-->
                                                    <button class="btn btn-primary change_passwoed" type="submit">Reset Password</button>
                                                    <label class="success_msg" style="padding: 9px;margin: 0;" id="demo"></label>
                                                </div>

                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END PROFILE CONTENT -->
            </div>
        </div>
        <!-- END CONTENT BODY -->
    </div>
</div>
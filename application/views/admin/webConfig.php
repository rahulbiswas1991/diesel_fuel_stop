<?php
if (isset($msg)) {
    echo "<script>alert('Logo has been Modified, ')</script>";
}
?>

<style>
    .form-group:last-child {
        margin-bottom: 15px;
    }
    .nav > li > a:focus, .nav > li > a:hover {
        background-color: rgb(63, 79, 98);
        text-decoration: none;
        color: #fff;
    }
</style>
<div class="page-content-wrapper">
    <div class="page-content">
        <h1 class="page-title">Web Config</h1>
        <div class="portlet">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <strong>Website Config</strong>
                            </h3>
                        </div>
                        <div class="panel-body">
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#home">Personalize Logo</a></li>
                                <li><a data-toggle="tab" href="#menu1">Social Links</a></li>
                                <li><a data-toggle="tab" href="#contact">Contact</a></li>
                                <li><a data-toggle="tab" href="#email">Email Configuration</a></li>
                            </ul>

                            <div class="col-md-8 ">
                                <div class="tab-content">
                                    <br>
                                    <div id="home" class="tab-pane fade in active">
                                        <form id="personalize_website" method="POST" enctype="multipart/form-data">
                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label class="col-md-2 col-xs-12 control-label">Title</label>
                                                    <div class="col-md-8 col-xs-12">
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <span class="fa fa-pencil"></span>
                                                            </span>
                                                            <input class="form-control" type="text" name="web_title" placeholder="Please Enter Website Title" value="<?=!empty($config_web['title']) ? $config_web['title'] :''?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label class="col-md-2 col-xs-12 control-label">Footer</label>
                                                    <div class="col-md-8 col-xs-12">
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <span class="fa fa-pencil"></span>
                                                            </span>
                                                            <input class="form-control" type="text" name="logo_tagline" placeholder="Please Enter Logo Tagline" value="<?= !empty($config_web['tagline']) ? $config_web['tagline'] : '' ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label class="col-md-2 col-xs-12 control-label">Image</label>
                                                    <div class="col-md-8 col-xs-12">
                                                        <input id="image" accept=".png, .jpg, .jpeg" name="userfile" class="fileinput btn-primary" type="file" title="Browse file" onchange="readURL(this);">
                                                        <img id="blah" src="<?= !empty($config_web['logo']) ? base_url() . '' . $config_web['logo'] : '#' ?>" alt="your image" style="mix-blend-mode: difference;" />
                                                    </div>
                                                </div>
                                                <label class="col-md-2 col-xs-12 control-label"></label>
                                                <div class="col-md-3">
                                                    <button type="submit" name="submit" class="btn btn-primary btn-md float-left">
                                                        Upload
                                                        <span class="fa fa-floppy-o fa-right"></span>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div id="email" class="tab-pane fade">
                                        <form method="POST" action="<?php echo base_url() ?>apcompundpower/config_email">
                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label class="col-md-2 col-xs-12 control-label">Host</label>
                                                    <div class="col-md-8 col-xs-12">
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <span class="fa fa-pencil"></span>
                                                            </span>
                                                            <input class="form-control" type="text" name="host" placeholder="smtp.gmail.com" value="<?= (isset($config_web['e_host'])?$config_web['e_host']:'') ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label class="col-md-2 col-xs-12 control-label">Port</label>
                                                    <div class="col-md-8 col-xs-12">
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <span class="fa fa-pencil"></span>
                                                            </span>
                                                            <input class="form-control" type="text" name="portt" placeholder="587" value="<?= (isset($config_web['e_port'])?$config_web['e_port']:'') ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label class="col-md-2 col-xs-12 control-label">Username</label>
                                                    <div class="col-md-8 col-xs-12">
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <span class="fa fa-pencil"></span>
                                                            </span>
                                                            <input class="form-control" type="text" name="user" placeholder="testdemo@gmail.com" value="<?= (isset($config_web['e_user'])?$config_web['e_user']:'') ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label class="col-md-2 col-xs-12 control-label">Password</label>
                                                    <div class="col-md-8 col-xs-12">
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <span class="fa fa-pencil"></span>
                                                            </span>
                                                            <input class="form-control" type="text" name="pass" placeholder="*******" value="<?= isset($config_web['e_password'])?$config_web['e_password']:'' ?>" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label class="col-md-2 col-xs-12 control-label">Protocol</label>
                                                    <div class="col-md-8 col-xs-12">
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <span class="fa fa-columns"></span>
                                                            </span>
                                                            <select class="form-control" name="pro">
                                                                <option value="mail" <?php if(isset($config_web['e_protocol']) && $config_web['e_protocol']=='mail') { echo 'selected'; } ?> >mail</option>
                                                                <option value="smtp" <?php if(isset($config_web['e_protocol']) && $config_web['e_protocol']=='smtp') { echo 'selected'; } ?> >smtp</option>
                                                                <option value="sendmail" <?php if(isset($config_web['e_protocol']) && $config_web['e_protocol']=='sendmail') { echo 'selected'; } ?> >sendmail</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label class="col-md-2 col-xs-12 control-label">Encryption</label>
                                                    <div class="col-md-8 col-xs-12">
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <span class="fa fa-columns"></span>
                                                            </span>
                                                            <select class="form-control" name="encry">
                                                                <option value="ssl" <?php if(isset($config_web['e_encryption']) && $config_web['e_encryption']=='ssl') { echo 'selected'; } ?> >ssl</option>
                                                                <option value="tls" <?php if(isset($config_web['e_encryption']) && $config_web['e_encryption']=='tls') { echo 'selected'; } ?> >tls</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <label class="col-md-2 col-xs-12 control-label"></label>
                                                <div class="col-md-3">
                                                    <button type="submit" name="submit" class="btn btn-primary btn-md float-left">
                                                        Save
                                                        <span class="fa fa-floppy-o fa-right"></span>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div id="menu1" class="tab-pane fade">
                                        <form class="form-horizontal" action="<?php echo base_url() ?>apcompundpower/config_social_links" method="post">
                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label class="col-md-2 col-xs-12 control-label">Facebook Link</label>
                                                    <div class="col-md-8 col-xs-12">
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <span class="fa fa-pencil"></span>
                                                            </span>
                                                            <input class="form-control" type="text" id="fblink" name="fb" required="required" placeholder="Please Provide Complete Link with 'http://'" value="<?= (isset($config_web['facebook'])?$config_web['facebook']:'') ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label class="col-md-2 col-xs-12 control-label">Twitter Link</label>
                                                    <div class="col-md-8 col-xs-12">
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <span class="fa fa-pencil"></span>
                                                            </span>
                                                            <input class="form-control" type="text" id="tlink" name="twitter" required="required" placeholder="Please Provide Complete Link with 'http://'" value="<?= (isset($config_web['twitter'])?$config_web['twitter']:'') ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label class="col-md-2 col-xs-12 control-label">Linked In Link</label>
                                                    <div class="col-md-8 col-xs-12">
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <span class="fa fa-pencil"></span>
                                                            </span>
                                                            <input class="form-control" type="text" name="linkedin" id="linked" required="required" placeholder="Please Provide Complete Link with 'http://'" value="<?= (isset($config_web['linkedin'])?$config_web['linkedin']:'') ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label class="col-md-2 col-xs-12 control-label">Youtube Link</label>
                                                    <div class="col-md-8 col-xs-12">
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <span class="fa fa-pencil"></span>
                                                            </span>
                                                            <input class="form-control" type="text" id="ylink" name="youtube" required="required" placeholder="Please Provide Complete Link with 'http://'" value="<?= (isset($config_web['youtube'])?$config_web['youtube']:'') ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label class="col-md-2 col-xs-12 control-label">Instagram Link</label>
                                                    <div class="col-md-8 col-xs-12">
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <span class="fa fa-pencil"></span>
                                                            </span>
                                                            <input class="form-control" type="text" name="instagram" id="linked" required="required" placeholder="Please Provide Complete Link with 'http://'" value="<?= (isset($config_web['instagram'])?$config_web['instagram']:'') ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label class="col-md-2 col-xs-12 control-label">Pinterest Link</label>
                                                    <div class="col-md-8 col-xs-12">
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <span class="fa fa-pencil"></span>
                                                            </span>
                                                            <input class="form-control" type="text" id="plink" name="pinterest" required="required" placeholder="Please Provide Complete Link with 'http://'" value="<?= (isset($config_web['pinterest'])?$config_web['pinterest']:'') ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label class="col-md-2 col-xs-12 control-label">Dribble Link</label>
                                                    <div class="col-md-8 col-xs-12">
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <span class="fa fa-pencil"></span>
                                                            </span>
                                                            <input class="form-control" type="text" id="dlink" name="dribble" required="required" placeholder="Please Provide Complete Link with 'http://'" value="<?= (isset($config_web['dribble'])?$config_web['dribble']:'') ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <label class="col-md-2 col-xs-12 control-label"></label>
                                                <div class="col-md-4">
                                                    <button type="submit" class="btn btn-primary btn-md float-left">
                                                        Save Links
                                                        <span class="fa fa-floppy-o fa-right"></span>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                    <div id="contact" class="tab-pane fade">
                                        <form class="form-horizontal" action="<?php echo base_url() ?>apcompundpower/config_contact" method="post">

                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label class="col-md-2 col-xs-12 control-label">website</label>
                                                    <div class="col-md-8 col-xs-12">
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <span class="fa fa-pencil"></span>
                                                            </span>

                                                            <input class="form-control" name="website" type="text" id="website" value="<?= (isset($config_web['website'])?$config_web['website']:'') ?>" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label class="col-md-2 col-xs-12 control-label">Contact 1</label>
                                                    <div class="col-md-8 col-xs-12">
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <span class="fa fa-pencil"></span>
                                                            </span>
                                                            <input class="form-control" name="mob" type="text" id="title" value="<?= (isset($config_web['mobile'])?$config_web['mobile']:'') ?>" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label class="col-md-2 col-xs-12 control-label">Contact 2</label>
                                                    <div class="col-md-8 col-xs-12">
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <span class="fa fa-pencil"></span>
                                                            </span>
                                                            <input class="form-control" name="mob1" type="text" id="title" value="<?= (isset($config_web['mobile1'])?$config_web['mobile1']:'') ?>" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label class="col-md-2 col-xs-12 control-label">Email</label>
                                                    <div class="col-md-8 col-xs-12">
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <span class="fa fa-pencil"></span>
                                                            </span>

                                                            <input class="form-control" name="email" type="text" value="<?= (isset($config_web['email'])?$config_web['email']:'') ?>" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label class="col-md-2 col-xs-12 control-label">Skype ID</label>
                                                    <div class="col-md-8 col-xs-12">
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <span class="fa fa-pencil"></span>
                                                            </span>

                                                            <input class="form-control" name="skype" type="text" id="skype" value="<?= (isset($config_web['skype'])?$config_web['skype']:'') ?>" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label class="col-md-2 col-xs-12 control-label">About</label>
                                                    <div class="col-md-8 col-xs-12">
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <span class="fa fa-pencil"></span>
                                                            </span>

                                                            <textarea class="form-control" name="description" rows="5" id="description" required><?= (isset($config_web['about'])?$config_web['about']:'') ?></textarea>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <label class="col-md-2 col-xs-12 control-label"></label>
                                            <div class="col-md-4">
                                                <button type="submit" class="btn btn-primary btn-md float-left">
                                                    Save
                                                    <span class="fa fa-floppy-o fa-right"></span>
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
        </div>
    </div>
</div>

    <script src="//code.jquery.com/jquery-3.4.1.min.js"></script>
    <script type="text/javascript">
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#blah')
                        .attr('src', e.target.result)
                        .width(100)
                        .height();
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
        $(document).ready(function(e) {
            $("#personalize_website").submit(function(e) {
                e.preventDefault();
                var tagline = $("input[name=logo_tagline]").val().trim();
                var title = $("input[name=web_title]").val().trim();
                var logo = $("input[name=userfile]").val().trim();
                if (tagline != '' || title != '' || logo != '') {
                    var formdata = new FormData($(this)[0]);
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url() ?>apcompundpower/update_logo",
                        data: formdata,
                        processData: false,
                        contentType: false,
                        success: function(data) {
                            if (data == 0) {
                                alert('Please Enter Some Value to change.');
                            } else {
                                alert('Logo Update successfully');
                                window.location = location.href;
                            }
                        }
                    });
                } else {
                    alert('Please Enter Some Values.');
                }
            });
        });
    </script>
<?php
    $path = base_url();
    //echo '<pre>';print_r($binary_chart_data['Nov']);
?>
<!-- BEGIN FOOTER -->
            <div class="page-footer">
                <div class="page-footer-inner"> <?=date("Y")?> &copy; B-Fly MLM. All Rights Reserved.
                </div>
                <div class="scroll-to-top">
                    <i class="icon-arrow-up"></i>
                </div>
            </div>
            <!-- END FOOTER -->
        </div>
        <!-- BEGIN QUICK NAV -->
       
        <div class="quick-nav-overlay"></div>
        <!-- END QUICK NAV -->
        
        <!-- BEGIN CORE PLUGINS -->
        <input type="hidden" id="searchusername" value="<?=base_url('common/searchusername');?>">                           
            <input type="hidden" id="basepath" value="<?= $path ?>">
        <script src="<?=$path?>assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<!-- 21-04-2018 -->
        <script type="text/javascript">var basepath = $("#basepath").val();</script>
      
        <script src="<?=$path?>assets/global/plugins/sweetalert2.min.js"></script>
        <script src="<?=$path?>assets/global/plugins/bootstrap-toastr/toastr.min.js"></script>
        <script src="<?=$path?>assets/global/plugins/bootstrapValidator.min.js"></script>
        <script src="<?=$path?>assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
        <script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="https://code.highcharts.com/modules/exporting.js"></script>
        <script src="https://code.highcharts.com/modules/export-data.js"></script>
        <script src="<?=$path?>assets/global/scripts/methadmin.js"></script>
        <script src="<?=$path?>assets/global/scripts/select2.min.js"></script>
<!-- 21-04-2018 -->
        <script src="<?=$path?>assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="<?=$path?>assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="<?=$path?>assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <script src="<?=$path?>assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="<?=$path?>assets/global/plugins/moment.min.js" type="text/javascript"></script>
        <script src="<?=$path?>assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
        <script src="<?=$path?>assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js" type="text/javascript"></script>
        <script src="<?=$path?>assets/global/plugins/morris/morris.min.js" type="text/javascript"></script>
        <script src="<?=$path?>assets/global/plugins/morris/raphael-min.js" type="text/javascript"></script>
        <script src="<?=$path?>assets/global/plugins/counterup/jquery.waypoints.min.js" type="text/javascript"></script>
        <script src="<?=$path?>assets/global/plugins/counterup/jquery.counterup.min.js" type="text/javascript"></script>
        <script src="<?=$path?>assets/global/plugins/amcharts/amcharts/amcharts.js" type="text/javascript"></script>
        <script src="<?=$path?>assets/global/plugins/amcharts/amcharts/serial.js" type="text/javascript"></script>
        <script src="<?=$path?>assets/global/plugins/amcharts/amcharts/pie.js" type="text/javascript"></script>
        <script src="<?=$path?>assets/global/plugins/amcharts/amcharts/radar.js" type="text/javascript"></script>
        <script src="<?=$path?>assets/global/plugins/amcharts/amcharts/themes/light.js" type="text/javascript"></script>
        <script src="<?=$path?>assets/global/plugins/amcharts/amcharts/themes/patterns.js" type="text/javascript"></script>
        <script src="<?=$path?>assets/global/plugins/amcharts/amcharts/themes/chalk.js" type="text/javascript"></script>
        <script src="<?=$path?>assets/global/plugins/amcharts/ammap/ammap.js" type="text/javascript"></script>
        <script src="<?=$path?>assets/global/plugins/amcharts/ammap/maps/js/worldLow.js" type="text/javascript"></script>
        <script src="<?=$path?>assets/global/plugins/amcharts/amstockcharts/amstock.js" type="text/javascript"></script>
        <script src="<?=$path?>assets/global/plugins/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
        <script src="<?=$path?>assets/global/plugins/horizontal-timeline/horizontal-timeline.js" type="text/javascript"></script>
       
        <script src="<?=$path?>assets/global/plugins/jquery-easypiechart/jquery.easypiechart.min.js" type="text/javascript"></script>
        <script src="<?=$path?>assets/global/plugins/jquery.sparkline.min.js" type="text/javascript"></script>
        <script src="<?=$path?>assets/global/plugins/jqvmap/jqvmap/jquery.vmap.js" type="text/javascript"></script>
        <script src="<?=$path?>assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.russia.js" type="text/javascript"></script>
        <script src="<?=$path?>assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.world.js" type="text/javascript"></script>
        <script src="<?=$path?>assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.europe.js" type="text/javascript"></script>
        <script src="<?=$path?>assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.germany.js" type="text/javascript"></script>
        <script src="<?=$path?>assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.usa.js" type="text/javascript"></script>
        <script src="<?=$path?>assets/global/plugins/jqvmap/jqvmap/data/jquery.vmap.sampledata.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
		<script src="<?=base_url()?>assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
        <script src="<?=$path?>assets/global/scripts/app.min.js" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="<?=$path?>assets/pages/scripts/table-datatables-managed.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="<?=$path?>assets/global/scripts/datatable.js" type="text/javascript"></script>
        <script src="<?=$path?>assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
        <script src="<?=$path?>assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
        <script src="<?=$path?>assets/pages/scripts/dashboard.min.js" type="text/javascript"></script>
        <script src="<?=$path?>assets/pages/scripts/ui-tree.min.js" type="text/javascript"></script>
        
        <script src="<?=$path?>assets/global/plugins/jstree/dist/jstree.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <script src="<?=$path?>assets/layouts/layout/scripts/layout.min.js" type="text/javascript"></script>
        <script src="<?=$path?>assets/layouts/layout/scripts/demo.min.js" type="text/javascript"></script>
        <script src="<?=$path?>assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
        <script src="<?=$path?>assets/layouts/global/scripts/quick-nav.min.js" type="text/javascript"></script>
		
		<script  src="<?=base_url()?>assets/pages/scripts/components-bootstrap-select.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/global/js/magicsuggest.js?<?=time();?>"></script>
<link href="<?php echo base_url(); ?>assets/global/css/magicsuggest.css" rel="stylesheet" type="text/css">
       
        <?php
          $this->load->helper('form');
          $error = $this->session->flashdata('error');
          $success = $this->session->flashdata('success');//success
          if($error)
            {
              echo "<SCRIPT LANGUAGE='javascript'> window.onload = function() {
            toastr.error(`".$this->session->flashdata('error')."`); };</SCRIPT>\n";
            }
          if($success)
           {
            echo "<SCRIPT LANGUAGE='javascript'> window.onload = function() {
              toastr.success(`".$this->session->flashdata('success')."`); };</SCRIPT>\n";
           }
        ?>

        <script type="text/javascript">
            $(document).ready(function()
            {
                $('#clickmewow').click(function()
                {
                    $('#radio1003').attr('checked', 'checked');
                });
            });
            /*$("button[type='submit']").click(function(){
                $(this).attr('disabled','disabled')
            }); */
            //Restrict spaces
            $("input#user_id").on({
            keydown: function(e) {
                if (e.which === 32)
                return false;
            },
            change: function() {
                this.value = this.value.replace(/\s/g, "");
            }
            });

            function WithdrawalAction(w_id,function_name="apprv_withdrawal",status){
                $.ajax({
                    type:"post",
                    url:"<?=base_url()?>common/"+function_name,
                    data:{id:w_id,status:status},
                    success:function(data){
                        //console.log(data);
                        window.location.reload();
                    }
                })
            }
        </script>
        <script>
            jQuery("#conf_pwd").keyup(function () {
            if (jQuery(this).val() != "") {
                if (jQuery(this).val() === jQuery("#new_password").val()) {
                jQuery(this).css("border", "1px solid green");
                jQuery("#new_password").css("border", "1px solid green");
                jQuery(".change_passwoed").removeAttr("disabled");
                } else {
                jQuery(this).css("border", "1px solid red");
                jQuery("#new_password").css("border", "1px solid red");
                jQuery(".change_passwoed").attr("disabled", "disabled");
                }
            }
            });

            jQuery("#new_password").keyup(function () {
            if (jQuery(this).val() != "") {
                if (jQuery(this).val() === jQuery("#conf_pwd").val()) {
                jQuery(this).css("border", "1px solid green");
                jQuery("#conf_pwd").css("border", "1px solid green");
                jQuery(".change_passwoed").removeAttr("disabled");
                } else {
                jQuery(this).css("border", "1px solid red");
                jQuery("#conf_pwd").css("border", "1px solid red");
                jQuery(".change_passwoed").attr("disabled", "disabled");
                }
            }
            });

            $("#changepwd").submit(function (e) {
            e.preventDefault();
            var formdata = new FormData($(this)[0]);
            $.ajax({
                type: "POST",
                url: basepath + "apcompundpower/ispwd",
                data: formdata,
                processData: false,
                contentType: false,
                success: function (data) {
                document.getElementById("demo").innerHTML = data;
                }
            });
            });
        </script>
        <script>
    $(function() {
        var ms1 = $('#ms1').magicSuggest({

            data: []
        });
    });
</script>
    </body>
</html>
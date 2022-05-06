<?php
$path = base_url();
$this->load->helper('comman_helper');
?>

<style>
.select2.select2-container.select2-container--default {
    width: 211px !important;
    float: right;
}
</style>

<!-- Content Wrapper. Contains page content -->
         <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
               <div class="header-icon">
                  <i class="fa fa-shopping-basket"></i>
               </div>
               <div class="header-title">
                  <h1>Share Per (%)</h1>
                  <small>&nbsp;</small>
               </div>
            </section>
            <!-- Main content -->
            <section class="content">
               <div class="row">
                     <div class="col-lg-6 pinpin">
                           <div class="card lobicard lobicard-custom-control"  data-sortable="true"> 
                               <div class="card-header">
                                   <div class="card-title custom_title">
                                       <h4>Share Per (%)</h4>
                                   </div>
                               </div>
                               <div class="card-body">
                                      <form id="mannualroi" name="mannualroi" action="<?=base_url()?>admin/mannualshare_perdata" method="POST">
 
                                        
                                        <div class="form-group">
                                            <label for="user_id">Select Agent</label>
                                            <input type="hidden" name="user_id" id="user_id" value="">
                                            <select class="form-control populate" id="select_usersnot" required >
                                            </select>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="id-number">Enter Reward Share in Percentage</label>
                                            <input type="number" name="mannual_per" id="mannual_per" value="" min="0" step="1" style="float: right;"  required >
                                        </div>
                                       
                                       <div class="form-group">
                                          <button type="submit" class="btn btn-add change_passwoed" id = "mannualroibutton"><i class="fa fa-check"></i> Submit
                                          </button>
                                          <label class="success_msg" style="padding: 9px;margin: 0;" id="demo_share"></label>
                                       </div>
                                    </form>
                                 </div>
                           </div>
                       </div>
                     
                     
                     <div class="col-lg-6 pinpin">
                           <div class="card lobicard lobicard-custom-control"  data-sortable="true">
                               <div class="card-header">
                                   <div class="card-title custom_title">
                                       <h4>Share(%)</h4>
                                   </div>
                               </div>
                               <div class="card-body">
                                    <div class="table-responsive">
                                       <table class="table table-bordered table-hover">
                                          <thead class="back_table_color">
                                             <tr class="info">
                                                <th>#</th>
                                                <th>EMP ID</th>
                                                <th>Per(%)</th>
                                                <th>Created Date</th>
                                                <!--<th>Status</th>-->
                                             </tr>
                                          </thead>
                                          <tbody>
                                               <?php $i = 1;
                              
                                    if (!empty($roi_detailss)) {
                                        foreach ($roi_detailss as $key => $roi) {
                                        //   echo "<pre>"; print_r($team['paid_status']); //die();
                                          
                                            
                                            ?>
                                             <tr>
                                                 <td><?= $i++; ?></td>
                                                <td><?= $roi['emp_id'] ?></td>
                                                <td><?= $roi['share_percentage'] ?></td>
                                                <td><?= $roi['created_date'] ?></td>
                                                 <!--<td>  <?= ($roi['status']==1)?"Active": "Inactive" ?></td>-->
                                             </tr>
                                              <?php } 
                                    } ?>
                                          </tbody>
                                       </table>
                                    </div>
                                 </div>
                           </div>
                       </div>
                     
                     
               </div>
            </section>
            <!-- /.content -->
         </div>
         <!-- /.content-wrapper -->
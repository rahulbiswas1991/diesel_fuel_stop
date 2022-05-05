<? //die("wornking on");

//$this->load->helper('comman_helper');
//echo "<pre>"; print_r($roi_detailss); die();
?>

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
                <li class="active">Reward Share Percentage</li>
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
                      <div class="portlet light bordered">
                          
                          
                        
                        
                     
                     
                     
                     
                     
                     
                     
                     
                     
                     
                    
                    <!--<div class="col-md-12">-->
                    <!--  <div class="portlet light bordered">-->
                        <div class="portlet">  
                        
                       <form id="mannualroi" name="mannualroi" action="<?=base_url()?>apcompundpower/mannualshare_perdata" method="POST">

                        
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">
                                        <strong>Reward Share Percentage</strong> 
                                    </h3>
                                    <div class="pull-right" style="margin-top: -25px;">
                                        <!--<a class="btn btn-info btn-condensed btn-sm" href="-->
                                        <!--    <?php echo base_url();?>apcompundpower/notificationlist">-->
                                        <!--    <i class="fa fa-arrow-left"></i>&nbsp Back-->
                                        <!--</a>-->
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="form-group" style="margin-bottom:25px;">
                                       
                                    </div>
                                    
                                       <div class="row  ">
                                        <div class="col-md-6">
                                            <label class="col-md-4 control-label ">Enter Reward Share in Percentage</label>
                                       </div> 
                                       <div class="col-md-6">
                                          <div class="form-group">
                                        <!--<label>Enter your choice...</label>-->
                                          <div class="input-group">
                                             <!--<input type="hidden" class="form-control" placeholder="Enter Userid" id = "username" name="username" value="">-->
                                             <!--<input type="text" class="form-control populate" placeholder="Enter Userid" id="select_usersnot" name="username" value="">-->
                                             <!--<select class="form-control populate" id="select_usersnot">-->
                                              <input type="text" name="mannual_per" id="mannual_per" value="">
                                              <!--<select class="form-control populate" id="select_usersnot" style = "width: 202px;" >-->
                                              <!--  </select>-->
                                            
                                          </div>
                                         <!--/input-group -->
                                      </div>
                                  </div>
                                  </div>
                                  
                                  <div class = "row">
                                                           <div class="col-md-8 text-center">
                                    <div class="form-group">
                                        <!--<label>Enter your choice...</label>-->
                                        <div class="input-group">
                                            <!--<input type="text" class="form-control" placeholder="Search for..." name="query" value="<?=trim($query)?>">-->
                                            <span class="input-group-btn">
                                                <button class="btn blue " id = "mannualroibutton" type="submit">Send</button>
                                                <!--<a class="btn red" href="<?=base_url()?>"><i class="fa fa-refresh"></i> </a>-->
                                                <!--<button class="btn green" type="button" id="excel_button"><i class="fa fa-file-excel-o"></i> </button>-->
                                            </span>
                                        </div>
                                         <!--/input-group -->
                                    </div>
                                </div>
                                 
                                </div>
                            
                        </form>
                        </div>
                        
                         <!-- Listing for transactions -->
                          <!-- Listing for transactions -->
                <?php //die;
                // if($_POST){
                ?>
                <div class="portlet-body">
                    <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">ROI Percentage</th>
                                
                                <th class="text-center">Created Date</th>
                                
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1;
                              
                                    if (!empty($roi_detailss)) {
                                        foreach ($roi_detailss as $key => $roi) {
                                        //   echo "<pre>"; print_r($team['paid_status']); //die();
                                          
                                            
                                            ?>
                                         <tr class="odd gradeX" id="">
                                             <td>

                                                 <?= $i++; ?>
                                             </td>
                                             <td> <?= $roi['share_percentage'] ?> </td>
                                            
                                             <td>  <?= $roi['created_date'] ?></td>
                                              <td>  <?= $roi['status'] ?></td>
                                            
                                         </tr>
                                     <?php } 
                                    } ?>
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-sm-12 text-right"><?php echo $pagination; ?></div>
                </div>
            </div>
            <?php 
            // } 
            ?>
               
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        </div>
                        </div>
                    </div>
                </div>
               
            </div>
            
        </div>
    </div>
     
    <!--<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.5.3/js/bootstrapValidator.js"></script>-->
    <link href="<?=base_url()?>assets/global/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
    <script src="<?=base_url()?>assets/global/plugins/bootstrapValidator.min.js"></script>
     
    <script type="text/javascript">
    var segment =  <?=$this->uri->segment($this->config->item('uri_segment'))!=''?$this->uri->segment($this->config->item('uri_segment')):0?>;

if(segment=='ManageUser') {
    segment = '';
}

var search_by = '<?=isset($_GET['search_by'])?$_GET['search_by']:''?>';
var startdate = '<?=isset($_GET['startdate'])?$_GET['startdate']:''?>';
var enddate = '<?=isset($_GET['enddate'])?$_GET['enddate']:''?>';
var query     = '<?=isset($_GET['query'])?$_GET['query']:''?>';
    
    
 
 
 
 
 
 
 
 
//  Amount By Date
//   $('#teamsummaryadmin').click(function(){
//           //alert('hlo'); die();
//           $('#teamsummaryadmindata').submit(function(e) {

//                 e.preventDefault();

//                 //alert('hlo'); die();
//                   var userid = $("#userid").val();
//                   //alert(userid); die();

//                 //  var enddate = $("#enddate").val();
       
//                  var url = "<?= base_url(); ?>apcompundpower/teamsummaryadmindata" ;
//       //  var url = basepath + 'user/withdraw_club';
//       //alert(url); die();

//                   $.ajax({

//                           url: url,

//                           type: 'POST',

//                           data: {userid: userid },
           
//                          dataType: 'json',

//                          error: function(data) {
//                               toastr.error('Something Went Wrong, Try again after sometime....');
          
//                          },

//                          success: function(data) {

//                             // alert(data.status); die();
//                              //console.log(data);
//                                   if(data.status == 1) {
//                                          alert(data.teamdata); die();
//                                       // $("#amounttotal").html(data.total_amount);
//                                       // $('#amounttotal').val(data.total_amount);
//                                       }else{
//                                              toastr.error('No data.');
//                                       }
//                         }

//                 });


//          });
 
//  });
 
//  END AMOUNT BY DATE





 $('#achieverdata').click(function(){
        //  alert('hlo'); die();
      $('#achieverstotaldataa').submit(function(e) {

        e.preventDefault();


       
       var url = "<?= base_url(); ?>apcompundpower/achieversdata" ;
      //  var url = basepath + 'user/withdraw_club';
      //alert(url); die();

        $.ajax({

           url: url,

           type: 'POST',

           data: {},
           
           dataType: 'json',

           error: function(data) {
          toastr.error('Something Went Wrong, Try again after sometime....');
          
        },

           success: function(data) {

            //   alert(data); die();
              
              //console.log(data);
                    if(data.status == 1) {
                    //     alert('yes'); die();
                    //   alert(data.total_achievers); die();
                        // $("#amounttotal").html(data.total_amount);
                         //$('#totalachievers').val(data.total_achievers);
                           $('#totalachievers').html(data.total_achievers);
                    }else{
                        alert('hloo'); die();
                         //toastr.error('No Amount.');
                    }
           }

        });


    });

 });

   
    
    
    
    


</script>
<style>
    
  #totalachieversusers { position: relative;  overflow: scroll; }  
    
    
</style>

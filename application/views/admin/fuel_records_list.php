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
                        
                       <!--<form id="mannualroi" name="mannualroi" action="<?=base_url()?>apcompundpower/mannualshare_perdata" method="POST">-->

                        
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">
                                        <strong>Upload Only CSV file for records and share per(%)</strong> 
                                    </h3>
                                    <div class="pull-right" style="margin-top: -25px;">
                                       
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="form-group" style="margin-bottom:25px;">
                                       
                                    </div>
                                    
                                  <div class = "row">
                                 <div class="col-md-8 text-center">
                                    <div class="form-group">
                                        <!--<label>Enter your choice...</label>-->
                                        <div class="input-group">
                                            <!--<input type="text" class="form-control" placeholder="Search for..." name="query" value="<?=trim($query)?>">-->
                                            <span class="input-group-btn">
                                                <div class="col-lg-1"><button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#importModal">Import</button></div>
                                            </span>
                                        </div>
                                         <!--/input-group -->
                                    </div>
                                </div>
                                 
                                </div>
                            
                        <!--</form>-->
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
                                <!--Carrier Name Company Billing Card Acct# PFJ Ascend # Acct TypeGallons-->
                                <th class="text-center">#</th>
                                <th class="text-center">Carrier Name</th>
                                
                                <th class="text-center">Company</th>
                                
                                <th class="text-center">Billing Card</th>
                                <th class="text-center">Acct</th>
                                <th class="text-center">PFJ Ascend</th>
                                <th class="text-center">Acct Type</th>
                                <th class="text-center">Fuel (Gallons)</th>
                                <th class="text-center">share_per</th>
                                <th class="text-center">Total Share</th>
                                <th class="text-center">Date</th>
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
<!--//SELECT `id`, `carrier_name`, `company`, `billing_card`, `acct`, `pfj_ascend`, `acct_type`, `fuel_gallons`, `share_per`, `total_share`, `isactive`, `created_date` FROM `diesel_fuel_records`-->
                                                 <?= $i++; ?>
                                             </td>
                                             <td> <?= $roi['carrier_name'] ?> </td>
                                              <td> <?= $roi['company'] ?> </td>
                                               <td> <?= $roi['billing_card'] ?> </td>
                                                <td> <?= $roi['acct'] ?> </td>
                                                <td> <?= $roi['pfj_ascend'] ?> </td> 
                                                <td> <?= $roi['acct_type'] ?> </td> 
                                                <td> <?= $roi['fuel_gallons'] ?> </td> 
                                                <td> <?= $roi['share_per'] ?> </td>
                                                
                                                <td> <?= $roi['total_share'] ?> </td>
                                                
                                            
                                             <td>  <?= $roi['created_date'] ?></td>
                                            
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
               
                        
                        
     
<!-- Modal -->
  <div class="modal fade" id="importModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" style="color:red;">Upload Csv file Only</h4>
        </div>
        <div class="modal-body">
                
          <form action="<?=base_url()?>apcompundpower/insert_record_sheet" method="post" enctype="multipart/form-data">
			<div class="col-lg-12">
			    
			    <!--//<input type="text" name="aaaa" id="aaaa" value="121212" >-->
				<div class="form-group">
					<input type="file" name="file" id="file" required accept=".csv" />
				</div>
			</div>	
			<div class="col-lg-12">
				<input type="submit" name="submit" value="Upload file" id="upload_btn">
			</div>	
		  </form>
        </div> 
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>                   
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
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




<?php
    $path = base_url();
    //echo '<pre>';print_r($binary_chart_data['Nov']);
     $mthd = $this->router->fetch_method();
?>

<footer class="main-footer">
            <strong> Diesel Fuel Stop </strong>
         </footer>
      </div>
      <!-- /.wrapper -->
      <!-- Start Core Plugins
         =====================================================================-->
        
       
        
        
      <!-- jQuery -->
      
      <script src="<?=base_url()?>assets_diesel/plugins/jQuery/jquery-1.12.4.min.js" ></script>
     <!-- Bootstrap proper -->
     <script src="<?=base_url()?>assets_diesel/bootstrap/js/popper.min.js" ></script>
      <!-- lobicard ui min js -->
      <script src="<?=base_url()?>assets_diesel/plugins/lobipanel/js/jquery-ui.min.js" ></script>
      <!-- lobicard ui touch-punch-improved js -->
      <script src="<?=base_url()?>assets_diesel/plugins/lobipanel/js/jquery.ui.touch-punch-improved.js"></script>
      <!-- lobicard tether min js -->
      <script src="<?=base_url()?>assets_diesel/plugins/lobipanel/js/tether.min.js" ></script>
      <!-- Bootstrap -->
      <script src="<?=base_url()?>assets_diesel/bootstrap/js/bootstrap.min.js" ></script>
      
      
      <script src="<?=$path?>assets/global/plugins/bootstrapValidator.min.js"></script>
         <script src="<?=$path?>assets/global/plugins/bootstrap-toastr/toastr.min.js"></script>
        <script src="<?=$path?>assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js" type="text/javascript"></script>
      
        <script src="<?=$path?>assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
      
        <script src="<?=$path?>assets/global/plugins/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
      <!-- lobicard js -->
      <script src="<?=base_url()?>assets_diesel/plugins/lobipanel/js/lobicard.js" ></script>
      <!-- lobicard highlight js -->
      <script src="<?=base_url()?>assets_diesel/plugins/lobipanel/js/highlight.js" ></script>
      <!-- Pace js -->
      <script src="<?=base_url()?>assets_diesel/plugins/pace/pace.min.js" ></script>
      <!-- NIceScroll -->
      <script src="<?=base_url()?>assets_diesel/plugins/slimScroll/jquery.nicescroll.min.js" ></script>
      <!-- FastClick -->
      <script src="<?=base_url()?>assets_diesel/plugins/fastclick/fastclick.min.js" ></script>
      <!-- CRMadmin frame -->
      <script src="<?=base_url()?>assets_diesel/dist/js/custom.js" ></script>
      <!-- End Core Plugins
         =====================================================================-->
      <!-- Start Page Lavel Plugins
         =====================================================================-->
      <!-- ChartJs JavaScript -->
      <script src="<?=base_url()?>assets_diesel/plugins/chartJs/Chart.min.js" ></script>
      <!-- Counter js -->
      <script src="<?=base_url()?>assets_diesel/plugins/counterup/waypoints.js" ></script>
      <script src="<?=base_url()?>assets_diesel/plugins/counterup/jquery.counterup.min.js" ></script>
      <!-- Monthly js -->
      <script src="<?=base_url()?>assets_diesel/plugins/monthly/monthly.js" ></script>
      <!-- End Page Lavel Plugins
         =====================================================================-->
         
     <!-- table-export js -->
      <script src="<?=base_url()?>assets_diesel/plugins/table-export/tableExport.js" ></script>
      <script src="<?=base_url()?>assets_diesel/plugins/table-export/jquery.base64.js" ></script>
      <script src="<?=base_url()?>assets_diesel/plugins/table-export/html2canvas.js" ></script>
      <script src="<?=base_url()?>assets_diesel/plugins/table-export/sprintf.js" ></script>
      <script src="<?=base_url()?>assets_diesel/plugins/table-export/jspdf.js" ></script>
      <script src="<?=base_url()?>assets_diesel/plugins/table-export/base64.js" ></script>     
         
      <!-- Start Theme label Script
         =====================================================================-->
      <!-- Dashboard js -->
      <script src="<?=base_url()?>assets_diesel/dist/js/dashboard.js" ></script>
      <!-- End Theme label Script
         =====================================================================-->
         
         
          <!--// custom vkp-->
        <input type="hidden" id="searchusername" value="<?=base_url('common/searchusername');?>">                           
        <input type="hidden" id="basepath" value="<?= $path ?>">
        
        <script type="text/javascript">var basepath = $("#basepath").val();</script>
      
         
        <script src="<?=$path?>assets/global/plugins/sweetalert2.min.js"></script>
        <script src="<?=$path?>assets/global/scripts/methadmin.js"></script>
        
        


          <script src="<?=$path?>assets/global/scripts/select2.min.js"></script>
      <script>
         function dash() {
         // single bar chart
         var ctx = document.getElementById("singelBarChart");
         var myChart = new Chart(ctx, {
         type: 'bar',
         data: {
         labels: ["Sun", "Mon", "Tu", "Wed", "Th", "Fri", "Sat"],
         datasets: [
         {
         label: "My First dataset",
         data: [40, 55, 75, 81, 56, 55, 40],
         borderColor: "rgba(0, 150, 136, 0.8)",
         width: "1",
         borderWidth: "0",
         backgroundColor: "rgba(0, 150, 136, 0.8)"
         }
         ]
         },
         options: {
         scales: {
         yAxes: [{
             ticks: {
                 beginAtZero: true
             }
         }]
         }
         }
         });
               //monthly calender
               $('#m_calendar').monthly({
                 mode: 'event',
                 //jsonUrl: 'events.json',
                 //dataType: 'json'
                 xmlUrl: 'events.xml'
             });
         
         //bar chart
         var ctx = document.getElementById("barChart");
         var myChart = new Chart(ctx, {
         type: 'bar',
         data: {
         labels: ["January", "February", "March", "April", "May", "June", "July", "august", "september","october", "Nobemver", "December"],
         datasets: [
         {
         label: "My First dataset",
         data: [65, 59, 80, 81, 56, 55, 40, 65, 59, 80, 81, 56],
         borderColor: "rgba(0, 150, 136, 0.8)",
         width: "1",
         borderWidth: "0",
         backgroundColor: "rgba(0, 150, 136, 0.8)"
         },
         {
         label: "My Second dataset",
         data: [28, 48, 40, 19, 86, 27, 90, 28, 48, 40, 19, 86],
         borderColor: "rgba(51, 51, 51, 0.55)",
         width: "1",
         borderWidth: "0",
         backgroundColor: "rgba(51, 51, 51, 0.55)"
         }
         ]
         },
         options: {
         scales: {
         yAxes: [{
             ticks: {
                 beginAtZero: true
             }
         }]
         }
         }
         });
             //counter
             $('.count-number').counterUp({
                 delay: 10,
                 time: 5000
             });
         }
         dash();         
      </script>
      
      
      
      
<script>
    
    var adcls ="<?php echo $mthd; ?>"; 
    
   // alert(adcls); die();
    
    //$('#status_span_' + user).removeClass("active");
    $('#' + adcls).addClass("active");
</script>

      
   </body>
</html>
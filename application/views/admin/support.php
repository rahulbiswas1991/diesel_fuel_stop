<?php
  $path = base_url();
  $this->load->helper('comman_helper');
  $searchby = '';
    $condition = '';
    $query = '';

    $searchby   = isset($_GET['search_by'])?$_GET['search_by']:'';
    $condition  = isset($_GET['condition'])?$_GET['condition']:'';
    if(isset($_GET['query']) && $_GET['query']!='')
    {
        $query      = $_GET['query'];
    }
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
                                    <a href="Dashboard">Home</a>
                                    <i class="fa fa-circle"></i>
                                </li>
                                <li>
                                    <span>Apps</span>
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
                                <!-- BEGIN TICKET LIST CONTENT -->
                                <div class="app-ticket app-ticket-list">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="portlet light ">
                                                <div class="portlet-title tabbable-line">
                                            <form method="get" action="<?=base_url()?>apcompundpower/support">  
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Search Options</label>
                                                        <select class="form-control" name="search_by">
                                                            <option value="">All</option>
                                                            <option <?=$searchby=='name'?'selected="selected"':'';?> value="name">Name</option>
                                                            <option <?=$searchby=='username'?'selected="selected"':'';?> value="username">Username</option>
                                                            <option <?=$searchby=='email'?'selected="selected"':'';?> value="email">Email</option>
                                                            <option <?=$searchby=='mobile'?'selected="selected"':'';?> value="mobile">Mobile</option>
                                                            <option <?=$searchby=='ticketno'?'selected="selected"':'';?> value="mobile">Ticket No</option>
                                                            <!-- <option>KYC Pending</option> -->
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Select Option</label>
                                                        <select class="form-control" name="condition">
                                                            <option value="">All</option>
                                                            <option <?=$condition==3?'selected="selected"':'';?> value="3">Pending</option>
                                                            <option <?=$condition==1?'selected="selected"':'';?> value="1">Replied</option>
                                                            <option <?=$condition==2?'selected="selected"':'';?> value="2">Resolved</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                    <label>Enter your choice...</label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" placeholder="Search for..." name="query" value="<?=trim($query)?>">
                                                            <span class="input-group-btn">
                                                                <button class="btn blue" type="submit">Search</button>
                                                                <a class="btn red" href="<?=base_url();?>apcompundpower/support"><i class="fa fa-refresh"></i> </a>
                                                                <button class="btn green" type="button" id="excel_button"><i class="fa fa-file-excel-o"></i> </button>
                                                            </span>
                                                        </div>
                                                        <!-- /input-group -->
                                                    </div>
                                                </div>
                                            </form>
                                                </div>
                                                <div class="portlet-body table-scrollable">
                                                    <table class="table table-striped table-bordered table-hover table-checkable order-column" id="suppot_ticket">
                                                        <thead>
                                                            <tr>
                                                              
                                                                <th style="width: 106px"> ID # </th>
                                                                <th>Department </th>
                                                                <th> Subject </th>
                                                                <th> Cust. id </th>
                                                                <th> Cust. Email </th>
                                                                <th> Date/Time </th>
                                                                <th> Status </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach ($tickets as $ticket) {
                                                                echo '
                                                                <tr class="odd gradeX">
                                                              
                                                                <td>
                                                                    <a href="'.base_url().'apcompundpower/support_ticket_detail/'.$ticket['id'].'">#'.$ticket['ticket_no'].'</a>
                                                                </td>
                                                                 <td>'.$ticket['dept'].'</td>
                                                                <td>
                                                                    <a href="'.base_url().'apcompundpower/support_ticket_detail/'.$ticket['id'].'">'.$ticket['subject'].'</a>
                                                                </td>
                                                                <td> '.$ticket['ref_id'].' </td>
                                                                <td>
                                                                    '.$ticket['email'].'
                                                                </td>
                                                                <td class="center"> '.change_date_format($ticket['created_date'],"d-M-Y h:i:s").' </td>
                                                               
                                                                <td>
                                                                ';
                                                                    switch ($ticket['status']) {
                                                                        case 0:
                                                                            echo '<span class="label label-sm label-default"> Pending </span>';
                                                                            break;
                                                                        case 1:
                                                                            echo '<span class="label label-sm label-info"> Replied </span>';
                                                                            break;
                                                                        case 2:
                                                                            echo '<span class="label label-sm label-success"> Resolved </span>';
                                                                            break;
                                                                        case 3:
                                                                            echo '<span class="label label-sm label-warning"> On Hold </span>';
                                                                            break;
                                                                    }
                                                                    echo '
                                                                    
                                                                </td>
                                                            </tr>';
                                                            }
                                                        ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="row">
                                            <div class="col-sm-12 text-right"><?php echo $pagination;?></div>
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

<script type="text/javascript">
    function search_me(){
        alert("dfgdh");
        var a = $(this).val();
        alert(a);
    }
var segment =  <?=$this->uri->segment($this->config->item('uri_segment'))!=''?$this->uri->segment($this->config->item('uri_segment')):0?>;

if(segment=='support')
{
    segment = '';
}

var search_by = '<?=isset($_GET['search_by'])?$_GET['search_by']:0?>';       
var condition = '<?=isset($_GET['condition'])?$_GET['condition']:0?>';
var query     = '<?=isset($_GET['query'])?$_GET['query']:0?>';

document.getElementById("excel_button").onclick = function ()
{
var rowCount = $('#suppot_ticket >tbody >tr').length;
 if(rowCount>0)
  {
    window.open(basepath+"apcompundpower/support_excel/"+segment+"?search_by="+search_by+"&condition="+condition+"&query="+query,"_self");
  }
  else
  {
    alert('No Data');
  }
}   
</script>
    
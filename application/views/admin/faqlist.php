<?php
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
                <div class="page-content-wrapper">
                    <!-- BEGIN CONTENT BODY -->
                    <div class="page-content">
                
                        <div class="page-bar">
                            
                            
                            
                        </div>
                        <!-- END PAGE BAR -->
                        <h1 class="page-title">Frequently asked questions (FAQ)
                        </h1>
                        <!-- END PAGE HEADER-->
                        
                        <div class="row">
                            <div class="col-md-12">
                                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                                <div class="portlet light bordered">
                                    <div class="portlet">

                                        <div class="caption font-dark">
                                         <form method="get" action="<?=base_url()?>apcompundpower/faq">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Search Options</label>
                                                    <select class="form-control" name="search_by" id= "faq_departments">
                                                      <option value="">All</option>
                                                      <?php if(!empty($department))
                                                            {
                                                              foreach ($department as $key => $value) {
                                                    ?>
                                                     <option <?=$searchby==$value['id']?'selected="selected"':'';?>  value="<?=$value['id']?>"><?=$value['title']?></option>
                                                    <?php }}?>
                                                    </select>  
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Type</label>
                                                    <select class="form-control" name="condition">
                                                        <option value="">All</option>
                                                        <option <?=$condition==1?'selected="selected"':'';?> value="1">Active</option>
                                                        <option <?=$condition==2?'selected="selected"':'';?> value="2">Inactive</option>
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
                                                            <a class="btn red" href="<?=base_url()?>apcompundpower/faq"><i class="fa fa-refresh"></i> </a>
                                                            <button class="btn green" type="button" id="excel_button"><i class="fa fa-file-excel-o"></i> </button>
                                                        </span>
                                                    </div>
                                                    <!-- /input-group -->
                                                </div>
                                            </div>
                                            </form>
                                        </div>
                                        </div>
                                    <!-- Form to credir Or debit amount in user wallet -->
                                        <form method="POST" action="<?=base_url('process/add_newfaq')?>" id="add_faqfm">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label >Department</label>
                                                    <select class="form-control populate" id="department_id" name="department_id">
                                                    <?php if(!empty($department))
                                                            {
                                                              foreach ($department as $key => $value) {
                                                    ?>
                                                     <option value="<?=$value['id']?>"><?=$value['title']?></option>
                                                    <?php }}?>
                                                    </select>
                                                </div>
                                                </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Enter Question</label>
                                                    <input type="text" name="question" id="faq_question" class="form-control input-default" placeholder="Enter Question"> </div>
                                                </div>
                                            

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Enter Answer</label>
                                                    <textarea class="form-control" placeholder="Enter Answer....." name="answer" id="faq_answer"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <div class="input-group input-group-default">
                                                        <span class="input-group-btn" id="faqfm_id">
                                                            <button class="btn blue submitbttn" disabled="disabled" type="submit"></i> Add FAQ</button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            </div>
                                        </form>
                    <!-- Listing for transactions -->
                                        <div class="portlet-body">
                                            <table class="table table-striped table-bordered table-hover table-checkable order-column" id="faq_table">
                                            <thead>
                                                <tr>
                                                    <th width="5%">#</th>
                                                    <th width="10%">Department</th>
                                                    <th class="text-center" width="15%">Question</th>
                                                    <th class="text-center" width="30%">Answer</th>
                                                    <th class="text-center" width="15%">Created At</th>
                                                    <th class="text-center" width="5%">Status</th>
                                                    <th class="text-center" width="20%">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                             <?php
                                                  if(!empty($faq))
                                                   { $sno = $row+1;
                                                     foreach ($faq as $key => $value)
                                                      {
                                             ?>
                                                 <tr id="faq_<?=$value['id']?>" data-val="<?=$value['id']?>"> 
                                                   <td width="5%"><?=$sno++?></td>
                                                   <td width="10%" class="department" data-ref="<?=$value['dep_id']?>"><?=$value['title']?></td>
                                                   <td width="15%" class="edquestion"><?=$value['question']?></td>
                                                   <td width="30%" class="edanswer"><?=$value['answer']?></td>
                                                   <td width="15%"><?=change_date_format($value['created_date'],"d M,Y h:i:s")?></td>
                                                   <td width="5%"><?=$value['isactive']==1?'Active':'Inactive'?></td>
                                                   <td width="20%">
                                                     <button id="status_<?=$value['id']?>" class="btn btn-<?=$value['isactive']==1?'success':'warning'?> btn-xs status_change" type="button" data-status="<?=$value['isactive']==1?0:1?>"><?=$value['isactive']==1?'Active':'Inactive'?></button>
                                                     <button class="btn btn-info btn-xs edit_faq submitbttn" disabled="disabled" type="button">Edit</button><button class="btn btn-danger btn-xs delete_faq" type="button">Delete</button></td>
                                                 </tr>
                                            <?php }}?>
                                            </tbody>
                                        </table>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12 text-right"><?php echo $pagination;?></div>
                                        </div>
                                    </div>
                                <!-- END EXAMPLE TABLE PORTLET-->
                                </div>
                            </div>
                        </div>
                    <!-- END CONTENT BODY -->
                    </div>
                    <!-- END CONTENT -->
                </div>
            <!-- END CONTAINER -->
<script type="text/javascript">
var segment =  <?=$this->uri->segment($this->config->item('uri_segment'))!=''?$this->uri->segment($this->config->item('uri_segment')):0?>;

if(segment=='faq')
{
    segment = '';
}

var search_by = '<?=isset($_GET['search_by'])?$_GET['search_by']:0?>';       
var condition = '<?=isset($_GET['condition'])?$_GET['condition']:0?>';
var query     = '<?=isset($_GET['query'])?$_GET['query']:0?>';

document.getElementById("excel_button").onclick = function ()
{
window.open(basepath+"apcompundpower/faq_excel/"+segment+"?search_by="+search_by+"&condition="+condition+"&query="+query,"_self");
}   
</script>
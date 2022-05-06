<?php $this->load->helper('comman_helper');
?>
<style type="text/css">
.portlet.light.bordered {
    overflow: auto;
    height: 375px;
}
</style>
<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content">
        <div class="page-bar">

        </div>
        <!-- END PAGE BAR -->
        <h1 class="page-title"> Network Explorer</h1>
        <div class="row">
            <div class="col-md-12">
                <form id="all_explorer_form" method="post" data-action="<?=base_url()?>process/searchinTree">
                    <input type="hidden" name="type" value="0">
                    <div class="portlet">
                        <div class="col-md-5">
                            <div class="paids_user_title">
                                <h4>All User</h4>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search for..."
                                        name="searchquery">
                                    <span class="input-group-btn">
                                        <button class="btn blue searchtree" type="button" id="">Search</button>
                                        <button class="btn red" type="button" onclick="location.reload();"><i class="fa fa-refresh"></i> </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="portlet light bordered">
                    <div class="portlet-body">
                        <div id="team_tree" class="tree-demo">
                        </div>
                    </div>
                </div>
            </div>

           
        </div>
    </div>
</div>
</div>
<div class="page-content-wrapper">
<!-- BEGIN CONTENT BODY -->
<div class="page-content">
    <!-- BEGIN PAGE HEADER-->

    <!-- BEGIN UPDATE BAR -->
    <?php  Dashboard::updater();  ?>
    <!-- END UPDATE BAR -->
    
    <!-- BEGIN PAGE BAR -->
    <?php echo Dashboard::view("parts/pageBar" , array("main" => "Lighty","title" => "View")) ?>
    <!-- END PAGE BAR -->
    <!-- BEGIN PAGE TITLE-->
    <h3 class="page-title"> 
    <i class="fa fa-sticky-note"></i>
        <span>Views</span>
        <small>What guest should see</small>
    </h3>
    <!-- END PAGE TITLE-->
    <!-- END PAGE HEADER-->
    <div class="row">
        <div class="col-md-6">
            <!-- BEGIN PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-plus font-dark"></i>
                        <span class="caption-subject font-dark bold uppercase">New View</span>
                    </div>
                </div>
                <div class="portlet-body">

                    
                    <div class="note note-success" id="new_view_alert_succes" style="display:none">
                        <h4 class="block"><strong>Success!</strong> The view has been added.</h4>
                        <p> The view created and stored in app/views </p>
                    </div>
                    <div class="alert alert-danger" id="new_view_alert_failed" style="display:none">
                        <strong>Error!</strong> view creation has failed. </div

                    <h4 class="block">View Informations</h4>
                    <form method="post" id="new_view_form">
                        <div class="form-group form-md-line-input form-md-floating-label">
                            <input type="text" class="form-control" name="new_view_file_name" id="new_view_file_name">
                            <label for="new_view_file_name">View name and path</label>
                            <span class="help-block">The name and the path of view file, You can create views in folders, even if they are not existed using '.', for example "user.show"</span>
                        </div>

                        <div class="form-group form-md-radios" style="margin-top: 50px;">
                            <label>Template Engine</label>
                            <div class="md-radio-inline">
                                <div class="md-radio">
                                    <input type="radio" id="radio_atomium" name="new_view_template" class="md-radiobtn" value="atom"  checked="">
                                    <label for="radio_atomium">
                                        <span class="inc"></span>
                                        <span class="check"></span>
                                        <span class="box"></span> Atomium </label>
                                </div>
                                <div class="md-radio">
                                    <input type="radio" id="radio_smarty" name="new_view_template" class="md-radiobtn" value="smart">
                                    <label for="radio_smarty">
                                        <span class="inc"></span>
                                        <span class="check"></span>
                                        <span class="box"></span> Smarty </label>
                                </div>
                                <div class="md-radio">
                                    <input type="radio" id="radio_none" name="new_view_template" class="md-radiobtn" value="nan">
                                    <label for="radio_none">
                                        <span class="inc"></span>
                                        <span class="check"></span>
                                        <span class="box"></span> None </label>
                                </div>
                            </div>
                        </div>

                        <div>
                            <button type="button" class="btn red">Clear</button>
                            <button type="submit" class="btn blue">Create</button>
                        </div>
                    </form>
                </div>
            </div>
            
        </div>
        <div class="col-md-6">
            <!-- BEGIN PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-edit font-dark"></i>
                        <span class="caption-subject font-dark bold uppercase">Views</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-scrollable">
                        <table class="table table-hover table-light">
                            <thead>
                                <tr>
                                    <th> # </th>
                                    <th> View Name </th>
                                    <th> Tempalte Engine </th>
                                    <th> Creation Time </th>
                                </tr>
                            </thead>
                            <tbody id="models_list">
                                <?php \Lighty\Kernel\Dashboard\Views::sort() ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            </div>
    </div>
</div>
<!-- END CONTENT BODY -->
</div>
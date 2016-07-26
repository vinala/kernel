<div class="page-content-wrapper">
<!-- BEGIN CONTENT BODY -->
<div class="page-content">
    <!-- BEGIN PAGE HEADER-->

    <!-- BEGIN UPDATE BAR -->
    <?php  Dashboard::updater();  ?>
    <!-- END UPDATE BAR -->
    
    <!-- BEGIN PAGE BAR -->
    <?php echo Dashboard::view("parts/pageBar" , array("main" => "Lighty","title" => "Controller")) ?>
    <!-- END PAGE BAR -->
    <!-- BEGIN PAGE TITLE-->
    <h3 class="page-title"> 
    <i class="fa fa-random"></i>
        <span>Controllers</span>
        <small>Relate Database with the interface</small>
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
                        <span class="caption-subject font-dark bold uppercase">New Controller</span>
                    </div>
                </div>
                <div class="portlet-body">

                    
                    <div class="note note-success" id="new_controller_alert_succes" style="display:none">
                        <h4 class="block"><strong>Success!</strong> The model has been added.</h4>
                        <p> The model files created and stored in app/models </p>
                    </div>
                    <div class="alert alert-danger" id="new_controller_alert_failed" style="display:none">
                        <strong>Error!</strong> model creation has failed. </div>

                    <h4 class="block">Controller Informations</h4>
                    <form method="post" id="new_controller_form">
                        <div class="form-group form-md-line-input form-md-floating-label">
                            <input type="text" class="form-control" name="new_controller_class_name" id="new_controller_class_name">
                            <label for="form_control_1">Controller name</label>
                            <span class="help-block">The name of controller class will be used</span>
                        </div>

                        <div class="form-group form-md-line-input form-md-floating-label">
                            <input type="text" class="form-control" name="new_controller_file_name" id="new_controller_file_name">
                            <label for="form_control_1">File</label>
                            <span class="help-block">The name of the file to store in controllers folder</span>
                        </div>

                        <div class="md-checkbox">
                            <input type="checkbox" id="new_controller_route" name="new_controller_route" class="md-check">
                            <label for="new_controller_route">
                                <span class="inc"></span>
                                <span class="check"></span>
                                <span class="box"></span> 
                                Add Route
                            </label>
                        </div>

                        <div style="margin-top:40px">
                            <button type="button" class="btn red">Clear</button>
                            <button type="submit" class="btn blue">Add</button>
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
                        <span class="caption-subject font-dark bold uppercase">Controllers</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-scrollable">
                        <table class="table table-hover table-light">
                            <thead>
                                <tr>
                                    <th> # </th>
                                    <th> Controller Name </th>
                                    <th> Creation time </th>
                                </tr>
                            </thead>
                            <tbody id="models_list">
                                <?php \Lighty\Kernel\Dashboard\Controllers::sort() ?>
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
<div class="page-content-wrapper">
<!-- BEGIN CONTENT BODY -->
<div class="page-content">
    <!-- BEGIN PAGE HEADER-->

    <!-- BEGIN UPDATE BAR -->
    <?php  Dashboard::updater();  ?>
    <!-- END UPDATE BAR -->
    
    <!-- BEGIN PAGE BAR -->
    <?php echo Dashboard::view("parts/pageBar" , array("main" => "Lighty","title" => "Model")) ?>
    <!-- END PAGE BAR -->
    <!-- BEGIN PAGE TITLE-->
    <h3 class="page-title"> 
    <i class="fa fa-cloud"></i>
        <span>Models</span>
        <small>Communicating with database</small>
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
                        <span class="caption-subject font-dark bold uppercase">New Model</span>
                    </div>
                </div>
                <div class="portlet-body">

                    
                    <div class="note note-success" id="new_models_alert_succes" style="display:none">
                        <h4 class="block"><strong>Success!</strong> The model has been added.</h4>
                        <p> The model files created and stored in app/models </p>
                    </div>
                    <div class="alert alert-danger" id="new_models_alert_failed" style="display:none">
                        <strong>Error!</strong> model creation has failed. </div

                    <h4 class="block">Model Informations</h4>
                    <form method="post" id="new_model_form">
                        <div class="form-group form-md-line-input form-md-floating-label">
                            <input type="text" class="form-control" name="new_models_class_name" id="new_models_class_name">
                            <label for="form_control_1">Model name</label>
                            <span class="help-block">The name of model class will be used</span>
                        </div>

                        <div class="form-group form-md-line-input form-md-floating-label">
                            <input type="text" class="form-control" name="new_models_table_name" id="new_models_table_name">
                            <label for="form_control_1">Database table</label>
                            <span class="help-block">The data table where data stored(without prefix)</span>
                        </div>

                        <div class="form-group form-md-line-input form-md-floating-label">
                            <input type="text" class="form-control" name="new_models_file_name" id="new_models_file_name">
                            <label for="form_control_1">File</label>
                            <span class="help-block">The name of the file to store in models folder</span>
                        </div>

                        <div style="text-direction:leftyy">
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
                        <span class="caption-subject font-dark bold uppercase">Models</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-scrollable">
                        <table class="table table-hover table-light">
                            <thead>
                                <tr>
                                    <th> # </th>
                                    <th> Model Name </th>
                                    <th> Creation time </th>
                                    <th> Data Table </th>
                                </tr>
                            </thead>
                            <tbody id="models_list">
                                <?php \Lighty\Kernel\Dashboard\Models::sort() ?>
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
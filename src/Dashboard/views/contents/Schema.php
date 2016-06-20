<div class="page-content-wrapper">
<!-- BEGIN CONTENT BODY -->
<div class="page-content">
    <!-- BEGIN PAGE HEADER-->

    <!-- BEGIN PAGE BAR -->
    <?php echo Dashboard::view("parts/pageBar" , array("main" => "Lighty","title" => "Schema")) ?>
    <!-- END PAGE BAR -->
    <!-- BEGIN PAGE TITLE-->
    <h3 class="page-title"> 
    <i class="fa fa-map-signs"></i>
        <span>Schema</span>
        <small>Generate database table</small>
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
                        <span class="caption-subject font-dark bold uppercase">New Schema</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="note note-success" id="new_schema_alert_succes" style="display:none">
                        <h4 class="block"><strong>Success!</strong> The schema has been added.</h4>
                        <p> The schema created and stored in database/schema </p>
                    </div>

                    <div class="alert alert-danger" id="new_schema_alert_failed" style="display:none">
                        <strong>Error!</strong> schema creation has failed. </div>

                    <h4 class="block">Schema Informations</h4>
                    <form method="post" id="new_schema_form">
                        <div class="form-group form-md-line-input form-md-floating-label">
                            <input type="text" class="form-control" name="migname" id="migname">
                            <label for="form_control_1">Schema name</label>
                            <span class="help-block">The name of Schema will be used</span>
                        </div>

                        <div style="text-direction:leftyy">
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
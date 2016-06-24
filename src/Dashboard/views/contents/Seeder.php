<div class="page-content-wrapper">
<!-- BEGIN CONTENT BODY -->
<div class="page-content">
    <!-- BEGIN PAGE HEADER-->

    <!-- BEGIN PAGE BAR -->
    <?php echo Dashboard::view("parts/pageBar" , array("main" => "Lighty","title" => "Seeder")) ?>
    <!-- END PAGE BAR -->
    <!-- BEGIN PAGE TITLE-->
    <h3 class="page-title"> 
    <i class="fa fa-leaf"></i>
        <span>Seeders</span>
        <small>To insert initial data in database</small>
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
                        <span class="caption-subject font-dark bold uppercase">Create seeder</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="note note-success" id="make_seeder_alert_succes" style="display:none">
                        <h4 class="block"><strong>Success!</strong> The seeder has been generated.</h4>
                        <p> The seeder generated and stored in database/seeds </p>
                    </div>

                    <div class="alert alert-danger" id="make_seeder_alert_failed" style="display:none">
                        <strong>Error!</strong> seeder creation has failed. </div>

                    <form method="post" id="new_seeder_form">
                        <div class="form-group form-md-line-input form-md-floating-label">
                            <input type="text" class="form-control" name="seed_name" id="seed_name">
                            <label for="form_control_1">Seeder name</label>
                            <span class="help-block">The name of seeder class will be used</span>
                        </div>

                        <div class="form-group form-md-line-input form-md-floating-label">
                            <input type="text" class="form-control" name="seed_table" id="seed_table">
                            <label for="form_control_1">Database table</label>
                            <span class="help-block">The data table where data will be stored(without prefix)</span>
                        </div>

                        <div class="form-group form-md-line-input form-md-floating-label">
                            <input type="text" class="form-control" name="seed_count" id="seed_count">
                            <label for="form_control_1">Count rows</label>
                            <span class="help-block">Who much rows to insert</span>
                        </div>

                        <div>
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
                        <span class="caption-subject font-dark bold uppercase">Seeders</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-scrollable">
                        <table class="table table-hover table-light">
                            <thead>
                                <tr>
                                    <th> # </th>
                                    <th> Seeder File </th>
                                    <th> Creation time </th>
                                </tr>
                            </thead>
                            <tbody id="models_list">
                                <?php 
                                \Lighty\Kernel\Dashboard\Seeder::sort() 
                                ?>
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
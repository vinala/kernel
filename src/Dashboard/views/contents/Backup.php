<div class="page-content-wrapper">
<!-- BEGIN CONTENT BODY -->
<div class="page-content">
    <!-- BEGIN PAGE HEADER-->

    <!-- BEGIN UPDATE BAR -->
    <?php  Dashboard::updater();  ?>
    <!-- END UPDATE BAR -->

    <!-- BEGIN PAGE BAR -->
    <?php echo Dashboard::view("parts/pageBar" , array("main" => "Lighty","title" => "Backup")) ?>
    <!-- END PAGE BAR -->
    <!-- BEGIN PAGE TITLE-->
    <h3 class="page-title"> 
    <i class="fa fa-history"></i>
        <span>Backup</span>
        <small>Make Backup of Database</small>
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
                        <span class="caption-subject font-dark bold uppercase">Create backup</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="note note-success" id="make_backup_alert_succes" style="display:none">
                        <h4 class="block"><strong>Success!</strong> The backup has been generated.</h4>
                        <p> The backup generated and stored in database/backup </p>
                    </div>

                    <div class="alert alert-danger" id="make_backup_alert_failed" style="display:none">
                        <strong>Error!</strong> backup creation has failed. </div>

                    <form method="post" id="make_backup_form">
                        <button class="btn blue btn-block">Genrate</button>
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
                        <span class="caption-subject font-dark bold uppercase">Schema</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-scrollable">
                        <table class="table table-hover table-light">
                            <thead>
                                <tr>
                                    <th> # </th>
                                    <th> BackUp File </th>
                                    <th> Creation time </th>
                                </tr>
                            </thead>
                            <tbody id="models_list">
                                <?php \Lighty\Kernel\Dashboard\Backup::sort() ?>
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
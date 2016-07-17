<div class="page-content-wrapper">
<!-- BEGIN CONTENT BODY -->
<div class="page-content">
    <!-- BEGIN PAGE HEADER-->

    <!-- BEGIN PAGE BAR -->
    <?php echo Dashboard::view("parts/pageBar" , array("main" => "Lighty","title" => "Translator")) ?>
    <!-- END PAGE BAR -->
    <!-- BEGIN PAGE TITLE-->
    <h3 class="page-title"> 
    <i class="fa fa-flag"></i>
        <span>Translator</span>
        <small>where application can talk many language</small>
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
                        <span class="caption-subject font-dark bold uppercase">New Translator</span>
                    </div>
                </div>
                <div class="portlet-body">

                    
                    <div class="note note-success" id="new_lang_alert_succes" style="display:none">
                        <h4 class="block"><strong>Success!</strong> The language file has been added.</h4>
                        <p> The language file created and stored in app/lang </p>
                    </div>
                    <div class="alert alert-danger" id="new_lang_alert_failed" style="display:none">
                        <strong>Error!</strong> language file creation has failed. </div

                    <h4 class="block">File Informations</h4>
                    <form method="post" id="new_lang_form">
                        <div class="form-group form-md-line-input form-md-floating-label">
                            <input type="text" class="form-control" name="lang_name" id="lang_name">
                            <label for="lang_name">File and folder name</label>
                            <span class="help-block">The name of folder and language file separted by '.' like "en.profile"  </span>
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
                        <span class="caption-subject font-dark bold uppercase">Translators</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-scrollable">
                        <table class="table table-hover table-light">
                            <thead>
                                <tr>
                                    <th> # </th>
                                    <th> Translator path</th>
                                    <th> Creation Time </th>
                                </tr>
                            </thead>
                            <tbody id="models_list">
                                <?php \Lighty\Kernel\Dashboard\Translator::sort() ?>
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
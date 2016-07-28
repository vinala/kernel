<div class="page-content-wrapper">
<!-- BEGIN CONTENT BODY -->
<div class="page-content">
    <!-- BEGIN PAGE HEADER-->

    <!-- BEGIN UPDATE BAR -->
    <?php  Dashboard::updater();  ?>
    <!-- END UPDATE BAR -->

    <!-- BEGIN PAGE BAR -->
    <?php echo Dashboard::view("parts/pageBar" , array("main" => "Lighty","title" => "Plugin")) ?>
    <!-- END PAGE BAR -->
    <!-- BEGIN PAGE TITLE-->
    <h3 class="page-title"> 
    <i class="icon-handbag"></i>
        <span>Plugin</span>
        <small>what else</small>
    </h3>
    <!-- END PAGE TITLE-->
    <!-- END PAGE HEADER-->
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <span class="caption-subject font-dark bold uppercase">General</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <?php $data = \Lighty\Kernel\Dashboard\Plugins::get_store(); ?>

                    <div class="mt-element-card mt-element-overlay">
                        <div class="row">

                            <?php foreach ($data as $item) : ?>
                                <a href="../<?php echo Config::get('dashboard.route') ?>/plugin/<?php echo $item["name"] ?>" class="plugin_link">
                                    <div class="col-lg-2 col-md-2 col-sm-6 col-xs-6">
                                        <div class="mt-card-item">
                                            <div class="mt-card-avatar mt-overlay-1" style="border-bottom: 4px solid <?php echo $item["color"] ?>;">
                                                <img src="../vendor/lighty/kernel/src/Dashboard/assets/pages/img/avatars/team<?php echo $item["image"]; ?>.jpg">
                                                <div class="mt-overlay"></div>
                                            </div>
                                            <div class="mt-card-content">
                                                <h3 class="mt-card-name"><?php echo $item["name"] ?></h3>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            <?php endforeach; ?>

                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
<!-- END CONTENT BODY -->
</div>
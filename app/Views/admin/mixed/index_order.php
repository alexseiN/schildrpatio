<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container-xxl">
            <div class="card mb-5 mb-xl-10">
                <div class="card-header cursor-pointer">
                    <div class="card-title m-0">
                        <h3 class="fw-bolder m-0">Project files</h3>
                    </div>
                </div>
                <div class="card-body p-9">
                    <div class="row mb-7">
                        <?php foreach ($features as $cat) { ?>
                        <?php
                            $itemid = $cat->id;
                            $main = get_langer('features',$admin_lang,$itemid);
                            $category = get_langer('pdcats',$admin_lang,$main->category_id);
                            $parent = get_langer('pdcats',$admin_lang,$category->parent_id);
                            $morefiles = morefiles('features',$itemid);
                        ?>
                        
                        <div class="col-lg-12 mb-5">
                            <span class="fw-bolder fs-1 text-dark-800 mb-3"><?=$parent->title?> - <?=$category->title?></span>
                        </div>
                        <div class="col-lg-12 mb-5">
                            <span class="fw-bolder fs-4 text-gray-500"><?=$main->title?></span>
                        </div>
                        <?php foreach($morefiles as $file) { ?>
                        <!--begin::Col-->
                        <div class="col-xl-3">
                            <div class="pt-1">
                                <div class="mixed-widget-4-chart" data-kt-chart-color="success" style="height: 200px; min-height: 178.7px;">
                                    <img src="assets/uploads/features/<?=$file->filename?>" style="width:100%;height:100%"> 
                                </div>
                            </div>
                            <div class="pt-5">
                                <span class="fw-normal fs-6 text-gray-800"><?=$file->description?></span>
                            </div>
                            <div class="pt-5">
                                <a href="<?=$file->link?>" class="btn btn-sm btn-primary"><span class="fw-normal fs-6">DOWNLOAD</span></a>
                            </div>
                        </div>
                        <!--end::Col-->
                        <?php } ?>
                        
                        <div class="col-lg-12 my-10" style="border-radius: 0 0 calc(0.475rem - 1px) calc(0.475rem - 1px);border-top: 1px solid #eff2f5;"></div>
    
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
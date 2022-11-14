<?php
    $result_data = isset($id)?$thisItems[0]:$thisItems;
    $counter = 0;
    error_reporting(0);
?>
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
            <!--begin::Form-->
            <?=view('admin/includes/common/errors')?>
            <?=form_open_multipart('', 'class="form d-flex flex-column flex-lg-row editform" id="editform" name="editform"')?>
                <!--begin::Aside column-->
                <div class="d-flex flex-column gap-7 gap-lg-10 w-300px w-lg-300px mb-7 me-lg-10">
                    <?php
                        $img = !isset($result_data->image)?$noimage:base_url($uploadFolder.'/small/'.$result_data->image);
                        $imagedata = [
                            "label" => 'Main Image',
                            "noimage" => $noimage,
                            "image" => $img,
                            "name" => 'image',
                            "value" => $result_data->image,
                            "description" => 'Allowed file types: png, jpg, jpeg.'
                        ];
                        echo view('admin/includes/common/image',$imagedata);
                        //pp($imagedata);
                    ?>
                </div>
                <!--end::Aside column-->
                <!--begin::Main column-->
                <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                    
                    <!--begin::General options-->
                    <div class="card card-flush py-4">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <div class="card-title">
                                <h2>General</h2>
                            </div>
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0">                 
                            <!--begin::Input group-->            
                            <div class="mb-10 fv-row">                                            
                            <?php                                
                                foreach($all_categories as $all_category){
                                    $coptions[$all_category->id] = $all_category->title;                                    
                                }                                 
                                $data = [
                                    "label"          => "Categories",
                                    "label_required" => "",
                                    "type"           => "select",
                                    "type_data"      => [
                                        'name'  => 'category',
                                        'options'  => $coptions,
                                        'value' => $result_data->category,
                                    ]
                                ];
                                echo html_form_tags($data);
                            ?>
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->            
                            <div class="mb-10 fv-row">
                                <?php
                                    foreach($all_products as $all_product){
                                        $poptions = array();
                                        if(isset($all_product['children'])){
                                            foreach($all_product['children'] as $child){
                                                $poptions[$child['id']] = $child['title'];
                                            }
                                        }
                                        $options[$all_product['title']] = $poptions;                                    
                                    }                                   
                                    $avalue = explode(",",$result_data->seproducts);                                    
                                    $data = [
                                        "label"          => "Products",
                                        "label_required" => "",
                                        "type"           => "selectmultiple",
                                        "type_data"      => [
                                            'name'  => 'seproducts[]',
                                            'options'  => $options,
                                            'value' => $avalue,
                                        ]
                                    ];
                                    echo html_form_tags($data);
                                ?>                                  
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->            
                            <div class="mb-10 fv-row">                                            
                            <?php                                
                                foreach($employees as $employee){
                                    $eoptions[$employee->id] = $employee->first_name.' '.$employee->last_name;
                                }                                 
                                $data = [
                                    "label"          => "Project manager",
                                    "label_required" => "",
                                    "type"           => "select",
                                    "type_data"      => [
                                        'name'  => 'pm',
                                        'options'  => $eoptions,
                                        'value' => $result_data->pm,
                                    ]
                                ];
                                echo html_form_tags($data);
                            ?>
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="mb-10 fv-row">
                                <?php                               
                                    $data = [
                                        "label"          => "Project Zip Code",
                                        "label_required" => "",
                                        "type"           => "input",
                                        "type_data"      => [
                                            'type'  => 'text',
                                            'name'  => 'pzipcode',
                                            'id'    => '',
                                            'value' => $result_data->pzipcode,
                                        ]
                                    ];
                                    echo html_form_tags($data);
                                ?>
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="mb-5 fv-row">
                                <?php                               
                                    $data = [
                                        "label"          => "Coordinates",
                                        "label_required" => "",
                                        "type"           => "input",
                                        "type_data"      => [
                                            'type'  => 'text',
                                            'name'  => 'map_address',
                                            'id'    => 'autocomplete',
                                            'value' => '',
                                        ]
                                    ];
                                    echo html_form_tags($data);
                                ?>
                                <?php                               
                                    $data = [
                                        "label"          => "",
                                        "label_required" => "",
                                        "type"           => "input",
                                        "type_data"      => [
                                            'type'  => 'hidden',
                                            'name'  => 'gps',
                                            'id'    => 'inputGps',
                                            'value' => $result_data->gps,
                                        ]
                                    ];
                                    echo html_form_tags($data);
                                ?>
                            </div>
                            <div class="gmap" id="mapsAddress" class="mb-10 fv-row"></div>
                            <!--end::Input group-->                            
                        </div>
                        <!--end::Card header-->
                    </div>
                    <!--end::General options-->
                    <!--begin:::Tabs-->
                    <div>
                    <?=view('admin/includes/common/langstab')?>
                    <!--end:::Tabs-->
                    <div class="tab-content">
                        <?php
                            $counter_1_check = 1;
                            foreach($ThisModule->languages as $key_lang=>$val_lang) {
                            $language_data = get_admin_conn_lang($_lang_table_names,$id,$key_lang);
                            //pp($language_data,false);
                        ?>
                        <!--begin::Tab pane-->
                        <div class="tab-pane fade <?=($counter_1_check == 1)?'active show':''?>" id="tab_<?=$counter_1_check?>" role="tab-panel">
                            <div class="d-flex flex-column gap-7 gap-lg-10">
                                <!--begin::General options-->
                                <div class="card card-flush rounded-0 py-4">
                                    <!--begin::Card body-->
                                    <div class="card-body pt-5">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <?php                                                                           
                                                $data = [
                                                    "label"          => "Title",
                                                    "label_required" => "",
                                                    "type"           => "input",
                                                    "type_data"      => [
                                                        'type'  => 'text',
                                                        'name'  => 'title_'.$key_lang,
                                                        'id'    => '',
                                                        'value' => trim($language_data->title),
                                                        'onkeyup' => 'return slugme(this)',
                                                        'data-key' => $key_lang
                                                    ]
                                                ];
                                                echo html_form_tags($data);
                                            ?>
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <?php                                                                           
                                                $data = [
                                                    "label"          => "Slug",
                                                    "label_required" => "",
                                                    "type"           => "input",
                                                    "type_data"      => [
                                                        'type'  => 'text',
                                                        'name'  => 'slug_'.$key_lang,
                                                        'id'    => 'inputSlug_'.$key_lang,
                                                        'value' => $language_data->slug,
                                                    ]
                                                ];
                                                echo html_form_tags($data);                                                
                                            ?>
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row" id="quillarea_<?=$counter_1_check?>">
                                            <?php                                                                           
                                                $data = [
                                                    "label"          => "About",
                                                    "label_required" => "",
                                                    "type"           => "textarea",
                                                    "type_data"      => [
                                                        'name'  => 'body_'.$key_lang,
                                                        'id'    => 'form_editor_'.$counter_1_check,
                                                        'value' => $language_data->body,
                                                        'class' => 'form-control form-control-solid form_editor form_editor_'.$counter_1_check,
                                                        'rows'  => '4',
                                                        'data-counter'  => $counter_1_check
                                                    ]
                                                ];
                                                echo html_form_tags($data);
                                            ?>
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <?php                                                                           
                                                $data = [
                                                    "label"          => "Keywords",
                                                    "label_required" => "",
                                                    "type"           => "input",
                                                    "type_data"      => [
                                                        'type'  => 'text',
                                                        'id'    => 'keywords_'.$counter_1_check,
                                                        'value' => $language_data->keywords,
                                                        'class' => 'form-control tags keywords_'.$counter_1_check,
                                                    ]
                                                ];
                                                echo html_form_tags($data);
                                                $data_hidden = [
                                                        'type'  => 'hidden',
                                                        'name'  => 'keywords_'.$key_lang,
                                                        'id'    => 'hidden_keywords_'.$counter_1_check,
                                                        'value' => $language_data->keywords,
                                                ];
                                                echo form_input($data_hidden);
                                            ?>
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <?php                                                                           
                                                $data = [
                                                    "label"          => "Meta Description",
                                                    "label_required" => "",
                                                    "type"           => "textarea",
                                                    "type_data"      => [
                                                        'type'  => 'text',
                                                        'name'  => 'short_description_'.$key_lang,
                                                        'id'    => '',
                                                        'value' => trim($language_data->short_description),
                                                    ]
                                                ];
                                                echo html_form_tags($data);
                                            ?>
                                        </div>
                                        <!--end::Input group-->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php $counter_1_check++;} ?>
                    </div>
                    </div>
                    <?=view('admin/includes/common/button')?>
                </div>
                <!--end::Main column-->
            <?=form_close()?>
            <?=view('admin/includes/common/media')?>
            <?=view('admin/project/pstatus')?>
            <!--end::Form-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Post-->
</div>

<script src="//maps.googleapis.com/maps/api/js?key=AIzaSyD85IqNDTQt5gqc-EHf2ZBnpsYtfd1R1wE" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gmap3/5.1.1/gmap3.min.js"></script>
<script type="text/javascript">
    var timerMap;
    var firstSet = false;
    var savedGpsData;
    $(function () {
        if($('#inputGps').length && $('#inputGps').val() != ''){
            savedGpsData = $('#inputGps').val().split(", ");
            $("#mapsAddress").gmap3({
                map:{
                    options:{
                        center: [parseFloat(savedGpsData[0]), parseFloat(savedGpsData[1])],
                        zoom: 14
                    }
                },
                marker:{
                    values:[
                        {latLng:[parseFloat(savedGpsData[0]), parseFloat(savedGpsData[1])]},
                    ],
                    options:{
                        draggable: true
                    },
                    events:{
                        dragend: function(marker){
                            $('#inputGps').val(marker.getPosition().lat()+', '+marker.getPosition().lng());
                        }
                    }
                }
            });
            firstSet = true;
        }
        else {
            $("#mapsAddress").gmap3({
                map:{
                    options:{
                        center: [<?php echo isset($thisItems->gps)?$thisItems->gps:'40.730610, -73.935242'?>],
                        zoom: 8
                    },
                }
            });
        }
        $('#autocomplete').keyup(function (e) {
            clearTimeout(timerMap);
            timerMap = setTimeout(function () {
                $("#mapsAddress").gmap3({
                    getlatlng:{
                        address:  $('#autocomplete').val(),
                        callback: function(results){
                            if ( !results ){
                                alert('Bad address!');
                                return;
                            }
                            if(firstSet){
                                $(this).gmap3({
                                    clear: {
                                        name:["marker"],
                                        last: true
                                    }
                               });
                            }
                           $(this).gmap3({
                                marker:{
                                    latLng:results[0].geometry.location,
                                    options: {
                                        id:'searchMarker',
                                        draggable: true
                                    },
                                    events: {
                                        dragend: function(marker){
                                            $('#inputGps').val(marker.getPosition().lat()+', '+marker.getPosition().lng());
                                        }
                                    }
                                }
                            });
                            // Center map
                            $(this).gmap3('get').setCenter( results[0].geometry.location );
                            $('#inputGps').val(results[0].geometry.location.lat()+', '+results[0].geometry.location.lng());
                            firstSet = true;
                        }
                    }
                });
            }, 2000);
        });
        tagfunction();
        quillfunction();
        
    });
    function slugme(selfvar){
         var text = $(selfvar).val();
         var key = $(selfvar).attr('data-key');
         $.ajax({
            type:"POST",
            url:"<?=$_cancel.'/slugifier'?>",
            data:{text:text},
            success:function(data){
                $('#inputSlug_'+key).val(data);
            }
        });
    }
</script>
<style>
    .gmap{
        margin:10px auto;
        border:1px dashed #C0C0C0;
        width:100%;
        height:250px;
    }
</style>
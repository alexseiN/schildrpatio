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
                                foreach($region_list as $regions){
                                    $coptions = array();
                                    foreach($regions['children'] as $child){
                                        $coptions[$child['id']] = $child['title'];
                                    }
                                    $options[$regions['title']] = $coptions;                                    
                                }                                
                                $data = [
                                    "label"          => "Country",
                                    "label_required" => "required",
                                    "type"           => "select",
                                    "type_data"      => [
                                        'name'  => 'region_id',
                                        'options'  => $options,
                                        'value' => $result_data->region_id,
                                    ]
                                ];
                                echo html_form_tags($data);
                            ?>
                            </div>
                            <!--end::Input group-->                            
                            <!--begin::Input group-->            
                            <div class="mb-10 fv-row">                                            
                            <?php                                
                                $options = [
                                    "sales" => "Sales",
                                    "manufacture" => "Manufacture",
                                    "partner" => "Partner",
                                    "main" => "Main",
                                ];                                
                                $data = [
                                    "label"          => "Organisation Type",
                                    "label_required" => "required",
                                    "type"           => "select",
                                    "type_data"      => [
                                        'name'  => 'ortype',
                                        'options'  => $options,
                                        'value' => $result_data->ortype,
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
                                        "label"          => "Metric",
                                        "label_required" => "",
                                        "type"           => "input",
                                        "type_data"      => [
                                            'type'  => 'text',
                                            'name'  => 'metric',
                                            'id'    => '',
                                            'value' => $result_data->metric,
                                        ]
                                    ];
                                    echo html_form_tags($data);
                                ?>
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->            
                            <div class="mb-10 fv-row">                                            
                            <?php
                                
                                foreach($all_currencies as $currency){
                                    $c_options[$currency->id] = $currency->name;                                    
                                }                                
                                $data = [
                                    "label"          => "Currency",
                                    "label_required" => "",
                                    "type"           => "select",
                                    "type_data"      => [
                                        'name'  => 'currency',
                                        'options'  => $c_options,
                                        'value' => $result_data->currency,
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
                                        "label"          => "Time Difference",
                                        "label_required" => "",
                                        "type"           => "input",
                                        "type_data"      => [
                                            'type'  => 'number',
                                            'name'  => 'diff',
                                            'id'    => '',
                                            'value' => $result_data->diff,
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
                                        "label"          => "C1GGCM",
                                        "label_required" => "",
                                        "type"           => "input",
                                        "type_data"      => [
                                            'type'  => 'text',
                                            'name'  => 'reg',
                                            'id'    => '',
                                            'value' => $result_data->reg,
                                            'readonly'  => 'readonly',
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
                                        "label"          => "C2GGCM",
                                        "label_required" => "",
                                        "type"           => "input",
                                        "type_data"      => [
                                            'type'  => 'text',
                                            'name'  => 'city',
                                            'id'    => '',
                                            'value' => $result_data->city,
                                            'readonly'  => 'readonly',
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
                            <!--begin::Input group-->
                            <div class="mb-10 fv-row">
                                <?php                               
                                    $data = [
                                        "label"          => "Company name",
                                        "label_required" => "",
                                        "type"           => "input",
                                        "type_data"      => [
                                            'type'  => 'text',
                                            'name'  => 'name',
                                            'id'    => '',
                                            'value' => $result_data->name,
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
                                        "label"          => "Branch name",
                                        "label_required" => "",
                                        "type"           => "input",
                                        "type_data"      => [
                                            'type'  => 'text',
                                            'name'  => 'bname',
                                            'id'    => '',
                                            'value' => $result_data->bname,
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
                                        "label"          => "Code",
                                        "label_required" => "",
                                        "type"           => "input",
                                        "type_data"      => [
                                            'type'  => 'text',
                                            'name'  => 'code',
                                            'id'    => '',
                                            'value' => $result_data->code,
                                        ]
                                    ];
                                    echo html_form_tags($data);
                                ?>
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="mb-10 fv-row" id="quillarea_<?=$counter?>">
                                <?php                                                                           
                                    $data = [
                                        "label"          => "Requisite",
                                        "label_required" => "",
                                        "type"           => "textarea",
                                        "type_data"      => [
                                            'name'  => 'requisite',
                                            'id'    => 'form_editor_'.$counter,
                                            'value' => $result_data->requisite,
                                            'class' => 'form-control form-control-solid form_editor form_editor_'.$counter,
                                            'rows'  => '4',
                                            'data-counter'  => $counter
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
                                        "label"          => "Phones",
                                        "label_required" => "",
                                        "type"           => "input",
                                        "type_data"      => [
                                            'type'  => 'text',
                                            'id'    => 'tags_'.$counter,
                                            'value' => $result_data->phones,
                                            'class' => 'form-control tags tags_'.$counter,
                                        ]
                                    ];
                                    echo html_form_tags($data);
                                    $data_hidden = [
                                            'type'  => 'hidden',
                                            'name'  => 'phones',
                                            'id'    => 'hidden_tags_'.$counter,
                                            'value' => $result_data->phones,
                                    ];
                                    echo form_input($data_hidden);
                                ?>
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="mb-10 fv-row">
                                <?php                                                                           
                                    $data = [
                                        "label"          => "Zip Ranges",
                                        "label_required" => "",
                                        "type"           => "input",
                                        "type_data"      => [
                                            'type'  => 'text',
                                            'id'    => 'tags_1',
                                            'value' => $result_data->zipranges,
                                            'class' => 'form-control tags tags_1',
                                        ]
                                    ];
                                    echo html_form_tags($data);
                                    $data_hidden = [
                                            'type'  => 'hidden',
                                            'name'  => 'zipranges',
                                            'id'    => 'hidden_tags_1',
                                            'value' => $result_data->zipranges,
                                    ];
                                    echo form_input($data_hidden);
                                ?>
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="mb-10 fv-row">
                                <?php                               
                                    $data = [
                                        "label"          => "Branch email",
                                        "label_required" => "",
                                        "type"           => "input",
                                        "type_data"      => [
                                            'type'  => 'email',
                                            'name'  => 'email',
                                            'id'    => '',
                                            'value' => $result_data->email,
                                        ]
                                    ];
                                    echo html_form_tags($data);
                                ?>
                            </div>
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
                                                    "label"          => "Official Address",
                                                    "label_required" => "",
                                                    "type"           => "input",
                                                    "type_data"      => [
                                                        'type'  => 'text',
                                                        'name'  => 'address_'.$key_lang,
                                                        'id'    => '',
                                                        'value' => $language_data->address,
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
                                                    "label"          => "About Branch",
                                                    "label_required" => "",
                                                    "type"           => "textarea",
                                                    "type_data"      => [
                                                        'name'  => 'about_'.$key_lang,
                                                        'id'    => 'form_editor_'.$counter_1_check,
                                                        'value' => $language_data->about,
                                                        'class' => 'form-control form-control-solid form_editor form_editor_'.$counter_1_check,
                                                        'rows'  => '4',
                                                        'data-counter'  => $counter_1_check
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
</script>
<style>
    .gmap{
        margin:10px auto;
        border:1px dashed #C0C0C0;
        width:100%;
        height:250px;
    }
</style>
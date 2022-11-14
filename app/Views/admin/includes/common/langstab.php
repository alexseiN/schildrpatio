<ul class="nav nav-tabs">
                        <?php $counter_check = 1;foreach($this->data['ThisModule']->languages_icon as $key_lang=>$val_lang) { ?>
                        <!--begin:::Tab item-->
                        <li class="nav-item">
                            <a class="nav-link rounded-0 px-6 py-4 <?=($counter_check == 1)?'active':''?>" data-bs-toggle="tab" href="#tab_<?=$counter_check?>">
                                <img src="<?php echo base_url('assets/uploads/language/full').'/'.$val_lang; ?>" title="<?=$key_lang?>"  width="30" height="15"  >
                            </a>
                        </li>
                        <!--end:::Tab item-->
                        <?php $counter_check++;} ?>
                    </ul>
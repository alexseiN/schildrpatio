<?php

namespace App\Controllers\Manage;

use App\Core\Admincontroller;
use App\Models\backend\Setprojectsmodel;

class Setproject extends Admincontroller {
    public $_table_names = 'setproject';			//set table name
    public $_subView = 'admin/setproject/';		//set subview
    public $_redirect = '/setproject';				//set controller link
    

    protected $CurrencyModel;

    public function __construct(){
        parent::__construct();

        $this->SetprojectsModel = new Setprojectsmodel();

        $this->data['ThisModule'] = $this->SetprojectsModel;
        $this->data['CommanModel'] = $this->CommanModel;

        //set left menu active on admin dashboard
        $this->data['active'] = 'Invoice management';
        $this->data['withoutlang'] = 1;
        
        //set link with function name
        $this->data['_edit'] = $this->data['admin_link'].$this->_redirect.'/edit';
        $this->data['_cancel'] = $this->data['admin_link'].$this->_redirect;
        $this->data['_delete'] = $this->data['admin_link'].$this->_redirect.'/delete';


        $this->data['employees'] = $this->CommanModel->get_lang('employees',false,false,array('rep'=>1),'connlang_id',FALSE);

	$this->data['branches'] = $this->CommanModel->get_lang('branches',false,false,array(),'connlang_id',FALSE);
        $this->data['pdcats'] = $this->CommanModel->get_lang('pdcats',$this->data['admin_lang'],false,array(),'connlang_id',FALSE);

	
	foreach($this->data['branches'] as $branch){
	    $branches[$branch->id] = $branch->name;
	}

	foreach($this->data['employees'] as $employee){
	    $employees[$employee->id] = $employee->first_name.' '.$employee->last_name;
	}
	
	foreach($this->data['pdcats'] as $pdcat){
	    $pdcats[] = array("id"=>$pdcat->id,"parent_id"=>$pdcat->parent_id,"title"=>$pdcat->title);
	}

	// for Global List
	$this->data['_table_names'] = $this->_table_names;
	$this->data['_subView'] = $this->_subView;
	$this->data['_parent_folder'] = 'Invoice & Estimates';
	$Sentoptions = array("s"=>"Sent","d"=>"Draft");
	$columns_with_filteroptions = array(
			"Client" => array(
				    "name"=>"buyer_TYPElike",
				    "type"=>"text",
				    "events"=>array(
					"onkeyup"=>"getData('no')"
				    )
				),
			"Phone" => array(
					"name"=>"phone_TYPElike",
					"type"=>"text",
					"events"=>array(
					    "onkeyup"=>"getData('no')"
					)					
				    ),			
			"Product" => array(
						"name"=>"product_category_TYPEwhere",
						"type"=>"selectwithoptiongroup",
						"options"=>$pdcats,
						"events"=>array(
						    "onchange"=>"getData('no')"
						)
					    ),
			"From" => array(
						"name"=>"employee_TYPEwhere",
						"type"=>"select",
						"options"=>$employees,
						"events"=>array(
						    "onchange"=>"getData('no')"
						)
					    ),
			"Branch" => array(
						"name"=>"branch_id_TYPEhaving",
						"type"=>"select",
						"options"=>$branches,
						"events"=>array(
						    "onchange"=>"getData('no')"
						)
					    ),
			"Sent Time" => array(
					"name"=>"sendtime_TYPEcustom",
					"type"=>"select",
					"options"=>$Sentoptions,
					"events"=>array(
					    "onchange"=>"getData('no')"
					)
				    ),
			"Sender" => array(
						"name"=>"sender_TYPEwhere",
						"type"=>"select",
						"options"=>$employees,
						"events"=>array(
						    "onchange"=>"getData('no')"
						)
					    ),
				    
			"Action" => array(
					"name"=>"id_TYPElike",
					"type"=>"text",
					"events"=>array(
					    "onkeyup"=>"getData('no')"
					)
				    ),
		    );
	$blank_array = array();
        $total_count = $this->CommanModel->getDatamwithlimit($this->data['_table_names'],$blank_array,$blank_array,$blank_array,'',0,'all',true);

	$main_array_view = array(
			    "view_data"=>array(
				"view_folder"=>"setproject",
				"columns_with_filteroptions"=>$columns_with_filteroptions,
				"total_count"=>$total_count,
				"is_filter"=>"yes",
				"default_sort"=>"created",
				"default_sort_type"=>"DESC",
				"add_link"=>array("status"=>"yes","link"=>$this->data['admin_link'].'/setproject/edit'),
			    )
			);
			
	$this->data['viewdata'] = $main_array_view;
	// end for Global List
    }


    


    public function index() {
        //set title
        $this->data['name'] = 'Invoices';
        $this->data['title'] = $this->data['name']; 
        echo view('admin/_layout_main',$this->data);
    }
    
    public function edit($id = NULL)
    {
        // Fetch a data or set a new one
        if($id)
        {
            //set title
            $this->data['name'] = 'Edit';
            $this->data['title'] = $this->data['name'].' | '.$this->data['settings']['site_name'];

            $this->data['thisItems'] = $this->data['ThisModule']->get($id, FALSE);
            $this->data['errors'][] = 'User could not be found';
        }
        else
        {
            //set title
            $this->data['name'] = 'Create new';
            $this->data['title'] = $this->data['name'].' | '.$this->data['settings']['site_name'];

            // set a new one
            $this->data['thisItems'] = $this->data['ThisModule']->getNew();
        }

        // Set up the form
        $input = $this->validate($this->data['ThisModule']->getAllRules());

        $this->data['validation'] = \Config\Services::validation();
        
        

        // Process the form
        if($_POST){
            if($input) {
                // get post data from form
                $data = $this->data['ThisModule']->arrayFromPost(array('project','employee','buyer','address','phone','email','notes'));
                $data['phone']= preg_replace('/[^0-9.]/', '', $data['phone']);;
      
                $data['created'] = time();
                $data['link']    = md5(time() . rand());


                //create or update data
                $id = $this->data['ThisModule']->saveData($data, $id);
                if(empty($this->data['thisItems']->id))
                    $this->data['session']->setFlashdata('success','Data has successfully created');
                else
                    $this->data['session']->setFlashdata('success','Data has successfully updated');
                return redirect()->to(base_url().'/'.$this->data['_cancel']);
            }
        }

        $request = \Config\Services::request();
        $this->data['request'] = $request;

        //set load view
        $this->data['subview'] = $this->_subView.'edit';
        echo view('admin/_layout_main', $this->data);
    }
    

    public function delete($id)	{//delete data
        $this->CommanModel->deleteData('setproject', array('id' => $id));
        
        $parents = $this->CommanModel->get_by('setproject',array('parent_id'=>$id),false,false,false);
        
        $this->CommanModel->deleteData('setproject', array('parent_id' => $id));
        
        
        //echo '<pre>';print_r($parents);die();
        
        $this->CommanModel->deleteData('selproducts', array('category_id' => $id));
        
        foreach($parents as $parent) {
        $this->CommanModel->deleteData('selproducts', array('category_id' => $parent->id));
        }
        
        
      
            return redirect()->to(base_url().'/admin123/setproject');
        
    }
    
    function extra ($id) {
        
        $data = $this->data;
        
        $this->data['name'] = 'Sent Invoice Data';
        
        $this->data['main'] =  $this->CommanModel->get_by('l_settings', array(), FALSE, FALSE, TRUE);
		
		$this->data['setproject'] =  $this->CommanModel->get_by('setproject', array('id'=>$id), FALSE, FALSE, TRUE);
		
		$this->data['subprojects'] =  $this->CommanModel->get_by('setproject', array('parent_id'=>$this->data['setproject']->id), FALSE, FALSE, FALSE);
		
		$this->data['selprods'] = $this->CommanModel->get_by('selproducts', array('category_id'=>$this->data['setproject']->id), FALSE, FALSE, FALSE);
        
        
        //set load view
        $this->data['subview'] = $this->_subView.'extra';
        echo view('admin/_layout_main', $this->data);
    }
    
    
    function clone($id) {
        
        //echo 'We are working on functionality cloning invoice to speed up your work. Please be patient'; 
        
        //die();
        
        $mainInvoice = $this->CommanModel->get_by('setproject',array('id'=>$id),false,false,true);
        
        if ($mainInvoice) {
        
            $mainInvoice->sendtime = '';
            $mainInvoice->sender = '';
            $mainInvoice->link = md5(time() . rand());
            $mainInvoice->created = time();
            
            $cloned_main_invoice = json_decode(json_encode($mainInvoice), true);
            
            $clonedMain = $this->CommanModel->saveData('setproject', $cloned_main_invoice, NULL);
            
            
            $this->data['MainInvoiceProducts'] = $this->CommanModel->get_by('selproducts',array('category_id'=>$mainInvoice->id),false,false,false);
        
            foreach ($this->data['MainInvoiceProducts'] as $newMainInvoice) {
                
                $newMainInvoice->id = null;
                $newMainInvoice->category_id = $clonedMain;
                
                $clonedMainproducts = $this->CommanModel->saveData('selproducts', json_decode(json_encode($newMainInvoice), true), NULL);
            }
        }
        
        $subInvoices = $this->CommanModel->get_by('setproject',array('parent_id'=>$id),false,false,false);
        
        
        if ($subInvoices) {
        
        foreach ($subInvoices as $subInvoice) {
            
            $clonedSubProducts = $this->CommanModel->get_by('selproducts',array('category_id'=>$subInvoice->id),false,false,false);
            
            $subInvoice->id = null;
            $subInvoice->parent_id = $clonedMain;
            
            $clonedSub = $this->CommanModel->saveData('setproject', json_decode(json_encode($subInvoice), true), NULL);
            
          
            foreach ($clonedSubProducts as $clonedSubProduct) {
                
                $clonedSubProduct->id = null;
                $clonedSubProduct->category_id = $clonedSub;
                
                
                //echo '<pre>';print_r($clonedSubProduct);
                $prods = $this->CommanModel->saveData('selproducts', json_decode(json_encode($clonedSubProduct), true), NULL);
                
                
            }
             
             
             
            
        }
        
        } 
        
        return redirect()->to(base_url().'/admin123/setproject');
        
    }
}

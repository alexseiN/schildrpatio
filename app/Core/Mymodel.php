<?php

namespace App\Core;
use CodeIgniter\Model;

class Mymodel extends Model {

    protected $_table_name      = '';
    protected $_primary_key     = 'id';
    protected $_primary_filter  = 'intval';
    protected $_orderBy        = ''; 
    protected $_timestamps      = FALSE;
    public $rules = array();

    public function __construct(){
        parent::__construct();
    }

    public function getTableName() : string
    {
        return $this->_table_name;
    }

    public function arrayFromPost($fields) : array
    {
        $data = array();
        foreach($fields as $field)
        {
            $request = \Config\Services::request();
            $data[$field] = $request->getPost($field);
        }
        return $data;
    }

    public function langFromPost($fields) : array
    {
        $data = array();
        foreach($fields as $field)
        {
            $request = \Config\Services::request();
            $data[$field] = $request->getPost($field);
        }
        return $data;
    }

    public function getAllRules() : array
    {
        return array_merge($this->rules, $this->rulesLang);
    }

    public function maxOrder() : int
    {
        // get max order
        $builder = $this->db->table($this->_table_name);
        $builder->select('MAX(`order`) as `order`', FALSE);
        $order = $builder->get()->getRowArray()['order'];

        return (int) $order;
    }

    public function getLangPostFields() : array
    {
        $post_fields = array();

        if(isset($this->rulesLang)){
            foreach($this->rulesLang as $key=>$value)
            {
                $post_fields[] = $key;
            }
        }

        return $post_fields;
    }

    public function get($id = NULL, $single = FALSE)
    {
        $builder = $this->db->table($this->_table_name);
        
        
        if($id != NULL)
        {
            $filter = $this->_primary_filter;
            $id = $filter($id);
            $builder->where($this->_table_name.'.'.$this->_primary_key, $id);
            $method = 'row';
        }
        else if($single == TRUE)
        {
            $method = 'row';
        }
        else
        {
            $method = 'result';
        }

        if($builder->orderBy($this->_orderBy)) {
            $builder->orderBy($this->_orderBy);
        }

        $query = $builder->get();
        if (is_object($query))
        {
            if($method == 'row')
                return $query->getRow();
            else
                return $query->getResult();
        }

        return array();
    }

    public function getFormDropdown($column, $where = FALSE, $empty=TRUE)
    {
        $filter = $this->_primary_filter;
        $builder = $this->db->table($this->_table_name);

        if($builder->orderBy($this->_order_by)) {
            $builder->orderBy($this->_order_by);
        }

        if($where)
            $builder->where($where);

        $builder->where(array('enabled'=>1));
        
        $dbdata = $builder->get()->getResultArray();

        $results = array();

        if($empty)
            $results[''] = '';

        foreach($dbdata as $key=>$row){
            if(isset($row[$column]))
            {
                //if(lang($row[$column]) != '')$row[$column] = lang($row[$column]);
                $results[$row[$this->_primary_key]] = $row[$column];
            }
        }
        return $results;
    }

    public function saveData($data, $id = NULL)
    {
        
        // Set timestamps
        if($this->_timestamps == TRUE)
        {
            $now = date('Y-m-d H:i:s');
            $id || $data['created'] = $now;
            $data['modified'] = $now;
        }
        

        $builder = $this->db->table($this->_table_name);

        // Insert
        if(!$id)
        {
            !isset($data[$this->_primary_key]) || $data[$this->_primary_key] = NULL;
            $builder->insert($data);
            $id = $this->db->insertID();
        }
        // Update
        else
        {
            $filter = $this->_primary_filter;
            $id = $filter($id);
            $builder->set($data);
            $builder->where($this->_primary_key, $id);
            $builder->update();
        }
        

        return $id;
    }

    

    public function deleteRow($id) : bool
    {
        $filter = $this->_primary_filter;
        $id = $filter($id);

        if(!$id)
        {
            return FALSE;
        }

        $builder = $this->db->table($this->_table_name);
        $builder->where($this->_primary_key, $id);
        $builder->limit(1);
        $builder->delete();

        return true;
    }

    public function total()
    {
        $builder = $this->db->table($this->_table_name);
        return $builder->countAllResults();
    }
    
    public function saveOrder ($pages)
    {
        if (count($pages)) {
            foreach ($pages as $order => $page) {
                if ($page['item_id'] != '') {
                    $data = array('parent_id' => (int) $page['parent_id'], 'order' => $order);
                    $this->db->table($this->_table_name)->set($data)->where($this->_primary_key, $page['item_id'])->update();
                }
            }
        }
    }
    
    public function getNested($lang_id=8,$withoutlang,$where){ 
        $builder = $this->db->table($this->_table_name);
        if ($withoutlang <> 1) {
        $builder->join($this->_table_name.'_lang', $this->_table_name.'.id = '.$this->_table_name.'_lang.'.$this->_connlang);
        $builder->where('language_id', $lang_id);
        }
        
        
        $builder->where($where);
        
        
        
        
        $builder->orderBy($this->_order_by);
        $pages = $builder->get()->getResultArray();
        
        $array = array();
        foreach ($pages as $page) {
            if (! $page['parent_id']) {
                // This page has no parent
                $array[$page['id']] = $page;
            }
            else {
                // This is a child page
                $array[$page['parent_id']]['children'][] = $page;
            }
        }
        return $array;
    }
    

    public function getLast($lang_id=8,$withoutlang,$where){ 
        $builder = $this->db->table($this->_table_name);
        if ($withoutlang <> 1) {
        $builder->join($this->_table_name.'_lang', $this->_table_name.'.id = '.$this->_table_name.'_lang.'.$this->_connlang);
        $builder->where('language_id', $lang_id);
        }
        
        
        $builder->where($where);
        
        
        
        
        $builder->orderBy('created DESC');
        $pages = $builder->get()->getResultArray();
        
        $array = array();
        foreach ($pages as $page) {
            if (! $page['parent_id']) {
                // This page has no parent
                $array[$page['id']] = $page;
            }
            else {
                // This is a child page
                $array[$page['parent_id']]['children'][] = $page;
            }
        }
        return $array;
    }
    
    
    
          //insert or update data
    public function saveWithLang($data, $data_lang, $id = NULL){
        // Set timestamps
        if($this->_timestamps == TRUE){
            $now = date('Y-m-d H:i:s');
            $id || $data['created'] = $now;
            $data['modified'] = $now;
        }

        // Insert
        if($id === NULL){
            !isset($data[$this->_primary_key]) || $data[$this->_primary_key] = NULL;

            $builder = $this->db->table($this->_table_name);
            $builder->set($data)->insert();
            $id = $this->db->insertID();
        }
        // Update
        else{
            $filter = $this->_primary_filter;
            $id = $filter($id);

            $builder = $this->db->table($this->_table_name);
            $builder->where($this->_primary_key, $id);
            $builder->set($data);
            $builder->update();
        }

        // Save lang data
        $this->db->table($this->_table_name.'_lang')->delete(array($this->_connlang => $id));

        foreach($this->languages as $lang_key=>$lang_val){
            if(is_numeric($lang_key)){
                $curr_data_lang = array();
                $curr_data_lang['language_id'] = $lang_key;
                $curr_data_lang[$this->_connlang] = $id;

                foreach($data_lang as $data_key=>$data_val){
                    $pos = strrpos($data_key, "_");
                    if(substr($data_key,$pos+1) == $lang_key){
                        $curr_data_lang[substr($data_key,0,$pos)] = $data_val;
                    }
                }
                $this->db->table($this->_table_name.'_lang')->set($curr_data_lang)->insert();
            }
        }
        return $id;
    }
    
        //fetch data in lang
    public function getLang($id = NULL, $single = FALSE, $lang_id=1){
        if($id != NULL){
            $result = $this->get($id);
            
            $builder = $this->db->table($this->_table_name.'_lang');
            $builder->where($this->_connlang, $id);
            $lang_result = $builder->get()->getResultArray();
            
            foreach ($lang_result as $row){
                foreach ($row as $key=>$val){
                    $result->{$key.'_'.$row['language_id']} = $val;
                }
            }

            foreach($this->languages as $key_lang=>$val_lang){
                foreach($this->rulesLang as $r_key=>$r_val){
                    if(!isset($result->{$r_key})){
                        $result->{$r_key} = '';
                    }
                }
            }

            return $result;
        }

        $builder = $this->db->table($this->_table_name);
        $builder->join($this->_table_name.'_lang', $this->_table_name.'.id = '.$this->_table_name.'_lang.'.$this->_connlang);
        $builder->where('language_id', $lang_id);

        if(!count($builder->orderBy($this->_order_by))) {
            $builder->orderBy($this->_order_by);
        }


        if($single == TRUE)
            $result = $builder->get()->getRow();
        else
            $result = $builder->get()->getResult();

        return $result;
    }
    
    public function deleteData($id)
    {
        $db = \Config\Database::connect();
        
        if ($db->tableExists($this->_table_name.'_lang')) {
            $this->db->table($this->_table_name.'_lang')->delete(array($this->_connlang => $id));
        }
        
        if ($db->tableExists($this->_table_name.'_files')) {
            $this->db->table($this->_table_name.'_files')->delete(array($this->_connfile => $id));
        }
        
        $this->db->table($this->_table_name)->delete(array('id' => $id));

        // Reset parent ID for its children
        //$this->db->table($this->_table_name)->set(array('parent_id' => 0))->where('parent_id', $id)->update();
    }
    
}

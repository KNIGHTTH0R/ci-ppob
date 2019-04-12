<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home_model extends CI_Model
{

  function get_operator($prefix)
  {
    $this->db->where('prefix_number',$prefix);
    $prefix = $this->db->get('prefix')->row();
    $operator_id = $prefix->operator_id;
    $operator_name = $this->get_operator_name($operator_id);
    return $operator_name;
  }

  function get_operator_name($operator_id){
    $this->db->where('operator_id',$operator_id);
    $operator = $this->db->get('operator')->row();
    $operator_name = $operator->operator_name;
    return $operator_name;
  }



}

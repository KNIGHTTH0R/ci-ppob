<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

  public function __construct(){
    parent::__construct();
    $this->load->model('home_model');
  }

	public function index()
	{
		$this->load->view('index');
	}

  public function get_operator($prefix){
    $operator_name = $this->home_model->get_operator($prefix);
    echo $operator_name;
  }

  public function get_nominal($operator){
    $username   = "085781838818";
    $apiKey   = "4715caad53c186d4";
    $signature  = md5($username.$apiKey.'pl');

    $json = '{
              "commands" : "pricelist",
              "username" : "085781838818",
              "sign"     : "36ab187b6332139edf0a65078aa57552"
            }';

    $url = "https://testprepaid.mobilepulsa.net/v1/legacy/index/pulsa/".$operator;

    $ch  = curl_init();
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $data = curl_exec($ch);
    curl_close($ch);

    echo $data;
  }

  public function topup_request(){
    $username   = "085781838818";
    $apiKey   = "4715caad53c186d4";
    $ref_id  = uniqid('');

    $code = $this->input->post('nominal');
    $hp = $this->input->post('nomor');

    $signature  = md5($username.$apiKey.$ref_id);

    $json = '{
              "commands"    : "topup",
              "username"    : "085781838818",
              "ref_id"      : "'.$ref_id.'",
              "hp"          : "'.$hp.'",
              "pulsa_code"  : "'.$code.'",
              "sign"        : "'.md5($username.$apiKey.$ref_id).'"
            }';

    $url = "https://testprepaid.mobilepulsa.net/v1/legacy/index";

    $ch  = curl_init();
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $data = curl_exec($ch);
    curl_close($ch);

    echo $data;
    // print_r($data);
  }

}

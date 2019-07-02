<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    function __construct() {
        parent::__construct();
        date_default_timezone_set("Asia/Kolkata");
        $this->load->model('Buildermodel');
    }
    
    /*
     * Start Page
     * This has all the stats info
     */

    public function index() {

        $city_name = $this->input->post('city_name'); /*For Creating new city*/
        if ($city_name) {
            $row_count['total'] = $this->Buildermodel->checkCityExists($city_name);
            if ($row_count['total']['total'] == 0) {
                $this->Buildermodel->insertCity($city_name);
                $username = 'nana';
                $data['points'] = 10;
                $data['updated_on'] = date('Y-m-d H:i:s');
                $this->Buildermodel->addUserPoints($data, $username);
            } else {
                echo "City Exists, Choose diffrent name";
            }
        }

        $data['username'] = 'nana';
        $data['cities'] = $this->Buildermodel->getAllCities();
        $buildings = $this->Buildermodel->getAllBuldings(); /*Get All Existing buildins*/

        if(count($buildings)>0){
            foreach ($buildings as $value) {

                $data['buildings'][$value['city_id']][$value['status']][] = $value;
            }
        }else{
            $data['buildings'] = array();
        }

        $data['user_info'] = $this->Buildermodel->getUserInfoByName($data['username']);
        $data['totalPoints'] = $data['user_info']['0']->points;
        $this->load->view('homepage', $data);
    }

    /*
     * This is the builder page
     * city_id as Get parameter
     */
    public function builder() {


        $data['username'] = 'nana';

        $data['city_id'] = $this->input->get('city_id');

        $data['city_info'] = $this->Buildermodel->getCityInfoById($data['city_id']);

        if ($data['city_info']) {
            $data['city'] = $data['city_info']['name'];
            $data['consume_points'] = $data['city_info']['consume_points'];
            $data['user_info'] = $this->Buildermodel->getUserInfoByName($data['username']);
            $data['totalPoints'] = $data['user_info']['0']->points;
            $data['building'] = json_encode($this->Buildermodel->getBuldingsByCity($data['city_id']));
            $this->load->view('builder', $data);
        } else {
            echo "city not found";
        }
    }

    /*
     * Ajax Function for updating user points
     * Gets username and points from the POST
     */
    public function updatUserPoints() {

        $username = $this->input->post('username');
        $totalPoints = $this->input->post('totalPoints');

        $data['points'] = $totalPoints;
        $data['updated_on '] = date('Y-m-d H:i:s');
        $this->Buildermodel->updateUserPoints($data, $username);
        echo "Success";
    }

    
    /*
     * AJAX function for updating building status
     * gets  city_id,building_type,level,status from the POST
     */
    public function updateCityBuildingsAjax() {

        $data['city_id'] = $this->input->post('city_id');
        $data['building_type'] = $this->input->post('bldType');
        $data['level'] = $this->input->post('level');
        $data['status'] = $this->input->post('status');
        $data['created_on'] = date('Y-m-d H:i:s');
        $data['updated_on'] = date('Y-m-d H:i:s');
        $operation = $this->input->post('operation');

        $this->Buildermodel->updateCityBuildings($data, $data['status'], $operation);
    }

    /*
     * AJax function for points cosume by the city //remove this txtx
     */
    public function updateCityConsumePoints() {
        $data['city_id'] = $this->input->post('city_id');
        $data['points'] = $this->input->post('points');
        $this->Buildermodel->updateCityConsumePoints($data['city_id'], $data['points']);
    }

    /*
    public function createCity() {
        $city_name = $this->input->get('city_name');
        if ($city_name) {
            $row_count['total'] = $this->Buildermodel->checkCityExists($city_name);
            if ($row_count['total']['total'] == 0) {
                $this->Buildermodel->insertCity($city_name);
            } else {
                echo "City Exists, Choose diffrent name";
            }
        }
    }
     * 
     */

}

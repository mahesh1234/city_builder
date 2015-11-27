<?php

class Buildermodel extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    public function updateUserPoints($data, $username) {
        $this->db->where('name', $username);
        $this->db->update('users', $data, FALSE);
    }

    public function addUserPoints($data, $username) {
        $this->db->set('points', 'points+' . $data['points'], FALSE);
        $this->db->set('updated_on', $data['updated_on']);
        $this->db->update('users');
    }

    public function updateCityBuildings($data, $status, $operation) {
        if ($operation == "add") {
            $this->db->insert('building', $data);
        } else {
            $where['city_id'] = $data['city_id'];
            $where['building_type'] = $data['building_type'];
            $update['status'] = $data['status'];
            $update['level'] = $data['level'];
            $update['updated_on'] = $data['updated_on'];
            $this->db->where($where);
            $this->db->update('building', $update);
        }
    }

    public function getUserInfoByName($name) {
        $this->db->select('name,points');
        $this->db->where('name', $name);
        $this->db->from('users');
        return $this->db->get()->result();
    }

    public function getCityInfoById($id) {
        $this->db->select('id,name,consume_points');
        $this->db->where('id', $id);
        $this->db->from('city');
        return $this->db->get()->row_array();
    }

    public function getBuldingsByCity($city_id) {
        $this->db->select('building_type,level,status');
        $this->db->where('city_id', $city_id);
        $this->db->from('building');
        return $this->db->get()->result_array();
    }

    public function getAllBuldings() {
        $this->db->select('id,building_type,level,status,city_id');
        $this->db->from('building');
        return $this->db->get()->result_array();
    }

    public function updateCityConsumePoints($city_id, $points) {
        $this->db->set('consume_points', 'consume_points+' . $points, FALSE);
        $this->db->update('city');
    }

    function checkCityExists($city_name) {
        $this->db->select('count(*)  as total');
        $this->db->from('city');
        $this->db->where('name', $city_name);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function insertCity($city_name) {
        $data['name'] = $city_name;
        $data['consume_points'] = 0;
        $data['created_on'] = date('Y-m-d H:i:s');
        $this->db->insert('city', $data);
    }

    public function getAllCities() {
        $this->db->select('id,name,consume_points');
        $this->db->from('city');
        $this->db->order_by('id', 'DESC');
        return $this->db->get()->result_array();
    }

}

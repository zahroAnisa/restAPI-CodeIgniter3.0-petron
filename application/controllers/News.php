<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class News extends REST_Controller {

    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
    }

    //Menampilkan data berita
    function index_get() {
        $NewsID = $this->get('NewsID');
        if ($NewsID == '') {
            $News = $this->db->get('CMS_News')->result();
        } else {
            $this->db->where('NewsID', $NewsID);
            $News = $this->db->get('CMS_News')->result();
        }
        $this->response($News, 200);
    }


    //Mengirim atau menambah News Baru
    function index_post() {
        $data = array(
                    'NewsID'      => $this->post('NewsID'),
                    'CategoryID'  => $this->post('CategoryID'),
                    'NewsTitle'   => $this->post('NewsTitle'),
                    'PostDate' => $this->post('PostDate'),
                    'NewsHTML'    => $this->post('NewsHTML'),
                    'ViewCount' => $this->post('ViewCount'),
                    'Visible' => $this->post('Visible')
                );
        $insert = $this->db->insert('CMS_News', $data);
        if ($insert) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }

    //Memperbarui data News yang sudah ada
    function index_put() {
        $id = $this->put('NewsID');
        $data = array(
                    'NewsID'      => $this->post('NewsID'),
                    'CategoryID'  => $this->post('CategoryID'),
                    'NewsTitle'   => $this->post('NewsTitle'),
                    'PostDate' => $this->post('PostDate'),
                    'NewsHTML'    => $this->post('NewsHTML'),
                    'ViewCount' => $this->post('ViewCount'),
                    'Visible' => $this->post('Visible')
                );
        $this->db->where('NewsID', $id);
        $update = $this->db->update('CMS_News', $data);
        if ($update) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }


    //Menghapus salah satu data News
    function index_delete() {
        $id = $this->delete('NewsID');
        $this->db->where('NewsID', $id);
        $delete = $this->db->delete('CMS_News');
        if ($delete) {
            $this->response(array('status' => 'success'), 201);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }
}
?>
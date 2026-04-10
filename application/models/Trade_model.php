<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Trade_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // Read: Lấy toàn bộ bài đăng kèm thông tin user và category
    public function get_all_posts() {
        $this->db->select('posts.*, users.username, categories.category_name');
        $this->db->from('posts');
        $this->db->join('users', 'users.id = posts.user_id', 'left');
        $this->db->join('categories', 'categories.id = posts.category_id', 'left');
        $this->db->order_by('posts.created_at', 'DESC');
        return $this->db->get()->result_array();
    }

    public function get_categories() {
        return $this->db->get('categories')->result_array();
    }

    // Create: Thêm bài đăng mới
    public function insert_post($data) {
        return $this->db->insert('posts', $data);
    }

    // Update: Chuyển trạng thái sang Đã Pass
    public function update_status($id, $status) {
        $this->db->where('id', $id);
        return $this->db->update('posts', ['status' => $status]);
    }

    // Delete: Xóa bài đăng
    public function delete_post($id) {
        $this->db->where('id', $id);
        return $this->db->delete('posts');
    }
}

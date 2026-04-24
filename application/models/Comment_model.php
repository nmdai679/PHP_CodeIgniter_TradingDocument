<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Comment_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // Lấy tất cả bình luận của 1 bài đăng
    public function get_comments_by_post($post_id) {
        $this->db->select('comments.*, users.username, users.full_name, users.avatar');
        $this->db->from('comments');
        $this->db->join('users', 'users.id = comments.user_id', 'left');
        $this->db->where('comments.post_id', $post_id);
        $this->db->order_by('comments.created_at', 'ASC');
        return $this->db->get()->result_array();
    }

    // Thêm bình luận
    public function add_comment($data) {
        return $this->db->insert('comments', $data);
    }

    // Xóa bình luận (chỉ chủ sở hữu hoặc admin)
    public function delete_comment($id) {
        $this->db->where('id', $id);
        return $this->db->delete('comments');
    }

    // Đếm bình luận theo bài đăng
    public function count_by_post($post_id) {
        return $this->db->where('post_id', $post_id)->count_all_results('comments');
    }

    // Lấy 1 bình luận theo ID
    public function get_comment_by_id($id) {
        return $this->db->get_where('comments', ['id' => $id])->row_array();
    }
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Trade_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // Read: Lấy toàn bộ bài đăng kèm user, category, avg_rating
    public function get_all_posts($category_id = NULL, $keyword = NULL) {
        $this->db->select('posts.*, users.username, users.full_name, users.phone, users.phone_visible,
            categories.category_name, categories.icon as cat_icon,
            COALESCE(AVG(ratings.stars), 0) as avg_rating,
            COUNT(DISTINCT ratings.id) as total_ratings,
            COUNT(DISTINCT comments.id) as comment_count');
        $this->db->from('posts');
        $this->db->join('users', 'users.id = posts.user_id', 'left');
        $this->db->join('categories', 'categories.id = posts.category_id', 'left');
        $this->db->join('ratings', 'ratings.seller_id = posts.user_id', 'left');
        $this->db->join('comments', 'comments.post_id = posts.id', 'left');
        
        if ($category_id) {
            $this->db->where('posts.category_id', $category_id);
        }
        if ($keyword) {
            $this->db->like('posts.title', $keyword);
        }

        // Chỉ hiện bài đã được duyệt (available, sold)
        $this->db->where_in('posts.status', ['available', 'sold']);

        $this->db->group_by(['posts.id', 'posts.user_id', 'posts.category_id', 'posts.title', 'posts.description', 'posts.price', 'posts.image_url', 'posts.status', 'posts.created_at', 'users.username', 'users.full_name', 'users.phone', 'users.phone_visible', 'categories.category_name', 'categories.icon']);
        $this->db->order_by('posts.created_at', 'DESC');
        return $this->db->get()->result_array();
    }

    // Lấy chi tiết 1 bài đăng + bình luận
    public function get_post_detail($id) {
        $this->db->select('posts.*, users.username, users.full_name, users.phone, users.phone_visible, users.id as seller_id,
            categories.category_name,
            COALESCE(AVG(ratings.stars), 0) as avg_rating,
            COUNT(DISTINCT ratings.id) as total_ratings');
        $this->db->from('posts');
        $this->db->join('users', 'users.id = posts.user_id', 'left');
        $this->db->join('categories', 'categories.id = posts.category_id', 'left');
        $this->db->join('ratings', 'ratings.seller_id = posts.user_id', 'left');
        $this->db->where('posts.id', $id);
        $this->db->group_by(['posts.id', 'posts.user_id', 'posts.category_id', 'posts.title', 'posts.description', 'posts.price', 'posts.image_url', 'posts.status', 'posts.created_at', 'users.username', 'users.full_name', 'users.phone', 'users.phone_visible', 'users.id', 'categories.category_name']);
        return $this->db->get()->row_array();
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

    // Lấy bài đăng theo ID (dùng để kiểm tra quyền sở hữu)
    public function get_post_by_id($id) {
        return $this->db->get_where('posts', ['id' => $id])->row_array();
    }

    // Lấy bài đăng của 1 user cụ thể
    public function get_posts_by_user($user_id) {
        $this->db->select('posts.*, categories.category_name,
            COALESCE(AVG(ratings.stars), 0) as avg_rating,
            COUNT(DISTINCT comments.id) as comment_count');
        $this->db->from('posts');
        $this->db->join('categories', 'categories.id = posts.category_id', 'left');
        $this->db->join('ratings', 'ratings.seller_id = posts.user_id', 'left');
        $this->db->join('comments', 'comments.post_id = posts.id', 'left');
        $this->db->where('posts.user_id', $user_id);
        $this->db->group_by(['posts.id', 'posts.user_id', 'posts.category_id', 'posts.title', 'posts.description', 'posts.price', 'posts.image_url', 'posts.status', 'posts.created_at', 'categories.category_name']);
        $this->db->order_by('posts.created_at', 'DESC');
        return $this->db->get()->result_array();
    }
    // Lấy bài đang chờ duyệt (admin)
    public function get_pending_posts() {
        $this->db->select('posts.*, users.username, users.full_name, categories.category_name');
        $this->db->from('posts');
        $this->db->join('users', 'users.id = posts.user_id', 'left');
        $this->db->join('categories', 'categories.id = posts.category_id', 'left');
        $this->db->where('posts.status', 'pending');
        $this->db->order_by('posts.created_at', 'ASC');
        return $this->db->get()->result_array();
    }

    // Lấy tổng số bài chờ duyệt
    public function count_pending() {
        return $this->db->where('status', 'pending')->count_all_results('posts');
    }
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_Session $session
 * @property CI_DB_query_builder $db
 * @property Trade_model $Trade_model
 * @property Auth_model $Auth_model
 * @property Message_model $Message_model
 */
class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(['Trade_model', 'Auth_model', 'Message_model']);
        $this->load->library('session');
        $this->load->helper(['url']);
    }

    private function require_admin() {
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') !== 'admin') {
            show_error('Bạn không có quyền truy cập trang này.', 403);
        }
    }

    // Dashboard tổng quan
    public function index() {
        $this->require_admin();
        $user_id = $this->session->userdata('user_id');

        // Thống kê nhanh
        $data['total_posts']     = $this->db->count_all('posts');
        $data['total_users']     = $this->db->count_all('users');
        $data['total_sold']      = $this->db->where('status', 'sold')->count_all_results('posts');
        $data['total_available'] = $this->db->where('status', 'available')->count_all_results('posts');
        $data['total_pending']   = $this->Trade_model->count_pending();

        $data['recent_posts']  = $this->Trade_model->get_all_posts();
        $data['pending_posts'] = $this->Trade_model->get_pending_posts();
        $data['unread_count']  = $this->Message_model->count_unread($user_id);

        $this->load->view('partials/header', $data);
        $this->load->view('admin/dashboard', $data);
        $this->load->view('partials/footer');
    }

    // Quản lý người dùng
    public function users() {
        $this->require_admin();
        $user_id = $this->session->userdata('user_id');

        $data['users']        = $this->db->get('users')->result_array();
        $data['unread_count'] = $this->Message_model->count_unread($user_id);

        $this->load->view('partials/header', $data);
        $this->load->view('admin/users', $data);
        $this->load->view('partials/footer');
    }

    // Admin xóa bài đăng bất kỳ
    public function delete_post($id) {
        $this->require_admin();
        $this->Trade_model->delete_post($id);
        $this->session->set_flashdata('success', 'Đã xóa bài đăng!');
        redirect('admin');
    }

    // Admin duyệt bài đăng
    public function approve_post($id) {
        $this->require_admin();
        $this->Trade_model->update_status($id, 'available');
        $this->session->set_flashdata('success', '✅ Đã duyệt và đăng bài lên trang chủ!');
        redirect('admin');
    }

    // Admin từ chối bài đăng
    public function reject_post($id) {
        $this->require_admin();
        $this->Trade_model->delete_post($id);
        $this->session->set_flashdata('success', 'Đã từ chối và xóa bài!');
        redirect('admin');
    }

    // Admin đổi role user
    public function toggle_role($id) {
        $this->require_admin();
        $user = $this->Auth_model->get_user_by_id($id);
        if ($user) {
            $new_role = ($user['role'] === 'admin') ? 'user' : 'admin';
            $this->Auth_model->update_user($id, ['role' => $new_role]);
            $this->session->set_flashdata('success', 'Đã thay đổi quyền người dùng!');
        }
        redirect('admin/users');
    }
}

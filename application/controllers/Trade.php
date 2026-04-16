<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Trade extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(['Trade_model', 'Comment_model', 'Rating_model', 'Message_model']);
        $this->load->helper(['form', 'url']);
        $this->load->library(['session', 'upload']);
    }

    // Helper: Kiểm tra đăng nhập
    private function require_login() {
        if (!$this->session->userdata('logged_in')) {
            $this->session->set_flashdata('error', 'Bạn cần đăng nhập để thực hiện thao tác này.');
            redirect('auth');
        }
    }

    // Helper: Kiểm tra admin
    private function require_admin() {
        if ($this->session->userdata('role') !== 'admin') {
            show_error('Bạn không có quyền thực hiện thao tác này.', 403);
        }
    }

    // Trang chủ - Hiển thị danh sách
    public function index() {
        $category_id = $this->input->get('cat');
        $keyword     = $this->input->get('q');

        $data['posts']      = $this->Trade_model->get_all_posts($category_id, $keyword);
        $data['categories'] = $this->Trade_model->get_categories();
        $data['active_cat'] = $category_id;
        $data['keyword']    = $keyword;

        // Đếm tin nhắn chưa đọc (nếu đang đăng nhập)
        $data['unread_count'] = 0;
        if ($this->session->userdata('logged_in')) {
            $data['unread_count'] = $this->Message_model->count_unread($this->session->userdata('user_id'));
        }

        $this->load->view('partials/header', $data);
        $this->load->view('home', $data);
        $this->load->view('partials/footer');
    }

    // Chi tiết bài đăng + bình luận
    public function detail($id) {
        $data['post']       = $this->Trade_model->get_post_detail($id);
        $data['categories'] = $this->Trade_model->get_categories();
        $data['comments']   = $this->Comment_model->get_comments_by_post($id);

        if (!$data['post']) {
            show_404();
        }

        // Kiểm tra đã đánh giá chưa
        $data['has_rated'] = FALSE;
        if ($this->session->userdata('logged_in')) {
            $data['has_rated'] = $this->Rating_model->has_rated(
                $this->session->userdata('user_id'), $id
            );
            $data['unread_count'] = $this->Message_model->count_unread($this->session->userdata('user_id'));
        } else {
            $data['unread_count'] = 0;
        }

        $this->load->view('partials/header', $data);
        $this->load->view('post_detail', $data);
        $this->load->view('partials/footer');
    }

    // Xử lý tạo bài đăng + Upload ảnh
    public function create() {
        $this->require_login();
        $user_id = $this->session->userdata('user_id');

        // Cấu hình upload thư mục assets/uploads/
        $config['upload_path']   = './assets/uploads/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size']      = 5120; // 5MB
        $config['encrypt_name']  = TRUE;

        if (!is_dir('./assets/uploads/')) {
            mkdir('./assets/uploads/', 0777, TRUE);
        }

        $this->upload->initialize($config);
        $image_url = 'assets/uploads/default.png';

        if ($this->upload->do_upload('image')) {
            $uploadData = $this->upload->data();
            $image_url  = 'assets/uploads/' . $uploadData['file_name'];
        }

        $post_data = [
            'user_id'     => $user_id,
            'category_id' => $this->input->post('category_id'),
            'title'       => $this->input->post('title', TRUE),
            'description' => $this->input->post('description', TRUE),
            'price'       => $this->input->post('price'),
            'image_url'   => $image_url,
            'status'      => 'pending'  // Chờ Admin duyệt
        ];

        $this->Trade_model->insert_post($post_data);
        $this->session->set_flashdata('success', '✅ Đăng bài thành công! Bài của bạn đang chờ Admin duyệt. Vui lòng chờ trong ít phút.');
        redirect('trade');
    }

    // Chuyển trạng thái Đã Pass — chỉ chủ bài hoặc admin
    public function update_status($id) {
        $this->require_login();
        $post = $this->Trade_model->get_post_by_id($id);

        if (!$post) { show_404(); }

        $user_id = $this->session->userdata('user_id');
        $role    = $this->session->userdata('role');

        if ($post['user_id'] != $user_id && $role !== 'admin') {
            $this->session->set_flashdata('error', 'Bạn không có quyền thực hiện thao tác này!');
            redirect('trade');
            return;
        }

        $this->Trade_model->update_status($id, 'sold');
        $this->session->set_flashdata('success', 'Đã chuyển trạng thái Đã Pass thành công!');
        redirect('trade');
    }

    // Xóa bài đăng — chỉ chủ bài hoặc admin
    public function delete($id) {
        $this->require_login();
        $post = $this->Trade_model->get_post_by_id($id);

        if (!$post) { show_404(); }

        $user_id = $this->session->userdata('user_id');
        $role    = $this->session->userdata('role');

        if ($post['user_id'] != $user_id && $role !== 'admin') {
            $this->session->set_flashdata('error', 'Bạn không có quyền xóa bài này!');
            redirect('trade');
            return;
        }

        $this->Trade_model->delete_post($id);
        $this->session->set_flashdata('success', 'Đã xóa bài đăng!');
        redirect('trade');
    }
}

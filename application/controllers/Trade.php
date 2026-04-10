<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Trade extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Trade_model');
        $this->load->helper(['form', 'url']);
        $this->load->library(['session', 'upload']);
    }

    // Trang chủ - Hiển thị danh sách
    public function index() {
        $data['posts'] = $this->Trade_model->get_all_posts();
        $data['categories'] = $this->Trade_model->get_categories();
        $this->load->view('home', $data);
    }

    // Xử lý tạo bài đăng + Upload ảnh
    public function create() {
        // Fix cứng user_id = 1 cho demo (Sau này thay bằng Session Login)
        $user_id = 1; 

        // Cấu hình upload thư mục assets/uploads/
        $config['upload_path']   = './assets/uploads/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size']      = 5120; // 5MB
        $config['encrypt_name']  = TRUE; // Mã hóa tên file

        $this->upload->initialize($config);

        $image_url = 'assets/uploads/default.png'; // Ảnh mặc định
        
        // Tạo thư mục nếu chưa có
        if (!is_dir('./assets/uploads/')) {
            mkdir('./assets/uploads/', 0777, TRUE);
        }

        if ($this->upload->do_upload('image')) {
            $uploadData = $this->upload->data();
            $image_url = 'assets/uploads/' . $uploadData['file_name'];
        }

        $post_data = [
            'user_id'     => $user_id,
            'category_id' => $this->input->post('category_id'),
            'title'       => $this->input->post('title'),
            'description' => $this->input->post('description'),
            'price'       => $this->input->post('price'),
            'image_url'   => $image_url,
            'status'      => 'available'
        ];

        $this->Trade_model->insert_post($post_data);
        $this->session->set_flashdata('success', 'Đăng bài thành công!');
        redirect('trade');
    }

    // Chuyển trạng thái Đã Pass
    public function update_status($id) {
        $this->Trade_model->update_status($id, 'sold');
        $this->session->set_flashdata('success', 'Đã chuyển sang trạng thái Đã Pass thành công!');
        redirect('trade');
    }

    // Xóa bài đăng
    public function delete($id) {
        $this->Trade_model->delete_post($id);
        $this->session->set_flashdata('success', 'Đã xóa bài đăng!');
        redirect('trade');
    }
}

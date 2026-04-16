<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Comment extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Comment_model');
        $this->load->library('session');
        $this->load->helper(['url']);
    }

    // Thêm bình luận vào bài đăng
    public function add($post_id) {
        if (!$this->session->userdata('logged_in')) {
            $this->session->set_flashdata('error', 'Đăng nhập để bình luận!');
            redirect('auth');
            return;
        }

        $content = trim($this->input->post('content', TRUE));
        if (empty($content)) {
            redirect('trade/detail/' . $post_id);
            return;
        }

        $this->Comment_model->add_comment([
            'post_id'  => $post_id,
            'user_id'  => $this->session->userdata('user_id'),
            'content'  => $content
        ]);

        redirect('trade/detail/' . $post_id . '#comments');
    }

    // Xóa bình luận
    public function delete($id, $post_id) {
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
            return;
        }
        // TODO: kiểm tra quyền sở hữu comment ở bước nâng cao
        $this->Comment_model->delete_comment($id);
        redirect('trade/detail/' . $post_id . '#comments');
    }
}

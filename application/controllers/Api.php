<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * API Controller
 *
 * Cung cấp dữ liệu dưới định dạng JSON cho các client bên ngoài.
 *
 * @property CI_Output    $output
 * @property CI_Input     $input
 * @property Trade_model  $Trade_model
 */
class Api extends CI_Controller {

    public function __construct() {
        parent::__construct();

        // Load model cần thiết
        $this->load->model('Trade_model');

        // Thiết lập Content-Type mặc định là JSON cho toàn bộ class
        $this->output->set_content_type('application/json');

        // Cấu hình CORS cơ bản
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');

        // Xử lý preflight request của CORS
        if ($this->input->server('REQUEST_METHOD') === 'OPTIONS') {
            exit(0);
        }
    }

    // -----------------------------------------------------------------------
    // GET /api/posts
    // Trả về toàn bộ danh sách bài đăng (sách) đã được duyệt.
    // -----------------------------------------------------------------------
    public function posts() {
        $posts = $this->Trade_model->get_all_posts();

        if (!empty($posts)) {
            $response = [
                'status'  => 200,
                'message' => 'Thành công',
                'total'   => count($posts),
                'data'    => $posts,
            ];
        } else {
            $response = [
                'status'  => 404,
                'message' => 'Không tìm thấy dữ liệu',
                'data'    => [],
            ];
        }

        echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
}

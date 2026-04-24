<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * ============================================================
 * API Controller — Campus Trade Hub
 * ============================================================
 * Tuân theo nguyên tắc Single Responsibility (SRP):
 *   - Mỗi hàm public chỉ xử lý đúng một endpoint.
 *   - Logic trả về JSON được tách riêng vào helper _response_json().
 *   - Controller KHÔNG chứa câu SQL hay logic nghiệp vụ;
 *     tất cả được uỷ quyền cho Trade_model.
 *
 * Endpoints:
 *   GET    /api/posts              → Lấy tất cả bài đăng đã duyệt
 *   GET    /api/posts/search       → Lọc bài đăng theo danh mục / từ khoá
 *   GET    /api/posts/detail/:id   → Lấy chi tiết 1 bài đăng
 *   POST   /api/posts/create       → Tạo bài đăng mới qua API
 *   DELETE /api/posts/delete/:id   → Xóa bài đăng qua API
 *
 * @property CI_Output          $output
 * @property CI_Input           $input
 * @property CI_Form_validation $form_validation
 * @property Trade_model        $Trade_model
 */
class Api extends CI_Controller {

    // -----------------------------------------------------------------------
    // KHỞI TẠO
    // -----------------------------------------------------------------------

    public function __construct() {
        parent::__construct();

        // Bước 1: Load model và thư viện cần dùng
        $this->load->model('Trade_model');
        $this->load->library('form_validation');

        // Bước 2: Khai báo Content-Type mặc định là JSON cho toàn bộ Controller
        $this->output->set_content_type('application/json');

        // Bước 3: Cấu hình CORS — cho phép mọi client gọi API này
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');

        // Bước 4: Xử lý preflight request (trình duyệt gửi OPTIONS trước khi POST/DELETE)
        if ($this->input->server('REQUEST_METHOD') === 'OPTIONS') {
            exit(0);
        }
    }

    // -----------------------------------------------------------------------
    // HELPER PRIVATE — Trả về JSON chuẩn hoá
    // -----------------------------------------------------------------------

    /**
     * Xuất JSON và gắn HTTP Status Code tương ứng.
     *
     * @param  array  $data        Mảng dữ liệu cần trả về
     * @param  int    $status_code HTTP Status Code (200, 201, 400, 404, ...)
     * @return void
     */
    private function _response_json(array $data, int $status_code = 200): void {
        // Gắn status code vào HTTP response header
        $this->output->set_status_header($status_code);

        // Xuất JSON, giữ nguyên ký tự Unicode (tiếng Việt)
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    // -----------------------------------------------------------------------
    // GET /api/posts
    // Lấy toàn bộ danh sách bài đăng đã được duyệt (status = available/sold)
    // -----------------------------------------------------------------------

    public function posts(): void {
        // Gọi Model — Controller không tự truy vấn DB
        $posts = $this->Trade_model->get_all_posts();

        if (empty($posts)) {
            $this->_response_json([
                'status'  => 404,
                'message' => 'Không tìm thấy bài đăng nào.',
                'data'    => [],
            ], 404);
            return;
        }

        $this->_response_json([
            'status'  => 200,
            'message' => 'Thành công',
            'total'   => count($posts),
            'data'    => $posts,
        ]);
    }

    // -----------------------------------------------------------------------
    // GET /api/posts/search?cat=1&q=keyword
    // Lọc bài đăng theo danh mục (cat) và / hoặc từ khoá tìm kiếm (q)
    // Tách riêng khỏi posts() để đảm bảo SRP — mỗi hàm một nhiệm vụ
    // -----------------------------------------------------------------------

    public function search(): void {
        // Đọc tham số từ query string
        $category_id = $this->input->get('cat');
        $keyword     = $this->input->get('q');

        // Tái sử dụng get_all_posts() vì model đã hỗ trợ filter tham số
        $posts = $this->Trade_model->get_all_posts($category_id, $keyword);

        if (empty($posts)) {
            $this->_response_json([
                'status'  => 404,
                'message' => 'Không tìm thấy bài đăng phù hợp.',
                'filters' => ['category_id' => $category_id, 'keyword' => $keyword],
                'data'    => [],
            ], 404);
            return;
        }

        $this->_response_json([
            'status'  => 200,
            'message' => 'Thành công',
            'total'   => count($posts),
            'filters' => ['category_id' => $category_id, 'keyword' => $keyword],
            'data'    => $posts,
        ]);
    }

    // -----------------------------------------------------------------------
    // GET /api/posts/detail/:id
    // Lấy thông tin chi tiết của một bài đăng theo ID
    // -----------------------------------------------------------------------

    public function detail(int $id): void {
        // Kiểm tra ID hợp lệ trước khi gọi Model
        if (!$id || $id <= 0) {
            $this->_response_json([
                'status'  => 400,
                'message' => 'ID bài đăng không hợp lệ.',
            ], 400);
            return;
        }

        $post = $this->Trade_model->get_post_detail($id);

        if (empty($post)) {
            $this->_response_json([
                'status'  => 404,
                'message' => 'Không tìm thấy bài đăng với ID = ' . $id,
            ], 404);
            return;
        }

        $this->_response_json([
            'status'  => 200,
            'message' => 'Thành công',
            'data'    => $post,
        ]);
    }

    // -----------------------------------------------------------------------
    // POST /api/posts/create
    // Tạo bài đăng mới qua API (nhận dữ liệu dạng application/x-www-form-urlencoded)
    // -----------------------------------------------------------------------

    public function create_post_api(): void {
        // Bước 1: Chỉ chấp nhận phương thức POST
        if ($this->input->server('REQUEST_METHOD') !== 'POST') {
            $this->_response_json([
                'status'  => 405,
                'message' => 'Phương thức không được phép. Chỉ chấp nhận POST.',
            ], 405);
            return;
        }

        // Bước 2: Khai báo luật kiểm tra dữ liệu đầu vào (Validation Rules)
        $this->form_validation->set_rules('user_id',     'ID người dùng', 'required|integer');
        $this->form_validation->set_rules('category_id', 'Danh mục',      'required|integer');
        $this->form_validation->set_rules('title',       'Tiêu đề',       'required|min_length[5]|max_length[255]');
        $this->form_validation->set_rules('description', 'Mô tả',         'required|min_length[10]');
        $this->form_validation->set_rules('price',       'Giá',           'required|decimal');

        // Bước 3: Chạy kiểm tra — nếu thất bại, trả về danh sách lỗi dạng JSON
        if (!$this->form_validation->run()) {
            $this->_response_json([
                'status'  => 400,
                'message' => 'Dữ liệu đầu vào không hợp lệ.',
                'errors'  => $this->form_validation->error_array(),
            ], 400);
            return;
        }

        // Bước 4: Thu thập và làm sạch dữ liệu hợp lệ (XSS clean = TRUE)
        $post_data = [
            'user_id'     => (int) $this->input->post('user_id'),
            'category_id' => (int) $this->input->post('category_id'),
            'title'       => $this->input->post('title',       TRUE),
            'description' => $this->input->post('description', TRUE),
            'price'       => (float) $this->input->post('price'),
            'image_url'   => '',        // API version không hỗ trợ upload file
            'status'      => 'pending', // Bài đăng qua API luôn chờ duyệt
        ];

        // Bước 5: Uỷ quyền cho Model thực hiện INSERT — Controller không tự viết SQL
        $inserted = $this->Trade_model->insert_post($post_data);

        if (!$inserted) {
            $this->_response_json([
                'status'  => 500,
                'message' => 'Lỗi máy chủ: Không thể tạo bài đăng. Vui lòng thử lại.',
            ], 500);
            return;
        }

        $this->_response_json([
            'status'  => 201,
            'message' => 'Tạo bài đăng thành công! Bài đang chờ Admin duyệt.',
        ], 201);
    }

    // -----------------------------------------------------------------------
    // DELETE /api/posts/delete/:id
    // Xóa một bài đăng theo ID (minh hoạ đầy đủ RESTful CRUD qua API)
    // -----------------------------------------------------------------------

    public function delete_post_api(int $id): void {
        // Bước 1: Chỉ chấp nhận phương thức DELETE
        if ($this->input->server('REQUEST_METHOD') !== 'DELETE') {
            $this->_response_json([
                'status'  => 405,
                'message' => 'Phương thức không được phép. Chỉ chấp nhận DELETE.',
            ], 405);
            return;
        }

        // Bước 2: Kiểm tra bài đăng có tồn tại không trước khi xóa
        $post = $this->Trade_model->get_post_by_id($id);

        if (empty($post)) {
            $this->_response_json([
                'status'  => 404,
                'message' => 'Không tìm thấy bài đăng với ID = ' . $id,
            ], 404);
            return;
        }

        // Bước 3: Uỷ quyền cho Model thực hiện DELETE
        $deleted = $this->Trade_model->delete_post($id);

        if (!$deleted) {
            $this->_response_json([
                'status'  => 500,
                'message' => 'Lỗi máy chủ: Không thể xóa bài đăng.',
            ], 500);
            return;
        }

        $this->_response_json([
            'status'  => 200,
            'message' => 'Xóa bài đăng ID = ' . $id . ' thành công.',
        ]);
    }
}

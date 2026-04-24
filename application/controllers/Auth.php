<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_Session $session
 * @property CI_Input $input
 * @property Auth_model $Auth_model
 */
class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Auth_model');
        $this->load->library(['session', 'form_validation']);
        $this->load->helper(['form', 'url']);
    }

    // Trang đăng nhập
    public function index() {
        if ($this->session->userdata('user_id')) {
            redirect('trade');
        }
        $this->load->view('auth/login');
    }

    // Xử lý đăng nhập
    public function login_post() {
        $email    = $this->input->post('email');
        $password = $this->input->post('password');

        $user = $this->Auth_model->get_user_by_email($email);

        if ($user && password_verify($password, $user['password'])) {
            $session_data = [
                'user_id'   => $user['id'],
                'username'  => $user['username'],
                'full_name' => $user['full_name'],
                'role'      => $user['role'],
                'logged_in' => TRUE
            ];
            $this->session->set_userdata($session_data);
            redirect('trade');
        } else {
            $this->session->set_flashdata('error', 'Email hoặc mật khẩu không đúng!');
            redirect('auth');
        }
    }

    // Trang đăng ký
    public function register() {
        if ($this->session->userdata('user_id')) {
            redirect('trade');
        }
        $this->load->view('auth/register');
    }

    // Xử lý đăng ký
    public function register_post() {
        $email    = $this->input->post('email', TRUE);
        $username = $this->input->post('username', TRUE);
        $password = $this->input->post('password');
        $confirm  = $this->input->post('confirm_password');
        $full_name = $this->input->post('full_name', TRUE);

        // Kiểm tra trống
        if (empty($email) || empty($username) || empty($password) || empty($full_name)) {
            $this->session->set_flashdata('error', 'Vui lòng nhập đầy đủ các trường bắt buộc!');
            redirect('auth/register');
            return;
        }

        // Kiểm tra mật khẩu khớp
        if ($password !== $confirm) {
            $this->session->set_flashdata('error', 'Mật khẩu xác nhận không khớp!');
            redirect('auth/register');
            return;
        }

        // Kiểm tra email đã tồn tại
        if ($this->Auth_model->get_user_by_email($email)) {
            $this->session->set_flashdata('error', 'Email này đã được đăng ký!');
            redirect('auth/register');
            return;
        }

        // Kiểm tra username đã tồn tại
        if ($this->Auth_model->get_user_by_username($username)) {
            $this->session->set_flashdata('error', 'Tên đăng nhập đã tồn tại!');
            redirect('auth/register');
            return;
        }

        $data = [
            'full_name' => $this->input->post('full_name', TRUE),
            'username'  => $username,
            'email'     => $email,
            'password'  => password_hash($password, PASSWORD_DEFAULT),
            'phone'     => $this->input->post('phone', TRUE),
            'phone_visible' => 0,
            'role'      => 'user'
        ];

        $this->Auth_model->create_user($data);
        $this->session->set_flashdata('success', 'Đăng ký thành công! Hãy đăng nhập.');
        redirect('auth');
    }

    // Đăng xuất
    public function logout() {
        $this->session->sess_destroy();
        redirect('auth');
    }
}

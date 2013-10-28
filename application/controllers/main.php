<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Main extends CI_Controller {

    public function __construct() {
        parent::__construct();
        session_start();
        $this->cart->product_name_rules = '\.\:\-_ a-z0-9\d\D';
    }

    //For SEO friendliness
    function _remap($method, $params = array()) {
        $method = str_replace('-', '_', $method);
        method_exists($this, $method) ? call_user_func_array(array($this, $method), $params) : show_404();
    }

    public function admin() {
        $_SESSION['current_view'] = 'Administration Login';
        !empty($_SESSION['admin_id']) ? redirect('main/administration-dashboard') : $this->load->view('administration-login');
    }

    public function logout() {
        //session_destroy();
        $_SESSION['userID'] = '';
        //$this->load->library('session');
        $this->session->set_flashdata('flashSuccess', 'You have logged out successfully.');
        redirect('main/home');
    }

    public function adminLogout() {
        $_SESSION['admin_id'] = '';
        redirect('main/admin');
    }

    public function my_account() {
        //we need if else statement here if logged in or logged out
        $_SESSION['current_view'] = 'Customer Login';
        $this->load->view('header');
        $this->login();
        $this->load->view('global-search');
        $this->global_navigation();

        if (!empty($_SESSION['userID']))
            $this->load->view('my-account');
        else {
            $this->load->view('customer-login');
            $this->load->view('create-an-account');
        }

        $this->load->view('copyright');
    }

    public function index() {
        $this->home();
    }

    //function for loading public board view
    public function home() {
        $_SESSION['current_view'] = 'Home Page';
        $this->load->view('header');
        $this->login();
        $this->load->view('global-search');
        $this->global_navigation();
        $this->categories_navigation();
        $this->load->view('newsletter');
        $this->load->view('social-links');
        $this->load->view('slideshow');
        $this->load->view('e-world-information');
        $this->load->view('footer');
        $this->load->view('copyright');
    }

    //function for loading about us view
    public function about_us() {
        $_SESSION['current_view'] = 'About Us';
        $this->load->model("getdb");
        $data["results"] = $this->getdb->getBlock('___ADMIN_EDITOR___ABOUT');
        $this->load->view('header');
        $this->login();
        $this->load->view('global-search');
        $this->global_navigation();
        $this->categories_navigation();
        $this->load->view('newsletter');
        $this->load->view('social-links');
        $this->load->view('about-us', $data);
        $this->load->view('footer');
        $this->load->view('copyright');
    }

    //function for loading how can we help view
    public function how_can_we_help() {
        $_SESSION['current_view'] = 'How Can We Help';
        $this->load->model("getdb");
        $data["results"] = $this->getdb->getBlock("___ADMIN_EDITOR___HOW_WE_CAN_HELP");
        $this->load->view('header');
        $this->login();
        $this->load->view('global-search');
        $this->global_navigation();
        $this->categories_navigation();
        $this->load->view('newsletter');
        $this->load->view('social-links');
        $this->load->view('how-can-we-help', $data);
        $this->load->view('footer');
        $this->load->view('copyright');
    }

    //function for loading our location view
    public function our_location() {
        $_SESSION['current_view'] = 'Our Location';
        $this->load->model("getdb");
        $data["results"] = $this->getdb->getBlock("___ADMIN_EDITOR___OUR_LOCATION");
        $this->load->view('header');
        $this->login();
        $this->load->view('global-search');
        $this->global_navigation();
        $this->categories_navigation();
        $this->load->view('newsletter');
        $this->load->view('social-links');
        $this->load->view('our-location', $data);
        $this->load->view('footer');
        $this->load->view('copyright');
    }

    //function for loading contact us view
    public function contact_us() {
        $_SESSION['current_view'] = 'Contact Us';
        $this->load->view('header');
        $this->login();
        $this->load->view('global-search');
        $this->global_navigation();
        $this->categories_navigation();
        $this->load->view('newsletter');
        $this->load->view('social-links');
        $this->load->model('getdb');
        $data["results"] = $this->load->getdb->getBlock('___ADMIN_EDITOR___CONTACTUS');
        $this->load->view('contact-us', $data);
        $this->load->view('footer');
        $this->load->view('copyright');
    }

    //function for loading privacy policy view
    public function privacy_policy() {
        $_SESSION['current_view'] = 'Privacy Policy';
        $this->load->view('header');
        $this->login();
        $this->load->view('global-search');
        $this->global_navigation();
        $this->categories_navigation();
        $this->load->view('newsletter');
        $this->load->view('social-links');
        $this->load->model("getdb");
        $data['results'] = $this->load->getdb->getBlock('___ADMIN_EDITOR___PRIVACYPOLICY');
        $this->load->view('privacy-policy', $data);
        $this->load->view('footer');
        $this->load->view('copyright');
    }

    //function for loading contact us view
    public function create_an_account() {
        $_SESSION['current_view'] = 'Create An Account';
        $this->load->view('header');
        $this->login();
        $this->load->view('global-search');
        $this->global_navigation();
        $this->load->view('create-an-account');
        $this->load->view('copyright');
    }

    public function products($id = null) {
        if (empty($id))
            $id = 95;
        $this->load->library('pagination');

        $config['base_url'] = base_url() . "main/products/$id";
        $config['uri_segment'] = 4;
        $config['full_tag_open'] = '<div class="pagination">';
        $config['full_tag_close'] = '</div>';
        $config['first_link'] = '&lt&ltFirst';
        $config['last_link'] = 'Last&gt&gt';
        $config['next_link'] = 'Next&gt';
        $config['prev_link'] = '&ltPrevious';
        $config['per_page'] = 3;
        $config['use_page_numbers'] = true;
        $this->load->model('getdb');
        $data['product'] = $this->getdb->product($id, $config['per_page'], $this->uri->segment(4) ? ($this->uri->segment(4) - 1) * $config['per_page'] : 0);
        $config['total_rows'] = $this->getdb->total($id);
        $_SESSION['id'] = $id;
        $_SESSION['page'] = base_url() . 'main/products/' . $id . '/' . $this->uri->segment(4);

        if (!empty($data['product']))
            $_SESSION['current_view'] = $data['product'][count($data['product']) - 1]['name_en'];
        else
            $_SESSION['current_view'] = $this->getdb->getProdName($id);

        $this->pagination->initialize($config);
        $data['links'] = $this->pagination->create_links();
        $this->load->view('header');
        $this->login();
        $this->load->view('global-search');
        $this->global_navigation();
        $this->categories_navigation();
        $this->load->view('newsletter');
        $this->load->view('social-links');
        $this->load->view('products-page', $data);
        $this->load->view('footer');
        $this->load->view('copyright');
    }

    public function product_focus($productid = null) {
        $this->load->model('getdb');
        $data['product'] = $this->getdb->productbyid($productid);
        $this->load->view('header', $data);
        $this->login();
        $this->load->view('global-search');
        $this->global_navigation();
        $this->categories_navigation();
        $this->load->view('newsletter');
        $this->load->view('social-links');
        $this->load->view('product-focus', $data);
        if (!empty($data['product']))
            $this->load->view('add-to-cart');
        $this->load->view('footer');
        $this->load->view('copyright');
    }

    public function getcategory($productid = null) {
        $this->load->model('getdb');
        $category = $this->getdb->getcategory($productid);
        return $category;
    }

//function for loading login form or logout button
    public function login() {
        if (!empty($_SESSION['userID'])) {
            $this->load->model('getdb');
            $data['userInfo'] = $this->getdb->getUserData($_SESSION['userID']);
            $this->load->view("logged-in", $data);
        } else {
            $this->load->view("logged-in");
        }
    }

    public function global_navigation() {
        $this->load->model('getdb');
        $data['results'] = $this->getdb->getBlock('___ADMIN_EDITOR___TOPMENU');
        $this->load->view('global-navigation', $data);
    }

    public function categories_navigation() {
        $this->load->model('getdb');
        $data['categories'] = $this->getdb->getCategories();
        $this->load->view('categories-navigation', $data);
    }

    public function result() {
        $data['searchResult'] = array();

        if (trim($this->input->get('search')) != '') {
            $this->load->model('getdb');
            $data['searchResult'] = $this->getdb->getSearchResult(mysql_real_escape_string(trim($this->input->get('search'))));
        }
        else
            $data['searchResult'] = '';

        $_SESSION['current_view'] = 'Search Result for \'' . mysql_real_escape_string(trim($this->input->get('search'))) . '\'';
        $_SESSION['page'] = base_url() . 'main/result?search=' . mysql_real_escape_string(trim($this->input->get('search')));
        $this->load->view('header');
        $this->login();
        $this->load->view('global-search');
        $this->global_navigation();
        $this->categories_navigation();
        $this->load->view('newsletter');
        $this->load->view('social-links');
        $this->load->view('search-result', $data);
        $this->load->view('footer');
        $this->load->view('copyright');
    }

    //function for validating login form
    public function login_validation() {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('login-email', 'email', 'required|xss_clean|trim|callback_validateCredentials');
        $this->form_validation->set_rules('login-password', 'password', 'required|min_length[6]|max_length[15]|sha1|xss_clean');

        if ($this->form_validation->run()) {
            $this->load->model('getdb');
            $_SESSION['email'] = $this->input->post('login-email');
            $_SESSION['userID'] = $this->getdb->getUserID($_SESSION['email']);
            $_SESSION['userInfo'] = $this->getdb->getUserData($_SESSION['userID']);

            //current page
            ($_SESSION['current_view'] == 'create-an-account') ? $this->home() : redirect($_SERVER['HTTP_REFERER']);
        } else {
            $this->load->library('session');
            $this->session->set_flashdata('flashError', 'Please enter correct email or password.');
            redirect('main/my-account');
            //$this->createAccount();
        }
    }

    //function for calling function in model to verify login
    public function validateCredentials() {
        $this->load->model('getdb');
        if ($this->getdb->checkLogin()) {
            return true;
        } else {
            /*             * *********NEED TO ECHO VALIDATION ERRORS********** */
            $this->form_validation->set_message('validateCredentials', 'Incorrect username/password');
            return false;
        }
    }

    //validate the create account form
    public function validateCreateAccount() {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('email', 'email', 'required|valid_email|trim|xss_clean|max_length[100]|callback_verifyAvailable[' . "customer" . ']');
        $this->form_validation->set_rules('password', 'password', 'required|trim|matches[confirm-password]|sha1|xss_clean');
        $this->form_validation->set_rules('confirm-password', 'confirm-password', 'required|trim|sha1|xss_clean|callback_confirmPassword');

        if ($this->form_validation->run()) {

            $this->load->model('getdb');
            $_SESSION['email'] = $this->input->post('email');
            $password = $this->input->post('password');
            $this->getdb->insertValues('customer', "email, password", "'$_SESSION[email]', '$password'");
            $_SESSION['userID'] = $this->getdb->getUserID($_SESSION['email']);
            $this->edit_profile();
        } else {
            //refresh page
            //
            // Display error message
            $this->load->library('session');
            $this->session->set_flashdata('flashError', 'Email already exists. Please use a new email.');
            $this->my_account();
        }
    }

    //make sure email doesn't exist in database
    public function verifyAvailable($value, $table) {
        $this->load->model('getdb');
        if (!($this->getdb->doesEmailExist($table))) {
            return true;
        } else {
            $this->form_validation->set_message('verifyAvailable', 'Email already in use');
            $_SESSION['test'] = $this->form_validation->verifyAvailable;
            return false;
        }
    }

    //verify both inputted passwords are the same
    public function confirmPassword() {
        if ($this->input->post('password') === $this->input->post('confirm-password')) {
            return true;
        } else {
            $this->form_validation->set_message('confirmPassword', 'The passwords do not match');
            return false;
        }
    }

    public function edit_profile() {
        $_SESSION['current_view'] = 'Edit Profile';
        $this->load->view('header');
        $this->login();
        $this->load->view('global-search');
        $this->global_navigation();
        !empty($_SESSION['userID']) ? $this->load->view('edit-profile') : $this->load->view('customer-login');
    }

//validate the edit profile form
    public function validateEditProfile() {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('first-name', 'firstName', 'required|trim|xss_clean|max_length[25]');
        $this->form_validation->set_rules('last-name', 'lastName', 'required|trim|xss_clean|max_length[45]');
        $this->form_validation->set_rules('address', 'address', 'required|trim|xss_clean');
        $this->form_validation->set_rules('city', 'city', 'required|trim|xss_clean');
        $this->form_validation->set_rules('state', 'state', 'required|trim|xss_clean|max_length[2]');
        $this->form_validation->set_rules('zipcode', 'zipcode', 'required|trim|xss_clean');
        $this->form_validation->set_rules('phone', 'phone', 'required|trim|xss_clean');

        if ($this->form_validation->run()) {
            $this->add_customer();
            redirect('main/home');
        } else {
            $this->form_validation->set_message('validateEditProfile', 'Invalid input');
            $this->edit_profile();
        }
    }

    //add/modify user info
    public function add_customer() {
        $this->load->model('getdb');

        $insertFields = "id, fname, lname, address, city, state, zipcode, phone";
        $fname = mysql_real_escape_string($this->input->post('first-name'));
        $lname = mysql_real_escape_string($this->input->post('last-name'));
        $address = mysql_real_escape_string($this->input->post('address'));
        $city = mysql_real_escape_string($this->input->post('city'));
        $state = mysql_real_escape_string($this->input->post('state'));
        $zipcode = mysql_real_escape_string($this->input->post('zipcode'));
        $phone = mysql_real_escape_string($this->input->post('phone'));
        $insertValues = "'$fname', '$lname', '$address', '$city', '$state', '$zipcode', '$phone'";
        $updateValues = array($fname, $lname, $address, $city, $state, $zipcode, $phone);
        $updateFields = array('fname', 'lname', 'address', 'city', 'state', 'zipcode', 'phone');

        if ($this->getdb->doesUserExist($_SESSION['userID']))
            $this->getdb->updateUser($_SESSION['userID'], $updateFields, $updateValues);
        else
            $this->getdb->insertValues('customer', $insertFields, $insertValues);
    }

//function for validating login form
    public function admin_login_validation() {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('admin-name', 'admin-name', 'required|xss_clean|trim|callback_validateAdminCredentials');
        $this->form_validation->set_rules('admin-password', 'admin-password', 'required|min_length[6]|max_length[15]|sha1|xss_clean');

        if ($this->form_validation->run()) {
            $this->load->model('getdb');
            $_SESSION['admin_name'] = $this->input->post('admin-name');
            $_SESSION['admin_id'] = $this->getdb->getAdminID($_SESSION['admin_name']);

            //current page
            ($_SESSION['current_view'] == 'Administration Login') ? redirect('main/administration-dashboard') : redirect($_SERVER['HTTP_REFERER']);
        } else {
            $this->load->library('session');
            $this->session->set_flashdata('flashError', 'Please enter correct email or password.');
            redirect('main/admin');
        }
    }

    //function for calling function in model to verify login
    public function validateAdminCredentials() {
        $this->load->model('getdb');
        if ($this->getdb->checkAdminLogin()) {
            return true;
        } else {
            /*             * *********NEED TO ECHO VALIDATION ERRORS********** */
            $this->form_validation->set_message('validateCredentials', 'Incorrect username/password');
            return false;
        }
    }

    public function administration_dashboard() {
        $_SESSION['current_view'] = "Administration Dashboard";
        !empty($_SESSION['admin_id']) ? $this->load->view('administration-dashboard') : redirect('main/admin');
    }

    public function temp() {
        $this->load->model('getdb');
        $data['categories'] = $this->getdb->getCategories();
        $this->load->view('edit', $data);
    }

    public function modify($value) {
        $this->load->model('getdb');
        if ($this->input->post('name') == '')
            $this->getdb->delete(mysql_real_escape_string($this->input->post('name')));
        else
            $this->getdb->update(mysql_real_escape_string($this->input->post('name'), $value));
    }

    public function insert() {
        $this->load->model('getdb');
        if ($this->input->post('name') != '')
            $this->getdb->insert(mysql_real_escape_string($this->input->post('name')));
    }

    public function addToCart() {
        $this->load->model('getdb');
        $product = $this->getdb->productbyid($_POST['id']);

        if (empty($_POST['rowid'])) {
            $data = array(
                'id' => $_POST['id'],
                'img' => $product['image'],
                'qty' => $_POST['qty'],
                'price' => number_format($product['price'], 2, '.', ''),
                'name' => $product['name_en'],
            );
            $_SESSION['product_name'] = $this->cart->insert($data) ? $product['name_en'] . " was added to your shopping cart." : '';
        } else {
            $data = array(
                'rowid' => $_POST['rowid'],
                'qty' => $_POST['qty'],
            );
            $_SESSION['product_name'] = $this->cart->update($data) ? $product['name_en'] . " was updated in your shopping cart." : '';
        }

        $this->shopping_cart();
    }

    public function update_cart() {
        print_r($this->input->post('item'));
        $data = array();
        foreach ($this->input->post('item') as $rowid => $qty) {
            $data[] = array(
                'rowid' => $rowid,
                'qty' => $qty
            );
        }

        $_SESSION['product_name'] = $this->cart->update($data) ? 'You shopping cart has been updated.' : 'Uhm...you didn\'t make any changes!';
        redirect('main/shopping-cart');
    }

    public function remove_item($rowid) {
        $data = array(
            'rowid' => $rowid,
            'qty' => 0
        );
        $name = $this->cart->contents()[$rowid]['name'];
        $_SESSION['product_name'] = $this->cart->update($data) ? $name . ' was removed from the shopping cart.' : '';
        redirect('main/shopping-cart');
    }

    public function shopping_cart() {
        $_SESSION['current_view'] = 'Shopping Cart';
        $this->load->view('header');
        $this->login();
        $this->load->view('global-search');
        $this->global_navigation();
        $this->categories_navigation();
        $this->load->view('newsletter');
        $this->load->view('social-links');
        $this->load->view('shopping-cart');
        $this->load->view('footer');
        $this->load->view('copyright');
    }

    public function subscribe() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'email', 'required|trim|xss_clean|valid_email|max_length[100]|callback_verifyAvailable[' . "tbl_newsletter" . ']');

        if ($this->form_validation->run()) {
            $this->load->model('getdb');
            $this->getdb->insertValues('tbl_newsletter', 'email', "'" . $this->input->post('email') . "'");
            $_SESSION['test'] = "You have successfully subscribed!";
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            $_SESSION['test'] = "Invalid Email or Email already exists.";
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function service_status() {
        $_SESSION['current_view'] = 'service status';
        $this->load->model('getdb');

        if (!empty($_SESSION['userID'])) {
            $this->load->view('header');
            $this->login();
            $this->load->view('global-search');
            $this->global_navigation();
            $data['services'] = $this->getdb->getServicedItems($_SESSION['userID']);
            $this->load->view('service-status', $data);
        }
        else
            $this->my_account();

        $this->load->view('copyright');
    }

    public function ajax_get_customers() {
        //header('Content-type: text/plain');
        $this->load->model('getdb');
        $data['customer'] = $this->getdb->getCustomers();
        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($data['customer']));
        //$this->output->set_output(json_encode($data));
    }

    public function ajax_get_services() {
        //header('Content-type: text/plain');
        $this->load->model('getdb');
        $data['service'] = $this->getdb->getServiceStatus();
        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($data['service']));
        //$this->output->set_output(json_encode($data));
    }

    public function ajax_add_service_item() {
        //header('Content-type: text/plain');
        $this->load->model('getdb');
        $postedValue = $this->input->post();
        $this->getdb->insertServiceItem($postedValue);
        $this->output->set_output(json_encode($postedValue));
        //$this->output->set_output(json_encode($data));
    }

    public function ajax_update_service_item() {
        //header('Content-type: text/plain');
        $this->load->model('getdb');
        $postedValue = $this->input->post();
        $this->getdb->updateServiceItem($postedValue);
        $this->output->set_output(json_encode($postedValue));
        //$this->output->set_output(json_encode($data));
    }

    public function ajax_remove_service_item() {
        //header('Content-type: text/plain');
        $this->load->model('getdb');
        $postedValue = $this->input->post();
        $this->getdb->removeServiceItem($postedValue);
        $this->output->set_output(json_encode($postedValue));
        //$this->output->set_output(json_encode($data));
    }

    public function admin_service_page() {
        $this->load->model('getdb');
        $data['customer'] = $this->getdb->getCustomers();
        //$data['service'] = $this->getdb->getServiceStatus();
        $this->load->view('header');
        $this->login();
        $this->load->view('global-search');
        $this->global_navigation();
        $this->load->view('admin-service-page', $data);
        $this->load->view('copyright');
    }

    public function invoice() {
        $this->createInvoice();
        $_SESSION['current_view'] = 'Invoice';
        $this->load->view('header');
        $this->login();
        $this->load->view('global-search');
        $this->global_navigation();
        $this->categories_navigation();
        $this->load->view('newsletter');
        $this->load->view('social-links');
        $this->load->model('getdb');
        if (!empty($_SESSION['userID'])) {
            $data['invoices'] = $this->getdb->getInvoices($_SESSION['userID']);
        } else {
            $data['invoices'] = "";
        }
        $this->load->view('invoice', $data);
        $this->load->view('footer');
        $this->load->view('copyright');
    }

    public function invoice_focus($id) {
        $this->load->model('getdb');
        $data['invoice'] = $this->getdb->getInvoiceById($id);
        $data['customer'] = $this->getdb->getUserData($_SESSION['userID']);
        $this->load->view('invoice-focus', $data);
    }

    public function createInvoice() {
        $this->load->model('getdb');
        $id = $this->getdb->insertValues('tbl_invoice', "customer_id, date, time", "$_SESSION[userID], CURDATE(), CURTIME()");
        foreach ($this->cart->contents() as $items) {
            $this->getdb->insertValues('tbl_product_list', "customer_id, invoice_id, product_id, qty", "$_SESSION[userID], $id, $items[id], $items[qty]");
        }
        $this->destroy();
    }

    private function destroy() {
        $this->cart->destroy();
    }
}

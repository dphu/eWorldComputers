<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Products extends CI_Controller {

    //For SEO friendliness
    function _remap($method) {
        $method = str_replace('-', '_', $method);
        method_exists($this, $method) ? $this->$method() : show_404();
    }

    public function desktops() {
        $_SESSION['current_view'] = 'Desktops';
        $this->load->library('../controllers/main');
        $this->load->model('getdb');
        $this->load->view('header');
        $this->load->view('global-search');
        $this->load->view('global-navigation');
        $this->load->view('catalog-navigation');
        $this->load->view('newsletter');
        $this->load->view('social-links');
        $this->load->view('desktops');
        $this->load->view('footer');
    }

}
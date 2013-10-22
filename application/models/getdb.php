<?php

class GetDB extends CI_Model {

    public function getCategories() {
        $query = $this->db->query('SELECT name_en, parent_id, id FROM tbl_cat_products WHERE display = 1');
        return $query->result_array();
    }

    //function for comparing login data with LoginInfo table
    public function checkLogin() {
        $this->db->where('email', $this->input->post('login-email'));
        $this->db->where('password', sha1($this->input->post('login-password')));
        $query = $this->db->get('customer');

        if ($query->num_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function checkAdminLogin() {
        $this->db->where('name', $this->input->post('admin-name'));
        $this->db->where('password', sha1($this->input->post('admin-password')));
        $query = $this->db->get('admin');

        if ($query->num_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }

    //return the id of user with given email
    public function getUserID($email) {
        $query = $this->db->query("SELECT id FROM customer WHERE email = '$email'");
        return $query->row()->id;
    }

    public function getAdminID($name) {
        $query = $this->db->query("SELECT admin_id FROM admin WHERE name = '$name'");
        return $query->row()->admin_id;
    }

    //returns user data based on user ID
    public function getUserData($userID) {
        $query = $this->db->query("SELECT * FROM customer WHERE id = $userID");
        return $query->row();
    }

    public function insertValues($table, $fields, $values) {
        $query = mysql_query("INSERT INTO $table ($fields) VALUES ($values)");
        return mysql_insert_id();
    }

    //check to see if email exists in database for a user
    public function doesEmailExist() {
        $email = $this->input->post('email');
        $query = $this->db->query("SELECT * FROM customer WHERE email = '$email'");
        if ($query->num_rows() == 1) {
            return true;
        }
        return false;
    }

    public function updateUser($userID, $fields, $values) {
        for ($i = 0; $i < count($fields); $i++) {
            $query = $this->db->query("UPDATE customer set $fields[$i] = '" . $values[$i] . "' WHERE id = $userID");
        }
    }

    //check to see if a user exists before calling insert vs update
    public function doesUserExist($userID) {
        $query = $this->db->query("SELECT * FROM customer WHERE id = $userID");
        if ($query->num_rows() == 1) {
            return true;
        }
        return false;
    }

    public function total($id) {
        $query = $this->db->query("SELECT id, name_en, price, image FROM tbl_products WHERE cat_id = $id");
        return $query->num_rows();
    }

    public function getProdName($id) {
        $query = $this->db->query("SELECT name_en FROM tbl_cat_products WHERE id = $id");
        return $query->row()->name_en;
    }

    public function product($id, $limit, $start) {
        $query = $this->db->query("SELECT p.id, p.name_en AS product_name_en, c.name_en, price, image FROM tbl_products AS p INNER JOIN tbl_cat_products AS c ON(p.cat_id = c.id) WHERE p.cat_id = $id LIMIT $start, $limit");
        return $query->result_array();
    }

    public function productById($id) {
        $query = $this->db->query("SELECT cat_id, id, name_en, price, image, desc_en, quantity FROM tbl_products WHERE id = $id");
        return $query->row_array();
    }

    public function getSearchResult($search) {
        $searchTerms = explode(' ', $search);
        $searchName = array();
        $searchSku = array();
        $searchDesc = array();

        foreach ($searchTerms as $term) {
            $term = strtoupper($term);
            $searchName[] = "UPPER(name_en) LIKE '%$term%'";
            $searchSku[] = "code LIKE '%$term%'";
            $searchDesc[] = "UPPER(desc_en) LIKE '%$term%'";
        }

        $query = $this->db->query("SELECT DISTINCT * FROM tbl_products WHERE " . implode(' AND ', $searchName) . " OR " . implode(' AND ', $searchSku) . " OR " . implode(' AND ', $searchDesc));
        return $query->result_array();
    }

    public function getBlock($blockName) {
        $query = $this->db->get_where('tbl_interface_manager', array('blockid' => $blockName));
        return $query->row_array();
    }
}

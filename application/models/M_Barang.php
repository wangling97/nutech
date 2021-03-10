<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Barang extends CI_Model {

    public function fetch($id_barang = null)
    {
        if ($id_barang) {
            $this->db->where('id_barang', $id_barang);
            return $this->db->get('tbl_barang')->row_array();
        } else {
            return $this->db->get('tbl_barang')->result_array();
        }        
    }

    public function insert($data)
    {
        $this->db->insert('tbl_barang', $data);
        return $this->db->insert_id();
    }

    public function update($id_barang, $data)
    {
        $this->db->update('tbl_barang', $data, ['id_barang' => $id_barang]);
        return $this->db->affected_rows();
    }

    public function delete($id_barang)
    {
        $this->db->delete('tbl_barang', ['id_barang' => $id_barang]);
        return $this->db->affected_rows();
    }

}

/* End of file M_Barang.php */

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barang extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_Barang');
    }

    public function index()
    {
        $this->form_validation->set_rules('nama_barang', 'Nama Barang', 'trim|required', array(
            'required' => '{field} wajib di isi.'
        ));
        $this->form_validation->set_rules('harga_beli', 'Harga Beli', 'trim|required|numeric|greater_than[0]', array(
            'required' => '{field} wajib di isi.',
            'numeric' => '{field} hanya boleh di isi angka.',
            'greater_than' => '{field} tidak boleh kurang dari {param}.'
        ));
        $this->form_validation->set_rules('harga_jual', 'Harga Jual', 'trim|required|numeric|greater_than[0]', array(
            'required' => '{field} wajib di isi.',
            'numeric' => '{field} hanya boleh di isi angka.',
            'greater_than' => '{field} tidak boleh kurang dari {param}.'
        ));
        $this->form_validation->set_rules('stok_barang', 'Stok Barang', 'trim|required|numeric', array(
            'required' => '{field} wajib di isi.',
            'numeric' => '{field} hanya boleh di isi angka.'
        ));

        if ($this->form_validation->run() == FALSE) {
            $data['barang'] = $this->M_Barang->fetch();
            $this->load->view('v_barang', $data);
        } else {
            if ($this->_uploadFotoBarang()) {

                $data = array(
                    'nama_barang' => $this->input->post('nama_barang'),
                    'harga_beli' => $this->input->post('harga_beli'),
                    'harga_jual' => $this->input->post('harga_jual'),
                    'stok' => $this->input->post('stok_barang'),
                    'foto_barang' => $this->upload->data('file_name'),
                    'created_at' => date('Y-m-d h:i:s'),
                    'updated_at' => date('Y-m-d h:i:s')
                );

                $this->M_Barang->insert($data);
                $this->_setAlert('message', 'success', 'Barang berhasil ditambahkan.');
                redirect('/');
            }
        }
    }

    public function edit()
    {
        $this->form_validation->set_rules('edit_nama_barang', 'Nama Barang', 'trim|required', array(
            'required' => '{field} wajib di isi.'
        ));
        $this->form_validation->set_rules('edit_harga_beli', 'Harga Beli', 'trim|required|numeric|greater_than[0]', array(
            'required' => '{field} wajib di isi.',
            'numeric' => '{field} hanya boleh di isi angka.',
            'greater_than' => '{field} tidak boleh kurang dari {param}.'
        ));
        $this->form_validation->set_rules('edit_harga_jual', 'Harga Jual', 'trim|required|numeric|greater_than[0]', array(
            'required' => '{field} wajib di isi.',
            'numeric' => '{field} hanya boleh di isi angka.',
            'greater_than' => '{field} tidak boleh kurang dari {param}.'
        ));
        $this->form_validation->set_rules('edit_stok_barang', 'Stok Barang', 'trim|required|numeric', array(
            'required' => '{field} wajib di isi.',
            'numeric' => '{field} hanya boleh di isi angka.'
        ));


        if ($this->form_validation->run() == FALSE) {
        } else {
            $id_barang = $this->input->post('edit_id_barang');
            $barang = $this->M_Barang->fetch($id_barang);

            $foto_barang = $barang['foto_barang'];

            if ($_FILES['edit_foto_barang']['name'] != FALSE) {
                if ($this->_uploadSecondFotoBarang($foto_barang)) {

                    $data = array(
                        'nama_barang' => $this->input->post('edit_nama_barang'),
                        'harga_beli' => $this->input->post('edit_harga_beli'),
                        'harga_jual' => $this->input->post('edit_harga_jual'),
                        'stok' => $this->input->post('edit_stok_barang'),
                        'foto_barang' => $this->upload->data('file_name'),
                        'updated_at' => date('Y-m-d h:i:s')
                    );

                    $this->M_Barang->update($id_barang, $data);
                    $this->_setAlert('message', 'success', 'Barang berhasil diubah.');
                    redirect('/');
                }
            } else {
                $data = array(
                    'nama_barang' => $this->input->post('edit_nama_barang'),
                    'harga_beli' => $this->input->post('edit_harga_beli'),
                    'harga_jual' => $this->input->post('edit_harga_jual'),
                    'stok' => $this->input->post('edit_stok_barang'),
                    'updated_at' => date('Y-m-d h:i:s')
                );

                $this->M_Barang->update($id_barang, $data);
                $this->_setAlert('message', 'success', 'Barang berhasil diubah.');
                redirect('/');
            }
        }
    }

    public function hapus()
    {
        $id_barang = $this->input->post('id_barang');
        $barang = $this->M_Barang->fetch($id_barang);

        unlink(FCPATH . 'assets/img/barang/' . $barang['foto_barang']);
        $this->M_Barang->delete($id_barang);
        $this->_setAlert('message', 'success', 'Barang berhasil dihapus.');
        redirect('/');
    }

    public function fetch()
    {
        $id_barang = $this->input->post('id_barang');
        $barang = $this->M_Barang->fetch($id_barang);
        echo json_encode($barang);
    }

    private function _uploadFotoBarang()
    {
        $config['upload_path']      = './assets/img/barang';
        $config['allowed_types']    = 'jpg|png';
        $config['max_size']         = 100;
        $config['encrypt_name']     = true;

        $this->upload->initialize($config);

        if ($this->upload->do_upload('foto_barang')) {
            return TRUE;
        } else {
            $this->_setAlert('message', 'warning', $this->upload->display_errors());
            redirect('/');
        }
    }

    private function _uploadSecondFotoBarang($old_foto)
    {
        $config['upload_path']      = './assets/img/barang';
        $config['allowed_types']    = 'jpg|png';
        $config['max_size']         = 100;
        $config['encrypt_name']     = true;

        $this->upload->initialize($config);

        if ($this->upload->do_upload('edit_foto_barang')) {
            unlink(FCPATH . 'assets/img/barang/' . $old_foto);
            return TRUE;
        } else {
            $this->_setAlert('message', 'warning', $this->upload->display_errors());
            redirect('/');
        }
    }

    private function _setAlert($name = NULL, $status = NULL, $message = NULL)
    {
        if ($status == 'success') {
            // For success alert
            return $this->session->set_flashdata($name, '<div class="alert alert-success alert-dismissible fade show mt-5 mb-3" role="alert"><strong>Success</strong> ' . $message . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
        } elseif ($status == 'warning') {
            // For warning alert
            return $this->session->set_flashdata($name, '<div class="alert alert-warning alert-dismissible fade show mt-5 mb-3" role="alert"><strong>Warning</strong> ' . $message . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
        } else {
            // For danger alert
            return $this->session->set_flashdata($name, '<div class="alert alert-danger alert-dismissible fade show mt-5 mb-3" role="alert"><strong>Danger</strong> ' . $message . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
        }
    }
}

/* End of file Home.php */

<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Alternatif as ModelsAlternatif;

class Alternatif extends BaseController
{
    public function __construct()
    {
        $this->model = new ModelsAlternatif();
    }


    public function index()
{
    $alternatifModel = new \App\Models\Alternatif();
    $data['alternatif'] = $this->model->where('id_user', session('id_user'))->findAll();
    $data['judul'] = 'Data Karbohidrat';

    return view('alternatif/index', $data);
}

    public function create()
{
    if (!$this->request->isAJAX()) {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }

    $id_user = session('id_user');
    $jumlahAlternatif = $this->model->countAlternatifByUser($id_user);

    if ($jumlahAlternatif >= 20) {
        return $this->response->setJSON(['status' => TRUE, 'warning' => 'Data alternatif sudah mencapai nilai maksimum!']);
    }

    $data = $this->request->getPost();
    $data['id_user'] = $id_user;

    $rules = [
        'kode'             => 'required',
        'nama_karbohidrat' => 'required',
        'indeks_glikemik'  => 'required|numeric',
        'serat'            => 'required|numeric',
        'karbohidrat'      => 'required|numeric',
        'harga'            => 'required|integer',
        'ketersediaan'     => 'required|integer',
    ];

    if (!$this->validate($rules)) {
        return $this->response->setJSON(['status' => FALSE, 'errors' => $this->validator->getErrors()]);
    }

    if ($this->model->save($data) === FALSE) {
        return $this->response->setJSON(['status' => FALSE, 'errors' => $this->model->errors()]);
    } else {
        return $this->response->setJSON(['status' => TRUE, 'message' => 'Data berhasil ditambahkan']);
    }
}

    public function delete()
    {
        if (!$this->request->isAJAX()) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $ids = $this->request->getPost('id');
        $this->model->whereIn('id_alternatif', $ids)->delete();
        return $this->response->setJSON(['status' => TRUE, 'message' => 'Data berhasil dihapus']);
    }

    public function getDataById()
    {
        if (!$this->request->isAJAX()) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $id = $this->request->getPost('id');
        $data = $this->model->find($id);
        return $this->response->setJSON($data);
    }

    public function update()
    {
        if (!$this->request->isAJAX()) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = $this->request->getPost();

        // Validasi update
        $rules = [
            'kode'             => 'required',
            'nama_karbohidrat' => 'required',
            'indeks_glikemik'  => 'required|numeric',
            'serat'            => 'required|numeric',
            'karbohidrat'      => 'required|numeric',
            'harga'            => 'required|integer',
            'ketersediaan'     => 'required|integer',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON(['status' => FALSE, 'errors' => $this->validator->getErrors()]);
        }

        if ($this->model->save($data) === FALSE) {
            return $this->response->setJSON(['status' => FALSE, 'errors' => $this->model->errors()]);
        } else {
            return $this->response->setJSON(['status' => TRUE, 'message' => 'Data berhasil diperbarui']);
        }
    }

    public function list()
    {
        $id_user = session('id_user');
        $data = $this->model->where('id_user', $id_user)->findAll();
        return $this->response->setJSON($data);
    }

}

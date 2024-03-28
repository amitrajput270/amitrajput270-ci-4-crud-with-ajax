<?php

namespace App\Models;

use CodeIgniter\Model;

class Products extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['title', 'category', 'description', 'image', 'created_at', 'updated_at'];
    protected $useTimestamps = false;
    protected $localfile = 'products.json';

    public function __construct()
    {
        parent::__construct();
        helper('file');
        helper('filesystem');

    }

    public function inserDataInDataBase()
    {
        $data = json_decode(read_file($this->localfile), true);
        if (!empty($data)) {
            foreach ($data as $row) {
                $this->upsert($row);
            }
        }
        return true;
    }

    public function allData()
    {
        return json_decode(read_file($this->localfile), true);
    }

    public function createData($parameters = [])
    {
        if (!file_exists($this->localfile)) {
            write_file($this->localfile, '');
        }
        $data = json_decode(read_file($this->localfile), true);
        if (!empty($data)) {
            $parameters['id'] = max(array_column($data, 'id')) + 1;
        } else {
            $parameters['id'] = 1;
        }
        $data[] = [
            'id' => $parameters['id'],
            'title' => $parameters['title'],
            'category' => $parameters['category'],
            'description' => $parameters['description'],
            'image' => $parameters['image'],
            'created_at' => $parameters['created_at'],
        ];
        usort($data, function ($a, $b) {
            return $a['id'] <=> $b['id'];
        });
        $data = json_encode($data, JSON_PRETTY_PRINT);
        write_file($this->localfile, $data);
        return true;
    }

    public function editData($id)
    {
        $data = json_decode(read_file($this->localfile), true);
        $key = array_search($id, array_column($data, 'id'));
        if ($key !== false) {
            return $data[$key];
        }
        return false;
    }

    public function updateData($id, $parameters = [])
    {
        $data = json_decode(read_file($this->localfile), true);
        $key = array_search($id, array_column($data, 'id'));
        if ($key !== false) {
            $data[$key] = [
                'id' => $id,
                'title' => $parameters['title'] ?? $data[$key]['title'],
                'category' => $parameters['category'] ?? $data[$key]['category'],
                'description' => $parameters['description'] ?? $data[$key]['description'],
                'image' => $parameters['image'] ?? $data[$key]['image'],
                'created_at' => $data[$key]['created_at'],
                'updated_at' => $parameters['updated_at'],
            ];
            $data = json_encode($data, JSON_PRETTY_PRINT);
            write_file($this->localfile, $data);
            return true;
        }
        return false;
    }

    public function details($id)
    {
        $data = json_decode(read_file($this->localfile), true);
        $key = array_search($id, array_column($data, 'id'));
        if ($key !== false) {
            return $data[$key];
        }
        return false;
    }

    public function deleteData($id)
    {
        $data = json_decode(read_file($this->localfile), true);
        $key = array_search($id, array_column($data, 'id'));
        if ($key !== false) {
            $file = $data[$key]['image'];
            if ($file != '') {
                unlink('uploads/avatar/' . $file);
            }
            unset($data[$key]);
            $data = json_encode(array_values($data), JSON_PRETTY_PRINT);
            write_file($this->localfile, $data);
            return true;
        }
        return false;
    }

}

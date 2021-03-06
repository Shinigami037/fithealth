<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\MainCategoryModel;
use App\Models\SubCategoryModel;
use CodeIgniter\CLI\Console;
use CodeIgniter\Config\View;
use CodeIgniter\Entity\Cast\BaseCast;

class AdminProduct extends BaseController
{
    public function action()
    {
        $subcategory = new SubCategoryModel();
        $data = $subcategory->where('category_id', $this->request->getVar('maincategory_id'))->findAll();
        echo json_encode($data);
    }
    public function update($id = null)
    {
        $product = new ProductModel();
        $var = $this->request->getPost('maincat');
        $var2 = $this->request->getPost('subcat');
        $data = [
            'category' => $var,
            'sub_category' => $var2,
            'detail' => $this->request->getPost('detail'),
            'name' => $this->request->getPost('name'),
            'quantity' => $this->request->getPost('quantity'),
            'price' => $this->request->getPost('price'),
            'status' => 1,
            // 'image' => $imageName,
        ];
        // die($var);
        // var_dump($var);
        if (isset($var)) {
            $col = $product->where('id', $id)->findColumn('category');
            $data = ['category' => $col[0]];
            // echo print_r($data['category']);
            // die(print_r($col[0]));
        }
        // die($data['category']);
        // var_dump($var);
        if (isset($var2)) {
            $col = $product->where('id', $id)->findColumn('sub_category');
            $var2 = $col[0];
            // echo print_r($col);
            // die(print_r($col[0]));
        }
        $file = $this->request->getFile('image');
        if ($file->isValid() && !$file->hasMoved()) {
            $imageName = $file->getName();
            $file->move('public/uploads/', $imageName);
        }
        // die($var);

        $product->update($id, $data);
        return redirect()->to('inventory');
    }
    public function edit($id = null)
    {
        echo $id;
        $maincategory = new MainCategoryModel();
        $product = new ProductModel();
        $subcategory = new SubCategoryModel();

        $data = $maincategory->findAll();
        $data2 = $subcategory->findAll();
        $data3 = $product->find($id);
        return view('admin/inventory/edit', ['subcategory' => $data2, 'category' => $data, 'product' => $data3]);
    }
    public function inventory()
    {
        $product = new ProductModel();
        $data = $product->findAll();
        $maincategory = new MainCategoryModel();
        $data2 = $maincategory->findAll();
        // $hell = $data['name'];
        // // echo $data
        // // echo $data
        // die($hell);
        // foreach ($data as $row) {
        //     echo $row->category;    
        //     echo $row->name;
        //         // $oldPass = $row->user_password;
        //         // break;
        //     }
        return view('admin/inventory/inventory', ['name' => $data, 'category' => $data2]);
    }
    public function product()
    {
        $maincategory = new MainCategoryModel();
        $data = $maincategory->orderBy('main_cat_name', 'ASC')->findAll();
        // $maincategory = new SubCategoryModel();
        // $data['category'] = $category->orderBy('name', 'ASC')->findAll();
        return view('admin/inventory/product', ['category' => $data]);
    }
    public function addproduct()
    {
        $maincategory = new MainCategoryModel();
        $subcategory = new SubCategoryModel();
        $product = new ProductModel();
        $file = $this->request->getFile('image');
        if ($file->isValid() && !$file->hasMoved()) {
            $imageName = $file->getName();
            $file->move('public/uploads/', $imageName);
        }
        $cat = $maincategory->find($this->request->getPost('maincat'));
        $sub = $subcategory->find($this->request->getPost('subcat'));
        if ($sub == NULL){
            // die("No category");
            return redirect()->to('product')->with('status', 'Category is not selected')->with('status_text', 'Choose a Sub Category')->with('status_icon', 'warning');
        }
        // die(print_r($cat['name']));
        $data = [
            'category' => $cat['main_cat_name'],
            'sub_category' => $sub['sub_cat_name'],
            'detail' => $this->request->getPost('detail'),
            'name' => $this->request->getPost('name'),
            'quantity' => 1,
            'price' => $this->request->getPost('price'),
            'image' => $imageName,
            'status' => 1,
        ];
        $product->save($data);
        return redirect()->to('product')->with('status', 'Data Saved')->with('status_text', '')->with('status_icon', 'success');
    }
    // public function show()
    // {
    //     $product = new ProductModel();
    //     $data = $product->findAll();
    // }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Models\Company;
use App\Models\ConsumerData;
use Phpml\Clustering\KMeans;

class UserController extends Controller
{
    public function index(){
        $company = Company::find(auth()->user()['company_id']);
        return view('brand_page', [
            'company' => $company,
            'allCategories' => ProductCategory::all(),
            'categories' => $company->productCategories,
        ]);
    }

    public function addProductCategory(){
        $attachedCompanies = ProductCategory::find(request()['product_category_id'])->companies();

        // check if already in list
        $existsAlready = $attachedCompanies->where('company_id', auth()->user()['company_id'])->first();
        if ($existsAlready !== null) {
            return redirect()->back()->withErrors([
                'product_category_id' => 'Category already attached.'
            ])->withInput();
        }

        $category = $attachedCompanies->attach(auth()->user()['company_id']);
        return redirect(route('brand_page'));
    }

    public function deleteProductCategory(){
        ProductCategory::find(request()['product_category_id'])->companies()->detach(auth()->user()['company_id']);
        return redirect(route('brand_page'));
    }

    
    public function my_personas_page() {
        $consumerData = ConsumerData::all();

        $personas = [
            ['first_name'=>'Davidoo', 'last_name'=>'Igandan', 'age'=>'8', 'customer_id'=>'239289', 'income'=>'300', 'education'=>'College', 'description'=>'More indepth', 'date_generated'=>'08/03/2023'], 
            ['first_name'=>'Davidoo', 'last_name'=>'Igandan', 'age'=>'8', 'customer_id'=>'239289', 'income'=>'300', 'education'=>'College', 'description'=>'More indepth', 'date_generated'=>'08/03/2023'],
            ['first_name'=>'Davidoo', 'last_name'=>'Igandan', 'age'=>'8', 'customer_id'=>'239289', 'income'=>'300', 'education'=>'College', 'description'=>'More indepth', 'date_generated'=>'08/03/2023'],
            ['first_name'=>'Davidoo', 'last_name'=>'Igandan', 'age'=>'8', 'customer_id'=>'239289', 'income'=>'300', 'education'=>'College', 'description'=>'More indepth', 'date_generated'=>'08/03/2023'],
            ['first_name'=>'Davidoo', 'last_name'=>'Igandan', 'age'=>'8', 'customer_id'=>'239289', 'income'=>'300', 'education'=>'College', 'description'=>'More indepth', 'date_generated'=>'08/03/2023'],
            ['first_name'=>'Davidoo', 'last_name'=>'Igandan', 'age'=>'8', 'customer_id'=>'239289', 'income'=>'300', 'education'=>'College', 'description'=>'More indepth', 'date_generated'=>'08/03/2023'],
            ['first_name'=>'Davidoo', 'last_name'=>'Igandan', 'age'=>'8', 'customer_id'=>'239289', 'income'=>'300', 'education'=>'College', 'description'=>'More indepth', 'date_generated'=>'08/03/2023'],
        ];
        
        return view('my_personas_page', [
            'personas' => $personas
        ]);
    }


}

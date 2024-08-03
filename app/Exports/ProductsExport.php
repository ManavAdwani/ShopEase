<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductsExport implements FromCollection, WithHeadings,ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Product::select(
            'products.id',
            'products.product_name',
            'companies.company_name as company_name',
            'categories.category_name as category_name',
            'products.product_price',
            'products.quantity',
            'products.color',
            'products.model_number'
        )
        ->join('companies', 'products.company_id', '=', 'companies.id')
        ->join('categories', 'products.category_id', '=', 'categories.id')
        ->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Product Name',
            'Company',
            'Category',
            'Product Price',
            'Quantity',
            'Color',
            'Model Number',
        ];
    }
}

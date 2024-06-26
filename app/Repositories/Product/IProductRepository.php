<?php 
 
 
namespace App\Repositories\Product;

use App\Repositories\IBaseRepository;

interface IProductRepository extends IBaseRepository
{
    public function getAllProductWithCategoryAndFeature(int $userId);
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\OrderRentProduct;
use App\Models\OrderSoldProduct;
use App\Models\RentOrder;
use App\Models\Role;
use App\Models\SoldOrder;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller 
{

    public function index() {
        $bestSellingProducts = $this->getBestSellingProducts();

        $bestRentingProducts = $this->getBestRentingProducts();

        $recentSoldOrders = $this-> recentSoldOrders();

        $recentRentOrders = $this-> recentRentOrders();

        $usersPerMonth = $this-> getUsersPerMonth();

        $newOrdersCount = $this->getNewOrdersCount();

        

        // dd($bestSellingProducts);
        return view('admin.index', compact('bestSellingProducts', 'bestRentingProducts', 'recentSoldOrders', 'recentRentOrders', 'usersPerMonth', 'newOrdersCount'));
    }


    private function getBestSellingProducts() {
        $soldProducts = OrderSoldProduct::groupBy('product_id')
        ->select('product_id', DB::raw('SUM(quantity) as total_sales'))
        ->orderByDesc('total_sales') ->limit(5) ->get();

        $productIds = $soldProducts->pluck('product_id')->toArray();

        $bestSellingProducts = Product::whereIn('id', $productIds)
            ->select('id', 'name', 'thumbnail', 'price') ->get()
            ->map(function ($product) use ($soldProducts) {
                $product->total_sales = $soldProducts->where('product_id', $product->id)->first()->total_sales;
                return $product;
            });

        return $bestSellingProducts;
    }


    private function getBestRentingProducts() {
            $soldProducts = OrderRentProduct::groupBy('product_id')
            ->select('product_id') ->limit(5) ->get();

            $productIds = $soldProducts->pluck('product_id')->toArray();

            $bestRentingProducts = Product::whereIn('id', $productIds)
                ->select('id', 'name', 'thumbnail', 'price') ->get()
                ->map(function ($product) use ($soldProducts) {
            $product->total_sales = $soldProducts->where('product_id', $product->id)->first()->total_sales;

                return $product;
            });
        return $bestRentingProducts;
    }
        


    
        
    public function recentSoldOrders()
    {
        $recentSoldOrders = SoldOrder::with('orderSoldProducts.product')->latest()->take(10)->get();

        $recentSoldOrders->each(function ($soldOrder) {
            // Присваиваем статус заказа в зависимости от наличия данных о датах
            if ($soldOrder->delivered_at) {
                $soldOrder->status = 'Получено';
            } elseif ($soldOrder->dispatched_at) {
                $soldOrder->status = 'Отправлено';
            } elseif ($soldOrder->assembled_at) {
                $soldOrder->status = 'Собран';
            } else {
                $soldOrder->status = 'Новый';
            }
    
            // Расчет общей цены товаров
            $totalPrice = 0;
    
            foreach ($soldOrder->orderSoldProducts as $orderProduct) {
                $productPrice = $orderProduct->product->price;
                $quantity = $orderProduct->quantity;
                $productTotalPrice = $productPrice * $quantity;
                $totalPrice += $productTotalPrice;
            }
    
            $soldOrder->total_price = $totalPrice;
        });
    
        return $recentSoldOrders;
}


public function recentRentOrders()
{
    $recentRentOrders = RentOrder::with('orderRentProducts.product')->latest()->take(10)->get();

    $recentRentOrders->each(function ($rentOrder) {
        // Присваиваем статус заказа в зависимости от наличия данных о датах
        if ($rentOrder->delivered_at) {
            $rentOrder->status = 'Получено';
        } elseif ($rentOrder->dispatched_at) {
            $rentOrder->status = 'Отправлено';
        } elseif ($rentOrder->assembled_at) {
            $rentOrder->status = 'Собран';
        } else {
            $rentOrder->status = 'Новый';
        }

        // Расчет общей цены товаров
        $totalPrice = 0;

        foreach ($rentOrder->orderRentProducts as $orderProduct) {
            $productPrice = $orderProduct->product->price;
            // $quantity = $orderProduct->quantity;
            $productTotalPrice = $productPrice;
            // * $quantity;
            $totalPrice += $productTotalPrice;
        }

        $rentOrder->total_price = $totalPrice;
    });

    return $recentRentOrders;
}

    public function getUsersPerMonth()
    {
        $startDate = Carbon::now()->subMonth(); // Получить дату начала последнего месяца
        $endDate = Carbon::now(); // Получить текущую дату
    
        $userRoleId = Role::where('name', 'user')->first()->id; // Получить ID роли "user"

        $usersPerMonth = User::whereBetween('created_at', [$startDate, $endDate])
        ->whereHas('role', function ($query) use ($userRoleId) {
            $query->where('id', $userRoleId);
        })
        ->count();
    
        return $usersPerMonth;
    }

    public function getNewOrdersCount()
    {
        $monthAgo = Carbon::now()->subMonth();
        
        $count = SoldOrder::where(function($query) {
            $query->whereNull('assembled_at')
                ->orWhereNull('dispatched_at')
                ->orWhereNull('delivered_at')
                ->orWhereNull('cancelled_at');
        })
        ->where('created_at', '>=', $monthAgo)
        ->count();

    return $count;
    }


}

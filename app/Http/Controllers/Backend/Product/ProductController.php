<?php

namespace App\Http\Controllers\Backend\Product;

use App\Models\Product\Product;
use App\Http\Controllers\Controller;
use App\Repositories\Product\ProductRepository;
use App\Http\Requests\Product\UpdateRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class ProductController
 * @package App\Http\Controllers\Backend\Product
 */
class ProductController extends Controller
{
    /** @var  ProductRepository */
    protected $products;

    /**
     * Create a new controller instance.
     *
     * @param ProductRepository $products
     */
    public function __construct(ProductRepository $products)
    {
        $this->middleware('auth');

        $this->products = $products;
    }

    /**
     * Products lists
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $products = $this->products->newQuery()->orderBy('id', 'asc')->paginate(25);

        return view('admin.products.index', compact('products'));
    }

    /**
     * Edit Product
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function edit(int $id)
    {
        $product = $this->products->newQuery()->findOrFail($id);

        $statuses = Product::getStatusesList();

        return view('admin.products.edit', compact('product','statuses'));
    }

    /**
     * Update Product
     *
     * @param UpdateRequest $request
     * @param int $id
     * @throws \Exception
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateRequest $request, int $id)
    {
        $product = $this->products->findOrFail($id);

        \DB::beginTransaction();

        try {

            $product->name = $request->get('name');
            $product->price = $request->get('price');
            $product->status = $request->get('status');

            $product->update();

        } catch (\Exception $e) {
            \DB::rollBack();
            die($e->getMessage());
        }

        \DB::commit();

        return redirect()->route('admin.products.edit', $product->id);
    }

    /**
     * Update Order
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function productAdd(Request $request)
    {
        $response = [
            'data' => []
        ];
        $sum = 0.00;

        $product_id = $request->get('product_id');
        $quantity = $request->get('quantity');

        $product = $this->products->findOrFail($product_id);

        $sum += $product->price * $quantity;

        $response['data']['sum'] = $sum;
        $response['data']['html'] = (string) view('admin.orders.product-row', compact('product', 'quantity', 'sum'));
        return response()->json($response);
    }

    /**
     * Update Order
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function calculateSum(Request $request)
    {
        $response = [
            'data' => []
        ];
        $totalSum = 0.00;

        if($request->get('product') == null){
            $response['data']['totalSum'] = $totalSum;
            $response['data']['html'] = '';
            return response()->json($response);
        }

        $products = $request->get('product');

        foreach ($products as $product_id => $quantityArray) {
            $quantity = $quantityArray['quantity'];
            $product = $this->products->findOrFail($product_id);
            $totalSum += $product->price * $quantity;
        }
        $response['data']['totalSum'] = $totalSum;
        $response['data']['html'] = '';
        return response()->json($response);
    }

    /**
     * Delete order products if it not set in update request
     *
     * @param $order
     * @param $productsIds
     *
     * @return void
     */
    private function checkSavedOrderProducts($order, $productsIds): void
    {
        if($order->orderProducts) {
            foreach ($order->orderProducts as $orderProduct) {
                //Delete order product if it not set in update request
                if (array_search($orderProduct->product_id, $productsIds) === false) {
                    $orderProduct->delete();
                }
            }
        }
    }

    /**
     * Create or update order product
     *
     * @param $order
     * @param $productsIds
     * @param $productData
     *
     * @return void
     */
    private function createOrUpdateOrderProducts($order, $productsIds, $productData): void
    {
        //Update or Create OrderProduct
        foreach ($productsIds as $product_id) {

            $product = $this->products->findOrFail($product_id);

            $orderProduct = OrderProduct::where(['order_id' => $order->id, 'product_id' => $product_id])->get();

            //Update if founded
            if($orderProduct->count()) {
                $orderProduct = $orderProduct->first();
                $orderProduct->quantity = (int) $productData[$product_id]['quantity'];
                $orderProduct->update();
            } else {
                $orderProduct = new OrderProduct();
                $orderProduct->product_id = $product->id;
                $orderProduct->order_id = $order->id;
                $orderProduct->price = $product->price;
                $orderProduct->quantity = (int) $productData[$product_id]['quantity'];
                $orderProduct->save();
            }
        }
    }
}

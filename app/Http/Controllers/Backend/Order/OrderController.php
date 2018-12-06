<?php

namespace App\Http\Controllers\Backend\Order;

use App\Models\Order\Order;
use App\Http\Controllers\Controller;
use App\Models\Order\OrderProduct;
use App\Repositories\Order\OrderRepository;
use App\Http\Requests\Order\UpdateRequest;
use App\Repositories\Partner\PartnerRepository;
use App\Repositories\Product\ProductRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class OrderController
 * @package App\Http\Controllers\Order
 */
class OrderController extends Controller
{
    /** @var  OrderRepository */
    protected $orders;

    /** @var  PartnerRepository */
    protected $partners;

    /** @var  ProductRepository */
    protected $products;

    /**
     * Create a new controller instance.
     *
     * @param OrderRepository $orders
     * @param PartnerRepository $partners
     * @param ProductRepository $products
     */
    public function __construct(OrderRepository $orders, PartnerRepository $partners, ProductRepository $products)
    {
        $this->middleware('auth');

        $this->orders = $orders;
        $this->partners = $partners;
        $this->products = $products;
    }

    /**
     * Orders lists
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $orders = $this->orders->newQuery()->with(['orderProducts'])->orderBy('id', 'desc')->paginate(25);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Edit Order
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function edit(int $id)
    {
        $order = $this->orders->newQuery()->with(['orderProducts'])->findOrFail($id);

        $disabledProducts = [];
        foreach ($order->orderProducts as $orderProduct) {
            $disabledProducts[$orderProduct->product_id] = ['disabled'];
        };

        $partners = $this->partners->get();
        $partnersList = $partners->pluck( 'name', 'id' );

        $products = $this->products->get();
        $productsList = $products->pluck( 'name', 'id' );

        $statuses = Order::getStatusesList();

        return view('admin.orders.edit', compact('order', 'partnersList', 'productsList', 'disabledProducts', 'statuses'));
    }

    /**
     * Update Order
     *
     * @param UpdateRequest $request
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateRequest $request, int $id)
    {
        $order = $this->orders->findOrFail($id);

        \DB::beginTransaction();

        try {

            $order->client_email = $request->get('client_email');
            $order->delivery_dt = $request->get('delivery_dt');
            $order->status = $request->get('status');
            $order->partner_id = $request->get('partner_id');

            $productsIds = $request->get('product_id');
            $productData = $request->get('product');

            //Delete order products if it not set in update request
            $this->checkSavedOrderProducts($order, $productsIds);

            //Create or update order product
            $this->createOrUpdateOrderProducts($order, $productsIds, $productData);

            $order->update();

        } catch (\Exception $e) {
            \DB::rollBack();
            die($e->getMessage());
        }

        \DB::commit();

        return redirect()->route('admin.orders.edit', $order->id);
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

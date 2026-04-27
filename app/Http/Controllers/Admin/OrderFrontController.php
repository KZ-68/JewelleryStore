<?php
/* 
* Front Controller File for the order page connected to the Back Office section 
*/

namespace App\Http\Controllers\Admin;

use App\Contracts\OrderListRepositoryInterface;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\Order;

class OrderFrontController extends Controller
{

    public function __construct(
        private OrderListRepositoryInterface $orderListRepository
    ) {}
    
    /**
    * Show order details view
    * @param Request Get the request, via GET method
    * @return Response|RedirectResponse Return an Inertia Object response with the rendered view or a redirection
    */
    public function show(Request $request): Response|RedirectResponse
    {
        $order = $this->orderListRepository->getOrderByReference($request->reference);
        if(!$order || $order['error']) {
            redirect('not-found', 404);
        }

        return Inertia::render('admin/OrderDetails', [
            'slug' => $order->slug,
            'order' => $order
        ]);
    }

}
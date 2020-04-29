<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Buyer;
use App\Services\Buyer\BuyerService;

class BuyerController extends Controller
{

    /**
     * @var BuyerService
     */
    private $service;

    public function __construct(BuyerService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $buyers = $this->service->getAllBuyers();
        return response()->json(['data' => $buyers]);
    }

    /**
     * Display the specified resource.
     *
     * @param Buyer $buyer
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id)
    {
        $buyer = $this->service->getBuyer($id);
        if (!$buyer)
            abort(404);
        return response()->json(['data' => $buyer]);
    }
}

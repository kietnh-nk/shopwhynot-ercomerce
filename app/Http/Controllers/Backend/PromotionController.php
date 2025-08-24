<?php

namespace App\Http\Controllers\Backend;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\PromotionService;
use Illuminate\Support\Facades\Log;

class PromotionController extends Controller
{
    protected $promotionService;

    public function __construct(PromotionService $promotionService)
    {
        $this->promotionService = $promotionService;
    }

    public function index(Request $request)
    {
        $promotions = $this->promotionService->paginate($request);
        // dd($promotions);
        return view('backend.dashboard.layout', [
            'template' => 'backend.promotion.index',
            'promotions' => $promotions
        ]);
    }

    public function create()
    {
        $products = $this->promotionService->getAllProducts();
        return view('backend.dashboard.layout', [
            'template' => 'backend.promotion.create',
            'products' => $products
        ]);
    }


    public function store(\App\Http\Requests\PromotionRequest $request)
    {
        $validatedData = $request->validated();
        $this->promotionService->createPromotion($validatedData);

        return redirect()->route('promotions.index')
            ->with('success', 'Khuyến mãi đã được tạo thành công!');
    }



    public function edit($id)
    {
        try {
            $promotion = $this->promotionService->getPromotionWithProducts($id);
            $products = $this->promotionService->getAllProducts();

            return view('backend.dashboard.layout', [
                'template' => 'backend.promotion.edit',
                'promotion' => $promotion,
                'products' => $products
            ]);
        } catch (Exception $e) {
            Log::error('Error loading promotion edit form: ' . $e->getMessage());
            return redirect()->route('promotions.index')->with('error', 'Không thể tải thông tin khuyến mãi.');
        }
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        $this->promotionService->updatePromotion($id, $request->all());
        return redirect()->route('promotions.index')->with('success', 'Cập nhật khuyến mãi thành công!');
    }


    public function destroy($id)
    {
        try {
            $this->promotionService->deletePromotion($id);
            return redirect()->route('promotions.index')->with('success', 'Khuyến mãi đã được xóa thành công.');
        } catch (Exception $e) {
            return redirect()->route('promotions.index')->with('error', 'Xảy ra lỗi khi xóa khuyến mãi.');
        }
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('id');
        if ($ids) {
            try {
                $this->promotionService->bulkDeletePromotions(explode(',', $ids));
                return redirect()->route('promotions.index')->with('success', 'Xóa thành công các bản ghi.');
            } catch (Exception $e) {
                Log::error('Bulk delete error: ' . $e->getMessage());
                return redirect()->route('promotions.index')->with('error', 'Xảy ra lỗi khi xóa các bản ghi. Vui lòng thử lại.');
            }
        }
        return redirect()->route('promotions.index')->with('warning', 'Không có bản ghi nào được chọn để xóa.');
    }

    public function show($id)
    {
        $promotion = $this->promotionService->getPromotionWithProducts($id);
        return view('backend.dashboard.layout', [
            'template' => 'backend.promotion.show',
            'promotion' => $promotion,
        ]);
    }
}

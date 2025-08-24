<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Services\BrandService;
use App\Http\Controllers\Controller;
use App\Repositories\BrandRepository;
use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;

class BrandController extends Controller
{
    protected $brandService;
    protected $brandRepository;
    public function __construct(
        BrandService $brandService,
        BrandRepository $brandRepository,
    ) {
        $this->brandService = $brandService;
        $this->brandRepository = $brandRepository;
    }

    public function index(Request $request)
    {
        $brands = $this->brandService->paginate($request);
        $template = 'backend.brand.index';
        return view('backend.dashboard.layout', compact(
            'template',
            'brands',
        ));
    }
    public function create()
    {
        $brands = $this->brandService->all();
        $template = 'backend.brand.create';
        return view('backend.dashboard.layout', compact(
            'template',
            'brands',
        ));
    }
    public function store(StoreBrandRequest $request)
    {
        // gọi tới service với phương thức create
        $result = $this->brandService->create($request);
        if ($result) {
            flash()->success('Thêm mới thành công');
            return redirect()->route('brand.index');
        } else {
            flash()->error('Thất bại. Đã có lỗi xảy ra vui lòng thử lại!');
            return redirect()->back();
        }
    }
    public function update($slug)
    {
        $brand = $this->brandRepository->findBySlug($slug);
        $template = 'backend.brand.update';
        return view('backend.dashboard.layout', compact(
            'template',
            'brand',
        ));
    }
    public function edit($slug, UpdateBrandRequest $request)
    {
        $result = $this->brandService->update($slug, $request);
        if ($result) {
            flash()->success('cập nhật thành công');
            return redirect()->route('brand.index');
        } else {
            flash()->error('Thất bại. Đã có lỗi xảy ra vui lòng thử lại!');
            return redirect()->back();
        }
    }
    public function delete($id = 0)
    {
        try {
            $brand = $this->brandRepository->findById($id);
            if (!$brand) {
                flash()->error('Không tìm thấy thương hiệu!');
                return redirect()->route('brand.index');
            }
            $template = 'backend.brand.delete';
            return view('backend.dashboard.layout', compact(
                'template',
                'brand',
            ));
        } catch (\Exception $e) {
            flash()->error('Không tìm thấy thương hiệu! Lỗi: ' . $e->getMessage());
            return redirect()->route('brand.index');
        }
    }
    public function destroy($id = 0)
    {
        if ($_POST['submit'] == 'cancel') {
            flash()->warning('Thương hiệu chưa được xóa!');
            return redirect()->route('brand.index');
        } else {
            $brand = $this->brandRepository->findById($id);
            //kiểm tra xem bản ghi đó có các bản ghi liên quan trong bảng products kh
            if ($brand->products()->exists()) {
                flash()->warning('Thương hiệu có sản phẩm liên quan không thể xóa!');
                return redirect()->back();
            }
            $result = $this->brandService->destroy($id);
            if ($result) {
                flash()->success('Thương hiệu đã được xóa thành công!');
                return redirect()->route('brand.index');
            } else {
                flash()->error('Có lỗi khi xóa, vui lòng thử lại!');
                return redirect()->back();
            }
        }
    }

    public function destroyMultiple(Request $request)
    {
        // Lấy giá trị từ input ẩn đã truyền mảng ID
        $listId = $request->input('array_id');

        // Kiểm tra nếu có ID, và tách chuỗi thành mảng
        if ($listId) {
            $arrayId = explode(',', $listId);
            dd($arrayId);
            $this->brandService->destroyBulk($arrayId);
            flash()->success('Xóa thành công các bản ghi.');
        } else {
            flash()->warning('Không có bản ghi nào được chọn để xóa.');
        }

        return redirect()->route('brand.index');
    }
}

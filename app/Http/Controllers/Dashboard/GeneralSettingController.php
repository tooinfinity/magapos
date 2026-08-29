<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;
use Intervention\Image\ImageManager;

class GeneralSettingController extends Controller
{
    public function index(GeneralSetting $generalSetting): View
    {
        $products = Product::all();
        return view('dashboard.settings.index', compact('products'));
    }

    public function create(): void
    {
        //
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'store_name' => 'required',
            'activity' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'start_day' => 'required',
            'image' => 'image',
            'investment_capital' => 'required',
        ]);

        $id = $request->input('id');
        $general_setting = GeneralSetting::findOrFail($id);
        $request_data = $request->all();

        if ($request->image) {
            if ($general_setting->image != 'logo_default.png') {
                Storage::disk('public_uploads')->delete('/settings/' . $general_setting->image);
            }
            $manager = new ImageManager(new GdDriver());
            $manager->make($request->image->getRealPath())
                ->resize(160, 160, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save(public_path('uploads/settings/' . $request->image->hashName()));
            $request_data['image'] = $request->image->hashName();
        }

        $general_setting->update($request_data);
        return redirect()->back();
    }

    public function show(GeneralSetting $generalSetting): void
    {
        //
    }

    public function edit(GeneralSetting $generalSetting): void
    {
        //
    }

    public function update(Request $request, GeneralSetting $generalSetting): void
    {
        //
    }

    public function updatesetting(Request $request): void
    {
        //
    }

    public function destroy(GeneralSetting $generalSetting): void
    {
        //
    }
}

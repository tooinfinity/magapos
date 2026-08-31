<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;
use Intervention\Image\ImageManager;

class ModeratorController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read_users'])->only('index');
        $this->middleware(['permission:create_users'])->only(['create', 'store']);
        $this->middleware(['permission:update_users'])->only(['edit', 'update']);
        $this->middleware(['permission:delete_users'])->only('destroy');
    }

    public function index(Request $request): View
    {
        $moderator = User::whereHas('roles', function ($q) {
            $q->where('name', 'employer');
        })->where(function ($q) use ($request) {
            return $q->when($request->search, function ($query) use ($request) {
                return $query
                    ->where('first_name', 'like', '%' . $request->search . '%')
                    ->orWhere('last_name', 'like', '%' . $request->search . '%');
            });
        })->latest()->paginate(5);

        return view('dashboard.moderator.index', compact('moderator'));
    }

    public function profile(): View
    {
        $profile = Auth::user();
        $allprofilepermission = $profile->allPermissions();
        return view('dashboard.moderator.profile', compact('profile', 'allprofilepermission'));
    }

    public function create(): View
    {
        return view('dashboard.moderator.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:users',
            'image' => 'image',
            'password' => 'required|confirmed',
            'permissions' => 'required|min:1',
        ]);

        $request_data = $request->except(['password', 'password_confirmation', 'permissions', 'image']);
        $request_data['password'] = bcrypt($request->password);

        if ($request->image) {
            $manager = new ImageManager(new GdDriver());
            $manager->make($request->image->getRealPath())
                ->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save(public_path('uploads/moderator_images/' . $request->image->hashName()));
            $request_data['image'] = $request->image->hashName();
        }

        $moderator = User::create($request_data);
        $moderator->addRole('employer');
        $moderator->syncPermissions($request->permissions);

        toast('Created Successfully', 'success', 'top-right');
        return redirect()->route('moderator.index');
    }

    public function show(User $moderator): void
    {
        //
    }

    public function edit(User $moderator): View
    {
        return view('dashboard.moderator.edit', compact('moderator'));
    }

    public function update(Request $request, User $moderator): RedirectResponse
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => [
                'required',
                Rule::unique('users')->ignore($moderator->id),
            ],
            'image' => 'image',
            'permissions' => 'required|min:1',
        ]);

        $request_data = $request->except(['permissions', 'image']);

        if ($request->image) {
            if ($moderator->image != 'default.png') {
                Storage::disk('public_uploads')->delete('/moderator_images/' . $moderator->image);
            }
            $manager = new ImageManager(new GdDriver());
            $manager->make($request->image->getRealPath())
                ->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save(public_path('uploads/moderator_images/' . $request->image->hashName()));
            $request_data['image'] = $request->image->hashName();
        }

        $moderator->update($request_data);
        $moderator->syncPermissions($request->permissions);

        toast('Updated Successfully', 'success', 'top-right');
        return redirect()->route('moderator.index');
    }

    public function destroy(User $moderator): RedirectResponse
    {
        if ($moderator->image != 'default.png') {
            Storage::disk('public_uploads')->delete('/moderator_images/' . $moderator->image);
        }
        $moderator->delete();
        toast('deleted Successfully', 'error', 'top-right');
        return redirect()->route('moderator.index');
    }
}

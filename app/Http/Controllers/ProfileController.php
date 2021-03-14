<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('profile.index');
    }

    public function update(ProfileUpdateRequest $request)
    {
        auth()->user()->update($request->only([
            'company_name',
            'name',
            'email',
            'phone',
        ]));

        return redirect()->back()->with([
            'status' => 'Сохранено',
            'type' => 'success'
        ]);
    }

    public function addresses()
    {
        $addresses = auth()->user()->addresses()->latest()->get();

        return view('profile.addresses', [
            'addresses' => $addresses
        ]);
    }

    public function deleteAddresses(UserAddress $address)
    {
        $address->delete();

        return redirect()->back()->with([
            'status' => 'Удалено',
            'type' => 'success'
        ]);
    }

    public function createAddresses()
    {
        return view('profile.create-address');
    }

    public function storeAddresses(Request $request)
    {
        auth()->user()->addresses()->create($request->all());

        return redirect()->route('profile.addresses')->with([
            'status' => 'Добавлено',
            'type' => 'success'
        ]);
    }

    public function orders()
    {
        $orders = auth()->user()->orders()->latest()->get();

        return view('profile.orders', [
            'orders' => $orders
        ]);
    }

    public function subscriptions()
    {
        return view('profile.subscriptions');
    }

    public function updateSubscriptions(Request $request)
    {
        $isEnabled = $request->is_subscriptions_enabled ? 1 : 0;

        auth()->user()->update(['is_subscriptions_enabled' => $isEnabled]);

        return redirect()->route('profile.subscriptions')->with([
            'status' => 'Сохранено',
            'type' => 'success'
        ]);
    }
}

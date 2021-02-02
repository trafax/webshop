<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $customers = \App\Models\User::where('role', 'customer')->orderBy('id');

        if ($request->get('search')) {
            $customers->where(function($query) use ($request) {
                return $query->orWhere('firstname', 'LIKE', '%'.$request->get('search').'%')
                    ->orWhere('lastname', 'LIKE', '%'.$request->get('search').'%')
                    ->orWhere('email', 'LIKE', '%'.$request->get('search').'%');
            });
        }

        return view('admin.customers.index')->with('customers', $customers->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.customers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'password' => 'required',
            'email' => 'unique:users'
        ]);

        $request->request->set('password', Hash::make($request->get('password')));

        $customer = new User();
        $customer->fill($request->all());
        $customer->save();

        return redirect()->route('customer.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $customer)
    {
        return view('admin.customers.edit')->with('customer', $customer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $customer)
    {
        if (empty($request->get('password'))) {
            $request->request->remove('password');
        } else {
            $request->request->set('password', Hash::make($request->get('password')));
        }

        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'unique:users,email,' . $customer->id
        ]);

        $customer->fill($request->all());
        $customer->save();

        return redirect()->route('customer.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::destroy($id);

        return route('customer.index');
    }

    public function delete(Request $request)
    {
        User::destroy($request->get('ids'));

        return true;
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsersRequest;
use App\Product;
use App\Role_user;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller {
	public function getUsers() {
		return User::with(['roles'])->where('company_id', Auth::user()->company_id)->get();
	}
	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(UsersRequest $request) {
		// return $request->all();
		// var_dump($request->form); die;
		$user = new User;
		$password = Hash::make($request->password);
		$user->name = $request->name;
		$user->password = $password;
		$user->email = $request->email;
		$user->phone = $request->phone;
		$user->zipcode = $request->zipcode;
		$user->branch = $request->branch;
		$user->address = $request->address;
		$user->city = $request->city;
		$user->country = $request->country;

		if ($user->save()) {
			$user_role = new Role_user;
			$user_role->user_id = $user->id;
			$user_role->role_id = $request->role_id;
			$user_role->save();
		}
		return $user;
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\User  $user
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, User $user) {
		// return $request->all();
		$user = User::find($request->id);
		$user->name = $request->name;
		$user->email = $request->email;
		$user->phone = $request->phone;
		$user->zipcode = $request->zipcode;
		$user->branch = $request->branch;
		$user->address = $request->address;
		$user->city = $request->city;
		$user->country = $request->country;
		if ($user->save()) {
			$user_role = Role_user::find($request->id);
			$user_id = $user->id;
			$role_id = $request->role_id;
			$user_role = Role_user::updateOrCreate(
				['user_id' => $user_id],
				['user_id' => $user_id, 'role_id' => $role_id]
			);
			// $user_role->save();
		}
		$user->save();
		return $user_role;
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\User  $user
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(User $user) {
		User::find($user->id)->delete();
	}

	public function getLogedinUsers() {
		return Auth::user();
	}

	public function profile(Request $request, User $user, $id) {
		// return $request->all;
		$upload = User::find($request->id);
		if ($request->hasFile('image')) {
			$imagename = time() . $request->image->getClientOriginalName();
			$request->image->storeAs('public/profile', $imagename);
		}
		$image_name = '/storage/profile/' . $imagename;
		$upload->profile = $image_name;
		$upload->save();
	}

	public function productimg(Request $request, Product $product, $id) {
		// return $request->all;
		if ($request->hasFile('image')) {
			$imagename = time() . $request->image->getClientOriginalName();
			$request->image->storeAs('public/products', $imagename);
		}
		// return $id;
		// $upload = Product::find($request->id);
		$image_name = '/storage/products/' . $imagename;
		$test = DB::table('products')
		            ->where('id', $id)
		            ->update(['image' => $image_name]);
		            return $test;
		// var_dump($imagename); 
		// $upload->image = $image_name;
		// $upload->save();
	}

	public function getDrivers()
	{
		$users = User::with('roles')->get();
		$userArr = [];
		foreach ($users as $user) {
				// var_dump($user->roles); die;
			foreach ($user->roles as $role) {
				if ($role->name == 'Driver') {
					$userArr[] = $role->pivot->user_id;		
				}
			}
		}
		$drivers = User::whereIn('id', $userArr)->get();
		return $drivers;
	}

	public function getCustomer()
	{
		$users = User::with('roles')->get();
		$userArr = [];
		foreach ($users as $user) {
			foreach ($user->roles as $role) {
				if ($role->name == 'Customer') {
					$userArr[] = $role->pivot->user_id;		
				}
			}
		}
		$customers = User::whereIn('id', $userArr)->get();
		return json_decode(json_encode($customers));
	}
}

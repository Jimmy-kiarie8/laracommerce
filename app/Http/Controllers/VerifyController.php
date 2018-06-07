<?php

namespace App\Http\Controllers;

use App\Mail\Documents;
use App\Notifications\Slack;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class VerifyController extends Controller {
	public function verify($verifyToken) {
		User::where('verifyToken', $verifyToken)->firstOrFail()
			->update(['verifyToken' => null, 'status' => '1']);
		return redirect()->route('login')->with('success', 'Email verified please login');
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Subcat  $subcat
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request) {
		// return $request->email;
		// $sub = Attachment::findOrFail($request->id);
		// $subcat_id = $request->list['id'];
		// $sub->sub_cat = $request->sub_cat;
		// $sub->save();
		// return $sub;
		/*foreach ($request->email as $key => $value) {
	            Mail::to($value)
	                    ->send(new Documents);
*/
		// $mail = $request->email;
		// foreach ($request->email as $key => $value) {
		//     $email = $value;
		//     $user = User::where('email', $email)->get();
		// // return $user;
		// SendMailJob::dispatch($user)
		//                 ->delay(now()->addSeconds(2));
		// }
		// $id = Auth::id();
		// foreach ($request->email as $key => $value) {
		/*$job = (new SendMailJob($value))
				->delay(Carbon::now()->addSeconds(3));

			dispatch($job);*/
		// }
		// SendMailJob::dispatch($mail)
		// 	->delay(now()->addSeconds(3));
		// dd($request->input('sub_cat'));
		// return $request->all();
		$users = User::whereIn('email', $request->email)->get();

		foreach ($users as $user) {
			$thread = $request->noty;
			$authUser = Auth::user()->name;
			Mail::queue(new Documents($user));
			Notification::send($user, new Slack($thread, $authUser));
		}

		/*return back()->with([
			    'success' => "Campaign Sent!"
		*/
	}
}

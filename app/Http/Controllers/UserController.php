<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Models\Otp;
use App\Models\User;
use App\Models\Country;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\ForgetPasswordRequest;
use App\Http\Requests\EditpersonalinfoRequest;

class UserController extends Controller
{

    public function handleRegister(RegisterRequest $request)
    {
        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "gender" => $request->gender,
            "phone" => $request->phone,
            "country_id" => $request->country_id,
            "main_address" => $request->address,
            "password" => Hash::make($request->password)
        ]);
        session()->put("user", $user);
        $this->sendOTP($user);
        return redirect()->route("otp");
    }

    public function sendOTP($user)
    {
        $otp = rand(10000000, 99999999);
        $time = time();
        $user_otp = Otp::updateOrCreate(
            ["email" => $user->email],
            [
                "email" => $user->email,
                "otp" => $otp,
                "created_at" => $time,
            ]
        );
        $data["email"] = $user_otp->email;
        $data["otp"] = $user_otp->otp;
        Mail::send('pages.Mails.your_otp', ['data' => $data], function ($message) use ($data) {
            $message->to($data["email"]);
            $message->subject('Verification Email');
        });
    }

    public function handleOTP(Request $request)
    {
        $data = $request->validate([
            'otp' => 'required|numeric',
        ]);
        $user_data = User::where("id", decrypt($request->user_id))->first();
        $otp_data = Otp::where("email", $user_data->email)->first();
        if ($user_data->email == $otp_data->email && $otp_data->otp == $request->otp) {
            $user_data->update([
                "email_verified_at" => now(),
            ]);
            return redirect()->route('login');
        } else {
            return redirect()->route('otp')->withErrors('Wrong Data,Click on Resend email to send another OTP');
        }
    }

    public function resendOTP()
    {
        if (session()->has("user")) {
            $user = session()->get("user");
            $this->sendOTP($user);
            return redirect()->route('otp')->with('success', "We send a new email for you, cheack your email");
        } else {
            return redirect()->route('Signup')->withErrors("You don't in our coummunity yet, Please register first");
        }
    }

    public function handleLogin(LoginRequest $request)
    {
        $is_login = Auth::attempt(["email" => $request->email, "password" => $request->password], $request->filled('remember'));
        if ($is_login) {
            $user = User::where("email", $request->email)->first();
            session()->put("user", $user);
            return redirect()->route('home');
        } else {
            return redirect()->back()->withErrors(["msg" => "Wrong credentials invalid email or password"]);
        }
    }

    public function forgetPasswordHandle(ForgetPasswordRequest $request)
    {
        $user_email = DB::table('password_reset_tokens')->where('email', $request->email)->first();
        if ($user_email == null) {
            $rand = Str::random(64);
            $user = DB::table('password_reset_tokens')->insert([
                "email" => $request->email,
                "token" => $rand,
            ]);
        } else {
            $rand = Str::random(64);
            $user = DB::table('password_reset_tokens')->where('email', $request->email)->update([
                "email" => $request->email,
                "token" => $rand,
            ]);
        }
        Mail::send('pages.Mails.reset_your_password', ['token' => $rand], function ($message) use ($request) {
            $message->to($request->email, $request->name);
            $message->subject('Reset Your Password');
        });
        return view('pages.Success.check_your_email');
    }

    public function reset_password($token)
    {
        $user = DB::table('password_reset_tokens')->where([
            'token' => $token
        ])->first();
        if ($user) {
            return view('pages.Forms.reset_password', compact("token"));
        } else {
            return view('pages.Forms.forget_password');
        }
    }

    public function resetPasswordHandle(ResetPasswordRequest $request)
    {
        $reset_pass = DB::table('password_reset_tokens')->where([
            'email' => $request->email,
            'token' => $request->token
        ])->first();
        if ($reset_pass == null) {
            return redirect()->route('forget_pass')->with('error', 'Unfortunately, the password reset process could not be completed due to an issue, Try Again');
        } else {
            $user = User::where("email", $request->email)->first();
            $user->update([
                "password" => Hash::make($request->password)
            ]);
            DB::table('password_reset_tokens')->where(['email' => $request->email])->delete();
            return redirect()->route("login")->with("success", "Your password reset successfully, Don't forget your password again 🙂");
        }
    }

    public function userProfile()
    {
        return view('pages.Profile.personal_info');
    }

    public function editPersonalInfo()
    {
        $countries = Country::orderBy('name', 'asc')->get();
        return view('pages.Forms.personal_info_edit', compact("countries"));
    }

    public function handleEditPersonalInfo(EditpersonalinfoRequest $request)
    {
        $user = User::where("id", Auth::user()->id)->first();
        if ($user) {
            if ($request->hasFile("image")) {
                //if we have image in the file but we don't have now so comment it
                if ($user->image != null) {
                    Storage::delete($user->image);
                    $image_name = Storage::putFile("UserImages", $request->image); //rename - uploads
                } elseif ($user->image == null) {
                    $image_name = Storage::putFile("UserImages", $request->image); //rename - uploads
                }
            } elseif ($request->image == null) {
                $image_name = $user->image;
            }

            $user_up = $user->update([
                "image" => $image_name,
                "name" => $request->name,
                "email" => $request->email,
                "gender" => $request->gender,
                "phone" => $request->phone,
                "country_id" => $request->country_id,
                "main_address" => $request->address,
            ]);
            return redirect()->route('user_profile')->with("success", "Data Updated Successfully");
        } else {
            return redirect()->route("error");
        }
    }

    public function changePasswordHandle(ChangePasswordRequest $request)
    {
        $user = Auth::user();
        if (!Hash::check($request->old_password, $user->password)) {
            return redirect()->route('error')->withErrors("wrong password");
        } elseif (strcmp($request->old_password, $request->password) == 0) {
            return redirect()->route('error')->withErrors("New Password cannot be same as your old password.");
        }
        $new_user = User::find($user->id);
        $new_user->update([
            "password" => Hash::make($request->password)
        ]);
        return redirect()->route('user_profile')->with("success", "Password Changed Successfully");
    }

    public function logout()
    {
        $user = Auth::user();
        Auth::logout();
        if ($user) {
            $user->setRememberToken(null);
            $user->save();
        }
        return redirect()->route('login');
    }
}

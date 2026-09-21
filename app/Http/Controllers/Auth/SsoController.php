<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Exception;

class SsoController extends Controller
{
    private $ssoLoginUrl = 'https://www.medsci.up.ac.th/msc_acc/sso/login.php';
    private $ssoLogoutUrl = 'https://www.medsci.up.ac.th/msc_acc/sso/logout.php';
    private $clientId = 'MSC_V5';
    private $clientSecret = 'FyT6EoigYuy0wqvdanYTIMVuGQLTru2k';

    public function redirect(Request $request)
    {
        // For local testing/development when we want to bypass SSO
        if (config('services.sso.mock', false)) {
            return $this->handleMockLogin();
        }

        // Construct the registered SSO callback URL
        $callbackUrl = url('public/auth/callback');

        // Redirect to SSO login screen
        $ssoRedirectUrl = $this->ssoLoginUrl . 
                            "?client_id=" . urlencode($this->clientId) . 
                            "&redirect_uri=" . urlencode($callbackUrl);
        
        return redirect()->away($ssoRedirectUrl);
    }

    public function callback(Request $request)
    {
        $token = trim($request->query('token', ''));

        if (empty($token)) {
            return redirect()->route('home')->with('error', 'เข้าสู่ระบบล้มเหลว: ไม่พบโทเคนยืนยันสิทธิ์');
        }

        // Call central verify API to validate token and retrieve profile
        $verifyApiUrl = 'https://www.medsci.up.ac.th/msc_acc/api/verify.php';

        try {
            $response = Http::withoutVerifying()->asForm()->post($verifyApiUrl, [
                'token' => $token,
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
            ]);

            if ($response->failed()) {
                throw new Exception("ไม่สามารถเชื่อมต่อเซิร์ฟเวอร์หลักเพื่อยืนยันโทเคนได้");
            }

            $res = $response->json();

            if (!$res || ($res['status'] ?? '') !== 'success' || empty($res['user'])) {
                throw new Exception("โทเค็นไม่ถูกต้องหรือข้อมูลบัญชีผู้ใช้งานไม่สมบูรณ์");
            }

            $ssoUser = $res['user']; // username, name, email, pos_name, div_name
            $username = trim($ssoUser['username'] ?? '');
            $email = trim($ssoUser['email'] ?? '');

            if (empty($username)) {
                throw new Exception("ไม่พบชื่อผู้ใช้งานจากระบบ SSO");
            }

            // Find user in local users table by email
            $user = User::where('email', $email)->first();

            // If user doesn't exist, create them
            if (!$user) {
                // Determine role: wittaya.su or admin becomes super_admin
                $role = ($username === 'wittaya.su' || $username === 'admin') ? 'super_admin' : 'viewer';
                $user = User::create([
                    'name' => $ssoUser['name'] ?? $username,
                    'email' => $email,
                    'role' => $role,
                    'active' => true,
                ]);
            } else {
                // If it is wittaya.su, ensure they are super_admin
                if ($username === 'wittaya.su' || $email === 'wittaya.su@up.ac.th') {
                    $user->role = 'super_admin';
                }
                $user->name = $ssoUser['name'] ?? $user->name;
                $user->save();
            }

            if (!$user->active) {
                return redirect()->route('home')->with('error', 'บัญชีผู้ใช้งานของคุณถูกระงับการใช้งาน');
            }

            // Log the user in
            Auth::login($user, true);

            // Redirect based on role
            if ($user->isEditor()) {
                return redirect()->intended('/admin');
            }

            return redirect()->route('home')->with('success', 'เข้าสู่ระบบสำเร็จ');

        } catch (Exception $e) {
            return redirect()->route('home')->with('error', 'เข้าสู่ระบบล้มเหลว: ' . $e->getMessage());
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect to central SSO logout, which will redirect back to V5 home
        $returnUrl = route('home');
        $ssoLogoutUrl = $this->ssoLogoutUrl . "?redirect_uri=" . urlencode($returnUrl);

        return redirect()->away($ssoLogoutUrl);
    }

    private function handleMockLogin()
    {
        // Auto-login as the first super admin
        $admin = User::where('role', 'super_admin')->first();
        if ($admin) {
            Auth::login($admin, true);
            return redirect()->to('/admin')->with('success', 'เข้าสู่ระบบจำลอง (SSO Mock Login)');
        }
        return redirect()->route('home')->with('error', 'ไม่พบบัญชีผู้ดูแลระบบเพื่อทำ Mock Login');
    }
}

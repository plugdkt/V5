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
    // Values come from .env (see config/services.php -> medsci_sso). Never commit the client secret.
    private $ssoLoginUrl;
    private $ssoLogoutUrl;
    private $clientId;
    private $clientSecret;
    private $verifyApiUrl;

    public function __construct()
    {
        $cfg = config('services.medsci_sso');
        $this->ssoLoginUrl  = $cfg['login_url'];
        $this->ssoLogoutUrl = $cfg['logout_url'];
        $this->verifyApiUrl = $cfg['verify_url'];
        $this->clientId     = $cfg['client_id'];
        $this->clientSecret = $cfg['client_secret'];
    }

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
            return redirect()->route('home')->with('error', 'เข้าสู่ระบบล้มเหลว: ไม่พบโทเค็นยืนยันสิทธิ์');
        }

        // Call central verify API to validate token and retrieve profile
        if (empty($this->clientSecret)) {
            report(new Exception('MEDSCI_SSO_CLIENT_SECRET is not set in .env'));
            return redirect()->route('home')->with('error', 'ระบบยังไม่ได้ตั้งค่าการเชื่อมต่อ SSO กรุณาติดต่อผู้ดูแลระบบ');
        }

        try {
            $http = config('services.medsci_sso.verify_ssl') ? Http::asForm() : Http::withoutVerifying()->asForm();
            $response = $http->post($this->verifyApiUrl, [
                'token' => $token,
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
            ]);

            if ($response->failed()) {
                throw new Exception("ไม่สามารถเชื่อมต่อเซิร์ฟเวอร์หลักเพื่อยืนยันโทเค็นได้");
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

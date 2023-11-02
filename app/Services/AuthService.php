<?php
namespace App\Services;

use App\Domain\MessageData;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Utils\LogUtil;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    private $userRepo;

    public function __construct() {
        if ($this->userRepo === null) {
            $this->userRepo = new UserRepository();
        }
    }

    /**
     * Register new account
     *
     * @param object $objParam
     * @return MessageData
     */
    public function doRegister(object $objParam): MessageData
    {
        $objMsg = new MessageData();
        try {
            $objParam->password = bcrypt($objParam->password);
            $objParam->role = User::ROLE_USER;
            $user = $this->userRepo->createUser((array) $objParam);

            $objMsg->Status = true;
            $objMsg->Message = 'Berhasil membuat akun, silahkan login';
            $objMsg->Payload = $user;
        } catch (\Exception $ex) {
            $objMsg->Status = false;
            $objMsg->Message = 'Gagal melakukan pendaftaran, silahkan coba lagi';
            LogUtil::logError($objMsg->Message, $ex);
        }

        return $objMsg;
    }

    /**
     * Do Login Function
     *
     * @param LoginRequest $request
     * @return MessageData
     */
    public function doLogin(LoginRequest $request): MessageData
    {
        $objMsg = new MessageData();
        try {
            if (!Auth::attempt($request->only('email', 'password'), $this->checkRememberMe($request->all()))) {
                $objMsg->Status = false;
                $objMsg->Message = 'Kredensial tidak diketahui, silahkan cek email dan password anda';
                return $objMsg;
            }
            $objMsg->Status = true;
            $objMsg->Message = 'Selamat datang !';
            Auth::logoutOtherDevices($request->password);
        } catch (\Exception $ex) {
            $objMsg->Status = false;
            $objMsg->Message = 'Gagal melakukan login, silahkan coba lagi';
            LogUtil::logError($objMsg->Message, $ex);
        }

        return $objMsg;
    }

    /**
     * Check remember me from login request
     *
     * @param array $params
     * @return boolean
     */
    protected function checkRememberMe(array $params): bool
    {
        return isset($params['remember_me']) ? ($params['remember_me'] == 1):false;
    }
}
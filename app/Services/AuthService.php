<?php
namespace App\Services;

use App\Domain\MessageData;
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
     * @param array $objParam
     * @return MessageData
     */
    public function doLogin(array $objParam): MessageData
    {
        $objMsg = new MessageData();
        try {
            if (!Auth::attempt($objParam)) {
                $objMsg->Status = false;
                $objMsg->Message = 'Kredensial tidak diketahui, silahkan cek email dan password anda';
                return $objMsg;
            }
            $objMsg->Status = true;
            $objMsg->Message = 'Selamat datang !';
        } catch (\Exception $ex) {
            $objMsg->Status = false;
            $objMsg->Message = 'Gagal melakukan login, silahkan coba lagi';
            LogUtil::logError($objMsg->Message, $ex);
        }

        return $objMsg;
    }
}
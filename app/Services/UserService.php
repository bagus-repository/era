<?php
namespace App\Services;

use App\Utils\LogUtil;
use App\Domain\MessageData;
use App\Models\User;
use App\Repositories\UserRepository;

class UserService
{
    private $userRepo;

    public function __construct() {
        if ($this->userRepo === null) {
            $this->userRepo = new UserRepository();
        }
    }

    /**
     * Create User
     *
     * @param object $objParam
     * @return MessageData
     */
    public function createUser(object $objParam): MessageData
    {
        $objMsg = new MessageData();
        try {
            $objParam->password = bcrypt($objParam->password);
            $objParam->role = $objParam->role;
            $user = $this->userRepo->createUser((array) $objParam);

            $objMsg->Status = true;
            $objMsg->Message = 'Berhasil membuat user';
            $objMsg->Payload = $user;
        } catch (\Exception $ex) {
            $objMsg->Status = false;
            $objMsg->Message = 'Gagal membuat user, silahkan coba lagi';
            LogUtil::logError($objMsg->Message, $ex);
        }

        return $objMsg;
    }

    /**
     * Update User
     *
     * @param object $objParam
     * @param string|int $id
     * @return MessageData
     */
    public function updateUser(object $objParam, $id): MessageData
    {
        $objMsg = new MessageData();
        try {
            if (property_exists($objParam, 'password') && $objParam->password != null) {
                $objParam->password = bcrypt($objParam->password);
            }
            $user = $this->userRepo->updateUser((array) $objParam, $id);

            $objMsg->Status = true;
            $objMsg->Message = 'Berhasil mengubah user';
            $objMsg->Payload = $user;
        } catch (\Exception $ex) {
            $objMsg->Status = false;
            $objMsg->Message = 'Gagal mengubah user, silahkan coba lagi';
            LogUtil::logError($objMsg->Message, $ex);
        }

        return $objMsg;
    }

    public function deleteUser($id): MessageData
    {
        $objMsg = new MessageData();
        try {
            User::find($id)->delete();

            $objMsg->Status = true;
            $objMsg->Message = 'Berhasil hapus user';
        } catch (\Exception $ex) {
            $objMsg->Status = false;
            $objMsg->Message = 'Gagal hapus user, silahkan coba lagi';
            LogUtil::logError($objMsg->Message, $ex);
        }

        return $objMsg;
    }

    /**
     * Get User not admin
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getUsersNotAdmin()
    {
        return User::where('role', User::ROLE_USER);
    }

    /**
     * Get Users
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getUsers()
    {
        return User::query();
    }
}
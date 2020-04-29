<?php


namespace App\Services\User;


use App\Enums\UserStatus;
use App\Enums\UserType;
use App\Exceptions\User\AdminNotVerifiedException;
use App\Exceptions\User\UpdateNotDifferentValuesException;
use App\Models\User;

class UserService
{
    /**
     * @return User[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAllUsers()
    {
        return User::all();
    }

    /**
     * @param array $inputData
     * @return User|\Illuminate\Database\Eloquent\Model
     */
    public function storeUser(array $inputData)
    {
        $otherData = [
            'password' => bcrypt($inputData['password']),
            'verified' => UserStatus::UNVERIFIED,
            'admin'    => UserType::REGULAR,
        ];

        $data = array_merge($inputData, $otherData);

        return User::create($data);
    }

    /**
     * @param User $user
     * @param array $data
     * @return User
     * @throws AdminNotVerifiedException
     * @throws UpdateNotDifferentValuesException
     */
    public function updateUser(User $user, array $data)
    {
        if (isset($data['name']))
            $user->name = $data['name'];

        if (isset($data['email']) && $data['email'] != $user->email) {
            $user->verified = false;
            $user->verification_token = User::generateVerificationCode();
            $user->email = $data['email'];
        }

        if (isset($data['password']))
            $user->password = $data['password'];

        if (isset($data['admin'])) {
            if (!$user->isVerified())
                throw new AdminNotVerifiedException();
            $user->admin = $data['admin'];
        }

        if (!$user->isDirty())
            throw new UpdateNotDifferentValuesException();

        $user->save();
        return $user;
    }
}
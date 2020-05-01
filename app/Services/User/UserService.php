<?php


namespace App\Services\User;


use App\Enums\UserStatus;
use App\Enums\UserType;
use App\Mail\UserCreated;
use App\Models\User;
use Mail;
use Symfony\Component\HttpKernel\Exception\HttpException;

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
            'password'           => bcrypt($inputData['password']),
            'verified'           => UserStatus::UNVERIFIED,
            'verification_token' => User::generateVerificationCode(),
            'admin'              => UserType::REGULAR,
        ];

        $data = array_merge($inputData, $otherData);

        return User::create($data);
    }

    /**
     * @param User $user
     * @param array $data
     * @return User
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
                throw new HttpException(409, __('user/error.only_verified_user_can_modify_the_admin_field'));
            $user->admin = $data['admin'];
        }

        if (!$user->isDirty())
            throw new  HttpException(422, __('errors.need_to_specify_a_different_values'));

        $user->save();
        return $user;
    }

    /**
     * @param string $token
     * @return bool
     */
    public function verifyUser(string $token)
    {
        $user = User::where('verification_token', $token)->first();

        if (!$user)
            return false;

        $user->verification_token = null;
        $user->verified = UserStatus::VERIFIED;
        $user->save();

        return true;
    }

    /**
     * @param User $user
     */
    public function resendVerificationEmail(User $user)
    {
        if ($user->isVerified())
            throw new HttpException(409, __('user/error.This user is already verified!'));

        retry(5, function () use ($user) {
            Mail::to($user)->send(new UserCreated($user));
        }, 100);
    }
}
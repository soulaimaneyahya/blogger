<?php

namespace App\Services;

use App\Models\Image;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Storage;

class UserService
{
    public function __construct
    (
        private UserRepository $userRepository,
    )
    {
    }

    public function update(array $data, User $user)
    {
        $user->update(['name' => $data['name']]);
        $user->profile()->update([
            'description' => $data['description'],
            'url' => $data['url']
        ]);
        if (isset($data['avatar']) && $data['avatar'] instanceof \Illuminate\Http\UploadedFile) {
            $path = $data['avatar']->store('avatars');
            if ($user->profile->image) {
                Storage::delete($user->profile->image->path);
                $user->profile->image->path = $path;
                $user->profile->image->save();
            } else {
                $user->profile->image()->save(
                    Image::make(['path' => $path])
                );
            }
        }
        return $user;
    }

    public function find(User $user)
    {
        return $this->userRepository->find($user);
    }

    public function profile(User $user)
    {
        return $this->userRepository->profile($user);
    }
}

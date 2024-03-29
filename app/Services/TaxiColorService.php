<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserTaxi;
use Illuminate\Support\Facades\DB;

class TaxiColorService
{
    /**
     * @param User $user
     * @param UserTaxi $taxi
     * @param string $newColor
     * @return bool|string
     */
    public static function validateAndChangeColor(User $user, UserTaxi $taxi, string $newColor): bool|string
    {
        if ($validate = self::canChangeColor($user, $taxi)) {
            return $validate;
        }

        return self::changeColor($taxi, $newColor);
    }

    /**
     * @param UserTaxi $taxi
     * @param string $newColor
     * @return bool|string
     */
    private static function changeColor(UserTaxi $taxi, string $newColor): bool|string
    {
        return DB::transaction(function () use ($taxi, $newColor) {
            if ($taxi->color === $newColor) {
                return 'Taxi already has this color.';
            }

            if (is_null($taxi->color)) {
                $taxi->color = $newColor;
                $taxi->save();
                return true;
            }

            $colorChangeCost = 1000;

            if (floatval($taxi->user->credit) < $colorChangeCost) {
                return 'Not enough credits to change color.';
            }

            UserService::decreaseCredits($taxi->user, $colorChangeCost);


            $taxi->color = $newColor;

            $taxi->save();

            return true;
        });
    }

    /**
     * @param User $user
     * @param UserTaxi $userTaxi
     * @return string|null
     */
    public static function canChangeColor(User $user, UserTaxi $userTaxi): ?string
    {
        if ($userTaxi->user_id !== $user->id) {
            return 'You do not own this taxi.';
        }

        return null;
    }

}

<?php

namespace App\Permissions\V1;

use App\Models\User;

final class Abilities
{
    public const CreateTicket = 'ticket:create';
    public const UpdateTicket = 'ticket:update';
    public const ReplaceTicket = 'ticket:replace';
    public const DeleteTicket = 'ticket:delete';

    public const CreateOwnTicket = 'ticket:own:create';
    public const UpdateOwnTicket = 'ticket:own:update';
    public const DeleteOwnTicket = 'ticket:own:delete';

    public const CreateUser = 'user:create';
    public const DeleteUser = 'user:delete';
    public const UpdateUser = 'user:update';
    public const ReplaceUser = 'user:replace';
    public static function getAbilities(User $user)
    {
        $baseAbilities = [
            self::CreateOwnTicket,
            self::UpdateOwnTicket,
            self::DeleteOwnTicket,
        ];

        if ($user->is_manager) {
            $baseAbilities = array_merge($baseAbilities, [
                 self::CreateTicket,
                 self::UpdateTicket,
                 self::ReplaceTicket,
                 self::DeleteTicket,
                 self::CreateUser,
                 self::DeleteUser,
                 self::UpdateUser,
                 self::ReplaceUser,
             ]);
        }

        return $baseAbilities;
    }
}

<?php

namespace App\Permissions\V1;

use App\Models\User;

final class Abilities
{
    public const CreateTicket = 'ticket:create';
    public const UpdateTicket = 'ticket:update';
    public const ReplaceTicket = 'ticket:replace';
    public const DeleteTicket = 'ticket:delete';

    public const UpdateOwnTicket = 'ticket:own:update';
    public const DeleteOwnTicket = 'ticket:own:delete';

    public const CreateUser = 'user:create';
    public const DeleteUser = 'ticket:own:delete';
    public const UpdateUser = 'ticket:own:update';
    public const ReplaceUser = 'ticket:own:replace';
    public static function getAbilities(User $user)
    {
        if ($user->is_manager) {
            return [
                self::CreateTicket,
                self::UpdateTicket,
                self::ReplaceTicket,
                self::DeleteTicket,
                self::UpdateOwnTicket,
                self::DeleteOwnTicket,
                self::CreateUser,
                self::DeleteUser,
                self::UpdateUser,
                self::ReplaceUser,
            ];
        }

        return [
            self::CreateTicket,
            self::UpdateOwnTicket,
            self::DeleteOwnTicket,
        ];
    }
}

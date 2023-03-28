<?php

namespace Src;

class Utils
{
    public static function getSessionMsgAsErreur(string $sessionName): string
    {
        $msg = self::getSessionMsg($sessionName);
        return $msg == null
            ? ""
            : "<p class='txt-danger no-margin'>" .$msg."</p>";
    }

    public static function getSessionMsgAsSuccess(string $sessionName): string
    {
        $msg = self::getSessionMsg($sessionName);
        return $msg == null
            ? ""
            : "<p class='txt-success no-margin'>" .$msg."</p>";
    }

    public static function getSessionMsg(string $sessionName, bool $deleteAfter = true): ?string
    {
        $msg = $_SESSION[$sessionName] ?? null;
        if($deleteAfter) unset($_SESSION[$sessionName]);
        return $msg;
    }

    public static function getAvatar(\Model\User $user): string
    {
        return $user->getAvatar() ?? "/PublicAssets/Images/basic-pfp.png";
    }
}

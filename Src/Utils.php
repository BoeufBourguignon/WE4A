<?php

namespace Src;

class Utils
{
    public static function getSessionMsg(string $sessionName)
    {
        $msg = "";
        if(isset($_SESSION[$sessionName]))
        {
            $msg = "<p class='txt-danger no-margin'>" .$_SESSION[$sessionName]."</p>";
            unset($_SESSION[$sessionName]);
        }
        return $msg;
    }

    public static function getAvatar(\Model\User $user): string
    {
        return $user->getAvatar() ?? "/PublicAssets/Images/basic-pfp.png";
    }
}

<?php

namespace Src;

class Utils
{
    /**
     * Sert à afficher une erreur stockée dans une session
     * Utilisé lorsque l'erreur est générée sur une autre page que celle où elle est affichée
     *
     * @param string $sessionName Nom de la variable de Session contenant le message
     * @return string Balise <p> formatée pour une erreur
     */
    public static function getSessionMsgAsErreur(string $sessionName): string
    {
        $msg = self::getSessionMsg($sessionName);
        return $msg == null
            ? ""
            : "<p class='txt-danger no-margin'>" .$msg."</p>";
    }

    /**
     * Sert à afficher un message de succès stockée dans une session
     * Utilisé lorsque le message est générée sur une autre page que celle où elle est affichée
     *
     * @param string $sessionName Nom de la variable de Session contenant le message
     * @return string Balise <p> formatée pour un succès
     */
    public static function getSessionMsgAsSuccess(string $sessionName): string
    {
        $msg = self::getSessionMsg($sessionName);
        return $msg == null
            ? ""
            : "<p class='txt-success no-margin'>" .$msg."</p>";
    }

    /**
     * Récupère un message stocké en Session puis supprime ce message de la session
     *
     * @param string $sessionName Nom de la variable de Session contenant le message
     * @param bool $deleteAfter true (défaut) si le message est supprimé de la session, false s'il est gardé
     * @return string|null Le message si la variable de session existe, null sinon
     */
    public static function getSessionMsg(string $sessionName, bool $deleteAfter = true): ?string
    {
        $msg = $_SESSION[$sessionName] ?? null;
        if($deleteAfter) unset($_SESSION[$sessionName]);
        return $msg;
    }

    // TODO mettre cette méthode dans la classe user
    // Il faut aussi vérifie que la pdp existe dans le dossier des pdp, sinon afficher celle par défaut
    public static function getAvatar(\Model\User $user): string
    {
        return $user->getAvatar() ?? "/PublicAssets/Images/basic-pfp.png";
    }
}

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

    public static function getDateInterval(string $date): string
    {
        $dateDiff = (new \DateTime())->diff(new \DateTime($date));
        return $dateDiff->y > 0
            ? $dateDiff->y . " an(s)"
            : ( $dateDiff->m > 0
                ? $dateDiff->m . " mois"
                : ( $dateDiff->d > 0
                    ? $dateDiff->d . " jour(s)"
                    : ( $dateDiff->h > 0
                        ? $dateDiff->h . " heures"
                        : ( $dateDiff->i > 0
                            ? $dateDiff->i . " minutes"
                            : $dateDiff->s . " secondes"
                        )
                    )
                )
            );
    }
}

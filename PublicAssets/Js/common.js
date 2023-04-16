/*
 * Méthodes utilitaires
 */

// Méthode traitant les erreurs générées par Axios
function axiosCatchError(e)
{
    alert("Une erreur s'est produite")
    console.log(e)
}

// Méthode donc le handler doit être une fonction qui sera appelée à la fin du chargement du HTML de la page
// Deux raisons :
//  - s'assurer que tout le HTML soit bien chargé
//  - "confiner" les variables utilisées par chaque script afin qu'elles ne soient pas accessible globalement
function doOnLoad(handler)
{
    window.addEventListener("load", handler)
}
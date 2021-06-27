
### Fonctionnement du script


- Génération d'une liste de nombres en fonction d'un nombre de lignes 'a' et de colonnes 'b' .
- Retourne le groupe de '1' adjacent le plus gros.


Ex (4 lignes, 4 colonnes) :

````
11011
10000
10111
00000
````

Dans l'exemple ci-dessus, le programme retournerait le premier groupe avec une valeur de 4.

### Explications

Le programme commencer par la première valeur (tableau[0]), et vérifier si elle est un '1'. Si non, elle continue à la prochaine valeur.

Si oui, il va lancer 4 fonctions avec un paramètre d'index en paramètre entre ces choix :
- n-1
- n+1
- n+a
- n-a

Le programme va suite vérifier chacune des 4 fonctions (avec une sécurité, afin d'éviter que si l'on est à l'index 0 du tableau, cela ne cherche pas de valeur 0-b ou une valeur supérieur à la taille du tableau.)

Dès que la fonction rencontre un 1, elle l'ajoute à son groupe et lance à nouveau les 4 fonctions.

Dès que la fonction rencontre un 0, elle retourne à sa fonction Parent tout les nombres qu'elle a trouvé et s'auto-détruit (un booléan check est mis en 'true' quand une valeur du tableau est testé, afin d'éviter les doublons)

Au bout d'un moment, tous les nombres reviennent à la source, et la fonction showResult() va trier tout les résultats et garder celui avec le plus de "1".

S'il y a des groupes ex aequo, cela les retourne tous dans le résultat.
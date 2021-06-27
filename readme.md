# Recursive Bot

- Le programme demande (en console PHP / version Web) une largeur et longueur de tableau (de 0 à infini).
- Le programme génère des 0 et 1 aléatoirement sur chaque case du tableau
- Le programme vérifie ensuite chaque case et créer des groupes pour chaque 1 adjacents.
- Le programme retourne ensuite le tableau le plus gros trouvé en premier. (retourne tout les tableaux ex aequo en Version 3)


<hr>

### RecursiveBotV1 : 

+ Première version fonctionnelle 
+ Sans choix utilisateur, largeur et longueur à 5 en permanence.
+ Les messages de debug apparaissent en permanence
+ Index de résultat non adapté à la lecture humaine (renvoit l'index tableau commencant à 0 au lieu de 1)

### RecursiveBotV2 :

+ Avec choix utilisateur, allant de 0 à infini.
+ Les messages de debug apparaissent si $debugMode = 1
+ Index de résultat renvoyant le n°Tableau à partir de 1 pour meilleur lecture humaine

### RecursiveBotV3 :

+ Code allégé
+ Contrôle saisie utilisateur
+ Gestion de l'affichage des groupes identiques.

### RecursiveBotV3Web :

+ RecursiveBotV3 version Web



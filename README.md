# Création d'un template pour WPLP #

Le fonction wplp_register_template permet d'enregistrer un nouveau template sur WPLP.

La creation d'un template se fait en 2 étapes

1. Creation de l'arboressence du projet
	2 fichiers sont obligatoirement présent dans le repertoire de votre template:
	   - **index.php**
	   - **config.json**
	   
	Le fichier index.php contient toute la structure html de votre landing page, Le fichier **config.json** contient la configuration de votre landing page, notamment il permet de définir les assets (css, js). 

2. Declaration du projet dans le fichier
	Pour declarer un repertoire de template, nous avons crée la fonction **wplp_register_template** . Qui s'utilise comme tel et doit être ajoutée au fichier **wplandingpage.php** :


```
#!php

wplp_register_template('nom_system_template', 'nom_template', '/' . plugin_basename( dirname(__FILE__) ) . '/templates/nom_template');
```

## Screenshot ##

Pour identifier le template par une image lors le la selection de celui ci, il est possible d'insérer un screnshot dans le repertoire (a la racine) de votre template.

Cette image doit porter le nom "**screenshot.jpg**"

## Insertion d'assets ##

Pour le styling et javascript de votre template, le fichier de configuration **config.json** present a la racine de votre projet vous permettra de declarer ces assets.

**Attention** Veillez a utiliser une syntax json correcte (comme ci dessous).

```
#!json

{
	"css": [
		"css/style1.css",
		"css/style2.css"
	],
	"js": [
		"js/script1.js",
		"js/script2.js"
	]
}
```

## Texte modifiable ##

Dans votre fichier index.php il est possible d'utiliser la fonction **wplp_editable_text** pour laisser a l'administrateur de WordPress le choix du texte qu'il va renseigner dedans.

Le premier paramètre est la "**key**" qui est le nom de la meta attaché a ce champs

Le second paramètres est le **texte par default** que vous souhaitez mettre.



```
#!php

wplp_editable_text('template1_title', 'Ceci est le titre par default');
```

## Image Modifiable ##

Idem que pour le texte modifiable, la fonction **wplp_editable_image** peut être insérer dans votre index.php.

Le premier paramètre est la "**key**"

Le second paramètre est l'url vers **l'image par default**

Le troisième paramètre est la **classe par default** (utile pour le styling par exemple).



```
#!php

wplp_editable_image('template1_img', $urlTemplate.'img/1.jpg', 'maClass');
```

Notez qu'une variable **$urlTemplate** a été définie afin de vous aider a retrouver l'url du dossier du template.
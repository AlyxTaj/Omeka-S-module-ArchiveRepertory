��    ?        Y         p  o   q  J   �  F   ,  l   s  [   �  T   <  7   �  +   �  u   �     k     ~     �     �     �     �  �    	  �   �	  �   W
       #     @   8  W   y     �  A   �     1     7     Q  L   o  P   �  D     �   R  �   �  Z   �  #   �  =     	   C     M     Y     i  &   y  1   �      �  �   �  \   �  X   �  v   N  N   �          )     F  �   �  W   G  R   �  5   �  3   (  "   \  %     '   �  1   �  y   �  C   y  �   �  #  v  �   �  V   "  Q   y  �   �  u   `  n   �  S   E  ;   �     �     U  ,   s  '   �     �  "   �  #     �   /  �   �  �   �     �  ,   �  T   �  n   /  0   �  O   �           (   +   G   U   s   ^   �   `   (!  �   �!  �   7"  q   �"     b#  >   �#     �#     �#     �#     �#  &   
$  &   1$  &   X$  �   $  �   E%  �   �%  �   M&  a   �&     ?'  #   ^'  �   �'  �   :(  a   �(  ]   ])  @   �)  @   �)  $   =*  "   b*  '   �*  @   �*  �   �*  S   �+  �   �+     6   5                    4   2             1              )   ;   8   !      7       '   
       -      =              /   :   9           +                             <      >      ,   &   %       	          .               3   *                                    $      (                 "      0      ?         #        "Archive Repertory" module allows to save files in a hierarchical structure and to keep original name of files. (not recommended because your server is not fully compatible with Unicode) (recommended because your server is not fully compatible with Unicode) But if you use a module that calls a program via the command line of the server, filenames issues can occur. Cannot move file "%s" inside archive directory ("%s"): filepath longer than 190 characters. Cannot move file "%s" inside archive directory: filepath longer than 190 characters. Cannot move file inside archive directory: no filename. Cannot move files inside archive directory. Choose a prefix, for example "item:", "record:" or "doc:", to select the appropriate metadata when they are multiple. Convert file names Convert first letter and spaces Convert first letter only Convert item names Convert item set names Convert spaces to underscores Currently, changes in these settings affect only new uploaded files. So, after a change, old files will continue to be stored and available as previously. Currently, no check is done on the name of folders, either for items. No files will be lost if two folders have the same name, but files attached to a record will be mixed in this folder. Depending on your server and your needs, to avoid some potential issues, you can choose or not to rename every folder to its Ascii equivalent (or only the first letter). Don’t add folder Error directory non writable: "%s". Error during move of a file from "%s" to "%s" (local dir: "%s"). Error during move of a file from "%s" to "%s" (local dir: "%s"): source does not exist. Error making directory: "%s". Failed to create folder "%s": a file with the same name exists… Files Full conversion to Ascii. Hash filename (default Omeka) If this identifier does not exists, the Omeka internal item id will be used. If this identifier does not exists, the Omeka internal item set id will be used. If this is not the case, filenames should use only Ascii characters. If you choose to add a folder, Omeka will add subfolders for each item in "files" folders, for example "files/original/unique_identifier/". If you choose to add a folder, Omeka will add subfolders for the %sfirst%s item set of each item in "files" folders, for example "files/original/item_set_identifier/". In all cases, names are sanitized: "/", "\", "|" and other special characters are removed. Internal numeric id of the resource It is strongly recommanded to convert your filename to ascii. Item Sets Item folder Item set folder Keep name as it Let empty to use simply the first one. Missing Archive Repertory ingesters configuration Missing thumbnails configuration Nevertheless, when an item is updated, attached files will follow the current settings, so all files of a record will move and stay together inside the same folder. New files will be stored inside them. Old files will be moved when item set will be updated. New files will be stored inside them. Old files will be moved when item will be updated. Note that if you choose a non unique name, files will be mixed in the same folder, with higher risk of name collision. Omeka works fine with filenames with Unicode characters ("é", "ñ", "Å"…). Prefix for item sets See %s for more information. So recommended ids are a specifc metadata, "Dublin Core Identifier", "Internal resource id" and eventually "Dublin Core Title". So recommended ids are a specific metadata, "Dublin Core:Identifier", "Internal resource id" and eventually "Dublin Core:Title". The module "%s" was automatically deactivated because the dependencies are unavailable. There was an undetected error before storage, probably during the convert process. This file is not present in the original directory :  This module has resources that connot be installed. This module requires modules "%s". This module requires the module "%s". This server is compatible with Unicode. This server is not fully compatible with Unicode: Use only an Ascii character as first character of your filenames or set the option "Convert first character of filename". Usually, this is not a problem with this module and common modules. When all options are set, files will be saved in "files / original / item_set_identifier / item_identifier / original_filename.ext" instead of "files / original / hashed_filename.ext". Project-Id-Version: 
Report-Msgid-Bugs-To: 
PO-Revision-Date: 2021-02-08 00:00+0000
Last-Translator: Daniel Berthereau <Daniel.fr@Berthereau.net>
Language-Team: 
Language: fr
MIME-Version: 1.0
Content-Type: text/plain; charset=UTF-8
Content-Transfer-Encoding: 8bit
X-Generator: Poedit 2.4.2
 Le module "Archive Repertory" permet d’enregistrer les fichiers dans une arborescence et de conserver les noms de fichiers originaux. (non recommandé, car votre serveur n’est pas complètement compatible avec Unicode) (recommandé car votre serveur n’est pas complètement compatible avec Unicode) Cependant, si vous utilisez un module qui appelle un programme via le terminal du serveur, des erreurs liées aux noms de fichiers peuvent survenir. Impossible de déplacer le fichier "%s" dans l’arborescence ("%s") : le nom de fichier a plus de 190 caractères. Impossible de déplacer le fichier "%s" dans l’arborescence : le nom de fichier a plus de 190 caractères. Impossible de déplacer le fichier dans l’arborescence : pas de nom de fichier. Impossible de déplacer les fichiers dans l’arborescence. Choisir un préfixe, par exemple "item:", "record:" ou "doc:", pour sélectionner la valeur correcte quand il y en a plusieurs. Convertir les noms de fichier Convertir la première lettre et les espaces Convertir la première lettre seulement Convertir les noms des contenus Convertir les noms des collections Convertir les espaces en tirets bas Actuellement, les modifications des paramètres s’appliquent uniquement pour les nouveaux fichiers. Les anciens fichiers restent localisés au même endroit. Actuellement, aucune vérification n’est réalisée sur les noms de dossiers, ni pour les contenus. Aucun fichier ne sera perdu si deux dossiers ont le même nom, mais les fichiers attachés aux contenus seront placés ensemble dans le dossier. En fonction de votre serveur et de vos besoins et pour éviter d’éventuels problèmes, vous pouvez choisir ou non de renommer chaque dossier en son équivalent Ascii (ou seulement la première lettre). Ne pas ajouter de dossier Erreur dossier fermé en écriture : "%s". Erreur lors du déplacement d’un fichier de "%s" à "%s" (dossier local : "%s"). Erreur lors du déplacement d’un fichier de "%s" à "%s" (dossier local : "%s"): la source n’existe pas. Erreur lors de la création du dossier : "%s". Impossible de créer le dossier "%s" : un fichier existe avec le même nom… Fichiers Conversion complète en Ascii. Brouiller le nom de fichier (défaut Omeka) Si l’identifiant n’existe pas, le numéro interne Omeka du contenu sera utilisé. Si l’identifiant n’ existe pas, le numéro interne Omeka de la collection sera utilisé. Si ce n’est pas le cas, les noms de fichiers doivent utiliser seulement des caractères Ascii. Si vous choisissez d’ajouter un dossier, Omeka ajoutera des sous-dossiers pour chaque contenu dans les dossiers "files/", par exemple "files/original/identifiant_unique/". Si vous choisissez d’ajouter un dossier, Omeka choisira la %spremière%s collection de chaque contenu comme nom de sous-dossier, par exemple "files/original/identifiant_collection/". Dans tous les cas, les noms sont nettoyés : "/", "\", "|" et les autres caractères spéciaux sont supprimés. Numéro interne de la ressource Il est recommandé de convertir les noms de fichiers en ascii. Collections Dossier contenu Dossier collection Conserver le nom tel quel Laisser vide pour utiliser le premier. Configuration des ingéreurs manquante Configuration des vignettes manquantes Néanmoins, quand un contenu est mis à jour, les fichiers attachés suivent les paramètres en cours et tous les fichiers d’'un contenu sont déplacés et restent ensemble dans le même dossier. Les nouveaux fichiers sont enregistrés à l’intérieur. Les anciens fichiers sont déplacés quand la collection est mise à jour. Les nouveaux fichiers sont enregistrés à l’intérieur. Les anciens fichiers sont déplacés quand le contenu est mis à jour. Notez que si vous choisissez un nom non-unique, les fichiers seront mélangés dans le même dossier, avec un risque de collision plus élevé. Omeka gère parfaitement les noms de fichiers avec des caractères Unicode ("é", "ñ", "Å"…). Préfixes pour les collections Voir %s pour plus d’informations. Il est donc recommandé d’utiliser une métadonnée spécifique comme identifiant : "Dublin Core Identifiant", "Numéro de ressource interne" et éventuellement "Dublin Core Titre". Il est donc recommandé d’utiliser une métadonnée spécifique comme identifiant : "Dublin Core : Identifiant", "Numéro de ressource interne" et éventuellement "Dublin Core  : Titre". Le module "%s" a été automatiquement désactivé car ses dépendances ne sont plus disponibles. Une erreur inconnue est survenue avant l’enregistrement, probablement durant la conversion. Le fichier n’ est pas présent dans le dossier original :  Ce module a des ressources qui ne peuvent pas être installées. Ce module requiert les modules "%s". Ce module requiert le module "%s". Ce serveur est compatible avec Unicode. Ce serveur n’est pas complètement compatible avec Unicode : Utilisz seulement un caractère Ascii comme première caractère de vos fichiers ou choisissez l’option "Convertir le premier caractère du nom de fichier". Généralement, ce n’est pas un problème avec ce module ou les modules courants. Quand toutes les options sont choisies, les fichiers seront enregistrés dans "files / original / identifiant_collection / identifiant_item / fichier_original.ext" au lieu de "files / original / hashed_filename.ext". 
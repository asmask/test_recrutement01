test de recrutement
1/symfony new test_recrutement --webapp

2/ ajouter www.testrec01.local dans /etc/hosts
   modifier listen dans /etc/port.conf sur le port 5458
   
   Créer un fichier test_rec.conf dans /etc/sites-available
 
   puis ajouter

   <VirtualHost *:5458>
    ServerAdmin www.testrec01.local
    ServerName www.testrec01.local
    ServerAlias www.testrec01.local
    DocumentRoot /var/www/test_recrutement/public
    <Directory /var/www/test_recrutement/public>
        AllowOverride All
        Order allow,deny
        Allow from All
    </Directory>
    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
  </VirtualHost>

  puis activer le Vhost par la commande a2ensite test_rec.conf


3/
Ajouter security-bundle
Creer l'entite user avec la cmd php bin/console make:user
réer un formulaire de connexion utiliser la cmd php bin/console make:auth
assurer la migration dans la bd avec
bin/console make:migration
bin/console doctrine:migration:migrate
 
4/Creation de l'entité Facture php bin/console make:entity
 apres création de Crud avec  php bin/console make:crud
assurer la migration dans la bd avec
bin/console make:migration
bin/console doctrine:migration:migrate
5/modification de la page d'acceuil pour visualiser les factures dans un tableau
6/php bin/phpunit
7/générer le rapport de taux de couverture de code
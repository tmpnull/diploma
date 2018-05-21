# diploma
RESTful application for manage schedule hosted by Laravel

To deploy this application you need to follow next steps:
1) Install homestead by Laravel https://laravel.com/docs/5.6/homestead
2) Create folder in source folder "code"
3) Clone this repo into code folder
4) Connect to Vagrant box by ssh
5) Change dir to code
6) Run composer install
7) Install yarn packages
8) Run artisan migrate:fresh --seed to create tables and seed them

If you want to run PHP Unit tests, you need to add some changes in Homestead.yaml
1) Add homestead_test database
2) After connect to box, run migrate:fresh --seed -env="testing" to migrate testing environment

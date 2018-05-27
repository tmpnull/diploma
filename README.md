# diploma
RESTful application for manage schedule hosted by Laravel

To deploy this application you need to follow next steps:
1) Install homestead by Laravel https://laravel.com/docs/5.6/homestead
2) Create "code" folder inside homestead dir
3) Clone this repo into code folder
4) Connect to Vagrant box by calling vagrant ssh in homestead dir
5) Change dir to code
6) Run composer install
7) Run yarn install
8) Run artisan migrate:fresh --seed to create tables and seed them

If you want to run PHP Unit tests, you need to add some changes in Homestead.yaml
1) Add homestead_test database
2) After step 8, run migrate:fresh --seed -env="testing" to migrate testing environment

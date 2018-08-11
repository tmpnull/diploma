# diploma
## RESTful application for manage schedule hosted by Laravel

**To deploy this application you need to follow next steps:**
1. Install [Homestead by Laravel](https://laravel.com/docs/5.6/homestead)
   
   **If you want to run PHP Unit tests, you need to add following changes in *Homestead.yaml*:**
   1. Add "*homestead_test*" to databases list right after the "*homestead*"
   2. After step 11, ```run migrate:fresh --seed -env="testing"``` to create testing environment

2. Create "*code*" folder inside application base dir
3. Clone this repo into the "*code*" folder
4. Rename *.env.example* to *.env*
5. Run Vagrant box in homestead dir by calling ```vagrant up```
6. Connect to Vagrant box by calling ```vagrant ssh``` 
7. Go to *code* directory
8. Run ```composer install``` to install all php dependencies
9. Run ```yarn install``` to install all JS dependencies for authorization
10. By default *APP_KEY* is not present in *.env*, so you need to run 
```artisan key:generate```
11. Run ```artisan migrate:fresh --seed``` to create tables and seed them
12. Login to [http://homestead.test](http://homestead.test/login) using next credentials:
Login: ```admin@homestead.test```
Password ```123456```
13. Create OAuth tokens run ```artisan passport:install```

    **If you want to connect to API documentation by password authorization:**
    
    You can use *Password grant client credentials* from output or create new:
    1. Run  ```artisan passport:client --password``` set name ex. *swagger*
    2. Connect to Swagger docs at [http://homestead.test/api](http://homestead.test/api)
    3. Press *Authorize* button at the bottom of modal window use provided *Client ID* 
    and *Secret* from step 1 with user login/password combination

    **If you want to connect to API documentation usin authorization code:**
    1. Go to [http://homestead.test/home](http://homestead.test/home)
    2. Press *Create New Client* with name ex. *swagger* 
    Redirect url: ```http://homestead.test/api/oauth2-callback```
    3. Connect to Swagger docs at [http://homestead.test/api](http://homestead.test/api)
    4. Press *Authorize* button at the section with authorizationCode use provided
     *Client ID* and *Secret* from step 1 with user login/password combination

# aydbooks
**A demo project based on Laravel5.8 and Vue2(Frontend separated with Backend)**

**Preconditions for this app to run**
1. php 7.1+
2. mysql 5.6+
3. node 12.18.4
4. npm 6.14.6
5. nginx

**The main package dependencies for this project**

**For Laravel part**
1. tymon/jwt-auth ^1.0
2. lcobucci/jwt 3.3.3
3. guzzlehttp/guzzle ^6.5(**Laravel 6+ may come with it at default**)

**For Vue2 part**
1. axios ^0.26.0
2. element-ui ^2.15.6
3. js-cookie ^2.2.1
4. js-md5 ^0.7.3
5. jsencrypt ^3.0.0-rc.1 
6. sass ^1.32.0
7. sass-loader ^10.1.0
9. vue-i18n ^8.22.0

**Instructions for the Backend depolyment**
1. cd YOUR_WEB_ROOT/backend/bootstrap and create a new directory(cache) via 'mkdir cache' command;
2. cd .. and then run 'composer install'
3. copy or touch a .env file and paste the proper configuration values to it.
4. Run `php artisan jwt:secret` or set a JWT_SECRET=XXXXX at the end of .env
5. Create a database and a credentials for it and set it into the .env file
6. Run `php artisan migrate` to build the db table instructure.
7. Edit the seeder file `YOUR_WEB_ROOT/backend/database/seeds/BookDataGatherSeeder` and uncomment all code lines in the `run()` method of this seeder and save it.
8. Run `php artisan db:seed --class=BookDataGatherSeeder` to gather some books from an online book website.
9. Edit the seeder file `YOUR_WEB_ROOT/backend/database/seeds/CreateAdminUserSeeder` and uncomment all code lines in the `run()` method of this seeder and save it.
10. Run `php artisan db:seed --class=CreateAdminUserSeeder` to create a admin user and a member user for this application.

**Instructions for the Frontend depolyment**
1. cd YOUR_WEB_ROOT/frontend and create a new directory(dist) via 'mkdir dist' command;
2. Run `npm install`


Finally, just depoly it as you depoly other website in nginx.

#######PLEASE MAKE SURE THE PHP REQUEST PART CORRECT#########

`.....`

`root    /YOUR_WEB_ROOT/frontend/dist;`

`location / {`

		`index 	index.html index.htm;`
    
		`try_files $uri $uri/ /index.php?$query_string;`
    
`} `

`.....`

`location ~ \.php$ {`

		`root	/YOUR_WEB_ROOT/backend/public;`
    
		`fastcgi_pass unix:/dev/shm/php-cgi.sock;`
    
		`fastcgi_index index.php;`
    
		`fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;`
    
		`include fastcgi.conf;`
    
`}`

`.....`

################


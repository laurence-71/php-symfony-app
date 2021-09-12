 # PHP Symfony App
 This is an example of a general app that manage a bike repair shop from the source to the repair process, the recycling and the stock process

 This include 
 * an authentification from the start
 * a hierarchy for the access
 * the management of the repair process(register the source, the bikes, the operation you want to do, choose the article from the stocks(new or second-hand),estimate the price of the repair, edit a bill,...)
 * the customization of errors type 403,404 and 500 when the app is on prod
 * the example of the use of ChartJS to make some charts
 * the print pages(billing and estimate)
 * the export of the file in CSV

 # Set Up
 * In the folder you want your project in, open a command prompt

* Create the project with composer(make sure you've got it set allready, if not, check the download composer documentation)
```bash
composer create-project symfony/website-skeleton nameofyourproject
```
* Put yourself in the right directory
```bash
cd nameofyourproject
```

* Create a git repository
```bash
git init
git config --global user.name"username"
git config --global user.email"useremail"
```
* If you wish to run your tests you can install phpUnit
```bash
php bin/phpunit
```
# set up the project in your IDE(Visual Studio Code)

* Open the project in your IDE(Integrated Developpement Environment)

*Just slide your project folder in an open window of your IDE*

* Run your terminal and check the project is install properly by clicking the URL 
```bash
symfony serve
```

# Authentification Set Up
* Create the user
```bash
symfony console make:user
```

* Answer the question like the following

-User

-Yes, to store the data

-Email for the unique display

-Yes, to ash the password

*This will make the User entity and his repository*

* Add the field you want in the entity by calling it in the terminal
```bash
symfony console make:entity
```
*The name of the entity is User and should be allready made*

*Add the field, its type and its property(can be null or not)*

*As the database is not create yet, the migration will be made later*

# The controllers
```bash
symfony console make:controller User
symfony console make controller Admin
symfony console make:controller Registration
symfony console make:controller Security
```
**Their respectives templates will be created automatically**

# The forms
* User form
```bash
symfony console make:form
```
-name will be UserType

-entity will be User

* In the form itself the type will be

-TextType for the name

-EmailType for the email

-RepeatedType for the password, then PasswordType and the options*

*Update the content of the registrationController.Make a constructor with the UserPasswordHasherInterface, and the method for the creation of the form, secure the fields, and make the command to persist and flush to the database*

*Check the imports are right*

* Login form
```bash
symfony console make:auth
```
-style will be 1(login form authentication)

-class name will be LoginFormAuthenticator

-controller will be SecurityController

-and yes, we want a logOut url

*Update the route and the method in the SecurityController*

# The database

* Update the .env file with the name of the database, the user, and the proper version of the SGBD
* Create the database
```bash
symfony console doctrine:database:create
symfony console make:migration
symfony console doctrine:migrations:migrate
```
If you're using XAMPP the database will be apparent in the admin of phpMyAdmin . You will be abble to manage it from there too.

You can visualize your database in your IDE with the SQL tool extension

# The form for the login

* Update the config/package/security.yaml

As I want the app to open directly on the login form

```yaml
logout:
        path:app_logout
        # where to redirect after logout
        target:/
```

# The views

* Fill up the admin/index.html.twig the security/login.html.twig the registration/index ( make the form) and check its controller and set up the base.html.twig
* Don't forget to redirect your response in case of success in Form/Security/loginFormAuthenticator

# Setting up the roles

* In config/packages/security.yaml uncomment the roles and create the hierarchy
* In the AdminController prefix the route for /admin_
* Put the role ADMIN manuelly in the database
* Code the logic to edit the user roles
* Create the form and the respective template
* Make sure the route are set up correctly

# Create a user profile to allow the change of password

* In the entity User add the firstname and lastname if you want
* In the UserController just return the view
* Make the ProfileController
* In the template create the table that will contains the user informations
* Add the buttons to edit the name or the password
* Create a form EditPasswordType
* The password form will be create manually with a POST method
* In the method don't forget to encode the password
* update the respective templates
* Create some flash messages for the success and the errors
* In the controller create the function to edit the profile and to edit the password
* Put the respective route in the user.html.twig buttons

# Create the bundle to manage, customize the errors screens in production

* Put the .env in prod to see the error page, you can stay in dev and still see it (check below)
* Install twig pack that include TwigBundle and TwigBridge
```bash
composer require symfony/twig-pack
```
* In the templates create the folders and files like under
bundles\twigBundle\Exception
error403.html.twig
* Create as much files for the error that you need
* The most common are error403.html.twig, error404.html.twig,error500.html.twig
* Create the code for the error in the view
* If you are in prod mode don't forget to clear the cache
* In dev mode you can also see the error
```url
https://127.0.0.1:8000/index.php/_error/404
```
# Create the favicon

* Get favicon generator for real
* select your favicon image
* Generate your favicon and html code to create the files and the links to make sure all the browsers and format will show it
* Just copy all the links and paste them in your stylesheet block in the base.html.twig
* Downdload the zip package, unzip it
* Create a ressource folder in the public folder,a favicon folder and put all the file in it
* Update the route of the links in the base.html.twig

# Start to build the app 

In Case you miss it.
The app takes care of all the process of repair, recycling a bike, and the article requirements . In the admin I put the beginning of a statistic management with ChartJS ; I used version 2.9.3 instead of symfony/UX-chartJS . 
Next to be done: retrievement of the password in email, more stats charts, the management of the bikes stocks, put those bikes on sell or rent

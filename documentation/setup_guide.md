#MacOS
##Installation guide

###1: Clone the project

Using [git](https://git-scm.com/doc):

```
git clone https://github.com/vegardbb/Overvann.git
```

<br>

###2: Install php

####Using [homebrew](http://brew.sh): 

```
brew install php71
```

####Otherwise 

Install from [php.net](http://php.net/manual/en/install.macosx.php)

<br>

###3: Install mySQL

####Using [homebrew](http://brew.sh): 

```
brew install mysql
```

####Otherwise 

Install from [mysql.com](https://dev.mysql.com/doc/refman/5.7/en/osx-installation-pkg.html)

<br>

###4: Download and install mySQL server:

IMPORTANT: Write down the password shown to you after installing.

From [mysql.com](https://dev.mysql.com/downloads/mysql/), download and install the preferred installation filetype.

<br>

###5: Create and setup database:

Make sure the MySQL server is running. To start the server, go to System Preferences. On the bottom, you can see MySQL. 

```
# Navigate to the directory of the project
cd Overvann/

# Create the database
php app/console doctrine:database:create

# Generate the tables in the database
php app/console doctrine:schema:update --force
```

<br>


###6: Download all dependencies:
```
# Make sure you are in the directory of the project.
cd ~/Overvann

# Install bundles required.
# IMPORTANT: This will prompt for some fields. When it asks for password, insert the password you should have written down from step #4.
php composer.phar install
```

#### You are now ready to run the server from your machine!

<br>
<br>

##How to run the server
Make sure MySQL server is running and that you are in the directory of the project.

To run the server:
```
php app/console server:run
```




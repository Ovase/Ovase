### [MacOS](#MacOS)

### [Windows](#Windows)

<br>
<br>

#<a name="MacOS">Mac OS</a>
##Installation guide

Open the terminal ([iTerm2](https://www.iterm2.com) is recommended on mac)

###1: Navigate to the directory you want the project to be installed in

```
cd ~/
```

###2: Clone the project

Using [git](https://git-scm.com/doc):

```
git clone https://github.com/vegardbb/Overvann.git
```


###3: Install php

####Using [homebrew](http://brew.sh): 

```
# Install php 7.1 or any similar version if this is not available
brew install php71
```

####Otherwise 

Install from [php.net](http://php.net/manual/en/install.macosx.php)


###4: Install MySQL

####Using [homebrew](http://brew.sh): 

```
brew install mysql
```

####Otherwise 

Install from [mysql.com](https://dev.mysql.com/doc/refman/5.7/en/osx-installation-pkg.html)


###5: Download and install MySQL server:

IMPORTANT: Write down the password shown to you after installing.

From [mysql.com](https://dev.mysql.com/downloads/mysql/), download the DMG file on the bottom of the page.



###6: Download all dependencies:
```
# Make sure you are in the directory of the project.
cd ~/Overvann

# Install required bundles.
# IMPORTANT: This will prompt for some fields. When it asks for password, insert the password you should have written down from step #4.
php composer.phar install
```

###7: Create and setup database:

Make sure the MySQL server is running. To start the server, go to System Preferences. On the bottom, you can see MySQL. 

```
# Navigate to the directory of the project
cd Overvann/

# Create the database
php app/console doctrine:database:create

# Generate the tables in the database
php app/console doctrine:schema:update --force
```


#### You are now ready to run the server from your machine!

<br>

##How to run the server
Make sure MySQL server is running and that you are in the directory of the project.

To run the server:
```
php app/console server:run
```

<br>
<br>
<br>

#<a name="Windows">Windows</a>
##Installation guide



###1: Install XAMPP
Download and install from [apachefriends.org](https://www.apachefriends.org/download.html)


###2: Clone the project in the XAMPP\htdocs folder

Using [git](https://git-scm.com/doc):

```
# Navigate to in C:\xampp\htdocs
cd C:\xampp\htdocs

git clone https://github.com/vegardbb/Overvann.git
```


###3: Download all dependencies:
```
# Make sure you are in the directory of the project.
cd C:\xampp\htdocs\Overvann

# Install required bundles.
# The script is going to ask for parameteres. If you are not sure what to write, just press enter.
php composer.phar install
```

###4: Create and setup database:

Make sure the MySQL server is running. To start the server, open XAMPP and click the start button besides MySQL. 

```
# Navigate to the directory of the project
cd C:\xampp\htdocs\Overvann

# Create the database
php app/console doctrine:database:create

# Generate the tables in the database
php app/console doctrine:schema:update --force
```

#### You are now ready to run the server from your machine!

<br>

##How to run the server
Make sure MySQL server is running and that you are in the directory of the project.

To run the server:
```
php app/console server:run
```






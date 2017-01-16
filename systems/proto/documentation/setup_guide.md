## Installation guide:

### TODOs For This Guide

- Mention how to run with Apache
- Include Apache gotchas

### Sections

- [Installing on MacOS](#macos-installation)
- [Installing on Windows](#windows-installation)
- [Running the server during development](#running-the-server-during-development)

## MacOS installation

Open the terminal ([iTerm2](https://www.iterm2.com) is recommended on mac)

### 1: Install XAMPP

#### Using [Homebrew Cask](https://caskroom.github.io)

```
brew cask install xampp
```

#### Otherwise:

Download and install from [apachefriends.org](https://www.apachefriends.org/download.html)


### 2: Clone the project

Using [git](https://git-scm.com/doc), clone the project in the XAMPP/htdocs/ folder:

```
# Navigate to xampp/htdocs
cd /Applications/XAMPP/htdocs/

git clone https://github.com/vegardbb/Overvann.git
```


###3: Download all dependencies:
```
# Navigate to the directory of the project.
cd Overvann/

# Install required bundles.
# The script is going to ask for parameteres. If you are not sure what to write, just press enter.
php composer.phar install
```

###4: Create and setup database:

Make sure the MySQL server is running. To start the server, open XAMPP and click the start button besides MySQL. 

```
# Create the database
php app/console doctrine:database:create

# Generate the tables in the database
php app/console doctrine:schema:update --force
```

#### You are now ready to [run](#run) the server from your machine!

## Windows installation

### 1: Install XAMPP
Download and install from [apachefriends.org](https://www.apachefriends.org/download.html)


### 2: Clone the project

Using [git](https://git-scm.com/doc), clone the project in the XAMPP\htdocs folder:

```
# Navigate to in C:\xampp\htdocs
cd C:\xampp\htdocs

git clone https://github.com/vegardbb/Overvann.git
```


### 3: Download all dependencies:
```
# Navigate to the directory of the project.
cd Overvann

# Install required bundles.
# The script is going to ask for parameteres. If you are not sure what to write, just press enter.
php composer.phar install
```

### 4: Create and setup database:

Make sure the MySQL server is running. To start the server, open XAMPP and click the start button besides MySQL. 

```
# Create the database
php app/console doctrine:database:create

# Generate the tables in the database
php app/console doctrine:schema:update --force
```

#### You are now ready to [run](#run) the server from your machine!

## Running the server during development

Make sure MySQL server is running and that you are in the directory of the project.

To run the server:
```
php app/console server:run
```

### Deploying the application

Ovase use the Apache HTTP Server. To use this application with Apache, one must do the following:

1) Customize and add `proto.conf` to the appropriate Apache config folder
2) Fix file permissions

#### Fixing file permissions for app/cache and app/logs

Instructions below taken from [here](http://symfony.com/doc/2.0/book/installation.html#configuration-and-setup).

```
cd proto
rm -rf app/cache/*
rm -rf app/logs/*
# Them do either: 
sudo chmod +a "www-data allow delete,write,append,file_inherit,directory_inherit" app/cache app/logs
sudo chmod +a "`whoami` allow delete,write,append,file_inherit,directory_inherit" app/cache app/logs
# Or:
sudo setfacl -R -m u:www-data:rwX -m u:`whoami`:rwX app/cache app/logs
sudo setfacl -dR -m u:www-data:rwx -m u:`whoami`:rwx app/cache app/logs
```


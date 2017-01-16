## Installation guide:

### Sections

- [Installing on MacOS](#macos-installation)
- [Installing on Windows](#windows-installation)
- [Running the Server](#running-the-server)

## MacOS Installation

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

## Windows Installation

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

## Running the Server

Make sure MySQL server is running and that you are in the directory of the project.

To run the server:
```
php app/console server:run
```




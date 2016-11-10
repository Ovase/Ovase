### [MacOS](#MacOS)

### [Windows](#Windows)

<br>
<br>

#<a name="MacOS">Mac OS</a>
##Installation guide

Open the terminal ([iTerm2](https://www.iterm2.com) is recommended on mac)



###1: Install XAMPP

#### Using [Homebrew Cask](https://caskroom.github.io)

```
brew cask install xamppp
```

#### Otherwise:

Download and install from [apachefriends.org](https://www.apachefriends.org/download.html)


###2: Clone the project

Using [git](https://git-scm.com/doc), clone the project in the XAMPP/htdocs/ folder:

```
# Navigate to xampp/htdocs
cd /Applications/XAMPP/htdocs/

git clone https://github.com/vegardbb/Overvann.git
```


###3: Download all dependencies:
```
# Make sure you are in the directory of the project.
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

#### You are now ready to run the server from your machine!
<br>
<br>

#<a name="Windows">Windows</a>
##Installation guide



###1: Install XAMPP
Download and install from [apachefriends.org](https://www.apachefriends.org/download.html)


###2: Clone the project

Using [git](https://git-scm.com/doc), clone the project in the XAMPP\htdocs folder:

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
# Make sure you are in the directory of the project.
cd C:\xampp\htdocs\Overvann

# Create the database
php app/console doctrine:database:create

# Generate the tables in the database
php app/console doctrine:schema:update --force
```

#### You are now ready to run the server from your machine!

<br>

#<a name="run">How to run the server</a>

Make sure MySQL server is running and that you are in the directory of the project.

To run the server:
```
php app/console server:run
```




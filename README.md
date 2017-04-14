# README specific to the "multi-site" configuration of ProAges #

## What is this repository for? ##

### Quick summary ###

Currently each instance of ProAges uses one directory and one database. We will call such setup a configuration "mono-site" in the rest of this README.

This repository is meant to be used in an configuration where there is a single directory for all the production websites / agencies. Each website / agency still use their own database. We will call such configuration "multi-site" in the rest of this README.

* Production sites: as said before, the files are installed in a single directory. There is one database for each website / agency.

* Test site: the files are installed in a directory different from the directory of the production websites. There is one test database for the test website.

## How do I get set up? ##

### Configuration ###

The files that differ from a "mono-site" installation are */application/config/config.php* and */application/config/database.php*.

Those files above contain a section for each website / agency.

------------

To deploy for the first time, those files must be modified as follows:

* */application/config/config.php*

1. change the domain names to reflect the real domain names of the existing production websites (e.g. intranet.aevum.com.mx/aevum, intranet.apasesores.com/ap-asesores etc)

2. add the domain name of the test website (to create).

* */application/config/database.php*

1. change the database access details to those of the databases already used.

2. add the access details of the database for the test website (to create).

------------

Then, when a new website / agency is added (or deleted or changed), the files 

* */application/config/config.php*
* */application/config/database.php*

must be changed.

### Dependencies ###
None.

### Database configuration ###
The database configuration on the MySQL server is the same as for a "mono-site" installation.

### How to run tests ###
Manual tests.

### Deployment instructions ###

* Test website:

Create a database.

Create a directory on the Ubuntu server. Then *git clone* the repository from the branch *'singledirmanybds'*.

Create a domain / sub domain name, then make it point to the newly created directory.

Test (manually) and correct issues if any.

* Production websites:

Create directory on the Ubuntu server. Then *git clone* the repository from the branch *'singledirmanybds'*.

Migrate the production websites:

1. Select a production website to test the installation.
1. (Maybe, tester will be able to change their local hosts file to make the DNS name of the selected production website point to the IP address of where the machine where the new directory is installed. The purpose of this is to be able to test before users start using the new installation).
1. Notify the users that the application will be migrated and when.
1. Make the production website DNS name point to the newly created directory.
1. Test before the users start to work with the new install, if possible. Fix issues if any.
1. Monitor users' feedback during a period to be defined.

Repeat steps 1. to 6. for each production website.

* Cleaning up:

** Clean up the repository:

1. merge the branch *'singledirmanybds'* with *'master'*,
1. delete branch *'singledirmanybds'*.

** Delete the directories used for the "mono-site" configuration.

** Any other cleaning ...

## Misc. ideas to make deployment easier ##

* Use CodeIgniter migrations to ease database changes.
* ...
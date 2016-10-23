## About

Piwik is an open source web analytics software. It gives interesting reports on your website visitors, your popular pages, the search engines keywords they used, the language they speak… and so much more. Piwik aims to be an open source alternative to Google Analytics. Because Piwik has been built on the top of APIs, all the data is available through simple to use APIs. All features in Piwik are built inside plugins: you can download new plugins, and easily build your own. The user interface is fully customizable and light speed. [[http://piwik.org/]]

## Requirements

* Piwik 0.x.x: Zikula < 1.3
* Piwik 1.x.x: Zikula = 1.3.x
* Piwik 1.2.x: Zikula = 1.4.3+
* An installed Piwik instance

## Installation

To install Piwik simply unpack the distribution inside your Zikula modules directory. This will create the ./modules/Piwik directory and should contain all the files of the distribution. (note: if you downloaded your module from the Zikula Extensions database, then you should unpack your module from your Zikula root directory.)

Now, enter the administration portion of your Zikula site:

* Select MODULES Administration
* Find the Piwik entry in the list
* Click INSTALL (the green arrow) 

You should now have a fully functioning Piwik installation.

## Configure


### Piwik path

Example:

  yourdomain.com/piwik

### Site ID
You have to check http://yourdomain.com/piwikpath/index.php?module=SitesManager&action=index to see site-id.
If you are tracking using only one site with Piwik the initial id works - but take care if you need a different one.

### Token
Your token can be found at http://yourdomain.com/piwikpath/index.php?module=UsersManager

## Module configuration

You have to fill out the path to Piwik installation, the site-id and your token. Before activation you have to decide if you want tracking of administration pages. If not, all pages with &type=admin will not be tracked.

## Support

* All support questions should be posted to the [Zikula Modules forum](http://community.zikula.org/module-Forum-viewforum-forum-23.htm)
* Bugs and feature requests can be posted here in the [Issues tracker](https://github.com/phaidon/Piwik/issues)

## Changelog

### Piwik 1.3.0
  * Migrated to Core-2.0 spec for improved compatibility with Zikula 1.4.3+.

### Piwik 1.2.0
  * Workaround for Zikula < 1.3.4 and lang != en.
  * Formdateinput fixes.
  * Added opt-out funcitonality: Block, Hook, Api-Func, closes #7.
  * Added option to set heigth and width in opt out block settings.
  * Updated German translation.
  * Site dropdown problem fixed, #11.
  * Dashboard no connection fix, closes #12.
  * Show no connection message just once.
  * Piwik tracker updated, closes #13. 

### Piwik 1.1.0 (2012-07-02)
  * API-Dashboard added.
  * Automatical site detection added.
  * Translation files updated.
  * Troubleshooting page added.

### Piwik 1.0.0 (2011-08-20)
  * Recoding of the module for Zikula 1.3.x

### Piwik 0.3
  * New user views
  * Bugfixes #2

### Piwik 0.2
  * Gettext version of 0.1

### Piwik 0.1
  * Initial release

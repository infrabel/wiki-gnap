wiki-gnap
=========

We utilise a wiki to combine all our documentation in a central place. This place is called **Athena**, after the Greek goddess of wisdom.

As a platform we use [DokuWiki](https://www.dokuwiki.org/dokuwiki), combined with a bunch of plugins which enable us to:

  * Utilise templates to easily stub new pages
  * Have Single Sign-On with Active Directory
  * Mark pages as favorites
  * Easily create overview pages
  * Export pages as PDF
  * ...

[themes-gnap](https://github.com/infrabel/themes-gnap) is used to style everything to make it consistent.

All of this is hosted on an IIS webserver, running on Windows Server 2012 R2.

Getting all of this to work together can be quite a bit of work, which is why we bundled everything with a nice installer, to allow other enterprises and/or startups to easily setup a similar environment.

## Usage

 * Clone the repository.
 * Open a prompt and navigate to the directory you cloned to.
 * Run ```install.cmd``` to access the installation menu.
   * [Details on all available commands can be found in the documentation](https://github.com/infrabel/wiki-gnap/wiki).
 * Depending on your needs, you can install all required prerequisites, as well as DokuWiki, our graphical modifications, our plugin selection, our sample structure and some sample content.
 * [Read the documentation](https://github.com/infrabel/wiki-gnap/wiki) to read more on how to configure your installation.

## Copyright

Copyright © 2014 Infrabel and contributors.

## License

DokuWiki is licensed under [GPL v2](http://choosealicense.com/licenses/gpl-v2/ "Read more about the GPL v2 License"). Refer to [dokuwiki/base/COPYING](https://github.com/infrabel/wiki-gnap/blob/master/dokuwiki/base/COPYING) for more information.

PHP is licensed under [PHP License v3.01](http://www.php.net/license/3_01.txt "Read more about the PHP v3.01 License"). Refer to [php/3_01.txt](https://github.com/infrabel/wiki-gnap/blob/master/php/3_01.txt) for more information.

IIS URL Rewrite 2.0 is licensed under Microsoft Software Supplemental License Terms. Refer to [rewrite/rewrite_license.rtf](https://github.com/infrabel/wiki-gnap/blob/master/rewrite/rewrite_license.rtf) for more information.

7-zip is licensed under [GNU LGPL](http://choosealicense.com/licenses/lgpl-3.0/ "Read more about the LGPL Licencse"). Refer to [7z/license.txt](https://github.com/infrabel/wiki-gnap/blob/master/7z/license.txt) for more information.

themes-gnap is licensed under [BSD (3-Clause)](http://choosealicense.com/licenses/bsd-3-clause/ "Read more about the BSD (3-Clause) License"). Refer to [LICENSE](https://github.com/infrabel/themes-gnap/blob/master/LICENSE) for more information.

The GNaP theme uses ```Ace - Responsive Admin Template``` as it's base theme, which is licensed under [Extended License](https://github.com/infrabel/themes-gnap/blob/master/custom/ace/LICENSE-Ace), our license covers redistribution and usage by you. However, if you would like to show your support to the original author, you can [buy a Single application license here](https://wrapbootstrap.com/theme/ace-responsive-admin-template-WB0B30DGR?ref=cc), it's quite cheap after all.

wiki-gnap is licensed under [GPL v2](http://choosealicense.com/licenses/gpl-v2/ "Read more about the GPL v2 License"). Refer to [dokuwiki/modifications/COPYING](https://github.com/infrabel/wiki-gnap/blob/master/dokuwiki/modifications/COPYING) for more information.

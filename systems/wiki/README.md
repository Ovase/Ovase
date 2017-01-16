# Ovase Fagwiki

Dette er koden til Ovases fagwiki. Systemet er basert på [MediaWiki](https://www.mediawiki.org/wiki/MediaWiki), som er det samme systemet som Wikipedia bruker.

## Refactor-steg

Eg forsøker å sette opp fresh MediaWiki lokalt. Apache 2.4, PHP 7

1) Lasta ned MW 1.28.0 og brukte vanilla-oppsettet saman med wiki.conf
    * Fungerte ut av boksen
2) Installerte PHP APCu (php-apcu)
3) Installerte PHP Intl (php-intl)
4) Restarta apache

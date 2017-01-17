# Ovase Fagwiki

Dette er koden til Ovases fagwiki. Systemet er basert på [MediaWiki](https://www.mediawiki.org/wiki/MediaWiki), som er det samme systemet som Wikipedia bruker.

## HUSK Å SKRIVE TIL BOKMÅL/ENGELSK NÅR FERDIG

## Refactor-steg

Eg forsøker å sette opp fresh MediaWiki lokalt. Apache 2.4, PHP 7

1) Lasta ned MW 1.28.0 og brukte vanilla-oppsettet saman med wiki.conf
    * Fungerte ut av boksen
2) Installerte PHP APCu (php-apcu)
3) Installerte PHP Intl (php-intl)
4) Restarta apache
5) Gjorde installasjons-wizarden
    * Husk eigen brukar for eigen database
    * Valde ein del relevante extensions
6) Endra max. opplastningsstorleik (20M) i php.ini
7) Endra file permissions for `images`: 774
8) Kopierte extensions:
    * VisualEditor
    * TemplateData
9) Installerte Parsoid: [link](https://www.mediawiki.org/wiki/Parsoid/Setup)
    * På Ubuntu/Debian: Service by default
    * Må endre `/etc/mediawiki/parsoid/config.yaml` og restarte service
    * Må sjekke at port i LocalSettings.php er korrekt (8000 eller 8142)
10) Satte opp ny infoboks-mal
    * CSS-kode i artikkelen MediaWiki:Common.css
    * Mal-kode i artikkelen Mal:Infoboks tiltak
11) Satte opp ny mal for forhåndsvisning av artikkel
    * CSS-kode i artikkelen MediaWiki:Common.css
    * Mal-kode i artikkelen Mal:Forhåndsvisning artikkel
12) Importerte artiklar frå gamle fagwiki via XML

## TODO:

- Theme
- Lage "distribusjons-pakke" for artiklar, malar + css, bilete

## Ting å legge til i system scripts

Må finne yum-ekvivalente
```
sudo apt-get install apt-transport-https
sudo apt-get update && sudo apt-get install parsoid
```

## Moglege basis-themes for vidare utvikling

- Dgraph
- Metrolook
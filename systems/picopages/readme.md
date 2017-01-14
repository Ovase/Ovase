# Ovase Pico Pages

Ovase use Pico for static pages such as the frontpage and the "about us" page. This system can be installed entirely through composer.

## Parts

- `assets` contains images used in articles
- `content` contains Markdown-formatted articles
- `config` contains the config files of Pico and pico_edit
- `installer` contains a post-install procedure used for creating symlinks between Pico, Ovase's Pico theme and Ovase's version of pico_edit.

## How to set up

1. Check that the two `config.php` files of the config folder look correct
2. Run composer install

## Potential hick-ups

- You might need to run composer install as admin/su to create the symlinks

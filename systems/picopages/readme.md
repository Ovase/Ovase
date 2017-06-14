# Ovase Pico Pages

Ovase use Pico for static pages such as the frontpage and the "about us" page. This system can be installed entirely through composer.

## Parts

- `assets` contains images used in articles
- `content` contains Markdown-formatted articles
- `config` contains the config files of Pico and pico_edit
- `installer` contains a post-install procedure used for creating symlinks between Pico, Ovase's Pico theme and Ovase's version of pico_edit.

## How to set up

1. Check that the two `config.php` files of the config folder look correct
2. Run composer install (maybe twice in a row)
3. Create `twig-cache` folder inside the new www-folder (symlinked folder). Check folder permissions.

## Known bugs

- The *clear cache* functionality of pico_edit does currently not work.
    + A workaround is to ssh into the `twig-cache` folder and manually delete contents

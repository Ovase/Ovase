# Deployment notes

## Fresh install
Not included here: Installing dependencies for mediawiki and others. This includes apache, mysql, nodejs+parsoid, and more.

- Set proper group and file permissions based on the following suggestions:
    + http://docs.aws.amazon.com/AWSEC2/latest/UserGuide/install-LAMP.html
- Git clone Ovase repo, preferably to `/var/www`
- Follow module-dependant steps

### Picopages
- CD into picopages
- Follow instructions in readme
- Install apache config

### Prototype
- Restore database
- CD into proto
- `composer install`
    + This asks for MySQL details and Symfony secret
- If no database: `php app/console doctrine:database:create`
- Verify DB mapping: `php app/console doctrine:schema:validate`
- Update `app/config/config.yml` with API keys
- Install apache config

### Wiki
- Restore database
- CD into wiki
- Copy `mw_keys.secret` and `sql_user.secret` into folder
- (Soon obsolote): Copy `LocalSettings.php` into folder
- Restore images
- `chmod -R 774 images/`
- Install apache config



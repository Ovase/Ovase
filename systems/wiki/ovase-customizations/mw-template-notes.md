# A few notes on creating mediawiki templates

### Headers inside templates
Careful about including headers (h1, h2, ...) in templates. If your MediaWiki article has a table of contents, it will be inserted above the first section heading. This means that it can get inserted **inside the template** if the template is inserted early in the article.
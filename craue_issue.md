Hi!

Previously I have created single-page forms where the user can upload images using a FileType form, and later, when using the same single-page form to edit the entity, the uploaded images are displayed using a CollectionType. The CollectionType has `allow_delete` set to `true`, which means that it can be used to delete images, while the same FileType form can be used to upload new ones. This works well in normal forms due to:

1. I store the images in the entity before `$form->handleRequest()' and compare with the images in the CollectionType afterwards. I remove deleted images.
2. Images that are uploaded using the FileType are moved into the CollectionType before persisting.

With flows, this is not as straight-forward. I have been tinkering with this, and I now have it working, but I want to know if there is an easier way.

First, I show how I do this with a single-page form. I use most of the tips from here:
- [http://symfony.com/doc/current/form/form_collections.html](http://symfony.com/doc/current/form/form_collections.html)
And my controller looks something like this:
```php


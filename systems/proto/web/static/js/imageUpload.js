function addImageFormDeleteLink($imageFormDiv) {
    var $removeFormA = $('<a href="#">Delete this image</a>');
    $imageFormDiv.append($removeFormA);
    $removeFormA.on('click', function(e) {
        e.preventDefault();
        $imageFormDiv.remove();
    });
}

var $addImageLink = $('<a href="#" class="add_image_link">Add image</a>');

function initImageUploadFunctionality($collectionHolder) {
    $collectionHolder.find('input[type="hidden"]').each(function() {
        var value = this.value;
        var $imageDiv = $('<div class="img-preview"></div>').html('<img src="' + value + '">');
        $(this).after($imageDiv);
    });
    $collectionHolder.children('div').each(function() {
        addImageFormDeleteLink($(this));
    });
}

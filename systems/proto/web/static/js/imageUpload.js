function addImageFormDeleteLink($imageFormDiv) {
    var $removeFormA = $('<a class="delete-img-anchor" href="#">Slett bilde</a>');
    $imageFormDiv.append($removeFormA);
    $removeFormA.on('click', function(e) {
        e.preventDefault();
        $imageFormDiv.remove();
    });
}

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

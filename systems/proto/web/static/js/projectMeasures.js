// Add a new measure form
function addMeasureForm($collectionHolder, $addMeasureLink) {
    var template = $collectionHolder.data('prototype');
    var index = $collectionHolder.data('index');
    // Replace placeholders with index
    var newForm = template.replace(/__name__label__/g, index);
    newForm = newForm.replace(/__name__/g, index);
    $collectionHolder.data('index', index + 1);
    // Display form before the 'add measure' div
    var $newFormDiv = $('<div></div>').append(newForm);
    addMeasureFormDeleteLink($newFormDiv);
    $addMeasureLink.before($newFormDiv);
}

// Add a delete link to measure form
function addMeasureFormDeleteLink($measureFormDiv) {
    var $removeFormA = $('<a class="delete-measure-anchor" href="#">Slett dette tiltaket</a>');
    $measureFormDiv.append($removeFormA);
    $removeFormA.on('click', function(e) {
        e.preventDefault();
        $measureFormDiv.remove();
    });
}

var $addMeasureLink = $('<a href="#" class="add-measure-link">Legg til nytt overvannstiltak</a>');

function initProjectMeasuresEdit($collectionHolder) {
    $collectionHolder.append($addMeasureLink);
    $collectionHolder.children('div').each(function() {
        addMeasureFormDeleteLink($(this));
    });
    // Count measures
    $collectionHolder.data('index', $collectionHolder.children('div').length);
    $addMeasureLink.on('click', function(e) {
        e.preventDefault();
        addMeasureForm($collectionHolder, $addMeasureLink);
    });
}

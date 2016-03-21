/**
 * Created by Nikita on 11.03.2016.
 */
$(document).ready(function(){
    var container = $('#color-filter');
    container.on('change', '[type=checkbox][name="color"]', function(){
        $(document).trigger('filterProductsList');
    }).on('click', '.clear-selection', function(e){
        e.preventDefault();
        container.find('[type=checkbox][name="color"]:checked').attr('checked', false);
        $(document).trigger('filterProductsList');
    })
});
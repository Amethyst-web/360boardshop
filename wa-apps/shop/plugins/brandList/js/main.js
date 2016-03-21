/**
 * Created by Nikita on 11.03.2016.
 */
$(document).ready(function(){
    var container = $('#brand-filter');
    container.on('change', '[type=radio][name="brand"]', function(){
        $(document).trigger('filterProductsList');
    }).on('click', '.clear-selection', function(e){
        e.preventDefault();
        container.find('[type=radio][name="brand"]:checked').attr('checked', false);
        $(document).trigger('filterProductsList');
    })
});
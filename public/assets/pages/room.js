(function ($) {
    $(document).on('submit', 'form.favoriteForm', function(e) {
        // Stop default behavior
        e.preventDefault();
        // Get form data
        const formData = $(this).serialize();
        // Ajax request
        $.ajax(
            '/public/ajax/room_favorite.php',
            {
                type: "POST",
                dataType: "json",
                data: formData
            }).done(function(result) {
                console.log(result);
                if (result.status){
                    
                //    $('input[name=is_favorite]').val(result.is_favorite ? 1 : 0);
                if ($('input[name=is_favorite]').val(result.is_favorite)) {
                    console.log(result.is_favorite);
                    $("#ajaxtd").replaceWith(`<td>
                    <?php if ($isFavorite == 1) { ?>
                    <i class="fas fa-heart"></i>
                    <input name="remove" id="RemButton" type="submit" value="Remove from Favorites">
                    <?php } ?> </td>`)
                } else {
                    $("#ajaxtd").replaceWith(`<td><?php if ($isFavorite == 0) { ?>
                    <i class="far fa-heart"></i>
                    <input name="add" id="FavButton" type="submit" value="Add to Favorites"> 
                    <?php } ?>   
                    </td>`)
                }        
                
                
                } else {
                    
                }
            });       
    });

    $(document).on('submit', 'form.reviewForm', function(e) {
        // Stop default behavior
        e.preventDefault();
        // Get form data
        const formData = $(this).serialize();
        // Ajax request
        $.ajax(
            'http://hotel.collegelink.localhost/public/ajax/room_review.php',
            {
                type: "POST",
                dataType: "json",
                data: formData
            }).done(function(result) {
                               
            });       
    });

})(jQuery);
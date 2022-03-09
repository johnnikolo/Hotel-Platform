(function ($) {
    $(document).on('submit', 'form.searchForm', function(e) {
        // Stop default behavior
        e.preventDefault();

        // Get form data
        const formData = $(this).serialize();
        // Ajax request
        $.ajax(
            '/public/ajax/search_results.php',
            {
                type: "GET",
                dataType: "html",
                data: formData
            }).done(function(result) {
                // Clear results container
                $('#search-results-container').html('');

                // Append results container
                $('#search-results-container').append(result);

                // Push url state
                history.pushState({}, '', '/public/list.php?' + formData);
            });       
    });
})(jQuery);

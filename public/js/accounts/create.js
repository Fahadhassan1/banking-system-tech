document.addEventListener("DOMContentLoaded", function () {

        var bookIndex1 = 0;
        $('#bookForm')     
            // Add button click handler
            .on('click', '.addButton', function() {
                bookIndex1++;
                var template = $('#bookTemplate');
                $('#submit-button').removeClass('d-none');
            
                var clone    = template
                                    .clone()
                                    .removeClass('d-none')
                                    .removeAttr('id')
                                    .attr('data-book-index', bookIndex1)
                                    .insertAfter('.accounts-fields:last');
                                    

                // Update the name attributes
                clone.find('.bookFormRemoveButton').removeClass('d-none');
                clone
                    .find('.user_id').attr('name', 'accounts[' + bookIndex1 + '][user_id]').val('').end()
                    .find('.fname').attr('name', 'accounts[' + bookIndex1 + '][fname]').val('').end()
                    .find('.lname').attr('name', 'accounts[' + bookIndex1 + '][lname]').val('').end()
                    .find('.dob').attr('name', 'accounts[' + bookIndex1 + '][dob]').val('').end()
                    .find('.address').attr('name', 'accounts[' + bookIndex1 + '][address]').val('').end()
                    .find('.phone').attr('name', 'accounts[' + bookIndex1 + '][phone]').val('').end()
                    .find('.currency').attr('name', 'accounts[' + bookIndex1 + '][currency]').val('').end()
                    .find('.balance').attr('name', 'accounts[' + bookIndex1 + '][balance]').val('').end();
            })

            // Remove button click handler
            .on('click', '.removeButton', function() {
                var row  = $(this).parents('.form-group'),
                    index = row.attr('data-book-index');
                row.remove();

            });
});
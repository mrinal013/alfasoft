jQuery(document).ready(function( $ ) {
    $('.js-example-basic-single').select2({ width: '100%' });

    $(document).on('click', '.add-button', function() {
        // console.log($(this).data('id'))
        $(this).closest('div[id^="wrapper"]').find('.error').remove()

        var country = $(this).closest('div[id^="wrapper"]').find('select option:selected').text()
        var telNumber = $(this).closest('div[id^="wrapper"]').find('.number').val()
        let isnum = /^\d+$/.test(telNumber);
        var id = $(this).closest('div[id^="wrapper"]').attr('id')
        var contactNo = $('.contact-management-table').find('tr').length
        if ( isnum && ( telNumber.length == 9 ) ) {
            var data = {
                'action': 'contact_management_action',
                'telNumber': telNumber,
                'country': country,
                'postId': id,
                'contactNumber': contactNo
            }
            $.ajax({
                url: ajaxurl,
                method: 'POST',
                data,
                success: function( response ) {
                    console.log(response)
                }
            })
        } else {
            $(this).closest('div[id^="wrapper"]').append('<div class="error">Number should be digits and 9 character long</div>')
        }
    })
});

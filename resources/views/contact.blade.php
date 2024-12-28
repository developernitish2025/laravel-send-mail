<!DOCTYPE html>
<html>
<head>
    <title>Contact Form</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div id="messageContainer"></div>
    <form id="contactForm">
        @csrf
        <div>
            <label>Name:</label>
            <input type="text" name="name" id="name">
            <span class="error" id="nameError"></span>
        </div>
        <div>
            <label>Email:</label>
            <input type="email" name="email" id="email">
            <span class="error" id="emailError"></span>
        </div>
        <div>
            <label>Message:</label>
            <textarea name="message" id="message"></textarea>
            <span class="error" id="messageError"></span>
        </div>
        <button type="submit">Submit</button>
    </form>

    <script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json'  // Add this line
            }
        });

        $('#contactForm').on('submit', function(e) {
            e.preventDefault();

            // Clear previous errors
            $('.error').text('');
            $('#messageContainer').html('');

            let formData = new FormData(this);  // Use FormData instead

            $.ajax({
                type: 'POST',
                url: '/contact/submit',
                data: formData,
                processData: false,  // Don't process the data
                contentType: false,  // Don't set content type
                success: function(response) {
                    $('#messageContainer').html('<div class="alert alert-success">' + response.message + '</div>');
                    $('#contactForm')[0].reset();
                },
                error: function(xhr) {
                    if (xhr.status === 422) {  // Validation error
                        var errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            $('#' + key + 'Error').text(value[0]);
                        });
                    } else {
                        $('#messageContainer').html('<div class="alert alert-danger">An error occurred. Please try again.</div>');
                    }
                }
            });
        });
    });
    </script>

    <style>
    .error {
        color: red;
        font-size: 0.8em;
        margin-left: 10px;
    }
    .alert {
        padding: 15px;
        margin-bottom: 20px;
        border: 1px solid transparent;
        border-radius: 4px;
    }
    .alert-success {
        color: #155724;
        background-color: #d4edda;
        border-color: #c3e6cb;
    }
    .alert-danger {
        color: #721c24;
        background-color: #f8d7da;
        border-color: #f5c6cb;
    }
    </style>
</body>
</html>

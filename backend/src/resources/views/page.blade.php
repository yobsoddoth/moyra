<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous"
        >
        <style>
            a {
                font-size: 2rem;
            }
        </style>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body>
        <div class="container">
            <h1>Booklist</h1>
            <div class="booklist"></div>
        </div>
    </body>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous">
    </script>

    <script>
        $(document).ready(() => {
            console.log("jQuery at the ready")

            $.get('/api/read')
                .done((data) => {
                    console.log(data)

                    let $booklist = $('.booklist')
                    data.forEach((book) => {
                        $booklist.append(
                            $('<div></div>')
                                .append(`<a href="#">${book.title}</a>`)
                                .append(`<p>${book.annotation}</p>`)
                        )
                    })
                })
        })
    </script>
</html>
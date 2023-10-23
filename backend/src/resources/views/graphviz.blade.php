<!DOCTYPE html>
<html>
    <head>
        @vite(['resources/js/app.js'])
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <style>
            body {
                font-family: "Georgia", "Times New Roman";
            }
            .graph {
                position: relative;
                min-width: 100%;
                min-height: 50%;
                overflow: scroll;
                margin-bottom: 1rem;
                padding: 1rem;
            }

            .editor {
                margin:1rem 0;
            }
            .episode-editor {
                position:relative;
                width:40%;
                height:40%;
                overflow: hidden;
            }
            .episode-editor textarea {
                position: relative;
                width:100%;
                height:100%;
            }
            .episode-choices {
                width: 40%;
            }
            .episode-choices-panel-controls {
                margin-top: 2rem;
            }
            .choice {
                background-color: #ffffcc;
                border: 1px solid orange;
                padding: 0.5rem;
            }
            .choice input {
                width: 98%;
                margin-top: 0.5rem;
            }
            .choice button {
                margin: 0.05rem
            }
            .choice-content-input {
                font-family: "Georgia";
                font-size: 1.1rem;
            }
            .choice-summary-input {
                font-size: 0.9rem;
            }
        </style>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    </head>

    <body>

        <div id="graph" class="graph">
            <div class="text-center">
                <div class="spinner-border" style="width: 5rem; height: 5rem;" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>

        <div id="editor" class="episode-editor">
            <div>
                <label for="episode-summary">Summary</label>
                <input type="text" name="episode-summary" id="episode-summary"/>
            </div>
            <textarea id="text-editor"></textarea>
        </div>

        <div class="episode-choices">
            <div id="episode-choices-panel" class="episode-choices-panel"></div>
            <div class="episode-choices-panel-controls">
                <button type="button" class="btn btn-success" id="btn-add-choice"><strong>Add Choice</strong></button>
            </div>
        </div>

    </body>
</html>
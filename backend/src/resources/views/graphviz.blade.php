<!DOCTYPE html>
<html>
    <head>
        @vite(['resources/js/app.js'])
        <style>
            body {
                font-family: "Georgia", "Times New Roman";
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
                border: 1px solid black;
                width: 40%;
            }
            .choice {
                background-color: gold;
            }
            .choice input {
                font-size:1.2rem;
                width: 98%;
                margin-top: 0.5rem;
            }
            .choice button {
                font-size:1.1rem;
                margin: 0.05rem
            }
        </style>
    </head>

    <body>
        <div id="graph" class="graph" style="width: 100%; height: 50%; overflow: scroll; position: relative;"></div>
        <div id="editor" class="episode-editor">
            <h3 id="episode-summary"></h3>
            <textarea id="text-editor"></textarea>
        </div>
        <div class="episode-choices">
            <div id="episode-choices-panel" class="episode-choices-panel"></div>
            <div class="episode-choices-panel">
                <button type="button" id="btn-add-choice"><strong>Add Choice</strong></button>
            </div>
        </div>
    </body>
</html>
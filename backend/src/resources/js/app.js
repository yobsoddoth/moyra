import './bootstrap'

import { instance } from '@viz-js/viz'

// Import TinyMCE
import tinymce from 'tinymce/tinymce'

// A theme is also required
import 'tinymce/themes/silver/theme'
import 'tinymce/skins/ui/oxide/skin.min.css'
import 'tinymce/skins/content/default/content.min.css'
import 'tinymce/skins/content/default/content.css'
import 'tinymce/icons/default/icons'
import 'tinymce/models/dom/model'
import 'tinymce/plugins/preview'
import 'tinymce/plugins/searchreplace'
import 'tinymce/plugins/visualblocks'

import Choice from './choice'
import BookSchema from './bookschema'
import axios from 'axios'

const graph = {
    graphAttributes: {
        rankdir: "LR"
    },
    nodeAttributes: {
        shape: "circle"
    },
    nodes: [
        { name: "a", attributes: { label: { html: "<i>A</i>" }, color: "red" } },
        { name: "b", attributes: { label: { html: "<b>A</b>" }, color: "green" } }
    ],
    edges: [
        { tail: "a", head: "b", attributes: { label: "1" } },
        { tail: "b", head: "c", attributes: { label: "2", headport: "name" } }
    ],
    subgraphs: [
        {
            name: "cluster_1",
            nodes: [
                {
                    name: "c",
                    attributes: {
                        label: {
                            html: "<table><tr><td>test</td><td port=\"name\">C</td></tr></table>"
                        }
                    }
                }
            ]
        }
    ]
}

let bookSchema = {
    graphAttributes: {
        rankdir: "LR",
        bgcolor: "#eeeecc",
    },
    nodeAttributes: {
        shape: "rectangle",
        style: "filled",
        color: "black",
        penwidth: 1,
        pad: 10,
        fillcolor: "#3356aa",
        fontsize:16,
        fontname: "Georgia",
        fontcolor:"lightgray",
        class:"episode-node",
    },
    edgeAttributes: {
        fontsize:12,
        fontname:"Comic Sans MS",
        fillcolor:"gray",
    },
    nodes: [
        {name: "E1", attributes: {label: "start at crossroads", id: "00-0000-e1", fillcolor: "darkgreen"}},
        {name: "E2", attributes: {label: "turned left", id: "00-0000-e2"}},
        {name: "E3", attributes: {label: "turned right", id: "00-0000-e3"}},
        {name: "E4", attributes: {label: "it's a junction", id: "00-0000-e4", fillcolor:"maroon"}},
    ],
    edges: [
        {tail: "E1", head: "E2", attributes: {label: "turn left"}},
        {tail: "E2", head: "E1", attributes: {label: "back"}},

        {tail: "E1", head: "E3", attributes: {label: "turn right"}},
        {tail: "E3", head: "E1", attributes: {label: "back"}},

        {tail: "E1", head: "E4", attributes: {label: "confront author"}},
    ]
}

const viz = instance()

axios.get('/api/write/schema/9a678df6-a8b9-405d-bd09-9a22846a3cda')
    .then((response) => {
        console.log(response)

        bookSchema.nodes = response.data.nodes
        bookSchema.edges = response.data.edges

        document.dispatchEvent(new Event('moyra:book-schema-loaded'))
    })

let schema = new BookSchema(bookSchema)

let $graph = document.getElementById('graph')
let $svgRendition;
let editingEpisodeUuid;

tinymce.init({
    selector: 'textarea#text-editor',
    skin: false,
    // content_css: false,
    content_style: "body { font-family: Georgia; font-size: 14pt;}",
    menubar: false,
    plugins: [
      'preview','searchreplace','visualblocks',
    ],
    toolbar: 'undo redo | casechange blocks | bold italic backcolor | ' +
      'alignleft aligncenter alignright alignjustify | ' +
      'bullist numlist checklist outdent indent | removeformat | a11ycheck code table help',
  });

function renderBookSchema(viz) {
    $svgRendition = viz.renderSVGElement(schema.asGraphviz())
    $graph.innerHTML = ''
    $graph.appendChild($svgRendition)

    document.querySelectorAll('.node').forEach((node) => {
        node.addEventListener('click', (e) => {
            let $epiNode = e.target.parentElement
            let episodeId = editingEpisodeUuid = $epiNode.getAttribute('id')
            let episodeSummary = $epiNode.querySelector('text').innerHTML

            document.getElementById('episode-summary').value = episodeSummary

            if (!schema.isFreshNode(episodeId))
                axios.get(`/api/write/episode/${episodeId}`)
                    .then((response) => {
                        tinymce.activeEditor.setContent(response.data.content)

                        let $choices = document.getElementById('episode-choices-panel')
                        $choices.innerHTML = ''

                        response.data?.choices.forEach((ch) => {
                            let $choice = new Choice('choice', episodeId, ch)
                            $choices.appendChild($choice.render())
                        })
                    },
                    (error) => {
                        console.log(error)
                        let $choices = document.getElementById('episode-choices-panel')
                        $choices.innerHTML = ''
                        tinymce.activeEditor.setContent(episodeSummary)
                    })



            // let $choice = new Choice('choice', episodeId)
            // $choices.appendChild($choice.render())
        })
    })
}

document.getElementById('btn-add-choice').addEventListener('click', (e) => {
    let $choices = document.getElementById('episode-choices-panel')
    let $choice = new Choice('choice', editingEpisodeUuid)
    $choices.appendChild($choice.render())
})

document.addEventListener('moyra:episode-make', (e) => {
    console.log(e.detail)
    let data = e.detail

    schema.makeNode(data.episodeSummary, data.towardsEpisodeUuid)
    schema.connect()
        .from(data.episodeUuid)
        .to(data.towardsEpisodeUuid)
        .via(data.choiceSummary, data.uuid)
        .end()

    viz.then(renderBookSchema)
})

document.addEventListener('moyra:book-schema-loaded', () => {
    viz.then(renderBookSchema)
})

// viz.then(renderBookSchema)

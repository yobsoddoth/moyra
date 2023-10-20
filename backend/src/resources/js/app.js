import './bootstrap'

import { instance } from "@viz-js/viz"

// Import TinyMCE
import tinymce from 'tinymce/tinymce';

// A theme is also required
import 'tinymce/themes/silver/theme';
import 'tinymce/skins/ui/oxide/skin.min.css';
import 'tinymce/skins/content/default/content.min.css';
import 'tinymce/skins/content/default/content.css';
import 'tinymce/icons/default/icons';
import 'tinymce/models/dom/model';
import 'tinymce/plugins/preview';
import 'tinymce/plugins/searchreplace';
import 'tinymce/plugins/visualblocks';


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

const bookSchema = {
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
let $graph = document.getElementById('graph')
let $svgRendition;

let $button = document.createElement('BUTTON')
$button.appendChild(document.createTextNode('add to graph'))

$button.addEventListener('click', () => {
    console.log('button clicked')
    bookSchema.nodes.push({ name: "dynamic node", attributes: { label: { html: "<b>Dyn</b>" }, color: "cyan" } })
    bookSchema.edges.push({ tail: "E4", head: "dynamic node", attributes: { label: "dynamic link" } })

    viz.then(viz => {
        $svgRendition = viz.renderSVGElement(bookSchema)
        $graph.innerHTML = ""
        $graph.appendChild($svgRendition)
    })
})
document.body.appendChild($button)

let $editor = tinymce.init({
    selector: 'textarea#text-editor',
    // height: 500,
    skin: false,
    content_css: false,
    menubar: false,
    plugins: [
      'preview','searchreplace','visualblocks',
    ],
    toolbar: 'undo redo | casechange blocks | bold italic backcolor | ' +
      'alignleft aligncenter alignright alignjustify | ' +
      'bullist numlist checklist outdent indent | removeformat | a11ycheck code table help',
  });

viz.then(viz => {
    $svgRendition = viz.renderSVGElement(bookSchema)
    $graph.appendChild($svgRendition)
    document.querySelectorAll(".node").forEach((node) => {
        node.addEventListener('click', (e) => {
            console.log(e.target.parentElement.getAttribute('id'))
        })
    })
});
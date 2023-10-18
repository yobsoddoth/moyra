import './bootstrap';

import { instance } from "@viz-js/viz";

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

const viz = instance()
let $graph = document.getElementById('graph')
let $svgRendition;

let $button = document.createElement('BUTTON')
$button.appendChild(document.createTextNode('add to graph'))

$button.addEventListener('click', () => {
    console.log('button clicked')
    graph.nodes.push({ name: "dynamic node", attributes: { label: { html: "<b>Dyn</b>" }, color: "cyan" } })
    graph.edges.push({ tail: "b", head: "dynamic node", attributes: { label: "dynamic link" } })

    viz.then(viz => {
        $svgRendition = viz.renderSVGElement(graph)
        $graph.innerHTML = ""
        $graph.appendChild($svgRendition)
    })
})
document.body.appendChild($button)

viz.then(viz => {
    $svgRendition = viz.renderSVGElement(graph)
    $graph.appendChild($svgRendition)
});
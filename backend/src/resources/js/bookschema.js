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

class Connector {
    #schema
    #fromNode
    #toNode
    #choiceSummary
    #choiceUuid

    constructor(schema) {
        this.#schema = schema
    }

    begin() {
        this.#fromNode = null
        this.#toNode = null
        this.#choiceSummary = null
        this.#choiceUuid = null
        return this
    }

    from(nodeUuid) {
        this.#fromNode = this.#schema.nodes.find((node) => node.attributes.id === nodeUuid)
        return this
    }

    to(nodeUuid) {
        this.#toNode = this.#schema.nodes.find((node) => node.attributes.id === nodeUuid)
        return this
    }

    via(choiceSummary, choiceUuid) {
        this.#choiceSummary = choiceSummary
        this.#choiceUuid = choiceUuid
        return this
    }

    end() {
        let edge = {
            tail: this.#fromNode.name,
            head: this.#toNode.name,
            attributes: {
                label: this.#choiceSummary,
                id: this.#choiceUuid,
                is_fresh: true
            },
        }
        this.#schema.edges.push(edge)
    }
}

export default class BookSchema {
    #schema
    #connector

    constructor(schema) {
        this.#schema = schema
        this.#connector = new Connector(schema)
    }

    makeNode(summary, uuid) {
        let node = {
            name: uuid,
            attributes: {
                label: summary,
                id: uuid,
            },
        }
        this.#schema.nodes.push(node)
    }

    connect() {
        return this.#connector.begin()
    }

    asGraphviz() {
        return this.#schema
    }

    isFreshNode(nodeUuid) {
        return !!this.#schema.nodes.filter((node) => node.name == nodeUuid).attributes?.is_fresh
    }
}
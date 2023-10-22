import { v4 as uuidv4 } from 'uuid'


export default class Choice {
    #uuid
    #episodeUuid
    #cssClass

    #$dom
    #$contentInput
    #$summaryInput
    #$editChoiceEpisodeButton
    #$deleteChoiceButton

    /**
     *
     * @param {string} cssClass
     * @param {uuid} episodeUuid
     * @param {uuid|null} uuid
     */
    constructor(cssClass, episodeUuid, uuid) {
        this.#cssClass = cssClass
        this.#episodeUuid = episodeUuid
        this.#uuid = uuid ?? uuidv4()

        this.#initContentInput()
        this.#initSummaryInput()
        this.#initEditChoiceEpisodeButton()
        this.#initDeleteChoiceButton()

        this.#makeDomNode()
    }

    #initContentInput() {
        this.#$contentInput = document.createElement('DIV')

        let $label = document.createElement('LABEL')
        $label.innerHTML = 'Content:'
        this.#$contentInput.appendChild($label)

        this.#$contentInput.appendChild(document.createElement('INPUT'))
    }

    #initSummaryInput() {
        this.#$summaryInput = document.createElement('DIV')

        let $label = document.createElement('LABEL')
        $label.innerHTML = 'Summary:'
        this.#$summaryInput.appendChild($label)

        this.#$summaryInput.appendChild(document.createElement('INPUT'))
    }

    #initEditChoiceEpisodeButton() {
        this.#$editChoiceEpisodeButton = document.createElement('BUTTON')
        this.#$editChoiceEpisodeButton.innerHTML = 'Make episode for choice'
        this.#$editChoiceEpisodeButton.classList.add('btn', 'btn-sm', 'btn-primary')

        this.#$editChoiceEpisodeButton.addEventListener('click', () => {
            document.dispatchEvent(
                new CustomEvent('moyra:episode-make', {
                    detail: {
                        uuid: this.#uuid,
                        episodeUuid: this.#episodeUuid,
                        towardsEpisodeUuid: uuidv4(),
                        episodeSummary: `Player: ${this.#$summaryInput.querySelector('input').value}`,
                        choiceSummary: this.#$summaryInput.querySelector('input').value
                    }
                })
            )
        })
    }

    #initDeleteChoiceButton() {
        this.#$deleteChoiceButton = document.createElement('BUTTON')
        this.#$deleteChoiceButton.innerHTML = 'Delete choice'
        this.#$deleteChoiceButton.classList.add('btn', 'btn-sm', 'btn-danger')
    }

    #makeDomNode() {
        this.#$dom = document.createElement('DIV')
        this.#$dom.classList.add(this.#cssClass)
        this.#$dom.appendChild(this.#$summaryInput)
        this.#$dom.appendChild(this.#$contentInput)
        this.#$dom.appendChild(this.#$editChoiceEpisodeButton)
        this.#$dom.appendChild(this.#$deleteChoiceButton)
    }

    render() {
        return this.#$dom
    }
}
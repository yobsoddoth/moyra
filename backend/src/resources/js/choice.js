import { v4 as uuidv4 } from 'uuid'


export default class Choice {
    #uuid
    #episodeUuid
    #choiceData
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
     * @param {Object} choiceData
     */
    constructor(cssClass, episodeUuid, choiceData) {
        this.#cssClass = cssClass
        this.#episodeUuid = episodeUuid
        this.#choiceData = choiceData || {}
        this.#uuid = choiceData ? choiceData.id : uuidv4()

        this.#initContentInput()
        this.#initSummaryInput()
        if (!choiceData?.content)
            this.#initEditChoiceEpisodeButton()

        this.#initDeleteChoiceButton()

        this.#makeDomNode()
    }

    #initContentInput() {
        this.#$contentInput = document.createElement('DIV')

        let $label = document.createElement('LABEL')
        $label.innerHTML = 'Content:'
        this.#$contentInput.appendChild($label)

        let $input = document.createElement('INPUT')
        $input.value = this.#choiceData?.content || ""
        $input.classList.add('choice-content-input')
        this.#$contentInput.appendChild($input)
    }

    #initSummaryInput() {
        this.#$summaryInput = document.createElement('DIV')

        let $label = document.createElement('LABEL')
        $label.innerHTML = 'Summary:'
        this.#$summaryInput.appendChild($label)

        let $input = document.createElement('INPUT')
        $input.value = this.#choiceData?.summary || ""
        $input.classList.add('choice-summary-input')
        this.#$summaryInput.appendChild($input)
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
        this.#$editChoiceEpisodeButton && this.#$dom.appendChild(this.#$editChoiceEpisodeButton)
        this.#$dom.appendChild(this.#$deleteChoiceButton)
    }

    render() {
        return this.#$dom
    }
}
import { v4 as uuidv4 } from 'uuid'


export default class Choice {
    #uuid
    #episodeUuid
    #cssClass

    #$dom
    #$input
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

        this.#initInput()
        this.#initEditChoiceEpisodeButton()
        this.#initDeleteChoiceButton()

        this.#makeDomNode()
    }

    #initInput() {
        this.#$input = document.createElement('INPUT')
    }

    #initEditChoiceEpisodeButton() {
        this.#$editChoiceEpisodeButton = document.createElement('BUTTON')
        this.#$editChoiceEpisodeButton.innerHTML = 'Make episode for choice'

        this.#$editChoiceEpisodeButton.addEventListener('click', () => {
            document.dispatchEvent(
                new CustomEvent('moyra:episode-make', {
                    detail: {
                        uuid: this.#uuid,
                        episodeUuid: this.#episodeUuid,
                        towardsEpisodeUuid: uuidv4(),
                    }
                })
            )
        })
    }

    #initDeleteChoiceButton() {
        this.#$deleteChoiceButton = document.createElement('BUTTON')
        this.#$deleteChoiceButton.innerHTML = 'Delete choice'
    }

    #makeDomNode() {
        this.#$dom = document.createElement('DIV')
        this.#$dom.classList.add(this.#cssClass)
        this.#$dom.appendChild(this.#$input)
        this.#$dom.appendChild(this.#$editChoiceEpisodeButton)
        this.#$dom.appendChild(this.#$deleteChoiceButton)
    }

    render() {
        return this.#$dom
    }
}
export default class Choice {
    constructor(cssClass) {
        this.cssClass = cssClass

        this.$dom = document.createElement('DIV')

        this.$input = document.createElement('INPUT')
        this.$editChoiceEpisodeButton = document.createElement('BUTTON')
        this.$editChoiceEpisodeButton.innerHTML = 'Make episode for choice'

        this.$deleteChoiceButton = document.createElement('BUTTON')
        this.$deleteChoiceButton.innerHTML = 'Delete choice'

        this.$dom.classList.add(cssClass)
        this.$dom.appendChild(this.$input)
        this.$dom.appendChild(this.$editChoiceEpisodeButton)
        this.$dom.appendChild(this.$deleteChoiceButton)
    }

    render() {
        return this.$dom
    }
}
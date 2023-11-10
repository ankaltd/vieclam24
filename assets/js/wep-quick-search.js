export default class QuickSearch {
    constructor() {
        this.input = document.querySelector('#wep_quick_search__input');
        this.result = document.querySelector('#wep_quick_search__result');

        this.input.addEventListener('click', () => this.showResult());
        this.input.addEventListener('keyup', (event) => this.handleKeyup(event));
    }

    showResult() {
        const rect = this.input.getBoundingClientRect();
        // console.log('Left: ' + rect.left + ', Top: ' + rect.top);

        this.result.style.left = rect.left + 'px';
        this.result.style.top = (rect.top + 40) + 'px';
        this.result.style.width = rect.width + 'px';

        if (this.result.style.display === 'none') {
            this.result.style.display = 'block';
        }
    }

    handleKeyup(event) {
        if (event.key === 'Escape' || this.input.value.trim() === '') {
            this.result.style.display = 'none';
        } else {
            this.showResult();
        }
    }
}

const input = document.querySelector('#wep_quick_search__input');
const result = document.querySelector('#wep_quick_search__result');

if (input && result) {
    new QuickSearch();
}


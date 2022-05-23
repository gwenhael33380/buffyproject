class Carousel {

    /**
     *
     * @param {HTMLElement} element
     * @param {Object} options
     * @param {Object} option.slidesToScroll Nombre d'éléments à faire défiler
     * @param {Object} option.slidesVisible Nombre d'éléments visible dans un slide
     */

    constructor(element, options = {}) {
      this.element = element
        this.options = Object.assign({}, {
            slidesToScroll: 1,
            slidesVisible : 1
        }, options)
        let root = this.creatDivWithClass('carousel')
        let container = this.creatDivWithClass('carousel__container')
        root.appendChild(container)

        this.element.appendChild(root)
    }

    /**
     *
     * @param (string) className
     * @returns (HTMLElement)
     */
    creatDivWithClass(className) {
        let div = document.createElement('div')
        div.setAttribute('class', 'ClassName')
        return  div
    }
}

document.addEventListener('DOMcontentLoaded', function (){
    new Carousel(document.querySelector('#carousel1'), {
        slidesToScroll: 3,
        slidesVisible: 3
    })
})


import './bootstrap';

const productSelectors = {
    counter: {
        increaseBtn: 'button[data-action="increment"]',
        decreaseBtn: 'button[data-action="decrement"]',
        increaseCart: 'button[data-action="incrementCart"]',
        decreaseCart: 'button[data-action="decrementCart"]',
        input: '.product-count'
    }
}

$(document).ready(function() {
    $(document).on('click', productSelectors.counter.decreaseBtn, function(e) {
        e.preventDefault()

        let value = Number($(productSelectors.counter.input).val())
        value--
        if (value > 0) {
            $(productSelectors.counter.input).val(value)
        }
    })

    $(document).on('click', productSelectors.counter.increaseBtn, function(e) {
        e.preventDefault()
        const max = Number($(productSelectors.counter.input).attr('max'))
        let value = Number($(productSelectors.counter.input).val())
        value++;

        if (value <= max) {
            $(productSelectors.counter.input).val(value)
        }
    })

    $(document).on('click', productSelectors.counter.decreaseCart, function(e) {
        e.preventDefault()

        let value = Number($(productSelectors.counter.input).val())
        value--
        if (value > 0) {
            $(productSelectors.counter.input).val(value)
        }
        $(this.form).submit()
    })

    $(document).on('click', productSelectors.counter.increaseCart, function(e) {
        e.preventDefault()
        const max = Number($(productSelectors.counter.input).attr('max'))
        let value = Number($(productSelectors.counter.input).val())
        value++;

        if (value <= max) {
            $(productSelectors.counter.input).val(value)
        }
        $(this.form).submit()
    })
})

'use strict'

window.$ = window.jQuery
window.Admin = window.Admin || {};

class Admin {

    constructor() {

		$(document).ready(() => this.dom_ready())

	}

	dom_ready() {

        this.init()

	}

    init() {

		this.bind()

    }

	bind() {

		$(document).on('click', 'a[href="#"]', e => { e.preventDefault() })

	}

}

new Admin()

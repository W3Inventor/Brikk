'use strict'

window.$ = window.jQuery

class Mobile {

	constructor() {

		$(document).ready(() => this.ready())

	}

	ready() {

		this.$body = $('body')
		this.$window = $(window)
		this.$nav = $('.brk-mobile-nav')

		this.bind()

	}

	bind() {

		$(`[data-action='toggle-mobile-nav']`).on('click', () => this.toggle_mobile_nav() )
		$('.brk-nav-mobile .menu-item-has-children > a').on('click', e => this.toggle_sub_menu(e) )
		$(`[data-action='toggle-mobile-action']`).on('click', () => this.toggle_mobile_action() )
		$(`[data-action='account-mobile-nav']`).on('change', e => this.account_mobile_nav(e) )

	}

	toggle_mobile_nav() {

		this.$body.toggleClass('brk-do-mobile-nav')

		if( this.$body.hasClass('brk-do-mobile-nav') ) {

			this.$body.css('overflow', 'hidden')

			TweenMax.fromTo(
				this.$nav,
				.4,
				{ visibility: 'hidden', x: '100%' },
				{ visibility: 'visible', x: 0, ease: 'power4.inOut' }
			)

		}else{

			this.$body.css('overflow', 'scroll')

			TweenMax.to(
				this.$nav,
				.4,
				{ x: '100%', ease: 'power4.inOut' }
			)

		}

	}

	toggle_sub_menu( e ) {

		let $e = $( e.currentTarget )
		let $li = $e.parent('li')

		if( ! $li.hasClass('brk--expand') ) {
			e.preventDefault()
		}

		$li.toggleClass('brk--expand')
			.find('> .sub-menu').toggleClass('brk-block')

	}

	toggle_mobile_action() {

		$('.rz-sidebar').toggleClass('rz-mobile-visible')
		this.$body.toggleClass('rz-is-sidebar-mobile-visible')

		window.dispatchEvent( new Event('resize') )

	}

	account_mobile_nav( e ) {

		window.location.href = e.target.value

	}

}

export default new Mobile()

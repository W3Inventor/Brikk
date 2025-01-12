'use strict'

import Lightbox from './lightbox'
import Mobile from './mobile'
import Masonry from 'masonry-layout'

window.$ = window.jQuery
window.Brikk = window.Brikk || {}

class Brikk {

	constructor() {

		$(document).ready(() => this.ready())

	}

	ready() {

		this.$body = $('body')
		this.$w = $(window)

		this.init()
		this.carousel_search()
		this.header()
		this.account_welcome()
		this.author_listing_types()
		this.notifications_sidebar()
		this.notifications_mark_as_read()
		this.gradient()
		this.blog()
		this.explore()
		this.woocommerce()
		this.widgets()
		this.listing_sidebar()
		this.listing_date_selection()

	}

	init() {

		this.bind()

	}

	header() {

		this.header_sticky()

		this.$w.on('scroll', () => {
			this.header_sticky()
		})

	}

	header_sticky() {

		if( this.$w.scrollTop() > 0 ) {
			if( ! this.$body.hasClass('brk-is-sticky') ) {
				this.$body.addClass('brk-is-sticky')
			}
		}else{
			if( this.$body.hasClass('brk-is-sticky') ) {
				this.$body.removeClass('brk-is-sticky')
			}
		}

	}

	carousel_search() {

		let $carousel = $('.brk-carousel-search')
		let $nav = $('.brk-carousel-nav')
		let $li = $( 'li', $nav )

		if( $nav.length ) {
			$li.on('click', e => {

				let $e = $( e.currentTarget )
				let index = $e.attr('data-for')

				$li.removeClass('brk-active')
				$e.addClass('brk-active')

				$('.brk--content', $carousel).removeClass('brk-active')
				$(`.brk--content[data-id='${index}']`, $carousel).addClass('brk-active')

			})
		}

	}

	bind() {

		$(document).on('click', 'a[href="#"]', e => { e.preventDefault() })
		$(document).on('click', `[data-action='browser-back']`, e => {
			// if browser history, use it
			if( window.history.length && document.referrer !== '' ) {
				e.preventDefault()
				window.history.back()
			}
		})

	}

	account_welcome() {

		let $e = $('.brk-account-welcome')

		if( $e.length ) {
			TweenMax.to( $e.parent(), .65, { height: $e.outerHeight(), marginBottom: '.75rem', delay: .25, ease: 'power4.inOut', onComplete: () => {
				$e.parent().css('height', 'auto')
			}})
		}

		$(`.brk-account-welcome [data-action='close']`).on('click', () => {
			TweenMax.to( $e.parent(), 1, { height: 0, marginBottom: 0, ease: 'power4.inOut' } )
		})

	}

	author_listing_types() {

		$(`[data-action='author-listing-types']`).on('change', e => {

			let listing_type_slug = e.currentTarget.value

			const urlParams = new URLSearchParams( window.location.search )

			if( $(`[data-action='author-listing-types'] option`).index( $( e.currentTarget ).find('option:selected') ) == 0 ) {
				urlParams.delete( 'type' )
			}else{
				urlParams.set( 'type', listing_type_slug )
			}

			urlParams.delete( 'onpage' )
			window.location.search = urlParams

		})

	}

	notifications_sidebar() {

		let $sidebar = $('.brk-side')

		$(`[data-action='toggle-side']`).on('click', () => {

			$sidebar.toggleClass('brk-visible')

			// show
			if( $sidebar.hasClass('brk-visible') ) {
				this.$body.addClass('rz-side-visible')
					.css('overflow', 'hidden')
			}
			// hide
			else{
				this.$body.removeClass('rz-side-visible')
					.css('overflow', 'auto')
			}

		})

	}

	notifications_mark_as_read() {

		$(`[data-action='marz-as-read']`).on('click', e => {

			let $e = $(e.currentTarget)
			alert('hello');

			$.ajax({
	            type: 'post',
	            dataType: 'json',
	            url: window.rz_vars.admin_ajax,
	            data: {
	                action: 'rz_notifications_mark_read',
	            },
				beforeSend: () => {

					$('.brk-side .rz--dot').remove()
					$('.brk-side .rz-active').removeClass('rz-active')
					$('.brk-nav-notifications .brk--dot').remove()
					$('.brk-mobile-bar .brk--notif').remove()

					$e.addClass('rz-ajaxing')
					setTimeout(() => {
						$e.removeClass('rz-ajaxing')
					}, 2000 )

				},
				complete: () => {},
				success: ( response ) => {}
	        })

		})

	}


	notifications_clear_all() {

    $(`[data-action='rz-clear-all']`).on('click', e => {
        let $e = $(e.currentTarget);
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: window.rz_vars.admin_ajax,
            data: {
                action: 'rz_notifications_clear_all'
            },
            beforeSend: () => {
                $e.addClass('rz-ajaxing');
                setTimeout(() => {
                    $e.removeClass('rz-ajaxing');
                }, 2000);
            },
            complete: () => {
            	 $e.removeClass("rz-ajaxing");
            },
            success: response => {
                if (response.success) {
                    // On successful deletion, the server-side should send back the updated HTML
                    // Replace the sidebar content with the updated HTML
                    $('.brk--content .rz-scrollbar').html(response.html);
            }
        })
    })
}




	gradient() {

		$(document).on('mousemove', '.rz-button, .brk-bg', e => {
			let rect = e.currentTarget.getBoundingClientRect(),
				x = e.clientX - rect.left,
				y = e.clientY - rect.top

			e.currentTarget.style.setProperty('--x', `${x}px`)
			e.currentTarget.style.setProperty('--y', `${y}px`)
		})

	}

	blog() {

		if( ! $('.brk-msnry').length ) {
			return;
		}

		let msnry = new Masonry('.brk-msnry', {})

	}

	explore() {

		// gtag send page view
		$(document).on('rz-dynamic:done', () => {
			if( typeof window.dataLayer !== 'undefined' ) {
				dataLayer.push({
					'event': 'pageview',
					'virtualUrl': window.location.href
				});
			}
		})

		// explore pagination scroll top
		$(document).on('click', '.brk-explore .rz-paging a', () => {
			this.$w.scrollTop(0)
		})

	}

	woocommerce() {

		$(document).on('click', '.brk-quantity .brk--actions span', e => {

			let $e = $(e.currentTarget);
			let $input = $e.closest('.brk-quantity').find('input')

            if( $e.hasClass('brk--plus') ) {
                $input.get(0).stepUp(1)
            }else{
				$input.get(0).stepDown(1)
            }

			$input.trigger('input')

		})

	}

	widgets() {

		let $archive = $(`.brk-widget select, .variations select`)
		if( $archive.length ) {
			$archive.wrap('<div class="brk-archive-dropdown"></div>')
		}

	}

	listing_sidebar() {

		// aside selector
		let $aside = $('.rz-single-sidebar.rz--sticky')

		if( ! $aside.length ) {
			return;
		}

		const aside = $aside.get(0),
			start_scroll = 57

		let end_scroll = window.innerHeight - aside.offsetHeight - 500,
			curr_pos = window.scrollY,
			screen_height = window.innerHeight,
			aside_height = aside.offsetHeight

		aside.style.top = start_scroll + 'px'

		// check height screen and aside on resize
		window.addEventListener('resize', () => {
		    screen_height = window.innerHeight
		    aside_height = aside.offsetHeight
		})

		document.addEventListener('scroll', () => {

			end_scroll = window.innerHeight - aside.offsetHeight
		    let aside_top = parseInt( aside.style.top.replace('px;', '') )

		    if( aside_height > screen_height ) {

				// scroll up
		        if( window.scrollY < curr_pos ) {
		            if( aside_top < start_scroll ) {
		                aside.style.top = ( aside_top + curr_pos - window.scrollY ) + 'px'
		            }else if( aside_top >= start_scroll && aside_top != start_scroll ) {
		                aside.style.top = start_scroll + 'px'
		            }
		        }
				// scroll down
				else{
		            if( aside_top > end_scroll) {
		                aside.style.top = ( aside_top + curr_pos - window.scrollY ) + 'px'
		            }else if( aside_top < ( end_scroll ) && aside_top != end_scroll ) {
		                aside.style.top = end_scroll + 'px'
		            }
		        }

		    }

		    curr_pos = window.scrollY

		},
		{
		    capture: true,
		    passive: true
		})

	}

	listing_date_selection() {

		let $action = $('.rz-mod-action-booking')
		if( $action.length ) {
			const url = new URLSearchParams( window.location.search )
			const date_start = url.get('date_start')
			const date_end = url.get('date_end')
			const guests = url.get('guests')

			if( guests ) {
				setTimeout(() => {
					$(`.rz-guests [name='guests']`, $action).val( guests )
				}, 50 )
			}

			if( date_start ) {
				setTimeout(() => {
					$(`[data-timestamp='${date_start}']`, $action).trigger('click')
				}, 100 )
			}

			if( date_end ) {
				setTimeout(() => {
					$(`[data-timestamp='${date_end}']`, $action).trigger('click')
				}, 150 )
			}
		}
	}

}

new Brikk()

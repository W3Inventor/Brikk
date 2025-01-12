'use strict'

window.$ = window.jQuery
window.Brikk = window.Brikk || {}

if( window.Routiz ) {

	window.Routiz.modal.requests['lightbox'] = class {

		constructor( modal, params ) {

	        this.$ = modal
	        this.params = params
	        this.$append = $('.rz-modal-image', this.$)

	        modal.addClass('rz-modal-ready')

			this.ajaxing()

			let $image = $(`<img src="${params}">`)

			$image.imagesLoaded(() => {

				this.$append.html( $image )
				this.$.removeClass('rz-ajaxing')

			})

	    }

	    init() {}

	    close() {
			this.$append.html('')
		}

	    ajaxing() {

			if( this.$.hasClass('rz-ajaxing') ) {
	            return
	        }
			this.$.addClass('rz-ajaxing')
	        this.$append.html('')

	    }
	}

	class Lightbox {

		constructor() {

			$(document).ready(() => this.ready())

		}

		ready() {

			this.init()

		}

		init() {

			this.$modal = $('.rz-modal-lightbox')

			$(document).on('click', '.brk--gallery-lighbox .brk--image', e => this.image_click(e) )
			$(document).on('click', `[data-action='expand-gallery']`, e => this.expand_gallery(e) )

			$(document).on('click', '.brk-lightbox', e => this.open(e) )
			$(document).on('click', '.rz-lightbox-nav', e => this.nav(e) )

		}

		image_click(e) {

			let $e = $(e.currentTarget)
			let $cover = $e.closest('.brk--gallery-lighbox')
			let index = $('.brk--image', $cover).index( $e )

			$('.brk-lightbox', $cover).eq( index ).trigger('click')

		}

		expand_gallery(e) {

			$(e.currentTarget).closest('.brk--gallery-lighbox').find('.brk--image:first').trigger('click')

		}

		open(e) {

			let $e = $(e.currentTarget)
			this.$stack = $e.closest('.brk-lightbox-stack')
			this.index = this.$stack.children().index( $e )
			this.is_stack = this.$stack.children().length > 1

			this.$modal[ this.is_stack ? 'addClass' : 'removeClass' ]('brk-is-stack')

			this.$modal.find('.rz--current').html( this.index + 1 )
			this.$modal.find('.rz--total').html( this.$stack.children().length )

			window.Routiz.modal.open( 'lightbox', $e.data('image') )

		}

		nav(e) {

			if( this.$modal.hasClass('rz-ajaxing') ) {
				return;
			}

			let $e = $(e.currentTarget)
			let is_next = $e.attr('data-action') == 'next'

			this.$modal.addClass('rz-ajaxing')

			let next_index = this.index + ( is_next ? 1 : -1 )

			if( next_index < 0 ) {
				next_index = this.$stack.children().length - 1
			}

			if( this.$stack.children().length - 1 < next_index ) {
				next_index = 0
			}

			let next_image_src = this.$stack.children().eq( next_index ).attr('data-image')

			let $image = $(`<img src="${next_image_src}">`)

			$image.imagesLoaded(() => {

				this.index = next_index

				this.$modal.find('.rz--current').html( next_index + 1 )

				$('.rz-modal-image', this.$modal).html( $image )
				this.$modal.removeClass('rz-ajaxing')

			})

		}

	}

	window.Brikk.lightbox = new Lightbox()

}

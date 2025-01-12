'use strict'

export default function serialize( element ) {

    let result = {}

    $.each( element.find('*').serializeArray(), function() {

        result[ this.name ] = this.value

    });

    return result

}

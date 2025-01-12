'use strict'

class cookie {

    constructor() {
        // ..
    }

    check() {

        var cookieEnabled = navigator.cookieEnabled;

        if ( ! cookieEnabled ) {
            document.cookie = 'testcookie';
            cookieEnabled = document.cookie.indexOf('testcookie')!=-1;
        }

        return cookieEnabled;

    }

    set( name, value, days ) {

        var expires = '';

        if ( days ) {
            var date = new Date();
            date.setTime( date.getTime() + ( days * 24 * 60 * 60 * 1000 ) );
            expires = "; expires=" + date.toUTCString();
        }

        var _domain = window.location.hostname;
        _domain = _domain.replace(/^[a-z]{2,3}\./, '');
        if( _domain == 'localhost' ) {
            _domain = '';
        }

        document.cookie = name + "=" + ( value || "" )  + expires + ";" + ( ( _domain == 'localhost' ) ? '' : 'domain=.' + _domain + ';' ) + 'path=/';

    }

    get( name ) {

        var nameEQ = name + "=";
        var ca = document.cookie.split(';');

        for( var i = 0; i < ca.length; i++ ) {
            var c = ca[i];
            while ( c.charAt(0) == ' ' ) c = c.substring( 1, c.length );
            if ( c.indexOf(nameEQ) == 0 ) return c.substring( nameEQ.length, c.length );
        }

        return null;

    }

    erase( name ) {

        document.cookie = name + '=;Max-Age=-99999999;';

    }

}

export default cookie;

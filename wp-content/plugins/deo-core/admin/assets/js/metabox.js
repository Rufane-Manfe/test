(function( $ ) {
    "use strict";

    $('.deo-layout-select-wrapper').each( function() {

        var el = $( this );
        var parent = el;

        el.find( '.deo-layout-select-img' ).on( 'click', function( e ) {
                var input_id = $( this ).closest( 'label' ).attr( 'for' );

                $( this )
                    .parents( ".deo-layout-select-wrapper:first" )
                    .find( '.deo-layout-selected' )
                    .removeClass( 'deo-layout-selected' )
                    .find( "input[type='radio']" )
                    .attr( "checked", false );

                $( this ).closest( 'label' ).find( 'input[type="radio"]' ).prop( 'checked' );

                el.find( 'label[for="' + input_id + '"]' ).addClass( 'deo-layout-selected' ).find( "input[type='radio']" ).attr(
                    "checked", true
                ).trigger('change');
        });
    });

})( jQuery );
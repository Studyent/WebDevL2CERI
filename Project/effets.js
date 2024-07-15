$(document).ready(() => {
    // Survol de la classe '.zoom'
    $(document).on('mouseenter', '.zoom', (event) => {
        $(event.target).animate({ fontSize: '2rem' }, 'fast');
    });

    // Quand la souris quitte la classe '.zoom'
    $(document).on('mouseleave', '.zoom', (event) => {
        $(event.target).animate({ fontSize: '1rem' }, 'fast');
    });

    // Quand la souris quitte la classe '.psd'
    $(document).on('mouseleave', '.psd', (event) => {
        $(event.target).animate({ color: 'black' }, 'fast');
    });
});


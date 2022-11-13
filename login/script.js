$('#email').on('change keyup focus focusout',()=>{
    let val = $('#email').val();
    let rgx = new RegExp(/^[A-Za-z0-9\.-]+@[A-Za-z0-9\.-]+\.[A-Za-z0-9]+$/)
    $('#email').attr('aria-invalid', !rgx.test(val))
})

$('#name').on('change keyup focus focusout',()=>{
    let val = $('#name').val();
    let rgx = new RegExp(/^[A-Za-z]{3,} [A-Za-z]{3,}( [A-Za-z]{3,}|)$/)
    $('#name').attr('aria-invalid', !rgx.test(val))
})

$('#pass').on('change keyup focus focusout',()=>{
    let val = $('#pass').val();
    let rgx = new RegExp(/^.+$/);
    $('#pass').attr('aria-invalid', !rgx.test(val));
})
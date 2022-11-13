var scorePassword = (pass) => {
    var score = 0;
    if (!pass)
        return score;
    // award every unique letter until 5 repetitions
    var letters = new Object();
    for (var i=0; i<pass.length; i++) {
        letters[pass[i]] = (letters[pass[i]] || 0) + 1;
        score += 5.0 / letters[pass[i]];
    }
    // bonus points for mixing it up
    var variations = {
        digits: /\d/.test(pass),
        lower: /[a-z]/.test(pass),
        upper: /[A-Z]/.test(pass),
        nonWords: /\W/.test(pass),
    }
    var variationCount = 0;
    for (var check in variations) {
        variationCount += (variations[check] == true) ? 1 : 0;
    }
    score += (variationCount - 1) * 10;
    return parseInt(score);
}

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
    $('#pass').attr('aria-invalid', !(scorePassword(val)>=60 && val.length >= 8));
})
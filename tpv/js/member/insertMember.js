$(document).ready(function(){
    $('#form').on('submit' , function (e) {
        var login = $('#login').val();
        var pass = $('#clave').val();
        var passRep = $('#claveRep').val();
        
        var mensaje = '';
        
        var valPass = validatePass(pass, passRep);
        if(!valPass){
            mensaje += 'Passwords don´t match ';
        }
        var regPass = regexValidation(/^(?=.*\d).{4,8}$/ , pass);
        if(!regPass){
            mensaje += 'Invalid password ';
        }
        var regLogin = regexValidation(/^[a-z\d_]{4,15}$/i , login);
        if(!regLogin){
            mensaje += 'Invalid username ';
        }
        if(!valPass || !regPass || !regLogin){
            e.preventDefault();
        }
        
        $('#error').empty();
        $('#error').append('<p>' + mensaje + '</p>');
    });
    
    
    function validatePass(pass , passRep){
        var res = false;
        if(pass === passRep){
            res = true;
        }
        return res;
    }
    
    function regexValidation(regex, palabra){
        var res = false;
        if(regex.test(palabra)){
            res = true;
        }
        return res;
    }
});
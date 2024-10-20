//translate login->sign up
const btTransforms=document.querySelectorAll('.link');
const background=document.getElementById('Background_Login');
const divFormSignUp=document.getElementById('sign_up');
const SignUpForm=document.getElementById('SignUpForm');
const loginForm=document.getElementById('loginForm');
let isMoveBackgroundRight=false;
let isMoveFormRight=false;

btTransforms.forEach(btn => {
    btn.addEventListener('click',function(event){
        event.preventDefault();
        if(!background.classList.contains('moving-background') && !divFormSignUp.classList.contains('moving-form')){
            background.classList.add('moving-background');
            divFormSignUp.classList.add('moving-form');
            loginForm.classList.remove('hide');
            SignUpForm.classList.add('hide');
        }
        else{
            if (isMoveBackgroundRight) {
                background.style.animation = "moveLeftBackground 1.5s linear forwards";
            } else {
                background.style.animation = "moveRightBackground 1.5s linear forwards";
            }
            if (isMoveFormRight) {
                divFormSignUp.style.animation = "moveLeftForm 1.5s linear forwards";
                loginForm.classList.remove('hide');
                SignUpForm.classList.add('hide');
            } else {
                divFormSignUp.style.animation = "moveRightForm 1.5s linear forwards";
                loginForm.classList.add('hide');
                SignUpForm.classList.remove('hide');
            }
            isMoveBackgroundRight=!isMoveBackgroundRight;
            isMoveFormRight=!isMoveFormRight;
        }
    })
});
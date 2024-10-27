const btTransforms=document.querySelectorAll('.link');
const background=document.getElementById('Background_Login');
const divFormSignUp=document.getElementById('sign_up');
const SignUpForm=document.getElementById('SignUpForm');
const loginForm=document.getElementById('loginForm');
// Checkbox
const agreeDocumentCB=document.getElementById('agreeDocumentCB');
//Btn
const CreateAccountBtn=document.getElementById('CreateAccountBtn');
const LoginAccount=document.getElementById('LoginAccount');
// Field Sign Up
const email_Sign=document.getElementById('email_Sign');
const username_Sign=document.getElementById('username_Sign');
const password_Sign=document.getElementById('password_Sign');
// Field Log In
const email_Login=document.getElementById('email_Login');
const password_Login=document.getElementById('password_Login');

// boolean
let isMoveBackgroundRight=false;
let isMoveFormRight=false;
let validEmail=false;
let validUsername=false;
let validPassword=false;

//translate login->sign up

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
// check exist email?
function checkEmailSignUp(email) {
    // Gửi yêu cầu fetch tới route kiểm tra email
    fetch('/check-email', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Lấy CSRF token từ meta
        },
        body: JSON.stringify({
            email: email
        })
    })
    .then(response => response.json()) // Chuyển đổi phản hồi thành JSON
    .then(data => {
        // Kiểm tra kết quả trả về từ server
        if (data.exists) {
            // Nếu email đã tồn tại, hiển thị thông báo lỗi
            document.getElementById('emailError').innerText = 'Email đã tồn tại';
            document.getElementById('emailError').style.display = 'block';
            validEmail = false;
        } else {
            isdisabledBtnCreate(false);
            // Nếu email hợp lệ, ẩn thông báo lỗi
            document.getElementById('emailError').style.display = 'none';
            validEmail = true;
        }
    })
    .catch(error => {
        isdisabledBtnCreate(false);
        console.log('Lỗi khi kiểm tra email:', error); // Log lỗi nếu có
    });
}
//login 
function checkEmailLogin (email,password) {
        return fetch("/check-account", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content') // CSRF token từ thẻ meta
            },
            body: JSON.stringify({
                email: email,
                password: password
            })
        })
        .then(response => response.json()) // Parse kết quả trả về dưới dạng JSON
        .then(data => {
            if (data.valid) {
                return true; // Tài khoản hợp lệ
            } else {
                isdisabledBtnLogin(false);
                return false; // Tài khoản không hợp lệ
            }
        })
        .catch(error => {
            isdisabledBtnLogin(false);
            console.log("Error:", error.message); // Log lỗi nếu có
            return false;
        });
    
}

//check input right
email_Sign.addEventListener('input',function(){
    isdisabledBtnCreate(false);

    // Lấy giá trị của input
    const emailValue = this.value;

    // Pattern kiểm tra email
    const emailPattern =/^[a-z0-9._%+-]+@[a-z0-9.-]+\.(com)$/i;
    ;

    // Kiểm tra xem giá trị nhập có khớp với pattern không
    if (emailPattern.test(emailValue)) {
        validEmail = true; // Nếu đúng, đặt validEmail là true
        document.getElementById('emailError').style.display = 'none'; // Ẩn thông báo lỗi
    } else {
        validEmail = false; // Nếu sai, đặt validEmail là false
        document.getElementById('emailError').style.display = 'block'; // Hiển thị thông báo lỗi
    }
})
username_Sign.addEventListener('input',function(){
    isdisabledBtnCreate(false);
    const usernameValue=this.value;
    if(usernameValue.length>=2){
        validUsername=true;
        document.getElementById('usernameError').style.display='none';
    }
    else{
        validUsername=false;
        document.getElementById('usernameError').style.display='block';
    }
})
password_Sign.addEventListener('input',function(){
        isdisabledBtnCreate(false);
        // Lấy giá trị của input
        const passwordValue = this.value;
    
        // Kiểm tra xem giá trị nhập có khớp với pattern không
        if (passwordValue.length >= 6) {
            validPassword = true; // Nếu đúng, đặt validPassword là true
            document.getElementById('passwordError').style.display = 'none'; // Ẩn thông báo lỗi
        } else {
            validPassword = false; // Nếu sai, đặt validPassword là false
            document.getElementById('passwordError').style.display = 'block'; // Hiển thị thông báo lỗi
        }
})
function isdisabledBtnCreate(status){
    CreateAccountBtn.disabled=status;

}
function isdisabledBtnLogin(status){
    LoginAccount.disabled=status;

}
// show Message
CreateAccountBtn.addEventListener('click',function(event){
    
    if(!agreeDocumentCB.checked){
        showErrorToast();
        event.preventDefault();
    }
    else if(agreeDocumentCB.checked && validEmail && validPassword && validUsername){
        isdisabledBtnCreate(true);
        checkEmailSignUp(email_Sign.value);
        if(validEmail){
            showSuccessToast();
        }
        else{
            event.preventDefault();
            toast({
                title: "Information",
                message: "Email này đã tồn tại , vui lòng kiểm tra lại",
                type: "error",
                duration: 5000
              });
        }
    }
    else{
        event.preventDefault();
        toast({
            title: "Information",
            message: "Bạn điền thiếu thông tin hoặc thông tin không hợp lệ.Vui lòng xem lại",
            type: "error",
            duration: 5000
          });
    }
});
//Login Account
LoginAccount.addEventListener('click',function(event){
    console.log("có click");
    const email = email_Login.value;
    const password = password_Login.value;
    if(checkEmailLogin(email,password)){
        isdisabledBtnLogin(true);
        toast({
            title: "Information",
            message: "Đang đăng nhập",
            type: "success",
            duration: 5000
          });
    }
    else{
        isdisabledBtnLogin(false);
        event.preventDefault();
        toast({
            title: "Information",
            message: "Nhập sai Email hoặc password",
            type: "error",
            duration: 5000
          });
    }
})
//toast
function showSuccessToast() {
    toast({
      title: "Thành công!",
      message: "Bạn đã đăng ký thành công",
      type: "success",
      duration: 5000
    });
  }

  function showErrorToast() {
    toast({
      title: "Thất bại!",
      message: "Vui lòng đồng ý các điều khoản trước khi tạo tài khoản.",
      type: "error",
      duration: 5000
    });
  }
  function toast({ title = "", message = "", type = "info", duration = 3000 }) {
    const main = document.getElementById("toast");
    
    if (main) {
      const toast = document.createElement("div");
  
      // Auto remove toast
      const autoRemoveId = setTimeout(function () {
        main.removeChild(toast);
      }, duration + 1000);
  
      // Remove toast when clicked
      toast.onclick = function (e) {
        if (e.target.closest(".toast__close")) {
          main.removeChild(toast);
          clearTimeout(autoRemoveId);
        }
      };
  
      const icons = {
        success: "fas fa-check-circle",
        info: "fas fa-info-circle",
        warning: "fas fa-exclamation-circle",
        error: "fas fa-exclamation-circle"
      };
      const icon = icons[type];
      const delay = (duration / 1000).toFixed(2);
  
      toast.classList.add("toast", `toast--${type}`);
      toast.style.animation = `slideInLeft ease .3s, fadeOut linear 1s ${delay}s forwards`;
  
      toast.innerHTML = `
                      <div class="toast__icon">
                          <i class="${icon}"></i>
                      </div>
                      <div class="toast__body">
                          <h3 class="toast__title">${title}</h3>
                          <p class="toast__msg">${message}</p>
                      </div>
                      <div class="toast__close">
                          <i class="fas fa-times"></i>
                      </div>
                  `;
      main.appendChild(toast);
    }
  }
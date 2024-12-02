<div class="accountLogin">
@if($isAuthenticated)
        <a href={{ route('user.index') }} id="login" class=" border rounded-circle p-2 me-lg-2 me-2 bg-white btn " style="width:40px ;height:40px">
        <i class="fa-solid fa-user" style="font-size: 20px"></i>
        </a>
@else
        <a href={{ route('account.index') }} id="login" class=" border rounded-circle p-2 me-lg-2 me-2 bg-white btn " style="width:40px ;height:40px">
        <i class="fa-solid fa-user" style="font-size: 20px"></i>
        </a>
@endif
</div>

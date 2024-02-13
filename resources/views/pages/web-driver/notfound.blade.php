<style>
    h1 {text-align:center; padding: 20px 10px; text-transform: uppercase; font-weight: 400; }
    .form_success { background: #fff; color: #31455A; width: 40%; text-align: center; border-radius: .5em; padding: 30px 15px; box-shadow: 2px 0 5px -1px rgba(0,0,0,.30); }
</style>

<div class="divCenter" style="display: flex; flex-flow: row nowrap; justify-content: center">
    <div class="form_success">
        <h1>Not Found 404 Error!</h1>
        <p style="margin-bottom: 30px;">Sorry, The page you searcing, that is not found. Please Login again with correct data.</p>
        <a class="btn btn-danger" href="{{ Request::segment(2) == "rider" ? url('web/rider/logout') : url('web/driver/logout') }}">Go to Login Page</a>
    </div>
</div>
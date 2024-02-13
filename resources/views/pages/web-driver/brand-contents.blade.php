<div class="brand animated fadeInRight">
    <div class="brand-content">
        <img src="{{ asset('login-assets/images/login-logo.png') }}" alt="" class="login-logo" />
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Animi assumenda at consequatur, cum dignissimos ea eaque facilis fugit nostrum obcaecati perferendis possimus quam qui, quod repellat sint soluta, sunt tempora!</p>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Animi assumenda at consequatur, cum dignissimos ea eaque facilis fugit nostrum obcaecati perferendis possimus quam qui, quod repellat sint soluta, sunt tempora!</p>
    </div>

    <div class="app-link">
        <p>Get the latest Rider App for your phone</p>
        <ul>
            @if(Request::segment(2) == "rider")
            <li><a href="https://apps.apple.com/us/app/esojai/id1301252711" target="_blank"><img width="246" height="79" src="https://pathao.com/wp-content/uploads/2019/03/App-Store-footer-.png" title="App-Store-footer-"></a></li>
            <li><a href="https://play.google.com/store/apps/details?id=com.esojai.userapps" target="_blank"><img width="248" height="79" src="https://pathao.com/wp-content/uploads/2019/03/Google-Play-footer-.png" title="Google-Play-footer-"></a></li>
            @else
            <li><a href="https://apps.apple.com/us/app/esojai/id1301252711" target="_blank"><img width="246" height="79" src="https://pathao.com/wp-content/uploads/2019/03/App-Store-footer-.png" title="App-Store-footer-"></a></li>
            <li><a href="https://play.google.com/store/apps/details?id=com.esojai.driver" target="_blank"><img width="248" height="79" src="https://pathao.com/wp-content/uploads/2019/03/Google-Play-footer-.png" title="Google-Play-footer-"></a></li>
            @endif
        </ul>
    </div>
</div>

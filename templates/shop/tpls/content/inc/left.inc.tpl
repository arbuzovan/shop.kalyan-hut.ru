<div id="sidebar">
    <div class="search">
        <ul>
            <li>Поиск товара</li>
        </ul>
        %search insert_form('cust_search')%
    </div>
    <div>
        <ul>
            <li>
                %catalog getPriceLink(%pid%)%
            </li>
        </ul>
    </div>
    <div class="cats">
        %content cacheMenu('category_menu', '2', '253', %pid%)%
    </div>
    
    <div class="social" style="text-align: center">
        <div class="h1text">Присоединяйтесь</div>
        <a href="//instagram.com/kalyan_hut/" target="_blank" style="font-size: 16px; line-height: 20px; text-decoration: none">
            <img src="/templates/shop/images/icons/instagram.png" />
        </a>
    </div>
    <div class="counterWrapper">
        %content ordersCount()%
    </div>
    <br />
    <div class="market">
        <div class="h1text">Подарок за подписку!</div>
        <a rel="nofollow" href="/dispatches_gift/"><img alt="Оценка интернет магазина" src="/images/market.png"></a>
    </div>
    <script src="https://app.sendsay.ru/kit/sendsayForms/sendsayforms.min.js"></script><script  type="text/javascript">SENDSAY.activatePopup("https://sendsay.ru/form/x_1494868933301352/3/");</script>
    %content showDopMenu(%pid%)%
    
</div>
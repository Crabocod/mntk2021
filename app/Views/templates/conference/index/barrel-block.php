<div class="col-4" id="barrel-block">
    <div class="index-banner">
        <h2>Добавь позитивных
            «баррелей»,</h2>
        <p>если тебе понравился день <br>на конференции!</p>
        <div class="index-banner__imgs -flex -justify-btw">
            <div class="kachalka-content">
                <div class="kachalka <?=(@$thisUserClicked) ? 'active' : '';?>"></div>
<!--                <p>Lorem Ipsum - это текст-"рыба", часто используемый в печати и вэб-дизайне.</p>-->
            </div>
            <!-- <img class="kachalka" src="/img/kachalka.svg" alt=""> -->
            <div class="barrel-content">
                <img class="barrel" width="141px" height="245" src="/img/barell.svg" alt="">
                <span class="barrel-neft" style="height:calc(<?=@$percent;?>% - 25px)"></span>
            </div>
        </div>
    </div>
</div>
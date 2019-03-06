<div style="padding: 100px;">
    <div>
        <h2>Минификация ссылки</h2>
        <form action="/minimized-url" method="post">
            <p>
                <input type="url" style="width: 375px;" placeholder="Вставте ссылку" required name="MinimizedUrl[original_link]"/>
            </p>

            <p>
                <input id="datetime" type="datetime-local" name="MinimizedUrl[life_time]" value="<?= $defaultLifeTime ?>"/>
            </p>

            <p><input type="submit" value="Минифицировать"/></p>
        </form>

        <?php if($minimizedLink): ?>
            <p><?= $minimizedLink ?></p>
        <?php endif; ?>

        <?php if($errors): ?>

            <p>ВНИМАНИЕ:</p>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li style="color: rgba(143,0,0,0.78);"><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>


    <div style="padding-top: 50px;">
        <h3><a href="/minimized-url/statistics-following">Статистика переходов по ссылкам</a></h3>
    </div>
</div>

<p style="font-size: 0.55em;
    padding: 20px;">version: 0.91</p>
